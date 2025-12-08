#!/bin/bash

echo "=== MySQL Password Fix & Database Setup ==="
echo ""

# Try to connect with the password
echo "Testing MySQL connection..."
MYSQL_PASSWORD="Newpassd12@"

# Test connection
/usr/local/mysql/bin/mysql -u root -p"$MYSQL_PASSWORD" -e "SELECT 1;" 2>&1 > /dev/null

if [ $? -eq 0 ]; then
    echo "✓ Password is correct! MySQL connection successful."
    echo ""
    
    # Create database
    echo "Creating 'fisheries' database..."
    /usr/local/mysql/bin/mysql -u root -p"$MYSQL_PASSWORD" << SQL
CREATE DATABASE IF NOT EXISTS fisheries CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON fisheries.* TO 'root'@'localhost';
FLUSH PRIVILEGES;
SELECT 'Database created successfully!' AS Status;
SQL

    if [ $? -eq 0 ]; then
        echo "✓ Database 'fisheries' created successfully!"
        echo ""
        
        # Update .env file
        echo "Updating .env file..."
        if [ -f .env ]; then
            # Backup
            cp .env .env.backup.$(date +%Y%m%d_%H%M%S)
            
            # Update settings - escape special characters in password
            sed -i.bak 's/^DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env
            grep -q "^DB_HOST=" .env && sed -i.bak 's/^DB_HOST=.*/DB_HOST=127.0.0.1/' .env || echo "DB_HOST=127.0.0.1" >> .env
            grep -q "^DB_PORT=" .env && sed -i.bak 's/^DB_PORT=.*/DB_PORT=3306/' .env || echo "DB_PORT=3306" >> .env
            grep -q "^DB_DATABASE=" .env && sed -i.bak 's/^DB_DATABASE=.*/DB_DATABASE=fisheries/' .env || echo "DB_DATABASE=fisheries" >> .env
            grep -q "^DB_USERNAME=" .env && sed -i.bak 's/^DB_USERNAME=.*/DB_USERNAME=root/' .env || echo "DB_USERNAME=root" >> .env
            
            # Update password - need to escape special characters
            ESCAPED_PASSWORD=$(echo "$MYSQL_PASSWORD" | sed 's/[@$]/\\&/g')
            if grep -q "^DB_PASSWORD=" .env; then
                sed -i.bak "s|^DB_PASSWORD=.*|DB_PASSWORD=$MYSQL_PASSWORD|" .env
            else
                echo "DB_PASSWORD=$MYSQL_PASSWORD" >> .env
            fi
            
            rm .env.bak 2>/dev/null
            echo "✓ .env file updated with MySQL configuration!"
        fi
        
        echo ""
        echo "=== Setup Complete! ==="
        echo ""
        echo "Next steps:"
        echo "1. Run migrations: php artisan migrate"
        echo "2. Seed database: php artisan db:seed"
        echo ""
        echo "Your MySQL credentials:"
        echo "  Database: fisheries"
        echo "  Username: root"
        echo "  Password: Newpassd12@"
        echo ""
        echo "To access MySQL:"
        echo "  /usr/local/mysql/bin/mysql -u root -p"
        echo "  (Enter password: Newpassd12@)"
        
    else
        echo "✗ Error creating database."
    fi
    
else
    echo "✗ Password is incorrect or access denied."
    echo ""
    echo "Let's try to reset the MySQL root password..."
    echo ""
    echo "Option 1: Try connecting interactively"
    echo "  /usr/local/mysql/bin/mysql -u root -p"
    echo "  (Then enter your password when prompted)"
    echo ""
    echo "Option 2: Reset MySQL root password"
    echo "  See FIND_MYSQL.md for instructions"
    echo ""
    echo "Option 3: Create a new MySQL user"
    read -p "Would you like to create a new MySQL user? (y/n): " create_user
    if [ "$create_user" = "y" ]; then
        read -p "Enter new username: " new_user
        read -sp "Enter new password: " new_pass
        echo ""
        
        # Try to connect without password first (if possible)
        /usr/local/mysql/bin/mysql -u root << SQL 2>/dev/null
CREATE USER IF NOT EXISTS '$new_user'@'localhost' IDENTIFIED BY '$new_pass';
GRANT ALL PRIVILEGES ON *.* TO '$new_user'@'localhost';
FLUSH PRIVILEGES;
CREATE DATABASE IF NOT EXISTS fisheries CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON fisheries.* TO '$new_user'@'localhost';
FLUSH PRIVILEGES;
SQL
        
        if [ $? -eq 0 ]; then
            echo "✓ New user created and database setup complete!"
            echo "Update .env with:"
            echo "  DB_USERNAME=$new_user"
            echo "  DB_PASSWORD=$new_pass"
        else
            echo "✗ Could not create user. You may need root access."
        fi
    fi
fi


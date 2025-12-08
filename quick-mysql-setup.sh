#!/bin/bash

echo "=== Quick MySQL Database Setup ==="
echo ""
echo "MySQL Location: /usr/local/mysql"
echo ""

# Prompt for MySQL root password
read -sp "Enter MySQL root password: " MYSQL_PASSWORD
echo ""

# Create database
echo "Creating 'fisheries' database..."
/usr/local/mysql/bin/mysql -u root -p"$MYSQL_PASSWORD" << SQL
CREATE DATABASE IF NOT EXISTS fisheries CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON fisheries.* TO 'root'@'localhost';
FLUSH PRIVILEGES;
SQL

if [ $? -eq 0 ]; then
    echo "✓ Database created successfully!"
    echo ""
    
    # Update .env file
    echo "Updating .env file..."
    if [ -f .env ]; then
        # Backup
        cp .env .env.backup.$(date +%Y%m%d_%H%M%S)
        
        # Update settings
        sed -i.bak 's/^DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env
        grep -q "^DB_HOST=" .env && sed -i.bak 's/^DB_HOST=.*/DB_HOST=127.0.0.1/' .env || echo "DB_HOST=127.0.0.1" >> .env
        grep -q "^DB_PORT=" .env && sed -i.bak 's/^DB_PORT=.*/DB_PORT=3306/' .env || echo "DB_PORT=3306" >> .env
        grep -q "^DB_DATABASE=" .env && sed -i.bak 's/^DB_DATABASE=.*/DB_DATABASE=fisheries/' .env || echo "DB_DATABASE=fisheries" >> .env
        grep -q "^DB_USERNAME=" .env && sed -i.bak 's/^DB_USERNAME=.*/DB_USERNAME=root/' .env || echo "DB_USERNAME=root" >> .env
        grep -q "^DB_PASSWORD=" .env && sed -i.bak "s|^DB_PASSWORD=.*|DB_PASSWORD=$MYSQL_PASSWORD|" .env || echo "DB_PASSWORD=$MYSQL_PASSWORD" >> .env
        
        rm .env.bak 2>/dev/null
        echo "✓ .env file updated!"
    fi
    
    echo ""
    echo "=== Next Steps ==="
    echo "1. Run migrations: php artisan migrate"
    echo "2. Seed database: php artisan db:seed"
    echo "3. View database: /usr/local/mysql/bin/mysql -u root -p fisheries"
    echo ""
    echo "Or use the web viewer: http://localhost:8000/view-database.php"
    
else
    echo "✗ Error: Could not create database."
    echo "Please check your MySQL root password."
    echo ""
    echo "To reset password, see FIND_MYSQL.md"
fi


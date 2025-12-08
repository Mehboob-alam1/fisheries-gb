#!/bin/bash

echo "=== Setting up MySQL Database for Fisheries Management System ==="
echo ""

# Check if MySQL is running
if ! mysqladmin ping -h localhost --silent 2>/dev/null; then
    echo "MySQL server is not running. Attempting to start..."
    
    # Try different methods to start MySQL
    if command -v brew &> /dev/null; then
        echo "Starting MySQL via Homebrew..."
        brew services start mysql
        sleep 3
    elif [ -f /usr/local/mysql/support-files/mysql.server ]; then
        echo "Starting MySQL server..."
        sudo /usr/local/mysql/support-files/mysql.server start
        sleep 3
    else
        echo "Please start MySQL manually and run this script again."
        echo "Or use: mysql.server start"
        exit 1
    fi
fi

# Check if MySQL is now running
if mysqladmin ping -h localhost --silent 2>/dev/null; then
    echo "✓ MySQL server is running!"
    echo ""
    
    # Create database
    echo "Creating database 'fisheries'..."
    mysql -u root << SQL
CREATE DATABASE IF NOT EXISTS fisheries CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON fisheries.* TO 'root'@'localhost';
FLUSH PRIVILEGES;
SQL

    if [ $? -eq 0 ]; then
        echo "✓ Database 'fisheries' created successfully!"
        echo ""
        echo "Updating .env file..."
        
        # Update .env file
        if [ -f .env ]; then
            # Backup .env
            cp .env .env.backup
            
            # Update DB settings
            sed -i.bak 's/^DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env
            sed -i.bak 's/^DB_HOST=.*/DB_HOST=127.0.0.1/' .env || echo "DB_HOST=127.0.0.1" >> .env
            sed -i.bak 's/^DB_PORT=.*/DB_PORT=3306/' .env || echo "DB_PORT=3306" >> .env
            sed -i.bak 's/^DB_DATABASE=.*/DB_DATABASE=fisheries/' .env || echo "DB_DATABASE=fisheries" >> .env
            sed -i.bak 's/^DB_USERNAME=.*/DB_USERNAME=root/' .env || echo "DB_USERNAME=root" >> .env
            sed -i.bak 's/^DB_PASSWORD=.*/DB_PASSWORD=/' .env || echo "DB_PASSWORD=" >> .env
            
            rm .env.bak 2>/dev/null
            echo "✓ .env file updated!"
        fi
        
        echo ""
        echo "=== Next Steps ==="
        echo "1. Run migrations: php artisan migrate"
        echo "2. Seed database: php artisan db:seed"
        echo "3. View database: mysql -u root fisheries"
        echo ""
        echo "Or use a GUI tool like:"
        echo "- DB Browser for SQLite (works with MySQL too)"
        echo "- TablePlus"
        echo "- phpMyAdmin"
        echo "- MySQL Workbench"
        
    else
        echo "✗ Error creating database. You may need to enter MySQL root password."
        echo "Run manually: mysql -u root -p"
        echo "Then: CREATE DATABASE fisheries;"
    fi
else
    echo "✗ Could not connect to MySQL server."
    echo "Please start MySQL manually:"
    echo "  - brew services start mysql (if using Homebrew)"
    echo "  - mysql.server start"
    echo "  - Or start MySQL from System Preferences"
fi


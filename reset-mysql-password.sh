#!/bin/bash

echo "=== MySQL Root Password Reset ==="
echo ""
echo "This script will help you reset MySQL root password."
echo ""

# Stop MySQL
echo "Step 1: Stopping MySQL server..."
sudo /usr/local/mysql/support-files/mysql.server stop

if [ $? -ne 0 ]; then
    echo "⚠️  Could not stop MySQL. Trying alternative method..."
    sudo killall mysqld 2>/dev/null
    sleep 2
fi

# Start MySQL in safe mode
echo "Step 2: Starting MySQL in safe mode (skip grant tables)..."
sudo /usr/local/mysql/bin/mysqld_safe --skip-grant-tables --skip-networking > /dev/null 2>&1 &
sleep 5

# Connect and reset password
echo "Step 3: Resetting root password..."
/usr/local/mysql/bin/mysql -u root << SQL
FLUSH PRIVILEGES;
ALTER USER 'root'@'localhost' IDENTIFIED BY 'Newpassd12@';
FLUSH PRIVILEGES;
EXIT;
SQL

if [ $? -eq 0 ]; then
    echo "✓ Password reset successful!"
    
    # Stop safe mode MySQL
    echo "Step 4: Stopping safe mode MySQL..."
    sudo killall mysqld_safe 2>/dev/null
    sudo killall mysqld 2>/dev/null
    sleep 2
    
    # Start MySQL normally
    echo "Step 5: Starting MySQL normally..."
    sudo /usr/local/mysql/support-files/mysql.server start
    
    sleep 3
    
    # Test connection
    echo "Step 6: Testing new password..."
    /usr/local/mysql/bin/mysql -u root -p'Newpassd12@' -e "SELECT 'Connection successful!' AS Status;" 2>&1 | grep -v "Warning"
    
    if [ $? -eq 0 ]; then
        echo ""
        echo "=== SUCCESS! ==="
        echo "MySQL root password has been reset to: Newpassd12@"
        echo ""
        echo "Now creating 'fisheries' database..."
        
        /usr/local/mysql/bin/mysql -u root -p'Newpassd12@' << SQL
CREATE DATABASE IF NOT EXISTS fisheries CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON fisheries.* TO 'root'@'localhost';
FLUSH PRIVILEGES;
SELECT 'Database created!' AS Status;
SQL
        
        echo ""
        echo "=== Database Setup Complete! ==="
        echo ""
        echo "Updating .env file..."
        
        # Update .env
        if [ -f .env ]; then
            cp .env .env.backup.$(date +%Y%m%d_%H%M%S)
            sed -i.bak 's/^DB_CONNECTION=.*/DB_CONNECTION=mysql/' .env
            grep -q "^DB_HOST=" .env && sed -i.bak 's/^DB_HOST=.*/DB_HOST=127.0.0.1/' .env || echo "DB_HOST=127.0.0.1" >> .env
            grep -q "^DB_PORT=" .env && sed -i.bak 's/^DB_PORT=.*/DB_PORT=3306/' .env || echo "DB_PORT=3306" >> .env
            grep -q "^DB_DATABASE=" .env && sed -i.bak 's/^DB_DATABASE=.*/DB_DATABASE=fisheries/' .env || echo "DB_DATABASE=fisheries" >> .env
            grep -q "^DB_USERNAME=" .env && sed -i.bak 's/^DB_USERNAME=.*/DB_USERNAME=root/' .env || echo "DB_USERNAME=root" >> .env
            grep -q "^DB_PASSWORD=" .env && sed -i.bak "s|^DB_PASSWORD=.*|DB_PASSWORD=Newpassd12@|" .env || echo "DB_PASSWORD=Newpassd12@" >> .env
            rm .env.bak 2>/dev/null
            echo "✓ .env file updated!"
        fi
        
        echo ""
        echo "=== Next Steps ==="
        echo "1. Run: php artisan migrate"
        echo "2. Run: php artisan db:seed"
        echo ""
        echo "Your MySQL credentials:"
        echo "  Username: root"
        echo "  Password: Newpassd12@"
        echo "  Database: fisheries"
        
    else
        echo "⚠️  Password reset but connection test failed."
        echo "You may need to try connecting manually."
    fi
else
    echo "✗ Error resetting password."
    echo "You may need to run this with sudo privileges."
fi


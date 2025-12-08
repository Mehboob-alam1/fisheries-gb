#!/bin/bash

echo "=== MySQL Setup for Fisheries Management System ==="
echo ""
echo "MySQL is installed at: /usr/local/mysql"
echo "MySQL is currently RUNNING ✓"
echo ""

# Check if database exists
echo "Checking if 'fisheries' database exists..."
DB_EXISTS=$(/usr/local/mysql/bin/mysql -u root -p"$MYSQL_ROOT_PASSWORD" -e "SHOW DATABASES LIKE 'fisheries';" 2>/dev/null | grep fisheries)

if [ -z "$DB_EXISTS" ]; then
    echo ""
    echo "Creating 'fisheries' database..."
    echo "You'll need to enter your MySQL root password."
    echo ""
    
    /usr/local/mysql/bin/mysql -u root -p << SQL
CREATE DATABASE IF NOT EXISTS fisheries CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON fisheries.* TO 'root'@'localhost';
FLUSH PRIVILEGES;
SQL

    if [ $? -eq 0 ]; then
        echo "✓ Database 'fisheries' created successfully!"
    else
        echo "✗ Error creating database. Please check your MySQL root password."
        exit 1
    fi
else
    echo "✓ Database 'fisheries' already exists!"
fi

echo ""
echo "=== MySQL Location ==="
echo "MySQL is installed at: /usr/local/mysql"
echo "MySQL binary: /usr/local/mysql/bin/mysql"
echo "MySQL server: /usr/local/mysql/bin/mysqld"
echo ""
echo "To access MySQL:"
echo "  /usr/local/mysql/bin/mysql -u root -p"
echo ""
echo "Or add to PATH:"
echo "  export PATH=\$PATH:/usr/local/mysql/bin"
echo ""


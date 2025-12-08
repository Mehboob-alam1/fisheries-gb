#!/bin/bash

echo "=== MySQL Database Setup for Fisheries Management System ==="
echo ""

# Check if MySQL is installed
if ! command -v mysql &> /dev/null; then
    echo "MySQL is not installed. Please install MySQL first."
    echo "macOS: brew install mysql"
    echo "Linux: sudo apt install mysql-server"
    exit 1
fi

echo "MySQL is installed."
echo ""
read -p "Enter MySQL root password: " -s root_password
echo ""

read -p "Enter database name (default: fisheries): " db_name
db_name=${db_name:-fisheries}

read -p "Enter database username (default: fisheries_user): " db_user
db_user=${db_user:-fisheries_user}

read -p "Enter database password: " -s db_password
echo ""

echo ""
echo "Creating database and user..."

mysql -u root -p"$root_password" << SQL
CREATE DATABASE IF NOT EXISTS ${db_name} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '${db_user}'@'localhost' IDENTIFIED BY '${db_password}';
GRANT ALL PRIVILEGES ON ${db_name}.* TO '${db_user}'@'localhost';
FLUSH PRIVILEGES;
SQL

if [ $? -eq 0 ]; then
    echo "✓ Database and user created successfully!"
    echo ""
    echo "Update your .env file with:"
    echo "DB_CONNECTION=mysql"
    echo "DB_HOST=127.0.0.1"
    echo "DB_PORT=3306"
    echo "DB_DATABASE=${db_name}"
    echo "DB_USERNAME=${db_user}"
    echo "DB_PASSWORD=${db_password}"
    echo ""
    echo "Then run: php artisan migrate && php artisan db:seed"
else
    echo "✗ Error creating database. Please check your MySQL credentials."
fi

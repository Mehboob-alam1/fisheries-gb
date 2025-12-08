#!/bin/bash

echo "=== Simple MySQL Setup (Interactive) ==="
echo ""
echo "Let's try connecting to MySQL interactively..."
echo ""

# Try to connect without password first
echo "Attempting to connect without password..."
/usr/local/mysql/bin/mysql -u root << SQL 2>/dev/null
SELECT 'Connected without password!' AS Status;
CREATE DATABASE IF NOT EXISTS fisheries CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
SELECT 'Database created!' AS Status;
EXIT;
SQL

if [ $? -eq 0 ]; then
    echo "✓ Successfully connected without password!"
    echo "✓ Database 'fisheries' created!"
    echo ""
    echo "Setting password to: Newpassd12@"
    
    /usr/local/mysql/bin/mysql -u root << SQL
ALTER USER 'root'@'localhost' IDENTIFIED BY 'Newpassd12@';
FLUSH PRIVILEGES;
EXIT;
SQL
    
    echo "✓ Password set!"
    
else
    echo "Could not connect without password."
    echo ""
    echo "Please try one of these options:"
    echo ""
    echo "Option 1: Connect manually and enter password"
    echo "  /usr/local/mysql/bin/mysql -u root -p"
    echo "  Then run: CREATE DATABASE fisheries;"
    echo ""
    echo "Option 2: Reset password (requires sudo)"
    echo "  sudo ./reset-mysql-password.sh"
    echo ""
    echo "Option 3: Use SQLite instead (current setup)"
    echo "  Your app is already working with SQLite!"
    echo "  View database at: http://localhost:8000/view-database.php"
fi


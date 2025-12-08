# How to Start MySQL and View Database

## Quick Start MySQL

### Option 1: Start MySQL Server (if installed via installer)

1. Open **System Preferences** (macOS)
2. Go to **MySQL**
3. Click **Start MySQL Server**

OR use command line:
```bash
sudo /usr/local/mysql/support-files/mysql.server start
```

### Option 2: Install and Start MySQL via Homebrew

```bash
# Install MySQL
brew install mysql

# Start MySQL service
brew services start mysql

# Create database
mysql -u root -e "CREATE DATABASE fisheries CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Option 3: Use Existing SQLite Database (Current Setup)

Your database is already working with SQLite! You can view it using:

**A) Web Viewer (Easiest):**
1. Make sure Laravel server is running: `php artisan serve`
2. Open browser: http://localhost:8000/view-database.php
3. Password: `admin123` (change this in the file!)

**B) Command Line:**
```bash
php show-database.php
```

**C) DB Browser for SQLite:**
1. Download: https://sqlitebrowser.org/
2. Open: `database/database.sqlite`

## Switch to MySQL (When Ready)

1. Start MySQL server (see above)
2. Create database:
   ```bash
   mysql -u root -p
   CREATE DATABASE fisheries;
   EXIT;
   ```

3. Update `.env` file:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=fisheries
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

4. Run migrations:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

## View MySQL Database

**Command Line:**
```bash
mysql -u root -p fisheries
SHOW TABLES;
SELECT * FROM users;
```

**GUI Tools:**
- **TablePlus** (macOS): https://tableplus.com/
- **MySQL Workbench**: https://dev.mysql.com/downloads/workbench/
- **Sequel Pro**: https://www.sequelpro.com/
- **phpMyAdmin**: Web-based interface

## Current Status

✅ **SQLite database is working!**
- Location: `database/database.sqlite`
- View online: http://localhost:8000/view-database.php
- View via script: `php show-database.php`


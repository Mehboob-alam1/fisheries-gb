# ✅ MySQL Found on Your Laptop!

## MySQL Location

**MySQL is installed and RUNNING at:**
```
/usr/local/mysql
```

**MySQL Version:** 9.5.0 (MySQL Community Server)

## How to Access MySQL

### Method 1: Direct Path
```bash
/usr/local/mysql/bin/mysql -u root -p
```

### Method 2: Add to PATH (Recommended)

Add MySQL to your PATH so you can use `mysql` command:

**For current session:**
```bash
export PATH=$PATH:/usr/local/mysql/bin
```

**Permanent (add to ~/.zshrc or ~/.bash_profile):**
```bash
echo 'export PATH=$PATH:/usr/local/mysql/bin' >> ~/.zshrc
source ~/.zshrc
```

Then you can use:
```bash
mysql -u root -p
```

## Setup Database for Fisheries App

### Step 1: Create Database

You'll need your MySQL root password. If you don't remember it, see "Reset Password" section below.

```bash
/usr/local/mysql/bin/mysql -u root -p
```

Then in MySQL:
```sql
CREATE DATABASE fisheries CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

### Step 2: Update .env File

Edit your `.env` file and change:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fisheries
DB_USERNAME=root
DB_PASSWORD=your_mysql_root_password
```

### Step 3: Run Migrations

```bash
php artisan migrate
php artisan db:seed
```

## Quick Setup Script

Run this (it will prompt for MySQL password):
```bash
chmod +x setup-mysql-now.sh
./setup-mysql-now.sh
```

## If You Forgot MySQL Root Password

### Reset MySQL Root Password:

1. **Stop MySQL:**
   ```bash
   sudo /usr/local/mysql/support-files/mysql.server stop
   ```

2. **Start MySQL in safe mode:**
   ```bash
   sudo /usr/local/mysql/bin/mysqld_safe --skip-grant-tables &
   ```

3. **Connect without password:**
   ```bash
   /usr/local/mysql/bin/mysql -u root
   ```

4. **Reset password:**
   ```sql
   USE mysql;
   UPDATE user SET authentication_string=PASSWORD('newpassword') WHERE User='root';
   FLUSH PRIVILEGES;
   EXIT;
   ```

5. **Restart MySQL normally:**
   ```bash
   sudo /usr/local/mysql/support-files/mysql.server restart
   ```

## MySQL Management

### Start MySQL:
```bash
sudo /usr/local/mysql/support-files/mysql.server start
```

### Stop MySQL:
```bash
sudo /usr/local/mysql/support-files/mysql.server stop
```

### Check Status:
```bash
sudo /usr/local/mysql/support-files/mysql.server status
```

### Or use System Preferences:
1. Open **System Preferences**
2. Look for **MySQL** (if installed via .dmg installer)
3. Click to start/stop MySQL

## View MySQL Database

### Command Line:
```bash
/usr/local/mysql/bin/mysql -u root -p fisheries
SHOW TABLES;
SELECT * FROM users;
```

### GUI Tools:
- **TablePlus**: https://tableplus.com/ (Recommended for macOS)
- **MySQL Workbench**: https://dev.mysql.com/downloads/workbench/
- **Sequel Pro**: https://www.sequelpro.com/

## Current Status

✅ **MySQL is INSTALLED and RUNNING**
- Location: `/usr/local/mysql`
- Version: MySQL 9.5.0
- Status: Server is running

Next: Create database and update .env file!


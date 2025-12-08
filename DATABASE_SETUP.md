# Database Setup Guide - MySQL Configuration

This guide will help you set up MySQL database for the Fisheries Management System.

## Option 1: Local MySQL Setup

### Step 1: Install MySQL

**macOS:**
```bash
brew install mysql
brew services start mysql
```

**Linux (Ubuntu/Debian):**
```bash
sudo apt update
sudo apt install mysql-server
sudo systemctl start mysql
```

**Windows:**
Download MySQL from: https://dev.mysql.com/downloads/mysql/

### Step 2: Create Database

Login to MySQL:
```bash
mysql -u root -p
```

Then create the database:
```sql
CREATE DATABASE fisheries CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'fisheries_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON fisheries.* TO 'fisheries_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Step 3: Update .env File

Edit your `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fisheries
DB_USERNAME=fisheries_user
DB_PASSWORD=your_secure_password
```

### Step 4: Run Migrations

```bash
php artisan migrate
php artisan db:seed
```

## Option 2: Remote MySQL (Hostinger/Production)

### Step 1: Create Database on Hostinger

1. Login to Hostinger hPanel
2. Go to **Databases** → **MySQL Databases**
3. Create a new database (e.g., `u123456789_fisheries`)
4. Create a new MySQL user
5. Add user to database with ALL PRIVILEGES
6. Note down:
   - Database name
   - Username
   - Password
   - Host (usually `localhost` or `mysql.hostinger.com`)

### Step 2: Update .env File

Edit your `.env` file on the server:
```env
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456789_fisheries
DB_USERNAME=u123456789_fisheries_user
DB_PASSWORD=your_secure_password
```

### Step 3: Run Migrations on Server

SSH into your server or use Hostinger File Manager terminal:
```bash
cd /path/to/your/project
php artisan migrate --force
php artisan db:seed
```

## Option 3: Cloud MySQL Services

### Using PlanetScale, AWS RDS, or Google Cloud SQL

1. Create a MySQL instance on your cloud provider
2. Get connection details (host, port, database, username, password)
3. Update `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=your-cloud-host.com
DB_PORT=3306
DB_DATABASE=fisheries
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## Migrating from SQLite to MySQL

If you have existing data in SQLite:

1. **Export SQLite data:**
```bash
sqlite3 database/database.sqlite .dump > backup.sql
```

2. **Update .env to MySQL** (as shown above)

3. **Run migrations:**
```bash
php artisan migrate:fresh
php artisan db:seed
```

4. **Import data manually** (if needed) or recreate through admin panel

## Testing Connection

Test your MySQL connection:
```bash
php artisan tinker
```

Then run:
```php
DB::connection()->getPdo();
// Should return: PDO object without errors
```

## Troubleshooting

### Error: "Access denied for user"
- Check username and password in `.env`
- Verify user has proper permissions
- Try resetting MySQL user password

### Error: "Unknown database"
- Make sure database exists
- Check database name in `.env` matches actual database

### Error: "Can't connect to MySQL server"
- Verify MySQL service is running: `mysql -u root -p`
- Check firewall settings
- Verify host and port are correct

### Error: "PDOException: could not find driver"
- Install PHP MySQL extension:
  ```bash
  # macOS
  brew install php@8.2-mysql
  
  # Linux
  sudo apt install php-mysql
  ```

## Security Best Practices

1. **Use strong passwords** for database users
2. **Don't commit `.env` file** to version control
3. **Use SSL connections** for remote databases:
   ```env
   MYSQL_ATTR_SSL_CA=/path/to/ca-cert.pem
   ```
4. **Limit database user privileges** to only what's needed
5. **Regular backups** of your database

## Backup and Restore

### Backup:
```bash
mysqldump -u username -p fisheries > backup.sql
```

### Restore:
```bash
mysql -u username -p fisheries < backup.sql
```


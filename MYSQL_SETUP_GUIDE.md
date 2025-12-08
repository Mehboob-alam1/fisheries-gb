# MySQL Setup Guide - Step by Step

## Current Issue
You're getting: `ERROR 1045 (28000): Access denied for user 'root'@'localhost'`

This means the password `Newpassd12@` is not correct for your MySQL root user.

## Solution Options

### Option 1: Reset MySQL Root Password (Recommended)

Run this command (you'll need your Mac password):
```bash
sudo ./reset-mysql-password.sh
```

This will:
1. Stop MySQL
2. Start MySQL in safe mode
3. Reset root password to `Newpassd12@`
4. Create the `fisheries` database
5. Update your `.env` file automatically

### Option 2: Connect Manually and Find Correct Password

Try connecting interactively:
```bash
/usr/local/mysql/bin/mysql -u root -p
```

When prompted, try:
- Your Mac password
- Empty password (just press Enter)
- `root`
- `password`
- Or any password you remember setting

Once connected, create the database:
```sql
CREATE DATABASE fisheries CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

Then update your `.env` file manually with the correct password.

### Option 3: Continue with SQLite (Already Working)

Your app is already working with SQLite! You can:
- View database: http://localhost:8000/view-database.php
- Continue development with SQLite
- Switch to MySQL later when needed

## Quick Fix Script

I've created these scripts for you:

1. **`reset-mysql-password.sh`** - Resets MySQL password (requires sudo)
2. **`simple-mysql-setup.sh`** - Tries simple connection
3. **`fix-mysql-password.sh`** - Tests password and sets up database

## Recommended Action

**Run this command:**
```bash
sudo ./reset-mysql-password.sh
```

This will reset your MySQL root password to `Newpassd12@` and set everything up automatically.

## After Setup

Once MySQL is configured:

1. **Run migrations:**
   ```bash
   php artisan migrate
   ```

2. **Seed the database:**
   ```bash
   php artisan db:seed
   ```

3. **View your database:**
   - Web viewer: http://localhost:8000/view-database.php
   - Command line: `/usr/local/mysql/bin/mysql -u root -p fisheries`

## Need Help?

If the reset script doesn't work, you can:
1. Check MySQL error logs: `/usr/local/mysql/data/mysqld.local.err`
2. Try connecting with different passwords
3. Continue using SQLite (it's already working!)


# 🚀 Quick Start Guide - How to Run the Project

## Quick Steps

### 1. Configure Database

Edit the `.env` file in the project root:

```env
DB_CONNECTION=sqlite
```

Or use MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fisheries
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Run Migrations and Seeder

```bash
php artisan migrate
php artisan db:seed
```

This will create:
- All database tables
- An admin user with credentials:
  - **Email**: `admin@fisheries.gov.pk`
  - **Password**: `admin123`

### 3. Start the Server

```bash
php artisan serve
```

### 4. Access the System

Open your browser and go to:

- **Admin**: http://localhost:8000/admin/login
- **Farm Manager**: http://localhost:8000/farm/login

### 5. Build Assets (optional, for development)

In another terminal:

```bash
npm run dev
```

## ⚠️ Common Issues

### Error: "SQLSTATE[HY000] [14] unable to open database file"

**Solution**: Create the SQLite database file manually:
```bash
touch database/database.sqlite
```

### Error: "Class 'App\Models\District' not found"

**Solution**: Run:
```bash
composer dump-autoload
```

### Error: "Route [admin.login] not defined"

**Solution**: Clear cache:
```bash
php artisan route:clear
php artisan config:clear
```

## 📝 Next Steps

After running the project, you can:

1. Login as admin
2. Create districts and farms
3. Create farm manager users
4. Test the system

## 🆘 Need Help?

Check the `README.md` file for detailed information.

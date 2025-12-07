# Gilgit-Baltistan Fisheries Management System

Centralized web-based platform for district-level fish farm managers to record, manage, and report daily operations data. Administrators can monitor all districts and farms, manage credentials, and generate printable reports.

## 🚀 How to Run the Project

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL or SQLite

### 1. Database Configuration

Copy the `.env.example` file to `.env` (if it doesn't exist):

```bash
cp .env.example .env
```

Edit the `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fisheries
DB_USERNAME=root
DB_PASSWORD=
```

Or use SQLite (simpler for development):

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Application Configuration

```bash
# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate
```

### 4. Create Admin User

Create an admin user manually via Tinker:

```bash
php artisan tinker
```

Then run:

```php
$admin = \App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@fisheries.gov.pk',
    'password' => bcrypt('password'),
    'role' => 'admin'
]);
```

Or use the seeder:

```bash
php artisan db:seed
```

### 5. Build Frontend Assets

```bash
# Development (watch mode)
npm run dev

# Production
npm run build
```

### 6. Start Development Server

```bash
php artisan serve
```

The project will be available at: `http://localhost:8000`

### 7. Access the System

- **Admin Login**: `http://localhost:8000/admin/login`
- **Farm Manager Login**: `http://localhost:8000/farm/login`

## 📁 Project Structure

```
fisheries/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Controllers for Admin and Farm Manager
│   │   └── Middleware/      # Role-based middleware
│   └── Models/              # Eloquent Models
├── database/
│   └── migrations/          # Database migrations
├── resources/
│   ├── views/
│   │   ├── admin/           # Admin views
│   │   └── farm/            # Farm Manager views
│   └── css/                 # TailwindCSS styles
├── routes/
│   ├── web.php              # Main routes
│   ├── admin.php            # Admin routes
│   └── farm.php             # Farm Manager routes
└── public/                  # Public files
```

## 🔐 Default Credentials

After creating the admin user, you can login with:
- **Email**: admin@fisheries.gov.pk
- **Password**: admin123

⚠️ **IMPORTANT**: Change the password after first login!

## 🛠️ Useful Commands

```bash
# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Create new controller
php artisan make:controller NameController

# Create new migration
php artisan make:migration migration_name

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 📝 Development Notes

The project is still under development. The following features need to be implemented:

- [ ] Complete Admin Dashboard
- [ ] Complete Farm Manager Dashboard
- [ ] Districts and Farms Management
- [ ] Daily data entry form
- [ ] Reports system with charts
- [ ] PDF/Excel export
- [ ] Edit/delete logic with 3-hour restriction

## 🌐 Deploy to Hostinger

1. Upload files to server via FTP/SFTP
2. Configure MySQL database on Hostinger
3. Update `.env` with production credentials
4. Run `composer install --no-dev --optimize-autoloader`
5. Run `php artisan migrate --force`
6. Configure SSL (Let's Encrypt) on Hostinger
7. Set document root to `/public`

## 📄 License

Project developed for the Government of Gilgit-Baltistan.

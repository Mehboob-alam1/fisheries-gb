# Gilgit-Baltistan Fisheries Management System

Centralized web-based platform for district-level fish farm managers to record, manage, and report daily operations data. Administrators can monitor all districts and farms, manage credentials, and generate printable reports.

## 👥 User Roles

### 1. Admin
- **Login URL**: `http://domain.com/admin/login`
- **Created**: Manually during system setup (via seeder)
- **Capabilities**:
  - Create and manage districts
  - Create and manage farms
  - Create farm manager accounts with credentials
  - View and manage all farm managers
  - Reset passwords for farm managers
  - View all daily entries from all farms
  - Generate reports and export data
  - Monitor system-wide statistics

### 2. Farm Manager
- **Login URL**: `http://domain.com/farm/login`
- **Created**: By Admin through admin panel
- **Capabilities**:
  - Add daily data entries (fish stock, feed, mortality, water temperature, remarks)
  - View all past entries for their farm
  - Edit or delete the last entry (within 3 hours of submission only)
  - Export personal records to CSV
  - View farm information and statistics

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

**Option 1: MySQL**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fisheries
DB_USERNAME=root
DB_PASSWORD=
```

**Option 2: SQLite (simpler for development)**
```env
DB_CONNECTION=sqlite
```

Then create the database file:
```bash
touch database/database.sqlite
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

# Seed admin user
php artisan db:seed
```

### 4. Build Frontend Assets

```bash
# Development (watch mode)
npm run dev

# Production
npm run build
```

### 5. Start Development Server

```bash
php artisan serve
```

The project will be available at: `http://localhost:8000`

### 6. Access the System

- **Admin Login**: `http://localhost:8000/admin/login`
- **Farm Manager Login**: `http://localhost:8000/farm/login`

## 🔐 Default Credentials

### Admin Account
After running the seeder, you can login with:
- **Email**: `admin@fisheries.gov.pk`
- **Password**: `admin123`
- **Login URL**: `http://localhost:8000/admin/login`

⚠️ **IMPORTANT**: Change the password after first login!

### Farm Manager Accounts
Farm managers are created by the admin through the admin panel. Credentials are displayed once during creation and should be provided to the farm manager.

## 📋 Admin User Guide

### Getting Started

1. **Login as Admin**
   - Navigate to: `http://localhost:8000/admin/login`
   - Use default credentials or your admin account

2. **Create a District**
   - Go to Dashboard → "Manage Districts"
   - Click "Create New District"
   - Enter district name and save

3. **Create a Farm Manager**
   - Go to Dashboard → "Manage Farm Managers"
   - Click "Create New Manager"
   - Fill in the form:
     - Manager's full name
     - Email address (used for login)
     - Password (create a secure password)
     - Select district
     - Farm name
     - Location (optional)
   - Click "Create Manager & Farm"
   - **IMPORTANT**: Save the credentials shown on the next page!

4. **View Manager Credentials**
   - Go to "Manage Farm Managers"
   - Click "View" on any manager
   - See login URL, email, and reset password option

### Admin Features

- **Dashboard**: Overview of districts, farms, and managers
- **Districts Management**: Create, edit, and view districts
- **Farms Management**: View all farms and their details
- **Managers Management**: 
  - Create new farm managers with credentials
  - View manager details and credentials
  - Edit manager information
  - Reset manager passwords
- **Reports**: (Coming soon) View and export data from all farms

## 📋 Farm Manager User Guide

### Getting Started

1. **Receive Credentials**
   - Admin will provide you with:
     - Login URL: `http://domain.com/farm/login`
     - Email address
     - Password

2. **First Login**
   - Navigate to the login URL
   - Enter your email and password
   - Click "Log in"

3. **Add Daily Entry**
   - Go to Dashboard
   - Fill in the daily data form:
     - Date
     - Fish stock count
     - Feed quantity (kg)
     - Mortality count
     - Water temperature
     - Remarks (optional)
   - Submit the entry

4. **View Past Entries**
   - All your past entries are listed on the dashboard
   - View details of each entry

5. **Edit/Delete Last Entry**
   - You can only edit or delete the most recent entry
   - This is only possible within 3 hours of submission
   - After 3 hours, entries become permanent

### Farm Manager Features

- **Dashboard**: View farm information and recent entries
- **Daily Entry Form**: Add new daily data entries
- **Entry History**: View all past entries
- **Edit/Delete**: Modify or remove last entry (3-hour window)
- **Export Data**: (Coming soon) Export entries to CSV

## 🔐 Authentication & Security

- **Laravel Breeze**: Secure session-based authentication
- **Role-based Access Control**: Middleware ensures proper access
- **CSRF Protection**: All forms protected against CSRF attacks
- **XSS Protection**: Input sanitization and output escaping
- **SQL Injection Protection**: Eloquent ORM with parameter binding
- **Password Hashing**: Bcrypt encryption for all passwords
- **Rate Limiting**: Login attempts limited to prevent brute force
- **HTTPS Ready**: Configure SSL certificate for production

## 🗂️ Database Structure

### Tables

1. **users**
   - `id`, `name`, `email`, `password`, `role` (admin/manager), `district_id`, `created_at`, `updated_at`

2. **districts**
   - `id`, `name`, `created_at`, `updated_at`

3. **farms**
   - `id`, `district_id`, `name`, `manager_id`, `location`, `created_at`, `updated_at`

4. **entries**
   - `id`, `farm_id`, `date`, `fish_stock`, `feed_quantity`, `mortality`, `water_temp`, `remarks`, `editable_until`, `created_at`, `updated_at`

## 📁 Project Structure

```
fisheries/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Admin controllers (Districts, Farms, Managers)
│   │   │   └── Auth/            # Authentication controllers
│   │   └── Middleware/          # Role-based middleware (admin, manager)
│   └── Models/                   # Eloquent Models (User, District, Farm, Entry)
├── database/
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders (AdminSeeder)
├── resources/
│   ├── views/
│   │   ├── admin/                # Admin views
│   │   │   ├── dashboard.blade.php
│   │   │   ├── login.blade.php
│   │   │   ├── districts/       # District management views
│   │   │   ├── farms/           # Farm management views
│   │   │   └── managers/        # Manager management views
│   │   ├── farm/                 # Farm Manager views
│   │   │   ├── dashboard.blade.php
│   │   │   └── login.blade.php
│   │   └── auth/                 # Authentication views
│   └── css/                     # TailwindCSS styles
├── routes/
│   ├── web.php                   # Main routes
│   ├── admin.php                 # Admin routes
│   └── farm.php                  # Farm Manager routes
└── public/                       # Public files
```

## 🛠️ Useful Commands

```bash
# Run migrations
php artisan migrate

# Fresh migration (drop all tables and re-run)
php artisan migrate:fresh

# Rollback last migration
php artisan migrate:rollback

# Seed database
php artisan db:seed

# Create new controller
php artisan make:controller NameController

# Create new migration
php artisan make:migration migration_name

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# List all routes
php artisan route:list
```

## ✅ Implemented Features

### Authentication
- [x] Separate login portals for Admin and Farm Manager
- [x] Role-based authentication
- [x] Password reset functionality for both roles
- [x] Remember me functionality
- [x] Rate limiting on login attempts
- [x] Secure password hashing

### Admin Features
- [x] Admin dashboard with statistics
- [x] Districts management (create, edit, view)
- [x] Farms management (view all farms)
- [x] Farm Manager management:
  - [x] Create farm managers with credentials
  - [x] View manager details and credentials
  - [x] Edit manager information
  - [x] Reset manager passwords
- [x] Credential display and management

### Farm Manager Features
- [x] Farm Manager dashboard
- [x] Farm information display
- [x] Login portal

## 🚧 Features in Development

- [ ] Daily data entry form for Farm Managers
- [ ] Entry history view
- [ ] Edit/delete logic with 3-hour restriction
- [ ] Reports system with filters
- [ ] Charts and data visualization
- [ ] PDF export functionality
- [ ] Excel/CSV export functionality
- [ ] Password change functionality for Farm Managers
- [ ] Email notifications

## 🌐 Deployment to Production

### Hostinger Deployment Steps

1. **Upload Files**
   - Upload all files to server via FTP/SFTP
   - Ensure `.env` is not uploaded (add to `.gitignore`)

2. **Configure Database**
   - Create MySQL database on Hostinger
   - Update `.env` with production credentials:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=your_host
     DB_DATABASE=your_database
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

3. **Install Dependencies**
   ```bash
   composer install --no-dev --optimize-autoloader
   npm install
   npm run build
   ```

4. **Run Migrations**
   ```bash
   php artisan migrate --force
   php artisan db:seed
   ```

5. **Configure SSL**
   - Set up Let's Encrypt SSL certificate on Hostinger
   - Update `APP_URL` in `.env` to use HTTPS

6. **Set Document Root**
   - Point document root to `/public` directory

7. **Set Permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

## 🔒 Security Best Practices

- Change default admin password immediately
- Use strong passwords for all accounts
- Enable HTTPS in production
- Regularly update dependencies
- Keep Laravel and packages up to date
- Review and audit user access regularly
- Backup database regularly

## 📞 Support

For issues or questions, contact the system administrator.

## 📄 License

Project developed for the Government of Gilgit-Baltistan.

---

**Version**: 1.0.0  
**Last Updated**: December 2024

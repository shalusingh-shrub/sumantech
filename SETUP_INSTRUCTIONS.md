# Teachers of Bihar - Laravel Project Setup

## Step 1: Create Fresh Laravel Project (if not already done)
```bash
cd C:\Users\YourUser\Herd
composer create-project laravel/laravel techsolutions
cd techsolutions
```

## Step 2: Install Required Packages
```bash
composer require spatie/laravel-permission
composer require intervention/image
```

## Step 3: Configure .env
```
APP_NAME="Teachers of Bihar"
APP_ENV=local
APP_KEY=base64:generatethis
APP_DEBUG=true
APP_URL=http://techsolutions.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tob_database
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@gmail.com
MAIL_PASSWORD=yourpassword
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your@gmail.com
MAIL_FROM_NAME="Teachers of Bihar"
```

## Step 4: Create Database
```sql
CREATE DATABASE tob_database CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Step 5: Copy All Files (from this zip) into your techsolutions folder

## Step 6: Run Commands
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve
```

## Default Admin Credentials
- URL: http://techsolutions.test/admin
- Email: admin@teachersofbihar.org
- Password: password

## Roles Available
- super_admin
- admin
- editor
- member

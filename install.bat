@echo off
REM File: INSTALL.bat
REM Run this from the techsolutions folder

echo ========================================
echo  Teachers of Bihar - Installation Script
echo ========================================
echo.

echo Step 1: Installing Composer Dependencies...
composer install
if %ERRORLEVEL% NEQ 0 (echo ERROR: composer install failed & pause & exit)

echo.
echo Step 2: Installing Spatie Permission...
composer require spatie/laravel-permission
if %ERRORLEVEL% NEQ 0 (echo ERROR: Failed to install spatie/laravel-permission & pause & exit)

echo.
echo Step 3: Generating App Key...
php artisan key:generate

echo.
echo Step 4: Publishing Spatie Permission...
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

echo.
echo Step 5: Running Migrations...
php artisan migrate:fresh
if %ERRORLEVEL% NEQ 0 (echo ERROR: Migration failed. Check .env DB settings & pause & exit)

echo.
echo Step 6: Running Seeders...
php artisan db:seed
if %ERRORLEVEL% NEQ 0 (echo ERROR: Seeding failed & pause & exit)

echo.
echo Step 7: Creating Storage Link...
php artisan storage:link

echo.
echo Step 8: Creating upload directories...
mkdir storage\app\public\sliders 2>nul
mkdir storage\app\public\team 2>nul
mkdir storage\app\public\news 2>nul
mkdir storage\app\public\publications 2>nul
mkdir storage\app\public\publication_files 2>nul
mkdir storage\app\public\gallery 2>nul
mkdir storage\app\public\testimonials 2>nul
mkdir storage\app\public\awards 2>nul
mkdir storage\app\public\competitions 2>nul
mkdir storage\app\public\eip 2>nul

echo.
echo Step 9: Clearing cache...
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo.
echo ========================================
echo  INSTALLATION COMPLETE!
echo ========================================
echo.
echo Admin URL: http://techsolutions.test/admin
echo Email: admin@teachersofbihar.org
echo Password: password
echo.
echo Run: php artisan serve
echo OR use Laravel Herd (site auto-detected)
echo.
pause

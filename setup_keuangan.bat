@echo off
echo Setting up PPDB Keuangan Dashboard...

echo.
echo 1. Running migrations...
php artisan migrate --force

echo.
echo 2. Running seeders...
php artisan db:seed --force

echo.
echo 3. Clearing cache...
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

echo.
echo Setup completed!
echo.
echo Login credentials for Keuangan:
echo Email: keuangan@smk.com
echo Password: keuangan123
echo.
pause
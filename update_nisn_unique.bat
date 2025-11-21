@echo off
echo Menambahkan constraint NISN unik...

echo.
echo 1. Running migration untuk NISN unique...
php artisan migrate --force

echo.
echo 2. Clearing cache...
php artisan cache:clear
php artisan config:clear

echo.
echo Update selesai!
echo NISN sekarang sudah memiliki constraint unique.
echo Siswa tidak bisa mendaftar dengan NISN yang sama.
echo.
pause
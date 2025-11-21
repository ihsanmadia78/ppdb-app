@echo off
echo ========================================
echo    SETUP PORTAL SISWA PPDB
echo ========================================

cd /d "c:\xampp\ppdb-app"

echo.
echo 1. Menjalankan seeder untuk user siswa...
php artisan db:seed --class=DatabaseSeeder

echo.
echo 2. Membuat data test siswa...
php create_siswa_test_data.php

echo.
echo ========================================
echo    SETUP SELESAI!
echo ========================================
echo.
echo Login Info:
echo - Email: siswa@test.com
echo - Password: siswa123
echo.
echo URL Portal:
echo - Login: http://localhost/ppdb-app/public/login
echo - Dashboard Siswa: http://localhost/ppdb-app/public/siswa/dashboard
echo - Pembayaran: http://localhost/ppdb-app/public/siswa/pembayaran
echo.
pause
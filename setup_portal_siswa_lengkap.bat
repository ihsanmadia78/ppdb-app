@echo off
echo ========================================
echo    SETUP PORTAL SISWA LENGKAP
echo ========================================

cd /d "c:\xampp\ppdb-app"

echo.
echo 1. Menjalankan seeder database...
php artisan db:seed --class=DatabaseSeeder

echo.
echo 2. Setup data portal siswa lengkap...
php setup_portal_siswa_lengkap.php

echo.
echo 3. Clear cache aplikasi...
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo.
echo ========================================
echo    SETUP SELESAI!
echo ========================================
echo.
echo Portal Siswa Info:
echo - Email: siswa@test.com
echo - Password: siswa123
echo - No. Pendaftaran: PPDB2025001
echo.
echo URL Portal Siswa:
echo - Login: http://localhost/ppdb-app/public/siswa/login
echo - Dashboard: http://localhost/ppdb-app/public/siswa/dashboard
echo - Biodata: http://localhost/ppdb-app/public/siswa/biodata
echo - Pembayaran: http://localhost/ppdb-app/public/siswa/pembayaran
echo - Cetak Kartu: http://localhost/ppdb-app/public/siswa/cetak-kartu
echo.
echo Fitur Portal Siswa:
echo ✅ Login terpisah untuk calon siswa
echo ✅ Dashboard dengan status pendaftaran
echo ✅ Halaman biodata lengkap
echo ✅ Upload bukti pembayaran
echo ✅ Cetak kartu peserta ke PDF
echo ✅ Integrasi dengan sistem keuangan
echo.
pause
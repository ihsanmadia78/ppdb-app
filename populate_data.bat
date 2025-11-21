@echo off
echo ========================================
echo    POPULATE DATA UNTUK FITUR ADMIN
echo ========================================
echo.

cd /d "%~dp0"

echo Membuat data dummy untuk testing fitur admin...
php populate_admin_data.php

echo.
echo ========================================
echo         DATA BERHASIL DIBUAT
echo ========================================
echo.
echo Sekarang semua fitur admin sudah memiliki data:
echo - Dashboard dengan statistik
echo - Chart dan grafik
echo - Data pendaftar lengkap
echo - Data pembayaran
echo - Export data
echo.
echo Login admin: admin@smk.com / admin123
echo.
pause
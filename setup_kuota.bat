@echo off
echo ========================================
echo      SETUP KUOTA JURUSAN
echo ========================================
echo.

cd /d "%~dp0"

echo Menambahkan kolom kuota ke tabel jurusan...
php add_kuota_jurusan.php

echo.
pause
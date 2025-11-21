@echo off
echo ========================================
echo     TEST FITUR STATUS AKHIR ADMIN
echo ========================================
echo.

cd /d "%~dp0"

echo Membuat data test untuk fitur status akhir...
php test_status_akhir.php

echo.
pause
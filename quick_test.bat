@echo off
echo ========================================
echo      QUICK TEST DATA DASHBOARD
echo ========================================
echo.

cd /d "%~dp0"

echo Membuat data test cepat...
php quick_test_data.php

echo.
pause
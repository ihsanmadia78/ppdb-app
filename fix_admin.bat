@echo off
echo ========================================
echo      PERBAIKAN FITUR ADMIN PPDB
echo ========================================
echo.

cd /d "%~dp0"

echo Memperbaiki semua fitur admin...
php fix_admin_features.php

echo.
echo ========================================
echo        PERBAIKAN SELESAI
echo ========================================
echo.
echo Silakan login ke admin dengan:
echo Email: admin@smk.com
echo Password: admin123
echo.
pause
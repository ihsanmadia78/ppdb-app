@echo off
echo ========================================
echo      PERBAIKAN KOLOM STATUS
echo ========================================
echo.

cd /d "%~dp0"

echo Memperbaiki kolom status di database...
php fix_status_column.php

echo.
pause
@echo off
echo ========================================
echo    SINKRONISASI DATA PEMBAYARAN
echo ========================================
echo.

cd /d "%~dp0"

echo Menyinkronkan data pendaftar dengan pembayaran...
php sync_pembayaran_data.php

echo.
pause
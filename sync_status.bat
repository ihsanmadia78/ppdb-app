@echo off
echo ========================================
echo    SINKRONISASI STATUS PEMBAYARAN
echo ========================================
echo.

cd /d "%~dp0"

echo Menyinkronkan status pendaftar dengan pembayaran...
php sync_status_pembayaran.php

echo.
pause
@echo off
echo ========================================
echo      BUAT DATA TEST PEMBAYARAN
echo ========================================
echo.

cd /d "%~dp0"

echo Membuat data test pembayaran...
php create_test_payment.php

echo.
pause
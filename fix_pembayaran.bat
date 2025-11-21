@echo off
echo ========================================
echo    PERBAIKAN RECORD PEMBAYARAN PPDB
echo ========================================
echo.

cd /d "%~dp0"

echo Menjalankan perbaikan record pembayaran...
php fix_pembayaran_records.php

echo.
echo ========================================
echo           PERBAIKAN SELESAI
echo ========================================
echo.
pause
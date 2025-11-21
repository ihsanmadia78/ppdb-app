@echo off
echo ========================================
echo      SETUP ALUR PEMBAYARAN PPDB
echo ========================================
echo.

cd /d "%~dp0"

echo Mengatur alur pembayaran PPDB...
php setup_pembayaran_flow.php

echo.
pause
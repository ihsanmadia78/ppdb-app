@echo off
echo ========================================
echo       DEBUG PEMBAYARAN PPDB
echo ========================================
echo.

cd /d "%~dp0"

echo Menjalankan debug pembayaran...
php debug_pembayaran.php

echo.
echo ========================================
echo         DEBUG SELESAI
echo ========================================
echo.
pause
@echo off
echo ========================================
echo   PERBAIKAN LENGKAP PEMBAYARAN PPDB
echo ========================================
echo.

cd /d "%~dp0"

echo Menjalankan perbaikan lengkap pembayaran...
echo PERINGATAN: Script ini akan mengubah data di database!
echo.
set /p confirm="Lanjutkan? (Y/N): "

if /i "%confirm%"=="Y" (
    echo.
    echo Memulai perbaikan...
    php fix_pembayaran_complete.php
) else (
    echo Perbaikan dibatalkan.
)

echo.
echo ========================================
echo         PERBAIKAN SELESAI
echo ========================================
echo.
pause
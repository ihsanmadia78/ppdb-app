@echo off
echo Memperbaiki masalah kuota gelombang...

echo.
echo 1. Mengupdate kuota gelombang...
php artisan tinker --execute="
DB::table('gelombang')->where('nama', 'Gelombang 1')->update(['kuota' => 100]);
DB::table('gelombang')->where('nama', 'Gelombang 2')->update(['kuota' => 100]);
echo 'Kuota berhasil diupdate!';
"

echo.
echo 2. Clearing cache...
php artisan cache:clear

echo.
echo Kuota gelombang sudah bisa diupdate!
pause
@echo off
echo Mengupdate harga gelombang...

echo.
echo Gelombang 1: Rp 5.000.000
echo Gelombang 2: Rp 4.500.000
echo.

php artisan tinker --execute="
DB::table('gelombang')->where('nama', 'Gelombang 1')->update(['biaya_daftar' => 5000000]);
DB::table('gelombang')->where('nama', 'Gelombang 2')->update(['biaya_daftar' => 4500000]);
echo 'Harga gelombang berhasil diupdate!';
"

echo.
echo Update selesai!
pause
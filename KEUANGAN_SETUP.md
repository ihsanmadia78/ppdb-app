# Setup Dashboard Keuangan PPDB

## Masalah yang Diperbaiki:
1. Model User tidak memiliki field `role`
2. Middleware untuk role keuangan belum ada
3. Error handling di KeuanganController
4. Routes tidak menggunakan middleware yang tepat

## Langkah Setup:

### 1. Jalankan Migration dan Seeder
```bash
# Jalankan file batch
setup_keuangan.bat

# Atau manual:
php artisan migrate --force
php artisan db:seed --force
php artisan cache:clear
```

### 2. Login Credentials
- **Email**: keuangan@smk.com
- **Password**: keuangan123

### 3. Akses Dashboard
- URL: `http://localhost/ppdb-app/public/keuangan/dashboard`
- Atau melalui login dengan credentials di atas

## Troubleshooting:

### Error "Table doesn't exist"
```bash
php artisan migrate:fresh --seed
```

### Error "Access Denied"
Pastikan user memiliki role 'keuangan' di database:
```sql
UPDATE users SET role = 'keuangan' WHERE email = 'keuangan@smk.com';
```

### Error "Class not found"
```bash
composer dump-autoload
php artisan config:clear
```

### Dashboard kosong/error
1. Periksa log: `storage/logs/laravel.log`
2. Pastikan database terkoneksi
3. Jalankan: `php artisan cache:clear`

## File yang Dimodifikasi:
- `app/Models/User.php` - Tambah field role
- `app/Http/Middleware/KeuanganMiddleware.php` - Middleware baru
- `app/Http/Kernel.php` - Daftarkan middleware
- `routes/web.php` - Tambah middleware ke routes
- `app/Http/Controllers/KeuanganController.php` - Error handling
- `resources/views/keuangan/dashboard.blade.php` - Perbaikan view
- `database/seeders/UserSeeder.php` - User seeder
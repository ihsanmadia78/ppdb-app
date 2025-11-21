# 🎓 Portal Siswa PPDB - Panduan Lengkap

## 📋 Overview
Portal siswa memungkinkan siswa yang sudah terdaftar untuk:
- Melihat status pendaftaran
- Upload bukti pembayaran
- Melihat status verifikasi pembayaran
- Mengakses informasi pendaftaran

## 🔐 Akses Portal Siswa

### Login Credentials (Test)
- **Email**: `siswa@test.com`
- **Password**: `siswa123`
- **Role**: `siswa`

### URL Portal
- **Login**: `http://localhost/ppdb-app/public/login`
- **Dashboard**: `http://localhost/ppdb-app/public/siswa/dashboard`
- **Pembayaran**: `http://localhost/ppdb-app/public/siswa/pembayaran`

## 🚀 Setup Portal Siswa

### 1. Jalankan Setup Script
```bash
# Jalankan file batch untuk setup otomatis
setup_siswa_portal.bat
```

### 2. Manual Setup
```bash
# 1. Seed database dengan user siswa
php artisan db:seed --class=DatabaseSeeder

# 2. Buat data test siswa
php create_siswa_test_data.php
```

## 📱 Fitur Portal Siswa

### 1. Dashboard Siswa
- **Status Pendaftaran**: Menampilkan status terkini (SUBMIT, LULUS, dll)
- **Status Pembayaran**: Menampilkan status verifikasi pembayaran
- **Informasi Pendaftar**: No. pendaftaran, jurusan, gelombang
- **Menu Navigasi**: Akses ke fitur pembayaran dan lainnya

### 2. Halaman Pembayaran
- **Informasi Biaya**: Menampilkan biaya pendaftaran sesuai gelombang
- **Upload Bukti**: Form upload bukti pembayaran
- **Status Verifikasi**: Menampilkan status verifikasi dari keuangan
- **Riwayat Pembayaran**: Melihat bukti yang sudah diupload

## 💳 Proses Pembayaran

### Flow Pembayaran:
1. **Siswa Login** → Portal Siswa
2. **Upload Bukti** → Halaman Pembayaran
3. **Auto Status** → Status berubah ke "MENUNGGU_VERIFIKASI_KEUANGAN"
4. **Masuk Keuangan** → Data otomatis masuk ke dashboard keuangan
5. **Verifikasi** → Petugas keuangan verifikasi pembayaran
6. **Notifikasi** → Siswa mendapat update status

### Metode Pembayaran:
- **Transfer Bank**
- **Virtual Account (VA)**
- **QRIS**

### Format File:
- **Ekstensi**: JPG, PNG, PDF
- **Ukuran Max**: 2MB
- **Nama File**: Auto generate dengan no. pendaftaran

## 🔄 Integrasi dengan Sistem Keuangan

### Automatic Integration:
- Upload bukti pembayaran siswa **langsung masuk** ke dashboard keuangan
- Status otomatis berubah ke `MENUNGGU_VERIFIKASI_KEUANGAN`
- Data pembayaran tersimpan dengan status `paid` untuk review keuangan

### Data yang Tersimpan:
```php
Pembayaran::create([
    'pendaftar_id' => $pendaftar->id,
    'nominal' => $nominal, // Dari gelombang
    'metode_pembayaran' => $request->metode_pembayaran,
    'bukti_bayar' => $path, // File path
    'status' => 'paid', // Untuk review keuangan
    'tanggal_bayar' => now()
]);
```

## 🛠 Technical Details

### Controllers:
- **SiswaController**: Handle dashboard dan pembayaran siswa
- **KeuanganController**: Verifikasi pembayaran dari siswa

### Routes:
```php
// Portal Siswa Routes
Route::middleware(['auth', 'prevent.back'])->group(function () {
    Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard']);
    Route::get('/siswa/pembayaran', [SiswaController::class, 'pembayaran']);
    Route::post('/siswa/upload-pembayaran', [SiswaController::class, 'uploadPembayaran']);
});
```

### Views:
- `resources/views/siswa/dashboard.blade.php`
- `resources/views/siswa/pembayaran.blade.php`

### Database Tables:
- **users**: Role siswa
- **pendaftar**: Data pendaftaran siswa
- **pembayaran**: Data pembayaran dan bukti

## 🔍 Testing

### Test Data:
- **User**: siswa@test.com / siswa123
- **Pendaftar**: PPDB2025001 (Auto created)
- **Jurusan**: PPLG (ID: 1)
- **Gelombang**: Gelombang 1 (ID: 1)

### Test Flow:
1. Login sebagai siswa
2. Akses dashboard siswa
3. Klik menu "Pembayaran"
4. Upload bukti pembayaran
5. Cek di dashboard keuangan (login sebagai keuangan@smk.com)
6. Verifikasi pembayaran
7. Cek kembali status di portal siswa

## 📊 Status Flow

```
SISWA UPLOAD BUKTI
        ↓
MENUNGGU_VERIFIKASI_KEUANGAN
        ↓
KEUANGAN VERIFIKASI
        ↓
TERBAYAR (Verified)
        ↓
ADMIN KEPUTUSAN AKHIR
        ↓
LULUS/TIDAK_LULUS/CADANGAN
```

## 🎯 Benefits

### Untuk Siswa:
- ✅ Akses mudah untuk upload pembayaran
- ✅ Real-time status tracking
- ✅ Interface yang user-friendly
- ✅ Riwayat pembayaran tersimpan

### Untuk Keuangan:
- ✅ Data pembayaran otomatis masuk sistem
- ✅ Bukti pembayaran terorganisir
- ✅ Workflow verifikasi yang jelas
- ✅ Tracking status pembayaran

### Untuk Admin:
- ✅ Monitoring pembayaran real-time
- ✅ Data terintegrasi dengan sistem utama
- ✅ Laporan pembayaran otomatis
- ✅ Kontrol penuh atas keputusan akhir

## 🔧 Troubleshooting

### Common Issues:
1. **File upload gagal**: Cek permission folder storage
2. **Data tidak masuk keuangan**: Cek status pembayaran di database
3. **Login siswa gagal**: Pastikan user role = 'siswa'
4. **Status tidak update**: Cek relasi database pendaftar-pembayaran

### Debug Commands:
```bash
# Cek data siswa
php artisan tinker
>>> App\Models\User::where('role', 'siswa')->get();

# Cek data pembayaran
>>> App\Models\Pembayaran::with('pendaftar')->get();
```

---

**🎉 Portal siswa siap digunakan! Data pembayaran akan otomatis masuk ke sistem keuangan untuk diverifikasi.**
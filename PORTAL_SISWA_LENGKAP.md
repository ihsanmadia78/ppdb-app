# 🎓 Portal Siswa Lengkap - PPDB SMK BaktiNusantara 666

## 📋 Overview
Portal siswa yang lengkap dengan login terpisah, dashboard, biodata, pembayaran, dan fitur cetak kartu peserta ke PDF.

## 🚀 Quick Setup
```bash
# Jalankan setup otomatis
setup_portal_siswa_lengkap.bat
```

## 🔐 Login Portal Siswa

### URL Login
- **Portal Siswa**: `http://localhost/ppdb-app/public/siswa/login`

### Test Account
- **Email**: `siswa@test.com`
- **Password**: `siswa123`
- **No. Pendaftaran**: `PPDB2025001`

## 📱 Fitur Portal Siswa

### 1. 🏠 Dashboard Siswa
- **URL**: `/siswa/dashboard`
- **Fitur**:
  - Status pendaftaran real-time
  - Status pembayaran
  - Informasi jurusan & gelombang
  - Menu navigasi ke semua fitur

### 2. 👤 Biodata Siswa
- **URL**: `/siswa/biodata`
- **Fitur**:
  - Data pendaftaran lengkap
  - Data pribadi siswa
  - Alamat & kontak
  - Data orang tua
  - Tombol cetak kartu

### 3. 💳 Pembayaran
- **URL**: `/siswa/pembayaran`
- **Fitur**:
  - Upload bukti pembayaran
  - Status verifikasi keuangan
  - Riwayat pembayaran
  - Integrasi otomatis ke sistem keuangan

### 4. 🖨️ Cetak Kartu Peserta
- **URL**: `/siswa/cetak-kartu`
- **Fitur**:
  - Generate PDF kartu peserta
  - Design profesional dengan logo sekolah
  - QR Code untuk verifikasi
  - Data lengkap siswa
  - Auto download PDF

## 🔄 Workflow Portal Siswa

```
1. Siswa Login → Portal Siswa
2. Dashboard → Lihat Status
3. Biodata → Cek Data Lengkap
4. Pembayaran → Upload Bukti
5. Cetak Kartu → Download PDF
```

## 🛠 Technical Implementation

### Controllers
- **SiswaController**: Handle semua fitur portal siswa
  - `showLogin()`: Tampil halaman login
  - `login()`: Proses login siswa
  - `dashboard()`: Dashboard siswa
  - `biodata()`: Halaman biodata
  - `pembayaran()`: Halaman pembayaran
  - `cetakKartu()`: Generate PDF kartu

### Views
- `siswa/login.blade.php`: Halaman login khusus siswa
- `siswa/layout.blade.php`: Layout khusus portal siswa
- `siswa/dashboard.blade.php`: Dashboard siswa
- `siswa/biodata.blade.php`: Halaman biodata lengkap
- `siswa/pembayaran.blade.php`: Halaman pembayaran
- `siswa/kartu-peserta.blade.php`: Template PDF kartu

### Routes
```php
// Login Portal Siswa
Route::get('/siswa/login', [SiswaController::class, 'showLogin']);
Route::post('/siswa/login', [SiswaController::class, 'login']);

// Portal Siswa (Protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/siswa/dashboard', [SiswaController::class, 'dashboard']);
    Route::get('/siswa/biodata', [SiswaController::class, 'biodata']);
    Route::get('/siswa/pembayaran', [SiswaController::class, 'pembayaran']);
    Route::get('/siswa/cetak-kartu', [SiswaController::class, 'cetakKartu']);
});
```

## 📄 Fitur Cetak Kartu PDF

### Template Kartu Peserta
- **Header**: Logo sekolah + info sekolah
- **Data Siswa**: Lengkap dengan foto placeholder
- **QR Code**: Untuk verifikasi digital
- **Footer**: Tanda tangan kepala sekolah
- **Catatan**: Instruksi penggunaan kartu

### PDF Features
- **Auto Download**: Langsung download saat akses
- **Filename**: `kartu-peserta-PPDB2025001.pdf`
- **Size**: A4 Portrait
- **Quality**: High resolution untuk print

## 🔐 Security Features

### Login System
- **Email Validation**: Cek email terdaftar di tabel pendaftar
- **Auto User Creation**: Buat user siswa otomatis jika belum ada
- **Role-based Access**: Hanya role 'siswa' yang bisa akses
- **Session Management**: Logout otomatis setelah idle

### Data Protection
- **User Isolation**: Siswa hanya bisa lihat data sendiri
- **Email Matching**: Data difilter berdasarkan email login
- **Secure Routes**: Semua route protected dengan middleware auth

## 🎨 UI/UX Features

### Design
- **Responsive**: Mobile-friendly design
- **Bootstrap 5**: Modern UI components
- **Font Awesome**: Professional icons
- **Color Scheme**: Consistent dengan tema sekolah

### Navigation
- **Navbar**: Menu dropdown dengan semua fitur
- **Breadcrumb**: Navigasi yang jelas
- **Back Button**: Tombol kembali di setiap halaman
- **Quick Actions**: Tombol aksi cepat di dashboard

## 📊 Integration

### Sistem Keuangan
- **Auto Integration**: Upload pembayaran langsung masuk keuangan
- **Status Sync**: Status pembayaran sinkron real-time
- **Notification**: Update status otomatis

### Database
- **Relasi**: Proper relationship antar tabel
- **Data Integrity**: Foreign key constraints
- **Performance**: Optimized queries dengan eager loading

## 🧪 Testing

### Test Data
```php
// User Siswa
Email: siswa@test.com
Password: siswa123
Role: siswa

// Data Pendaftar
No. Pendaftaran: PPDB2025001
Nama: Ahmad Siswa Test Lengkap
NISN: 1234567890
Jurusan: PPLG
```

### Test Scenarios
1. **Login Test**: Login dengan credentials siswa
2. **Dashboard Test**: Akses dashboard dan cek data
3. **Biodata Test**: Lihat biodata lengkap
4. **Pembayaran Test**: Upload bukti pembayaran
5. **PDF Test**: Generate dan download kartu peserta

## 🔧 Troubleshooting

### Common Issues
1. **Login Gagal**: Pastikan email terdaftar di tabel pendaftar
2. **PDF Error**: Install dompdf package
3. **Data Kosong**: Jalankan seeder database
4. **Route Error**: Clear cache aplikasi

### Debug Commands
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Check data
php artisan tinker
>>> App\Models\Pendaftar::where('email', 'siswa@test.com')->first();
```

## 📈 Benefits

### Untuk Siswa
- ✅ Portal khusus yang mudah digunakan
- ✅ Akses 24/7 untuk cek status
- ✅ Upload pembayaran mandiri
- ✅ Cetak kartu peserta sendiri
- ✅ Interface yang user-friendly

### Untuk Sekolah
- ✅ Mengurangi beban admin
- ✅ Proses pembayaran otomatis
- ✅ Data terintegrasi
- ✅ Laporan real-time
- ✅ Paperless system

---

**🎉 Portal Siswa Lengkap siap digunakan dengan semua fitur yang dibutuhkan!**
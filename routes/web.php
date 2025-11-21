<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\BulkActionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SiswaController;


// LOGIN
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (Protected)
Route::middleware(['auth', 'prevent.back'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Pendaftar Management
    Route::get('/admin/pendaftar', [AdminController::class, 'index'])->name('admin.pendaftar');
    Route::get('/admin/pendaftar/{id}', [AdminController::class, 'show'])->name('admin.show');
    Route::get('/admin/peta-pendaftar', [AdminController::class, 'petaPendaftar'])->name('admin.peta');
    Route::get('/admin/diterima', [AdminController::class, 'diterima'])->name('admin.diterima');
    Route::get('/admin/ditolak', [AdminController::class, 'ditolak'])->name('admin.ditolak');
    Route::get('/admin/cadangan', [AdminController::class, 'cadangan'])->name('admin.cadangan');
    
    // Jurusan Management
    Route::get('/admin/jurusan', [JurusanController::class, 'index'])->name('admin.jurusan');
    Route::post('/admin/jurusan/store', [JurusanController::class, 'store'])->name('admin.jurusan.store');
    Route::post('/admin/jurusan/update/{id}', [JurusanController::class, 'update'])->name('admin.jurusan.update');
    Route::delete('/admin/jurusan/delete/{id}', [JurusanController::class, 'destroy'])->name('admin.jurusan.delete');
    
    // User Management
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::post('/admin/users/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/delete/{id}', [UserController::class, 'destroy'])->name('admin.users.delete');
    
    // Gelombang Management
    Route::get('/admin/gelombang', [App\Http\Controllers\GelombangController::class, 'index'])->name('admin.gelombang');
    Route::post('/admin/gelombang/store', [App\Http\Controllers\GelombangController::class, 'store'])->name('admin.gelombang.store');
    Route::post('/admin/gelombang/update/{id}', [App\Http\Controllers\GelombangController::class, 'update'])->name('admin.gelombang.update');
    Route::delete('/admin/gelombang/delete/{id}', [App\Http\Controllers\GelombangController::class, 'destroy'])->name('admin.gelombang.delete');
    
    // Biaya Management
    Route::get('/admin/biaya', [App\Http\Controllers\BiayaController::class, 'index'])->name('admin.biaya');
    Route::post('/admin/biaya/update', [App\Http\Controllers\BiayaController::class, 'update'])->name('admin.biaya.update');
    
    // Wilayah Management
    Route::get('/admin/wilayah', [App\Http\Controllers\WilayahController::class, 'index'])->name('admin.wilayah');
    Route::post('/admin/wilayah/store', [App\Http\Controllers\WilayahController::class, 'store'])->name('admin.wilayah.store');
    Route::post('/admin/wilayah/update/{id}', [App\Http\Controllers\WilayahController::class, 'update'])->name('admin.wilayah.update');
    Route::delete('/admin/wilayah/delete/{id}', [App\Http\Controllers\WilayahController::class, 'destroy'])->name('admin.wilayah.delete');
    
    // Status Management
    Route::post('/admin/status/update/{pendaftar_id}', [App\Http\Controllers\StatusController::class, 'updateStatus'])->name('admin.status.update');
    Route::post('/admin/pendaftar/{id}/terima', [App\Http\Controllers\StatusController::class, 'terimaPendaftar'])->name('admin.pendaftar.terima');
    Route::post('/admin/pendaftar/{id}/tolak', [App\Http\Controllers\StatusController::class, 'tolakPendaftar'])->name('admin.pendaftar.tolak');
    Route::post('/admin/pendaftar/{id}/status-akhir', [AdminController::class, 'updateStatusAkhir'])->name('admin.pendaftar.status-akhir');
    
    // Dashboard Eksekutif (Kepala Sekolah/Yayasan)
    Route::get('/eksekutif/dashboard', [App\Http\Controllers\EksekutifController::class, 'dashboard'])->name('eksekutif.dashboard');
    
    // Reports & Export
    Route::get('/admin/export', [ReportController::class, 'exportExcel'])->name('admin.export');
    Route::get('/admin/reports', [ReportController::class, 'generateReport'])->name('admin.reports');
    
    // Settings
    Route::get('/admin/settings', [SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/admin/settings', [SettingsController::class, 'updateSettings'])->name('admin.settings.update');
    Route::post('/admin/backup', [SettingsController::class, 'backup'])->name('admin.backup');
    Route::post('/admin/clear-cache', [SettingsController::class, 'clearCache'])->name('admin.clear-cache');
    
    // Bulk Actions
    Route::post('/admin/bulk/update-status', [BulkActionController::class, 'bulkUpdateStatus'])->name('admin.bulk.update-status');
    Route::post('/admin/bulk/delete', [BulkActionController::class, 'bulkDelete'])->name('admin.bulk.delete');
    Route::post('/admin/bulk/export', [BulkActionController::class, 'bulkExport'])->name('admin.bulk.export');
    

    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications');
    Route::post('/notifications/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    
    // Verifikator Routes
    Route::get('/verifikator/dashboard', [App\Http\Controllers\VerifikatorController::class, 'dashboard'])->name('verifikator.dashboard');
    Route::get('/verifikator/pendaftar', [App\Http\Controllers\VerifikatorController::class, 'index'])->name('verifikator.pendaftar');
    Route::get('/verifikator/detail/{id}', [App\Http\Controllers\VerifikatorController::class, 'show'])->name('verifikator.detail');
    Route::post('/verifikator/verifikasi/{id}', [App\Http\Controllers\VerifikatorController::class, 'verifikasi'])->name('verifikator.verifikasi');
    Route::get('/verifikator/riwayat', [App\Http\Controllers\VerifikatorController::class, 'riwayat'])->name('verifikator.riwayat');
    Route::delete('/verifikator/riwayat/{id}', [App\Http\Controllers\VerifikatorController::class, 'deleteRiwayat'])->name('verifikator.riwayat.delete');
    
    // Pembayaran Management
    Route::get('/admin/pembayaran', [AdminController::class, 'pembayaran'])->name('admin.pembayaran');
    Route::post('/admin/pembayaran/verifikasi/{id}', [AdminController::class, 'pembayaranVerifikasi'])->name('admin.pembayaran.verifikasi');
    Route::get('/admin/pembayaran/cetak/{id}', [AdminController::class, 'cetakBuktiPembayaran'])->name('admin.pembayaran.cetak');
    
    // Keuangan Routes
    Route::middleware(['keuangan'])->group(function () {
        Route::get('/keuangan/dashboard', [App\Http\Controllers\KeuanganController::class, 'dashboard'])->name('keuangan.dashboard');
        Route::get('/keuangan/pembayaran', [App\Http\Controllers\KeuanganController::class, 'index'])->name('keuangan.pembayaran');
        Route::get('/keuangan/detail/{id}', [App\Http\Controllers\KeuanganController::class, 'show'])->name('keuangan.detail');
        Route::post('/keuangan/verifikasi/{id}', [App\Http\Controllers\KeuanganController::class, 'verifikasi'])->name('keuangan.verifikasi');
        Route::get('/keuangan/laporan', [App\Http\Controllers\KeuanganController::class, 'laporan'])->name('keuangan.laporan');
        Route::get('/keuangan/pembayaran/manual', [App\Http\Controllers\KeuanganController::class, 'manualPayment'])->name('keuangan.pembayaran.manual');
        Route::post('/keuangan/pembayaran/manual', [App\Http\Controllers\KeuanganController::class, 'storeManualPayment'])->name('keuangan.pembayaran.manual.store');
        Route::get('/keuangan/histori', [App\Http\Controllers\KeuanganController::class, 'histori'])->name('keuangan.histori');
        Route::delete('/keuangan/histori/{id}', [App\Http\Controllers\KeuanganController::class, 'deleteHistori'])->name('keuangan.histori.delete');
        Route::get('/keuangan/search-pendaftar', [App\Http\Controllers\KeuanganController::class, 'searchPendaftar']);
        Route::get('/keuangan/pembayaran/cetak/{id}', [AdminController::class, 'cetakBuktiPembayaran'])->name('keuangan.pembayaran.cetak');
    });
});
// ============================
// 1️⃣ Portal Pendaftar (Siswa)
// ============================
Route::get('/', function() {
    return view('welcome');
})->name('welcome');

Route::get('/home', function() {
    return view('welcome');
})->name('home');

// Registration with OTP
Route::get('/register', [App\Http\Controllers\RegistrationController::class, 'showRegister'])->name('register');
Route::post('/register', [App\Http\Controllers\RegistrationController::class, 'register'])->name('register.post');
Route::get('/verify-otp', [App\Http\Controllers\RegistrationController::class, 'showOtpForm'])->name('otp.verify.form');
Route::post('/verify-otp', [App\Http\Controllers\RegistrationController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/resend-otp', [App\Http\Controllers\RegistrationController::class, 'resendOtp'])->name('otp.resend');

// Registration flow info
Route::get('/alur-pendaftaran', function() {
    return view('info.registration-flow');
})->name('registration.flow');

// Test OTP (for development only)
Route::get('/test-otp/{email?}', [App\Http\Controllers\TestController::class, 'getLatestOtp']);

// Pendaftaran (requires verified email)
Route::get('/pendaftaran/create', [PendaftarController::class, 'create'])->middleware('verified.email')->name('pendaftaran.create');
Route::post('/pendaftaran/store', [PendaftarController::class, 'store'])->middleware('verified.email')->name('pendaftaran.store');
Route::get('/pendaftaran/status', [PendaftarController::class, 'status'])->name('pendaftaran.status');

// Cek Status
Route::get('/pendaftaran/cek-status', [PendaftarController::class, 'cekStatus'])->name('pendaftaran.cek');
Route::post('/pendaftaran/cek-status', [PendaftarController::class, 'cekStatusResult'])->name('pendaftaran.cek.result');

// Edit Data (hanya jika status SUBMIT)
Route::get('/pendaftaran/edit/{id}', [PendaftarController::class, 'edit'])->name('pendaftaran.edit');
Route::put('/pendaftaran/update/{id}', [PendaftarController::class, 'update'])->name('pendaftaran.update');

// Upload Berkas
Route::get('/pendaftaran/berkas/{pendaftar_id}', [App\Http\Controllers\BerkasController::class, 'index'])->name('berkas.index');
Route::post('/pendaftaran/berkas/{pendaftar_id}', [App\Http\Controllers\BerkasController::class, 'store'])->name('berkas.store');
Route::delete('/berkas/{id}', [App\Http\Controllers\BerkasController::class, 'destroy'])->name('berkas.destroy');

// Pembayaran
Route::get('/pendaftaran/pembayaran/{pendaftar_id}', [App\Http\Controllers\PembayaranController::class, 'index'])->name('pembayaran.index');
Route::post('/pendaftaran/pembayaran/{pendaftar_id}', [App\Http\Controllers\PembayaranController::class, 'uploadBukti'])->name('pembayaran.upload');

// Siswa Portal Routes
Route::get('/siswa/login', [SiswaController::class, 'showLogin'])->name('siswa.login');
Route::post('/siswa/login', [SiswaController::class, 'login'])->name('siswa.login.post');
Route::get('/siswa/logout', [SiswaController::class, 'logout'])->name('siswa.logout');

Route::middleware(['auth', 'prevent.back'])->group(function () {
    Route::get('/siswa/dashboard', [SiswaController::class, 'profil'])->name('siswa.dashboard');
    Route::get('/siswa/profil', [SiswaController::class, 'profil'])->name('siswa.profil');
    Route::get('/siswa/timeline', [SiswaController::class, 'timeline'])->name('siswa.timeline');
    Route::get('/siswa/biodata', [SiswaController::class, 'biodata'])->name('siswa.biodata');
    Route::get('/siswa/pembayaran', [SiswaController::class, 'pembayaran'])->name('siswa.pembayaran');
    Route::post('/siswa/upload-pembayaran', [SiswaController::class, 'uploadPembayaran'])->name('siswa.upload-pembayaran');
    Route::get('/siswa/cetak-kartu', [SiswaController::class, 'cetakKartu'])->name('siswa.cetak-kartu');
    Route::get('/siswa/cetak-bukti-pembayaran', [SiswaController::class, 'cetakBuktiPembayaran'])->name('siswa.cetak-bukti-pembayaran');
    Route::get('/siswa/perbaikan-berkas', [SiswaController::class, 'perbaikanBerkas'])->name('siswa.perbaikan-berkas');
    Route::post('/siswa/perbaikan-berkas', [SiswaController::class, 'perbaikanBerkasStore'])->name('siswa.perbaikan-berkas.store');
});



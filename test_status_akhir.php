<?php

require_once 'vendor/autoload.php';

use App\Models\Pendaftar;
use App\Models\PendaftarDataSiswa;
use App\Models\Pembayaran;
use App\Models\Jurusan;
use App\Models\Gelombang;
use Illuminate\Support\Facades\DB;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🧪 TEST FITUR STATUS AKHIR ADMIN\n";
echo "================================\n\n";

try {
    $jurusan = Jurusan::first();
    $gelombang = Gelombang::first();
    
    if (!$jurusan || !$gelombang) {
        echo "❌ Jalankan DatabaseSeeder dulu!\n";
        exit;
    }
    
    // Buat pendaftar dengan status TERBAYAR (siap untuk status akhir)
    $noPendaftaran = 'ADMIN001';
    
    // Hapus jika sudah ada
    Pendaftar::where('no_pendaftaran', $noPendaftaran)->delete();
    
    $pendaftar = Pendaftar::create([
        'no_pendaftaran' => $noPendaftaran,
        'email' => 'admin.test@test.com',
        'gelombang_id' => $gelombang->id,
        'jurusan_id' => $jurusan->id,
        'status' => 'TERBAYAR'
    ]);
    
    PendaftarDataSiswa::create([
        'pendaftar_id' => $pendaftar->id,
        'nama' => 'Test Admin Status',
        'nik' => '3201000000000001',
        'nisn' => '0000000001',
        'jk' => 'L',
        'tmp_lahir' => 'Jakarta',
        'tgl_lahir' => '2008-01-01',
        'agama' => 'Islam',
        'alamat' => 'Alamat Test Admin'
    ]);
    
    // Buat pembayaran verified
    Pembayaran::create([
        'pendaftar_id' => $pendaftar->id,
        'nominal' => $gelombang->biaya_daftar,
        'metode_pembayaran' => 'transfer',
        'bukti_bayar' => 'pembayaran/test_admin.jpg',
        'status' => 'verified',
        'tanggal_bayar' => now()->subDays(5),
        'verified_at' => now()->subDays(3),
        'verified_by' => 1
    ]);
    
    echo "✅ Pendaftar test berhasil dibuat:\n";
    echo "   - No. Pendaftaran: {$noPendaftaran}\n";
    echo "   - Status: {$pendaftar->status}\n";
    echo "   - Pembayaran: verified\n\n";
    
    echo "🎯 CARA TEST FITUR STATUS AKHIR:\n";
    echo "================================\n";
    echo "1. Login sebagai admin: admin@smk.com / admin123\n";
    echo "2. Buka menu 'Pendaftar'\n";
    echo "3. Klik 'Lihat Detail' pada pendaftar {$noPendaftaran}\n";
    echo "4. Scroll ke bawah, cari tombol 'Tentukan Status Akhir'\n";
    echo "5. Klik tombol tersebut\n";
    echo "6. Pilih status: LULUS / TIDAK_LULUS / CADANGAN\n";
    echo "7. Isi keterangan (opsional)\n";
    echo "8. Klik 'Simpan Status'\n\n";
    
    echo "✅ FITUR YANG HARUS JALAN:\n";
    echo "=========================\n";
    echo "- Tombol 'Tentukan Status Akhir' muncul\n";
    echo "- Modal terbuka dengan form\n";
    echo "- Validasi kuota jurusan\n";
    echo "- Status berubah setelah submit\n";
    echo "- Timeline status ter-update\n";
    echo "- Dashboard statistik ter-update\n\n";
    
    echo "🔍 CEK HASIL:\n";
    echo "=============\n";
    echo "- Status pendaftar berubah di detail\n";
    echo "- Dashboard admin menampilkan angka baru\n";
    echo "- Statistik 'Diterima/Ditolak/Cadangan' bertambah\n\n";
    
    echo "🎉 Test data siap! Silakan test fitur status akhir.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
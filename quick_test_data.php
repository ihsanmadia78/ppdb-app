<?php

require_once 'vendor/autoload.php';

use App\Models\Pendaftar;
use App\Models\PendaftarDataSiswa;
use App\Models\Jurusan;
use App\Models\Gelombang;
use Illuminate\Support\Facades\DB;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "⚡ QUICK TEST DATA UNTUK DASHBOARD\n";
echo "=================================\n\n";

try {
    $jurusan = Jurusan::first();
    $gelombang = Gelombang::first();
    
    if (!$jurusan || !$gelombang) {
        echo "❌ Jalankan DatabaseSeeder dulu!\n";
        exit;
    }
    
    // Buat 10 pendaftar cepat dengan status berbeda
    $statusList = ['SUBMIT', 'LULUS', 'TIDAK_LULUS', 'CADANGAN', 'TERBAYAR', 'MENUNGGU_PEMBAYARAN'];
    
    for ($i = 1; $i <= 10; $i++) {
        $noPendaftaran = 'TEST' . str_pad($i, 4, '0', STR_PAD_LEFT);
        
        // Cek apakah sudah ada
        if (Pendaftar::where('no_pendaftaran', $noPendaftaran)->exists()) {
            continue;
        }
        
        $pendaftar = Pendaftar::create([
            'no_pendaftaran' => $noPendaftaran,
            'email' => 'test' . $i . '@test.com',
            'gelombang_id' => $gelombang->id,
            'jurusan_id' => $jurusan->id,
            'status' => $statusList[($i - 1) % count($statusList)]
        ]);
        
        PendaftarDataSiswa::create([
            'pendaftar_id' => $pendaftar->id,
            'nama' => 'Test Siswa ' . $i,
            'nik' => '320100000000' . str_pad($i, 2, '0', STR_PAD_LEFT),
            'nisn' => '000000000' . $i,
            'jk' => $i % 2 == 0 ? 'L' : 'P',
            'tmp_lahir' => 'Jakarta',
            'tgl_lahir' => '2008-01-01',
            'agama' => 'Islam',
            'alamat' => 'Alamat Test ' . $i
        ]);
        
        echo "✅ {$noPendaftaran}: {$pendaftar->status}\n";
    }
    
    // Tampilkan statistik
    echo "\n📊 STATISTIK SEKARANG:\n";
    echo "======================\n";
    echo "Total Pendaftar: " . Pendaftar::count() . "\n";
    echo "Diterima: " . Pendaftar::where('status', 'LULUS')->count() . "\n";
    echo "Ditolak: " . Pendaftar::where('status', 'TIDAK_LULUS')->count() . "\n";
    echo "Cadangan: " . Pendaftar::where('status', 'CADANGAN')->count() . "\n";
    echo "Menunggu: " . Pendaftar::whereNotIn('status', ['LULUS', 'TIDAK_LULUS', 'CADANGAN'])->count() . "\n";
    
    echo "\n🎉 Data test berhasil dibuat! Refresh dashboard admin.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
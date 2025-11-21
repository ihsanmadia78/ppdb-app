<?php

require_once 'vendor/autoload.php';

use App\Models\Pendaftar;
use App\Models\PendaftarDataSiswa;
use App\Models\Pembayaran;
use App\Models\PendaftarStatus;
use App\Models\Jurusan;
use App\Models\Gelombang;
use Illuminate\Support\Facades\DB;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🎯 POPULATE DATA UNTUK FITUR ADMIN\n";
echo "==================================\n\n";

DB::beginTransaction();

try {
    // 1. Buat data pendaftar dummy jika belum ada
    $totalPendaftar = Pendaftar::count();
    
    if ($totalPendaftar < 20) {
        echo "1️⃣ Membuat data pendaftar dummy...\n";
        
        $jurusan = Jurusan::all();
        $gelombang = Gelombang::first();
        
        $namaList = [
            'Ahmad Rizki', 'Siti Nurhaliza', 'Budi Santoso', 'Dewi Sartika', 'Eko Prasetyo',
            'Fitri Handayani', 'Gilang Ramadhan', 'Hana Pertiwi', 'Indra Gunawan', 'Joko Widodo',
            'Kartika Sari', 'Lukman Hakim', 'Maya Sari', 'Nanda Pratama', 'Oki Setiana',
            'Putri Ayu', 'Qori Sumantri', 'Rina Susanti', 'Sandi Permana', 'Tina Marlina'
        ];
        
        $sekolahList = [
            'SMP Negeri 1 Jakarta', 'SMP Negeri 2 Bogor', 'SMP Swasta Al-Azhar',
            'SMP Negeri 5 Depok', 'SMP Muhammadiyah 1', 'SMP Negeri 3 Tangerang'
        ];
        
        for ($i = 0; $i < 20; $i++) {
            $noPendaftaran = 'PPDB' . date('Y') . str_pad($i + 1, 4, '0', STR_PAD_LEFT);
            
            // Buat pendaftar
            $pendaftar = Pendaftar::create([
                'no_pendaftaran' => $noPendaftaran,
                'email' => 'siswa' . ($i + 1) . '@test.com',
                'gelombang_id' => $gelombang->id,
                'jurusan_id' => $jurusan->random()->id,
                'status' => 'SUBMIT'
            ]);
            
            // Buat data siswa
            PendaftarDataSiswa::create([
                'pendaftar_id' => $pendaftar->id,
                'nama' => $namaList[$i],
                'nik' => '3201' . str_pad($i + 1, 12, '0', STR_PAD_LEFT),
                'nisn' => '0' . str_pad($i + 1, 9, '0', STR_PAD_LEFT),
                'jk' => $i % 2 == 0 ? 'L' : 'P',
                'tmp_lahir' => 'Jakarta',
                'tgl_lahir' => '2008-' . str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT) . '-' . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT),
                'agama' => 'Islam',
                'alamat' => 'Jl. Contoh No. ' . ($i + 1) . ', Jakarta',
                'nama_sekolah_asal' => $sekolahList[array_rand($sekolahList)],
                'nilai_rata_rata' => rand(75, 95) + (rand(0, 99) / 100),
                'nama_ayah' => 'Ayah ' . $namaList[$i],
                'nama_ibu' => 'Ibu ' . $namaList[$i],
                'hp_ayah' => '081' . rand(100000000, 999999999),
                'hp_ibu' => '082' . rand(100000000, 999999999)
            ]);
            
            echo "   ✅ {$noPendaftaran}: {$namaList[$i]}\n";
        }
        
        echo "   📊 Total: 20 pendaftar dummy dibuat\n\n";
    } else {
        echo "1️⃣ Data pendaftar sudah cukup ({$totalPendaftar} pendaftar)\n\n";
    }
    
    // 2. Set status yang bervariasi
    echo "2️⃣ Mengatur status pendaftar yang bervariasi...\n";
    
    $pendaftarList = Pendaftar::all();
    $statusList = ['SUBMIT', 'VERIFIKASI_ADMIN', 'MENUNGGU_PEMBAYARAN', 'TERBAYAR', 'LULUS', 'TIDAK_LULUS', 'CADANGAN'];
    
    foreach ($pendaftarList as $index => $pendaftar) {
        $status = $statusList[$index % count($statusList)];
        $pendaftar->update(['status' => $status]);
        
        // Buat timeline status
        PendaftarStatus::updateOrCreate([
            'pendaftar_id' => $pendaftar->id,
            'status' => $status
        ], [
            'keterangan' => 'Status diset untuk demo: ' . $status,
            'created_by' => 1
        ]);
    }
    
    echo "   ✅ Status pendaftar berhasil divariasikan\n\n";
    
    // 3. Buat data pembayaran
    echo "3️⃣ Membuat data pembayaran...\n";
    
    $pendaftarBayar = Pendaftar::whereIn('status', ['MENUNGGU_PEMBAYARAN', 'TERBAYAR', 'LULUS'])->get();
    
    foreach ($pendaftarBayar as $pendaftar) {
        $pembayaran = Pembayaran::updateOrCreate([
            'pendaftar_id' => $pendaftar->id
        ], [
            'nominal' => $pendaftar->gelombang->biaya_daftar ?? 150000,
            'metode_pembayaran' => ['transfer', 'va', 'qris'][array_rand(['transfer', 'va', 'qris'])],
            'bukti_bayar' => 'pembayaran/dummy_' . $pendaftar->no_pendaftaran . '.jpg',
            'status' => in_array($pendaftar->status, ['TERBAYAR', 'LULUS']) ? 'verified' : 'paid',
            'tanggal_bayar' => now()->subDays(rand(1, 30)),
            'verified_at' => in_array($pendaftar->status, ['TERBAYAR', 'LULUS']) ? now()->subDays(rand(1, 15)) : null,
            'verified_by' => in_array($pendaftar->status, ['TERBAYAR', 'LULUS']) ? 1 : null
        ]);
        
        echo "   💳 {$pendaftar->no_pendaftaran}: {$pembayaran->status}\n";
    }
    
    echo "   📊 Data pembayaran berhasil dibuat\n\n";
    
    DB::commit();
    
    // 4. Tampilkan statistik final
    echo "📊 STATISTIK FINAL:\n";
    echo "==================\n";
    
    $stats = [
        'Total Pendaftar' => Pendaftar::count(),
        'Diterima (LULUS)' => Pendaftar::where('status', 'LULUS')->count(),
        'Cadangan' => Pendaftar::where('status', 'CADANGAN')->count(),
        'Ditolak (TIDAK_LULUS)' => Pendaftar::where('status', 'TIDAK_LULUS')->count(),
        'Menunggu Proses' => Pendaftar::whereNotIn('status', ['LULUS', 'TIDAK_LULUS', 'CADANGAN'])->count(),
        'Total Pembayaran' => Pembayaran::count(),
        'Pembayaran Verified' => Pembayaran::where('status', 'verified')->count(),
        'Pembayaran Paid' => Pembayaran::where('status', 'paid')->count()
    ];
    
    foreach ($stats as $label => $count) {
        echo "{$label}: {$count}\n";
    }
    
    echo "\n🎉 SEMUA FITUR ADMIN SIAP DIGUNAKAN!\n";
    echo "===================================\n";
    echo "✅ Dashboard dengan statistik lengkap\n";
    echo "✅ Data pendaftar dengan status bervariasi\n";
    echo "✅ Data pembayaran untuk testing\n";
    echo "✅ Chart dan grafik akan menampilkan data\n";
    echo "✅ Export akan menghasilkan file dengan data\n";
    echo "✅ Semua fitur admin sudah memiliki data\n\n";
    
    echo "🔑 Login admin: admin@smk.com / admin123\n";
    
} catch (Exception $e) {
    DB::rollback();
    echo "❌ Error: " . $e->getMessage() . "\n";
}
<?php

require_once 'vendor/autoload.php';

use App\Models\Pendaftar;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔄 SINKRONISASI DATA PEMBAYARAN\n";
echo "===============================\n\n";

DB::beginTransaction();

try {
    // 1. Ambil semua pendaftar
    $pendaftar = Pendaftar::with(['gelombang', 'dataSiswa'])->get();
    
    echo "📊 Total pendaftar: " . $pendaftar->count() . "\n\n";
    
    $created = 0;
    $updated = 0;
    
    foreach ($pendaftar as $p) {
        // Cek apakah sudah ada pembayaran
        $pembayaran = Pembayaran::where('pendaftar_id', $p->id)->first();
        
        if (!$pembayaran) {
            // Buat pembayaran baru dengan status 'paid' (simulasi sudah bayar)
            Pembayaran::create([
                'pendaftar_id' => $p->id,
                'nominal' => $p->gelombang->biaya_daftar ?? 150000,
                'metode_pembayaran' => 'transfer',
                'bukti_bayar' => 'pembayaran/bukti_' . $p->no_pendaftaran . '.jpg',
                'status' => 'paid',
                'tanggal_bayar' => now()->subDays(rand(1, 7))
            ]);
            
            $created++;
            echo "✅ Dibuat: {$p->no_pendaftaran} - {$p->dataSiswa->nama ?? 'Nama kosong'}\n";
        } else {
            // Update pembayaran yang ada agar status 'paid'
            if ($pembayaran->status == 'pending') {
                $pembayaran->update([
                    'status' => 'paid',
                    'metode_pembayaran' => 'transfer',
                    'bukti_bayar' => 'pembayaran/bukti_' . $p->no_pendaftaran . '.jpg',
                    'tanggal_bayar' => now()->subDays(rand(1, 7))
                ]);
                
                $updated++;
                echo "🔄 Diupdate: {$p->no_pendaftaran} - {$p->dataSiswa->nama ?? 'Nama kosong'}\n";
            }
        }
    }
    
    DB::commit();
    
    echo "\n📈 HASIL SINKRONISASI:\n";
    echo "=====================\n";
    echo "Pembayaran dibuat: {$created}\n";
    echo "Pembayaran diupdate: {$updated}\n";
    
    // Tampilkan statistik
    $totalPaid = Pembayaran::where('status', 'paid')->count();
    echo "Total status 'paid': {$totalPaid}\n\n";
    
    echo "✅ Sinkronisasi selesai! Cek dashboard keuangan.\n";
    
} catch (Exception $e) {
    DB::rollback();
    echo "❌ Error: " . $e->getMessage() . "\n";
}
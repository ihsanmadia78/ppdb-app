<?php

require_once 'vendor/autoload.php';

use App\Models\Pendaftar;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔧 SETUP ALUR PEMBAYARAN PPDB\n";
echo "=============================\n\n";

DB::beginTransaction();

try {
    // 1. Buat record pembayaran untuk semua pendaftar yang belum punya
    $pendaftarTanpaPembayaran = Pendaftar::whereDoesntHave('pembayaran')->get();
    
    echo "1️⃣ Membuat record pembayaran untuk {$pendaftarTanpaPembayaran->count()} pendaftar...\n";
    
    foreach ($pendaftarTanpaPembayaran as $pendaftar) {
        Pembayaran::create([
            'pendaftar_id' => $pendaftar->id,
            'nominal' => $pendaftar->gelombang->biaya_daftar ?? 150000,
            'status' => 'pending' // Status awal: belum bayar
        ]);
        
        echo "   📋 {$pendaftar->no_pendaftaran}: Record pembayaran dibuat\n";
    }
    
    // 2. Simulasi beberapa siswa sudah upload bukti pembayaran
    echo "\n2️⃣ Simulasi siswa upload bukti pembayaran...\n";
    
    $pendaftarUntukSimulasi = Pendaftar::with('pembayaran')->take(3)->get();
    
    foreach ($pendaftarUntukSimulasi as $pendaftar) {
        if ($pendaftar->pembayaran) {
            $pendaftar->pembayaran->update([
                'metode_pembayaran' => 'transfer',
                'bukti_bayar' => 'pembayaran/bukti_' . $pendaftar->no_pendaftaran . '.jpg',
                'status' => 'paid',
                'tanggal_bayar' => now()->subHours(rand(1, 24))
            ]);
            
            $pendaftar->update(['status' => 'MENUNGGU_VERIFIKASI_KEUANGAN']);
            
            echo "   💳 {$pendaftar->no_pendaftaran}: Simulasi upload bukti pembayaran\n";
        }
    }
    
    DB::commit();
    
    // 3. Tampilkan statistik
    echo "\n📊 STATISTIK PEMBAYARAN:\n";
    echo "========================\n";
    
    $totalPendaftar = Pendaftar::count();
    $statusPending = Pembayaran::where('status', 'pending')->count();
    $statusPaid = Pembayaran::where('status', 'paid')->count();
    $statusVerified = Pembayaran::where('status', 'verified')->count();
    
    echo "Total Pendaftar: {$totalPendaftar}\n";
    echo "Belum Bayar (pending): {$statusPending}\n";
    echo "Sudah Upload Bukti (paid): {$statusPaid}\n";
    echo "Sudah Diverifikasi (verified): {$statusVerified}\n\n";
    
    echo "✅ Setup selesai! Sekarang:\n";
    echo "   - Siswa yang upload bukti akan langsung muncul di keuangan\n";
    echo "   - Status pembayaran akan ter-update otomatis\n";
    echo "   - Petugas keuangan bisa langsung verifikasi\n";
    
} catch (Exception $e) {
    DB::rollback();
    echo "❌ Error: " . $e->getMessage() . "\n";
}
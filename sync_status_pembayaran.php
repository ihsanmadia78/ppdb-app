<?php

require_once 'vendor/autoload.php';

use App\Models\Pendaftar;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔄 SINKRONISASI STATUS PEMBAYARAN\n";
echo "=================================\n\n";

DB::beginTransaction();

try {
    // Update status pendaftar berdasarkan status pembayaran
    $pembayaranPaid = Pembayaran::where('status', 'paid')->get();
    $pembayaranVerified = Pembayaran::where('status', 'verified')->get();
    
    $updatedPaid = 0;
    $updatedVerified = 0;
    
    // Update pendaftar dengan pembayaran status 'paid'
    foreach ($pembayaranPaid as $pembayaran) {
        $pendaftar = $pembayaran->pendaftar;
        if ($pendaftar && $pendaftar->status != 'MENUNGGU_VERIFIKASI_KEUANGAN') {
            $pendaftar->update(['status' => 'MENUNGGU_VERIFIKASI_KEUANGAN']);
            $updatedPaid++;
            echo "📋 {$pendaftar->no_pendaftaran}: Status → MENUNGGU_VERIFIKASI_KEUANGAN\n";
        }
    }
    
    // Update pendaftar dengan pembayaran status 'verified'
    foreach ($pembayaranVerified as $pembayaran) {
        $pendaftar = $pembayaran->pendaftar;
        if ($pendaftar && $pendaftar->status != 'TERBAYAR') {
            $pendaftar->update(['status' => 'TERBAYAR']);
            $updatedVerified++;
            echo "✅ {$pendaftar->no_pendaftaran}: Status → TERBAYAR\n";
        }
    }
    
    DB::commit();
    
    echo "\n📊 HASIL SINKRONISASI:\n";
    echo "=====================\n";
    echo "Status 'MENUNGGU_VERIFIKASI_KEUANGAN': {$updatedPaid}\n";
    echo "Status 'TERBAYAR': {$updatedVerified}\n\n";
    
    echo "✅ Sinkronisasi selesai! Status siswa sudah sesuai dengan pembayaran.\n";
    
} catch (Exception $e) {
    DB::rollback();
    echo "❌ Error: " . $e->getMessage() . "\n";
}
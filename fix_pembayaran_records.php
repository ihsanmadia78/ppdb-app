<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use App\Models\Pendaftar;
use App\Models\Pembayaran;

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔧 Memperbaiki record pembayaran yang hilang...\n\n";

try {
    // Ambil semua pendaftar yang belum memiliki record pembayaran
    $pendaftarTanpaPembayaran = Pendaftar::whereDoesntHave('pembayaran')->get();
    
    echo "📊 Ditemukan " . $pendaftarTanpaPembayaran->count() . " pendaftar tanpa record pembayaran\n\n";
    
    $created = 0;
    
    foreach ($pendaftarTanpaPembayaran as $pendaftar) {
        // Buat record pembayaran untuk setiap pendaftar
        $biayaDaftar = $pendaftar->gelombang->biaya_daftar ?? 150000;
        
        Pembayaran::create([
            'pendaftar_id' => $pendaftar->id,
            'nominal' => $biayaDaftar,
            'status' => 'pending'
        ]);
        
        $created++;
        echo "✅ Record pembayaran dibuat untuk: {$pendaftar->no_pendaftaran} - {$pendaftar->dataSiswa->nama ?? 'Nama tidak tersedia'}\n";
    }
    
    echo "\n🎉 Selesai! {$created} record pembayaran berhasil dibuat.\n";
    
    // Cek pendaftar yang mungkin sudah upload bukti tapi statusnya masih pending
    echo "\n🔍 Mencari pendaftar dengan bukti pembayaran tapi status masih pending...\n";
    
    $pembayaranPending = Pembayaran::where('status', 'pending')
                                  ->whereNotNull('bukti_bayar')
                                  ->get();
    
    if ($pembayaranPending->count() > 0) {
        echo "📊 Ditemukan " . $pembayaranPending->count() . " pembayaran dengan bukti tapi status pending\n\n";
        
        foreach ($pembayaranPending as $pembayaran) {
            $pembayaran->update(['status' => 'paid']);
            echo "🔄 Status diubah ke 'paid' untuk: {$pembayaran->pendaftar->no_pendaftaran}\n";
        }
    } else {
        echo "✅ Tidak ada pembayaran dengan status yang perlu diperbaiki\n";
    }
    
    echo "\n✨ Semua perbaikan selesai!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
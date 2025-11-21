<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔧 PERBAIKAN KOLOM STATUS\n";
echo "========================\n\n";

try {
    // Cek struktur kolom status saat ini
    $columns = DB::select("SHOW COLUMNS FROM pendaftar LIKE 'status'");
    
    if (!empty($columns)) {
        $currentType = $columns[0]->Type;
        echo "Tipe kolom status saat ini: {$currentType}\n";
        
        // Ubah kolom status menjadi VARCHAR yang lebih panjang
        DB::statement("ALTER TABLE pendaftar MODIFY COLUMN status VARCHAR(50) DEFAULT 'SUBMIT'");
        
        echo "✅ Kolom status berhasil diperbesar menjadi VARCHAR(50)\n\n";
        
        // Tampilkan status yang valid
        echo "📋 Status yang bisa digunakan:\n";
        echo "- SUBMIT\n";
        echo "- VERIFIKASI_ADMIN\n";
        echo "- MENUNGGU_PEMBAYARAN\n";
        echo "- MENUNGGU_VERIFIKASI_KEUANGAN\n";
        echo "- TERBAYAR\n";
        echo "- VERIFIKASI_KEUANGAN\n";
        echo "- LULUS\n";
        echo "- TIDAK_LULUS\n\n";
        
        echo "✅ Perbaikan selesai! Sekarang upload bukti pembayaran akan berfungsi.\n";
        
    } else {
        echo "❌ Kolom status tidak ditemukan\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
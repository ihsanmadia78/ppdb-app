<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔧 MENAMBAHKAN KOLOM KUOTA JURUSAN\n";
echo "==================================\n\n";

try {
    // Cek apakah kolom kuota sudah ada
    $hasKuota = DB::select("SHOW COLUMNS FROM jurusan LIKE 'kuota'");
    
    if (empty($hasKuota)) {
        // Tambah kolom kuota
        DB::statement("ALTER TABLE jurusan ADD COLUMN kuota INT DEFAULT 50 AFTER nama");
        echo "✅ Kolom kuota berhasil ditambahkan ke tabel jurusan\n";
        
        // Update kuota default untuk semua jurusan
        DB::table('jurusan')->update(['kuota' => 50]);
        echo "✅ Kuota default (50) telah diset untuk semua jurusan\n";
    } else {
        echo "✅ Kolom kuota sudah ada di tabel jurusan\n";
    }
    
    // Tampilkan data jurusan dengan kuota
    $jurusan = DB::table('jurusan')->select('kode', 'nama', 'kuota')->get();
    
    echo "\n📊 DATA JURUSAN DAN KUOTA:\n";
    echo "==========================\n";
    foreach ($jurusan as $j) {
        echo "- {$j->kode}: {$j->nama} (Kuota: {$j->kuota})\n";
    }
    
    echo "\n✅ Setup kuota jurusan selesai!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
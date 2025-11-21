<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Buat data pendaftar untuk siswa test
    $pendaftar_id = DB::table('pendaftar')->insertGetId([
        'no_pendaftaran' => 'PPDB2025001',
        'nama' => 'Siswa Test',
        'email' => 'siswa@test.com',
        'jurusan_id' => 1, // PPLG
        'gelombang_id' => 1, // Gelombang 1
        'status' => 'SUBMIT',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    // Buat data siswa detail
    DB::table('pendaftar_data_siswa')->insert([
        'pendaftar_id' => $pendaftar_id,
        'nama_lengkap' => 'Siswa Test Lengkap',
        'nisn' => '1234567890',
        'tempat_lahir' => 'Jakarta',
        'tanggal_lahir' => '2007-01-01',
        'jenis_kelamin' => 'L',
        'alamat' => 'Jl. Test No. 123',
        'no_hp' => '081234567890',
        'asal_sekolah' => 'SMP Test',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    echo "✅ Data siswa test berhasil dibuat!\n";
    echo "📧 Email: siswa@test.com\n";
    echo "🔑 Password: siswa123\n";
    echo "📝 No. Pendaftaran: PPDB2025001\n";
    echo "\n🔗 Login di: http://localhost/ppdb-app/public/login\n";
    echo "🔗 Portal Siswa: http://localhost/ppdb-app/public/siswa/dashboard\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
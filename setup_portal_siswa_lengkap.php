<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

// Load Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "🚀 Setup Portal Siswa Lengkap...\n\n";

    // 1. Buat data pendaftar untuk siswa test
    echo "1. Membuat data pendaftar siswa...\n";
    
    // Hapus data lama jika ada
    DB::table('pendaftar')->where('email', 'siswa@test.com')->delete();
    DB::table('users')->where('email', 'siswa@test.com')->delete();

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

    // 2. Buat data siswa detail lengkap
    echo "2. Membuat data siswa detail...\n";
    DB::table('pendaftar_data_siswa')->insert([
        'pendaftar_id' => $pendaftar_id,
        'nama_lengkap' => 'Ahmad Siswa Test Lengkap',
        'nisn' => '1234567890',
        'tempat_lahir' => 'Bandung',
        'tanggal_lahir' => '2007-05-15',
        'jenis_kelamin' => 'L',
        'alamat' => 'Jl. Raya Test No. 123, Bandung',
        'no_hp' => '081234567890',
        'asal_sekolah' => 'SMP Negeri 1 Bandung',
        'nama_ayah' => 'Bapak Test',
        'nama_ibu' => 'Ibu Test',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    // 3. Buat user siswa
    echo "3. Membuat user siswa...\n";
    DB::table('users')->insert([
        'name' => 'Ahmad Siswa Test',
        'email' => 'siswa@test.com',
        'password' => Hash::make('siswa123'),
        'role' => 'siswa',
        'created_at' => now(),
        'updated_at' => now()
    ]);

    // 4. Buat data pembayaran sample
    echo "4. Membuat data pembayaran sample...\n";
    DB::table('pembayaran')->insert([
        'pendaftar_id' => $pendaftar_id,
        'nominal' => 5000000,
        'metode_pembayaran' => 'transfer',
        'status' => 'paid',
        'tanggal_bayar' => now(),
        'created_at' => now(),
        'updated_at' => now()
    ]);

    echo "\n✅ Setup Portal Siswa Lengkap Berhasil!\n";
    echo "==========================================\n";
    echo "📧 Email: siswa@test.com\n";
    echo "🔑 Password: siswa123\n";
    echo "📝 No. Pendaftaran: PPDB2025001\n";
    echo "👤 Nama: Ahmad Siswa Test Lengkap\n";
    echo "🎓 Jurusan: PPLG\n";
    echo "📅 Gelombang: Gelombang 1\n";
    echo "\n🔗 URL Portal Siswa:\n";
    echo "- Login: http://localhost/ppdb-app/public/siswa/login\n";
    echo "- Dashboard: http://localhost/ppdb-app/public/siswa/dashboard\n";
    echo "- Biodata: http://localhost/ppdb-app/public/siswa/biodata\n";
    echo "- Pembayaran: http://localhost/ppdb-app/public/siswa/pembayaran\n";
    echo "- Cetak Kartu: http://localhost/ppdb-app/public/siswa/cetak-kartu\n";
    echo "\n🎯 Fitur Portal Siswa:\n";
    echo "✅ Login terpisah untuk calon siswa\n";
    echo "✅ Dashboard dengan status pendaftaran\n";
    echo "✅ Halaman biodata lengkap\n";
    echo "✅ Upload bukti pembayaran\n";
    echo "✅ Cetak kartu peserta ke PDF\n";
    echo "✅ Integrasi dengan sistem keuangan\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Pendaftar;
use App\Models\PendaftarDataSiswa;

// Simulasi pendaftar baru dengan koordinat
$pendaftar = Pendaftar::create([
    'no_pendaftaran' => 'PPDB' . date('YmdHis') . 'TEST',
    'email' => 'test.koordinat@example.com',
    'gelombang_id' => 1,
    'jurusan_id' => 1,
    'status' => 'SUBMIT'
]);

PendaftarDataSiswa::create([
    'pendaftar_id' => $pendaftar->id,
    'nama' => 'Test Koordinat Siswa',
    'nik' => '1234567890123456',
    'nisn' => 'TEST123456',
    'jk' => 'L',
    'tmp_lahir' => 'Yogyakarta',
    'tgl_lahir' => '2007-06-15',
    'alamat' => 'Jl. Test Koordinat No. 123, Yogyakarta',
    'nama_ayah' => 'Bapak Test',
    'nama_ibu' => 'Ibu Test',
    'nama_sekolah_asal' => 'SMP Test Yogyakarta',
    'lat' => -7.797068,  // Koordinat Yogyakarta
    'lng' => 110.370529,
    'provinsi' => 'DI Yogyakarta',
    'kabupaten' => 'Yogyakarta',
    'kecamatan' => 'Gondokusuman',
    'kelurahan' => 'Terban'
]);

echo "Test pendaftar created with coordinates: -7.797068, 110.370529 (Yogyakarta)\n";
echo "Pendaftar ID: {$pendaftar->id}\n";
echo "No. Pendaftaran: {$pendaftar->no_pendaftaran}\n";

// Cek total pendaftar dengan koordinat
$total = Pendaftar::whereHas('dataSiswa', function($q) {
    $q->whereNotNull('lat')->whereNotNull('lng')->where('lat', '!=', 0)->where('lng', '!=', 0);
})->count();

echo "Total pendaftar dengan koordinat: {$total}\n";
?>
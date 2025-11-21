<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pendaftar;
use App\Models\PendaftarDataSiswa;

class PendaftarWithCoordinatesSeeder extends Seeder
{
    public function run(): void
    {
        // Sample data dengan koordinat berbeda-beda
        $sampleData = [
            [
                'pendaftar' => [
                    'no_pendaftaran' => 'PPDB' . date('Ymd') . '001',
                    'email' => 'siswa1@test.com',
                    'gelombang_id' => 1,
                    'jurusan_id' => 1,
                    'status' => 'SUBMIT'
                ],
                'data_siswa' => [
                    'nama' => 'Ahmad Siswa Test',
                    'nik' => '3201234567890123',
                    'nisn' => '1234567890',
                    'jk' => 'L',
                    'tmp_lahir' => 'Bandung',
                    'tgl_lahir' => '2007-05-15',
                    'alamat' => 'Jl. Contoh No. 123, Bandung',
                    'nama_ayah' => 'Bapak Ahmad',
                    'nama_ibu' => 'Ibu Siti',
                    'nama_sekolah_asal' => 'SMP Negeri 1 Bandung',
                    'lat' => -6.917464,
                    'lng' => 107.619123
                ]
            ],
            [
                'pendaftar' => [
                    'no_pendaftaran' => 'PPDB' . date('Ymd') . '002',
                    'email' => 'siswa2@test.com',
                    'gelombang_id' => 1,
                    'jurusan_id' => 2,
                    'status' => 'LULUS'
                ],
                'data_siswa' => [
                    'nama' => 'Siti Siswa Test',
                    'nik' => '3201234567890124',
                    'nisn' => '1234567891',
                    'jk' => 'P',
                    'tmp_lahir' => 'Jakarta',
                    'tgl_lahir' => '2007-03-20',
                    'alamat' => 'Jl. Test No. 456, Jakarta',
                    'nama_ayah' => 'Bapak Budi',
                    'nama_ibu' => 'Ibu Ani',
                    'nama_sekolah_asal' => 'SMP Negeri 2 Jakarta',
                    'lat' => -6.208763,
                    'lng' => 106.845599
                ]
            ],
            [
                'pendaftar' => [
                    'no_pendaftaran' => 'PPDB' . date('Ymd') . '003',
                    'email' => 'siswa3@test.com',
                    'gelombang_id' => 1,
                    'jurusan_id' => 3,
                    'status' => 'SIAP_SELEKSI'
                ],
                'data_siswa' => [
                    'nama' => 'Budi Siswa Test',
                    'nik' => '3201234567890125',
                    'nisn' => '1234567892',
                    'jk' => 'L',
                    'tmp_lahir' => 'Surabaya',
                    'tgl_lahir' => '2007-07-10',
                    'alamat' => 'Jl. Sample No. 789, Surabaya',
                    'nama_ayah' => 'Bapak Joko',
                    'nama_ibu' => 'Ibu Rina',
                    'nama_sekolah_asal' => 'SMP Negeri 3 Surabaya',
                    'lat' => -7.257472,
                    'lng' => 112.752090
                ]
            ]
        ];

        foreach ($sampleData as $data) {
            try {
                // Cek apakah pendaftar sudah ada
                $existingPendaftar = Pendaftar::where('email', $data['pendaftar']['email'])->first();
                
                if (!$existingPendaftar) {
                    $pendaftar = Pendaftar::create($data['pendaftar']);
                    
                    $data['data_siswa']['pendaftar_id'] = $pendaftar->id;
                    PendaftarDataSiswa::create($data['data_siswa']);
                    
                    echo "Created pendaftar: " . $data['data_siswa']['nama'] . "\n";
                } else {
                    echo "Pendaftar already exists: " . $data['pendaftar']['email'] . "\n";
                }
            } catch (\Exception $e) {
                echo "Error creating pendaftar: " . $e->getMessage() . "\n";
            }
        }
    }
}
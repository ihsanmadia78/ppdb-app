<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user default
        User::create([
            'name' => 'Admin PPDB',
            'email' => 'admin@smk.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);
        
        User::create([
            'name' => 'Verifikator',
            'email' => 'verifikator@smk.com', 
            'password' => Hash::make('verifikator123'),
            'role' => 'verifikator'
        ]);
        
        User::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@smk.com',
            'password' => Hash::make('kepsek123'),
            'role' => 'eksekutif'
        ]);
        
        User::create([
            'name' => 'Petugas Keuangan',
            'email' => 'keuangan@smk.com',
            'password' => Hash::make('keuangan123'),
            'role' => 'keuangan'
        ]);
        
        User::create([
            'name' => 'Siswa Test',
            'email' => 'siswa@test.com',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa'
        ]);

        // Tambah data jurusan
        DB::table('jurusan')->insert([
            [
                'kode' => 'PPLG',
                'nama' => 'Pengembangan Perangkat Lunak dan Gim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'AKT',
                'nama' => 'Akuntansi dan Keuangan Lembaga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'ANIMASI',
                'nama' => 'Animasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'PEMASARAN',
                'nama' => 'Pemasaran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'DKV',
                'nama' => 'Desain Komunikasi Visual',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Tambah data gelombang
        DB::table('gelombang')->insert([
            [
                'nama' => 'Gelombang 1',
                'tahun' => 2025,
                'tgl_mulai' => '2025-01-01',
                'tgl_selesai' => '2025-03-31',
                'biaya_daftar' => 5000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Gelombang 2',
                'tahun' => 2025,
                'tgl_mulai' => '2025-04-01',
                'tgl_selesai' => '2025-06-30',
                'biaya_daftar' => 5500000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
        // Tambah data sample pendaftar
        try {
            $pendaftar = \App\Models\Pendaftar::create([
                'no_pendaftaran' => 'PPDB' . date('Ymd') . '001',
                'email' => 'siswa@test.com',
                'gelombang_id' => 1,
                'jurusan_id' => 1,
                'status' => 'SUBMIT'
            ]);
            
            \App\Models\PendaftarDataSiswa::create([
                'pendaftar_id' => $pendaftar->id,
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
            ]);
            
            // Tambah pendaftar kedua dengan koordinat berbeda
            $pendaftar2 = \App\Models\Pendaftar::create([
                'no_pendaftaran' => 'PPDB' . date('Ymd') . '002',
                'email' => 'siswa2@test.com',
                'gelombang_id' => 1,
                'jurusan_id' => 2,
                'status' => 'LULUS'
            ]);
            
            \App\Models\PendaftarDataSiswa::create([
                'pendaftar_id' => $pendaftar2->id,
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
            ]);
            
            // Tambah pendaftar ketiga
            $pendaftar3 = \App\Models\Pendaftar::create([
                'no_pendaftaran' => 'PPDB' . date('Ymd') . '003',
                'email' => 'siswa3@test.com',
                'gelombang_id' => 1,
                'jurusan_id' => 3,
                'status' => 'SIAP_SELEKSI'
            ]);
            
            \App\Models\PendaftarDataSiswa::create([
                'pendaftar_id' => $pendaftar3->id,
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
            ]);
        } catch (\Exception $e) {
            // Ignore if data already exists
        }
    }
}
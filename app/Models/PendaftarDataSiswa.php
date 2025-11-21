<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftarDataSiswa extends Model
{
    use HasFactory;

    protected $table = 'pendaftar_data_siswa';

    protected $fillable = [
        'pendaftar_id',
        'nama',
        'nik',
        'nisn',
        'jk',
        'tmp_lahir',
        'tgl_lahir',
        'agama',
        'alamat',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'kode_pos',
        'latitude',
        'longitude',
        'wilayah_id',
        'nama_ayah',
        'pekerjaan_ayah',
        'hp_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'hp_ibu',
        'asal_sekolah',
        'npsn_sekolah',
        'nama_sekolah_asal',
        'kabupaten_sekolah',
        'nilai_rata_rata'
    ];

    // Relasi ke tabel pendaftar (kebalikan dari hasOne di Pendaftar)
    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id');
    }
}

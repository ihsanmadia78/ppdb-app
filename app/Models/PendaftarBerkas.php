<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftarBerkas extends Model
{
    use HasFactory;
    protected $table = 'pendaftar_berkas';
    protected $fillable = [
        'pendaftar_id', 'nama_berkas', 'jenis_berkas', 'file_path', 'ukuran_file'
    ];

    public function pendaftar() {
        return $this->belongsTo(Pendaftar::class);
    }
}

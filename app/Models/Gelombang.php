<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gelombang extends Model
{
    use HasFactory;
    protected $table = 'gelombang';
    protected $fillable = ['nama', 'tahun', 'tgl_mulai', 'tgl_selesai', 'biaya_daftar', 'tanggal_mulai', 'tanggal_selesai', 'kuota', 'status'];
    
    public function pendaftar()
    {
        return $this->hasMany(Pendaftar::class, 'gelombang_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';

    protected $fillable = ['nama', 'kode', 'kuota'];

    public function pendaftar()
    {
        return $this->hasMany(\App\Models\Pendaftar::class, 'jurusan_id');
    }
}

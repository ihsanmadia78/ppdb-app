<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiBerkas extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_berkas';

    protected $fillable = [
        'pendaftar_id',
        'status',
        'catatan',
        'verified_by',
        'verified_at'
    ];

    protected $casts = [
        'verified_at' => 'datetime'
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
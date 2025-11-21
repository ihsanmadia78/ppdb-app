<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    protected $table = 'pendaftar';

    protected $fillable = [
        'user_id',
        'no_pendaftaran',
        'email',
        'gelombang_id',
        'jurusan_id',
        'status',
    ];

    public function dataSiswa()
    {
        return $this->hasOne(PendaftarDataSiswa::class, 'pendaftar_id');
    }

    public function berkas()
    {
        return $this->hasMany(PendaftarBerkas::class, 'pendaftar_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class, 'gelombang_id');
    }

    public function statusTimeline()
    {
        return $this->hasMany(PendaftarStatus::class)->orderBy('created_at', 'asc');
    }

    public function currentStatus()
    {
        return $this->hasOne(PendaftarStatus::class)->latest();
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function verifikasiBerkas()
    {
        return $this->hasOne(VerifikasiBerkas::class);
    }

    public function updateStatus($status, $keterangan = null)
    {
        $this->update(['status' => $status]);
        
        PendaftarStatus::create([
            'pendaftar_id' => $this->id,
            'status' => $status,
            'keterangan' => $keterangan ?? 'Status diubah menjadi ' . $status,
            'created_by' => auth()->id() ?? 1
        ]);
    }
}

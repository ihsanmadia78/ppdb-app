<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'pendaftar_id',
        'nominal',
        'metode_pembayaran',
        'bukti_bayar',
        'status',
        'keterangan',
        'tanggal_bayar',
        'verified_by',
        'verified_at',
        'catatan_verifikasi'
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'verified_at' => 'datetime',
        'nominal' => 'decimal:2'
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public static function getStatusList()
    {
        return [
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Bayar',
            'verified' => 'Terverifikasi',
            'rejected' => 'Ditolak'
        ];
    }

    public static function getStatusColor($status)
    {
        return match($status) {
            'pending' => 'warning',
            'paid' => 'info',
            'verified' => 'success',
            'rejected' => 'danger',
            default => 'secondary'
        };
    }
}
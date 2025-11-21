<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftarStatus extends Model
{
    use HasFactory;

    protected $table = 'pendaftar_status';

    protected $fillable = [
        'pendaftar_id',
        'status',
        'keterangan',
        'created_by'
    ];

    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function getStatusList()
    {
        return [
            'DRAFT' => 'Draft',
            'SUBMIT' => 'Dikirim',
            'VERIFIKASI_ADMIN' => 'Verifikasi Administrasi',
            'MENUNGGU_PEMBAYARAN' => 'Menunggu Pembayaran',
            'TERBAYAR' => 'Terbayar',
            'VERIFIKASI_KEUANGAN' => 'Verifikasi Keuangan',
            'LULUS' => 'Lulus',
            'TIDAK_LULUS' => 'Tidak Lulus',
            'CADANGAN' => 'Cadangan'
        ];
    }

    public static function getStatusColor($status)
    {
        $colors = [
            'DRAFT' => 'secondary',
            'SUBMIT' => 'info',
            'VERIFIKASI_ADMIN' => 'warning',
            'MENUNGGU_PEMBAYARAN' => 'primary',
            'TERBAYAR' => 'info',
            'VERIFIKASI_KEUANGAN' => 'warning',
            'LULUS' => 'success',
            'TIDAK_LULUS' => 'danger',
            'CADANGAN' => 'warning'
        ];

        return $colors[$status] ?? 'secondary';
    }

    public static function getStatusIcon($status)
    {
        $icons = [
            'DRAFT' => 'fas fa-edit',
            'SUBMIT' => 'fas fa-paper-plane',
            'VERIFIKASI_ADMIN' => 'fas fa-user-check',
            'MENUNGGU_PEMBAYARAN' => 'fas fa-credit-card',
            'TERBAYAR' => 'fas fa-check-circle',
            'VERIFIKASI_KEUANGAN' => 'fas fa-calculator',
            'LULUS' => 'fas fa-trophy',
            'TIDAK_LULUS' => 'fas fa-times-circle',
            'CADANGAN' => 'fas fa-hourglass-half'
        ];

        return $icons[$status] ?? 'fas fa-question-circle';
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Simplify enum to basic workflow statuses only
        $values = [
            'SUBMIT',
            'VERIFIKASI_BERKAS',
            'BERKAS_DITOLAK',
            'MENUNGGU_PEMBAYARAN',
            'PEMBAYARAN_DITOLAK',
            'SIAP_SELEKSI',
            'LULUS',
            'TIDAK_LULUS',
            'CADANGAN'
        ];

        $enum = implode("','", $values);
        DB::statement("ALTER TABLE `pendaftar` MODIFY `status` ENUM('" . $enum . "') NOT NULL DEFAULT 'SUBMIT'");
    }

    public function down(): void
    {
        // Revert to previous complex enum
        $values = [
            'DRAFT',
            'SUBMIT',
            'VERIFIKASI_ADMIN',
            'MENUNGGU_PEMBAYARAN',
            'MENUNGGU_VERIFIKASI_KEUANGAN',
            'TERBAYAR',
            'VERIFIKASI_KEUANGAN',
            'ADM_PASS',
            'ADM_REJECT',
            'PAID',
            'BAYAR',
            'VERIFIKASI',
            'LULUS',
            'TIDAK_LULUS',
            'CADANGAN'
        ];
        
        $enum = implode("','", $values);
        DB::statement("ALTER TABLE `pendaftar` MODIFY `status` ENUM('" . $enum . "') NOT NULL DEFAULT 'DRAFT'");
    }
};
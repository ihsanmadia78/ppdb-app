<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Extend enum values to include all status strings used in the app
        // This migration uses raw SQL to modify the enum definition safely.
        $values = [
            'DRAFT',
            'SUBMIT',
            'VERIFIKASI_BERKAS',
            'BERKAS_DITOLAK',
            'MENUNGGU_PEMBAYARAN',
            'VERIFIKASI_PEMBAYARAN',
            'PEMBAYARAN_DITOLAK',
            'SIAP_SELEKSI',
            'LULUS',
            'TIDAK_LULUS',
            'CADANGAN'
        ];

        $enum = implode("','", $values);

        DB::statement("ALTER TABLE `pendaftar` MODIFY `status` ENUM('" . $enum . "') NOT NULL DEFAULT 'DRAFT'");
    }

    public function down(): void
    {
        // Revert to a safe minimal enum (keeps main statuses)
        DB::statement("ALTER TABLE `pendaftar` MODIFY `status` ENUM('DRAFT','SUBMIT','LULUS','TIDAK_LULUS','CADANGAN') NOT NULL DEFAULT 'DRAFT'");
    }
};

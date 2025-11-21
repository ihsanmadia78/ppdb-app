<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->enum('status', [
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
            ])->default('SUBMIT')->after('jurusan_id');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('pendaftar', function (Blueprint $table) {
            $table->enum('status', [
                'DRAFT',
                'SUBMIT', 
                'MENUNGGU_PEMBAYARAN',
                'BAYAR',
                'VERIFIKASI',
                'TERBAYAR',
                'LULUS',
                'TIDAK_LULUS',
                'CADANGAN'
            ])->default('DRAFT')->after('jurusan_id');
        });
    }
};
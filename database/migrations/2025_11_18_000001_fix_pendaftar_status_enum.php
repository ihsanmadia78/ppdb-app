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
                'DRAFT',
                'SUBMIT', 
                'BAYAR',
                'VERIFIKASI',
                'TERBAYAR',
                'LULUS',
                'TIDAK_LULUS',
                'CADANGAN'
            ])->default('DRAFT')->after('jurusan_id');
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
                'MENUNGGU_VERIFIKASI_KEUANGAN',
                'TERBAYAR',
                'ADM_PASS',
                'ADM_REJECT',
                'PAID',
                'LULUS',
                'TIDAK_LULUS',
                'CADANGAN'
            ])->default('DRAFT')->after('jurusan_id');
        });
    }
};
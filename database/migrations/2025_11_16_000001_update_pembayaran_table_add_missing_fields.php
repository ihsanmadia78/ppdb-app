<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            // Tambah field yang mungkin hilang
            if (!Schema::hasColumn('pembayaran', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
            
            if (!Schema::hasColumn('pembayaran', 'catatan_verifikasi')) {
                $table->text('catatan_verifikasi')->nullable()->after('verified_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            if (Schema::hasColumn('pembayaran', 'verified_at')) {
                $table->dropColumn('verified_at');
            }
            
            if (Schema::hasColumn('pembayaran', 'catatan_verifikasi')) {
                $table->dropColumn('catatan_verifikasi');
            }
        });
    }
};
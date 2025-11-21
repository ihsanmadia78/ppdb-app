<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('gelombang', function (Blueprint $table) {
            // Add new columns
            $table->date('tanggal_mulai')->nullable()->after('tgl_selesai');
            $table->date('tanggal_selesai')->nullable()->after('tanggal_mulai');
            $table->integer('kuota')->default(100)->after('tanggal_selesai');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->after('kuota');
        });
    }

    public function down()
    {
        Schema::table('gelombang', function (Blueprint $table) {
            $table->dropColumn(['tanggal_mulai', 'tanggal_selesai', 'kuota', 'status']);
        });
    }
};
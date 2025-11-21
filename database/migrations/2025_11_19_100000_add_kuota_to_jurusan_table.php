<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jurusan', function (Blueprint $table) {
            $table->integer('kuota')->default(30)->after('kode');
        });
    }

    public function down(): void
    {
        Schema::table('jurusan', function (Blueprint $table) {
            $table->dropColumn('kuota');
        });
    }
};
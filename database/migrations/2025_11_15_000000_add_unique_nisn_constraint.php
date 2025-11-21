<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pendaftar_data_siswa', function (Blueprint $table) {
            $table->unique('nisn', 'unique_nisn');
        });
    }

    public function down()
    {
        Schema::table('pendaftar_data_siswa', function (Blueprint $table) {
            $table->dropUnique('unique_nisn');
        });
    }
};
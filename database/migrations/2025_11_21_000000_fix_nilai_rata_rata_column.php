<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pendaftar_data_siswa', function (Blueprint $table) {
            $table->decimal('nilai_rata_rata', 5, 2)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('pendaftar_data_siswa', function (Blueprint $table) {
            $table->decimal('nilai_rata_rata', 4, 2)->nullable()->change();
        });
    }
};

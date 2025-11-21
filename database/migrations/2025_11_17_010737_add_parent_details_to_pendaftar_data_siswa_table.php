<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pendaftar_data_siswa', function (Blueprint $table) {
            $table->string('pekerjaan_ayah')->nullable()->after('nama_ayah');
            $table->string('hp_ayah')->nullable()->after('pekerjaan_ayah');
            $table->string('pekerjaan_ibu')->nullable()->after('nama_ibu');
            $table->string('hp_ibu')->nullable()->after('pekerjaan_ibu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pendaftar_data_siswa', function (Blueprint $table) {
            $table->dropColumn(['pekerjaan_ayah', 'hp_ayah', 'pekerjaan_ibu', 'hp_ibu']);
        });
    }
};

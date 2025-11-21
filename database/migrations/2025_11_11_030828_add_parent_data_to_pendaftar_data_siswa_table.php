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
            $table->string('nama_ayah')->nullable()->after('alamat');
            $table->string('nama_ibu')->nullable()->after('nama_ayah');
            $table->string('telp_ortu')->nullable()->after('nama_ibu');
            $table->string('pekerjaan_ortu')->nullable()->after('telp_ortu');
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
            $table->dropColumn(['nama_ayah', 'nama_ibu', 'telp_ortu', 'pekerjaan_ortu']);
        });
    }
};

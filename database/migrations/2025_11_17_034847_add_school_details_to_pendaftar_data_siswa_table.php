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
            $table->string('npsn_sekolah', 8)->nullable()->after('asal_sekolah');
            $table->string('nama_sekolah_asal')->nullable()->after('npsn_sekolah');
            $table->string('kabupaten_sekolah')->nullable()->after('nama_sekolah_asal');
            $table->decimal('nilai_rata_rata', 4, 2)->nullable()->after('kabupaten_sekolah');
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
            $table->dropColumn(['npsn_sekolah', 'nama_sekolah_asal', 'kabupaten_sekolah', 'nilai_rata_rata']);
        });
    }
};

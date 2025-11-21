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
            // Only add columns that don't exist yet
            if (!Schema::hasColumn('pendaftar_data_siswa', 'agama')) {
                $table->string('agama', 20)->nullable()->after('tgl_lahir');
            }
            if (!Schema::hasColumn('pendaftar_data_siswa', 'provinsi')) {
                $table->text('provinsi')->nullable()->after('alamat');
            }
            if (!Schema::hasColumn('pendaftar_data_siswa', 'kabupaten')) {
                $table->text('kabupaten')->nullable()->after('provinsi');
            }
            if (!Schema::hasColumn('pendaftar_data_siswa', 'kecamatan')) {
                $table->text('kecamatan')->nullable()->after('kabupaten');
            }
            if (!Schema::hasColumn('pendaftar_data_siswa', 'kelurahan')) {
                $table->text('kelurahan')->nullable()->after('kecamatan');
            }
            if (!Schema::hasColumn('pendaftar_data_siswa', 'kode_pos')) {
                $table->string('kode_pos', 5)->nullable()->after('kelurahan');
            }
            // Rename existing lat/lng to latitude/longitude
            if (Schema::hasColumn('pendaftar_data_siswa', 'lat') && !Schema::hasColumn('pendaftar_data_siswa', 'latitude')) {
                $table->renameColumn('lat', 'latitude');
            }
            if (Schema::hasColumn('pendaftar_data_siswa', 'lng') && !Schema::hasColumn('pendaftar_data_siswa', 'longitude')) {
                $table->renameColumn('lng', 'longitude');
            }
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
            $table->dropColumn([
                'agama', 'provinsi', 'kabupaten', 'kecamatan', 
                'kelurahan', 'kode_pos'
            ]);
            // Rename back to original names
            if (Schema::hasColumn('pendaftar_data_siswa', 'latitude')) {
                $table->renameColumn('latitude', 'lat');
            }
            if (Schema::hasColumn('pendaftar_data_siswa', 'longitude')) {
                $table->renameColumn('longitude', 'lng');
            }
        });
    }
};

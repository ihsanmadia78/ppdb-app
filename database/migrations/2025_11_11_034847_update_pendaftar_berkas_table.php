<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pendaftar_berkas', function (Blueprint $table) {
            // Drop old columns if exist
            if (Schema::hasColumn('pendaftar_berkas', 'jenis')) {
                $table->dropColumn(['jenis', 'nama_file', 'path', 'ukuran_kb', 'valid', 'catatan']);
            }
            
            // Add new columns
            $table->string('nama_berkas')->after('pendaftar_id');
            $table->string('jenis_berkas')->after('nama_berkas');
            $table->string('file_path')->after('jenis_berkas');
            $table->integer('ukuran_file')->after('file_path');
        });
    }

    public function down()
    {
        Schema::table('pendaftar_berkas', function (Blueprint $table) {
            $table->dropColumn(['nama_berkas', 'jenis_berkas', 'file_path', 'ukuran_file']);
            $table->string('jenis')->after('pendaftar_id');
            $table->string('nama_file')->after('jenis');
            $table->string('path')->after('nama_file');
            $table->integer('ukuran_kb')->after('path');
            $table->boolean('valid')->default(false)->after('ukuran_kb');
            $table->text('catatan')->nullable()->after('valid');
        });
    }
};
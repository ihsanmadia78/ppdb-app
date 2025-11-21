<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pendaftar_data_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftar_id');
            $table->string('nik', 20)->nullable();
            $table->string('nisn', 20)->nullable();
            $table->string('nama', 120);
            $table->enum('jk', ['L','P'])->nullable();
            $table->string('tmp_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->unsignedBigInteger('wilayah_id')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->timestamps();

            $table->foreign('pendaftar_id')->references('id')->on('pendaftar')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('pendaftar_data_siswa');
    }
};

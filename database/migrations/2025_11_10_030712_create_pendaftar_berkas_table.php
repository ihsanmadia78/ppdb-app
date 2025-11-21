<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pendaftar_berkas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftar_id');
            $table->enum('jenis', ['IJAZAH','RAPOR','KIP','KKS','AKTA','KK','LAINNYA']);
            $table->string('nama_file');
            $table->string('path');
            $table->integer('ukuran_kb')->nullable();
            $table->boolean('valid')->default(false);
            $table->string('catatan')->nullable();
            $table->timestamps();

            $table->foreign('pendaftar_id')->references('id')->on('pendaftar')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('pendaftar_berkas');
    }
};

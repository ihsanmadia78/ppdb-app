<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pendaftar', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('no_pendaftaran')->unique();
            $table->unsignedBigInteger('gelombang_id')->nullable();
            $table->unsignedBigInteger('jurusan_id')->nullable();
            $table->enum('status', ['DRAFT','SUBMIT','ADM_PASS','ADM_REJECT','PAID','LULUS','TIDAK_LULUS'])->default('DRAFT');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('pendaftar');
    }
};

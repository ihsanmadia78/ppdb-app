<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('wilayah', function (Blueprint $table) {
            $table->id();
            $table->string('provinsi')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kodepos', 10)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('wilayah');
    }
};

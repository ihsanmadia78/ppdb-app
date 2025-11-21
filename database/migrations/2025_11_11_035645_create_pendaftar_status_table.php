<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pendaftar_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftar_id');
            $table->string('status');
            $table->text('keterangan')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('pendaftar_id')->references('id')->on('pendaftar')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftar_status');
    }
};
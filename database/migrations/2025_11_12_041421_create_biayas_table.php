<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('biayas', function (Blueprint $table) {
            $table->id();
            $table->string('jenis'); // pendaftaran, spp, seragam, buku
            $table->decimal('nominal', 12, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('biayas');
    }
};
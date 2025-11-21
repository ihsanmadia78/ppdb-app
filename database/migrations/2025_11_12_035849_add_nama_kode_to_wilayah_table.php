<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('wilayah', function (Blueprint $table) {
            $table->string('nama')->after('id');
            $table->string('kode', 10)->after('nama');
        });
    }

    public function down()
    {
        Schema::table('wilayah', function (Blueprint $table) {
            $table->dropColumn(['nama', 'kode']);
        });
    }
};
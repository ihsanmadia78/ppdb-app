<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','verifikator','eksekutif','keuangan','siswa') NOT NULL DEFAULT 'admin'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','verifikator','eksekutif','keuangan') NOT NULL DEFAULT 'admin'");
    }
};
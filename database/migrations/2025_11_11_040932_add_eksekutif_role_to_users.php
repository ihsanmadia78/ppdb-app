<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Update existing role column to allow eksekutif and keuangan
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'verifikator', 'eksekutif', 'keuangan') NOT NULL DEFAULT 'admin'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'verifikator') NOT NULL DEFAULT 'admin'");
    }
};
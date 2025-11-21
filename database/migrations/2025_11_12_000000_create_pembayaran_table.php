<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pendaftar_id');
            $table->decimal('nominal', 10, 2);
            $table->string('metode_pembayaran')->nullable(); // transfer, va, qris
            $table->string('bukti_bayar')->nullable(); // path file bukti
            $table->enum('status', ['pending', 'paid', 'verified', 'rejected'])->default('pending');
            $table->text('keterangan')->nullable();
            $table->timestamp('tanggal_bayar')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamps();

            $table->foreign('pendaftar_id')->references('id')->on('pendaftar')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
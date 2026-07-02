<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id('kode_jual');

            $table->unsignedBigInteger('id_user');

            $table->date('tanggal_jual');

            // ✅ DATA PEMBELI
            $table->string('nama_pembeli')->nullable();

            $table->integer('total_jual');

            // ✅ METODE PEMBAYARAN (UPDATE)
            $table->enum('metode_bayar', [
                'Cash',
                'Transfer',
                'Kartu Kredit',
                'SpayLater',
                'Akulaku',
                'Kredivo',
                'GopayLater'
            ]);

            // ✅ BUKTI BAYAR (UPLOAD FOTO)
            $table->string('bukti_bayar')->nullable();

            // ✅ STATUS PEMBAYARAN
            $table->enum('status_bayar', ['Lunas', 'Belum Lunas', 'Sebagian'])->default('Belum Lunas');

            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
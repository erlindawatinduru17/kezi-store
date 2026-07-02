<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_penjualans', function (Blueprint $table) {
            $table->id('id_detailjual');

            $table->unsignedBigInteger('kode_jual');
            $table->unsignedBigInteger('id_produk');

            $table->integer('jumlah');
            $table->decimal('harga', 10, 2);
            $table->decimal('subtotal', 10, 2);

            $table->timestamps();

            $table->foreign('kode_jual')
                  ->references('kode_jual')
                  ->on('penjualans')
                  ->cascadeOnDelete();

            $table->foreign('id_produk')
                  ->references('id_produk')
                  ->on('produks')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_penjualans');
    }
};
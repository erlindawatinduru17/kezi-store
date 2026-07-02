<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id('id_produk');
            $table->string('nama_produk');
            $table->decimal('harga', 10, 2);
            $table->integer('stok');
            $table->string('gambar')->nullable();

            $table->unsignedBigInteger('kode_kategori');

            $table->foreign('kode_kategori')
                  ->references('kode_kategori')
                  ->on('kategoris')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('penerimaan_kas')) {
            return;
        }

        Schema::create('penerimaan_kas', function (Blueprint $table) {
            $table->id('kode_terimakas');
            $table->unsignedBigInteger('kode_jual');
            $table->date('tgl_terimakas');
            $table->integer('jmlh_terimakas');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('kode_jual')
                  ->references('kode_jual')
                  ->on('penjualans')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerimaan_kas');
    }
};
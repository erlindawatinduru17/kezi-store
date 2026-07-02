<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id('id_log');

            // 🔥 RELASI KE USER (ADMIN / KASIR)
            $table->unsignedBigInteger('id_user');

            // 🔥 MENU YANG DIAKSES (Transaksi, Produk, dll)
            $table->string('menu')->nullable();

            // 🔥 AKTIVITAS (Tambah, Edit, Hapus, Login, dll)
            $table->string('aktivitas');

            // 🔥 KETERANGAN TAMBAHAN
            $table->text('keterangan')->nullable();

            // 🔥 OPSIONAL: SIMPAN IP ADDRESS
            $table->string('ip_address')->nullable();

            // 🔥 OPSIONAL: SIMPAN USER AGENT (browser)
            $table->text('user_agent')->nullable();

            $table->timestamps();

            // 🔥 FOREIGN KEY CONSTRAINT
            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
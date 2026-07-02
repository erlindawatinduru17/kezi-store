<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan tabel penjualans punya kolom yang diperlukan
        Schema::table('penjualans', function (Blueprint $table) {
            if (!Schema::hasColumn('penjualans', 'no_penjualan')) {
                $table->string('no_penjualan')->unique()->nullable()->after('id_jual');
            }
        });

        // Pastikan tabel produks punya kolom id_produk sebagai auto-increment
        // (Jika sebelumnya menggunakan string, kita perlu handle ini)
    }

    public function down(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            if (Schema::hasColumn('penjualans', 'no_penjualan')) {
                $table->dropColumn('no_penjualan');
            }
        });
    }
};

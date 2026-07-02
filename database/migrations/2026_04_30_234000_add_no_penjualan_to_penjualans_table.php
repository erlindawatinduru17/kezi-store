<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            // Tambahkan kolom no_penjualan jika belum ada
            if (!Schema::hasColumn('penjualans', 'no_penjualan')) {
                $table->string('no_penjualan')->unique()->after('id_jual');
            }
        });
    }

    public function down(): void
    {
        Schema::table('penjualans', function (Blueprint $table) {
            if (Schema::hasColumn('penjualans', 'no_penjualan')) {
                $table->dropColumn('no_penjualan'); // Hapus kolom no_penjualan yang lama
            }
        });
    }
};

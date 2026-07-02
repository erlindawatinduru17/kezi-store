<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            // Tambahkan kolom kode_produk jika belum ada
            if (!Schema::hasColumn('produks', 'kode_produk')) {
                $table->string('kode_produk')->unique()->nullable()->after('id_produk');
            }
        });
    }

    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            if (Schema::hasColumn('produks', 'kode_produk')) {
                $table->dropColumn('kode_produk');
            }
        });
    }
};

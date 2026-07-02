<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('penjualans')) {
            return;
        }

        if (!Schema::hasColumn('penjualans', 'no_penjualan')) {
            Schema::table('penjualans', function (Blueprint $table) {
                $table->string('no_penjualan')->nullable()->unique();
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('penjualans')) {
            return;
        }

        if (Schema::hasColumn('penjualans', 'no_penjualan')) {
            Schema::table('penjualans', function (Blueprint $table) {
                $table->dropColumn('no_penjualan');
            });
        }
    }
};

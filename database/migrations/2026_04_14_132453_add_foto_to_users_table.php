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
        // Cek dulu biar tidak error kalau kolom sudah ada
        if (!Schema::hasColumn('users', 'foto')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('foto')->nullable()->after('email');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cek dulu sebelum drop
        if (Schema::hasColumn('users', 'foto')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('foto');
            });
        }
    }
};
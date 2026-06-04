<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('perizinans', function (Blueprint $table) {
            // ⬇️ MASUKKAN KODE ANDA DI SINI
            $table->string('alasan_tolak')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('perizinans', function (Blueprint $table) {
            // Hapus kolom jika migration di-rollback
            $table->dropColumn('alasan_tolak');
        });
    }
};
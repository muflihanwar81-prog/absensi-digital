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
        Schema::create('admin_activities', function (Blueprint $table) {
            $table->id();
            $table->string('type');           // jenis: karyawan_tambah, karyawan_edit, dll
            $table->string('judul');          // judul aktivitas
            $table->string('deskripsi')->nullable(); // detail: nama karyawan / divisi
            $table->string('icon')->default('circle-check'); // font awesome icon
            $table->string('warna')->default('emerald');     // warna badge
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_activities');
    }
};

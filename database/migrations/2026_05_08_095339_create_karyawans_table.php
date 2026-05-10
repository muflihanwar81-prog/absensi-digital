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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();

            $table->string('nip');
            $table->string('nama');

            // Relasi ke tabel divisis
            $table->foreignId('divisi_id')->constrained('divisis');

            // Nama divisi disimpan juga untuk memudahkan tampil data
            $table->string('divisi')->nullable();

            $table->string('jabatan');

            // Status karyawan (Tetap, Kontrak, Magang, dll)
            $table->string('status')->nullable();

            // Jam kerja mengikuti divisi
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();

            $table->string('email')->nullable();
            $table->string('password');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
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
        Schema::create('izins', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Data pengajuan izin
            $table->string('nip')->nullable();
            $table->string('nama')->nullable();
            $table->string('divisi')->nullable();
            $table->string('jabatan')->nullable();

            // Data izin
            $table->date('tanggal')->nullable();
            $table->text('alasan')->nullable();
            $table->string('kategori')->nullable(); // Sakit, Izin, Cuti

            // Tanggal mulai & selesai
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            // File pendukung
            $table->string('file_tambahan')->nullable();

            // Status pengajuan
            $table->string('status')->default('Menunggu');
            // Menunggu, Disetujui, Ditolak

            // Alasan penolakan
            $table->text('alasan_tolak')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izins');
    }
};

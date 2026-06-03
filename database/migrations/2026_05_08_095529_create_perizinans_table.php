<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('perizinans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('karyawan_id')->constrained('karyawans');
    $table->enum('jenis', [
        'Izin',
        'Sakit'
    ]);
    $table->text('keterangan')->nullable();
    $table->date('tanggal');
    $table->string('bukti')->nullable();
    $table->timestamps();
});
    }

    
    public function down(): void
    {
        Schema::dropIfExists('perizinans');
    }
};


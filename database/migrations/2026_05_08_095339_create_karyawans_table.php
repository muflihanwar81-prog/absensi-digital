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
    $table->foreignId('divisi_id')->constrained('divisis');
    $table->string('jabatan');
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

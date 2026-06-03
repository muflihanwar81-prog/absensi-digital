<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();

            $table->string('nip');
            $table->string('nama');

            
            $table->foreignId('divisi_id')->constrained('divisis');

            
            $table->string('divisi')->nullable();

            $table->string('jabatan');

            
            $table->string('status')->nullable();

            
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();

            $table->string('email')->nullable();
            $table->string('password');

            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};

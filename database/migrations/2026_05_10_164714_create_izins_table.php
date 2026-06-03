<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('izins', function (Blueprint $table) {
            $table->id();

            
            $table->foreignId('karyawan_id')
                  ->constrained()
                  ->cascadeOnDelete();

            
            $table->string('nip')->nullable();
            $table->string('nama')->nullable();
            $table->string('divisi')->nullable();
            $table->string('jabatan')->nullable();

            
            $table->date('tanggal')->nullable();
            $table->text('alasan')->nullable();
            $table->string('kategori')->nullable(); 

            
            $table->string('file_tambahan')->nullable();

            
            $table->string('status')->default('Menunggu');
            

            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('izins');
    }
};

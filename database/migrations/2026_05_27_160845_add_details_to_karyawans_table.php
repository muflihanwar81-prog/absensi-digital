<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->string('username')->nullable()->unique();
            $table->date('tgl_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->text('alamat')->nullable();
            $table->date('tgl_bergabung')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('role')->nullable();
        });
    }

    
    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'tgl_lahir',
                'jenis_kelamin',
                'alamat',
                'tgl_bergabung',
                'no_hp',
                'role'
            ]);
        });
    }
};


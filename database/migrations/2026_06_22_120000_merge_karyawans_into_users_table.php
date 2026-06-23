<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Merge karyawans table into users table.
     *
     * Adds all karyawan-specific columns to users, drops the old
     * karyawans table (if it still exists).
     *
     * NOTE: absensis, izins, perizinans migrations already use user_id
     * referencing users, so no FK rename is needed here.
     */
    public function up(): void
    {
        // 1. Add karyawan columns to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('id');
            $table->string('nama')->after('nip');
            $table->foreignId('divisi_id')->nullable()->constrained('divisis')->after('nama');
            $table->string('divisi')->nullable()->after('divisi_id');
            $table->string('jabatan')->nullable()->after('divisi');
            $table->string('username')->nullable()->unique()->after('email');
            $table->date('tgl_lahir')->nullable()->after('username');
            $table->string('jenis_kelamin')->nullable()->after('tgl_lahir');
            $table->text('alamat')->nullable()->after('jenis_kelamin');
            $table->date('tgl_bergabung')->nullable()->after('alamat');
            $table->string('no_hp')->nullable()->after('tgl_bergabung');
            $table->time('jam_masuk')->nullable()->after('no_hp');
            $table->time('jam_keluar')->nullable()->after('jam_masuk');
            $table->text('komentar_nonaktif')->nullable()->after('status');
        });

        // 2. Migrate existing 'name' data into 'nama' for any existing users
        DB::table('users')->whereNull('nama')->update([
            'nama' => DB::raw('`name`'),
        ]);

        // 3. Drop the old 'name' column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        // 4. Drop karyawans table if it still exists (legacy)
        Schema::dropIfExists('karyawans');
    }

    /**
     * Reverse the migration (not fully reversible due to data loss).
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
            if (Schema::hasColumn('users', 'divisi_id')) {
                $table->dropForeign(['divisi_id']);
            }
            $table->dropColumn([
                'nip', 'nama', 'divisi_id', 'divisi', 'jabatan',
                'username', 'tgl_lahir', 'jenis_kelamin', 'alamat',
                'tgl_bergabung', 'no_hp', 'jam_masuk', 'jam_keluar',
                'komentar_nonaktif',
            ]);
        });
    }
};

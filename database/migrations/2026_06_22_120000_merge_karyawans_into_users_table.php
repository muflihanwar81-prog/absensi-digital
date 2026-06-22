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
     * karyawans table, and updates FK references in absensis & izins.
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

        // 4. Drop FK constraints on absensis and izins that reference karyawans
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->renameColumn('karyawan_id', 'user_id');
        });

        Schema::table('izins', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->renameColumn('karyawan_id', 'user_id');
        });

        Schema::table('perizinans', function (Blueprint $table) {
            $table->dropForeign(['karyawan_id']);
            $table->renameColumn('karyawan_id', 'user_id');
        });

        // 5. Drop the karyawans table
        Schema::dropIfExists('karyawans');

        // 6. Add new FK constraints referencing users
        Schema::table('absensis', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('izins', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });

        Schema::table('perizinans', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migration (not fully reversible due to data loss).
     */
    public function down(): void
    {
        // Recreate karyawans table
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
            $table->string('username')->nullable()->unique();
            $table->date('tgl_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->text('alamat')->nullable();
            $table->date('tgl_bergabung')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('role')->nullable();
            $table->text('komentar_nonaktif')->nullable();
            $table->timestamps();
        });

        // Revert FK on absensis & izins
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->renameColumn('user_id', 'karyawan_id');
        });

        Schema::table('izins', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->renameColumn('user_id', 'karyawan_id');
        });

        Schema::table('absensis', function (Blueprint $table) {
            $table->foreign('karyawan_id')->references('id')->on('karyawans');
        });

        Schema::table('izins', function (Blueprint $table) {
            $table->foreign('karyawan_id')->references('id')->on('karyawans')->cascadeOnDelete();
        });

        // Add back 'name' and remove karyawan columns from users
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->dropForeign(['divisi_id']);
            $table->dropColumn([
                'nip', 'nama', 'divisi_id', 'divisi', 'jabatan',
                'username', 'tgl_lahir', 'jenis_kelamin', 'alamat',
                'tgl_bergabung', 'no_hp', 'jam_masuk', 'jam_keluar',
                'komentar_nonaktif',
            ]);
        });
    }
};

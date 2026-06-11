<?php

namespace App\Models;

use App\Models\Karyawan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Model User
 *
 * Merepresentasikan akun login untuk admin dan kepala divisi.
 * Tabel users terpisah dari tabel karyawans — hanya pengguna
 * dengan hak akses tertentu yang memiliki akun di tabel ini.
 *
 * Role yang tersedia:
 * - admin         : admin biasa, akses penuh ke panel admin
 * - super_admin   : super admin, level tertinggi
 * - kepala_divisi : kepala divisi, akses dashboard divisi masing-masing
 *
 * Akun user otomatis dibuat/dihapus oleh admin saat mengelola
 * data karyawan (AdminDataKaryawanController):
 * - Dibuat saat karyawan berjabatan Kepala Divisi atau ber-role admin
 * - Dihapus saat jabatan diturunkan dari Kepala Divisi
 *
 * @property int         $id                  Primary key
 * @property string      $name                Nama pengguna (nama divisi untuk kepala_divisi)
 * @property string      $email               Email login (unik, sinkron dengan email karyawan)
 * @property string      $password            Password terenkripsi (auto-hash via cast)
 * @property string      $role                Role akses: admin|super_admin|kepala_divisi
 * @property string|null $email_verified_at   Timestamp verifikasi email
 * @property string|null $remember_token      Token "remember me" untuk session
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom-kolom yang boleh diisi secara mass assignment.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Kolom-kolom yang disembunyikan saat serialisasi (JSON/array).
     * Mencegah password dan token bocor ke response.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Definisi casting tipe data untuk kolom tertentu.
     * - email_verified_at: otomatis di-cast ke instance Carbon
     * - password: otomatis di-hash saat di-set (fitur Laravel 11+)
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: User memiliki satu Karyawan.
     * Menghubungkan akun login (user) dengan data karyawan terkait.
     * Tidak semua user memiliki karyawan (misal: admin tanpa NIP).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function karyawan(): HasOne
    {
        return $this->hasOne(Karyawan::class);
    }
}
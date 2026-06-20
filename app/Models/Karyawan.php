<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Absensi;
use App\Models\User;
use App\Models\Divisi;

/**
 * Model Karyawan
 *
 * Merepresentasikan data karyawan/pegawai dalam sistem absensi.
 * Extends Authenticatable karena karyawan juga bisa login ke sistem
 * menggunakan guard 'karyawan' (terpisah dari tabel users).
 *
 * Setiap karyawan memiliki data pribadi, divisi, jabatan, jam kerja,
 * status (Aktif/Nonaktif), dan role untuk akses level.
 *
 * Digunakan oleh admin untuk:
 * - CRUD data karyawan (AdminDataKaryawanController)
 * - Filter dan statistik di dashboard (AdminDashboardController)
 * - Relasi ke absensi dan izin di seluruh modul admin
 *
 * @property int         $id                Primary key
 * @property string      $nip               Nomor Induk Pegawai (unik)
 * @property string      $nama              Nama lengkap karyawan
 * @property int|null    $divisi_id         Foreign key ke tabel divisis
 * @property string      $divisi            Nama divisi (denormalized untuk kemudahan query)
 * @property string      $jabatan           Jabatan karyawan (misal: Staff, Kepala Divisi)
 * @property string      $status            Status karyawan: Aktif|Nonaktif
 * @property string      $jam_masuk         Jam masuk kerja (otomatis dari divisi)
 * @property string      $jam_keluar        Jam keluar kerja (otomatis dari divisi)
 * @property string      $email             Alamat email (unik, digunakan untuk login)
 * @property string      $password          Password terenkripsi (bcrypt)
 * @property string|null $username          Username opsional
 * @property string|null $tgl_lahir         Tanggal lahir (format: Y-m-d)
 * @property string|null $jenis_kelamin     Jenis kelamin: Laki-laki|Perempuan
 * @property string|null $alamat            Alamat tempat tinggal
 * @property string|null $tgl_bergabung     Tanggal mulai bekerja (format: Y-m-d)
 * @property string|null $no_hp             Nomor telepon/HP
 * @property string|null $role              Role akses: karyawan|admin|super_admin
 * @property string|null $komentar_nonaktif Alasan/komentar jika status Nonaktif
 */
class Karyawan extends Authenticatable
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'karyawans';

    /**
     * Kolom-kolom yang boleh diisi secara mass assignment.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nip',
        'nama',
        'divisi_id',
        'divisi',
        'jabatan',
        'status',
        'jam_masuk',
        'jam_keluar',
        'email',
        'password',
        'username',
        'tgl_lahir',
        'jenis_kelamin',
        'alamat',
        'tgl_bergabung',
        'no_hp',
        'role',
        'komentar_nonaktif',
    ];

    /**
     * Kolom-kolom yang disembunyikan saat serialisasi (JSON/array).
     * Mencegah password dan token bocor ke response API.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi: Karyawan dimiliki oleh satu User (akun login admin/kepala divisi).
     * Tidak semua karyawan memiliki akun user — hanya yang berjabatan
     * Kepala Divisi atau ber-role admin/super_admin.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /**
     * Relasi: Karyawan termasuk dalam satu Divisi.
     * Terhubung melalui kolom divisi_id ke tabel divisis.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    /**
     * Relasi: Karyawan memiliki banyak record Absensi.
     * Satu karyawan bisa punya banyak data absensi (satu per hari kerja).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
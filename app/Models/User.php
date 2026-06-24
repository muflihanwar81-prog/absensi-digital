<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Model User (Unified)
 *
 * Merepresentasikan semua pengguna sistem: karyawan, admin, super admin,
 * dan kepala divisi. Menggabungkan data yang sebelumnya terpisah di
 * tabel users dan karyawans menjadi satu tabel.
 *
 * Role yang tersedia:
 * - karyawan      : karyawan biasa, akses dashboard karyawan
 * - admin         : admin biasa, akses penuh ke panel admin
 * - kepala_divisi : kepala divisi, akses dashboard divisi
 *
 * @property int         $id
 * @property string|null $nip               Nomor Induk Pegawai
 * @property string      $nama              Nama lengkap
 * @property int|null    $divisi_id         Foreign key ke tabel divisis
 * @property string|null $divisi            Nama divisi (denormalized)
 * @property string|null $jabatan           Jabatan karyawan
 * @property string      $email             Email login (unik)
 * @property string|null $username          Username opsional
 * @property string      $password          Password terenkripsi
 * @property string      $role              Role akses
 * @property string      $status            Status: Aktif|Nonaktif
 * @property string|null $komentar_nonaktif Alasan nonaktif
 * @property string|null $jam_masuk         Jam masuk kerja
 * @property string|null $jam_keluar        Jam keluar kerja
 * @property string|null $tgl_lahir         Tanggal lahir
 * @property string|null $jenis_kelamin     Jenis kelamin
 * @property string|null $alamat            Alamat
 * @property date|null   $tgl_bergabung     Tanggal mulai bekerja
 * @property string|null $no_hp             Nomor HP
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
        'nip',
        'nama',
        'divisi_id',
        'divisi',
        'jabatan',
        'email',
        'username',
        'password',
        'role',
        'status',
        'komentar_nonaktif',
        'jam_masuk',
        'jam_keluar',
        'tgl_lahir',
        'jenis_kelamin',
        'alamat',
        'tgl_bergabung',
        'no_hp',
    ];

    /**
     * Kolom-kolom yang disembunyikan saat serialisasi.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Definisi casting tipe data.
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
     * Relasi: User termasuk dalam satu Divisi.
     */
    public function divisiObj()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }

    /**
     * Relasi: User memiliki banyak Absensi.
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    /**
     * Relasi: User memiliki banyak Izin.
     */
    public function izin()
    {
        return $this->hasMany(Izin::class);
    }
}
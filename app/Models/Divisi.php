<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Divisi
 *
 * Merepresentasikan data divisi/departemen dalam organisasi.
 * Setiap divisi memiliki nama, jam kerja (masuk & keluar),
 * dan opsional data lokasi GPS untuk validasi absensi.
 *
 * Digunakan oleh admin untuk:
 * - Mengelola daftar divisi (AdminKelolaDivisiController)
 * - Menetapkan jam kerja per divisi
 * - Dropdown filter di dashboard dan laporan
 * - Otomatis mengisi jam_masuk/jam_keluar karyawan saat ditambahkan
 *
 * @property int         $id            Primary key
 * @property string      $nama_divisi   Nama divisi (harus unik)
 * @property string      $jam_masuk     Jam masuk kerja divisi (format: H:i)
 * @property string      $jam_keluar    Jam keluar/pulang kerja divisi (format: H:i)
 * @property float|null  $latitude      Koordinat latitude lokasi divisi (opsional)
 * @property float|null  $longitude     Koordinat longitude lokasi divisi (opsional)
 * @property int|null    $radius        Radius validasi GPS dalam meter (opsional)
 */
class Divisi extends Model
{
    /**
     * Kolom-kolom yang boleh diisi secara mass assignment.
     *
     * @var array<string>
     */
    protected $fillable = [
        'nama_divisi',
        'jam_masuk',
        'jam_keluar',
        'latitude',
        'longitude',
        'radius',
    ];

    /**
     * Relasi: Divisi memiliki banyak User (karyawan).
     */
    public function users()
    {
        return $this->hasMany(User::class, 'divisi_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Izin
 *
 * Merepresentasikan data pengajuan izin/cuti dari karyawan.
 *
 * @property int         $id
 * @property int         $user_id          Foreign key ke tabel users
 * @property string      $nip              NIP karyawan (denormalized)
 * @property string      $nama             Nama karyawan (denormalized)
 * @property string      $divisi           Divisi karyawan (denormalized)
 * @property string      $jabatan          Jabatan karyawan (denormalized)
 * @property string      $kategori         Kategori izin (Sakit, Cuti, dll)
 * @property string      $tanggal_mulai    Tanggal mulai izin
 * @property string      $tanggal_selesai  Tanggal selesai izin
 * @property string|null $file_tambahan    Path file lampiran
 * @property string      $status           Status: Menunggu|Disetujui|Ditolak
 * @property string|null $alasan_tolak     Alasan penolakan
 */
class Izin extends Model
{
    /**
     * Kolom-kolom yang boleh diisi secara mass assignment.
     *
     * @var array<string>
     */
protected $fillable = [
    'user_id',
    'nip',
    'nama',
    'divisi',
    'jabatan',
    'kategori',
    'keterangan',
    'tanggal_mulai',
    'tanggal_selesai',
    'status',
    'alasan_tolak',
];

    /**
     * Relasi: Izin milik satu User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
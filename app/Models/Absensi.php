<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Absensi
 *
 * Merepresentasikan data kehadiran/absensi harian karyawan.
 * Setiap record berisi informasi jam masuk, jam keluar, tanggal,
 * dan status kehadiran (Hadir, Terlambat, Izin, Sakit).
 *
 * @property int    $id
 * @property int    $user_id    Foreign key ke tabel users
 * @property string $tanggal    Tanggal absensi (format: Y-m-d)
 * @property string $jam_masuk  Waktu masuk (format: H:i:s)
 * @property string $jam_keluar Waktu pulang (format: H:i:s)
 * @property string $status     Status: Hadir|Terlambat|Izin|Sakit|Alpha
 */
class Absensi extends Model
{
    /**
     * Kolom-kolom yang boleh diisi secara mass assignment.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status'
    ];

    /**
     * Relasi: Absensi milik satu User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Alias untuk backward compatibility di views.
     * Beberapa view masih menggunakan $absensi->karyawan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function karyawan()
    {
        return $this->user();
    }
}
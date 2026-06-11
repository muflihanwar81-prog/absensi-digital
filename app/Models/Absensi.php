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
 * Digunakan oleh admin untuk:
 * - Melihat rekap kehadiran di dashboard (AdminDashboardController)
 * - Mengelola data absensi (AdminDataAbsensiController)
 * - Membuat laporan absensi CSV/PDF (AdminLaporanController)
 *
 * @property int    $id           Primary key
 * @property int    $karyawan_id  Foreign key ke tabel karyawans
 * @property string $tanggal      Tanggal absensi (format: Y-m-d)
 * @property string $jam_masuk    Waktu karyawan masuk (format: H:i:s)
 * @property string $jam_keluar   Waktu karyawan pulang (format: H:i:s)
 * @property string $status       Status kehadiran: Hadir|Terlambat|Izin|Sakit
 */
class Absensi extends Model
{
    /**
     * Kolom-kolom yang boleh diisi secara mass assignment.
     *
     * @var array<string>
     */
    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'jam_masuk',
        'jam_keluar',
        'status'
    ];

    /**
     * Relasi: Absensi milik satu Karyawan.
     * Setiap record absensi terhubung ke satu karyawan melalui karyawan_id.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Perizinan
 *
 * Merepresentasikan data perizinan internal karyawan (berbeda dari model Izin).
 * Model ini menyimpan data izin dengan format yang lebih sederhana,
 * biasanya digunakan untuk perizinan internal divisi.
 *
 * Data perizinan otomatis dihapus saat karyawan dihapus oleh admin
 * (cascade delete di AdminDataKaryawanController).
 *
 * @property int         $id            Primary key
 * @property int         $karyawan_id   Foreign key ke tabel karyawans
 * @property string      $jenis         Jenis perizinan (misal: Izin, Sakit, Cuti)
 * @property string      $keterangan    Keterangan/alasan perizinan
 * @property string      $tanggal       Tanggal perizinan (format: Y-m-d)
 * @property string|null $bukti         Path file bukti/lampiran (opsional)
 */
class Perizinan extends Model
{
    /**
     * Kolom-kolom yang boleh diisi secara mass assignment.
     *
     * @var array<string>
     */
    protected $fillable = [
        'karyawan_id',
        'jenis',
        'keterangan',
        'tanggal',
        'bukti'
    ];

    /**
     * Relasi: Perizinan milik satu Karyawan.
     * Setiap record perizinan terhubung ke satu karyawan melalui karyawan_id.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
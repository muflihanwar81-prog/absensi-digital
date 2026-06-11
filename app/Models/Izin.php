<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Izin
 *
 * Merepresentasikan data pengajuan izin/cuti dari karyawan.
 * Karyawan mengajukan izin melalui form, lalu admin menyetujui atau menolak.
 *
 * Status izin:
 * - Menunggu  : belum diproses oleh admin
 * - Disetujui : izin diterima oleh admin
 * - Ditolak   : izin ditolak oleh admin
 *
 * Digunakan oleh admin untuk:
 * - Melihat dan mengelola pengajuan izin (AdminDataPerizinanController)
 * - Menampilkan jumlah izin pending di dashboard (AdminDashboardController)
 * - Dihapus saat karyawan dihapus (AdminDataKaryawanController)
 *
 * @property int         $id               Primary key
 * @property int         $karyawan_id      Foreign key ke tabel karyawans
 * @property string      $nip              NIP karyawan yang mengajukan (denormalized)
 * @property string      $nama             Nama karyawan yang mengajukan (denormalized)
 * @property string      $divisi           Divisi karyawan (denormalized)
 * @property string      $jabatan          Jabatan karyawan (denormalized)
 * @property string      $kategori         Kategori izin (misal: Sakit, Cuti, Dinas Luar)
 * @property string      $tanggal_mulai    Tanggal mulai izin (format: Y-m-d)
 * @property string      $tanggal_selesai  Tanggal selesai izin (format: Y-m-d)
 * @property string|null $file_tambahan    Path file lampiran/bukti (opsional)
 * @property string      $status           Status izin: Menunggu|Disetujui|Ditolak
 */
class Izin extends Model
{
    /**
     * Kolom-kolom yang boleh diisi secara mass assignment.
     *
     * @var array<string>
     */
    protected $fillable = [
        'karyawan_id',
        'nip',
        'nama',
        'divisi',
        'jabatan',
        'kategori',
        'tanggal_mulai',
        'tanggal_selesai',
        'file_tambahan',
        'status',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminActivity extends Model
{
    protected $fillable = [
        'type',
        'judul',
        'deskripsi',
        'icon',
        'warna',
    ];

    /**
     * Helper untuk mencatat aktivitas admin.
     *
     * @param string $type     Jenis aktivitas (karyawan_tambah, dll)
     * @param string $judul    Judul yang ditampilkan
     * @param string|null $deskripsi  Detail/subjek aktivitas
     */
    public static function log(string $type, string $judul, ?string $deskripsi = null): void
    {
        $map = [
            // Karyawan
            'karyawan_tambah' => ['icon' => 'user-plus',       'warna' => 'blue'],
            'karyawan_edit'   => ['icon' => 'pen-to-square',   'warna' => 'amber'],
            'karyawan_hapus'  => ['icon' => 'user-minus',      'warna' => 'rose'],

            // Divisi
            'divisi_tambah'   => ['icon' => 'building',        'warna' => 'purple'],
            'divisi_edit'     => ['icon' => 'pen-to-square',   'warna' => 'amber'],
            'divisi_hapus'    => ['icon' => 'trash',           'warna' => 'rose'],

            // Perizinan
            'izin_setujui'    => ['icon' => 'circle-check',    'warna' => 'emerald'],
            'izin_tolak'      => ['icon' => 'circle-xmark',    'warna' => 'rose'],
            'izin_hapus'      => ['icon' => 'trash',           'warna' => 'rose'],

            // Absensi
            'absensi_hapus'   => ['icon' => 'calendar-xmark',  'warna' => 'rose'],

            // Laporan
            'laporan_excel'   => ['icon' => 'file-excel',      'warna' => 'emerald'],
            'laporan_pdf'     => ['icon' => 'file-pdf',        'warna' => 'rose'],

            // Lokasi
            'lokasi_update'   => ['icon' => 'location-dot',    'warna' => 'cyan'],
        ];

        $style = $map[$type] ?? ['icon' => 'circle-check', 'warna' => 'slate'];

        static::create([
            'type'      => $type,
            'judul'     => $judul,
            'deskripsi' => $deskripsi,
            'icon'      => $style['icon'],
            'warna'     => $style['warna'],
        ]);
    }
}

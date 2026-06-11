<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model AdminActivity
 *
 * Menyimpan log/riwayat semua aktivitas yang dilakukan admin di sistem.
 * Setiap aksi penting (tambah, edit, hapus karyawan/divisi/izin, ekspor laporan, dll)
 * dicatat ke tabel ini untuk keperluan audit trail dan ditampilkan di dashboard admin.
 *
 * Setiap aktivitas memiliki:
 * - type     : kode unik jenis aktivitas (misal: karyawan_tambah, divisi_hapus)
 * - judul    : label yang ditampilkan di UI
 * - deskripsi: detail/subjek aktivitas
 * - icon     : nama ikon FontAwesome untuk tampilan di dashboard
 * - warna    : kode warna untuk styling badge/icon
 *
 * @property int         $id         Primary key
 * @property string      $type       Kode jenis aktivitas (karyawan_tambah, divisi_edit, dll)
 * @property string      $judul      Judul aktivitas yang ditampilkan di UI
 * @property string|null $deskripsi  Detail/subjek aktivitas (opsional)
 * @property string      $icon       Nama ikon FontAwesome (misal: user-plus, trash)
 * @property string      $warna      Nama warna untuk styling (misal: blue, rose, emerald)
 */
class AdminActivity extends Model
{
    /**
     * Kolom-kolom yang boleh diisi secara mass assignment.
     *
     * @var array<string>
     */
    protected $fillable = [
        'type',
        'judul',
        'deskripsi',
        'icon',
        'warna',
    ];

    /**
     * Mencatat aktivitas admin ke database.
     *
     * Method static ini digunakan oleh semua controller admin untuk mencatat
     * setiap aksi penting. Icon dan warna otomatis ditentukan berdasarkan
     * tipe aktivitas menggunakan mapping internal.
     *
     * Contoh penggunaan:
     *   AdminActivity::log('karyawan_tambah', 'Menambahkan Karyawan Baru', 'John Doe - IT');
     *
     * @param string      $type       Kode jenis aktivitas (harus sesuai dengan $map di bawah)
     * @param string      $judul      Judul yang ditampilkan di UI
     * @param string|null $deskripsi  Detail/subjek aktivitas (opsional)
     * @return void
     */
    public static function log(string $type, string $judul, ?string $deskripsi = null): void
    {
        /**
         * Mapping tipe aktivitas ke icon dan warna.
         * Dikelompokkan berdasarkan modul:
         * - Karyawan  : tambah (blue), edit (amber), hapus (rose)
         * - Divisi    : tambah (purple), edit (amber), hapus (rose)
         * - Perizinan : setujui (emerald), tolak (rose), hapus (rose)
         * - Absensi   : hapus (rose)
         * - Laporan   : excel (emerald), pdf (rose)
         * - Lokasi    : update (cyan)
         */
        $map = [
            // Karyawan — aksi CRUD pada data karyawan
            'karyawan_tambah' => ['icon' => 'user-plus',       'warna' => 'blue'],
            'karyawan_edit'   => ['icon' => 'pen-to-square',   'warna' => 'amber'],
            'karyawan_hapus'  => ['icon' => 'user-minus',      'warna' => 'rose'],

            // Divisi — aksi CRUD pada data divisi
            'divisi_tambah'   => ['icon' => 'building',        'warna' => 'purple'],
            'divisi_edit'     => ['icon' => 'pen-to-square',   'warna' => 'amber'],
            'divisi_hapus'    => ['icon' => 'trash',           'warna' => 'rose'],

            // Perizinan — aksi persetujuan/penolakan izin karyawan
            'izin_setujui'    => ['icon' => 'circle-check',    'warna' => 'emerald'],
            'izin_tolak'      => ['icon' => 'circle-xmark',    'warna' => 'rose'],
            'izin_hapus'      => ['icon' => 'trash',           'warna' => 'rose'],

            // Absensi — penghapusan data absensi
            'absensi_hapus'   => ['icon' => 'calendar-xmark',  'warna' => 'rose'],

            // Laporan — ekspor laporan ke file
            'laporan_excel'   => ['icon' => 'file-excel',      'warna' => 'emerald'],
            'laporan_pdf'     => ['icon' => 'file-pdf',        'warna' => 'rose'],

            // Lokasi — perubahan pengaturan lokasi kantor
            'lokasi_update'   => ['icon' => 'location-dot',    'warna' => 'cyan'],
        ];

        // Ambil icon & warna dari mapping, fallback ke default jika tipe tidak dikenal
        $style = $map[$type] ?? ['icon' => 'circle-check', 'warna' => 'slate'];

        // Simpan record aktivitas baru ke database
        static::create([
            'type'      => $type,
            'judul'     => $judul,
            'deskripsi' => $deskripsi,
            'icon'      => $style['icon'],
            'warna'     => $style['warna'],
        ]);
    }
}

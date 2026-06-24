<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $karyawan
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereJamKeluar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereJamMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereUserId($value)
 */
	class Absensi extends \Eloquent {}
}

namespace App\Models{
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminActivity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminActivity whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminActivity whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminActivity whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminActivity whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminActivity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdminActivity whereWarna($value)
 */
	class AdminActivity extends \Eloquent {}
}

namespace App\Models{
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereJamKeluar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereJamMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereNamaDivisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereRadius($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Divisi whereUpdatedAt($value)
 */
	class Divisi extends \Eloquent {}
}

namespace App\Models{
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
 * @property string|null $tanggal
 * @property string|null $alasan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereAlasan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereAlasanTolak($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereDivisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereFileTambahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereTanggalMulai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Izin whereUserId($value)
 */
	class Izin extends \Eloquent {}
}

namespace App\Models{
/**
 * Model Setting
 *
 * Menyimpan konfigurasi sistem dalam format key-value.
 * Digunakan untuk menyimpan pengaturan yang bisa diubah oleh admin
 * tanpa perlu mengubah file .env atau konfigurasi Laravel.
 *
 * Saat ini digunakan untuk menyimpan:
 * - latitude   : koordinat latitude lokasi kantor (untuk validasi GPS absensi)
 * - longitude  : koordinat longitude lokasi kantor
 * - radius     : radius validasi GPS dalam meter
 *
 * Dikelola oleh admin melalui AdminKelolaDivisiController (updateLokasi).
 *
 * @property int    $id     Primary key
 * @property string $key    Nama/kunci pengaturan (unik)
 * @property string $value  Nilai pengaturan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereValue($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
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
 * @property time|null   $jam_masuk         Jam masuk kerja
 * @property time|null   $jam_keluar        Jam keluar kerja
 * @property date|null   $tgl_lahir         Tanggal lahir
 * @property string|null $jenis_kelamin     Jenis kelamin
 * @property string|null $alamat            Alamat
 * @property date|null   $tgl_bergabung     Tanggal mulai bekerja
 * @property string|null $no_hp             Nomor HP
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Absensi> $absensi
 * @property-read int|null $absensi_count
 * @property-read \App\Models\Divisi|null $divisiObj
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Izin> $izin
 * @property-read int|null $izin_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDivisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDivisiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereJamKeluar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereJamMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereKomentarNonaktif($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTglBergabung($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTglLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 */
	class User extends \Eloquent {}
}


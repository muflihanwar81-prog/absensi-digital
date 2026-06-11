<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
 */
class Setting extends Model
{
    /**
     * Kolom-kolom yang boleh diisi secara mass assignment.
     *
     * @var array<string>
     */
    protected $fillable = ['key', 'value'];

    /**
     * Ambil nilai setting berdasarkan key.
     * Jika key tidak ditemukan di database, kembalikan nilai default.
     *
     * Contoh penggunaan:
     *   $lat = Setting::get('latitude', '-6.200000');
     *
     * @param string     $key      Nama kunci setting yang dicari
     * @param mixed|null $default  Nilai default jika key tidak ditemukan
     * @return mixed  Nilai setting atau default
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Simpan atau update nilai setting berdasarkan key.
     * Menggunakan updateOrCreate sehingga:
     * - Jika key sudah ada → update value-nya
     * - Jika key belum ada → buat record baru
     *
     * Contoh penggunaan:
     *   Setting::set('latitude', '-6.175110');
     *
     * @param string $key    Nama kunci setting
     * @param mixed  $value  Nilai yang akan disimpan
     * @return \App\Models\Setting  Instance model yang dibuat/diupdate
     */
    public static function set($key, $value)
    {
        return self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}

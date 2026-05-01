<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    // Tambahkan baris ini agar Laravel merujuk ke tabel yang benar
    protected $table = 'absensi'; 

    protected $fillable = [
        'karyawan_id', // Pastikan nama kolom ini sama dengan yang di phpMyAdmin
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status'
    ];
}
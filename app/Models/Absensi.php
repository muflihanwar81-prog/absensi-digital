<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi'; // tetap kalau memang tabel kamu ini

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status'
    ];

    // 🔹 Casting biar otomatis jadi date/time
    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime',
        'jam_pulang' => 'datetime',
    ];

    // 🔹 Relasi ke Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
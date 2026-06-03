<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    protected $fillable = [
        'karyawan_id',
        'jenis',
        'keterangan',
        'tanggal',
        'bukti'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
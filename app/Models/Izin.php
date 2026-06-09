<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
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
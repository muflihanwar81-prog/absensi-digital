<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'divisi',
        'user_id'
    ];

    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Absensi;
use App\Models\User;
use App\Models\Divisi;

class Karyawan extends Authenticatable
{
    use HasFactory;

    protected $table = 'karyawans';

    protected $fillable = [
        'nip',
        'nama',
        'divisi_id',
        'divisi',
        'jabatan',
        'status',
        'jam_masuk',
        'jam_keluar',
        'email',
        'password',
        'username',
        'tgl_lahir',
        'jenis_kelamin',
        'alamat',
        'tgl_bergabung',
        'no_hp',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
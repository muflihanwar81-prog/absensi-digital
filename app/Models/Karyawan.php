<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Absensi;
use App\Models\User;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans';

    // app/Models/Karyawan.php

protected $fillable = [
    'nip',
    'nama',
    'divisi_id',
    'divisi',
    'jabatan',
    'status',
    'password',
];

protected $hidden = [
    'password',
];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }
}
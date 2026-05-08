<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
<<<<<<< HEAD
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
=======
   protected $fillable = [
    'name',
    'email',
    'password',
    'role'
];
>>>>>>> 9ec4a894840ead0e23b0906aea80a414521cc4fa

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
<<<<<<< HEAD
=======
    public function karyawan()
{
    return $this->hasOne(Karyawan::class);
}
>>>>>>> 9ec4a894840ead0e23b0906aea80a414521cc4fa
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class UpdateHpAlamatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $users = User::whereIn('role', ['karyawan', 'kepala_divisi'])->get();

        foreach ($users as $user) {
            $user->update([
                'no_hp' => $faker->phoneNumber,
                'alamat' => $faker->address,
            ]);
        }
    }
}

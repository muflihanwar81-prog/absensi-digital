<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DivisiKaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data lama agar tidak menumpuk, kecuali admin utama
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::where('email', '!=', 'admin@admin.com')->delete();
        Divisi::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $faker = Faker::create('id_ID');
        $divisis = ['HSE', 'M&R', 'HRD', 'IT'];
        $jamMasuk = '08:00:00';
        $jamKeluar = '17:00:00';
        $password = Hash::make('12345678');
        
        $usedEmails = [];
        $usedUsernames = [];

        // Helper function for unique email
        $getUniqueEmail = function($firstName) use (&$usedEmails) {
            $base = strtolower($firstName);
            $base = preg_replace('/[^a-z0-9]/', '', $base); // Hapus karakter aneh
            $email = $base . '@gmail.com';
            $counter = 1;
            while (in_array($email, $usedEmails)) {
                $email = $base . $counter . '@gmail.com';
                $counter++;
            }
            $usedEmails[] = $email;
            return $email;
        };

        // Helper function for unique username
        $getUniqueUsername = function($firstName) use (&$usedUsernames) {
            $base = strtolower($firstName);
            $base = preg_replace('/[^a-z0-9]/', '', $base);
            $username = $base;
            $counter = 1;
            while (in_array($username, $usedUsernames)) {
                $username = $base . $counter;
                $counter++;
            }
            $usedUsernames[] = $username;
            return $username;
        };

        // 1. Tambah Admin Karyawan
        $genderAdmin = $faker->randomElement(['male', 'female']);
        $firstNameAdmin = $faker->firstName($genderAdmin);
        $lastNameAdmin = $faker->lastName($genderAdmin);
        $namaAdmin = $firstNameAdmin . ' ' . $lastNameAdmin;

        User::create([
            'nip' => $faker->unique()->numerify('#####'),
            'nama' => $namaAdmin,
            'email' => $getUniqueEmail($firstNameAdmin),
            'jabatan' => 'Admin',
            'username' => $getUniqueUsername($firstNameAdmin),
            'password' => $password,
            'role' => 'admin',
            'status' => 'Aktif',
            'jenis_kelamin' => $genderAdmin === 'male' ? 'Laki-laki' : 'Perempuan',
            'tgl_bergabung' => now()->format('Y-m-d'),
        ]);

        foreach ($divisis as $namaDivisi) {
            // 2. Create Divisi
            $divisi = Divisi::create([
                'nama_divisi' => $namaDivisi,
                'jam_masuk' => $jamMasuk,
                'jam_keluar' => $jamKeluar,
            ]);

            // 3. Create Kepala Divisi
            $genderKadiv = $faker->randomElement(['male', 'female']);
            $firstNameKadiv = $faker->firstName($genderKadiv);
            $lastNameKadiv = $faker->lastName($genderKadiv);
            $namaKadiv = $firstNameKadiv . ' ' . $lastNameKadiv;
            
            User::create([
                'nip' => $faker->unique()->numerify('#####'),
                'nama' => $namaKadiv,
                'email' => $getUniqueEmail($firstNameKadiv),
                'divisi_id' => $divisi->id,
                'divisi' => $divisi->nama_divisi,
                'jabatan' => 'Kepala Divisi',
                'username' => $getUniqueUsername($firstNameKadiv),
                'password' => $password,
                'role' => 'kepala_divisi',
                'status' => 'Aktif',
                'jenis_kelamin' => $genderKadiv === 'male' ? 'Laki-laki' : 'Perempuan',
                'jam_masuk' => $jamMasuk,
                'jam_keluar' => $jamKeluar,
                'tgl_bergabung' => now()->format('Y-m-d'),
            ]);

            // 4. Create 20 Karyawan
            for ($i = 1; $i <= 20; $i++) {
                $genderKaryawan = $faker->randomElement(['male', 'female']);
                $firstNameKaryawan = $faker->firstName($genderKaryawan);
                $lastNameKaryawan = $faker->lastName($genderKaryawan);
                $namaKaryawan = $firstNameKaryawan . ' ' . $lastNameKaryawan;
                
                User::create([
                    'nip' => $faker->unique()->numerify('#####'),
                    'nama' => $namaKaryawan,
                    'email' => $getUniqueEmail($firstNameKaryawan),
                    'divisi_id' => $divisi->id,
                    'divisi' => $divisi->nama_divisi,
                    'jabatan' => 'Karyawan',
                    'username' => $getUniqueUsername($firstNameKaryawan),
                    'password' => $password,
                    'role' => 'karyawan',
                    'status' => 'Aktif',
                    'jenis_kelamin' => $genderKaryawan === 'male' ? 'Laki-laki' : 'Perempuan',
                    'jam_masuk' => $jamMasuk,
                    'jam_keluar' => $jamKeluar,
                    'tgl_bergabung' => now()->format('Y-m-d'),
                ]);
            }
        }
    }
}

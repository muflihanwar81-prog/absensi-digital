<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bersihkan data absensi sebelumnya agar tidak duplikat
        Absensi::truncate();

        // Ambil semua karyawan, kecualikan kepala divisi dan admin
        $karyawans = User::where('role', 'karyawan')->get();
        
        // Buat absen untuk 7 hari ke belakang sampai hari ini
        $startDate = Carbon::now()->subDays(7);
        $endDate = Carbon::now();

        foreach ($karyawans as $karyawan) {
            // Looping per hari
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                
                // Lewati akhir pekan (Sabtu & Minggu) untuk membuatnya lebih realistis
                if ($date->isWeekend()) {
                    continue;
                }

                // Probabilitas status (Hadir lebih banyak agar realistis)
                $statusOptions = [
                    'Hadir', 'Hadir', 'Hadir', 'Hadir', 'Hadir', 'Hadir', 'Hadir', 
                    'Terlambat', 'Terlambat', 
                    'Izin', 
                    'Sakit', 
                    'Alpha'
                ];
                $status = $statusOptions[array_rand($statusOptions)];
                
                $jamMasuk = null;
                $jamKeluar = null;
                
                if ($status === 'Hadir') {
                    // Jam masuk acak antara 07:30 - 08:00
                    $jamMasuk = Carbon::createFromTime(8, 0, 0)->subMinutes(rand(0, 30))->format('H:i:s');
                    // Jam keluar acak antara 17:00 - 17:30
                    $jamKeluar = Carbon::createFromTime(17, 0, 0)->addMinutes(rand(0, 30))->format('H:i:s');
                } elseif ($status === 'Terlambat') {
                    // Jam masuk acak antara 08:05 - 09:00
                    $jamMasuk = Carbon::createFromTime(8, 0, 0)->addMinutes(rand(5, 60))->format('H:i:s');
                    $jamKeluar = Carbon::createFromTime(17, 0, 0)->addMinutes(rand(0, 30))->format('H:i:s');
                }
                
                Absensi::create([
                    'user_id' => $karyawan->id,
                    'tanggal' => $date->format('Y-m-d'),
                    'jam_masuk' => $jamMasuk,
                    'jam_keluar' => $jamKeluar,
                    'status' => $status
                ]);
            }
        }
    }
}

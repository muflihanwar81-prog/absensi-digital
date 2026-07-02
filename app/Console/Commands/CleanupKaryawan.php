<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CleanupKaryawan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-karyawan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus karyawan, sisakan 5 karyawan per divisi dan tidak menghapus kepala divisi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses cleanup karyawan...');

        // 1. Dapatkan semua divisi unik yang dimiliki oleh karyawan
        $divisis = User::where('role', 'karyawan')
            ->whereNotNull('divisi_id')
            ->select('divisi_id')
            ->distinct()
            ->get();

        $deletedCount = 0;
        $keptCount = 0;

        foreach ($divisis as $divisi) {
            // Dapatkan semua karyawan untuk divisi ini, urutkan berdasarkan id
            $karyawans = User::where('role', 'karyawan')
                ->where('divisi_id', $divisi->divisi_id)
                ->orderBy('id', 'asc')
                ->get();

            $count = 0;
            foreach ($karyawans as $karyawan) {
                $count++;
                if ($count > 5) {
                    $karyawan->delete();
                    $deletedCount++;
                } else {
                    $keptCount++;
                }
            }
        }

        // 2. Bagaimana dengan karyawan yang tidak memiliki divisi_id?
        // Kita juga bisa menyisakan maksimal 5 karyawan yang tidak memiliki divisi_id
        $noDivisiKaryawan = User::where('role', 'karyawan')
            ->whereNull('divisi_id')
            ->orderBy('id', 'asc')
            ->get();
            
        $countNoDiv = 0;
        foreach ($noDivisiKaryawan as $karyawan) {
            $countNoDiv++;
            if ($countNoDiv > 5) {
                $karyawan->delete();
                $deletedCount++;
            } else {
                $keptCount++;
            }
        }

        // 3. Pastikan kepala_divisi tidak terhapus (hanya mengecek jumlah saat ini)
        $kepalaDivisiCount = User::where('role', 'kepala_divisi')->count();

        $this->info("Proses selesai.");
        $this->line("Total karyawan dihapus: <error>{$deletedCount}</error>");
        $this->line("Total karyawan dipertahankan: <info>{$keptCount}</info>");
        $this->line("Total kepala divisi saat ini (tidak dihapus): <info>{$kepalaDivisiCount}</info>");
    }
}

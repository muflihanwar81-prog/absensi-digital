<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDataKaryawanController extends Controller
{
    public function index()
    {
        // Dummy Data Karyawan
        $karyawans = collect([
            (object)[
                'nip' => '2025001',
                'nama' => 'Ita Purba',
                'divisi' => 'Divisi A',
                'jabatan' => 'Frontend Developer',
                'status' => 'Aktif',
            ],

            (object)[
                'nip' => '2025002',
                'nama' => 'Budi Santoso',
                'divisi' => 'Divisi B',
                'jabatan' => 'Backend Developer',
                'status' => 'Aktif',
            ],

            (object)[
                'nip' => '2025003',
                'nama' => 'Siti Aulia',
                'divisi' => 'Divisi C',
                'jabatan' => 'UI/UX Designer',
                'status' => 'Cuti',
            ],
        ]);

        // Statistik Divisi
        $stats = [
            'divisi_a' => $karyawans->where('divisi', 'Divisi A')->count(),
            'divisi_b' => $karyawans->where('divisi', 'Divisi B')->count(),
            'divisi_c' => $karyawans->where('divisi', 'Divisi C')->count(),
            'divisi_d' => $karyawans->where('divisi', 'Divisi D')->count(),
        ];

        return view('admin/admindatakaryawan', compact('karyawans', 'stats'));
    }
}
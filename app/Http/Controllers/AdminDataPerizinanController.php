<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDataPerizinanController extends Controller
{
    public function index()
    {
        $perizinan = collect([
            (object)[
                'nip' => '2025001',
                'nama' => 'Ita Purba',
                'jenis' => 'Sakit',
                'tanggal' => '2026-05-04',
                'keterangan' => 'Demam tinggi',
                'status' => 'Disetujui',
            ],
            (object)[
                'nip' => '2025003',
                'nama' => 'Siti Aulia',
                'jenis' => 'Cuti',
                'tanggal' => '2026-05-05',
                'keterangan' => 'Urusan Keluarga',
                'status' => 'Pending',
            ],
        ]);

        return view('admin.AdminDataPerizinan', compact('perizinan'));
    }
}
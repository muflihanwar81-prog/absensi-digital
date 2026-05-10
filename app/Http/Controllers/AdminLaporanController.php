<?php

namespace App\Http\Controllers;

use App\Models\Absensi;

class AdminLaporanController extends Controller
{
    public function index()
    {
        $data = Absensi::with(['karyawan.divisi'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.laporan', compact('data'));
    }
}

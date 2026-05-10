<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Izin;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanDashboardController extends Controller
{
    public function index()
    {
        $karyawanId = session('karyawan_id');

        if (!$karyawanId) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $karyawan = Karyawan::findOrFail($karyawanId);

        $hadir = Absensi::where('karyawan_id', $karyawanId)
            ->where('status', 'Hadir')
            ->count();

        $terlambat = Absensi::where('karyawan_id', $karyawanId)
            ->where('status', 'Terlambat')
            ->count();

        $tidakHadir = Absensi::where('karyawan_id', $karyawanId)
            ->where('status', 'Tidak Hadir')
            ->count();

        $izin = Izin::where('karyawan_id', $karyawanId)
            ->count();

        $aktivitas = Absensi::where('karyawan_id', $karyawanId)
            ->latest()
            ->take(10)
            ->get();

        session([
            'karyawan_nama' => $karyawan->nama,
            'karyawan_divisi' => $karyawan->divisi,
            'karyawan_jabatan' => $karyawan->jabatan,
        ]);

        return view('karyawan.dashboard', compact(
            'karyawan',
            'hadir',
            'terlambat',
            'tidakHadir',
            'izin',
            'aktivitas'
        ));
    }
}
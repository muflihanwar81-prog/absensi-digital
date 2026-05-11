<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DivisiDashboardController extends Controller
{
    /**
     * Dashboard Divisi
     */
   public function index()
{
    $user = Auth::user();

    $nama_user = $user->name;
    $namaDivisi = $user->name;
    $divisi = $namaDivisi;

    $total_karyawan = Karyawan::where('divisi', $namaDivisi)->count();

    $hadir = Absensi::where('divisi', $namaDivisi)
        ->where('status', 'Hadir')
        ->count();

    $terlambat = Absensi::where('divisi', $namaDivisi)
        ->where('status', 'Terlambat')
        ->count();

    $alpha = Absensi::where('divisi', $namaDivisi)
        ->where('status', 'Alpha')
        ->count();

    $izin = Izin::where('divisi', $namaDivisi)
        ->whereIn('kategori', ['Izin', 'Cuti'])
        ->count();

    $sakit = Izin::where('divisi', $namaDivisi)
        ->where('kategori', 'Sakit')
        ->count();

    return view('divisi.DashboardDivisi', compact(
        'nama_user',
        'divisi',
        'total_karyawan',
        'hadir',
        'terlambat',
        'alpha',
        'izin',
        'sakit'
    ));
}
    public function karyawan()
    {
        $user = Auth::user();
        $namaDivisi = $user->name;

        $karyawans = Karyawan::where('divisi', $namaDivisi)
            ->orderBy('nama')
            ->get();

        return view('divisi.DataKaryawanDivisi', compact('karyawans'));
    }

    public function riwayatAbsensi()
    {
        $user = Auth::user();
        $namaDivisi = $user->name;

        $absensi = Absensi::where('divisi', $namaDivisi)
            ->latest()
            ->get();

        return view('divisi.RiwayatAbsensiDivisi', compact('absensi'));
    }

    public function perizinan()
    {
        $user = Auth::user();
        $namaDivisi = $user->name;

        $data = Izin::where('divisi', $namaDivisi)
            ->latest()
            ->get();

        return view('divisi.DivisiPerizinan', compact('data'));
    }

    public function laporan()
    {
        $user = Auth::user();
        $namaDivisi = $user->name;

        $karyawans = Karyawan::where('divisi', $namaDivisi)->get();
        $absensi = Absensi::where('divisi', $namaDivisi)->get();
        $izins = Izin::where('divisi', $namaDivisi)->get();

        return view('divisi.DivisiLaporan', compact(
            'karyawans',
            'absensi',
            'izins'
        ));
    }
}
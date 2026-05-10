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

        // Nama divisi diambil dari akun yang login
        // Misalnya akun user name = HR, maka hanya data divisi HR yang ditampilkan
        $namaDivisi = $user->name;

        // Statistik dashboard
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
            'total_karyawan',
            'hadir',
            'terlambat',
            'alpha',
            'izin',
            'sakit'
        ));
    }

    /**
     * Data Karyawan berdasarkan divisi yang login
     */
    public function karyawan()
    {
        $user = Auth::user();
        $namaDivisi = $user->name;

        $karyawans = Karyawan::where('divisi', $namaDivisi)
            ->orderBy('nama')
            ->get();

        return view('divisi.DataKaryawanDivisi', compact('karyawans'));
    }

    /**
     * Riwayat Absensi berdasarkan divisi yang login
     */
    public function riwayatAbsensi()
    {
        $user = Auth::user();
        $namaDivisi = $user->name;

        $absensi = Absensi::where('divisi', $namaDivisi)
            ->latest()
            ->get();

        return view('divisi.RiwayatAbsensiDivisi', compact('absensi'));
    }

    /**
     * Data Perizinan berdasarkan divisi yang login
     */
    public function perizinan()
    {
        $user = Auth::user();
        $namaDivisi = $user->name;

        $data = Izin::where('divisi', $namaDivisi)
            ->latest()
            ->get();

        return view('divisi.DivisiPerizinan', compact('data'));
    }

    /**
     * Laporan Divisi
     */
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
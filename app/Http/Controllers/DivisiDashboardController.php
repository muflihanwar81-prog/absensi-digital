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
     * Nama divisi diambil dari field 'name' user kepala_divisi.
     * Pastikan user kepala_divisi dibuat dengan name = nama divisinya.
     */
    public function index()
    {
        $user = Auth::user();

        $nama_user  = $user->name;
        $namaDivisi = $user->name;
        $divisi     = $namaDivisi;

        // Ambil ID karyawan yang ada di divisi ini
        $karyawanIds = Karyawan::where('divisi', $namaDivisi)->pluck('id');

        $total_karyawan = $karyawanIds->count();

        $hadir = Absensi::whereIn('karyawan_id', $karyawanIds)
            ->where('status', 'Hadir')
            ->count();

        $terlambat = Absensi::whereIn('karyawan_id', $karyawanIds)
            ->where('status', 'Terlambat')
            ->count();

        $alpha = Absensi::whereIn('karyawan_id', $karyawanIds)
            ->whereIn('status', ['Alpha', 'Tidak Hadir'])
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
        $user       = Auth::user();
        $namaDivisi = $user->name;

        $karyawans = Karyawan::where('divisi', $namaDivisi)
            ->orderBy('nama')
            ->get();

        return view('divisi.DataKaryawanDivisi', compact('karyawans'));
    }

    public function riwayatAbsensi()
    {
        $user       = Auth::user();
        $namaDivisi = $user->name;

        // Ambil ID karyawan di divisi ini
        $karyawanIds = Karyawan::where('divisi', $namaDivisi)->pluck('id');

        $absensi = Absensi::with('karyawan')
            ->whereIn('karyawan_id', $karyawanIds)
            ->latest()
            ->get();

        return view('divisi.RiwayatAbsensiDivisi', compact('absensi'));
    }

    public function perizinan()
    {
        $user       = Auth::user();
        $namaDivisi = $user->name;

        $data = Izin::where('divisi', $namaDivisi)
            ->latest()
            ->get();

        return view('divisi.DivisiPerizinan', compact('data'));
    }

    public function laporan()
    {
        $user       = Auth::user();
        $namaDivisi = $user->name;

        $karyawanIds = Karyawan::where('divisi', $namaDivisi)->pluck('id');

        $karyawans = Karyawan::where('divisi', $namaDivisi)->get();
        $absensi   = Absensi::with('karyawan')
            ->whereIn('karyawan_id', $karyawanIds)
            ->get();
        $izins     = Izin::where('divisi', $namaDivisi)->get();

        return view('divisi.DivisiLaporan', compact(
            'karyawans',
            'absensi',
            'izins'
        ));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Izin;
use App\Models\AdminActivity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard admin.
     * Statistik kehadiran dihitung secara akurat berdasarkan kondisi:
     * - Hadir        : ada record absensi hari ini dengan status Hadir (tidak terlambat)
     * - Terlambat    : ada record absensi hari ini dengan status Terlambat
     * - Izin/Sakit   : ada record absensi hari ini dengan status Izin/Sakit
     * - Belum Absen  : karyawan aktif yang belum punya record absensi hari ini sama sekali
     */
    public function index()
    {
        $today = Carbon::today()->toDateString();

        // Total divisi terdaftar
        $totalDivisi = Divisi::count();

        // Hanya karyawan dengan status Aktif
        $totalKaryawan = Karyawan::where('status', 'Aktif')->count();

        // ID semua karyawan aktif
        $semuaKaryawanIds = Karyawan::where('status', 'Aktif')->pluck('id');

        // Hadir = punya record absensi hari ini, status Hadir (tepat waktu)
        $totalHadir = Absensi::whereDate('tanggal', $today)
            ->where('status', 'Hadir')
            ->whereIn('karyawan_id', $semuaKaryawanIds)
            ->count();

        // Terlambat = punya record absensi hari ini, status Terlambat
        $totalTerlambat = Absensi::whereDate('tanggal', $today)
            ->where('status', 'Terlambat')
            ->whereIn('karyawan_id', $semuaKaryawanIds)
            ->count();

        // Izin = punya record absensi hari ini dengan status Izin
        $totalIzin = Absensi::whereDate('tanggal', $today)
            ->where('status', 'Izin')
            ->whereIn('karyawan_id', $semuaKaryawanIds)
            ->count();

        // Sakit = punya record absensi hari ini dengan status Sakit
        $totalSakit = Absensi::whereDate('tanggal', $today)
            ->where('status', 'Sakit')
            ->whereIn('karyawan_id', $semuaKaryawanIds)
            ->count();

        // Alpha = karyawan aktif yang TIDAK punya record absensi sama sekali hari ini
        // (belum absen, tidak izin, tidak sakit)
        $sudahAbsenIds = Absensi::whereDate('tanggal', $today)
            ->whereIn('karyawan_id', $semuaKaryawanIds)
            ->pluck('karyawan_id');

        $totalBelumAbsen = $semuaKaryawanIds->diff($sudahAbsenIds)->count();

        // Total kehadiran (hadir tepat waktu + terlambat)
        $totalMasuk = $totalHadir + $totalTerlambat;

        // Persentase kehadiran hari ini
        $persentaseHadir = $totalKaryawan > 0
            ? round(($totalMasuk / $totalKaryawan) * 100)
            : 0;

        // Izin pending yang menunggu persetujuan
        $totalIzinPending = Izin::where('status', 'Menunggu')->count();

        // 5 aktivitas admin terbaru
        $activities = AdminActivity::latest()->take(5)->get();

        // Daftar divisi untuk dropdown filter
        $divisiList = Divisi::orderBy('nama_divisi')->get();

        return view('admin.dashboard', compact(
            'totalDivisi',
            'totalKaryawan',
            'totalHadir',
            'totalTerlambat',
            'totalIzin',
            'totalSakit',
            'totalBelumAbsen',
            'totalMasuk',
            'persentaseHadir',
            'totalIzinPending',
            'activities',
            'divisiList'
        ));
    }

    /**
     * Endpoint AJAX: statistik per divisi untuk filter dropdown di dashboard.
     * Return JSON, dipanggil tanpa reload halaman.
     */
    public function stats(Request $request)
    {
        $today    = Carbon::today()->toDateString();
        $divisiId = $request->query('divisi_id');

        // Tentukan scope karyawan: per divisi atau semua
        $karyawanQuery = Karyawan::where('status', 'Aktif');
        if ($divisiId) {
            $divisi = Divisi::find($divisiId);
            if ($divisi) {
                $karyawanQuery->where('divisi', $divisi->nama_divisi);
            }
        }
        $karyawanIds = $karyawanQuery->pluck('id');
        $totalKaryawan = $karyawanIds->count();

        // Hitung statistik berdasarkan scope karyawan
        $totalHadir = Absensi::whereDate('tanggal', $today)
            ->where('status', 'Hadir')
            ->whereIn('karyawan_id', $karyawanIds)
            ->count();

        $totalTerlambat = Absensi::whereDate('tanggal', $today)
            ->where('status', 'Terlambat')
            ->whereIn('karyawan_id', $karyawanIds)
            ->count();

        $totalIzin = Absensi::whereDate('tanggal', $today)
            ->where('status', 'Izin')
            ->whereIn('karyawan_id', $karyawanIds)
            ->count();

        $totalSakit = Absensi::whereDate('tanggal', $today)
            ->where('status', 'Sakit')
            ->whereIn('karyawan_id', $karyawanIds)
            ->count();

        // Karyawan yang belum absen sama sekali hari ini
        $sudahAbsenIds = Absensi::whereDate('tanggal', $today)
            ->whereIn('karyawan_id', $karyawanIds)
            ->pluck('karyawan_id');
        $totalBelumAbsen = $karyawanIds->diff($sudahAbsenIds)->count();

        $totalMasuk      = $totalHadir + $totalTerlambat;
        $persentaseHadir = $totalKaryawan > 0
            ? round(($totalMasuk / $totalKaryawan) * 100)
            : 0;

        return response()->json(compact(
            'totalKaryawan',
            'totalHadir',
            'totalTerlambat',
            'totalIzin',
            'totalSakit',
            'totalBelumAbsen',
            'totalMasuk',
            'persentaseHadir'
        ));
    }
}

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

    public function index()
    {
        $today = Carbon::today()->toDateString();

        // Total divisi
        $totalDivisi = Divisi::count();

        // Hanya karyawan dengan status Aktif
        $totalKaryawan = Karyawan::where('status', 'Aktif')->count();

        // ID semua karyawan aktif
        $semuaKaryawanIds = Karyawan::where('status', 'Aktif')->pluck('id');

        // karyawan yg hadir
        $totalHadir = Absensi::whereDate('tanggal', $today)
            ->where('status', 'Hadir')
            ->whereIn('karyawan_id', $semuaKaryawanIds)
            ->count();

        // karyawan yg terlambat
        $totalTerlambat = Absensi::whereDate('tanggal', $today)
            ->where('status', 'Terlambat')
            ->whereIn('karyawan_id', $semuaKaryawanIds)
            ->count();

        // karyawan yg izin
        $totalIzin = Absensi::whereDate('tanggal', $today)
            ->where('status', 'Izin')
            ->whereIn('karyawan_id', $semuaKaryawanIds)
            ->count();

        // karyawan yg sakit
        $totalSakit = Absensi::whereDate('tanggal', $today)
            ->where('status', 'Sakit')
            ->whereIn('karyawan_id', $semuaKaryawanIds)
            ->count();

        // karyawan yang belum absen sama sekali hari ini
        $sudahAbsenIds = Absensi::whereDate('tanggal', $today)
            ->whereIn('karyawan_id', $semuaKaryawanIds)
            ->pluck('karyawan_id');

        $totalBelumAbsen = $semuaKaryawanIds->diff($sudahAbsenIds)->count();

        // Total kehadiran
        $totalMasuk = $totalHadir + $totalTerlambat;

        // Persentase kehadiran hari ini
        $persentaseHadir = $totalKaryawan > 0
            ? round(($totalMasuk / $totalKaryawan) * 100)
            : 0;

        // Izin yang masih pending
        $totalIzinPending = Izin::where('status', 'Menunggu')->count();

        // 5 aktivitas admin terbaru
        $activities = AdminActivity::latest()->take(5)->get();

        // Daftar divisi untuk filter dropdown
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

        // Hitung statistik absensi untuk karyawan hari ini 
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

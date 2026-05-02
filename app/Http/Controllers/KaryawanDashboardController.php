<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

class KaryawanDashboardController extends Controller
{
    // 🔹 DASHBOARD
    public function index()
    {
        $user = Auth::user();

        // 🔥 CEGAH ERROR kalau belum ada relasi karyawan
        if (!$user->karyawan) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan');
        }

        $karyawan = $user->karyawan;
        $today = now()->toDateString();

        $absensiHariIni = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->first();

        // 🔥 HITUNG STATISTIK REAL
        $hadir = Absensi::where('karyawan_id', $karyawan->id)
            ->where('status', 'hadir')->count();

        $terlambat = Absensi::where('karyawan_id', $karyawan->id)
            ->where('status', 'terlambat')->count();

        $izin = Absensi::where('karyawan_id', $karyawan->id)
            ->where('status', 'izin')->count();

        $alpha = Absensi::where('karyawan_id', $karyawan->id)
            ->where('status', 'alpha')->count();

        return view('karyawan.dashboard', compact(
            'absensiHariIni',
            'hadir',
            'terlambat',
            'izin',
            'alpha'
        ));
    }

    // 🔹 ABSEN MASUK
    public function absenMasuk()
    {
        $karyawan = Auth::user()->karyawan;
        $today = now()->toDateString();

        // ❌ cegah double absen
        $cek = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($cek) {
            return back()->with('error', 'Kamu sudah absen hari ini');
        }

        Absensi::create([
            'karyawan_id' => $karyawan->id,
            'tanggal' => $today,
            'jam_masuk' => now(),
            'status' => 'hadir'
        ]);

        return back()->with('success', 'Absen berhasil');
    }

    // 🔹 TIDAK HADIR
    public function tidakHadir()
    {
        $karyawan = Auth::user()->karyawan;
        $today = now()->toDateString();

        $cek = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($cek) {
            return back()->with('error', 'Sudah ada data hari ini');
        }

        Absensi::create([
            'karyawan_id' => $karyawan->id,
            'tanggal' => $today,
            'status' => 'alpha'
        ]);

        return back()->with('success', 'Status tidak hadir dicatat');
    }

    // 🔹 RIWAYAT
    public function riwayat()
    {
        $karyawan = Auth::user()->karyawan;

        $data = Absensi::where('karyawan_id', $karyawan->id)
            ->latest()
            ->get();

        return view('karyawan.riwayat', compact('data'));
    }

    // 🔹 PROFILE
    public function profile()
    {
        $user = Auth::user();
        return view('karyawan.profile', compact('user'));
    }
}
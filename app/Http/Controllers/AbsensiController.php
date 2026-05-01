<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi; // Pastikan kamu sudah punya model Absensi
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        // Mengambil data absensi hari ini untuk user yang sedang login
        $absensiHariIni = Absensi::where('karyawan_id', Auth::id())
            ->whereDate('tanggal', Carbon::today())
            ->first();

        return view('karyawan_absensi', compact('absensiHariIni'));
    }

    public function masuk(Request $request)
    {
        $userId = Auth::id();
        $tanggal = Carbon::today()->toDateString();
        $jamMasuk = Carbon::now()->toTimeString();

        // Cek apakah sudah absen masuk hari ini
        $cek = Absensi::where('karyawan_id', $userId)->whereDate('tanggal', $tanggal)->first();

        if ($cek) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absen masuk hari ini.');
        }

        Absensi::create([
            'karyawan_id' => $userId,
            'tanggal' => $tanggal,
            'jam_masuk' => $jamMasuk,
            'status' => 'Hadir' // Kamu bisa tambah logika jika jam > 08:00 maka 'Terlambat'
        ]);

        return redirect()->back()->with('success', 'Berhasil absen masuk pada jam ' . $jamMasuk);
    }

    public function pulang(Request $request)
    {
        $userId = Auth::id();
        $tanggal = Carbon::today()->toDateString();
        $jamPulang = Carbon::now()->toTimeString();

        $absensi = Absensi::where('karyawan_id', $userId)->whereDate('tanggal', $tanggal)->first();

        if (!$absensi) {
            return redirect()->back()->with('error', 'Anda belum melakukan absen masuk.');
        }

        if ($absensi->jam_pulang) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absen pulang.');
        }

        $absensi->update([
            'jam_pulang' => $jamPulang
        ]);

        return redirect()->back()->with('success', 'Berhasil absen pulang pada jam ' . $jamPulang);
    }
}
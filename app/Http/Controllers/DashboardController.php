<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $absensiHariIni = Absensi::where('karyawan_id', $user->id)
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        return view('admin.dashboard', compact('user', 'absensiHariIni'));
    }

    public function masuk()
    {
        $user = Auth::user();

        $cek = Absensi::where('karyawan_id', $user->id)
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        if ($cek) {
            return back()->with('error', 'Sudah absen hari ini');
        }

        Absensi::create([
            'karyawan_id' => $user->id,
            'tanggal' => now(),
            'jam_masuk' => now(),
        ]);

        return back()->with('success', 'Absen masuk berhasil');
    }

    public function pulang()
    {
        $user = Auth::user();

        $absen = Absensi::where('karyawan_id', $user->id)
            ->whereDate('tanggal', now()->toDateString())
            ->first();

        if (!$absen) {
            return back()->with('error', 'Belum absen masuk');
        }

        if ($absen->jam_pulang) {
            return back()->with('error', 'Sudah absen pulang');
        }

        $absen->update([
            'jam_pulang' => now(),
        ]);

        return back()->with('success', 'Absen pulang berhasil');
    }
}
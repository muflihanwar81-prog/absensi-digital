<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Izin;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;

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

    public function absenMasuk()
    {
        $karyawanId = session('karyawan_id');

        if (!$karyawanId) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $today = Carbon::today()->toDateString();

        $absensi = Absensi::where('karyawan_id', $karyawanId)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$absensi) {
            Absensi::create([
                'karyawan_id' => $karyawanId,
                'tanggal'     => $today,
                'jam_masuk' => now()->setTimezone('Asia/Jakarta')->format('H:i:s'),
                'status'      => 'Hadir',
            ]);
        }

        return redirect()->back()
            ->with('success', 'Absensi masuk berhasil.');
    }

    public function absenPulang()
    {
        $karyawanId = session('karyawan_id');

        if (!$karyawanId) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $today = Carbon::today()->toDateString();

        $absensi = Absensi::where('karyawan_id', $karyawanId)
            ->whereDate('tanggal', $today)
            ->first();

        if ($absensi && !$absensi->jam_keluar) {
            $absensi->update([
                'jam_keluar' => now()->setTimezone('Asia/Jakarta')->format('H:i:s'),
            ]);
        }

        return redirect()->back()
            ->with('success', 'Absensi pulang berhasil.');
    }

    public function kehadiran(Request $request)
    {
        $karyawanId = session('karyawan_id');

        if (!$karyawanId) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $query = Absensi::where('karyawan_id', $karyawanId);

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $karyawan = Karyawan::findOrFail($karyawanId);

        $absensis = $query->orderBy('tanggal', 'desc')->get();

        $absensis->transform(function ($item) use ($karyawan) {
            $item->nama_karyawan = $karyawan->nama;
            $item->nip           = $karyawan->nip ?? '-';
            $item->divisi        = $karyawan->divisi ?? '-';
            $item->jabatan       = $karyawan->jabatan ?? '-';
            return $item;
        });

        return view('karyawan.kehadiran', compact('absensis'));
    }
}
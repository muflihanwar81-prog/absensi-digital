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

    public function absenMasuk(Request $request)
    {
        $karyawanId = session('karyawan_id');

        if (!$karyawanId) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi GPS
        $gpsCheck = $this->validateGPSLocation($request);
        if (!$gpsCheck['status']) {
            return redirect()->back()->with('error', $gpsCheck['message']);
        }

        $today = Carbon::today()->toDateString();

        $absensi = Absensi::where('karyawan_id', $karyawanId)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$absensi) {
            $karyawan = Karyawan::with('divisi')
                ->findOrFail($karyawanId);

            $jamSekarang = Carbon::now('Asia/Jakarta');

            $jamMasukDivisi = Carbon::today('Asia/Jakarta')
                ->setTimeFromTimeString($karyawan->getRelation('divisi')->jam_masuk);
            $status = $jamSekarang->gt($jamMasukDivisi)
                ? 'Terlambat'
                : 'Hadir';

            Absensi::create([
                'karyawan_id' => $karyawanId,
                'tanggal'     => $today,
                'jam_masuk'   => $jamSekarang->format('H:i:s'),
                'status'      => $status,
            ]);
        }

        return redirect()->back()
            ->with('success', 'Absensi masuk berhasil.');
    }

    public function absenPulang(Request $request)
    {
        $karyawanId = session('karyawan_id');

        if (!$karyawanId) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi GPS
        $gpsCheck = $this->validateGPSLocation($request);
        if (!$gpsCheck['status']) {
            return redirect()->back()->with('error', $gpsCheck['message']);
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

    private function validateGPSLocation(Request $request)
    {
        $latOffice = doubleval(\App\Models\Setting::get('latitude', '-6.200000'));
        $lngOffice = doubleval(\App\Models\Setting::get('longitude', '106.816666'));
        $radius = doubleval(\App\Models\Setting::get('radius', '100'));

        $latUser = $request->input('latitude');
        $lngUser = $request->input('longitude');

        if (is_null($latUser) || is_null($lngUser)) {
            return [
                'status' => false,
                'message' => 'Gagal memverifikasi lokasi. Pastikan GPS Anda aktif dan berikan izin akses lokasi.'
            ];
        }

        $latUser = doubleval($latUser);
        $lngUser = doubleval($lngUser);

        // Haversine formula
        $earthRadius = 6371000; // in meters
        $latFrom = deg2rad($latOffice);
        $lonFrom = deg2rad($lngOffice);
        $latTo = deg2rad($latUser);
        $lonTo = deg2rad($lngUser);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        $distance = $angle * $earthRadius;

        if ($distance > $radius) {
            return [
                'status' => false,
                'message' => 'Anda berada di luar radius lokasi absensi yang diperbolehkan (Jarak Anda: ' . round($distance) . ' meter, Radius maks: ' . $radius . ' meter).'
            ];
        }

        return ['status' => true];
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

    public function riwayat(Request $request)
    {
        $karyawanId = session('karyawan_id');

        if (!$karyawanId) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $karyawan = Karyawan::findOrFail($karyawanId);

        $absensis = Absensi::where('karyawan_id', $karyawanId)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('karyawan.kehadiran', compact('absensis', 'karyawan'));
    }

    public function profile()
    {
        $karyawanId = session('karyawan_id');

        if (!$karyawanId) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $karyawan = Karyawan::with('divisi')->findOrFail($karyawanId);

        return view('karyawan.dashboard', compact('karyawan'));
    }
}
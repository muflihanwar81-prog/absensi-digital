<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Izin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class KaryawanDashboardController extends Controller
{
    public function index()
    {
        $karyawan = Auth::user();

        if (!$karyawan) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $karyawanId = $karyawan->id;

        $hadir = Absensi::where('user_id', $karyawanId)
            ->whereIn('status', ['Hadir', 'Terlambat'])
            ->count();

        $terlambat = Absensi::where('user_id', $karyawanId)
            ->where('status', 'Terlambat')
            ->count();

        $tidakHadir = Absensi::where('user_id', $karyawanId)
            ->where('status', 'Tidak Hadir')
            ->count();

        $izin = Izin::where('user_id', $karyawanId)
            ->count();

        $aktivitas = Absensi::where('user_id', $karyawanId)
            ->latest()
            ->take(10)
            ->get();

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
        $karyawan = Auth::user();

        if (!$karyawan) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $karyawanId = $karyawan->id;

        // Validasi GPS
        $gpsCheck = $this->validateGPSLocation($request);
        if (!$gpsCheck['status']) {
            return redirect()->back()->with('error', $gpsCheck['message']);
        }

        $today = Carbon::today()->toDateString();

        $absensi = Absensi::where('user_id', $karyawanId)
            ->whereDate('tanggal', $today)
            ->first();

        if ($absensi) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absen masuk hari ini.');
        }

        $jamSekarang = Carbon::now('Asia/Jakarta');

        $jamMasukDivisi = Carbon::today('Asia/Jakarta')
            ->setTimeFromTimeString(optional($karyawan->divisiObj)->jam_masuk ?? '08:00:00');
        $status = $jamSekarang->gt($jamMasukDivisi)
            ? 'Terlambat'
            : 'Hadir';

        Absensi::create([
            'user_id'     => $karyawanId,
            'tanggal'     => $today,
            'jam_masuk'   => $jamSekarang->format('H:i:s'),
            'status'      => $status,
        ]);

        return redirect()->back()
            ->with('success', 'Absensi masuk berhasil.');
    }

    public function absenPulang(Request $request)
    {
        $karyawan = Auth::user();

        if (!$karyawan) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $karyawanId = $karyawan->id;

        // Validasi GPS
        $gpsCheck = $this->validateGPSLocation($request);
        if (!$gpsCheck['status']) {
            return redirect()->back()->with('error', $gpsCheck['message']);
        }

        $today = Carbon::today()->toDateString();

        $absensi = Absensi::where('user_id', $karyawanId)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$absensi) {
            return redirect()->back()->with('error', 'Anda belum melakukan absen masuk hari ini.');
        }

        if ($absensi->jam_keluar) {
            return redirect()->back()->with('error', 'Anda sudah melakukan absen pulang hari ini.');
        }

        $absensi->update([
            'jam_keluar' => now()->setTimezone('Asia/Jakarta')->format('H:i:s'),
        ]);

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
        $karyawan = Auth::user();

        if (!$karyawan) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $karyawanId = $karyawan->id;

        $query = Absensi::where('user_id', $karyawanId);

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
        $karyawan = Auth::user();

        if (!$karyawan) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $absensis = Absensi::where('user_id', $karyawan->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('karyawan.kehadiran', compact('absensis', 'karyawan'));
    }

    public function profile()
    {
        $karyawan = Auth::user();

        if (!$karyawan) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return view('karyawan.profile', compact('karyawan'));
    }

    public function updateProfile(Request $request)
    {
        $karyawan = Auth::user();

        if (!$karyawan) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $karyawanId = $karyawan->id;

        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $karyawanId,
            'email' => 'required|email|max:255|unique:users,email,' . $karyawanId,
            'no_hp' => 'nullable|string|max:20',
            'tgl_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ], [
            'nama.required' => 'Nama Karyawan wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh karyawan lain.',
            'username.unique' => 'Username sudah digunakan oleh karyawan lain.',
        ]);

        $karyawan->update([
            'nama'          => $request->nama,
            'username'      => $request->username,
            'email'         => $request->email,
            'no_hp'         => $request->no_hp,
            'tgl_lahir'     => $request->tgl_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat'        => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $karyawan = Auth::user();

        if (!$karyawan) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:6|confirmed',
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password_baru.required' => 'Password baru wajib diisi.',
            'password_baru.min' => 'Password baru minimal 6 karakter.',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        if (!Hash::check($request->password_lama, $karyawan->password)) {
            return redirect()->back()->with('error', 'Password lama salah.');
        }

        $karyawan->update([
            'password' => Hash::make($request->password_baru),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }
}
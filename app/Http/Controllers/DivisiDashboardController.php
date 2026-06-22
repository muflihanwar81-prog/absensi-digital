<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Absensi;
use App\Models\Divisi;
use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DivisiDashboardController extends Controller
{
    private function getKaryawanKepala()
    {
        return Auth::user();
    }

    public function index()
    {
        $user = Auth::user();

        $nama_user  = $user->nama;
        $namaDivisi = $user->nama; // Wait, original code used $user->name for namaDivisi? Oh, in the old table Kepala Divisi's name was set to the nama divisi? Wait, $user->name was used as $namaDivisi. In old code: $user->name. So now $user->nama if that's what was mapped. Wait, I should use $user->nama or $user->divisi. Let's look at how the original code used it. Original code used $user->name for $namaDivisi. Since 'name' was migrated to 'nama', let's use $user->nama. Wait, actually `divisi` field might be better but I'll stick to $user->nama for safety to match original behavior. Let me change $namaDivisi to $user->nama. Wait, a kepala_divisi role probably has its "name" set as the division name. Let's stick to `$user->nama` to match original `$user->name`. Let's also set `$user->nama` for `$nama_user`.

        // Actually, $user->name has been migrated to $user->nama.
        $nama_user  = $user->nama;
        $namaDivisi = $user->nama;
        $divisi     = $namaDivisi;

        // Ambil ID karyawan yang ada di divisi ini
        $karyawanIds = User::where('divisi', $namaDivisi)->pluck('id');

        $total_karyawan = $karyawanIds->count();
        $hadir = Absensi::whereIn('user_id', $karyawanIds)
            ->whereIn('status', ['Hadir', 'Terlambat'])
            ->whereDate('tanggal', Carbon::today())
            ->count();
        $terlambat = Absensi::whereIn('user_id', $karyawanIds)
            ->where('status', 'Terlambat')
            ->whereDate('tanggal', Carbon::today())
            ->count();
        $alpha = Absensi::whereIn('user_id', $karyawanIds)
            ->whereIn('status', ['Alpha', 'Tidak Hadir'])
            ->whereDate('tanggal', Carbon::today())
            ->count();
        $izin = Absensi::whereIn('user_id', $karyawanIds)
            ->where('status', 'Izin')
            ->whereDate('tanggal', Carbon::today())
            ->count();
        $sakit = Absensi::whereIn('user_id', $karyawanIds)
            ->where('status', 'Sakit')
            ->whereDate('tanggal', Carbon::today())
            ->count();

        // Absensi kepala divisi hari ini
        $karyawanKepala = $this->getKaryawanKepala();
        $absensiHariIni = null;
        $aktivitas = collect();

        if ($karyawanKepala) {
            $absensiHariIni = Absensi::where('user_id', $karyawanKepala->id)
                ->whereDate('tanggal', Carbon::today())
                ->first();

            $aktivitas = Absensi::where('user_id', $karyawanKepala->id)
                ->latest('tanggal')
                ->take(10)
                ->get();
        }

        return view('divisi.DashboardDivisi', compact(
            'nama_user',
            'divisi',
            'total_karyawan',
            'hadir',
            'terlambat',
            'alpha',
            'izin',
            'sakit',
            'absensiHariIni',
            'karyawanKepala',
            'aktivitas'
        ));
    }

    public function absenMasuk(Request $request)
    {
        $karyawan = $this->getKaryawanKepala();

        if (!$karyawan) {
            return redirect()->back()
                ->with('error', 'Data karyawan kepala divisi tidak ditemukan.');
        }
        // Validasi GPS
        $gpsCheck = $this->validateGPSLocation($request);
        if (!$gpsCheck['status']) {
            return redirect()->back()->with('error', $gpsCheck['message']);
        }
        $today = Carbon::today()->toDateString();

        $absensi = Absensi::where('user_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$absensi) {
            $jamSekarang = Carbon::now('Asia/Jakarta');
            // Cek jam masuk divisi
            $divisi = Divisi::where('nama_divisi', $karyawan->divisi)->first();
            $status = 'Hadir';

            if ($divisi && $divisi->jam_masuk) {
                $jamMasukDivisi = Carbon::today('Asia/Jakarta')
                    ->setTimeFromTimeString($divisi->jam_masuk);
                $status = $jamSekarang->gt($jamMasukDivisi) ? 'Terlambat' : 'Hadir';
            }
            Absensi::create([
                'user_id' => $karyawan->id,
                'tanggal'     => $today,
                'jam_masuk'   => $jamSekarang->format('H:i:s'),
                'status'      => $status,
            ]);
        }
        return redirect()->back()
            ->with('success', 'Absensi masuk berhasil dicatat.');
    }

    public function absenKeluar(Request $request)
    {
        $karyawan = $this->getKaryawanKepala();

        if (!$karyawan) {
            return redirect()->back()
                ->with('error', 'Data karyawan kepala divisi tidak ditemukan.');
        }

        // Validasi GPS
        $gpsCheck = $this->validateGPSLocation($request);
        if (!$gpsCheck['status']) {
            return redirect()->back()->with('error', $gpsCheck['message']);
        }

        $today = Carbon::today()->toDateString();

        $absensi = Absensi::where('user_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($absensi && !$absensi->jam_keluar) {
            $absensi->update([
                'jam_keluar' => Carbon::now('Asia/Jakarta')->format('H:i:s'),
            ]);
        }

        return redirect()->back()
            ->with('success', 'Absensi pulang berhasil dicatat.');
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

    public function karyawan(Request $request)
    {
        $user = Auth::user();
        $namaDivisi = $user->nama;

        $search = $request->search;
        $status = $request->status;

        $karyawans = User::where('divisi', $namaDivisi)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nip', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama')
            ->get();
        return view('divisi.DataKaryawanDivisi', compact('karyawans'));
    }

    public function riwayatAbsensi(Request $request)
    {
        $user = Auth::user();
        $namaDivisi = $user->nama;

        // Ambil ID karyawan sesuai divisi yang login
        $karyawanIds = User::where('divisi', $namaDivisi)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('nip', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%");
                });
            })
            ->pluck('id');

        $absensi = Absensi::with('user')
            ->whereIn('user_id', $karyawanIds)

            // Filter tanggal awal
            ->when($request->filled('tanggal_awal'), function ($query) use ($request) {
                $query->whereDate('tanggal', '>=', $request->tanggal_awal);
            })

            // Filter tanggal akhir
            ->when($request->filled('tanggal_akhir'), function ($query) use ($request) {
                $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
            })

            ->latest()
            ->get();

        return view('divisi.RiwayatAbsensiDivisi', compact('absensi'));
    }

    public function perizinan(Request $request)
    {
        $user = Auth::user();
        $namaDivisi = $user->nama;

        $data = Izin::where('divisi', $namaDivisi)

            // Pencarian
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($q) use ($search) {
                    $q->where('nip', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
                });
            })

            // Filter tanggal awal
            ->when($request->filled('tanggal_awal'), function ($query) use ($request) {
                $query->whereDate('tanggal_mulai', '>=', $request->tanggal_awal);
            })

            // Filter tanggal akhir
            ->when($request->filled('tanggal_akhir'), function ($query) use ($request) {
                $query->whereDate('tanggal_selesai', '<=', $request->tanggal_akhir);
            })

            ->latest()
            ->get();

        return view('divisi.DivisiPerizinan', compact('data'));
    }

    public function setujui($id)
    {
        $izin = Izin::findOrFail($id);
        $izin->status = 'Disetujui';
        $izin->save();

        // Sync with Absensi table for the entire range of dates
        $startDate = \Carbon\Carbon::parse($izin->tanggal_mulai ?? $izin->created_at);
        $endDate = \Carbon\Carbon::parse($izin->tanggal_selesai ?? $izin->created_at);
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);

        // Map kategori to valid absensis status ('Cuti' -> 'Izin')
        $statusAbsensi = $izin->kategori === 'Cuti' ? 'Izin' : $izin->kategori;

        foreach ($period as $date) {
            $tanggal = $date->toDateString();
            $absensi = Absensi::where('user_id', $izin->user_id)
                ->whereDate('tanggal', $tanggal)
                ->first();
            if ($absensi) {
                $absensi->status = $statusAbsensi;
                $absensi->save();
            } else {
                Absensi::create([
                    'user_id'     => $izin->user_id,
                    'tanggal'     => $tanggal,
                    'jam_masuk'   => null,
                    'jam_keluar'  => null,
                    'status'      => $statusAbsensi,
                ]);
            }
        }
        return redirect()
            ->route('divisi.data-perizinan')
            ->with('success', 'Pengajuan izin berhasil disetujui.');
    }

   public function tolak(Request $request, $id)
    {
        // 1. Validasi agar alasan penolakan wajib diisi
        $request->validate([
            'alasan_tolak' => 'required|string|max:255'
        ]);

        $izin = Izin::findOrFail($id);
        
        // 2. Simpan status 'Ditolak' beserta alasannya ke model/tabel Izin
        $izin->status = 'Ditolak';
        $izin->alasan_tolak = $request->alasan_tolak;
        $izin->save();

        
        $startDate = \Carbon\Carbon::parse($izin->tanggal_mulai ?? $izin->created_at)->toDateString();
        $endDate = \Carbon\Carbon::parse($izin->tanggal_selesai ?? $izin->created_at)->toDateString();

        Absensi::where('user_id', $izin->user_id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->whereIn('status', ['Izin', 'Sakit', 'Cuti'])
            ->delete();

        return redirect()
            ->route('divisi.data-perizinan')
            ->with('danger', 'Pengajuan izin telah ditolak.');
    }

    public function laporan(Request $request)
    {
        $user = Auth::user();
        $namaDivisi = $user->nama;
        $karyawanIds = User::where('divisi', $namaDivisi)

            // Pencarian
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nip', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%");
                });
            })
            ->pluck('id');
        $karyawans = User::where('divisi', $namaDivisi)->get();
        $absensi = Absensi::with('user')
            ->whereIn('user_id', $karyawanIds)
            // Filter tanggal awal
            ->when($request->filled('tanggal_awal'), function ($query) use ($request) {
                $query->whereDate('tanggal', '>=', $request->tanggal_awal);
            })
            // Filter tanggal akhir
            ->when($request->filled('tanggal_akhir'), function ($query) use ($request) {
                $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        $izins = Izin::where('divisi', $namaDivisi)->get();

        return view('divisi.DivisiLaporan', compact(
            'karyawans',
            'absensi',
            'izins'
        ));
    }

    public function exportExcel(Request $request)
    {
        $user       = Auth::user();
        $namaDivisi = $user->nama;

        $karyawanIds = User::where('divisi', $namaDivisi)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nip', 'like', "%{$search}%")
                      ->orWhere('nama', 'like', "%{$search}%")
                      ->orWhere('jabatan', 'like', "%{$search}%");
                });
            })
            ->pluck('id');

        $data = Absensi::with('user')
            ->whereIn('user_id', $karyawanIds)
            ->when($request->filled('tanggal_awal'), function ($query) use ($request) {
                $query->whereDate('tanggal', '>=', $request->tanggal_awal);
            })
            ->when($request->filled('tanggal_akhir'), function ($query) use ($request) {
                $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        $filename = "laporan_absensi_divisi_" . $namaDivisi . "_" . date('Ymd_His') . ".csv";

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = ['No', 'NIP', 'Nama', 'Divisi', 'Jabatan', 'Jam Masuk', 'Jam Keluar', 'Tanggal'];

        $callback = function() use($data, $columns, $namaDivisi) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $no = 1;
            foreach ($data as $item) {
                fputcsv($file, [
                    $no++,
                    optional($item->user)->nip ?? '-',
                    optional($item->user)->nama ?? '-',
                    optional($item->user)->divisi ?? $namaDivisi,
                    optional($item->user)->jabatan ?? '-',
                    $item->jam_masuk ?? '-',
                    $item->jam_keluar ?? '-',
                    Carbon::parse($item->tanggal)->format('d-m-Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $user       = Auth::user();
        $namaDivisi = $user->nama;

        $karyawanIds = User::where('divisi', $namaDivisi)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('nip', 'like', "%{$search}%")
                      ->orWhere('nama', 'like', "%{$search}%")
                      ->orWhere('jabatan', 'like', "%{$search}%");
                });
            })
            ->pluck('id');

        $data = Absensi::with('user')
            ->whereIn('user_id', $karyawanIds)
            ->when($request->filled('tanggal_awal'), function ($query) use ($request) {
                $query->whereDate('tanggal', '>=', $request->tanggal_awal);
            })
            ->when($request->filled('tanggal_akhir'), function ($query) use ($request) {
                $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
            })
            ->orderBy('tanggal', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.laporan_pdf', compact('data'));
        return $pdf->download("laporan_absensi_divisi_" . $namaDivisi . "_" . date('Ymd_His') . ".pdf");
    }
}
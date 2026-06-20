<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\AdminActivity;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AdminLaporanController extends Controller
{
    private function applyFilters(Request $request)
    {
        $query = Absensi::with(['karyawan.divisi']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('karyawan', function ($q) use ($search) {
                $q->where('nip', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%')
                  ->orWhere('divisi', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('nama')) {
            $query->whereHas('karyawan', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        if ($request->filled('divisi')) {
            $query->whereHas('karyawan', function ($q) use ($request) {
                $q->where('divisi', $request->divisi);
            });
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $query = $this->applyFilters($request);

        $data = $query->orderBy('tanggal', 'desc')->get();

        $daftarDivisi = \App\Models\Divisi::orderBy('nama_divisi')->pluck('nama_divisi');

        $karyawanPerDivisi = \App\Models\Karyawan::select('nama', 'divisi')
            ->orderBy('nama')
            ->get()
            ->groupBy('divisi')
            ->map(fn($group) => $group->pluck('nama'));

        return view('admin.laporan', compact('data', 'daftarDivisi', 'karyawanPerDivisi'));
    }

    public function exportExcel(Request $request)
    {
        // Ambil data absensi
        $data = $this->applyFilters($request)
            ->orderBy('tanggal', 'desc')
            ->get();

        $filename = "laporan_absensi_admin_" . date('Ymd_His') . ".csv";

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = ['No', 'NIP', 'Nama', 'Divisi', 'Jabatan', 'Jam Masuk', 'Jam Keluar', 'Tanggal'];

    
        $callback = function() use($data, $columns) {
            $file = fopen('php://output', 'w'); 
            fputcsv($file, $columns);          

            $no = 1;
            foreach ($data as $item) {
                fputcsv($file, [
                    $no++,
                    optional($item->karyawan)->nip ?? '-',
                    optional($item->karyawan)->nama ?? '-',
                    optional($item->karyawan)->divisi ?? '-',
                    optional($item->karyawan)->jabatan ?? '-',
                    $item->jam_masuk ?? '-',
                    $item->jam_keluar ?? '-',
                    Carbon::parse($item->tanggal)->format('d-m-Y')
                ]);
            }

            fclose($file); 
        };

        AdminActivity::log(
            'laporan_excel',
            'Ekspor Laporan Excel',
            'Mengunduh laporan absensi format Excel/CSV'
        );

        return response()->stream($callback, 200, $headers);
    }
    public function exportPdf(Request $request)
    {
        $data = $this->applyFilters($request)
            ->orderBy('tanggal', 'desc')
            ->get();

        AdminActivity::log(
            'laporan_pdf',
            'Ekspor Laporan PDF',
            'Mengunduh laporan absensi format PDF'
        );

        $pdf = Pdf::loadView('admin.laporan_pdf', compact('data'));
        return $pdf->download("laporan_absensi_admin_" . date('Ymd_His') . ".pdf");
    }
}

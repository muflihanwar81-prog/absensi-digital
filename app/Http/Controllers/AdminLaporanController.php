<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\AdminActivity;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AdminLaporanController extends Controller
{
    /**
     * Tampilkan halaman laporan absensi.
     * Support filter: search, nama, divisi, tanggal_awal, tanggal_akhir.
     */
    public function index(Request $request)
    {
        $query = Absensi::with(['karyawan.divisi']);

        // Filter pencarian umum: NIP, nama, divisi, jabatan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('karyawan', function ($q) use ($search) {
                $q->where('nip', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%')
                  ->orWhere('divisi', 'like', '%' . $search . '%')
                  ->orWhere('jabatan', 'like', '%' . $search . '%');
            });
        }

        // Filter nama karyawan spesifik
        if ($request->filled('nama')) {
            $query->whereHas('karyawan', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->nama . '%');
            });
        }

        // Filter divisi spesifik (exact match dari dropdown)
        if ($request->filled('divisi')) {
            $query->whereHas('karyawan', function ($q) use ($request) {
                $q->where('divisi', $request->divisi);
            });
        }

        // Filter tanggal mulai
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal);
        }

        // Filter tanggal akhir
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        $data = $query->orderBy('tanggal', 'desc')->get();

        // Ambil daftar divisi untuk dropdown filter
        $daftarDivisi = \App\Models\Divisi::orderBy('nama_divisi')->pluck('nama_divisi');

        // Ambil semua karyawan dikelompokkan per divisi untuk dropdown nama dinamis
        $karyawanPerDivisi = \App\Models\Karyawan::select('nama', 'divisi')
            ->orderBy('nama')
            ->get()
            ->groupBy('divisi')
            ->map(fn($group) => $group->pluck('nama'));

        return view('admin.laporan', compact('data', 'daftarDivisi', 'karyawanPerDivisi'));
    }

    public function exportExcel()
    {
        // Ambil semua data absensi dengan relasi karyawan
        $data = Absensi::with(['karyawan.divisi'])
            ->orderBy('tanggal', 'desc')
            ->get();

        // Nama file dengan timestamp agar unik
        $filename = "laporan_absensi_admin_" . date('Ymd_His') . ".csv";

        // Header HTTP untuk trigger download file CSV
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        // Definisi kolom header di baris pertama CSV
        $columns = ['No', 'NIP', 'Nama', 'Divisi', 'Jabatan', 'Jam Masuk', 'Jam Keluar', 'Tanggal'];

        // Callback streaming: tulis CSV baris per baris ke output
        $callback = function() use($data, $columns) {
            $file = fopen('php://output', 'w'); // Buka stream output
            fputcsv($file, $columns);           // Tulis baris header

            $no = 1;
            foreach ($data as $item) {
                // Tulis tiap baris data absensi
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

            fclose($file); // Tutup stream
        };

        // Catat aktivitas ekspor ke log admin
        AdminActivity::log(
            'laporan_excel',
            'Ekspor Laporan Excel',
            'Mengunduh laporan absensi format Excel/CSV'
        );

        // Kirim response stream sebagai file download
        return response()->stream($callback, 200, $headers);
    }
    public function exportPdf()
    {
        // Ambil semua data absensi dengan relasi karyawan
        $data = Absensi::with(['karyawan.divisi'])
            ->orderBy('tanggal', 'desc')
            ->get();

        // Catat aktivitas ekspor PDF ke log admin
        AdminActivity::log(
            'laporan_pdf',
            'Ekspor Laporan PDF',
            'Mengunduh laporan absensi format PDF'
        );

        // Generate PDF dari view blade dan trigger download
        $pdf = Pdf::loadView('admin.laporan_pdf', compact('data'));
        return $pdf->download("laporan_absensi_admin_" . date('Ymd_His') . ".pdf");
    }
}

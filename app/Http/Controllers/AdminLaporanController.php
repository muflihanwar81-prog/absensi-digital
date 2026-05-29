<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AdminLaporanController extends Controller
{
    public function index()
    {
        $data = Absensi::with(['karyawan.divisi'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.laporan', compact('data'));
    }

    public function exportExcel()
    {
        $data = Absensi::with(['karyawan.divisi'])
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

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $data = Absensi::with(['karyawan.divisi'])
            ->orderBy('tanggal', 'desc')
            ->get();

        $pdf = Pdf::loadView('admin.laporan_pdf', compact('data'));
        return $pdf->download("laporan_absensi_admin_" . date('Ymd_His') . ".pdf");
    }
}

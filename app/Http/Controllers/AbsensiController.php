<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;


class AbsensiController extends Controller
{
    
    public function index(Request $request)
    {
        
        $karyawanId = session('karyawan_id');

        
        if (!$karyawanId) {
            return redirect('/login');
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

        
        $absensis = $query
            ->orderBy('tanggal', 'desc')
            ->get();

        
        return view('karyawan.kehadiran', compact('absensis'));
    }

    
    public function exportPdf()
    {
        
        $karyawanId = session('karyawan_id');

        
        if (!$karyawanId) {
            return redirect('/login');
        }

        
        $absensis = Absensi::with('karyawan')
            ->where('karyawan_id', $karyawanId)
            ->orderBy('tanggal', 'desc')
            ->get();

        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('absensi_pdf', ['absensi' => $absensis]);

        return $pdf->download('laporan-absensi.pdf');
    }
}

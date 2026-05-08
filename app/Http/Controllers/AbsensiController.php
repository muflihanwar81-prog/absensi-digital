<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $karyawanId = $user->karyawan->id;

        $query = Absensi::with('karyawan')->where('karyawan_id', $karyawanId);

        if ($request->dari && $request->sampai) {
            $query->whereBetween('tanggal', [$request->dari, $request->sampai]);
        }

        $absensi = $query->orderBy('tanggal', 'desc')->get();

        return view('absensi', compact('absensi'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $karyawanId = $user->karyawan->id;

        $data = Absensi::where('id', $id)
            ->where('karyawan_id', $karyawanId)
            ->firstOrFail();

        return view('absensi_detail', compact('data'));
    }

    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        $karyawanId = $user->karyawan->id;

        $query = Absensi::with('karyawan')->where('karyawan_id', $karyawanId);

        if ($request->dari && $request->sampai) {
            $query->whereBetween('tanggal', [$request->dari, $request->sampai]);
        }

        $absensi = $query->orderBy('tanggal', 'desc')->get();

        $pdf = Pdf::loadView('absensi_pdf', compact('absensi'));

        return $pdf->download('laporan-absensi.pdf');
    }
}
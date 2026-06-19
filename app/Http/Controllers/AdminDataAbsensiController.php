<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\AdminActivity;
use Illuminate\Http\Request;

class AdminDataAbsensiController extends Controller
{

    public function index(Request $request)
    {
        // Mulai query dengan eager load relasi karyawan
        $query = Absensi::with('karyawan');

        // Filter pencarian berdasarkan NIP, nama, divisi, atau jabatan karyawan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('karyawan', function ($q) use ($search) {
                $q->where('nip', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%')
                  ->orWhere('divisi', 'like', '%' . $search . '%')
                  ->orWhere('jabatan', 'like', '%' . $search . '%');
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

        // Filter berdasarkan status (Hadir, Terlambat, dll)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ambil data urut terbaru
        $absensi = $query->orderBy('tanggal', 'desc')->get();

        // Tambahkan field karyawan
        $absensi->transform(function ($item) {
            $item->nip     = optional($item->karyawan)->nip ?? '-';
            $item->nama    = optional($item->karyawan)->nama ?? '-';
            $item->divisi  = optional($item->karyawan)->divisi ?? '-';
            $item->jabatan = optional($item->karyawan)->jabatan ?? '-';
            return $item;
        });

        return view('admin.AdminDataAbsensi', compact('absensi'));
    }



    /**
     * Hapus satu record absensi berdasarkan ID.
     * Catat aksi ini ke log aktivitas admin.
     */
    public function destroy($id)
    {
        // Cari data absensi beserta relasi karyawannya
        $absensi = Absensi::with('karyawan')->findOrFail($id);

        // Simpan info untuk keperluan log
        $namaKaryawan = $absensi->karyawan ? $absensi->karyawan->nama : 'Tidak diketahui';
        $tanggal = $absensi->tanggal;

        // Hapus record absensi dari database
        $absensi->delete();

        // Catat aktivitas hapus ke tabel admin_activities
        AdminActivity::log(
            'absensi_hapus',
            'Menghapus Absensi',
            "Menghapus absensi {$namaKaryawan} pada tanggal {$tanggal}"
        );

        return redirect()
            ->route('admin.absensi.index')
            ->with('success', 'Data absensi berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\AdminActivity;
use Illuminate\Http\Request;

class AdminDataPerizinanController extends Controller
{
    /**
     * Tampilkan semua data pengajuan izin karyawan.
     * Support filter pencarian berdasarkan NIP, nama, atau kategori izin.
     */
    public function index(Request $request)
    {
        $query = Izin::query();

        // Filter pencarian: NIP, nama karyawan, atau jenis/kategori izin
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        // Ambil data urut terbaru
        $perizinan = $query->latest()->get();

        return view('admin.AdminDataPerizinan', compact('perizinan'));
    }



    /**
     * Update status pengajuan izin (Menunggu / Disetujui / Ditolak).
     * Catat ke log aktivitas sesuai keputusan admin.
     */
    public function update(Request $request, $id)
    {
        // Validasi nilai status yang diperbolehkan
        $request->validate([
            'status' => 'required|in:Menunggu,Disetujui,Ditolak',
        ]);

        // Cari data izin dan update statusnya
        $izin = Izin::findOrFail($id);
        $izin->status = $request->status;
        $izin->save();

        // Catat log berbeda tergantung keputusan (setujui atau tolak)
        if ($izin->status === 'Disetujui') {
            AdminActivity::log(
                'izin_setujui',
                'Persetujuan Izin',
                "Menyetujui izin {$izin->kategori} - {$izin->nama}"
            );
        } elseif ($izin->status === 'Ditolak') {
            AdminActivity::log(
                'izin_tolak',
                'Penolakan Izin',
                "Menolak izin {$izin->kategori} - {$izin->nama}"
            );
        }

        return redirect()
            ->route('admin.perizinan.index')
            ->with('success', 'Status perizinan berhasil diperbarui.');
    }

    /**
     * Hapus data izin berdasarkan ID.
     * Catat ke log aktivitas admin.
     */
    public function destroy($id)
    {
        $izin = Izin::findOrFail($id);

        // Simpan info sebelum dihapus untuk keperluan log
        $namaKaryawan = $izin->nama;
        $kategori     = $izin->kategori;

        // Hapus record izin dari database
        $izin->delete();

        // Catat aktivitas hapus izin ke log admin
        AdminActivity::log(
            'izin_hapus',
            'Menghapus Izin',
            "Menghapus data izin {$kategori} - {$namaKaryawan}"
        );

        return redirect()
            ->route('admin.perizinan.index')
            ->with('success', 'Data perizinan berhasil dihapus.');
    }
}

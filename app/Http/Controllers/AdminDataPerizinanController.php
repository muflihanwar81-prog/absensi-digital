<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\AdminActivity;
use Illuminate\Http\Request;

class AdminDataPerizinanController extends Controller
{
    public function index(Request $request)
    {
        $query = Izin::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        $perizinan = $query->latest()->get();

        return view('admin.AdminDataPerizinan', compact('perizinan'));
    }

    public function create()
    {
        return redirect()->route('admin.perizinan.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.perizinan.index');
    }

    public function show($id)
    {
        return redirect()->route('admin.perizinan.index');
    }

    public function edit($id)
    {
        return redirect()->route('admin.perizinan.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Disetujui,Ditolak',
        ]);

        $izin = Izin::findOrFail($id);
        $izin->status = $request->status;
        $izin->save();

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

    public function destroy($id)
    {
        $izin = Izin::findOrFail($id);
        $namaKaryawan = $izin->nama;
        $kategori = $izin->kategori;
        
        $izin->delete();

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
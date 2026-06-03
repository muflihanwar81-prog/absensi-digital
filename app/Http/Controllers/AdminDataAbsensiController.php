<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use Illuminate\Http\Request;


class AdminDataAbsensiController extends Controller
{
    
    public function index(Request $request)
    {
        
        $query = Absensi::with('karyawan');

        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('karyawan', function ($q) use ($search) {
                $q->where('nip', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%')
                  ->orWhere('divisi', 'like', '%' . $search . '%')
                  ->orWhere('jabatan', 'like', '%' . $search . '%');
            });
        }

        
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_awal);
        }

        
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }

        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        
        $absensi = $query->orderBy('tanggal', 'desc')->get();

        
        
        $absensi->transform(function ($item) {
            $item->nip     = optional($item->karyawan)->nip ?? '-';
            $item->nama    = optional($item->karyawan)->nama ?? '-';
            $item->divisi  = optional($item->karyawan)->divisi ?? '-';
            $item->jabatan = optional($item->karyawan)->jabatan ?? '-';
            return $item;
        });

        
        return view('admin.AdminDataAbsensi', compact('absensi'));
    }

    
    public function create()
    {
        return redirect()->route('admin.absensi.index');
    }

    
    public function store(Request $request)
    {
        return redirect()->route('admin.absensi.index');
    }

    
    public function show($id)
    {
        $item = Absensi::with('karyawan')->findOrFail($id);
        return redirect()->route('admin.absensi.index');
    }

    
    public function edit($id)
    {
        return redirect()->route('admin.absensi.index');
    }

    
    public function update(Request $request, $id)
    {
        return redirect()->route('admin.absensi.index');
    }

    
    public function destroy($id)
    {
        
        $absensi = Absensi::findOrFail($id);

        
        $absensi->delete();

        
        return redirect()
            ->route('admin.absensi.index')
            ->with('success', 'Data absensi berhasil dihapus.');
    }
}

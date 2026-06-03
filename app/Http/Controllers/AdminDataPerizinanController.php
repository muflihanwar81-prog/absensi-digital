<?php

namespace App\Http\Controllers;

use App\Models\Izin;
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

        return redirect()
            ->route('admin.perizinan.index')
            ->with('success', 'Status perizinan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $izin = Izin::findOrFail($id);
        $izin->delete();

        return redirect()
            ->route('admin.perizinan.index')
            ->with('success', 'Data perizinan berhasil dihapus.');
    }
}
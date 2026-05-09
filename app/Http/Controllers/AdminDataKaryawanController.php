<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class AdminDataKaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%')
                  ->orWhere('divisi', 'like', '%' . $search . '%')
                  ->orWhere('jabatan', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('divisi')) {
            $query->where('divisi', $request->divisi);
        }

        if ($request->filled('jabatan')) {
            $query->where('jabatan', $request->jabatan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $karyawans = $query->orderBy('nama')->get();

        $daftarDivisi = Divisi::orderBy('nama_divisi')
            ->pluck('nama_divisi');

        $daftarJabatan = Karyawan::select('jabatan')
            ->whereNotNull('jabatan')
            ->where('jabatan', '!=', '')
            ->distinct()
            ->orderBy('jabatan')
            ->pluck('jabatan');

        $stats = [];

        foreach ($daftarDivisi as $divisi) {
            $stats[$divisi] = Karyawan::where('divisi', $divisi)->count();
        }

        return view('admin.karyawan', compact(
            'karyawans',
            'stats',
            'daftarDivisi',
            'daftarJabatan'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'     => 'required|unique:karyawans,nip',
            'nama'    => 'required',
            'divisi'  => 'required',
            'jabatan' => 'required',
        ]);

        $divisi = Divisi::where('nama_divisi', $request->divisi)->first();

        $karyawan = new Karyawan();
        $karyawan->nip = $request->nip;
        $karyawan->nama = $request->nama;
        $karyawan->divisi_id = $divisi ? $divisi->id : null;
        $karyawan->divisi = $request->divisi;
        $karyawan->jabatan = $request->jabatan;
        $karyawan->status = 'Aktif';

        if ($divisi) {
            $karyawan->jam_masuk = $divisi->jam_masuk;
            $karyawan->jam_keluar = $divisi->jam_keluar;
        }

        $karyawan->password = bcrypt('12345678');
        $karyawan->save();

        return redirect()
            ->route('admin.karyawan')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        return response()->json($karyawan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip'     => 'required|unique:karyawans,nip,' . $id,
            'nama'    => 'required',
            'divisi'  => 'required',
            'jabatan' => 'required',
            'status'  => 'nullable',
        ]);

        $karyawan = Karyawan::findOrFail($id);

        $divisi = Divisi::where('nama_divisi', $request->divisi)->first();

        $karyawan->nip = $request->nip;
        $karyawan->nama = $request->nama;
        $karyawan->divisi_id = $divisi ? $divisi->id : null;
        $karyawan->divisi = $request->divisi;
        $karyawan->jabatan = $request->jabatan;
        $karyawan->status = $request->status ?? $karyawan->status;

        if ($divisi) {
            $karyawan->jam_masuk = $divisi->jam_masuk;
            $karyawan->jam_keluar = $divisi->jam_keluar;
        }

        $karyawan->save();

        return redirect()
            ->route('admin.karyawan')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect()
            ->route('admin.karyawan')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}
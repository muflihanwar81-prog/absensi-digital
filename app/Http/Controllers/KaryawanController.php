<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();

        // SEARCH NIP
        if ($request->filled('search')) {
            $query->where('nip', 'like', '%' . $request->search . '%');
        }

        // FILTER DIVISI
        if ($request->filled('divisi')) {
            $query->where('divisi', $request->divisi);
        }

        $karyawan = $query->get();

        return view('data_karyawan', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:karyawans',
            'nama' => 'required',
            'email' => 'required|email|unique:karyawans',
            'jabatan' => 'required',
            'divisi' => 'required',
        ]);

        Karyawan::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'divisi' => $request->divisi,

            // 🔐 password default (bisa dipakai login nanti)
            'password' => Hash::make('123456')
        ]);

        return redirect('/karyawan')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        return redirect('/karyawan')->with('success', 'Karyawan berhasil dihapus');
    }

    // 🔥 BONUS: show detail (opsional tapi bagus)
    public function show($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('karyawan.show', compact('karyawan'));
    }
}
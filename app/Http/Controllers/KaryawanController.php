<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;

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
        ]);

        return redirect('/karyawan');
    }
}
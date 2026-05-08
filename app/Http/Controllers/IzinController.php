<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;
use Illuminate\Support\Facades\Auth;

class IzinController extends Controller
{
    public function index()
    {
        return view('karyawan.izin');
    }

    public function store(Request $request)
    {
        Izin::create([
            'karyawan_id' => Auth::user()->karyawan->id,
            'tanggal' => $request->tanggal,
            'alasan' => $request->alasan
        ]);

        return back()->with('success', 'Pengajuan izin berhasil');
    }
}
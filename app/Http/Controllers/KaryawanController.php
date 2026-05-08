<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    // 🔹 TAMPIL DATA
    public function index(Request $request)
    {
        $query = Karyawan::with('user');

        // SEARCH
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nip', 'like', '%' . $request->search . '%')
                  ->orWhere('nama', 'like', '%' . $request->search . '%');
            });
        }

        // FILTER DIVISI
        if ($request->filled('divisi')) {
            $query->where('divisi', $request->divisi);
        }

        $karyawan = $query->latest()->get();

        return view('data_karyawan', compact('karyawan'));
    }

    // 🔹 SIMPAN KARYAWAN + USER
    public function store(Request $request)
    {
        // ✅ VALIDASI
        $request->validate([
            'nip' => 'required|unique:karyawans,nip',
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'jabatan' => 'required',
            'divisi' => 'required',
        ]);

        DB::beginTransaction();

        try {
            // 🔍 DEBUG DATA MASUK (aktifkan kalau perlu)
            // dd($request->all());

            // ✅ 1. BUAT USER
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'karyawan'
            ]);

            // ✅ 2. BUAT KARYAWAN
            Karyawan::create([
                'nip' => $request->nip,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'divisi' => $request->divisi,
                'user_id' => $user->id
            ]);

            DB::commit();

            return redirect('/karyawan')->with('success', 'Karyawan + akun berhasil dibuat');

        } catch (\Exception $e) {

            DB::rollBack();

            // 🔥 DEBUG ERROR ASLI (WAJIB saat troubleshooting)
            dd($e->getMessage());
        }
    }

    // 🔹 HAPUS
    public function destroy($id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);

        DB::beginTransaction();

        try {
            // hapus user
            if ($karyawan->user) {
                $karyawan->user->delete();
            }

            // hapus karyawan
            $karyawan->delete();

            DB::commit();

            return redirect('/karyawan')->with('success', 'Karyawan berhasil dihapus');

        } catch (\Exception $e) {

            DB::rollBack();

            dd($e->getMessage());
        }
    }

    // 🔹 DETAIL
    public function show($id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);
        return view('karyawan.show', compact('karyawan'));
    }
}
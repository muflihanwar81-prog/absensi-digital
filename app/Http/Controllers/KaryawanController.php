<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class KaryawanController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Karyawan::with('user');

        
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nip', 'like', '%' . $request->search . '%')
                  ->orWhere('nama', 'like', '%' . $request->search . '%');
            });
        }

        
        if ($request->filled('divisi')) {
            $query->where('divisi', $request->divisi);
        }

        $karyawan = $query->latest()->get();

        return view('data_karyawan', compact('karyawan'));
    }

    
    public function store(Request $request)
    {
        
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
            
            

            
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'karyawan'
            ]);

            
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

            
            dd($e->getMessage());
        }
    }

    
    public function destroy($id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);

        DB::beginTransaction();

        try {
            
            if ($karyawan->user) {
                $karyawan->user->delete();
            }

            
            $karyawan->delete();

            DB::commit();

            return redirect('/karyawan')->with('success', 'Karyawan berhasil dihapus');

        } catch (\Exception $e) {

            DB::rollBack();

            dd($e->getMessage());
        }
    }

    
    public function show($id)
    {
        $karyawan = Karyawan::with('user')->findOrFail($id);
        return view('karyawan.show', compact('karyawan'));
    }
}

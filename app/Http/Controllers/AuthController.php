<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Karyawan;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            if ($user->role === 'divisi') {
                return redirect('/divisi-dashboard');
            }

            if ($user->role === 'admin') {
                return redirect('/dashboard');
            }

            Auth::logout();

            return back()->with('error', 'Role tidak dikenali.');
        }

        $karyawan = Karyawan::where('email', $request->email)->first();

        if ($karyawan && Hash::check($request->password, $karyawan->password)) {
            session([
                'karyawan_id' => $karyawan->id,
                'karyawan_nama' => $karyawan->nama,
            ]);

            return redirect('/dashboard_karyawan');
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->forget([
            'karyawan_id',
            'karyawan_nama',
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
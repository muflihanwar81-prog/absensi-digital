<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 🔹 LOGIN
    public function login(Request $request)
    {
        // ✅ VALIDASI
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // ✅ AMBIL DATA
        $credentials = $request->only('email', 'password');

        // ✅ COBA LOGIN
        if (Auth::attempt($credentials)) {

            // 🔐 regenerate session (biar aman)
            $request->session()->regenerate();

            $user = Auth::user();

            // 🔥 DEBUG (kalau mau cek)
            // dd($user);

            // ✅ REDIRECT BERDASARKAN ROLE
            if ($user->role === 'admin') {
                return redirect('/dashboard')->with('success', 'Login berhasil sebagai admin');
            }

            if ($user->role === 'karyawan') {
                return redirect('/dashboard_karyawan')->with('success', 'Login berhasil sebagai karyawan');
            }

            // ❗ fallback kalau role aneh
            return redirect('/login')->with('error', 'Role tidak dikenali');
        }

        // ❌ LOGIN GAGAL
        return back()->with('error', 'Email atau password salah')->withInput();
    }

    // 🔹 LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        // 🔐 hapus session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout');
    }
}
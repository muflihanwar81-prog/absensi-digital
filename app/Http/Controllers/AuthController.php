<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            // Blokir akun yang berstatus Nonaktif
            if (($user->status ?? 'Aktif') === 'Nonaktif') {
                return back()->with('error', 'Akun Anda telah dinonaktifkan. Hubungi administrator.');
            }

            Auth::login($user);
            $request->session()->regenerate();

            // Redirect berdasarkan role
            return match ($user->role) {
                'admin'                => redirect('/dashboard'),
                'kepala_divisi'        => redirect('/divisi-dashboard'),
                default                => redirect('/dashboard_karyawan'),
            };
        }

        return back()->with('error', 'Email atau Password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Absensi;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('dashboard', compact('user'));
    }

    public function masuk(Request $request)
    {
        Absensi::create([
            'user_id' => Auth::id(),
            'status' => 'masuk',
            'waktu' => now()
        ]);

        return back();
    }

    public function pulang(Request $request)
    {
        Absensi::create([
            'user_id' => Auth::id(),
            'status' => 'pulang',
            'waktu' => now()
        ]);

        return back();
    }
}
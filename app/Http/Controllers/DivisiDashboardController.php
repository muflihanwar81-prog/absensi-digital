<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DivisiDashboardController extends Controller
{
    public function index()
    {
        // Data statistik simulasi sesuai gambar
        $stats = [
            'hadir'     => 20,
            'terlambat' => 5,
            'alpha'     => 2,
            'izin'      => 0
        ];

        return view('divisi.DashboardDivisi', compact('stats'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Karyawan;
class AdminDashboardController extends Controller
{
    public function index()
{
    $totalDivisi = Divisi::count();
    $totalKaryawan = Karyawan::count();

    return view('admin.dashboard', compact(
        'totalDivisi',
        'totalKaryawan'
    ));
}
}
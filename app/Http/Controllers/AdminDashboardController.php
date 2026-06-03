<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Perizinan;
use App\Models\AdminActivity;


class AdminDashboardController extends Controller
{
    
    public function index()
    {
        
        $totalDivisi = Divisi::count();

        
        $totalKaryawan = Karyawan::count();

        
        $totalHadir = Absensi::where('status', 'Hadir')->count();
        $totalTerlambat = Absensi::where('status', 'Terlambat')->count();
        $totalAlpha = Absensi::where('status', 'Alpha')->count();
        $totalIzin = Absensi::where('status', 'Izin')->count();
        $totalSakit = Absensi::where('status', 'Sakit')->count();

        
        $activities = \App\Models\AdminActivity::orderBy('created_at', 'desc')->take(10)->get();

        
        return view('admin.dashboard', compact(
            'totalDivisi',
            'totalKaryawan',
            'totalHadir',
            'totalTerlambat',
            'totalAlpha',
            'totalIzin',
            'totalSakit',
            'activities'
        ));
    }
}

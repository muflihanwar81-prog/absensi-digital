<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DivisiDashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_karyawan' => 50,
            'hadir' => 35,
            'terlambat' => 2,
            'alpha' => 5,
            'izin' => 3,
            'sakit' => 2,
            'nama_user' => 'Dio Kurniawan',
            'divisi' => 'HRD'
        ];

        return view('divisi.DashboardDivisi', $data);
    }
    public function karyawan()
    {
        // Sementara menggunakan data kosong sesuai gambar
        $karyawans = []; 
    
        return view('divisi.DataKaryawanDivisi', compact('karyawans'));
    }
    public function riwayatAbsensi()
    {
        // Sementara menggunakan data kosong sesuai gambar
        $absensi = []; 
    
        return view('divisi.RiwayatAbsensiDivisi', compact('absensi'));
    }
    public function perizinan()
    {
    return view('divisi.DivisiPerizinan');
    }
    public function laporan()
    {
    return view('divisi.DivisiLaporan');
    }
}
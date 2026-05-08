<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDataAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Dummy Data Absensi sesuai kolom image_659444.png
        $allAbsensi = collect([
            (object)[
                'nip' => '2025001',
                'nama' => 'Ita Purba',
                'divisi' => 'Divisi A',
                'jabatan' => 'Frontend Developer',
                'jam_masuk' => '08:00:15',
                'jam_keluar' => '17:05:00',
                'tanggal' => '2026-05-04',
            ],
            (object)[
                'nip' => '2025002',
                'nama' => 'Budi Santoso',
                'divisi' => 'Divisi B',
                'jabatan' => 'Backend Developer',
                'jam_masuk' => '07:55:00',
                'jam_keluar' => '17:00:10',
                'tanggal' => '2026-05-04',
            ],
        ]);

        // Logika Filter Pencarian
        $absensi = $allAbsensi->when($search, function($collection, $search) {
            return $collection->filter(function($item) use ($search) {
                return false !== stripos($item->nama, $search) || false !== stripos($item->nip, $search);
            });
        });

        return view('admin.AdminDataAbsensi', compact('absensi'));
    }
}
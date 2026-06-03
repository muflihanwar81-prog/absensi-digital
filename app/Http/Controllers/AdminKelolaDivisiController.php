<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\AdminActivity;
use Illuminate\Http\Request;


class AdminKelolaDivisiController extends Controller
{
    
    public function index()
    {
        
        $data = Divisi::orderBy('nama_divisi')->get();

        
        $globalLatitude = \App\Models\Setting::get('latitude', '-6.200000');
        $globalLongitude = \App\Models\Setting::get('longitude', '106.816666');
        $globalRadius = \App\Models\Setting::get('radius', '100');

        
        return view('admin.keloladivisi', compact('data', 'globalLatitude', 'globalLongitude', 'globalRadius'));
    }

    
    public function store(Request $request)
    {
        
        $request->validate([
            'nama_divisi' => 'required|string|max:255|unique:divisis,nama_divisi',
            'jam_masuk'   => 'required',
            'jam_keluar'  => 'required',
        ]);

        
        Divisi::create([
            'nama_divisi' => $request->nama_divisi,
            'jam_masuk'   => $request->jam_masuk,
            'jam_keluar'  => $request->jam_keluar,
        ]);

        
        AdminActivity::log(
            'divisi_tambah',
            'Menambahkan Divisi Baru',
            $request->nama_divisi
        );

        
        return redirect()
            ->route('admin.keloladivisi')
            ->with('success', 'Data divisi berhasil ditambahkan.');
    }

    
    public function edit($id)
    {
        
        $divisi = Divisi::findOrFail($id);

        
        return response()->json($divisi);
    }

    
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'nama_divisi' => 'required|string|max:255|unique:divisis,nama_divisi,' . $id,
            'jam_masuk'   => 'required',
            'jam_keluar'  => 'required',
        ]);

        
        $divisi = Divisi::findOrFail($id);

        
        $namaDivisiLama = $divisi->nama_divisi;

        
        $divisi->nama_divisi = $request->nama_divisi;
        $divisi->jam_masuk = $request->jam_masuk;
        $divisi->jam_keluar = $request->jam_keluar;
        $divisi->save();

        
        \App\Models\Karyawan::where('divisi', $namaDivisiLama)->update([
            'divisi'    => $divisi->nama_divisi,
            'divisi_id' => $divisi->id,
        ]);

        
        AdminActivity::log(
            'divisi_edit',
            'Memperbarui Data Divisi',
            $divisi->nama_divisi
        );

        
        return redirect()
            ->route('admin.keloladivisi')
            ->with('success', 'Data divisi berhasil diperbarui.');
    }

    
    public function destroy($id)
    {
        
        $divisi = Divisi::findOrFail($id);

        
        $jumlahKaryawan = \App\Models\Karyawan::where(
            'divisi_id',
            $divisi->id
        )->count();

        
        if ($jumlahKaryawan > 0) {
            return redirect()
                ->route('admin.keloladivisi')
                ->with(
                    'error',
                    'Divisi tidak dapat dihapus karena masih digunakan oleh karyawan.'
                );
        }

        
        $namaDivisi = $divisi->nama_divisi;

        
        $divisi->delete();

        
        AdminActivity::log(
            'divisi_hapus',
            'Menghapus Divisi',
            $namaDivisi
        );

        
        return redirect()
            ->route('admin.keloladivisi')
            ->with('success', 'Data divisi berhasil dihapus.');
    }

    
    public function updateLokasi(Request $request)
    {
        
        $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius'    => 'required|integer|min:1',
        ]);

        
        \App\Models\Setting::set('latitude', $request->latitude);
        \App\Models\Setting::set('longitude', $request->longitude);
        \App\Models\Setting::set('radius', $request->radius);

        
        AdminActivity::log(
            'lokasi_update',
            'Memperbarui Lokasi Kantor',
            'Lat: ' . $request->latitude . ', Long: ' . $request->longitude . ', Radius: ' . $request->radius . 'm'
        );

        
        return redirect()
            ->route('admin.keloladivisi')
            ->with('success', 'Lokasi kantor berhasil disimpan.');
    }

    
    public function storeLokasi(Request $request)
    {
        
        $request->validate([
            'nama_lokasi' => 'required',
            'latitude'    => 'required',
            'longitude'   => 'required',
            'radius'      => 'required',
        ]);

        
        return redirect()
            ->route('admin.keloladivisi')
            ->with('success', 'Lokasi berhasil disimpan.');
    }
}

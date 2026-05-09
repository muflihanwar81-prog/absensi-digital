<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use Illuminate\Http\Request;

class AdminKelolaDivisiController extends Controller
{
    public function index()
    {
        $data = Divisi::orderBy('nama_divisi')->get();

        return view('admin.keloladivisi', compact('data'));
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

        return redirect()
            ->route('admin.keloladivisi')
            ->with('success', 'Data divisi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $divisi = Divisi::findOrFail($id);

        \App\Models\Karyawan::where('divisi_id', $divisi->id)->update([
            'divisi_id' => null,
            'divisi'    => null,
        ]);

        $divisi->delete();

        return redirect()
            ->route('admin.keloladivisi')
            ->with('success', 'Data divisi berhasil dihapus.');
    }
    public function updateLokasi(Request $request)
{
    $request->validate([
        'divisi_id' => 'required|exists:divisis,id',
        'latitude'  => 'required|numeric',
        'longitude' => 'required|numeric',
        'radius'    => 'required|integer|min:1',
    ]);

    $divisi = Divisi::findOrFail($request->divisi_id);

    $divisi->latitude = $request->latitude;
    $divisi->longitude = $request->longitude;
    $divisi->radius = $request->radius;
    $divisi->save();

    return redirect()
        ->route('admin.keloladivisi')
        ->with('success', 'Lokasi divisi berhasil disimpan.');
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
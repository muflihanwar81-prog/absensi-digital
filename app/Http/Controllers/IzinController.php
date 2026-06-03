<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    public function index()
    {
        $karyawanId = session('karyawan_id');

        if (!$karyawanId) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $karyawan = Karyawan::findOrFail($karyawanId);

        $data = Izin::where('karyawan_id', $karyawanId)
            ->latest()
            ->get();

        return view('karyawan.perizinan', compact('karyawan', 'data'));
    }

    public function store(Request $request)
    {
        $karyawanId = session('karyawan_id');

        if (!$karyawanId) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'kategori' => 'required|string|max:255',
            'file_tambahan' => 'nullable|file|mimes:pdf,docx,docx,jpg,jpeg,png|max:10240',

        ]);

        $karyawan = Karyawan::findOrFail($karyawanId);

        $namaFile = null;

        if ($request->hasFile('file_tambahan')) {
            $namaFile = $request->file('file_tambahan')
                ->store('izin_files', 'public');
        }

        Izin::create([
            'karyawan_id'   => $karyawan->id,
            'nip'           => $karyawan->nip,
            'nama'          => $karyawan->nama,
            'divisi'        => $karyawan->divisi,
            'jabatan'       => $karyawan->jabatan,
            'kategori'      => $request->kategori,
            'file_tambahan' => $namaFile,
            'status'        => 'Menunggu',
        ]);

        return redirect()
            ->route('karyawan.perizinan')
            ->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    public function destroy($id)
    {
        $karyawanId = session('karyawan_id');

        if (!$karyawanId) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $izin = Izin::where('id', $id)
            ->where('karyawan_id', $karyawanId)
            ->firstOrFail();

        $izin->delete();

        return redirect()
            ->route('karyawan.perizinan')
            ->with('success', 'Data izin berhasil dihapus.');
    }
}

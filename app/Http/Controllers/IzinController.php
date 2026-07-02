<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\User;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    public function index()
    {
        $karyawan = auth()->user();

        if (!$karyawan) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = Izin::where('user_id', $karyawan->id)
            ->latest()
            ->get();

        return view('karyawan.perizinan', compact('karyawan', 'data'));
    }

    public function store(Request $request)
    {
        $karyawan = auth()->user();

        if (!$karyawan) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $request->validate([
            'kategori' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'file_tambahan' => 'nullable|file|mimes:pdf,docx,jpg,jpeg,png|max:5120',

        ],  [
            'file_tambahan.max' => 'Ukuran file tidak boleh lebih dari 5 MB.',
            'file_tambahan.mimes' => 'Format file harus pdf, docx, jpeg, jpg, atau png.',
        ]);

        $namaFile = null;

        if ($request->hasFile('file_tambahan')) {
            $namaFile = $request->file('file_tambahan')
                ->store('izin_files', 'public');
        }

        Izin::create([
            'user_id'         => $karyawan->id,
            'nip'             => $karyawan->nip,
            'nama'            => $karyawan->nama,
            'divisi'          => $karyawan->divisi,
            'jabatan'         => $karyawan->jabatan,
            'kategori'        => $request->kategori,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'file_tambahan'   => $namaFile,
            'status'          => 'Menunggu',
        ]);

        return redirect()
            ->route('karyawan.perizinan')
            ->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    public function destroy($id)
    {
        $karyawan = auth()->user();

        if (!$karyawan) {
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $izin = Izin::where('id', $id)
            ->where('user_id', $karyawan->id)
            ->firstOrFail();

        $izin->delete();

        return redirect()
            ->route('karyawan.perizinan')
            ->with('success', 'Data izin berhasil dihapus.');
    }
}
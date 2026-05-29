<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Absensi;
use App\Models\Izin;
use App\Models\Perizinan;
use App\Models\User;
class AdminDataKaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%')
                  ->orWhere('divisi', 'like', '%' . $search . '%')
                  ->orWhere('jabatan', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('divisi')) {
            $query->where('divisi', $request->divisi);
        }

        if ($request->filled('jabatan')) {
            $query->where('jabatan', $request->jabatan);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $karyawans = $query->orderBy('nama')->get();

        $daftarDivisi = Divisi::orderBy('nama_divisi')
            ->pluck('nama_divisi');

        $daftarJabatan = Karyawan::select('jabatan')
            ->whereNotNull('jabatan')
            ->where('jabatan', '!=', '')
            ->distinct()
            ->orderBy('jabatan')
            ->pluck('jabatan');

        $stats = [];

        foreach ($daftarDivisi as $divisi) {
            $stats[$divisi] = Karyawan::where('divisi', $divisi)->count();
        }

        return view('admin.karyawan', compact(
            'karyawans',
            'stats',
            'daftarDivisi',
            'daftarJabatan'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'           => 'required|unique:karyawans,nip',
            'nama'          => 'required',
            'email'         => 'required|email|unique:karyawans,email',
            'password'      => 'required|min:6',
            'divisi'        => 'required|exists:divisis,nama_divisi',
            'jabatan'       => 'required',
            'username'      => 'nullable|unique:karyawans,username',
            'tgl_lahir'     => 'nullable|date',
            'jenis_kelamin' => 'nullable|string',
            'alamat'        => 'nullable|string',
            'tgl_bergabung' => 'nullable|date',
            'no_hp'         => 'nullable|string',
            'role'          => 'nullable|string',
            'status'        => 'nullable|string',
        ]);

        $divisi = Divisi::where('nama_divisi', $request->divisi)->first();

        $karyawan = new Karyawan();
        $karyawan->nip = $request->nip;
        $karyawan->nama = $request->nama;
        $karyawan->email = $request->email;
        $karyawan->password = Hash::make($request->password);
        $karyawan->divisi_id = $divisi ? $divisi->id : null;
        $karyawan->divisi = $request->divisi;
        $karyawan->jabatan = $request->jabatan;
        $karyawan->username = $request->username;
        $karyawan->tgl_lahir = $request->tgl_lahir;
        $karyawan->jenis_kelamin = $request->jenis_kelamin;
        $karyawan->alamat = $request->alamat;
        $karyawan->tgl_bergabung = $request->tgl_bergabung;
        $karyawan->no_hp = $request->no_hp;
        $karyawan->role = $request->role;
        $karyawan->status = $request->status ?? 'Aktif';

        if ($divisi) {
            $karyawan->jam_masuk = $divisi->jam_masuk;
            $karyawan->jam_keluar = $divisi->jam_keluar;
        }

        $karyawan->save();

        // Sync to User table if applicable
        $roleLower = strtolower($request->role);
        if ($request->jabatan === 'Kepala Divisi') {
            User::updateOrCreate(
                ['email' => $request->email],
                [
                    'name'     => $request->divisi,
                    'password' => Hash::make($request->password),
                    'role'     => 'kepala_divisi',
                ]
            );
        } elseif (in_array($roleLower, ['admin', 'super_admin', 'super admin'])) {
            $normalizedRole = $roleLower === 'super admin' ? 'super_admin' : $roleLower;
            User::updateOrCreate(
                ['email' => $request->email],
                [
                    'name'     => $request->nama,
                    'password' => Hash::make($request->password),
                    'role'     => $normalizedRole,
                ]
            );
        }

        return redirect()
            ->route('admin.karyawan')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        return response()->json($karyawan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip'           => 'required|unique:karyawans,nip,' . $id,
            'nama'          => 'required',
            'email'         => 'required|email|unique:karyawans,email,' . $id,
            'divisi'        => 'required|exists:divisis,nama_divisi',
            'jabatan'       => 'required',
            'status'        => 'nullable|string',
            'password'      => 'nullable|min:6',
            'username'      => 'nullable|unique:karyawans,username,' . $id,
            'tgl_lahir'     => 'nullable|date',
            'jenis_kelamin' => 'nullable|string',
            'alamat'        => 'nullable|string',
            'tgl_bergabung' => 'nullable|date',
            'no_hp'         => 'nullable|string',
            'role'          => 'nullable|string',
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $oldEmail = $karyawan->email;
        $divisi = Divisi::where('nama_divisi', $request->divisi)->first();

        $karyawan->nip            = $request->nip;
        $karyawan->nama           = $request->nama;
        $karyawan->email          = $request->email;
        $karyawan->divisi_id      = $divisi ? $divisi->id : null;
        $karyawan->divisi         = $request->divisi;
        $karyawan->jabatan        = $request->jabatan;
        $karyawan->status         = $request->status ?? $karyawan->status;
        $karyawan->username       = $request->username;
        $karyawan->tgl_lahir      = $request->tgl_lahir;
        $karyawan->jenis_kelamin  = $request->jenis_kelamin;
        $karyawan->alamat         = $request->alamat;
        $karyawan->tgl_bergabung  = $request->tgl_bergabung;
        $karyawan->no_hp          = $request->no_hp;
        $karyawan->role           = $request->role;

        if ($divisi) {
            $karyawan->jam_masuk  = $divisi->jam_masuk;
            $karyawan->jam_keluar = $divisi->jam_keluar;
        }

        if ($request->filled('password')) {
            $karyawan->password = Hash::make($request->password);
        }

        $karyawan->save();

        // Handle Kepala Divisi User Sync
        if ($request->jabatan === 'Kepala Divisi') {
            $userData = [
                'name'  => $request->divisi,
                'email' => $request->email,
                'role'  => 'kepala_divisi',
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            } else {
                $userData['password'] = $karyawan->password;
            }
            User::updateOrCreate(
                ['email' => $oldEmail],
                $userData
            );
        } else {
            // Remove user if they are demoted to regular employee
            User::where('email', $oldEmail)->orWhere('email', $request->email)->where('role', 'kepala_divisi')->delete();
        }

        return redirect()
            ->route('admin.karyawan')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy($id)
{
    $karyawan = Karyawan::findOrFail($id);

    // Remove user if they were a division head
    User::where('email', $karyawan->email)->where('role', 'kepala_divisi')->delete();

    // hapus seluruh absensi milik karyawan
    Absensi::where('karyawan_id', $id)->delete();

    // hapus data izin jika ada
    Izin::where('karyawan_id', $id)->delete();

    // hapus data perizinan jika ada
    Perizinan::where('karyawan_id', $id)->delete();

    // hapus karyawan
    $karyawan->delete();

    return redirect()
        ->route('admin.karyawan')
        ->with('success', 'Data karyawan berhasil dihapus.');
}
}
<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Absensi;
use App\Models\Izin;
use App\Models\User;
use App\Models\AdminActivity;

class AdminDataKaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = Karyawan::query();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', '%' . $search . '%')
                  ->orWhere('nama', 'like', '%' . $search . '%')
                  ->orWhere('divisi', 'like', '%' . $search . '%')
                  ->orWhere('jabatan', 'like', '%' . $search . '%');
            });
        }

        // Filter divisi
        if ($request->filled('divisi')) {
            $query->where('divisi', $request->divisi);
        }

        // Filter jabatan
        if ($request->filled('jabatan')) {
            $query->where('jabatan', $request->jabatan);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Ambil query nama
        $karyawans = $query->orderBy('nama')->get();

        // Ambil nama divisi untuk dropdown filter
        $daftarDivisi = Divisi::orderBy('nama_divisi')->pluck('nama_divisi');

        // Ambil daftar jabatan
        $daftarJabatan = Karyawan::select('jabatan')
            ->whereNotNull('jabatan')
            ->where('jabatan', '!=', '')
            ->distinct()
            ->orderBy('jabatan')
            ->pluck('jabatan');

        // jumlah karyawan per divisi
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
        // Validasi semua input form tambah karyawan
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
            'komentar_nonaktif' => 'nullable|string',
        ]);

        // Cari data divisi untuk mengambil jam masuk/keluar otomatis
        $divisi = Divisi::where('nama_divisi', $request->divisi)->first();

        // Buat data karyawan baru
        $karyawan = new Karyawan();
        $karyawan->nip            = $request->nip;
        $karyawan->nama           = $request->nama;
        $karyawan->email          = $request->email;
        $karyawan->password       = Hash::make($request->password); // Enkripsi password
        $karyawan->divisi_id      = $divisi ? $divisi->id : null;
        $karyawan->divisi         = $request->divisi;
        $karyawan->jabatan        = $request->jabatan;
        $karyawan->username       = $request->username;
        $karyawan->tgl_lahir      = $request->tgl_lahir;
        $karyawan->jenis_kelamin  = $request->jenis_kelamin;
        $karyawan->alamat         = $request->alamat;
        $karyawan->tgl_bergabung  = $request->tgl_bergabung;
        $karyawan->no_hp          = $request->no_hp;
        $karyawan->role           = $request->role;
        $karyawan->status         = $request->status ?? 'Aktif'; // Default status Aktif
        // Komentar nonaktif hanya diisi jika status = Nonaktif
        $karyawan->komentar_nonaktif = $request->status === 'Nonaktif' ? $request->komentar_nonaktif : null;

        // Otomatis set jam masuk/keluar dari data divisi
        if ($divisi) {
            $karyawan->jam_masuk  = $divisi->jam_masuk;
            $karyawan->jam_keluar = $divisi->jam_keluar;
        }

        $karyawan->save();

        // Buat akun user dengan role kepala_divisi
        $roleLower = strtolower($request->role ?? '');
        if ($request->jabatan === 'Kepala Divisi') {
            User::updateOrCreate(
                ['email' => $request->email],
                [
                    'name'     => $request->divisi,
                    'password' => Hash::make($request->password),
                    'role'     => 'kepala_divisi',
                    'status'   => $karyawan->status,
                ]
            );
        // Buat akun user dengan role admin / super_admin
        } elseif (in_array($roleLower, ['admin', 'super_admin', 'super admin'])) {
            $normalizedRole = $roleLower === 'super admin' ? 'super_admin' : $roleLower;
            User::updateOrCreate(
                ['email' => $request->email],
                [
                    'name'     => $request->nama,
                    'password' => Hash::make($request->password),
                    'role'     => $normalizedRole,
                    'status'   => $karyawan->status,
                ]
            );
        }

        // Catat aktivitas tambah karyawan ke log admin
        AdminActivity::log(
            'karyawan_tambah',
            'Menambahkan Karyawan Baru',
            $karyawan->nama . ' - ' . $karyawan->divisi
        );

        return redirect()
            ->route('admin.karyawan')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);

        // Ambil nama divisi untuk dropdown filter
        return response()->json($karyawan);
    }
    public function update(Request $request, $id)
    {
        // Validasi semua input form edit karyawan
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
            'komentar_nonaktif' => 'nullable|string',
        ]);

        $karyawan = Karyawan::findOrFail($id);
        $oldEmail = $karyawan->email; // Simpan email lama untuk update user tabel

        // Cari divisi baru untuk update jam masuk/keluar
        $divisi = Divisi::where('nama_divisi', $request->divisi)->first();

        // Update semua field karyawan
        $karyawan->nip            = $request->nip;
        $karyawan->nama           = $request->nama;
        $karyawan->email          = $request->email;
        $karyawan->divisi_id      = $divisi ? $divisi->id : null;
        $karyawan->divisi         = $request->divisi;
        $karyawan->jabatan        = $request->jabatan;
        $karyawan->status         = $request->status ?? $karyawan->status;
        // Komentar nonaktif hanya disimpan jika status = Nonaktif
        $karyawan->komentar_nonaktif = $karyawan->status === 'Nonaktif' ? $request->komentar_nonaktif : null;
        $karyawan->username       = $request->username;
        $karyawan->tgl_lahir      = $request->tgl_lahir;
        $karyawan->jenis_kelamin  = $request->jenis_kelamin;
        $karyawan->alamat         = $request->alamat;
        $karyawan->tgl_bergabung  = $request->tgl_bergabung;
        $karyawan->no_hp          = $request->no_hp;
        $karyawan->role           = $request->role;

        // Update jam masuk/keluar mengikuti divisi yang baru dipilih
        if ($divisi) {
            $karyawan->jam_masuk  = $divisi->jam_masuk;
            $karyawan->jam_keluar = $divisi->jam_keluar;
        }

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $karyawan->password = Hash::make($request->password);
        }

        $karyawan->save();

        // Sinkronisasi status ke akun user (aktif/nonaktif)
        $existingUser = User::where('email', $oldEmail)
            ->orWhere('email', $request->email)
            ->first();

        // Jika jabatan diubah ke Kepala Divisi → update atau buat akun user
        if ($request->jabatan === 'Kepala Divisi') {
            $userData = [
                'name'   => $request->divisi,
                'email'  => $request->email,
                'role'   => 'kepala_divisi',
                'status' => $karyawan->status,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            } else {
                $userData['password'] = $karyawan->password;
            }
            User::updateOrCreate(['email' => $oldEmail], $userData);
        } else {
            // Jika jabatan diturunkan dari Kepala Divisi → hapus akun user lama
            User::where('email', $oldEmail)
                ->orWhere('email', $request->email)
                ->where('role', 'kepala_divisi')
                ->delete();

            // Jika role karyawan adalah admin/super_admin, sync status ke users
            $roleLower = strtolower($request->role ?? '');
            if (in_array($roleLower, ['admin', 'super_admin', 'super admin'])) {
                $normalizedRole = $roleLower === 'super admin' ? 'super_admin' : $roleLower;
                $userData = [
                    'name'   => $request->nama,
                    'email'  => $request->email,
                    'role'   => $normalizedRole,
                    'status' => $karyawan->status,
                ];
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                } else {
                    $userData['password'] = $karyawan->password;
                }
                User::updateOrCreate(['email' => $oldEmail], $userData);
            } elseif ($existingUser && !in_array($existingUser->role, ['kepala_divisi'])) {
                // Sync status-only untuk user yang sudah ada dengan role lain (admin)
                $existingUser->update(['status' => $karyawan->status]);
            }
        }

        // Catat aktivitas edit karyawan ke log admin
        AdminActivity::log(
            'karyawan_edit',
            'Memperbarui Data Karyawan',
            $karyawan->nama . ' - ' . $karyawan->divisi
        );

        return redirect()
            ->route('admin.karyawan')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    /**
     * Hapus karyawan beserta semua data terkait (absensi, izin, perizinan, akun user).
     * Operasi ini tidak dapat dibatalkan.
     */
    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $namaKaryawan   = $karyawan->nama;
        $divisiKaryawan = $karyawan->divisi;

        // Hapus akun user jika karyawan ini adalah Kepala Divisi
        User::where('email', $karyawan->email)->where('role', 'kepala_divisi')->delete();

        // Hapus seluruh data absensi milik karyawan ini
        Absensi::where('karyawan_id', $id)->delete();

        // Hapus seluruh data izin milik karyawan ini
        Izin::where('karyawan_id', $id)->delete();

        // Hapus data karyawan dari tabel utama
        $karyawan->delete();

        // Catat aktivitas hapus karyawan ke log admin
        AdminActivity::log(
            'karyawan_hapus',
            'Menghapus Data Karyawan',
            $namaKaryawan . ' - ' . $divisiKaryawan
        );

        return redirect()
            ->route('admin.karyawan')
            ->with('success', 'Data karyawan berhasil dihapus.');
    }
}

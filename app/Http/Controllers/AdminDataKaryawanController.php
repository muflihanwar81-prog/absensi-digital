<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Absensi;
use App\Models\Izin;
use App\Models\AdminActivity;

class AdminDataKaryawanController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

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
        $daftarJabatan = User::select('jabatan')
            ->whereNotNull('jabatan')
            ->where('jabatan', '!=', '')
            ->distinct()
            ->orderBy('jabatan')
            ->pluck('jabatan');

        // jumlah karyawan per divisi
        $stats = [];
        foreach ($daftarDivisi as $divisi) {
            $stats[$divisi] = User::where('divisi', $divisi)->count();
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
            'nip'           => 'required|unique:users,nip',
            'nama'          => 'required',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'divisi'        => 'required|exists:divisis,nama_divisi',
            'jabatan'       => 'required',
            'username'      => 'nullable|unique:users,username',
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

        // Tentukan role berdasarkan jabatan dan input role
        $roleLower = strtolower($request->role ?? '');
        $role = 'karyawan'; // default

        if ($request->jabatan === 'Kepala Divisi') {
            $role = 'kepala_divisi';
        } elseif ($roleLower === 'admin') {
            $role = 'admin';
        }

        // Buat data user/karyawan baru (satu tabel)
        $user = new User();
        $user->nip            = $request->nip;
        $user->nama           = $request->nama;
        $user->email          = $request->email;
        $user->password       = Hash::make($request->password);
        $user->divisi_id      = $divisi ? $divisi->id : null;
        $user->divisi         = $request->divisi;
        $user->jabatan        = $request->jabatan;
        $user->username       = $request->username;
        $user->tgl_lahir      = $request->tgl_lahir;
        $user->jenis_kelamin  = $request->jenis_kelamin;
        $user->alamat         = $request->alamat;
        $user->tgl_bergabung  = $request->tgl_bergabung;
        $user->no_hp          = $request->no_hp;
        $user->role           = $role;
        $user->status         = $request->status ?? 'Aktif';
        $user->komentar_nonaktif = $request->status === 'Nonaktif' ? $request->komentar_nonaktif : null;

        // Otomatis set jam masuk/keluar dari data divisi
        if ($divisi) {
            $user->jam_masuk  = $divisi->jam_masuk;
            $user->jam_keluar = $divisi->jam_keluar;
        }

        $user->save();

        // Catat aktivitas tambah karyawan ke log admin
        AdminActivity::log(
            'karyawan_tambah',
            'Menambahkan Karyawan Baru',
            $user->nama . ' - ' . $user->divisi
        );

        return redirect()
            ->route('admin.karyawan')
            ->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $karyawan = User::findOrFail($id);

        return response()->json($karyawan);
    }

    public function update(Request $request, $id)
    {
        // Validasi semua input form edit karyawan
        $request->validate([
            'nip'           => 'required|unique:users,nip,' . $id,
            'nama'          => 'required',
            'email'         => 'required|email|unique:users,email,' . $id,
            'divisi'        => 'required|exists:divisis,nama_divisi',
            'jabatan'       => 'required',
            'status'        => 'nullable|string',
            'password'      => 'nullable|min:6',
            'username'      => 'nullable|unique:users,username,' . $id,
            'tgl_lahir'     => 'nullable|date',
            'jenis_kelamin' => 'nullable|string',
            'alamat'        => 'nullable|string',
            'tgl_bergabung' => 'nullable|date',
            'no_hp'         => 'nullable|string',
            'role'          => 'nullable|string',
            'komentar_nonaktif' => 'nullable|string',
        ]);

        $karyawan = User::findOrFail($id);

        // Cari divisi baru untuk update jam masuk/keluar
        $divisi = Divisi::where('nama_divisi', $request->divisi)->first();

        // Tentukan role berdasarkan jabatan dan input role
        $roleLower = strtolower($request->role ?? '');
        $role = 'karyawan'; // default

        if ($request->jabatan === 'Kepala Divisi') {
            $role = 'kepala_divisi';
        } elseif ($roleLower === 'admin') {
            $role = 'admin';
        }

        // Update semua field
        $karyawan->nip            = $request->nip;
        $karyawan->nama           = $request->nama;
        $karyawan->email          = $request->email;
        $karyawan->divisi_id      = $divisi ? $divisi->id : null;
        $karyawan->divisi         = $request->divisi;
        $karyawan->jabatan        = $request->jabatan;
        $karyawan->status         = $request->status ?? $karyawan->status;
        $karyawan->komentar_nonaktif = $karyawan->status === 'Nonaktif' ? $request->komentar_nonaktif : null;
        $karyawan->username       = $request->username;
        $karyawan->tgl_lahir      = $request->tgl_lahir;
        $karyawan->jenis_kelamin  = $request->jenis_kelamin;
        $karyawan->alamat         = $request->alamat;
        $karyawan->tgl_bergabung  = $request->tgl_bergabung;
        $karyawan->no_hp          = $request->no_hp;
        $karyawan->role           = $role;

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
     * Hapus karyawan beserta semua data terkait (absensi, izin).
     */
    public function destroy($id)
    {
        $karyawan = User::findOrFail($id);
        $namaKaryawan   = $karyawan->nama;
        $divisiKaryawan = $karyawan->divisi;

        // Hapus seluruh data absensi milik karyawan ini
        Absensi::where('user_id', $id)->delete();

        // Hapus seluruh data izin milik karyawan ini
        Izin::where('user_id', $id)->delete();

        // Hapus data karyawan
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

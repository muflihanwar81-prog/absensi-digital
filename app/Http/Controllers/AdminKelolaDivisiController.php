<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\AdminActivity;
use Illuminate\Http\Request;

class AdminKelolaDivisiController extends Controller
{
    /**
     * Tampilkan halaman kelola divisi.
     * Ambil semua divisi dan setting lokasi kantor (lat, lng, radius) dari tabel settings.
     */
    public function index()
    {
        // Ambil semua divisi urut berdasarkan nama
        $data = Divisi::orderBy('nama_divisi')->get();

        // Ambil koordinat dan radius kantor dari settings (default: Jakarta Pusat)
        $globalLatitude  = \App\Models\Setting::get('latitude', '-6.200000');
        $globalLongitude = \App\Models\Setting::get('longitude', '106.816666');
        $globalRadius    = \App\Models\Setting::get('radius', '100');

        return view('admin.keloladivisi', compact('data', 'globalLatitude', 'globalLongitude', 'globalRadius'));
    }

    /**
     * Simpan divisi baru ke database.
     * Nama divisi harus unik. Catat ke log aktivitas admin.
     */
    public function store(Request $request)
    {
        // Validasi input form tambah divisi
        $request->validate([
            'nama_divisi' => 'required|string|max:255|unique:divisis,nama_divisi',
            'jam_masuk'   => 'required',
            'jam_keluar'  => 'required',
        ]);

        // Simpan divisi baru ke tabel divisis
        Divisi::create([
            'nama_divisi' => $request->nama_divisi,
            'jam_masuk'   => $request->jam_masuk,
            'jam_keluar'  => $request->jam_keluar,
        ]);

        // Catat aktivitas tambah divisi ke log admin
        AdminActivity::log(
            'divisi_tambah',
            'Menambahkan Divisi Baru',
            $request->nama_divisi
        );

        return redirect()
            ->route('admin.keloladivisi')
            ->with('success', 'Data divisi berhasil ditambahkan.');
    }

    /**
     * Ambil data satu divisi berdasarkan ID dan kembalikan sebagai JSON.
     * Dipakai oleh modal edit via JavaScript untuk mengisi form.
     */
    public function edit($id)
    {
        $divisi = Divisi::findOrFail($id);

        // Return JSON agar bisa diisi ke form modal edit di frontend
        return response()->json($divisi);
    }

    /**
     * Update data divisi yang sudah ada.
     * Jika nama divisi berubah, semua karyawan di divisi tersebut ikut diupdate.
     */
    public function update(Request $request, $id)
    {
        // Validasi input, abaikan nilai unik milik divisi itu sendiri
        $request->validate([
            'nama_divisi' => 'required|string|max:255|unique:divisis,nama_divisi,' . $id,
            'jam_masuk'   => 'required',
            'jam_keluar'  => 'required',
        ]);

        $divisi = Divisi::findOrFail($id);

        // Simpan nama lama untuk update data karyawan yang menggunakan divisi ini
        $namaDivisiLama = $divisi->nama_divisi;

        // Update data divisi
        $divisi->nama_divisi = $request->nama_divisi;
        $divisi->jam_masuk   = $request->jam_masuk;
        $divisi->jam_keluar  = $request->jam_keluar;
        $divisi->save();

        // Sinkronisasi: update kolom divisi & divisi_id di semua karyawan yang terpengaruh
        \App\Models\Karyawan::where('divisi', $namaDivisiLama)->update([
            'divisi'    => $divisi->nama_divisi,
            'divisi_id' => $divisi->id,
        ]);

        // Catat aktivitas edit divisi ke log admin
        AdminActivity::log(
            'divisi_edit',
            'Memperbarui Data Divisi',
            $divisi->nama_divisi
        );

        return redirect()
            ->route('admin.keloladivisi')
            ->with('success', 'Data divisi berhasil diperbarui.');
    }

    /**
     * Hapus divisi berdasarkan ID.
     * Tidak bisa dihapus jika masih ada karyawan yang terdaftar di divisi ini.
     */
    public function destroy($id)
    {
        $divisi = Divisi::findOrFail($id);

        // Cek jumlah karyawan yang masih menggunakan divisi ini
        $jumlahKaryawan = \App\Models\Karyawan::where('divisi_id', $divisi->id)->count();

        // Tolak hapus jika masih ada karyawan terdaftar
        if ($jumlahKaryawan > 0) {
            return redirect()
                ->route('admin.keloladivisi')
                ->with('error', 'Divisi tidak dapat dihapus karena masih digunakan oleh karyawan.');
        }

        $namaDivisi = $divisi->nama_divisi;

        // Hapus divisi dari database
        $divisi->delete();

        // Catat aktivitas hapus divisi ke log admin
        AdminActivity::log(
            'divisi_hapus',
            'Menghapus Divisi',
            $namaDivisi
        );

        return redirect()
            ->route('admin.keloladivisi')
            ->with('success', 'Data divisi berhasil dihapus.');
    }

    /**
     * Simpan pengaturan lokasi kantor (latitude, longitude, radius) ke tabel settings.
     * Nilai ini digunakan untuk validasi GPS saat karyawan absen.
     */
    public function updateLokasi(Request $request)
    {
        // Validasi input koordinat dan radius
        $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius'    => 'required|integer|min:1',
        ]);

        // Simpan setting lokasi ke tabel settings (key-value)
        \App\Models\Setting::set('latitude', $request->latitude);
        \App\Models\Setting::set('longitude', $request->longitude);
        \App\Models\Setting::set('radius', $request->radius);

        // Catat aktivitas update lokasi ke log admin
        AdminActivity::log(
            'lokasi_update',
            'Memperbarui Lokasi Kantor',
            'Lat: ' . $request->latitude . ', Long: ' . $request->longitude . ', Radius: ' . $request->radius . 'm'
        );

        return redirect()
            ->route('admin.keloladivisi')
            ->with('success', 'Lokasi kantor berhasil disimpan.');
    }

    /**
     * Tidak digunakan saat ini — endpoint placeholder untuk simpan lokasi alternatif.
     */
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

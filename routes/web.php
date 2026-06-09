<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\Divisi;
use App\Models\Karyawan;
use App\Models\Absensi;
use App\Models\Perizinan;
use App\Models\AdminActivity;

use App\Http\Controllers\{
    HomeController,
    AbsensiController,
    AuthController,
    TAController,
    KaryawanDashboardController,
    IzinController,
    AdminDashboardController,
    AdminDataKaryawanController,
    AdminDataAbsensiController,
    AdminDataPerizinanController,
    AdminLaporanController,
    AdminKelolaDivisiController,
    DivisiDashboardController
};

Route::get('/', [HomeController::class, 'index']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/tecno_view', [TAController::class, 'tampilkan']);


Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }

    if (session()->has('karyawan_id')) {
        return redirect('/dashboard_karyawan');
    }

    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::middleware(['auth'])->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [AdminDashboardController::class, 'stats'])->name('dashboard.stats');

    Route::get('/aktifitas', function () {
        $activities = AdminActivity::latest()->paginate(15);
        return view('admin.aktifitas', compact('activities'));
    })->name('aktifitas');

    Route::get('/karyawan', [AdminDataKaryawanController::class, 'index'])
        ->name('karyawan');

    Route::get('/karyawan/create', [AdminDataKaryawanController::class, 'create'])
        ->name('karyawan.create');

    Route::post('/karyawan', [AdminDataKaryawanController::class, 'store'])
        ->name('karyawan.store');

    Route::get('/karyawan/{karyawan}', [AdminDataKaryawanController::class, 'show'])
        ->name('karyawan.show');

    Route::get('/karyawan/{karyawan}/edit', [AdminDataKaryawanController::class, 'edit'])
        ->name('karyawan.edit');

    Route::put('/karyawan/{karyawan}', [AdminDataKaryawanController::class, 'update'])
        ->name('karyawan.update');

    Route::delete('/karyawan/{karyawan}', [AdminDataKaryawanController::class, 'destroy'])
        ->name('karyawan.destroy');

    Route::resource('absensi', AdminDataAbsensiController::class)
        ->names('absensi');

    Route::resource('perizinan', AdminDataPerizinanController::class)
        ->names('perizinan');

    Route::get('/laporan-admin', [AdminLaporanController::class, 'index'])
        ->name('laporan');

    Route::get('/laporan-admin/excel', [AdminLaporanController::class, 'exportExcel'])
        ->name('laporan.excel');

    Route::get('/laporan-admin/pdf', [AdminLaporanController::class, 'exportPdf'])
        ->name('laporan.pdf');

    Route::get('/keloladivisi', [AdminKelolaDivisiController::class, 'index'])
        ->name('keloladivisi');

    Route::post('/divisi', [AdminKelolaDivisiController::class, 'store'])
        ->name('divisi.store');

    Route::get('/keloladivisi/{id}/edit', [AdminKelolaDivisiController::class, 'edit'])
        ->name('keloladivisi.edit');

    Route::put('/keloladivisi/{id}', [AdminKelolaDivisiController::class, 'update'])
        ->name('keloladivisi.update');

    Route::delete('/keloladivisi/{id}', [AdminKelolaDivisiController::class, 'destroy'])
        ->name('keloladivisi.destroy');

    Route::post('/keloladivisi/lokasi', [AdminKelolaDivisiController::class, 'updateLokasi'])
        ->name('divisi.lokasi');

    Route::post('/lokasi/store', [AdminKelolaDivisiController::class, 'storeLokasi'])
        ->name('lokasi.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/divisi-dashboard', [DivisiDashboardController::class, 'index'])
        ->name('divisi.dashboard');

    Route::get('/data-karyawan', [DivisiDashboardController::class, 'karyawan'])
        ->name('divisi.karyawan');

    Route::get('/riwayat-absensi', [DivisiDashboardController::class, 'riwayatAbsensi'])
        ->name('divisi.riwayat-absensi');

    Route::get('/data-perizinan', [DivisiDashboardController::class, 'perizinan'])
        ->name('divisi.data-perizinan');

    Route::post('/perizinan/{id}/setujui', [DivisiDashboardController::class, 'setujui'])
        ->name('divisi.perizinan.setujui');

    Route::post('/perizinan/tolak/{id}', [DivisiDashboardController::class, 'tolak'])
        ->name('divisi.perizinan.tolak');

    Route::get('/laporan', [DivisiDashboardController::class, 'laporan'])
        ->name('divisi.DivisiLaporan');

    Route::get('/laporan/excel', [DivisiDashboardController::class, 'exportExcel'])
        ->name('divisi.laporan.excel');

    Route::get('/laporan/pdf', [DivisiDashboardController::class, 'exportPdf'])
        ->name('divisi.laporan.pdf');

    Route::post('/divisi/absensi/masuk', [DivisiDashboardController::class, 'absenMasuk'])
        ->name('divisi.absensi.masuk');

    Route::post('/divisi/absensi/keluar', [DivisiDashboardController::class, 'absenKeluar'])
        ->name('divisi.absensi.keluar');
});

Route::middleware(['karyawan.auth'])->group(function () {

    Route::get('/dashboard_karyawan', [KaryawanDashboardController::class, 'index'])
        ->name('karyawan.dashboard');

    Route::get('/karyawan_absen', [AbsensiController::class, 'index'])
        ->name('karyawan.kehadiran');

    Route::post('/karyawan/absensi/masuk', [KaryawanDashboardController::class, 'absenMasuk'])
    ->name('karyawan.absensi.masuk');

    Route::post('/karyawan/absensi/pulang', [KaryawanDashboardController::class, 'absenPulang'])
    ->name('karyawan.absensi.pulang');

    Route::get('/izin', [IzinController::class, 'index'])
        ->name('karyawan.perizinan');

    Route::post('/izin', [IzinController::class, 'store'])
        ->name('izin.store');

    Route::delete('/izin/{id}', [IzinController::class, 'destroy'])
        ->name('izin.destroy');

    Route::post('/absen-masuk', [KaryawanDashboardController::class, 'absenMasuk'])
        ->name('karyawan.absen-masuk');

    Route::post('/tidak-hadir', [KaryawanDashboardController::class, 'tidakHadir'])
        ->name('karyawan.tidak-hadir');

    Route::get('/riwayat', [KaryawanDashboardController::class, 'riwayat'])
        ->name('karyawan.riwayat');

    Route::get('/profile', [KaryawanDashboardController::class, 'profile'])
        ->name('karyawan.profile');

    Route::put('/profile', [KaryawanDashboardController::class, 'updateProfile'])
        ->name('karyawan.profile.update');

    Route::put('/profile/password', [KaryawanDashboardController::class, 'updatePassword'])
        ->name('karyawan.profile.password');

    Route::get('/absensi/pdf', [AbsensiController::class, 'exportPdf'])
        ->name('absensi.pdf');
});
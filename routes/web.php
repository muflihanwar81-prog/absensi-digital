<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\{
    HomeController,
    AbsensiController,
    AuthController,
    KaryawanController,
    TAController,
    ProdukController,
    AdminDashboardController,
    KaryawanDashboardController,
    IzinController,
    ProductController,
    AdminDataKaryawanController,
    AdminDataAbsensiController,
    AdminDataPerizinanController,
    AdminLaporanController,
    AdminKelolaDivisiController,
    DivisiDashboardController
};

Route::get('/', [HomeController::class, 'index']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/tecno_view', [TAController::class, 'tampilkan']);
Route::get('/test', [ProdukController::class, 'test']);

Route::get('/login', function () {
    return Auth::check()
        ? redirect('/dashboard')
        : view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/divisi/dashboard', [DivisiDashboardController::class, 'index'])
        ->name('divisi.dashboard');

    Route::get('/karyawan', [AdminDataKaryawanController::class, 'index'])
        ->name('karyawan');

    Route::resource('karyawan', AdminDataKaryawanController::class)
        ->except(['index']);

    Route::resource('absensi', AdminDataAbsensiController::class);

    Route::resource('perizinan', AdminDataPerizinanController::class);

    Route::get('/laporan', [AdminLaporanController::class, 'index'])
        ->name('laporan');

    Route::get('/keloladivisi', [AdminKelolaDivisiController::class, 'index'])
    ->name('keloladivisi');

Route::get('/keloladivisi/{id}/edit', [AdminKelolaDivisiController::class, 'edit'])
    ->name('keloladivisi.edit');

Route::put('/keloladivisi/{id}', [AdminKelolaDivisiController::class, 'update'])
    ->name('keloladivisi.update');

Route::delete('/keloladivisi/{id}', [AdminKelolaDivisiController::class, 'destroy'])
    ->name('keloladivisi.destroy');

    Route::post('/divisi', [AdminKelolaDivisiController::class, 'store'])
    ->name('divisi.store');

    Route::post('keloladivisi/lokasi', [AdminKelolaDivisiController::class, 'updateLokasi'])
    ->name('divisi.lokasi');
    Route::post('/lokasi/store', [AdminKelolaDivisiController::class, 'storeLokasi'])
    ->name('lokasi.store');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/dashboard_karyawan', [KaryawanDashboardController::class, 'index']);

    Route::post('/absen-masuk', [KaryawanDashboardController::class, 'absenMasuk']);

    Route::post('/tidak-hadir', [KaryawanDashboardController::class, 'tidakHadir']);

    Route::get('/riwayat', [KaryawanDashboardController::class, 'riwayat']);

    Route::get('/profile', [KaryawanDashboardController::class, 'profile']);

    Route::get('/izin', [IzinController::class, 'index']);

    Route::post('/izin', [IzinController::class, 'store']);

    Route::get('/absensi', function () {
        return view('absensi');
    });

    Route::get('/karyawan_absen', [AbsensiController::class, 'index']);

    Route::get('/absensi/pdf', [AbsensiController::class, 'exportPdf']);

    Route::resource('karyawan', KaryawanController::class);
});
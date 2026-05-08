<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AdminDataKaryawanController;
use App\Http\Controllers\AdminDataAbsensiController;
use App\Http\Controllers\AdminDataPerizinanController;
use App\Http\Controllers\AdminLaporanController;


use App\Http\Controllers\{
    HomeController,
    AbsensiController,
    AuthController,
    KaryawanController,
    TAController,
    ProdukController,
    DashboardController,
    KaryawanDashboardController,
    IzinController,
    ProductController
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

Route::get('/admindatakaryawan', [AdminDataKaryawanController::class, 'index'])
    ->name('admin.karyawan.index');

Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan');

Route::get('/admindataabsensi', [AdminDataAbsensiController::class, 'index'])
    ->name('admin.absensi.index');

Route::get('/admindataperizinan', [AdminDataPerizinanController::class, 'index'])
    ->name('admin.perizinan.index');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
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

    Route::post('/absensi/masuk', [DashboardController::class, 'masuk']);

    Route::post('/absensi/pulang', [DashboardController::class, 'pulang']);

    Route::get('/karyawan_absen', [AbsensiController::class, 'index']);

    Route::get('/absensi/pdf', [AbsensiController::class, 'exportPdf']);

    Route::resource('karyawan', KaryawanController::class);
});
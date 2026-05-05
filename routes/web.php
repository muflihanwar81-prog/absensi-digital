<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\TAController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KaryawanDashboardController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\AdminDataKaryawanController;
use App\Http\Controllers\AdminDataAbsensiController;
use App\Http\Controllers\AdminDataPerizinanController;

Route::get('/AdminDataPerizinan', [AdminDataPerizinanController::class, 'index'])->name('admin.perizinan.index');
Route::get('/AdminDataAbsensi', [AdminDataAbsensiController::class, 'index'])->name('admin.absensi.index');
Route::get('/admindatakaryawan', [AdminDataKaryawanController::class, 'index'])->name('admin.karyawan.index');

Route::get('/', [HomeController::class, 'index']);
Route::get('/contact', [HomeController::class, 'contact']);

Route::prefix('pages')->group(function () {
    Route::view('/home', 'pages.home');
    Route::view('/product', 'pages.product');
    Route::view('/contact', 'pages.contact');
});

Route::get('/tecno_view', [TAController::class, 'tampilkan']);
Route::get('/test', [ProdukController::class, 'test']);

Route::get('/product', [ProductController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);

Route::get('/login', function () {
    return Auth::check() ? redirect('/dashboard') : view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::post('/absensi/masuk', [DashboardController::class, 'masuk']);
Route::post('/absensi/pulang', [DashboardController::class, 'pulang']);

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard_karyawan', [KaryawanDashboardController::class, 'index']);

    Route::post('/absen-masuk', [KaryawanDashboardController::class, 'absenMasuk']);
    Route::post('/tidak-hadir', [KaryawanDashboardController::class, 'tidakHadir']);

    Route::get('/riwayat', [KaryawanDashboardController::class, 'riwayat']);

    Route::get('/izin', [IzinController::class, 'index']);
    Route::post('/izin', [IzinController::class, 'store']);

    Route::get('/profile', [KaryawanDashboardController::class, 'profile']);
});

Route::resource('karyawan', KaryawanController::class);

Route::get('/absensi', function () {
    return view('absensi');
});

Route::get('/laporan', function () {
    return view('laporan');
});

Route::get('/karyawan_absen', [AbsensiController::class, 'index']);
Route::post('/absen-masuk', [AbsensiController::class, 'masuk']);
Route::post('/absen-pulang', [AbsensiController::class, 'pulang']);
<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\TAController;
use App\Http\Controllers\ProdukController;

use App\Http\Controllers\DashboardController; // tambahkan controller dashboard

// Test & Home
Route::get('/test', [ProdukController::class, 'test']); 
use App\Http\Controllers\KaryawanDashboardController;
use App\Http\Controllers\IzinController;

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard_karyawan', [KaryawanDashboardController::class, 'index'])->middleware('auth');

    Route::post('/absen-masuk', [KaryawanDashboardController::class, 'absenMasuk']);
    Route::post('/tidak-hadir', [KaryawanDashboardController::class, 'tidakHadir']);

    Route::get('/riwayat', [KaryawanDashboardController::class, 'riwayat']);

    Route::get('/izin', [IzinController::class, 'index']);
    Route::post('/izin', [IzinController::class, 'store']);

    Route::get('/profile', [KaryawanDashboardController::class, 'profile']);
});
// 🔹 HALAMAN UMUM
Route::get('/', [HomeController::class, 'index']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/tecno_view', [TAController::class, 'tampilkan']);
Route::get('/test', [ProdukController::class, 'test']);

// Login & Logout
// 🔹 LOGIN
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


// Dashboard pakai controller
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Absensi Masuk & Pulang
Route::post('/absensi/masuk', [DashboardController::class, 'masuk'])->name('absensi.masuk');
Route::post('/absensi/pulang', [DashboardController::class, 'pulang'])->name('absensi.pulang');

// Halaman statis
Route::get('/karyawan', function () {
    return view('data_karyawan');
});
Route::get('/absensi', function () {
    return view('absensi');
});
Route::get('/laporan', function () {
    return view('laporan');
});
Route::get('/contact', [HomeController::class, 'contact']);

// CRUD Karyawan
Route::get('/karyawan', [KaryawanController::class, 'index']);
Route::post('/karyawan', [KaryawanController::class, 'store']);
Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy']);
Route::get('/karyawan/{id}', [KaryawanController::class, 'show']);
Route::get('/index', [KaryawanController::class, 'index']);

// 🔹 DASHBOARD
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

// 🔹 GROUP AUTH (WAJIB LOGIN)
Route::middleware(['auth'])->group(function () {

    // ✅ KARYAWAN (SUDAH RAPI)
    Route::resource('karyawan', KaryawanController::class);

    // ✅ ABSENSI
    Route::get('/absensi', function () {
        return view('absensi');
    });

    Route::get('karyawan_absen', [AbsensiController::class, 'index']);
    Route::post('/absen-masuk', [AbsensiController::class, 'masuk']);
    Route::post('/absen-pulang', [AbsensiController::class, 'pulang']);

    // ✅ LAPORAN
    Route::get('/laporan', function () {
        return view('laporan');
    });

});

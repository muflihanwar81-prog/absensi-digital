<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KaryawanController;
Route::get('/', [HomeController::class, 'index']);

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }

    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');

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



Route::get('/karyawan', [KaryawanController::class, 'index']);
Route::post('/karyawan', [KaryawanController::class, 'store']);
Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy']);
Route::get('/karyawan/{id}', [KaryawanController::class, 'show']);
Route::get('/index', [KaryawanController::class, 'index']);
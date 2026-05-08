<?php
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});
use Illuminate\Support\Facades\Auth;

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
use App\Http\Controllers\AdminDataKaryawanController;
use App\Http\Controllers\AdminDataAbsensiController;
use App\Http\Controllers\AdminDataPerizinanController;
use App\Http\Controllers\DivisiDashboardController;

Route::prefix('divisi')->name('divisi.')->group(function () {
    // URL ini akan menjadi: /divisi/dashboard
    Route::get('/dashboard', [DivisiDashboardController::class, 'index'])->name('dashboard');
    // URL ini akan menjadi: /divisi/karyawan
    Route::get('/karyawan', [DivisiDashboardController::class, 'karyawan'])->name('karyawan');
    Route::get('/riwayat-absensi', [DivisiDashboardController::class, 'riwayatAbsensi'])->name('riwayat-absensi');
    Route::get('/data-perizinan', [DivisiDashboardController::class, 'perizinan'])->name('data-perizinan');
    Route::get('/laporan', [DivisiDashboardController::class, 'laporan'])->name('laporan');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // URL ini akan menjadi: /admin/admindatakaryawan
    Route::get('/admindatakaryawan', [AdminDataKaryawanController::class, 'index'])->name('admin.karyawan.index');
    
    // URL ini akan menjadi: /admin/admindataabsensi
    Route::get('/admindataabsensi', [AdminDataAbsensiController::class, 'index'])->name('admin.absensi.index');
    
    // URL ini akan menjadi: /admin/admindataperizinan
    Route::get('/admindataperizinan', [AdminDataPerizinanController::class, 'index'])->name('admin.perizinan.index');
});

Route::get('/', [HomeController::class, 'index']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/tecno_view', [TAController::class, 'tampilkan']);
Route::get('/test', [ProdukController::class, 'test']);

Route::get('/login', function () {
    return Auth::check() ? redirect('/dashboard') : view('login');
})->name('login');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard_karyawan', [KaryawanDashboardController::class, 'index']);

    Route::post('/absen-masuk', [KaryawanDashboardController::class, 'absenMasuk']);
    Route::post('/tidak-hadir', [KaryawanDashboardController::class, 'tidakHadir']);

    Route::get('/riwayat', [KaryawanDashboardController::class, 'riwayat']);
    Route::get('/profile', [KaryawanDashboardController::class, 'profile']);

    Route::get('/izin', [IzinController::class, 'index']);
    Route::post('/izin', [IzinController::class, 'store']);

    Route::get('/absensi', fn() => view('absensi'));

    Route::post('/absensi/masuk', [DashboardController::class, 'masuk']);
    Route::post('/absensi/pulang', [DashboardController::class, 'pulang']);

    Route::get('karyawan_absen', [AbsensiController::class, 'index']);

    Route::resource('karyawan', KaryawanController::class);


    Route::view('/laporan', 'laporan');

    Route::get('/absensi/pdf', [AbsensiController::class, 'exportPdf']);
});

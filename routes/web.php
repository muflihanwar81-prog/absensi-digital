<?php

use Illuminate\Support\Facades\Route; Use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListBarangController;

route::get('/listbarang/{id}/{nama}', [ListBarangController::class, 'tampilkan']);

route::prefix('admin')->group (function () {
    Route::get('/dashboard', function () {
        return 'Dashboard Admin';
    });
    Route::get('/users', function () {
        return 'Admin users';
});
});

Route::get('/user/{id}', function ($id) {
return 'User dengan ID' . $id;
});
Route::get('/welcome', function () {
return view('welcome');
});

Route::get('/', [HomeController::class, 'index']); Route::get('/contact', [HomeController::class, 'contact']);

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;

// Public routes (login & register)
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerProcess']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protected by auth middleware
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', function () {
        return view('layout.dashboard');
    });

    // Perusahaan
    Route::prefix('perusahaan')->controller(PerusahaanController::class)->group(function () {
        Route::get('/', 'index')->name('perusahaan.index');
        Route::get('/create', 'create')->name('perusahaan.create');
        Route::post('/store', 'store')->name('perusahaan.store');
        Route::get('/edit/{id_perusahaan}', 'edit')->name('perusahaan.edit');
        Route::post('/update/{id}', 'update')->name('perusahaan.update');
        Route::delete('/delete/{id}', 'destroy')->name('perusahaan.destroy');
    });

    // Customer
    Route::prefix('customer')->controller(CustomerController::class)->group(function () {
        Route::get('/', 'index')->name('customer.index');
        Route::get('/create', 'create')->name('customer.create');
        Route::post('/store', 'store')->name('customer.store');
        Route::get('/edit/{id_customer}', 'edit')->name('customer.edit');
        Route::put('/update/{id_customer}', 'update')->name('customer.update');
        Route::delete('/delete/{id_customer}', 'destroy')->name('customer.destroy');
        Route::get('/print', 'print')->name('customer.print');
    });

    // Produk
    Route::prefix('produk')->controller(ProdukController::class)->group(function () {
        Route::get('/', 'index')->name('produk.index');
        Route::get('/create', 'create')->name('produk.create');
        Route::post('/store', 'store')->name('produk.store');
        Route::get('/edit/{id}', 'edit')->name('produk.edit');
        Route::post('/update/{id}', 'update')->name('produk.update');
        Route::delete('/destroy/{id}', 'destroy')->name('produk.destroy');
    });
    Route::prefix('penjualan')->controller(PenjualanController::class)->group(function () {
        Route::get('/', 'index')->name('penjualan.index');
        Route::get('/create', 'create')->name('penjualan.create');
        Route::post('/store', 'store')->name('penjualan.store');
        Route::get('/show/{no_faktur}', 'show')->name('penjualan.show');
        Route::delete('/destroy/{no_faktur}', 'destroy')->name('penjualan.destroy');
    });
});

<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.app');
});

// kategori
Route::get('/kategori', [KategoriController::class, 'index'])->name('pages.kategori');
Route::get('/kategori-add', [KategoriController::class, 'create'])->name('detail.addkategori');
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
// kategori edit
Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{kategori}/edit', [KategoriController::class, 'update'])->name('kategori.update');
// kategori destroy
Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');


// produk
Route::get('/produk', [ProdukController::class, 'index'])->name('pages.produk');
Route::get('/produk-add', [ProdukController::class, 'create'])->name('detail.add');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
// edit produk
Route::put('/produk/{produk}/edit', [ProdukController::class, 'update'])->name('produk.update');
// produk hapus
Route::delete('/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');


// order
Route::get('/order', [TransaksiController::class, 'index'])->name('pages.order');
Route::post('/Transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');

// payments
Route::get('/payment', [TransaksiController::class, 'payment'])->name('pages.payment');

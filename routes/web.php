<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth/redirect', [App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider']);
Route::get('/auth/callback', [App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Rute untuk halaman admin
Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin');

Route::get(uri: '/cekongkir', action: [\App\Http\Controllers\BarangController::class, 'cekongkir'])->name(name: 'cekongkir');
Route::post(uri: '/ongkir-simpan', action: [\App\Http\Controllers\BarangController::class, 'ongkirsimpan'])->name(name: 'ongkir.simpan');

//Rute untuk halaman user
Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');
Route::get('/user/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('profile.edit');
Route::put('/user/update', [App\Http\Controllers\UserController::class, 'update'])->name('profile.update');

Route::get(uri: '/cekongkos', action: [\App\Http\Controllers\BarangController::class, 'cekongkir'])->name(name: 'cekongkir');
Route::post(uri: '/ongkir-simpan', action: [\App\Http\Controllers\BarangController::class, 'ongkirsimpan'])->name(name: 'ongkir.simpan');

use App\Http\Controllers\DataUserController;

Route::resource('datauser', DataUserController::class);

use App\Http\Controllers\ProdukController;

// Resourceful route for ProdukController
Route::resource('dataproduk', ProdukController::class);

// Custom route to show products in book.blade.php
Route::get('produk/book', [ProdukController::class, 'showBook'])->name('produk.book');

Route::get('/produk/{id}', [ProdukController::class, 'detail'])->name('produk.detail');

use App\Http\Controllers\PesananController;

Route::resource('datapesanan', PesananController::class);

Route::get('/checkout/store', [ProdukController::class, 'store'])->name('checkout.store');
Route::post('/checkout/{id}', [PesananController::class, 'store'])->name('checkout.store');

// Route to display the checkout page (GET)
Route::get('/produk/{id}/checkout', [PesananController::class, 'checkout'])->name('produk.checkout');
Route::post('/checkout/{id}', [PesananController::class, 'store'])->name('checkout.store');


Route::get('/produks', [ProdukController::class, 'show'])->name('api.produks.index');

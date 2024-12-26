<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});


// routes/api.php
use App\Http\Controllers\ProdukController;

Route::get('produks', [ProdukController::class, 'apiIndex']); // Menampilkan semua produk
Route::post('produks-store', [ProdukController::class, 'apiStore'])->middleware('api'); // Menyimpan produk baru
Route::put('produks-update/{id}', [ProdukController::class, 'apiUpdate']); // Memperbarui produk
Route::delete('produks-delete/{id}', [ProdukController::class, 'apiDestroy']); // Menghapus produk

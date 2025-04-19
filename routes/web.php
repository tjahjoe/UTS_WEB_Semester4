<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\TransaksiController;
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

// Route::get('/', function () {
//     // return view('welcome');
// });
Route::get('/', [AkunController::class, 'index']);

Route::group(['prefix' => 'akun'], function(){
    Route::get('/', [AkunController::class, 'index']);
    Route::post('/list', [AkunController::class, 'list']);
    Route::get('/{id}/detail_data', [AkunController::class, 'get_detail_data']);
    Route::get('/tambah_data', [AkunController::class, 'get_tambah_data']);
    Route::post('/tambah_data', [AkunController::class, 'post_tambah_data']);
    Route::get('/{id}/edit_data', [AkunController::class, 'get_edit_data']);
    Route::put('/{id}/edit_data', [AkunController::class, 'put_edit_data']);
    Route::get('/{id}/hapus_data', [AkunController::class, 'get_hapus_data']);
    Route::delete('/{id}/hapus_data', [AkunController::class, 'delete_hapus_data']);
});

Route::group(['prefix' => 'barang'], function(){
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/list', [BarangController::class, 'list']);
    Route::get('/{id}/detail_data', [BarangController::class, 'get_detail_data']);
    Route::get('/tambah_data', [BarangController::class, 'get_tambah_data']);
    Route::post('/tambah_data', [BarangController::class, 'post_tambah_data']);
    Route::get('/{id}/edit_data', [BarangController::class, 'get_edit_data']);
    Route::put('/{id}/edit_data', [BarangController::class, 'put_edit_data']);
    Route::get('/{id}/hapus_data', [BarangController::class, 'get_hapus_data']);
    Route::delete('/{id}/hapus_data', [BarangController::class, 'delete_hapus_data']);
});

Route::group(['prefix' => 'pembelian'], function(){
    Route::get('/', [PembelianController::class, 'index']);
    Route::post('/list', [PembelianController::class, 'list']);
    Route::get('/{id}/detail_data', [PembelianController::class, 'get_detail_data']);
    Route::get('/tambah_data', [PembelianController::class, 'get_tambah_data']);
    Route::post('/tambah_data', [PembelianController::class, 'post_tambah_data']);
    Route::get('/{id}/edit_data', [PembelianController::class, 'get_edit_data']);
    Route::put('/{id}/edit_data', [PembelianController::class, 'put_edit_data']);
    Route::get('/{id}/hapus_data', [PembelianController::class, 'get_hapus_data']);
    Route::delete('/{id}/hapus_data', [PembelianController::class, 'delete_hapus_data']);
});

Route::get('/login', [AuthController::class, 'get_login'])->name('login');
Route::post('/login', [AuthController::class, 'post_login']);
Route::get('/logout', [AuthController::class, 'get_logout'])->middleware('auth');
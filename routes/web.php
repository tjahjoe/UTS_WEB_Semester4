<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\BarangController;
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

// Route::get('/', [BarangController::class, 'index']);
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

// Route::group(['prefix' => 'barang'], function(){
//     Route::get('/', [BarangController::class, 'index']);
//     Route::post('/list', [BarangController::class, 'list']);
//     Route::get('/create', [BarangController::class, 'create']);
//     Route::post('/', [BarangController::class, 'store']);
//     Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
//     Route::post('/ajax', [BarangController::class, 'store_ajax']);
//     Route::get('/{id}', [BarangController::class, 'show']);
//     Route::get('/{id}/edit', [BarangController::class, 'edit']);
//     Route::put('/{id}', [BarangController::class, 'update']);
//     Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
//     Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
//     Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
//     Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);
//     Route::delete('/{id}', [BarangController::class, 'destroy']);
// });

// Route::group(['prefix' => 'user'], function(){
//     Route::get('/', [TransaksiController::class, 'index']);
//     Route::post('/list', [TransaksiController::class, 'list']);
//     Route::get('/create', [TransaksiController::class, 'create']);
//     Route::post('/', [TransaksiController::class, 'store']);
//     Route::get('/create_ajax', [TransaksiController::class, 'create_ajax']);
//     Route::post('/ajax', [TransaksiController::class, 'store_ajax']);
//     Route::get('/{id}', [TransaksiController::class, 'show']);
//     Route::get('/{id}/edit', [TransaksiController::class, 'edit']);
//     Route::put('/{id}', [TransaksiController::class, 'update']);
//     Route::get('/{id}/edit_ajax', [TransaksiController::class, 'edit_ajax']);
//     Route::put('/{id}/update_ajax', [TransaksiController::class, 'update_ajax']);
//     Route::get('/{id}/delete_ajax', [TransaksiController::class, 'confirm_ajax']);
//     Route::delete('/{id}/delete_ajax', [TransaksiController::class, 'delete_ajax']);
//     Route::delete('/{id}', [TransaksiController::class, 'destroy']);
// });


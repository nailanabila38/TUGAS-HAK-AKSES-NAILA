<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuanganController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/rooms', [RuanganController::class, 'index']);
Route::get('/tambah-ruang', [RuanganController::class, 'create']);
Route::post('/tambah-ruang', [RuanganController::class, 'store']);

Route::get('/edit-ruang/{id}', [RuanganController::class, 'edit']);
Route::put('/edit-ruang/{id}', [RuanganController::class, 'update']);
Route::delete('/hapus-ruang/{id}', [RuanganController::class, 'destroy']);
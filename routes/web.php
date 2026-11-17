<?php

use App\Http\Controllers\RuanganController;
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
Route::redirect('/rooms', '/');

Route::middleware('auth')->group(function () {

    Route::get('/', [RuanganController::class, 'index'])
        ->middleware('akses:ruangan,view');

    Route::get('/tambah-ruang', [RuanganController::class, 'create'])
        ->middleware('akses:ruangan,create');
    Route::post('/tambah-ruang', [RuanganController::class, 'store'])
        ->middleware('akses:ruangan,create');

    Route::get('/edit-ruang/{id}', [RuanganController::class, 'edit'])
        ->middleware('akses:ruangan,edit');
    Route::put('/edit-ruang/{id}', [RuanganController::class, 'update'])
        ->middleware('akses:ruangan,edit');

    Route::delete('/hapus-ruang/{id}', [RuanganController::class, 'destroy'])
        ->middleware('akses:ruangan,delete');
});

require __DIR__.'/auth.php';

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublikasiController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/user', function (Request $request){
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    // Publikasi
    Route::get('/publikasi', [PublikasiController::class, 'index']); //menampilkan semua publikasi
    Route::post('/publikasi', [PublikasiController::class, 'store']); //membuat publikasi baru
    Route::get('/publikasi/{id}', [PublikasiController::class, 'detail']); //menampilkan detail publikasi
    Route::put('/publikasi/{id}', [PublikasiController::class, 'edit']); //mengedit data publikasi
    Route::delete('/publikasi/{id}', [PublikasiController::class, 'hapus']); //menghapus publikasi
});


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
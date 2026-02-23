<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\SpaController;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk menangani permintaan halaman dinamis dari app-spa.js
Route::get('/page/{page}', [ContentController::class, 'getPage']);

// Route API untuk filter dokumen
Route::get('/api/dokumen-sakip', [SpaController::class, 'getDokumen']);

// Route API untuk data pengukuran (IKU Kab, PD List, Keuangan)
Route::get('/api/pengukuran-data', [SpaController::class, 'getPengukuran']);

// Route API untuk detail pengukuran (Modal)
Route::get('/api/pengukuran-detail', [ContentController::class, 'getPengukuranDetail']);

// Route API untuk grafik IKU Kabupaten
Route::get('/api/iku-kabupaten', [ContentController::class, 'getIkuKabupaten']);

// Route API untuk data evaluasi
Route::get('/api/evaluasi-data', [ContentController::class, 'getEvaluasiData']);

// Route API untuk data pelaporan
Route::get('/api/pelaporan-data', [ContentController::class, 'getPelaporanData']);

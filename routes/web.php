<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\SpaController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin|moderator'])->group(function () {
    Route::get('/dashboard-admin', [AuthController::class, 'dashboardAdmin']);
});

// Route untuk cek status autentikasi (API)
Route::get('/api/auth-status', [AuthController::class, 'checkAuthStatus']);

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

// Route API untuk increment hits (Menambah jumlah dilihat)
Route::post('/api/increment-hits', [ContentController::class, 'incrementHits'])->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

//Route::post('/api/increment-hits-unduh')  
Route::post('/api/increment-hits-unduh', [App\Http\Controllers\ContentController::class, 'incrementHitsUnduh'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
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

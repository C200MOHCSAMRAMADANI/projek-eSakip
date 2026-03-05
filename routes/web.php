<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\SpaController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin/dashboard', [ContentController::class, 'adminDashboard'])->middleware('auth');

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

//Route:ADMIN PENGGUNA 
// Route: ADMIN PENGGUNA (Mengambil data dari database)
Route::get('/admin/pengguna', function () {
    // Mengambil semua data dari tabel 'user'
    $pengguna = User::orderBy('id', 'DESC')->get(); 

    // Mengirim data $pengguna ke view 'pengguna.blade.php'
    return view('pengguna', compact('pengguna')); 
});


// Di dalam routes/web.php
Route::get('/admin/dokumen/{slug}', function ($slug) {
    $mapping = [
        'perencanaan'       => ['column' => 'renstra', 'title' => 'Dokumen Perencanaan'], // Tambahkan ini
        'rencana-strategis' => ['column' => 'renstra', 'title' => 'Rencana Strategis'],
        'rencana-kerja'     => ['column' => 'renja', 'title' => 'Rencana Kerja'],
        'iku'               => ['column' => 'iku', 'title' => 'Indikator Kinerja Utama (IKU)'],
        'perjanjian-kinerja'=> ['column' => 'rencana_aksi', 'title' => 'Perjanjian Kinerja'],
        'sk-iku'            => ['column' => 'sk_iku', 'title' => 'SK IKU'],
        'pohon-kinerja'     => ['column' => 'renstra', 'title' => 'Pohon Kinerja'],
    ];

    if (!isset($mapping[$slug])) { 
        abort(404); 
    }

    $config = $mapping[$slug];
    $column = $config['column'];
    $title  = $config['title'];

    $dokumen = DB::table('file')
        ->join('user', 'file.id_opd', '=', 'user.id_opd')
        ->select('user.nama_satker', "file.$column as file_path", 'file.create_at', 'file.update_at')
        ->whereNotNull("file.$column")
        ->get();

    return view('dokumen_perencanaan', compact('dokumen', 'title'));
});
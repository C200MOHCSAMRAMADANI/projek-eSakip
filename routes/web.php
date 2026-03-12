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

Route::post('/api/increment-hits-unduh', [App\Http\Controllers\ContentController::class, 'incrementHitsUnduh'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Route: ADMIN PENGGUNA (Mengambil data dari database)
Route::get('/admin/pengguna', function () {
    // Mengambil semua data dari tabel 'user'
    $pengguna = User::orderBy('id', 'DESC')->get(); 

    // Mengirim data $pengguna ke view 'pengguna.blade.php'
    return view('pengguna', compact('pengguna')); 
});

// ==========================================
// ROUTE MEDIA (ALBUM & GALERI)
// ==========================================
Route::get('/admin/media/album', function () {
    // PERBAIKAN: Mengganti 'id' menjadi 'id_album' sesuai dengan tabel database Anda
    $albums = DB::table('album')->orderBy('id_album', 'DESC')->get();
    return view('media_album', compact('albums'));
});

Route::get('/admin/media/galeri-foto', function () {
    // Mengambil data galeri dan di-join dengan album untuk mendapatkan nama albumnya
    $galleries = DB::table('gallery')
        ->leftJoin('album', 'gallery.id_album', '=', 'album.id_album')
        ->select('gallery.*', 'album.jdl_album')
        ->orderBy('gallery.id_gallery', 'DESC')
        ->get();
        
    return view('media_galeri', compact('galleries'));
});

// ==========================================
// ROUTE DOKUMEN PERENCANAAN
// ==========================================
Route::get('/admin/dokumen/{slug}', function ($slug) {
    // SEMUA KATEGORI YANG BELUM ADA DI DATABASE SAYA TUMANGKAN KE 'rencana_aksi'
    $mapping = [
        'perencanaan'         => ['column' => 'renstra', 'title' => 'Dokumen Perencanaan'],
        'rencana-strategis'   => ['column' => 'renstra', 'title' => 'Rencana Strategis'],
        'RENSTRA'             => ['column' => 'renstra', 'title' => 'Rencana Strategis'],
        
        'rencana-kerja'       => ['column' => 'renja', 'title' => 'Rencana Kerja'],
        'RENJA'               => ['column' => 'renja', 'title' => 'Rencana Kerja'],
        
        'rencana-aksi'        => ['column' => 'rencana_aksi', 'title' => 'Rencana Aksi'],
        'REN-AKSI'            => ['column' => 'rencana_aksi', 'title' => 'Rencana Aksi'],
        
        'sk-iku'              => ['column' => 'sk_iku', 'title' => 'SK IKU'],
        'SK-IKU'              => ['column' => 'sk_iku', 'title' => 'SK IKU'],
        
        'ik-program'          => ['column' => 'iku', 'title' => 'IK Program'],
        'IK-PROGRAM'          => ['column' => 'iku', 'title' => 'IK Program'],
        
        'pohon-kinerja'       => ['column' => 'renstra', 'title' => 'Pohon Kinerja'],
        'POHON'               => ['column' => 'renstra', 'title' => 'Pohon Kinerja'],

        // --- INI YANG BIKIN ERROR, SEKARANG SEMUANYA NUMPANG KE 'rencana_aksi' ---
        'laporan-kinerja'     => ['column' => 'rencana_aksi', 'title' => 'Laporan Kinerja (LKJIP)'],
        'perjanjian-kinerja'  => ['column' => 'rencana_aksi', 'title' => 'Perjanjian Kinerja'],
        'PK'                  => ['column' => 'rencana_aksi', 'title' => 'Perjanjian Kinerja'],
        'cascading'           => ['column' => 'rencana_aksi', 'title' => 'Cascading Kegiatan'],
        'CASCADING'           => ['column' => 'rencana_aksi', 'title' => 'Cascading Kegiatan'],
        'kak'                 => ['column' => 'rencana_aksi', 'title' => 'Kerangka Acuan Kerja'],
        'KAK'                 => ['column' => 'rencana_aksi', 'title' => 'Kerangka Acuan Kerja'],
    ];

    if (!isset($mapping[$slug])) { 
        abort(404); 
    }

    $config = $mapping[$slug];
    $column = $config['column'];
    $title  = $config['title'];

    // Mengambil data dan diurutkan berdasarkan id_opd sesuai permintaan Anda
    $dokumen = DB::table('file')
        ->join('user', 'file.id_opd', '=', 'user.id_opd')
        ->select('user.nama_satker', "file.$column as file_path", 'file.create_at', 'file.update_at')
        ->whereNotNull("file.$column")
        ->orderBy('user.id_opd', 'ASC') // Ini untuk mengurutkan sesuai ID OPD
        ->get();

    return view('dokumen_perencanaan', compact('dokumen', 'title', 'slug'));
});
// Route Dashboard Client
Route::get('/dashboard-client', [AuthController::class, 'dashboardClient'])->middleware('auth')->name('dashboard.client');

// Route untuk menu Dokumen Sakip -> Perencanaan (yang ada di sidebar)
Route::get('/client/dokumen/perencanaan', [AuthController::class, 'clientPerencanaan'])->middleware('auth')->name('client.perencanaan');

// Route untuk upload dokumen perencanaan
Route::post('/client/dokumen/upload', [AuthController::class, 'uploadDokumen'])->middleware('auth')->name('client.upload');

// Route untuk delete dokumen perencanaan
Route::delete('/client/dokumen/delete', [AuthController::class, 'deleteDokumen'])->middleware('auth')->name('client.delete');

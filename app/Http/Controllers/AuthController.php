<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Handle login request
     */
    /**
     * Handle login request (Dengan Keamanan Ganda: MD5 & Bcrypt)
     */
    public function login(Request $request)
    {
        $request->validate([
            'username'       => 'required|string',
            'password'       => 'required|string',
            'password_kedua' => 'required|string',
        ]);

        $user = DB::table('user')
            ->where('username', $request->username)
            ->where('status', 'aktif')
            ->first();

        // Verifikasi Ganda
        if ($user && 
            md5($request->password) === $user->password && 
            Hash::check($request->password_kedua, $user->password_kedua)
        ) {
            $userModel = \App\Models\User::find($user->id);
            Auth::login($userModel);

            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'nama_lengkap' => $user->nama_lengkap,
                'level' => $user->level,
                'id_opd' => $user->id_opd,
                'nama_satker' => $user->nama_satker,
                'logged_in' => true,
            ]);

            if ($user->level === 'admin' || $user->level === 'moderator') {
                return redirect('/dashboard-admin')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
            } elseif ($user->level === 'client' && $user->id_opd === '00_') {
                return redirect('/dashboard-client-pemkab')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
            } elseif ($user->level === 'client') {
                return redirect('/dashboard-client')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
            }

            return redirect('/')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
        }

        return back()->with('error', 'Gagal Login! Username atau salah satu sandi Anda salah.')->withInput();
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        session()->flush();
        return redirect('/')->with('success', 'Anda telah logout');
    }

    /**
     * Show login form (for web)
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke halaman utama atau dashboard yang sesuai
        if (session('logged_in')) {
            if (session('level') === 'admin' || session('level') === 'moderator') {
                return redirect('/dashboard-admin')->with('info', 'Anda sudah logged in.');
            }
            // Cek jika yang sudah login adalah client PEMKAB
            elseif (session('level') === 'client' && session('id_opd') === '00_') {
                return redirect('/dashboard-client-pemkab')->with('info', 'Anda sudah logged in.');
            }
            // Cek jika yang sudah login adalah client OPD
            elseif (session('level') === 'client') {
                return redirect('/dashboard-client')->with('info', 'Anda sudah logged in.');
            }
            
            return redirect('/')->with('info', 'Anda sudah logged in.');
        }
        
        return view('login');
    }

    /**
     * Show dashboard admin
     */
    public function dashboardAdmin()
    {
        $tahunSekarang = date('Y');
        
        // 1. Hitung file tahun ini
        $fileTahunIni = \Illuminate\Support\Facades\DB::table('file_sakip')->where('tahun', $tahunSekarang)->count();
        
        // 2. Hitung file tahun sebelumnya
        $fileTahunLalu = \Illuminate\Support\Facades\DB::table('file_sakip')->where('tahun', '<', $tahunSekarang)->count();
        
        // 3. Hitung Total OPD Aktif (User level client)
        $totalOPD = \Illuminate\Support\Facades\DB::table('user')->where('level', 'client')->where('status', 'aktif')->count();
        
        // 4. Hitung OPD yang BELUM upload tahun ini
        $opdSudahUpload = \Illuminate\Support\Facades\DB::table('file_sakip')
                            ->where('tahun', $tahunSekarang)
                            ->distinct('id_opd')
                            ->count('id_opd');
        $opdBelumUpload = $totalOPD - $opdSudahUpload;

        return view('dashboard-admin', compact(
            'fileTahunIni', 
            'fileTahunLalu', 
            'totalOPD', 
            'opdBelumUpload'
        ));
    }

    /**
     * Check authentication status (API)
     */
    public function checkAuthStatus()
    {
        if (session('logged_in')) {
            return response()->json([
                'authenticated' => true,
                'user' => [
                    'id' => session('user_id'),
                    'username' => session('username'),
                    'nama_lengkap' => session('nama_lengkap'),
                    'level' => session('level'),
                    'id_opd' => session('id_opd'),
                    'nama_satker' => session('nama_satker'),
                ]
            ]);
        }

        return response()->json([
            'authenticated' => false
        ]);
    }
    /**
     * Show dashboard client PEMKAB - Menampilkan data untuk PEMKAB
     */
    public function dashboardClientPEMKAB()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $tahunSekarang = date('Y');
        $nama_lengkap = Auth::user()->nama_lengkap;

        // Hitung total file semua OPD tahun ini
        $fileTahunIni = DB::table('file_sakip')
            ->where('tahun', $tahunSekarang)
            ->count();
        
        // Hitung total file semua OPD (semua tahun)
        $totalFile = DB::table('file_sakip')->count();
        
        // Hitung total OPD aktif
        $totalOPD = DB::table('user')->where('level', 'client')->where('status', 'aktif')->count();
        
        // Hitung OPD yang sudah upload tahun ini
        $opdSudahUpload = DB::table('file_sakip')
            ->where('tahun', $tahunSekarang)
            ->distinct('id_opd')
            ->count('id_opd');
        $opdBelumUpload = $totalOPD - $opdSudahUpload;

        // Hitung dokumen yang sudah diverifikasi
        $dokumenTerverifikasi = DB::table('file_sakip')->where('verifikasi', 1)->count();

        // Hitung dokumen yang belum diverifikasi
        $dokumenMenunggu = DB::table('file_sakip')->where('verifikasi', 0)->count();

        return view('dashboard-client-pemkab', compact(
            'fileTahunIni', 
            'totalFile', 
            'totalOPD',
            'opdSudahUpload',
            'opdBelumUpload',
            'dokumenTerverifikasi',
            'dokumenMenunggu',
            'nama_lengkap'
        ));
    }

    /**
     * Show dashboard client - Menampilkan data spesifik OPD yang login
     */
    public function dashboardClient()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $tahunSekarang = date('Y');
        $id_opd = Auth::user()->id_opd;
        $nama_satker = Auth::user()->nama_satker;
        $nama_lengkap = Auth::user()->nama_lengkap;

        // Hitung file tahun ini untuk OPD ini saja
        $fileTahunIni = DB::table('file_sakip')
            ->where('id_opd', $id_opd)
            ->where('tahun', $tahunSekarang)
            ->count();
        
        // Hitung total file OPD ini (semua tahun)
        $totalFileOPD = DB::table('file_sakip')
            ->where('id_opd', $id_opd)
            ->count();
        
        // Hitung file tahun sebelumnya
        $fileTahunLalu = DB::table('file_sakip')
            ->where('id_opd', $id_opd)
            ->where('tahun', '<', $tahunSekarang)
            ->count();

        // Hitung dokumen yang sudah diverifikasi
        $dokumenTerverifikasi = DB::table('file_sakip')
            ->where('id_opd', $id_opd)
            ->where('verifikasi', 1)
            ->count();

        // Hitung dokumen yang belum diverifikasi
        $dokumenMenunggu = DB::table('file_sakip')
            ->where('id_opd', $id_opd)
            ->where(function($query) {
                $query->where('verifikasi', 0)
                      ->orWhereNull('verifikasi');
            })
            ->count();

        // Ambil data dokumen terbaru OPD ini (5 terbaru)
        $dokumenTerbaru = DB::table('file_sakip')
            ->where('id_opd', $id_opd)
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        return view('dashboard-client', compact(
            'fileTahunIni', 
            'fileTahunLalu', 
            'totalFileOPD',
            'dokumenTerverifikasi',
            'dokumenMenunggu',
            'dokumenTerbaru',
            'nama_satker',
            'nama_lengkap'
        ));
    }

    /**
     * Show client perencanaan page - Menampilkan dokumen perencanaan OPD yang login
     */
    public function clientPerencanaan()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $id_opd = Auth::user()->id_opd;
        $nama_satker = Auth::user()->nama_satker;
        $tahunSekarang = date('Y');

        // Ambil dokumen OPD ini dari database
        $dokumenOPD = DB::table('file_sakip')
            ->where('id_opd', $id_opd)
            ->orderBy('tahun', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get();

        // Daftar 10 dokumen OPD (sesuai permintaan user - TIDAK DIUBAH)
        $dokumenList = [
            'Rencana Strategis (RENSTRA)',
            'Rencana Kerja (RENJA)',
            'Rencana Aksi (RENAKSI)',
            'SK Indikator Kinerja Utama (IKU)',
            'Indikator Kinerja Program',
            'Pohon Kinerja Organisasi',
            'Cascading Kinerja',
            'Perjanjian Kinerja (PK)',
            'Laporan Kinerja (LKJIP)',
            'Kerangka Acuan Kerja (KAK)',
        ];

        // Hitung statistik
        $stats = [
            'total' => $dokumenOPD->count(),
            'terverifikasi' => $dokumenOPD->where('verifikasi', 1)->count(),
            'menunggu' => $dokumenOPD->filter(function($d) { return $d->verifikasi == 0 || is_null($d->verifikasi); })->count(),
            'tahun_ini' => $dokumenOPD->where('tahun', $tahunSekarang)->count(),
        ];

        return view('client-perencanaan', compact(
            'dokumenOPD',
            'dokumenList',
            'nama_satker',
            'stats',
            'tahunSekarang'
        ));
    }

    /**
     * Show client perencanaan PEMKAB page - Menampilkan 8 dokumen untuk PEMKAB
     */
    public function clientPerencanaanPEMKAB()
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        $nama_lengkap = Auth::user()->nama_lengkap;
        $tahunSekarang = date('Y');

        // Ambil data dokumen yang sudah diupload oleh PEMKAB (id_opd = '00_')
        $dokumenUploaded = DB::table('file_sakip')
            ->where('id_opd', '00_')
            ->orderBy('tahun', 'DESC')
            ->get();

        // Daftar 8 dokumen PEMKAB
        $dokumenPEMKAB = [
            ['key' => 'RPJPD', 'judul' => 'RPJPD (Rencana Pembangunan Jangka Panjang Daerah)'],
            ['key' => 'RPJMD', 'judul' => 'RPJMD (Rencana Pembangunan Jangka Menengah Daerah)'],
            ['key' => 'RKPD', 'judul' => 'RKPD (Rencana Kerja Pemerintah Daerah)'],
            ['key' => 'SK IKU', 'judul' => 'SK IKU (SK Indikator Kinerja Utama)'],
            ['key' => 'LKJIP', 'judul' => 'LKJIP (Laporan Kinerja Instansi Pemerintah)'],
            ['key' => 'Perjanjian Kinerja', 'judul' => 'Perjanjian Kinerja'],
            ['key' => 'Laporan Hasil Evaluasi', 'judul' => 'Laporan Hasil Evaluasi'],
            ['key' => 'Cascading Kinerja', 'judul' => 'Cascading Kinerja'],
        ];

        // Proses untuk mencocokkan dokumen upload dengan daftar dokumen
        foreach ($dokumenPEMKAB as &$doc) {
            $doc['data'] = null;
            foreach ($dokumenUploaded as $upload) {
                // Cek apakah judul upload mengandung keyword dokumen
                if (strpos($upload->judul, $doc['key']) !== false || 
                    strpos($doc['key'], $upload->judul) !== false ||
                    stripos($upload->judul, $doc['key']) !== false) {
                    $doc['data'] = $upload;
                    break;
                }
            }
        }

        return view('client-perencanaan-pemkab', compact(
            'nama_lengkap',
            'tahunSekarang',
            'dokumenPEMKAB'
        ));
    }

    /**
     * Handle upload dokumen perencanaan client
     */
    public function uploadDokumen(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Validasi input
        $request->validate([
            'judul' => 'required|string|max:100',
            'tahun' => 'required|integer|min:2018|max:2030',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        $id_opd = Auth::user()->id_opd;
        
        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Buat folder uploads jika belum ada
            if (!file_exists(public_path('uploads'))) {
                mkdir(public_path('uploads'), 0777, true);
            }
            
            // Simpan file ke folder public/uploads
            $file->move(public_path('uploads'), $filename);
            
            // Simpan ke database
            DB::table('file_sakip')->insert([
                'id_opd' => $id_opd,
                'judul' => $request->judul,
                'nama_file' => $filename,
                'tgl_posting' => now(),
                'tahun' => $request->tahun,
                'hits' => 0,
                'status' => 1,
                'verifikasi' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()->with('success', 'Dokumen berhasil diupload dan menunggu verifikasi!');
        }

        return back()->with('error', 'Gagal upload dokumen. Silakan coba lagi.');
    }

    /**
     * Handle upload dokumen perencanaan PEMKAB
     */
    public function uploadDokumenPEMKAB(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Validasi input
        $request->validate([
            'jenis_dokumen' => 'required|string',
            'judul' => 'required|string|max:100',
            'tahun' => 'required|integer|min:2018|max:2030',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        $id_opd = Auth::user()->id_opd;
        
        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Buat folder uploads jika belum ada
            if (!file_exists(public_path('uploads'))) {
                mkdir(public_path('uploads'), 0777, true);
            }
            
            // Simpan file ke folder public/uploads
            $file->move(public_path('uploads'), $filename);
            
            // Simpan ke database
            DB::table('file_sakip')->insert([
                'id_opd' => $id_opd,
                'judul' => $request->judul,
                'nama_file' => $filename,
                'tgl_posting' => now(),
                'tahun' => $request->tahun,
                'hits' => 0,
                'status' => 1,
                'verifikasi' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect('/client/dokumen/perencanaan-pemkab')->with('success', 'Dokumen berhasil diupload dan menunggu verifikasi!');
        }

        return back()->with('error', 'Gagal upload dokumen. Silakan coba lagi.');
    }

    /**
     * Delete dokumen perencanaan client
     */
    public function deleteDokumen(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $id_opd = Auth::user()->id_opd;
        $id_file = $request->input('id');

        // Cek apakah dokumen milik OPD ini
        $dokumen = DB::table('file_sakip')
            ->where('id_file_sakip', $id_file)
            ->where('id_opd', $id_opd)
            ->first();

        if (!$dokumen) {
            return response()->json(['success' => false, 'message' => 'Dokumen tidak ditemukan'], 404);
        }

        // Hapus file dari storage jika ada
        if ($dokumen->nama_file && file_exists(public_path('uploads/' . $dokumen->nama_file))) {
            unlink(public_path('uploads/' . $dokumen->nama_file));
        }

        // Hapus dari database
        DB::table('file_sakip')->where('id_file_sakip', $id_file)->delete();

        return response()->json(['success' => true, 'message' => 'Dokumen berhasil dihapus']);
    }
    
}

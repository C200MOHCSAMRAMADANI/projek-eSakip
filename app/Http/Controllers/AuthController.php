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
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Ambil user dari tabel user (bukan users default Laravel)
        $user = DB::table('user')
            ->where('username', $request->username)
            ->where('status', 'aktif')
            ->first();

        // Cek apakah user ada dan password cocok
        if ($user && Hash::check($request->password, $user->password)) {
            // Integrasi Auth Laravel & Spatie
            // Kita ambil instance Model User berdasarkan ID dari query DB sebelumnya
            $userModel = \App\Models\User::find($user->id);
            Auth::login($userModel);

            // Set session untuk login
            session([
                'user_id' => $user->id,
                'username' => $user->username,
                'nama_lengkap' => $user->nama_lengkap,
                'level' => $user->level,
                'id_opd' => $user->id_opd,
                'nama_satker' => $user->nama_satker,
                'logged_in' => true,
            ]);

            // Redirect berdasarkan level user
            if ($user->level === 'admin' || $user->level === 'moderator') {
                return redirect('/dashboard-admin')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
            } 
            // ---> TAMBAHAN: Redirect khusus untuk level client
            elseif ($user->level === 'client') {
                return redirect('/dashboard-client')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
            }

            return redirect('/')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
        }

        return back()->with('error', 'Username atau password salah!')->withInput();
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
            // ---> TAMBAHAN: Cek jika yang sudah login adalah client
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

        // Ambil semua dokumen perencanaan OPD ini
        $dokumen_perencanaan = DB::table('file_sakip')
            ->where('id_opd', $id_opd)
            ->orderBy('tahun', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get();

        // Hitung statistik dokumen
        $stats = [
            'total' => DB::table('file_sakip')->where('id_opd', $id_opd)->count(),
            'terverifikasi' => DB::table('file_sakip')->where('id_opd', $id_opd)->where('verifikasi', 1)->count(),
            'menunggu' => DB::table('file_sakip')->where('id_opd', $id_opd)->where(function($query) {
                $query->where('verifikasi', 0)->orWhereNull('verifikasi');
            })->count(),
            'tahun_ini' => DB::table('file_sakip')->where('id_opd', $id_opd)->where('tahun', $tahunSekarang)->count(),
        ];

        return view('client-perencanaan', compact(
            'dokumen_perencanaan', 
            'nama_satker',
            'stats',
            'tahunSekarang'
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

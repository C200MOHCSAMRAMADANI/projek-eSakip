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

            return redirect('/')->with('success', 'Selamat datang, ' . $user->nama_lengkap);
        }

        return back()->with('error', 'Username atau password salah!')->withInput();
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        session()->flush();
        return redirect('/')->with('success', 'Anda telah logout');
    }

    /**
     * Show login form (for web)
     */
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke halaman utama atau dashboard admin
        if (session('logged_in')) {
            if (session('level') === 'admin' || session('level') === 'moderator') {
                return redirect('/dashboard-admin')->with('info', 'Anda sudah logged in.');
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
        return view('dashboard-admin');
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
}

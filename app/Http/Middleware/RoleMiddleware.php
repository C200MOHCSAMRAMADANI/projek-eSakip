<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Ambil level user yang sedang login
        $userLevel = Auth::user()->level;

        // Jika middleware dipanggil menggunakan pipa (misal: role:admin|moderator)
        // Laravel 11/12 kadang mengirimkannya sebagai satu string "admin|moderator", 
        // kita perlu memecahnya menjadi array
        if (count($roles) === 1 && str_contains($roles[0], '|')) {
            $roles = explode('|', $roles[0]);
        }

        // Cek apakah level user ada di dalam daftar role yang diizinkan
        if (in_array($userLevel, $roles)) {
            return $next($request);
        }

        // Jika tidak sesuai role, tampilkan error 403 Forbidden
        abort(403, 'Akses Ditolak. Anda tidak memiliki izin untuk melihat halaman ini.');
    }
}
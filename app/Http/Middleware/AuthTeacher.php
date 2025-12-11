<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AuthTeacher
{
    /**
     * Handle an incoming request.
     * Middleware untuk proteksi route guru - hanya bisa diakses jika sudah login
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah guru sudah login
        if (!Session::has('guru_logged')) {
            return redirect()
                ->route('guru.login')
                ->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }

        // Optional: Cek session timeout (2 jam)
        $loginTime = Session::get('guru_login_time');
        if ($loginTime && now()->diffInHours($loginTime) > 2) {
            Session::forget(['guru_logged', 'guru_login_time', 'guru_session_id']);
            return redirect()
                ->route('guru.login')
                ->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        }

        // Update last activity time
        Session::put('guru_last_activity', now());

        return $next($request);
    }
}
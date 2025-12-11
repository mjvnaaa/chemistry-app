<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckTeacherAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if teacher is logged in
        if (!Session::has('guru_logged')) {
            return redirect()->route('guru.login')
                ->with('error', 'Silakan login terlebih dahulu untuk mengakses dashboard guru');
        }

        // Optional: Check if login is still valid (e.g., within 24 hours)
        if (Session::has('guru_login_time')) {
            $loginTime = Session::get('guru_login_time');
            $hoursSinceLogin = now()->diffInHours($loginTime);
            
            if ($hoursSinceLogin > 24) {
                Session::forget(['guru_logged', 'guru_login_time']);
                return redirect()->route('guru.login')
                    ->with('error', 'Sesi login telah berakhir. Silakan login kembali.');
            }
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class GuestTeacher
{
    /**
     * Handle an incoming request.
     * Middleware untuk redirect guru yang sudah login ke dashboard
     * Mencegah akses ke halaman login jika sudah authenticated
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika guru sudah login, redirect ke dashboard
        if (Session::has('guru_logged')) {
            return redirect()
                ->route('guru.dashboard')
                ->with('info', 'Anda sudah login.');
        }

        return $next($request);
    }
}
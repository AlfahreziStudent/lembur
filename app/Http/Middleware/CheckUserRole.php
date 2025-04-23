<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah pengguna sudah login
        if (!auth()->check()) {
            return redirect()->route('login'); // Redirect ke halaman login jika belum login
        }

        // Periksa apakah status pengguna adalah Admin
        if (auth()->user()->status !== 'admin') {
            return redirect('/')->withErrors(['message' => 'Access denied.']); // Redirect jika bukan admin
        }

        return $next($request);
    }
}

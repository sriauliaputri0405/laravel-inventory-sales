<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login DAN rolenya adalah 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Izinkan masuk
        }

        // Jika bukan admin (misal: staff), tolak dan kembalikan ke dashboard
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki hak akses Admin.');
    }
}
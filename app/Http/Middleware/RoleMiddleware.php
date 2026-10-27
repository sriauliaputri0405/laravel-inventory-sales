<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (!$user) {
            abort(401, 'Unauthorized. Silakan login terlebih dahulu.');
        }

        // Jika user adalah admin, izinkan akses secara otomatis ke semua halaman
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Validasi role untuk staff
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized action. Anda tidak memiliki hak akses ke halaman ini.');
        }

        return $next($request);
    }
}
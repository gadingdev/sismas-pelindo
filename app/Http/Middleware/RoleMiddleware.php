<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Cek apakah role user sesuai dengan yang diizinkan
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Akses ditolak! Anda tidak memiliki izin.');
        }

        return $next($request);
    }
}
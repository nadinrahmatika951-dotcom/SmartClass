<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Jika role user saat ini cocok dengan role yang diminta pada route
        if (Auth::user()->role == $role) {
            return $next($request);
        }

        // Jika tidak cocok, kembalikan ke dashboard atau halaman error
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}

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
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 🔒 Jika belum login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 🔥 Jika role tidak sesuai
        if (!in_array($user->jabatan, $roles)) {
            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak, Anda tidak memiliki izin.');
        }

        return $next($request);
    }
}
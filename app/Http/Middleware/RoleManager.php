<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek apakah sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Ambil data user yang sedang login
        $user = Auth::user();

        // 3. LOGIKA BARU: Jika role user TIDAK SAMA dengan role yang diminta di route
        if ($user->role !== $role) {
            // Langsung munculkan halaman error 403 (Forbidden)
            abort(403, 'MAAF, KAMU TIDAK PUNYA AKSES KE HALAMAN INI!');
        }

        return $next($request);
    }
}

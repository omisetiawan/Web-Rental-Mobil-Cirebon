<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Middleware ini memastikan bahwa user:
     * - Sudah login
     * - Memiliki role admin / superadmin
     * - Logout otomatis jika admin buka halaman publik
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Jika belum login → redirect ke login
        if (! $user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Logout otomatis jika admin buka halaman publik (bukan admin/*)
        if (in_array($user->role, ['admin', 'superadmin']) && ! $request->is('admin/*')) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('error', 'Anda otomatis logout untuk keamanan.');
        }

        // Jika bukan admin → redirect ke halaman utama
        if (!in_array($user->role, ['admin', 'superadmin'])) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        $response = $next($request);
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet');
        return $response;
    }
}

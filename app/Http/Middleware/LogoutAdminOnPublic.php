<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutAdminOnPublic
{
    /**
     * Handle an incoming request.
     *
     * Logout user admin jika membuka halaman publik (bukan admin/*)
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && in_array($user->role, ['admin', 'superadmin'])) {
            // Jika buka route publik
            if (! $request->is('admin/*')) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('message', 'Anda otomatis logout untuk keamanan.');
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Kalau belum login → ke halaman login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $roles = explode('|', $role); // support: role:admin|superadmin

        /*
        |--------------------------------------------------------------------------
        | PRIORITAS 1: Kolom 'role' di tabel users
        |--------------------------------------------------------------------------
        */
        if (!empty($user->role) && in_array($user->role, $roles)) {
            $response = $next($request);
            if ($response instanceof \Symfony\Component\HttpFoundation\Response) {
                $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet');
            }
            return $response;
        }

        /*
        |--------------------------------------------------------------------------
        | PRIORITAS 2 (opsional): Relasi RBAC jika user->roles() tersedia
        |--------------------------------------------------------------------------
        */
        if (method_exists($user, 'roles')) {
            if ($user->roles()->whereIn('name', $roles)->exists()) {
                $response = $next($request);
                if ($response instanceof \Symfony\Component\HttpFoundation\Response) {
                    $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet');
                }
                return $response;
            }
        }

        // Kalau semua gagal → 403
        abort(403, 'Unauthorized.');
    }
}

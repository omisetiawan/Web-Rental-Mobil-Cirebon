<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutomaticSeoRobotsMiddleware
{
    /**
     * Otomatis menentukan dan mengaplikasikan status indexing SEO:
     * - Seluruh halaman publik otomatis TER-INDEX (index, follow).
     * - Seluruh area admin, autentikasi, dan private user otomatis DI-BLOKIR (noindex, nofollow).
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Deteksi apakah rute/request adalah area admin, auth, atau internal
        $isPrivate = $request->is('admin*')
            || $request->is('profile*')
            || $request->is('login*')
            || $request->is('register*')
            || $request->is('forgot-password*')
            || $request->is('reset-password*')
            || $request->is('confirm-password*')
            || $request->is('verify-email*')
            || $request->is('logout*')
            || $request->is('chatbot*')
            || $request->is('debug*')
            || $request->is('test*');

        if ($isPrivate) {
            $robotsValue = 'noindex, nofollow, noarchive, nosnippet';
        } else {
            $robotsValue = 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1';
        }

        // Bagikan variabel ke seluruh Blade view secara otomatis
        view()->share('seo_robots', $robotsValue);

        $response = $next($request);

        // Pasang HTTP Header X-Robots-Tag pada response jika bertipe Response
        if ($response instanceof Response) {
            $response->headers->set('X-Robots-Tag', $robotsValue);
        }

        return $response;
    }
}

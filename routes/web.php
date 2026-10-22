<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;

/*
|--------------------------------------------------------------------------
| LANDING PAGE - PUBLIC
|--------------------------------------------------------------------------
| Tambahkan middleware 'logout.admin' agar admin otomatis logout saat buka publik
*/

Route::middleware('logout.admin')->controller(LandingController::class)->group(function () {
    Route::get('/', 'home')->name('landing.home');
    Route::get('/pricing', 'pricing')->name('landing.pricing');
    Route::get('/car/{id}', 'detail')->name('landing.detail');
    Route::get('/about', 'about')->name('landing.about');
    Route::get('/contact', 'contact')->name('landing.contact');
    Route::post('/contact', 'contactStore')->name('landing.contact.store');
});

// Blog & Travel Guides
Route::middleware('logout.admin')->controller(BlogController::class)->group(function () {
    Route::get('/blog', 'index')->name('landing.blog.index');
    Route::get('/blog/{slug}', 'show')->name('landing.blog.show');
});

// XML Sitemap for Search Engine Discovery
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.xml');

// Dynamic robots.txt
Route::get('/robots.txt', function () {
    $sitemapUrl = url('/sitemap.xml');
    $content = "User-agent: *\n"
        . "Allow: /\n"
        . "Allow: /assets/\n"
        . "Allow: /build/\n"
        . "Allow: /storage/\n"
        . "Allow: /pricing\n"
        . "Allow: /car/\n"
        . "Allow: /about\n"
        . "Allow: /contact\n"
        . "Allow: /blog\n"
        . "Allow: /blog/\n\n"
        . "# Strictly Disallow Admin Portal\n"
        . "Disallow: /admin\n"
        . "Disallow: /admin/\n"
        . "Disallow: /admin/*\n\n"
        . "# Disallow User Profile\n"
        . "Disallow: /profile\n"
        . "Disallow: /profile/\n"
        . "Disallow: /profile/*\n\n"
        . "# Disallow Authentication\n"
        . "Disallow: /login\n"
        . "Disallow: /register\n"
        . "Disallow: /forgot-password\n"
        . "Disallow: /reset-password\n"
        . "Disallow: /confirm-password\n"
        . "Disallow: /verify-email\n"
        . "Disallow: /logout\n\n"
        . "# Disallow Internal APIs & Diagnostics\n"
        . "Disallow: /chatbot/\n"
        . "Disallow: /debug/\n"
        . "Disallow: /test\n\n"
        . "Sitemap: {$sitemapUrl}\n";

    return response($content, 200, ['Content-Type' => 'text/plain; charset=utf-8']);
});

/*
|--------------------------------------------------------------------------
| CHATBOT
|--------------------------------------------------------------------------
*/
Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])
    ->middleware(['throttle:10,1', 'logout.admin'])
    ->name('chatbot.send');

/*
|--------------------------------------------------------------------------
| ADMIN AREA (secured)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Cars
        Route::resource('cars', CarController::class)->middleware('throttle:30,1');
        Route::post('cars/{car}/status', [CarController::class, 'updateStatus'])
            ->name('cars.updateStatus')
            ->middleware('throttle:20,1');
        Route::get('cars/trashed/list', [CarController::class, 'trashed'])
            ->name('cars.trashed')
            ->middleware('throttle:20,1');
        Route::post('cars/{id}/restore', [CarController::class, 'restore'])
            ->name('cars.restore')
            ->middleware('throttle:10,1');
        Route::delete('cars/{id}/force-delete', [CarController::class, 'forceDelete'])
            ->name('cars.forceDelete')
            ->middleware('throttle:10,1');

        // Bookings
        Route::resource('bookings', BookingController::class)->middleware('throttle:30,1');
        Route::post('bookings/{booking}/status', [BookingController::class, 'updateStatus'])
            ->name('bookings.updateStatus')
            ->middleware('throttle:20,1');
        Route::post('bookings/calculate-price', [BookingController::class, 'calculatePrice'])
            ->name('bookings.calculatePrice')
            ->middleware('throttle:30,1');

        // Contacts
        Route::resource('contacts', ContactController::class)->middleware('throttle:30,1');
        Route::post('contacts/{contact}/mark-as-read', [ContactController::class, 'markAsRead'])
            ->name('contacts.markAsRead')
            ->middleware('throttle:20,1');
        Route::patch('contacts/{contact}/status', [ContactController::class, 'updateStatus'])
            ->name('contacts.updateStatus')
            ->middleware('throttle:20,1');
        Route::post('contacts/mark-all-read', [ContactController::class, 'markAllRead'])
            ->name('contacts.markAllRead')
            ->middleware('throttle:10,1');
        Route::post('contacts/bulk-action', [ContactController::class, 'bulkAction'])
            ->name('contacts.bulkAction')
            ->middleware('throttle:10,1');

        // Posts & Yoast SEO Blog Management
        Route::resource('posts', PostController::class)->middleware('throttle:30,1');

        // Reports
        Route::get('reports', [ReportController::class, 'index'])
            ->name('reports.index')
            ->middleware('throttle:20,1');
        Route::match(['GET', 'POST'], 'reports/pdf', [ReportController::class, 'generatePDF'])
            ->name('reports.pdf')
            ->middleware('throttle:20,1');
        Route::match(['GET', 'POST'], 'reports/generate-pdf', [ReportController::class, 'generatePDF'])
            ->name('reports.generatePDF')
            ->middleware('throttle:20,1');
    });

/*
|--------------------------------------------------------------------------
| USER PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit')
        ->middleware('throttle:10,1');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update')
        ->middleware('throttle:10,1');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy')
        ->middleware('throttle:5,1');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| LOCAL TEST ONLY
|--------------------------------------------------------------------------
*/
if (app()->environment('local')) {
    Route::get('/test', fn() => 'OK')->middleware('throttle:10,1');

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/debug/routes', function () {
            $routes = collect(Route::getRoutes())->map(function ($route) {
                return [
                    'method' => $route->methods(),
                    'uri' => $route->uri(),
                    'name' => $route->getName(),
                    'action' => $route->getActionName(),
                ];
            });
            return response()->json($routes);
        })->name('debug.routes');
    });
}

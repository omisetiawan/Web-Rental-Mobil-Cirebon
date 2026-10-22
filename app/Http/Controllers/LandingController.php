<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Car;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;

class LandingController extends Controller
{
    // Rate limiting configuration
    const MAX_CONTACT_ATTEMPTS = 3;
    const MAX_SEARCH_ATTEMPTS = 30;
    const RATE_LIMIT_DECAY = 3600;

    public function home(Request $request)
    {
        // Rate limiting untuk search (additional layer)
        $searchKey = 'search-home-' . $this->getClientIdentifier($request);
        if ($request->has('search') && RateLimiter::tooManyAttempts($searchKey, self::MAX_SEARCH_ATTEMPTS)) {
            abort(429, 'Terlalu banyak permintaan pencarian. Silakan coba lagi nanti.');
        }

        try {
            // Ambil data real dari database untuk stats dengan query optimization
            $stats = $this->getSecureStats();

            // Ambil 3 mobil terpopuler untuk featured section
            $featuredCars = Car::where('status', 'available')
                ->select(['id', 'brand', 'model', 'price_per_day', 'color', 'year', 'fuel_type', 'transmission', 'seat_capacity', 'status', 'image', 'images'])
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();

            // Query untuk search & filter dengan sanitization
            $query = Car::where('status', 'available');

            // Fungsi pencarian dengan input sanitization
            if ($request->has('search') && !empty($request->search)) {
                $search = $this->sanitizeSearchInput($request->search);
                $query->where(function($q) use ($search) {
                    $q->where('brand', 'like', "%{$search}%")
                      ->orWhere('model', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%")
                      ->orWhere('plate_number', 'like', "%{$search}%");
                });

                // Hitung rate limiting untuk search
                RateLimiter::hit($searchKey, self::RATE_LIMIT_DECAY);
            }

            // Filter tipe / kategori kendaraan
            if ($request->filled('type') || $request->filled('category')) {
                $categorySearch = $request->input('category', $request->input('type'));
                $query->where(function($q) use ($categorySearch) {
                    $q->where('category', 'like', "%{$categorySearch}%")
                      ->orWhere('model', 'like', "%{$categorySearch}%");
                });
            }

            // Filter transmission
            if ($request->has('transmission') && in_array($request->transmission, ['manual', 'automatic'])) {
                $query->where('transmission', $request->transmission);
            }

            // Fungsi sorting dengan whitelist
            $sortField = $this->validateSortField($request->sort);
            $query = $this->applySecureSorting($query, $sortField);

            // Pagination dengan limit - TAMBAHKAN field image dan images
            $cars = $query->select([
                    'id', 'brand', 'model', 'category', 'price_per_day', 'color',
                    'year', 'fuel_type', 'transmission', 'seat_capacity',
                    'plate_number', 'status', 'image', 'images'
                ])
                ->paginate(12)
                ->appends($request->except('page'));

            // Ambil semua mobil aktif untuk dropdown kalkulator dinamis langsung dari database
            $allCars = Car::where('status', 'available')
                ->select(['id', 'brand', 'model', 'price_per_day'])
                ->orderBy('price_per_day', 'asc')
                ->get();

            return view('landing.home', compact('cars', 'stats', 'featuredCars', 'allCars'));

        } catch (\Exception $e) {
            Log::error('Home page error: ' . $e->getMessage(), [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'inputs' => $request->all()
            ]);

            // Fallback tanpa search/filter jika error
            $cars = Car::where('status', 'available')
                ->select(['id', 'brand', 'model', 'price_per_day', 'color', 'year', 'fuel_type', 'status', 'image', 'images'])
                ->latest()
                ->paginate(12);

            $allCars = Car::where('status', 'available')
                ->select(['id', 'brand', 'model', 'price_per_day'])
                ->orderBy('price_per_day', 'asc')
                ->get();

            return view('landing.home', compact('cars', 'stats', 'featuredCars', 'allCars'))
                ->with('error', 'Terjadi kesalahan sistem. Menampilkan data default.');
        }
    }

    public function pricing(Request $request)
    {
        try {
            // PERBAIKAN: Tampilkan SEMUA mobil, tidak hanya yang available
            $query = Car::whereNull('deleted_at') // Hanya mobil yang tidak dihapus
                ->select([
                    'id', 'brand', 'model', 'category', 'price_per_day', 'color',
                    'year', 'fuel_type', 'transmission', 'seat_capacity',
                    'plate_number', 'status', 'image', 'images'
                ]);

            // Sanitized search
            if ($request->has('search') && !empty($request->search)) {
                $search = $this->sanitizeSearchInput($request->search);
                $query->where(function($q) use ($search) {
                    $q->where('brand', 'like', "%{$search}%")
                      ->orWhere('model', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%")
                      ->orWhere('plate_number', 'like', "%{$search}%");
                });
            }

            // Sorting untuk pricing page
            if ($request->has('sort')) {
                $sortField = $this->validateSortField($request->sort);
                $query = $this->applySecureSorting($query, $sortField);
            } else {
                $query->orderBy('price_per_day', 'asc');
            }

            $cars = $query->paginate(6)->withQueryString();

            // Optimized stats query - PERBAIKAN: Hitung semua mobil
            $stats = $this->getPricingStats();

            // Quick filter models diambil langsung dan dinamis dari database (bukan hardcoded)
            $quickModels = Car::whereNull('deleted_at')
                ->select('model', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
                ->groupBy('model')
                ->orderByDesc('total')
                ->orderBy('model')
                ->pluck('model')
                ->take(5);

            return view('landing.pricing', compact('cars', 'stats', 'quickModels'));

        } catch (\Exception $e) {
            Log::error('Pricing page error: ' . $e->getMessage(), [
                'ip' => $request->ip(),
                'inputs' => $request->all()
            ]);

            // Fallback: tampilkan semua mobil tanpa filter
            $cars = Car::whereNull('deleted_at')
                ->select([
                    'id', 'brand', 'model', 'category', 'price_per_day', 'color',
                    'year', 'fuel_type', 'transmission', 'seat_capacity',
                    'plate_number', 'status', 'image', 'images'
                ])
                ->orderBy('price_per_day', 'asc')
                ->paginate(6)
                ->withQueryString();

            $stats = $this->getPricingStats();
            $quickModels = Car::whereNull('deleted_at')
                ->select('model')
                ->distinct()
                ->pluck('model')
                ->take(5);

            return view('landing.pricing', compact('cars', 'stats', 'quickModels'))
                ->with('error', 'Terjadi kesalahan sistem. Menampilkan semua mobil.');
        }
    }

    public function detail($id)
    {
        try {
            // Validasi ID untuk mencegah SQL injection
            if (!is_numeric($id) || $id <= 0) {
                abort(404, 'Mobil tidak ditemukan.');
            }

            // PERBAIKAN: Bisa tampilkan detail mobil meskipun status bukan available
            $car = Car::whereNull('deleted_at')
                ->select([
                    'id', 'brand', 'model', 'category', 'price_per_day', 'color', 'year', 'fuel_type',
                    'transmission', 'seat_capacity', 'plate_number', 'status', 'image', 'images'
                ])
                ->findOrFail($id);

            // Ambil mobil terkait dengan query optimization
            $relatedCars = Car::where('brand', $car->brand)
                ->where('id', '!=', $car->id)
                ->where('status', 'available') // Hanya yang available untuk related
                ->select(['id', 'brand', 'model', 'price_per_day', 'color', 'year', 'status', 'image', 'images']) // TAMBAH INI
                ->inRandomOrder()
                ->limit(3)
                ->get();

            return view('landing.detail', compact('car', 'relatedCars'));

        } catch (\Exception $e) {
            Log::error('Car detail error: ' . $e->getMessage(), [
                'car_id' => $id,
                'ip' => request()->ip()
            ]);

            abort(404, 'Mobil tidak ditemukan.');
        }
    }

    public function contact()
    {
        return view('landing.contact');
    }

    public function about()
    {
        $stats = $this->getSecureStats();
        return view('landing.about', compact('stats'));
    }

    public function contactStore(Request $request)
    {
        // Rate limiting berdasarkan IP dan session
        $rateLimitKey = 'contact-form-' . $this->getClientIdentifier($request);

        if (RateLimiter::tooManyAttempts($rateLimitKey, self::MAX_CONTACT_ATTEMPTS)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);
            return redirect()->back()
                ->with('error', "Terlalu banyak percobaan. Silakan coba lagi dalam {$seconds} detik.")
                ->withInput();
        }

        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'regex:/^[a-zA-Z\s\.\'\-\p{L}]+$/u'
                ],
                'phone' => [
                    'required',
                    'string',
                    'max:20',
                    'regex:/^[\+]?[0-9\s\-\(\)]{10,20}$/'
                ],
                'email' => [
                    'required',
                    'email:rfc,filter',
                    'max:255'
                ],
                'purpose' => [
                    'required',
                    'string',
                    Rule::in(['booking', 'info', 'partnership', 'complaint', 'other'])
                ],
                'message' => [
                    'required',
                    'string',
                    'min:10',
                    'max:2000',
                    function ($attribute, $value, $fail) {
                        if ($this->containsSuspiciousContent($value)) {
                            $fail('Pesan mengandung konten yang tidak diizinkan.');
                        }
                    }
                ]
            ], [
                'name.required' => 'Nama lengkap wajib diisi',
                'name.regex' => 'Format nama tidak valid',
                'phone.required' => 'Nomor WhatsApp wajib diisi',
                'phone.regex' => 'Format nomor telepon tidak valid',
                'email.required' => 'Alamat email wajib diisi',
                'email.email' => 'Format email tidak valid',
                'purpose.required' => 'Keperluan wajib dipilih',
                'message.required' => 'Pesan wajib diisi',
                'message.min' => 'Pesan minimal 10 karakter',
                'message.max' => 'Pesan maksimal 2000 karakter',
            ]);

            // Additional phone validation
            $phone = $this->formatAndValidatePhoneNumber($validated['phone']);
            if (!$phone) {
                return redirect()->back()
                    ->with('error', 'Format nomor telepon tidak valid.')
                    ->withInput();
            }

            // Create contact message - SESUAI dengan struktur database
            Contact::create([
                'name' => strip_tags($validated['name']),
                'phone' => $phone,
                'email' => strtolower(trim($validated['email'])),
                'purpose' => $validated['purpose'],
                'message' => $this->sanitizeMessage($validated['message']),
                'status' => 'unread'
            ]);

            // Hit rate limiter setelah sukses
            RateLimiter::hit($rateLimitKey, self::RATE_LIMIT_DECAY);

            Log::info('Contact form submitted successfully', [
                'email' => $validated['email'],
                'purpose' => $validated['purpose'],
                'ip' => $request->ip()
            ]);

            return redirect()->back()
                ->with('success', 'Pesan Anda berhasil dikirim! Tim kami akan merespons dalam 2 jam kerja.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            RateLimiter::hit($rateLimitKey, self::RATE_LIMIT_DECAY);

            Log::warning('Contact form validation failed', [
                'errors' => $e->errors(),
                'ip' => $request->ip(),
                'inputs' => $request->except('g-recaptcha-response')
            ]);

            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();

        } catch (\Exception $e) {
            RateLimiter::hit($rateLimitKey, self::RATE_LIMIT_DECAY);

            Log::error('Contact form system error: ' . $e->getMessage(), [
                'ip' => $request->ip(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi WhatsApp langsung.')
                ->withInput();
        }
    }

    /**
     * ==================== SECURITY HELPER METHODS ====================
     */

    private function getClientIdentifier(Request $request): string
    {
        return md5($request->ip() . $request->userAgent());
    }

    private function sanitizeSearchInput(string $input): string
    {
        $input = trim(strip_tags($input));
        $input = preg_replace('/[^\w\s\-@\.]/u', '', $input);
        return substr($input, 0, 50);
    }

    private function validateSortField(?string $sort): string
    {
        $allowedSorts = [
            'price_low' => 'price_per_day',
            'price_high' => 'price_per_day',
            'year_new' => 'year',
            'default' => 'created_at'
        ];

        return $allowedSorts[$sort] ?? $allowedSorts['default'];
    }

    private function applySecureSorting($query, string $sortField)
    {
        $direction = 'asc';

        if (request()->sort === 'price_high') {
            $direction = 'desc';
        } elseif (request()->sort === 'year_new') {
            $direction = 'desc';
        } else {
            $direction = 'asc';
        }

        return $query->orderBy($sortField, $direction);
    }

    private function formatAndValidatePhoneNumber($phone): ?string
    {
        // Hapus karakter selain angka dan +
        $phone = preg_replace('/[^\d+]/', '', $phone);

        if (empty($phone) || strlen($phone) < 10) {
            return null;
        }

        // Format Indonesia
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (!str_starts_with($phone, '62') && !str_starts_with($phone, '+62')) {
            $phone = '62' . $phone;
        }

        // Remove + jika ada
        $phone = str_replace('+', '', $phone);

        // Validasi final format
        if (!preg_match('/^62\d{9,13}$/', $phone)) {
            return null;
        }

        return $phone;
    }

    private function containsSuspiciousContent(string $message): bool
    {
        $suspiciousPatterns = [
            '/<script\b[^>]*>(.*?)<\/script>/is',
            '/javascript:/i',
            '/onmouseover|onclick|onload|onerror/i',
            '/base64_decode/',
            '/eval\(/',
            '/union\s+select/i',
            '/drop\s+table/i',
            '/insert\s+into/i',
            '/select.*from/i',
            '/http:\/\/|https:\/\//i',
        ];

        foreach ($suspiciousPatterns as $pattern) {
            if (preg_match($pattern, $message)) {
                return true;
            }
        }

        return false;
    }

    private function sanitizeMessage(string $message): string
    {
        $message = strip_tags($message);
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
        return trim($message);
    }

    /**
     * Get secure stats - SESUAI dengan struktur database
     */
    private function getSecureStats(): array
    {
        return [
            'total_customers' => Booking::distinct('customer_phone')->count(),
            'total_cars' => Car::count(),
            'available_cars' => Car::where('status', 'available')->count(),
            'rating' => 4.9,
            'pending_bookings' => Booking::where('status', 'pending')->count(),
        ];
    }

 /**
 * Get pricing stats - FIX SEMENTARA: Handle kolom yang belum ada
 */
private function getPricingStats(): array
{
    // Cek apakah kolom year_start dan year_end sudah ada
    $hasYearStart = \Schema::hasColumn('cars', 'year_start');
    $hasYearEnd = \Schema::hasColumn('cars', 'year_end');

    if ($hasYearStart && $hasYearEnd) {
        // Jika kolom sudah ada, gunakan query baru
        $carStats = Car::whereNull('deleted_at')
            ->selectRaw('COUNT(*) as total,
                         COUNT(CASE WHEN status = "available" THEN 1 END) as available,
                         MIN(year_start) as min_year,
                         MAX(year_end) as max_year,
                         MIN(price_per_day) as min_price')
            ->first();

        $minYear = $carStats->min_year ?? date('Y');
        $maxYear = $carStats->max_year ?? date('Y');
    } else {
        // Jika kolom belum ada, gunakan parsing dari year string
        $carStats = Car::whereNull('deleted_at')
            ->selectRaw('COUNT(*) as total,
                         COUNT(CASE WHEN status = "available" THEN 1 END) as available,
                         MIN(price_per_day) as min_price')
            ->first();

        // Hitung min dan max year dari string
        $allYears = Car::whereNull('deleted_at')->pluck('year');

        $startYears = [];
        $endYears = [];

        foreach ($allYears as $year) {
            if (str_contains($year, ' - ')) {
                $years = explode(' - ', $year);
                if (count($years) === 2) {
                    $startYears[] = (int) trim($years[0]);
                    $endYears[] = (int) trim($years[1]);
                }
            } else {
                $singleYear = (int) trim($year);
                if ($singleYear > 0) {
                    $startYears[] = $singleYear;
                    $endYears[] = $singleYear;
                }
            }
        }

        $minYear = !empty($startYears) ? min($startYears) : date('Y');
        $maxYear = !empty($endYears) ? max($endYears) : date('Y');
    }

    return [
        'total_cars' => $carStats->total ?? 0,
        'available_cars' => $carStats->available ?? 0,
        'rented_cars' => Car::where('status', 'rented')->whereNull('deleted_at')->count(),
        'maintenance_cars' => Car::where('status', 'maintenance')->whereNull('deleted_at')->count(),
        'min_year' => $minYear,
        'max_year' => $maxYear,
        'min_price' => $carStats->min_price ?? 0,
    ];
}

    /**
     * Temporary method to fix existing year data (run once)
     */
    public function fixYearData()
    {
        try {
            $cars = Car::all();
            $fixedCount = 0;

            foreach ($cars as $car) {
                // Jika belum ada year_start dan year_end, generate dari year string
                if (!$car->year_start || !$car->year_end) {
                    $cleanYear = $car->cleanYearFormat($car->year);
                    if (str_contains($cleanYear, ' - ')) {
                        $years = explode(' - ', $cleanYear);
                        $car->update([
                            'year_start' => (int) $years[0],
                            'year_end' => (int) $years[1],
                            'year' => $cleanYear
                        ]);
                        $fixedCount++;
                    }
                }
            }

            return redirect()->route('admin.cars.index')
                ->with('success', "Data tahun berhasil dibersihkan! {$fixedCount} mobil diperbaiki.");
        } catch (\Exception $e) {
            Log::error('Year data fix failed: ' . $e->getMessage());
            return redirect()->route('admin.cars.index')
                ->with('error', 'Gagal membersihkan data tahun: ' . $e->getMessage());
        }
    }
}

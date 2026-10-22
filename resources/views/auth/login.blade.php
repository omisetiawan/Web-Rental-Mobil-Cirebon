<!DOCTYPE html>
<html lang="id" class="dark h-full bg-[#07090e]">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Masuk ke Akun - RentGo Indonesia</title>

    {{-- Strict SEO & Security: Never index login authentication views --}}
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
    <meta name="googlebot" content="noindex, nofollow, noarchive, nosnippet">

    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        html, body {
            background-color: #07090e !important;
            color: #ffffff !important;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
        }
        .purple-card-bg {
            background: radial-gradient(130% 95% at 50% 0%, #8b3dff 0%, #5816c5 28%, #21074e 62%, #090216 100%);
            box-shadow: inset 0 1px 1px 0 rgba(255, 255, 255, 0.25), 0 20px 40px -15px rgba(0, 0, 0, 0.7);
        }
    </style>
</head>
<body class="min-h-screen bg-[#07090e] text-white flex items-center justify-center p-3 sm:p-5 md:p-8 antialiased selection:bg-[#8b3dff] selection:text-white">

    <div class="w-full max-w-[1240px] min-h-[640px] lg:min-h-[720px] rounded-[32px] bg-[#07090e] lg:border lg:border-white/10 p-3 md:p-4 lg:p-5 grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
        
        {{-- LEFT PANEL: Glowing Purple Aurora Card (Reference Match) --}}
        <div class="lg:col-span-6 rounded-[28px] purple-card-bg border border-white/15 p-8 md:p-12 flex flex-col justify-between relative overflow-hidden min-h-[460px] lg:min-h-[660px]">
            {{-- Background Subtle Glow Orb --}}
            <div class="absolute -top-24 -left-24 w-72 h-72 bg-[#c084fc]/20 rounded-full blur-3xl pointer-events-none"></div>

            {{-- Top Branding --}}
            <div class="relative z-10 flex items-center justify-between">
                <a href="{{ route('landing.home') }}" class="inline-flex items-center gap-2 group">
                    <img src="{{ asset('assets/rentgo_light.png') }}"
                         alt="RentGo"
                         class="h-9 md:h-11 w-auto object-contain transition-transform group-hover:scale-105" />
                </a>
                <span class="text-[11px] font-medium tracking-[0.14em] uppercase text-white/70 bg-white/10 backdrop-blur-sm px-3 py-1 rounded-full border border-white/15">
                    ADMIN PORTAL
                </span>
            </div>

            {{-- Center Content: Headline & Subtitle --}}
            <div class="relative z-10 my-auto py-8">
                <div class="inline-flex items-center gap-2 text-white/80 text-xs font-medium mb-3">
                    <span class="w-2 h-2 rounded-full bg-[#18dcdc] animate-pulse"></span>
                    <span>Sistem Manajemen Terpadu</span>
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-[44px] font-semibold tracking-[-0.03em] leading-[1.05] text-white">
                    Get Started with Us
                </h2>
                <p class="mt-4 text-sm md:text-base text-white/75 leading-relaxed max-w-[460px]">
                    Kelola kesiapan armada mobil, verifikasi pemesanan lepas kunci, dan pantau performa operasional Cirebon secara real-time.
                </p>

                {{-- Stacked Step/Feature Badges (Exact OnlyPipe Reference Style) --}}
                <div class="mt-8 space-y-3 max-w-[400px]">
                    {{-- Active Step 1: Solid White Pill --}}
                    <div class="flex items-center gap-3.5 px-4 py-3 rounded-[14px] bg-white text-black font-semibold text-sm shadow-lg transition-transform hover:translate-x-1">
                        <span class="w-6 h-6 rounded-full bg-black text-white flex items-center justify-center text-xs font-bold">1</span>
                        <span>Sign in to admin dashboard</span>
                    </div>

                    {{-- Step 2: Dark Translucent Pill --}}
                    <div class="flex items-center gap-3.5 px-4 py-3 rounded-[14px] bg-white/10 border border-white/15 text-white/90 text-sm font-medium transition-transform hover:translate-x-1">
                        <span class="w-6 h-6 rounded-full bg-white/20 text-white flex items-center justify-center text-xs font-bold">2</span>
                        <span>Monitor armada & jadwal sewa</span>
                    </div>

                    {{-- Step 3: Dark Translucent Pill --}}
                    <div class="flex items-center gap-3.5 px-4 py-3 rounded-[14px] bg-white/10 border border-white/15 text-white/90 text-sm font-medium transition-transform hover:translate-x-1">
                        <span class="w-6 h-6 rounded-full bg-white/20 text-white flex items-center justify-center text-xs font-bold">3</span>
                        <span>Kelola transaksi & laporan rental</span>
                    </div>
                </div>
            </div>

            {{-- Bottom Footer Note --}}
            <div class="relative z-10 flex items-center justify-between text-xs text-white/50 pt-4 border-t border-white/10">
                <span>RentGo Indonesia • Versi 2.4</span>
                <span class="flex items-center gap-1.5 text-emerald-400 font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    Sistem Aktif
                </span>
            </div>
        </div>

        {{-- RIGHT PANEL: Sleek Dark Login Form --}}
        <div class="lg:col-span-6 flex flex-col justify-center px-4 sm:px-8 md:px-12 lg:px-16 py-6 md:py-10">
            <div class="w-full max-w-[440px] mx-auto">
                
                {{-- Form Header --}}
                <div class="mb-8">
                    <h1 class="text-2xl md:text-3xl font-semibold text-white tracking-[-0.03em]">
                        Sign In Account
                    </h1>
                    <p class="mt-2 text-sm text-[#8b95a8] leading-relaxed">
                        Masukkan email dan password terdaftar untuk mengakses dashboard.
                    </p>
                </div>

                {{-- Status Session Alert --}}
                @if (session('status'))
                    <div class="mb-6 p-3.5 rounded-[12px] bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-sm flex items-center gap-2">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                {{-- Validation Errors Alert --}}
                @if ($errors->any())
                    <div class="mb-6 p-3.5 rounded-[12px] bg-red-500/15 border border-red-500/30 text-red-300 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <div class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                <span>{{ $error }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email Input --}}
                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-[#a0aec0] mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="eg. admin@rentgo.id"
                                class="w-full px-4 py-3.5 rounded-[12px] bg-[#141a26] text-white placeholder-[#505c73] border border-white/10 focus:border-[#8b3dff] focus:ring-2 focus:ring-[#8b3dff]/30 outline-none text-sm transition-all"
                            />
                        </div>
                    </div>

                    {{-- Password Input --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-[#a0aec0]">
                                Password
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-[#a0aec0] hover:text-white transition-colors">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                class="w-full px-4 py-3.5 pr-11 rounded-[12px] bg-[#141a26] text-white placeholder-[#505c73] border border-white/10 focus:border-[#8b3dff] focus:ring-2 focus:ring-[#8b3dff]/30 outline-none text-sm transition-all"
                            />
                            <button
                                type="button"
                                onclick="togglePasswordVisibility()"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[#68748d] hover:text-white transition-colors p-1"
                                aria-label="Lihat password"
                            >
                                <svg id="eyeIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eyeSlashIcon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center pt-1">
                        <label class="inline-flex items-center gap-2 cursor-pointer select-none">
                            <input
                                type="checkbox"
                                name="remember"
                                id="remember_me"
                                class="w-4 h-4 rounded-[4px] bg-[#141a26] border-white/20 text-[#8b3dff] focus:ring-0 focus:ring-offset-0 cursor-pointer"
                            />
                            <span class="text-xs text-[#a0aec0] hover:text-white transition-colors">
                                Ingat saya di perangkat ini
                            </span>
                        </label>
                    </div>

                    {{-- Submit Button (High-Contrast Solid White Button like reference) --}}
                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full py-3.5 px-4 rounded-[12px] bg-white hover:bg-gray-100 text-black font-semibold text-sm tracking-wide transition-all transform active:scale-[0.99] shadow-lg flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <span>Sign In</span>
                            <span class="text-xs">→</span>
                        </button>
                    </div>
                </form>

                {{-- Back to Home --}}
                <div class="mt-8 pt-6 border-t border-white/10 text-center">
                    <a href="{{ route('landing.home') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-[#8b95a8] hover:text-white transition-colors">
                        <span>← Kembali ke Beranda RentGo</span>
                    </a>
                </div>

            </div>
        </div>

    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeSlashIcon = document.getElementById('eyeSlashIcon');
            if (!passwordInput) return;

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }
    </script>
</body>
</html>

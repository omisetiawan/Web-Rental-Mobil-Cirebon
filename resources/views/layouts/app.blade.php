<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>@yield('title', 'Rental Mobil Cirebon Terpercaya & 24 Jam - RentGo Indonesia')</title>
    <meta name="description" content="@yield('meta_description', 'Sewa mobil Cirebon lepas kunci atau dengan pengemudi. Unit prima, inspeksi 21 titik, tarif transparan tanpa biaya tersembunyi. Layanan 24 jam siap antar stasiun.')">
    <meta name="keywords" content="rental mobil cirebon, sewa mobil cirebon, sewa mobil lepas kunci cirebon, rental mobil plus supir cirebon, rent car cirebon, rental mobil stasiun cirebon, sewa mobil avanza cirebon, sewa innova zenix cirebon, rentgo cirebon">
    <meta name="author" content="RentGo Indonesia">
    {{-- Search Engine Indexing Directives (Otomatis ditentukan oleh AutomaticSeoRobotsMiddleware) --}}
    <meta name="robots" content="@yield('robots', $seo_robots ?? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">
    <meta name="googlebot" content="@yield('robots', $seo_robots ?? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">
    
    {{-- Canonical URL --}}
    <link rel="canonical" href="@yield('canonical_url', url()->current())" />

    {{-- Geo Meta Tags for Local SEO Cirebon --}}
    <meta name="geo.region" content="ID-JB" />
    <meta name="geo.placename" content="Cirebon" />
    <meta name="geo.position" content="-6.7320;108.5523" />
    <meta name="ICBM" content="-6.7320, 108.5523" />

    {{-- Open Graph / Facebook / WhatsApp Preview --}}
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('title', 'Rental Mobil Cirebon Terpercaya & 24 Jam - RentGo Indonesia')">
    <meta property="og:description" content="@yield('meta_description', 'Sewa mobil Cirebon lepas kunci atau dengan pengemudi. Unit prima, inspeksi 21 titik, tarif transparan.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="RentGo Indonesia">
    <meta property="og:image" content="@yield('og_image', asset('assets/og_image.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="Rental Mobil Cirebon - RentGo Indonesia">

    {{-- Twitter Cards --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Rental Mobil Cirebon Terpercaya & 24 Jam - RentGo Indonesia')">
    <meta name="twitter:description" content="@yield('meta_description', 'Sewa mobil Cirebon unit prima, inspeksi 21 titik, tarif transparan.')">
    <meta name="twitter:image" content="@yield('og_image', asset('assets/og_image.jpg'))">

    {{-- Favicons --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/rentgo_light.png') }}">

    {{-- Preconnect & Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite('resources/css/app.css')

    {{-- Global AutoRental Schema.org JSON-LD for Google Rich Results & Local Knowledge Graph --}}
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@type": "AutoRental",
      "@id": "{{ url('/') }}/#autorental",
      "name": "RentGo Indonesia - Rental Mobil Cirebon",
      "alternateName": "RentGo Cirebon",
      "url": "{{ url('/') }}",
      "sameAs": [
        "https://www.instagram.com/rentgo.id/"
      ],
      "logo": "{{ asset('assets/rentgo_light.png') }}",
      "image": "{{ asset('assets/og_image.jpg') }}",
      "description": "Layanan rental dan sewa mobil terpercaya di Cirebon melayani lepas kunci atau dengan supir profesional. Unit bersih, lolos inspeksi 21 titik, tarif transparan, siap 24 jam.",
      "telephone": "+6285601700507",
      "email": "rentgo.idcirebon@gmail.com",
      "priceRange": "Rp 300.000 - Rp 2.500.000",
      "paymentAccepted": "Cash, Bank Transfer, QRIS",
      "currenciesAccepted": "IDR",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Kecamatan Talun & Kecamatan Weru",
        "addressLocality": "Cirebon",
        "addressRegion": "Jawa Barat",
        "postalCode": "45171",
        "addressCountry": "ID"
      },
      "geo": {
        "@type": "GeoCoordinates",
        "latitude": -6.7320,
        "longitude": 108.5523
      },
      "openingHoursSpecification": [
        {
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday"
          ],
          "opens": "00:00",
          "closes": "23:59"
        }
      ],
      "areaServed": [
        { "@type": "City", "name": "Kota Cirebon" },
        { "@type": "AdministrativeArea", "name": "Kabupaten Cirebon" },
        { "@type": "AdministrativeArea", "name": "Kuningan" },
        { "@type": "AdministrativeArea", "name": "Majalengka" },
        { "@type": "AdministrativeArea", "name": "Indramayu" }
      ],
      "makesOffer": [
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Sewa Mobil Lepas Kunci Cirebon",
            "description": "Rental mobil tanpa supir dengan persyaratan mudah dan verifikasi instan."
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Sewa Mobil Plus Supir Cirebon",
            "description": "Rental mobil dengan supir berpengalaman untuk wisata dan perjalanan dinas."
          }
        },
        {
          "@type": "Offer",
          "itemOffered": {
            "@type": "Service",
            "name": "Antar Jemput Stasiun Cirebon & Bandara BIJB",
            "description": "Layanan gratis antar jemput unit di Stasiun Kejaksan, Stasiun Prujakan, dan Bandara Kertajati."
          }
        }
      ]
    }
    </script>
    @yield('schema')
</head>
<body class="bg-white text-[#001733] font-sans antialiased selection:bg-[#006aed] selection:text-white">

@php
    $isHome = request()->routeIs('landing.home') || request()->is('/');
    $isPricing = request()->routeIs('landing.pricing') || request()->is('pricing*') || request()->is('car/*');
    $isAbout = request()->routeIs('landing.about') || request()->is('about*');
    $isContact = request()->routeIs('landing.contact') || request()->is('contact*');
    $isBlog = request()->routeIs('landing.blog.*') || request()->is('blog*');
@endphp

{{-- TOP NAVIGATION BAR (Aurora: Full-width, transparent on hero, nav links moved to right with generous spacing) --}}
<header id="navbar"
        data-is-home="{{ $isHome ? 'true' : 'false' }}"
        class="fixed top-0 left-0 w-full z-50 transition-all duration-300 {{ $isHome ? 'is-home-top' : 'is-scrolled' }}">
    <div class="w-full px-6 md:px-10 lg:px-14 xl:px-16">
        <div class="flex items-center justify-between h-[76px] md:h-[84px]">
            
            {{-- Left: Brand Mark (Official RentGo Logo - shifted right for comfortable breathing room) --}}
            <a href="{{ route('landing.home') }}" 
               class="inline-flex items-center group flex-shrink-0 py-1 pl-2 sm:pl-4 md:pl-6 lg:pl-8 xl:pl-10 transition-all duration-200" 
               aria-label="RentGo Indonesia - Rental Mobil Cirebon">
                <img src="{{ asset('assets/rentgo_light.png') }}"
                     alt="Rental Mobil Cirebon - RentGo Indonesia"
                     class="h-[52px] md:h-[62px] w-auto object-contain logo-light transition-transform duration-200 hover:scale-105" />
                <img src="{{ asset('assets/rentgo_dark.png') }}"
                     alt="Rental Mobil Cirebon - RentGo Indonesia"
                     class="h-[52px] md:h-[62px] w-auto object-contain logo-dark transition-transform duration-200 hover:scale-105" />
            </a>

            {{-- Right: Menu Links AND CTA Button grouped together on the far right with generous spacing --}}
            <div class="hidden lg:flex items-center ml-auto">
                <nav class="flex items-center gap-[32px] xl:gap-[38px] mr-[32px] xl:mr-[38px]" style="display: flex; align-items: center; gap: 32px; margin-right: 32px;">
                    <a href="{{ route('landing.home') }}"
                       class="nav-link whitespace-nowrap {{ $isHome ? 'active-link' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('landing.pricing') }}#armada"
                       id="navLinkArmada"
                       class="nav-link whitespace-nowrap {{ $isPricing ? 'active-link' : '' }}">
                        Armada
                    </a>
                    <a href="{{ route('landing.blog.index') }}"
                       class="nav-link whitespace-nowrap {{ $isBlog ? 'active-link' : '' }}">
                        Blog & Tips
                    </a>
                    <a href="{{ route('landing.about') }}"
                       class="nav-link whitespace-nowrap {{ $isAbout ? 'active-link' : '' }}">
                        Tentang Kami
                    </a>
                    <a href="{{ route('landing.contact') }}"
                       class="nav-link whitespace-nowrap {{ $isContact ? 'active-link' : '' }}">
                        Kontak
                    </a>
                </nav>

                <a href="https://www.instagram.com/rentgo.id/"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="hidden xl:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-current text-[13px] font-medium transition-all duration-200 hover:text-[#e1306c] hover:border-[#e1306c] mr-3 opacity-85 hover:opacity-100"
                   title="Instagram Resmi RentGo @rentgo.id">
                    <svg class="w-3.5 h-3.5 fill-[#e1306c]" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span>@rentgo.id</span>
                </a>

                <a href="{{ route('landing.pricing') }}" class="button-pill !py-[11px] !px-[18px] !min-h-[42px] flex-shrink-0">
                    <span class="button-pill__inner">
                        <span>Pesan Unit</span>
                        <span class="text-[12px] leading-none">→</span>
                    </span>
                </a>
            </div>

            {{-- Mobile Menu Toggle --}}
            <button type="button"
                    onclick="toggleMenu()"
                    class="lg:hidden inline-flex items-center justify-center w-11 h-11 rounded-[8px] border transition-colors"
                    aria-label="Buka navigasi"
                    aria-expanded="false"
                    id="mobileMenuBtn">
                <svg id="menuIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="closeIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Mobile Menu Panel --}}
        <div id="mobileMenu" class="hidden lg:hidden border-t border-[#e6e9f0] py-4 space-y-1 bg-white text-[#001733] shadow-lg rounded-b-[8px]">
            <a href="{{ route('landing.home') }}" class="block px-3 py-2.5 text-[14px] font-medium rounded-[8px] {{ $isHome ? 'bg-[#f3f4f8] text-[#006aed]' : 'text-[#001733] hover:bg-[#f3f4f8]' }}">Beranda</a>
            <a href="{{ route('landing.pricing') }}#armada" class="block px-3 py-2.5 text-[14px] font-medium rounded-[8px] {{ $isPricing ? 'bg-[#f3f4f8] text-[#006aed]' : 'text-[#001733] hover:bg-[#f3f4f8]' }}">Armada</a>
            <a href="{{ route('landing.blog.index') }}" class="block px-3 py-2.5 text-[14px] font-medium rounded-[8px] {{ $isBlog ? 'bg-[#f3f4f8] text-[#006aed]' : 'text-[#001733] hover:bg-[#f3f4f8]' }}">Blog & Tips</a>
            <a href="{{ route('landing.about') }}" class="block px-3 py-2.5 text-[14px] font-medium rounded-[8px] {{ $isAbout ? 'bg-[#f3f4f8] text-[#006aed]' : 'text-[#001733] hover:bg-[#f3f4f8]' }}">Tentang Kami</a>
            <a href="{{ route('landing.contact') }}" class="block px-3 py-2.5 text-[14px] font-medium rounded-[8px] {{ $isContact ? 'bg-[#f3f4f8] text-[#006aed]' : 'text-[#001733] hover:bg-[#f3f4f8]' }}">Kontak</a>
            <a href="https://www.instagram.com/rentgo.id/" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between px-3 py-2.5 text-[14px] font-medium rounded-[8px] text-[#001733] hover:bg-[#f3f4f8]">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 fill-[#e1306c]" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span>Instagram @rentgo.id</span>
                </span>
                <span class="text-[12px] font-semibold text-[#006aed]">Ikuti ↗</span>
            </a>
            <div class="pt-3 mt-2 border-t border-[#e6e9f0] flex flex-col gap-2">
                <a href="{{ route('landing.pricing') }}" class="button-pill w-full">
                    <span class="button-pill__inner justify-center">
                        <span>Pesan Unit</span>
                        <span class="text-[12px]">→</span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</header>

<main class="{{ $isHome ? '' : 'pt-[76px] md:pt-[84px]' }}">
    @yield('content')
</main>

@include('components.chatbot')

{{-- NAV FOOTER (design.md: Top border 1px Mist #e6e9f0, lives on Paper White #ffffff, 4 columns left-aligned, brand mark & copyright right-aligned) --}}
<footer class="bg-white border-t border-[#e6e9f0] mt-24">
    <div class="max-w-[1280px] mx-auto px-6 md:px-10 py-16 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 pb-16 border-b border-[#e6e9f0]">
            
            {{-- Left-aligned 4 Navigation Columns --}}
            <div class="lg:col-span-8 grid grid-cols-2 sm:grid-cols-4 gap-8">
                <div>
                    <div class="eyebrow-label mb-4">NAVIGASI</div>
                    <ul class="space-y-3">
                        <li><a href="{{ route('landing.home') }}" class="text-[14px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">Beranda</a></li>
                        <li><a href="{{ route('landing.pricing') }}#armada" class="text-[14px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">Armada</a></li>
                        <li><a href="{{ route('landing.blog.index') }}" class="text-[14px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">Blog & Tips</a></li>
                        <li><a href="{{ route('landing.about') }}" class="text-[14px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">Tentang Kami</a></li>
                        <li><a href="{{ route('landing.contact') }}" class="text-[14px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">Kontak</a></li>
                    </ul>
                </div>

                <div>
                    <div class="eyebrow-label mb-4">UNIT ARMADA</div>
                    <ul class="space-y-3">
                        <li><a href="{{ route('landing.pricing', ['search' => 'Avanza']) }}" class="text-[14px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">Toyota Avanza</a></li>
                        <li><a href="{{ route('landing.pricing', ['search' => 'Innova']) }}" class="text-[14px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">Kijang Innova Zenix</a></li>
                        <li><a href="{{ route('landing.pricing', ['search' => 'Brio']) }}" class="text-[14px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">Honda Brio</a></li>
                        <li><a href="{{ route('landing.pricing', ['search' => 'Fortuner']) }}" class="text-[14px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">Toyota Fortuner</a></li>
                        <li><a href="{{ route('landing.pricing', ['search' => 'Alphard']) }}" class="text-[14px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">Toyota Alphard</a></li>
                    </ul>
                </div>

                <div>
                    <div class="eyebrow-label mb-4">LAYANAN</div>
                    <ul class="space-y-3">
                        <li><a href="{{ route('landing.pricing') }}#armada" class="text-[14px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">Sewa Lepas Kunci</a></li>
                        <li><a href="{{ route('landing.pricing') }}#armada" class="text-[14px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">Sewa Plus Pengemudi</a></li>
                        <li><a href="{{ route('landing.home') }}#jangkauan" class="text-[14px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">Antar Stasiun Cirebon</a></li>
                        <li><a href="{{ route('landing.home') }}#jangkauan" class="text-[14px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">Antar Bandara BIJB</a></li>
                        <li><a href="{{ route('landing.about') }}#korporat" class="text-[14px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">Sewa Korporat B2B</a></li>
                    </ul>
                </div>

                <div>
                    <div class="eyebrow-label mb-4">OPERASIONAL</div>
                    <ul class="space-y-3 text-[14px] text-[#68748d]">
                        <li><a href="https://wa.me/6285601700507" target="_blank" class="font-medium text-[#001733] hover:text-[#006aed] transition-colors">+62 856-0170-0507</a></li>
                        <li><a href="mailto:rentgo.idcirebon@gmail.com" class="font-medium text-[#001733] hover:text-[#006aed] transition-colors">rentgo.idcirebon@gmail.com</a></li>
                        <li>
                            <a href="https://www.instagram.com/rentgo.id/" target="_blank" rel="noopener noreferrer" class="font-medium text-[#001733] hover:text-[#e1306c] transition-colors flex items-center gap-2 group">
                                <svg class="w-4 h-4 fill-current text-[#e1306c] group-hover:scale-110 transition-transform" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                                <span>@rentgo.id</span>
                            </a>
                        </li>
                        <li>Kec. Talun &amp; Kec. Weru</li>
                        <li>Cirebon, Jawa Barat 45171</li>
                    </ul>
                </div>
            </div>

            {{-- Right-aligned Brand Mark & Summary --}}
            <div class="lg:col-span-4 flex flex-col justify-between lg:items-end lg:text-right">
                <div>
                    <a href="{{ route('landing.home') }}" class="inline-flex items-center mb-3">
                        <img src="{{ asset('assets/rentgo_dark.png') }}"
                             alt="RentGo Indonesia"
                             class="h-[46px] w-auto object-contain" />
                    </a>
                    <p class="text-[14px] text-[#68748d] leading-[1.5] max-w-xs lg:ml-auto">
                        Layanan sewa mobil Cirebon dengan protokol inspeksi 21 titik, tarif transparan, dan kesiapan 24 jam.
                    </p>
                </div>

                {{-- Instagram Official Branding Card --}}
                <div class="mt-6 pt-5 border-t border-[#e6e9f0] w-full lg:max-w-xs">
                    <a href="https://www.instagram.com/rentgo.id/"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="flex items-center gap-3 p-3 rounded-[8px] bg-[#fafbfd] border border-[#e6e9f0] hover:border-[#e1306c]/40 hover:bg-white hover:shadow-sm transition-all group text-left">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] flex items-center justify-center text-white flex-shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-[11px] font-semibold text-[#68748d] uppercase tracking-wider">Instagram Resmi</div>
                            <div class="text-[14px] font-bold text-[#001733] group-hover:text-[#e1306c] transition-colors flex items-center gap-1.5">
                                <span>@rentgo.id</span>
                                <span class="w-3.5 h-3.5 rounded-full bg-[#006aed] text-white inline-flex items-center justify-center text-[8px] font-black" title="Official Account">✓</span>
                            </div>
                        </div>
                        <span class="text-[12px] font-semibold text-[#006aed] group-hover:text-[#e1306c] transition-colors">Lihat ↗</span>
                    </a>
                </div>

                <div class="mt-4">
                    <a href="https://wa.me/6285601700507" target="_blank" class="link-ghost">
                        <span>Konsultasi Cepat via WhatsApp</span>
                        <span class="text-[12px]">→</span>
                    </a>
                </div>
            </div>

        </div>

        {{-- Bottom Legal Row (Inter 14px weight 400 Slate Whisper) --}}
        <div class="pt-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 text-[14px] font-normal text-[#68748d]">
            <p>© {{ date('Y') }} RentGo Indonesia. Seluruh hak cipta dilindungi.</p>
            <div class="flex flex-wrap items-center gap-3 sm:gap-4">
                <a href="https://www.instagram.com/rentgo.id/" target="_blank" rel="noopener noreferrer" class="hover:text-[#e1306c] transition-colors flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 fill-current text-[#e1306c]" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span>@rentgo.id</span>
                </a>
                <span>•</span>
                <span>Wilayah Layanan: Cirebon, Kuningan, Majalengka, Indramayu.</span>
            </div>
        </div>
    </div>
</footer>

<script>
function toggleMenu() {
    const menu = document.getElementById('mobileMenu');
    const menuIcon = document.getElementById('menuIcon');
    const closeIcon = document.getElementById('closeIcon');
    const btn = document.getElementById('mobileMenuBtn');
    const isHidden = menu.classList.toggle('hidden');
    menuIcon.classList.toggle('hidden');
    closeIcon.classList.toggle('hidden');
    if (btn) btn.setAttribute('aria-expanded', !isHidden);
}

document.addEventListener('click', (e) => {
    const menu = document.getElementById('mobileMenu');
    const btn = document.getElementById('mobileMenuBtn');
    if (menu && !menu.contains(e.target) && btn && !btn.contains(e.target) && !menu.classList.contains('hidden')) {
        toggleMenu();
    }
});

// Navbar scroll state for transparent home hero
function updateNavbarScroll() {
    const navbar = document.getElementById('navbar');
    if (!navbar) return;
    const isHome = navbar.getAttribute('data-is-home') === 'true';
    if (!isHome) return;

    if (window.scrollY > 40) {
        navbar.classList.remove('is-home-top');
        navbar.classList.add('is-scrolled');
    } else {
        navbar.classList.add('is-home-top');
        navbar.classList.remove('is-scrolled');
    }
}
window.addEventListener('scroll', updateNavbarScroll, { passive: true });
document.addEventListener('DOMContentLoaded', updateNavbarScroll);


// Aurora Scroll-Driven Word-by-Word Text Reveal (design.md: Fog #d1d6e0 -> Horizon Navy #001733)
document.addEventListener('DOMContentLoaded', () => {
    const revealBlocks = document.querySelectorAll('.js-text-reveal');
    if (!revealBlocks.length) return;

    revealBlocks.forEach(block => {
        const text = block.textContent.trim().replace(/\s+/g, ' ');
        block.textContent = '';
        const words = text.split(' ');
        words.forEach((word, idx) => {
            const span = document.createElement('span');
            span.className = 'reveal-word';
            span.textContent = word + (idx < words.length - 1 ? ' ' : '');
            block.appendChild(span);
        });
    });

    function updateRevealOnScroll() {
        const vh = window.innerHeight;
        revealBlocks.forEach(block => {
            const rect = block.getBoundingClientRect();
            const words = block.querySelectorAll('.reveal-word');
            if (!words.length) return;

            // Start revealing when top enters 85% of viewport, complete by 35% of viewport
            const start = vh * 0.85;
            const end = vh * 0.30;
            const progress = Math.max(0, Math.min(1, (start - rect.top) / (start - end)));
            const activeCount = Math.floor(progress * words.length);

            words.forEach((w, idx) => {
                if (idx <= activeCount) {
                    w.classList.add('is-active');
                } else {
                    w.classList.remove('is-active');
                }
            });
        });
    }

    window.addEventListener('scroll', updateRevealOnScroll, { passive: true });
    window.addEventListener('resize', updateRevealOnScroll, { passive: true });
    updateRevealOnScroll();
});
</script>

</body>
</html>

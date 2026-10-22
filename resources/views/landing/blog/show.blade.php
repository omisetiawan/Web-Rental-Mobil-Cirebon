@extends('layouts.app')

@section('title', $post->seo_title_display)
@section('meta_description', $post->meta_description_display)
@section('og_type', 'article')
@section('og_image', $post->image_url)
@section('robots', $post->is_indexed ? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' : 'noindex, nofollow, noarchive, nosnippet')
@if(!empty($post->canonical_url))
@section('canonical_url', $post->canonical_url)
@endif

{{-- YOAST SEO SCHEMA.ORG JSON-LD (Article & BlogPosting) --}}
@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "BlogPosting",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ url()->current() }}"
  },
  "headline": @json($post->seo_title_display),
  "description": @json($post->meta_description_display),
  "image": [
    "{{ $post->image_url }}"
  ],
  "datePublished": "{{ $post->published_at ? $post->published_at->toIso8601String() : $post->created_at->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": @json($post->user ? $post->user->name : 'Tim Redaksi RentGo'),
    "url": "{{ url('/about') }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "RentGo Indonesia",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('assets/rentgo_light.png') }}"
    }
  },
  "keywords": @json($post->focus_keyword ?: 'rental mobil cirebon, wisata cirebon'),
  "articleSection": @json($post->category),
  "inLanguage": "id-ID"
}
</script>

{{-- BreadcrumbList Schema for Google SERP Rich Results --}}
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Beranda",
      "item": "{{ route('landing.home') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Blog",
      "item": "{{ route('landing.blog.index') }}"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": @json($post->category),
      "item": "{{ route('landing.blog.index', ['category' => $post->category]) }}"
    },
    {
      "@type": "ListItem",
      "position": 4,
      "name": @json($post->title),
      "item": "{{ url()->current() }}"
    }
  ]
}
</script>
@endsection

@section('content')
<div class="bg-white">

    <!-- ----------------------------------------------------
         BREADCRUMB BAR
    ---------------------------------------------------- -->
    <div class="bg-[#f8fafc] border-b border-slate-200 py-3.5">
        <div class="max-w-[1080px] mx-auto px-6 md:px-10">
            <nav class="flex items-center gap-2 text-xs sm:text-sm text-slate-500 overflow-x-auto no-scrollbar" aria-label="Breadcrumb">
                <a href="{{ route('landing.home') }}" class="hover:text-[#006aed] transition-colors whitespace-nowrap">Beranda</a>
                <span class="text-slate-300">/</span>
                <a href="{{ route('landing.blog.index') }}" class="hover:text-[#006aed] transition-colors whitespace-nowrap">Blog</a>
                <span class="text-slate-300">/</span>
                <a href="{{ route('landing.blog.index', ['category' => $post->category]) }}" class="hover:text-[#006aed] transition-colors whitespace-nowrap">
                    {{ $post->category }}
                </a>
                <span class="text-slate-300">/</span>
                <span class="text-slate-800 font-semibold truncate max-w-[200px] sm:max-w-[320px]">{{ $post->title }}</span>
            </nav>
        </div>
    </div>

    <!-- ----------------------------------------------------
         ARTICLE HEADER
    ---------------------------------------------------- -->
    <header class="pt-10 pb-8 sm:pt-14 sm:pb-10 max-w-[1080px] mx-auto px-6 md:px-10">
        <!-- Category & Reading time -->
        <div class="flex items-center gap-2.5 mb-4 flex-wrap">
            <a href="{{ route('landing.blog.index', ['category' => $post->category]) }}" 
               class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-50 text-[#006aed] hover:bg-blue-100 transition-colors">
                {{ $post->category }}
            </a>
            <span class="text-slate-300">•</span>
            <span class="text-xs text-slate-500 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $post->reading_time ?? 3 }} Menit Waktu Baca
            </span>
            <span class="text-slate-300">•</span>
            <span class="text-xs text-slate-500 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                {{ number_format($post->views_count) }} Pembaca
            </span>
        </div>

        <!-- Main H1 Headline -->
        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-[42px] font-extrabold text-[#001733] tracking-tight leading-[1.25] mb-6">
            {{ $post->title }}
        </h1>

        <!-- Author & Date -->
        <div class="flex items-center justify-between py-4 border-y border-slate-100 flex-wrap gap-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center font-bold text-[#001733] text-sm flex-shrink-0">
                    {{ strtoupper(substr($post->user ? $post->user->name : 'RentGo', 0, 1)) }}
                </div>
                <div>
                    <div class="text-sm font-bold text-[#001733]">
                        {{ $post->user ? $post->user->name : 'Tim Redaksi RentGo' }}
                    </div>
                    <div class="text-xs text-slate-500">
                        Dipublikasikan pada {{ $post->published_at ? $post->published_at->translatedFormat('d F Y') : $post->created_at->translatedFormat('d F Y') }}
                    </div>
                </div>
            </div>

            <!-- Social Share Buttons -->
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-400 mr-1 hidden sm:inline">Bagikan:</span>
                
                <!-- WhatsApp -->
                <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' - ' . url()->current()) }}" 
                   target="_blank" 
                   class="w-9 h-9 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition-all shadow-2xs" 
                   title="Bagikan ke WhatsApp">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                </a>

                <!-- Facebook -->
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                   target="_blank" 
                   class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-all shadow-2xs" 
                   title="Bagikan ke Facebook">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>

                <!-- X / Twitter -->
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" 
                   target="_blank" 
                   class="w-9 h-9 rounded-full bg-slate-100 text-slate-700 hover:bg-slate-900 hover:text-white flex items-center justify-center transition-all shadow-2xs" 
                   title="Bagikan ke X">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </a>

                <!-- Copy Link Button -->
                <button type="button" 
                        onclick="copyArticleLink()" 
                        id="copyLinkBtn"
                        class="w-9 h-9 rounded-full bg-slate-100 text-slate-700 hover:bg-[#006aed] hover:text-white flex items-center justify-center transition-all shadow-2xs" 
                        title="Salin Tautan">
                    <svg class="w-4 h-4 fill-none stroke-current" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- ----------------------------------------------------
         FEATURED IMAGE WITH ALT AND CAPTION
    ---------------------------------------------------- -->
    <div class="max-w-[1080px] mx-auto px-6 md:px-10 mb-10">
        <figure class="rounded-3xl overflow-hidden border border-slate-200 shadow-sm bg-slate-100">
            <img src="{{ $post->image_url }}" 
                 alt="{{ $post->image_alt ?: $post->title }}"
                 class="w-full h-auto max-h-[560px] object-cover"
                 onerror="this.src='{{ asset('assets/og_image.jpg') }}'">
            @if($post->image_caption)
                <figcaption class="p-3 text-center text-xs text-slate-500 bg-slate-50 border-t border-slate-100 flex items-center justify-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $post->image_caption }}</span>
                </figcaption>
            @endif
        </figure>
    </div>

    <!-- ----------------------------------------------------
         MAIN ARTICLE CONTENT & INSET CTA
    ---------------------------------------------------- -->
    <main class="max-w-[840px] mx-auto px-6 md:px-10 pb-16">
        
        <!-- Excerpt Lead Box -->
        @if($post->excerpt)
            <div class="p-6 mb-8 bg-blue-50/50 border-l-4 border-[#006aed] rounded-r-2xl text-slate-700 text-base sm:text-lg leading-relaxed font-medium">
                {{ $post->excerpt }}
            </div>
        @endif

        <!-- Article Rich Content Body (Fully Synchronized with Quill WYSIWYG) -->
        <article class="blog-article-content">
            {!! $post->content !!}
        </article>

        <!-- ----------------------------------------------------
             INLINE CONVERSION CTA BOX: Rental Mobil Cirebon
        ---------------------------------------------------- -->
        <div class="my-12 p-8 rounded-3xl bg-gradient-to-r from-[#001733] to-[#0a2540] text-white shadow-xl relative overflow-hidden">
            <div class="absolute -right-8 -top-8 w-48 h-48 rounded-full bg-[#006aed]/20 blur-2xl pointer-events-none"></div>
            
            <div class="relative z-10">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-xs font-semibold text-blue-200 mb-3">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                    </svg>
                    <span>Solusi Transportasi Cirebon</span>
                </span>
                <h3 class="text-xl sm:text-2xl font-extrabold mb-3 leading-snug">
                    Ingin Menjelajahi Destinasi Ini dengan Nyaman?
                </h3>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-6 max-w-xl">
                    Sewa mobil lepas kunci atau dengan supir profesional di RentGo Cirebon. Tarif transparan mulai <strong>Rp 300.000/hari</strong>, unit bersih terawat, gratis antar ke stasiun!
                </p>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('landing.pricing') }}" class="button-pill !bg-white !text-[#001733] hover:!bg-slate-100 !py-[11px] !px-[20px]">
                        <span class="button-pill__inner">
                            <span class="font-bold text-sm">Lihat Pilihan Mobil</span>
                            <span>→</span>
                        </span>
                    </a>
                    <a href="https://wa.me/6285601700507?text=Halo%20RentGo,%20saya%20membaca%20artikel%20{{ urlencode($post->title) }}%20dan%20ingin%20tanya%20sewa%20mobil" 
                       target="_blank" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#25D366] text-white font-bold text-sm hover:bg-[#20ba59] transition-colors shadow-sm">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Chat WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tags & Meta Footer -->
        <div class="pt-6 border-t border-slate-200 flex items-center justify-between flex-wrap gap-3">
            <div class="flex items-center gap-2 flex-wrap">
                <span class="text-xs font-semibold text-slate-500">Kata Kunci:</span>
                @if($post->focus_keyword)
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                        #{{ str_replace(' ', '', $post->focus_keyword) }}
                    </span>
                @endif
                <span class="px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                    #{{ str_replace(' ', '', $post->category) }}
                </span>
                <span class="px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                    #RentalMobilCirebon
                </span>
            </div>

            <!-- Share again -->
            <div class="flex items-center gap-2">
                <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' - ' . url()->current()) }}" 
                   target="_blank" 
                   class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3.5 py-1.5 rounded-full transition-colors">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>Bagikan ke WhatsApp</span>
                </a>
            </div>
        </div>

    </main>

    <!-- ----------------------------------------------------
         RELATED ARTICLES SECTION
    ---------------------------------------------------- -->
    @if(isset($relatedPosts) && $relatedPosts->count() > 0)
    <section class="bg-slate-50 py-16 border-t border-slate-200">
        <div class="max-w-[1240px] mx-auto px-6 md:px-10">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <span class="text-xs font-bold uppercase text-[#006aed] tracking-wider">Rekomendasi Terkait</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-[#001733] mt-1">
                        Artikel Lain yang Mungkin Anda Suka
                    </h2>
                </div>
                <a href="{{ route('landing.blog.index') }}" class="hidden sm:inline-flex items-center gap-1 text-sm font-bold text-[#006aed] hover:underline">
                    <span>Lihat Semua</span>
                    <span>→</span>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 sm:gap-6 md:gap-8">
                @foreach($relatedPosts as $rel)
                <article class="group bg-white rounded-2xl border border-slate-200 shadow-xs hover:shadow-lg transition-all duration-300 overflow-hidden flex flex-col">
                    <a href="{{ route('landing.blog.show', $rel->slug) }}" class="relative block overflow-hidden aspect-[16/10] bg-slate-100">
                        <img src="{{ $rel->image_url }}" 
                             alt="{{ $rel->image_alt ?: $rel->title }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             loading="lazy"
                             onerror="this.src='{{ asset('assets/og_image.jpg') }}'">
                        <div class="absolute top-2 left-2 sm:top-3 sm:left-3">
                            <span class="inline-flex items-center px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-semibold bg-white/95 text-slate-800 shadow-xs backdrop-blur-sm">
                                {{ $rel->category }}
                            </span>
                        </div>
                    </a>
                    <div class="p-3 sm:p-5 flex flex-col flex-grow justify-between">
                        <div>
                            <div class="flex items-center gap-1 sm:gap-2 text-[10px] sm:text-xs text-slate-500 mb-1.5 sm:mb-2">
                                <span>{{ $rel->published_at ? $rel->published_at->translatedFormat('d M Y') : '' }}</span>
                                <span>•</span>
                                <span>{{ $rel->reading_time ?? 3 }} mnt</span>
                            </div>
                            <h3 class="text-xs sm:text-base font-bold text-[#001733] group-hover:text-[#006aed] transition-colors line-clamp-2 leading-snug mb-1 sm:mb-2">
                                <a href="{{ route('landing.blog.show', $rel->slug) }}">
                                    {{ $rel->title }}
                                </a>
                            </h3>
                            <p class="hidden sm:block text-slate-600 text-xs sm:text-sm line-clamp-2 leading-relaxed">
                                {{ $rel->meta_description_display }}
                            </p>
                        </div>
                        <div class="pt-2 sm:pt-4 mt-2 sm:mt-3 border-t border-slate-100 flex items-center justify-between text-[10px] sm:text-xs text-slate-500">
                            <span class="truncate max-w-[70px] sm:max-w-none">Oleh {{ $rel->user ? $rel->user->name : 'RentGo' }}</span>
                            <a href="{{ route('landing.blog.show', $rel->slug) }}" class="font-bold text-[#006aed] group-hover:underline shrink-0">
                                Baca →
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</div>

<!-- Copy Link Feedback Script -->
<script>
function copyArticleLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        const btn = document.getElementById('copyLinkBtn');
        const originalHtml = btn.innerHTML;
        btn.innerHTML = '<svg class="w-4 h-4 text-emerald-600 fill-none stroke-current" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>';
        setTimeout(() => {
            btn.innerHTML = originalHtml;
        }, 2000);
    });
}
</script>

<style>
/* --------------------------------------------------------------------------
   BLOG ARTICLE CONTENT: 100% WYSIWYG & TYPOGRAPHY SYNCHRONIZATION
   Ensures headings, bold, italic, lists, quotes, tables, and alignments match
   the Quill Rich Text Editor output perfectly.
-------------------------------------------------------------------------- */
.blog-article-content {
    font-size: 17px;
    line-height: 1.85;
    color: #334155;
    word-break: break-word;
}

/* Headings */
.blog-article-content h1 {
    font-size: 2.25rem;
    font-weight: 800;
    color: #001733;
    margin-top: 2.75rem;
    margin-bottom: 1.25rem;
    line-height: 1.25;
    letter-spacing: -0.025em;
}
.blog-article-content h2 {
    font-size: 1.75rem;
    font-weight: 800;
    color: #001733;
    margin-top: 2.5rem;
    margin-bottom: 1rem;
    line-height: 1.3;
    letter-spacing: -0.02em;
    padding-bottom: 6px;
    border-bottom: 1px solid #f1f5f9;
}
.blog-article-content h3 {
    font-size: 1.35rem;
    font-weight: 700;
    color: #001733;
    margin-top: 2rem;
    margin-bottom: 0.75rem;
    line-height: 1.35;
    letter-spacing: -0.015em;
}
.blog-article-content h4 {
    font-size: 1.15rem;
    font-weight: 700;
    color: #001733;
    margin-top: 1.5rem;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

/* Paragraphs */
.blog-article-content p {
    margin-top: 0;
    margin-bottom: 1.5rem;
    line-height: 1.85;
    color: #334155;
}

/* Bold & Strong Typography (Synchronized with Quill) */
.blog-article-content strong,
.blog-article-content b {
    font-weight: 700 !important;
    color: #001733 !important;
}

/* Italic / Emphasis */
.blog-article-content em,
.blog-article-content i {
    font-style: italic !important;
    color: #1e293b;
}

/* Underline */
.blog-article-content u {
    text-decoration: underline !important;
    text-underline-offset: 3px !important;
    text-decoration-thickness: 1.5px !important;
}

/* Strikethrough */
.blog-article-content s,
.blog-article-content strike,
.blog-article-content del {
    text-decoration: line-through !important;
    color: #94a3b8 !important;
}

/* Unordered Lists (Bullets) */
.blog-article-content ul {
    list-style-type: disc !important;
    padding-left: 1.85rem !important;
    margin-top: 0.75rem !important;
    margin-bottom: 1.75rem !important;
    color: #334155 !important;
}
.blog-article-content ul ul {
    list-style-type: circle !important;
    margin-top: 0.5rem !important;
    margin-bottom: 0.5rem !important;
    padding-left: 1.5rem !important;
}

/* Ordered Lists (Numbered) */
.blog-article-content ol {
    list-style-type: decimal !important;
    padding-left: 1.85rem !important;
    margin-top: 0.75rem !important;
    margin-bottom: 1.75rem !important;
    color: #334155 !important;
}
.blog-article-content ol ol {
    list-style-type: lower-alpha !important;
    margin-top: 0.5rem !important;
    margin-bottom: 0.5rem !important;
    padding-left: 1.5rem !important;
}

/* List Items */
.blog-article-content li {
    margin-bottom: 0.65rem !important;
    line-height: 1.75 !important;
    color: #334155 !important;
    padding-left: 0.25rem;
}
.blog-article-content li::marker {
    color: #006aed;
    font-weight: 700;
}

/* Blockquotes (Editorial Pull-Quote) */
.blog-article-content blockquote {
    border-left: 4px solid #006aed;
    background: #f8fafc;
    padding: 1.25rem 1.75rem;
    margin: 2rem 0;
    border-radius: 0 16px 16px 0;
    color: #1e3a8a;
    font-style: italic;
    font-size: 1.05rem;
    line-height: 1.75;
}
.blog-article-content blockquote p {
    margin-bottom: 0.5rem;
    color: #1e3a8a;
}
.blog-article-content blockquote p:last-child {
    margin-bottom: 0;
}

/* Links */
.blog-article-content a {
    color: #006aed !important;
    text-decoration: underline !important;
    text-underline-offset: 3px !important;
    font-weight: 600 !important;
    transition: color 0.2s ease;
}
.blog-article-content a:hover {
    color: #004db3 !important;
    text-decoration-color: #004db3 !important;
}

/* Images inside Content */
.blog-article-content img {
    max-width: 100% !important;
    height: auto !important;
    border-radius: 18px !important;
    margin: 2rem auto !important;
    display: block !important;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.08) !important;
}
.blog-article-content figure {
    margin: 2rem 0 !important;
    text-align: center;
}
.blog-article-content figcaption {
    font-size: 0.85rem;
    color: #64748b;
    margin-top: 0.6rem;
    font-style: italic;
}

/* Tables */
.blog-article-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 2rem 0;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    font-size: 15px;
}
.blog-article-content th {
    background-color: #f8fafc;
    padding: 12px 16px;
    font-weight: 700;
    color: #001733;
    text-align: left;
    border-bottom: 2px solid #cbd5e1;
}
.blog-article-content td {
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
    color: #334155;
}
.blog-article-content tr:nth-child(even) {
    background-color: #fafbfc;
}

/* Inline Code & Code Blocks */
.blog-article-content code {
    background-color: #f1f5f9;
    color: #0f172a;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 0.88em;
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
}
.blog-article-content pre,
.blog-article-content pre.ql-syntax {
    background-color: #0f172a !important;
    color: #e2e8f0 !important;
    padding: 1.25rem 1.5rem !important;
    border-radius: 14px !important;
    overflow-x: auto !important;
    font-size: 0.9rem !important;
    line-height: 1.6 !important;
    margin: 1.75rem 0 !important;
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
}

/* Quill Text Alignments */
.blog-article-content .ql-align-center,
.blog-article-content p.ql-align-center,
.blog-article-content h2.ql-align-center,
.blog-article-content h3.ql-align-center {
    text-align: center !important;
}
.blog-article-content .ql-align-right,
.blog-article-content p.ql-align-right,
.blog-article-content h2.ql-align-right,
.blog-article-content h3.ql-align-right {
    text-align: right !important;
}
.blog-article-content .ql-align-justify,
.blog-article-content p.ql-align-justify {
    text-align: justify !important;
}

/* Quill Indentations */
.blog-article-content .ql-indent-1 {
    padding-left: 2rem !important;
}
.blog-article-content .ql-indent-2 {
    padding-left: 4rem !important;
}
.blog-article-content .ql-indent-3 {
    padding-left: 6rem !important;
}
.blog-article-content .ql-indent-4 {
    padding-left: 8rem !important;
}

/* Quill Responsive Video Embed */
.blog-article-content iframe.ql-video {
    width: 100% !important;
    aspect-ratio: 16 / 9 !important;
    border-radius: 16px !important;
    margin: 2rem 0 !important;
    border: none !important;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.08) !important;
}

/* Horizontal Rule / Divider */
.blog-article-content hr {
    border: none;
    border-top: 1px solid #e2e8f0;
    margin: 2.5rem 0;
}
</style>
@endsection

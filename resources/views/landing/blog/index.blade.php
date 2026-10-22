@extends('layouts.app')

@section('title', 'Blog, Tips Rental & Panduan Wisata Cirebon - RentGo Indonesia')
@section('meta_description', 'Kumpulan artikel wisata Cirebon, tips sewa mobil lepas kunci, panduan rute Kuningan & Majalengka, serta tips otomotif terpercaya dari RentGo Indonesia.')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "Blog",
  "@id": "{{ url('/blog') }}#blog",
  "name": "Blog & Panduan Wisata Rental Mobil Cirebon - RentGo Indonesia",
  "description": "Kumpulan artikel wisata Cirebon, tips sewa mobil lepas kunci, panduan rute Kuningan & Majalengka, serta tips otomotif terpercaya.",
  "url": "{{ url('/blog') }}",
  "inLanguage": "id-ID",
  "publisher": {
    "@type": "AutoRental",
    "name": "RentGo Indonesia",
    "url": "{{ url('/') }}",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('assets/rentgo_light.png') }}"
    }
  }
}
</script>
@endsection

@section('content')
<div class="editorial-page-bg">
    <div class="editorial-container">
        {{-- Search Engine & Accessibility Primary Heading --}}
        <h1 class="sr-only">Blog, Panduan Wisata & Tips Rental Mobil Cirebon - RentGo Indonesia</h1>

        <!-- ====================================================
             TOP HERO SECTION: FEATURED SPOTLIGHT + LATEST POSTS
             (Exact 1:1 Match with Reference Mockup Anatomy)
        ==================================================== -->
        @if($featuredPost && empty($search))
        <section class="hero-section">
            <div class="hero-grid">
                
                <!-- LEFT COLUMN: Big Featured Spotlight Card (~63% width) -->
                <div class="hero-featured-col">
                    <a href="{{ route('landing.blog.show', $featuredPost->slug) }}" class="hero-featured-card">
                        
                        <!-- High-Res Cover Image -->
                        <img src="{{ $featuredPost->image_url }}" 
                             alt="{{ $featuredPost->image_alt ?: $featuredPost->title }}" 
                             class="hero-cover-img"
                             loading="eager"
                             onerror="this.src='{{ asset('assets/og_image.jpg') }}'">
                        
                        <!-- Warm / Editorial Sunset Overlay matching essos reference mockup -->
                        <div class="hero-overlay"></div>

                        <!-- Card Content at Bottom -->
                        <div class="hero-content">
                            <!-- Category Pill with Terracotta Dot -->
                            <div class="hero-category-pill">
                                <span class="dot-terracotta"></span>
                                <span>{{ $featuredPost->category }}</span>
                            </div>

                            <!-- Big Bold White Title -->
                            <h2 class="hero-title">
                                {{ $featuredPost->title }}
                            </h2>

                            <!-- Date & Reading Time -->
                            <div class="hero-meta">
                                <span>{{ $featuredPost->published_at ? $featuredPost->published_at->format('M d') : 'Terbaru' }}</span>
                                <span class="meta-separator">•</span>
                                <span>{{ $featuredPost->reading_time ?? 4 }} min read</span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- RIGHT COLUMN: Latest Post Stack (~37% width) -->
                <div class="hero-latest-col">
                    <h3 class="latest-header-title">
                        Latest post
                    </h3>

                    <!-- 4 Compact Horizontal Post Items -->
                    <div class="latest-post-stack">
                        @forelse($latestPosts as $lPost)
                        <a href="{{ route('landing.blog.show', $lPost->slug) }}" class="latest-item">
                            <!-- Small Rounded Square Thumbnail (76x76) -->
                            <div class="latest-thumb-box">
                                <img src="{{ $lPost->image_url }}" 
                                     alt="{{ $lPost->title }}" 
                                     class="latest-thumb-img"
                                     loading="lazy"
                                     onerror="this.src='{{ asset('assets/og_image.jpg') }}'">
                            </div>

                            <!-- Text Details -->
                            <div class="latest-text-box">
                                <h4 class="latest-item-title">
                                    {{ $lPost->title }}
                                </h4>
                                <div class="latest-item-meta">
                                    <span>{{ $lPost->published_at ? $lPost->published_at->format('M d') : '' }}</span>
                                    <span class="meta-separator">•</span>
                                    <span>{{ $lPost->reading_time ?? 3 }} min read</span>
                                </div>
                            </div>
                        </a>
                        @empty
                        <p class="text-xs text-slate-400">Belum ada artikel terbaru lainnya.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </section>
        @endif

        <!-- ====================================================
             SUBTLE FILTER & SEARCH BAR
             (Positioned above the grid for clean browsing)
        ==================================================== -->
        <div class="filter-search-bar">
            <!-- Category Pills -->
            <div class="category-pills-row">
                <a href="{{ route('landing.blog.index', array_filter(['q' => $search])) }}" 
                   class="filter-pill {{ ($currentCategory === 'all' || empty($currentCategory)) ? 'active' : '' }}">
                    Semua ({{ $totalPublished }})
                </a>
                @foreach($categories as $key => $cat)
                    <a href="{{ route('landing.blog.index', array_filter(['category' => $key, 'q' => $search])) }}" 
                       class="filter-pill {{ $currentCategory === $key ? 'active' : '' }}">
                        {{ $key }}
                        <span class="filter-count">({{ $cat['count'] }})</span>
                    </a>
                @endforeach
            </div>

            <!-- Compact Search Input -->
            <form action="{{ route('landing.blog.index') }}" method="GET" class="search-form-box">
                <span class="search-icon">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input type="text" 
                       name="q" 
                       value="{{ $search }}" 
                       placeholder="Cari artikel..." 
                       class="search-input">
                @if($currentCategory && $currentCategory !== 'all')
                    <input type="hidden" name="category" value="{{ $currentCategory }}">
                @endif
            </form>
        </div>

        @if($search || ($currentCategory && $currentCategory !== 'all'))
            <!-- Active Filter Notification -->
            <div class="active-filter-alert">
                <div class="filter-labels">
                    <span class="text-slate-500 font-medium">Filter aktif:</span>
                    @if($search)
                        <span class="filter-chip">Pencarian: "{{ $search }}"</span>
                    @endif
                    @if($currentCategory && $currentCategory !== 'all')
                        <span class="filter-chip">Topik: {{ $currentCategory }}</span>
                    @endif
                </div>
                <a href="{{ route('landing.blog.index') }}" class="reset-filter-link">
                    Reset Filter ✕
                </a>
            </div>
        @endif

        <!-- ====================================================
             SECOND SECTION: "Founders corner" / 3-COLUMN CARD GRID
             (Exact 1:1 Match with Reference Mockup Anatomy)
        ==================================================== -->
        <section class="founders-section">
            <!-- Section Header with Circular Navigation Arrows -->
            <div class="founders-header">
                <h2 class="founders-title">
                    @if($search)
                        Hasil Pencarian untuk "{{ $search }}"
                    @elseif($currentCategory && $currentCategory !== 'all')
                        Artikel Topik: {{ $currentCategory }}
                    @else
                        Founders corner
                    @endif
                </h2>

                <!-- Circular Navigation Arrows (Reference Mockup Match) -->
                <div class="circular-arrows-box">
                    <button type="button" 
                            id="scrollLeftBtn"
                            onclick="history.back()"
                            class="circle-arrow-btn" 
                            title="Sebelumnya">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </button>
                    <button type="button" 
                            id="scrollRightBtn"
                            onclick="document.getElementById('articlesGridSection')?.scrollIntoView({behavior: 'smooth'})"
                            class="circle-arrow-btn" 
                            title="Selanjutnya">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Articles Grid (3 Columns on Desktop) -->
            @if($posts->count() > 0)
            <div class="articles-3col-grid" id="articlesGridSection">
                @foreach($posts as $post)
                <article class="article-card-plain">
                    <!-- Thumbnail Image Container (Aspect 16:10, Rounded 20px) -->
                    <a href="{{ route('landing.blog.show', $post->slug) }}" class="card-thumb-link">
                        <img src="{{ $post->image_url }}" 
                             alt="{{ $post->image_alt ?: $post->title }}"
                             class="card-thumb-img"
                             loading="lazy"
                             onerror="this.src='{{ asset('assets/og_image.jpg') }}'">
                    </a>

                    <!-- Category with Small Terracotta Dot Indicator -->
                    <div class="card-category-row">
                        <span class="dot-terracotta"></span>
                        <span class="card-category-text">{{ $post->category }}</span>
                    </div>

                    <!-- Post Title -->
                    <h3 class="card-title">
                        <a href="{{ route('landing.blog.show', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h3>

                    <!-- Excerpt (3 lines clamp) -->
                    <p class="card-excerpt">
                        {{ $post->meta_description_display }}
                    </p>

                    <!-- Meta: Date & Reading Time -->
                    <div class="card-meta">
                        <span>{{ $post->published_at ? $post->published_at->format('M d') : '' }}</span>
                        <span class="meta-separator">•</span>
                        <span>{{ $post->reading_time ?? 3 }} min read</span>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- ====================================================
                 PAGINATION: Exact Match with Reference
                 (Centered arrow, dark active circle, plain numbers, arrow)
            ==================================================== -->
            @if($posts->hasPages())
            <div class="editorial-pagination">
                {{-- Previous Page Arrow --}}
                @if ($posts->onFirstPage())
                    <span class="page-arrow disabled">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 19l-7-7 7-7"/></svg>
                    </span>
                @else
                    <a href="{{ $posts->previousPageUrl() }}" class="page-arrow" title="Halaman Sebelumnya">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                @endif

                {{-- Numbered Page Links --}}
                @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                    @if ($page == $posts->currentPage())
                        <span class="page-number-active">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="page-number-link">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Page Arrow --}}
                @if ($posts->hasMorePages())
                    <a href="{{ $posts->nextPageUrl() }}" class="page-arrow" title="Halaman Selanjutnya">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @else
                    <span class="page-arrow disabled">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                @endif
            </div>
            @endif

            @else
            <!-- Empty State -->
            <div class="empty-state-box">
                <div class="empty-icon">🔍</div>
                <h3 class="empty-title">Tidak Ada Artikel yang Cocok</h3>
                <p class="empty-desc">
                    Silakan coba kata kunci lain atau lihat seluruh artikel yang tersedia.
                </p>
                <a href="{{ route('landing.blog.index') }}" class="empty-btn">
                    Lihat Semua Artikel
                </a>
            </div>
            @endif
        </section>

    </div>
</div>

<style>
/* --------------------------------------------------------------------------
   EDITORIAL MAGAZINE BLOG STYLES (MATCHING ESSOS REFERENCE MOCKUP)
-------------------------------------------------------------------------- */
.editorial-page-bg {
    background-color: #faf8f5;
    min-height: 100vh;
    padding-top: 24px;
    padding-bottom: 48px;
}
@media (min-width: 640px) {
    .editorial-page-bg {
        padding-top: 36px;
        padding-bottom: 64px;
    }
}
.editorial-container {
    max-width: 1220px;
    margin-left: auto;
    margin-right: auto;
    padding-left: 14px;
    padding-right: 14px;
}
@media (min-width: 640px) {
    .editorial-container {
        padding-left: 32px;
        padding-right: 32px;
    }
}

/* Hero Section */
.hero-section {
    margin-bottom: 56px;
}
.hero-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 36px;
    align-items: stretch;
}
@media (min-width: 1024px) {
    .hero-grid {
        grid-template-columns: 7fr 4.2fr;
        gap: 40px;
    }
}

/* Left Featured Spotlight Card */
.hero-featured-col {
    display: flex;
    flex-direction: column;
}
.hero-featured-card {
    position: relative;
    border-radius: 28px;
    overflow: hidden;
    background-color: #0f172a;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    min-height: 400px;
    height: 100%;
    text-decoration: none;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
@media (min-width: 640px) {
    .hero-featured-card {
        min-height: 460px;
    }
}
@media (min-width: 1024px) {
    .hero-featured-card {
        min-height: 490px;
    }
}
.hero-featured-card:hover {
    box-shadow: 0 12px 30px -4px rgba(15, 23, 42, 0.16);
}
.hero-cover-img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
}
.hero-featured-card:hover .hero-cover-img {
    transform: scale(1.04);
}
.hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(15, 12, 10, 0.02) 0%, rgba(20, 15, 12, 0.35) 45%, rgba(18, 13, 10, 0.94) 100%);
    pointer-events: none;
}
.hero-content {
    position: relative;
    z-index: 10;
    padding: 24px;
    max-width: 640px;
}
@media (min-width: 640px) {
    .hero-content {
        padding: 36px 40px;
    }
}
.hero-category-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px;
    border-radius: 9999px;
    background-color: #ffffff;
    color: #0f172a;
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 14px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
}
.dot-terracotta {
    width: 8px;
    height: 8px;
    border-radius: 9999px;
    background-color: #c25e2e;
    flex-shrink: 0;
}
.hero-title {
    color: #ffffff;
    font-size: 22px;
    font-weight: 800;
    line-height: 1.25;
    letter-spacing: -0.025em;
    margin-bottom: 12px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.2s ease;
}
@media (min-width: 640px) {
    .hero-title {
        font-size: 28px;
    }
}
@media (min-width: 1024px) {
    .hero-title {
        font-size: 32px;
    }
}
.hero-featured-card:hover .hero-title {
    color: #fef08a;
}
.hero-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255, 255, 255, 0.8);
    font-size: 13px;
    font-weight: 400;
}
.meta-separator {
    opacity: 0.6;
}

/* Right Latest Post Column */
.hero-latest-col {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}
.latest-header-title {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin-top: 0;
    margin-bottom: 24px;
}
.latest-post-stack {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.latest-item {
    display: flex;
    align-items: center;
    gap: 16px;
    text-decoration: none;
    transition: transform 0.2s ease;
}
.latest-item:hover {
    transform: translateX(3px);
}
.latest-thumb-box {
    width: 76px;
    height: 76px;
    min-width: 76px;
    max-width: 76px;
    border-radius: 18px;
    overflow: hidden;
    background-color: #e2e8f0;
    flex-shrink: 0;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
}
.latest-thumb-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.latest-item:hover .latest-thumb-img {
    transform: scale(1.08);
}
.latest-text-box {
    flex: 1;
    min-width: 0;
}
.latest-item-title {
    font-size: 14.5px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1.35;
    margin-top: 0;
    margin-bottom: 6px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.2s ease;
}
.latest-item:hover .latest-item-title {
    color: #006aed;
}
.latest-item-meta {
    font-size: 12px;
    color: #94a3b8;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Filter & Search Bar */
.filter-search-bar {
    display: flex;
    flex-direction: column;
    gap: 16px;
    border-top: 1px solid rgba(226, 232, 240, 0.8);
    padding-top: 24px;
    margin-bottom: 32px;
}
@media (min-width: 768px) {
    .filter-search-bar {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
}
.category-pills-row {
    display: flex;
    align-items: center;
    gap: 8px;
    overflow-x: auto;
    padding-bottom: 4px;
    scrollbar-width: none;
}
.category-pills-row::-webkit-scrollbar {
    display: none;
}
.filter-pill {
    padding: 7px 16px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
    text-decoration: none;
    transition: all 0.2s ease;
    background-color: #ffffff;
    color: #475569;
    border: 1px solid #e2e8f0;
}
.filter-pill:hover {
    background-color: #f1f5f9;
    color: #0f172a;
}
.filter-pill.active {
    background-color: #0f172a;
    color: #ffffff;
    border-color: #0f172a;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.12);
}
.filter-count {
    opacity: 0.65;
    margin-left: 2px;
    font-size: 11px;
}
.search-form-box {
    position: relative;
    width: 100%;
}
@media (min-width: 768px) {
    .search-form-box {
        width: 250px;
        flex-shrink: 0;
    }
}
.search-icon {
    position: absolute;
    top: 50%;
    left: 14px;
    transform: translateY(-50%);
    color: #94a3b8;
    pointer-events: none;
    display: flex;
}
.search-input {
    width: 100%;
    padding: 8px 16px 8px 38px;
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 9999px;
    font-size: 12px;
    color: #0f172a;
    outline: none;
    transition: all 0.2s ease;
    box-sizing: border-box;
}
.search-input:focus {
    border-color: #0f172a;
    box-shadow: 0 0 0 2px rgba(15, 23, 42, 0.08);
}
.active-filter-alert {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 12px 18px;
    margin-bottom: 24px;
    font-size: 12px;
}
.filter-labels {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.filter-chip {
    padding: 3px 10px;
    border-radius: 9999px;
    background-color: #f1f5f9;
    font-weight: 600;
    color: #0f172a;
}
.reset-filter-link {
    color: #e11d48;
    font-weight: 600;
    text-decoration: none;
}
.reset-filter-link:hover {
    text-decoration: underline;
}

/* Founders Corner / 3-Column Grid */
.founders-section {
    margin-bottom: 40px;
}
@media (min-width: 640px) {
    .founders-section {
        margin-bottom: 56px;
    }
}
.founders-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
}
@media (min-width: 640px) {
    .founders-header {
        margin-bottom: 24px;
    }
}
.founders-title {
    font-size: 19px;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin: 0;
}
@media (min-width: 640px) {
    .founders-title {
        font-size: 24px;
    }
}
.circular-arrows-box {
    display: flex;
    align-items: center;
    gap: 10px;
}
.circle-arrow-btn {
    width: 36px;
    height: 36px;
    border-radius: 9999px;
    border: 1px solid #cbd5e1;
    background-color: #ffffff;
    color: #475569;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    transition: all 0.2s ease;
}
.circle-arrow-btn:hover {
    border-color: #0f172a;
    color: #0f172a;
    background-color: #f8fafc;
}
.articles-3col-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px 12px;
}
@media (min-width: 640px) {
    .articles-3col-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 28px 20px;
    }
}
@media (min-width: 1024px) {
    .articles-3col-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 32px;
    }
}
.article-card-plain {
    display: flex;
    flex-direction: column;
    text-align: left;
}
.card-thumb-link {
    display: block;
    width: 100%;
    aspect-ratio: 16 / 10;
    border-radius: 14px;
    overflow: hidden;
    background-color: #e2e8f0;
    margin-bottom: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
}
@media (min-width: 640px) {
    .card-thumb-link {
        border-radius: 20px;
        margin-bottom: 14px;
    }
}
.card-thumb-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
.article-card-plain:hover .card-thumb-img {
    transform: scale(1.05);
}
.card-category-row {
    display: flex;
    align-items: center;
    gap: 5px;
    margin-bottom: 5px;
}
@media (min-width: 640px) {
    .card-category-row {
        gap: 6px;
        margin-bottom: 8px;
    }
}
.card-category-text {
    font-size: 11px;
    font-weight: 600;
    color: #64748b;
}
@media (min-width: 640px) {
    .card-category-text {
        font-size: 12px;
    }
}
.card-title {
    font-size: 13.5px;
    font-weight: 700;
    line-height: 1.35;
    margin-top: 0;
    margin-bottom: 5px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
@media (min-width: 640px) {
    .card-title {
        font-size: 17px;
        margin-bottom: 8px;
    }
}
.card-title a {
    color: #0f172a;
    text-decoration: none;
    transition: color 0.2s ease;
}
.article-card-plain:hover .card-title a {
    color: #006aed;
}
.card-excerpt {
    font-size: 11px;
    line-height: 1.45;
    color: #64748b;
    margin-top: 0;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    flex-grow: 1;
}
@media (min-width: 640px) {
    .card-excerpt {
        font-size: 13px;
        line-height: 1.55;
        -webkit-line-clamp: 3;
        margin-bottom: 12px;
    }
}
.card-meta {
    font-size: 10.5px;
    color: #94a3b8;
    font-weight: 500;
}
@media (min-width: 640px) {
    .card-meta {
        font-size: 12px;
    }
}

/* Pagination */
.editorial-pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding-top: 36px;
    padding-bottom: 24px;
}
@media (min-width: 640px) {
    .editorial-pagination {
        gap: 12px;
        padding-top: 48px;
    }
}
.page-number-active {
    width: 32px;
    height: 32px;
    border-radius: 9999px;
    background-color: #0f172a;
    color: #ffffff;
    font-size: 12px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.page-number-link {
    width: 32px;
    height: 32px;
    border-radius: 9999px;
    color: #475569;
    font-size: 13px;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.2s ease;
}
.page-number-link:hover {
    background-color: #e2e8f0;
    color: #0f172a;
}
.page-arrow {
    width: 32px;
    height: 32px;
    border-radius: 9999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    text-decoration: none;
    transition: color 0.2s ease;
}
.page-arrow:hover {
    color: #0f172a;
}
.page-arrow.disabled {
    color: #cbd5e1;
    cursor: not-allowed;
}

/* Empty State */
.empty-state-box {
    text-align: center;
    padding: 64px 20px;
    background-color: #ffffff;
    border-radius: 24px;
    border: 1px dashed #cbd5e1;
}
.empty-icon {
    font-size: 32px;
    margin-bottom: 12px;
}
.empty-title {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 6px;
}
.empty-desc {
    font-size: 13px;
    color: #64748b;
    max-width: 360px;
    margin: 0 auto 20px;
}
.empty-btn {
    display: inline-flex;
    padding: 10px 22px;
    border-radius: 9999px;
    background-color: #0f172a;
    color: #ffffff;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: background-color 0.2s ease;
}
.empty-btn:hover {
    background-color: #334155;
}
</style>
@endsection

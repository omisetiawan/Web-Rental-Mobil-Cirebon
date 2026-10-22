@extends('layouts.app')

@section('title', 'Katalog Armada & Daftar Tarif Sewa Mobil Cirebon - RentGo Indonesia')
@section('meta_description', 'Katalog armada rental mobil Cirebon resmi & terlengkap. Tersedia Avanza, Innova Zenix, Brio, Fortuner, Alphard lepas kunci atau dengan supir. Inspeksi 21 titik, unit prima, tarif transparan.')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "ItemList",
  "name": "Katalog Sewa Mobil Cirebon - RentGo Indonesia",
  "description": "Daftar unit armada rental mobil Cirebon lepas kunci dan dengan supir beserta tarif sewa 24 jam.",
  "numberOfItems": {{ $cars->count() }},
  "itemListElement": [
    @foreach($cars as $index => $car)
    {
      "@type": "ListItem",
      "position": {{ $index + 1 }},
      "item": {
        "@type": "Product",
        "name": "Sewa {{ $car->brand }} {{ $car->model }} Cirebon",
        "url": "{{ route('landing.detail', $car->id) }}",
        "offers": {
          "@type": "Offer",
          "priceCurrency": "IDR",
          "price": "{{ $car->price_per_day }}",
          "availability": "{{ $car->status === 'available' ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}"
        }
      }
    }{{ $loop->last ? '' : ',' }}
    @endforeach
  ]
}
</script>
@endsection

@section('content')

@php
    $defaultImages = [
        'Avanza' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80',
        'Kijang Innova' => 'https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&w=800&q=80',
        'Innova' => 'https://images.unsplash.com/photo-1583121274602-3e2820c69888?auto=format&fit=crop&w=800&q=80',
        'Brio' => 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?auto=format&fit=crop&w=800&q=80',
        'Xenia' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80',
        'Fortuner' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=80',
        'Pajero Sport' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=80',
        'Alphard' => 'https://images.unsplash.com/photo-1508974239320-0a029497e820?auto=format&fit=crop&w=800&q=80',
        'Civic' => 'https://images.unsplash.com/photo-1618843479313-40f8afb4b4d8?auto=format&fit=crop&w=800&q=80',
        'HR-V' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=80',
        'Ertiga' => 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80',
    ];
@endphp

{{-- 1. EDITORIAL HEADER & METRICS BAR (#armada) --}}
<section id="armada" class="pt-16 pb-12 bg-white">
    <div class="aurora-container">
        <div class="max-w-[760px] mb-12">
            <div class="eyebrow-label mb-3">KATALOG ARMADA & DAFTAR TARIF</div>
            <h1 class="text-[44px] md:text-[64px] font-semibold text-[#001733] leading-[0.96] tracking-[-2.56px] mb-5">
                Armada siap jalan.<br>Tarif terbuka.
            </h1>
            <p class="text-[16px] md:text-[18px] text-[#68748d] leading-[1.5] max-w-[580px]">
                Seluruh unit yang tampil di katalog kami telah melalui protokol inspeksi 21 titik. Pilih kendaraan sesuai kapasitas dan jadwal perjalanan Anda di Cirebon.
            </p>
        </div>

        {{-- 4-Column Rectilinear Stats Bar (Hailstone surface, 1px Mist hairlines, 8px radius) --}}
        <div class="rounded-[8px] bg-[#f3f4f8] border border-[#e6e9f0] grid grid-cols-2 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-[#e6e9f0] mb-12">
            <div class="p-6">
                <div class="eyebrow-label !text-[11px] mb-1">TOTAL ARMADA</div>
                <div class="text-[28px] md:text-[36px] font-semibold text-[#001733] leading-[1.1] tracking-[-1.368px]">
                    {{ $stats['total_cars'] ?? 0 }} <span class="text-[14px] font-normal text-[#68748d]">Unit</span>
                </div>
            </div>
            <div class="p-6">
                <div class="eyebrow-label !text-[11px] mb-1">STATUS TERSEDIA</div>
                <div class="text-[28px] md:text-[36px] font-semibold text-[#006aed] leading-[1.1] tracking-[-1.368px]">
                    {{ $stats['available_cars'] ?? 0 }} <span class="text-[14px] font-normal text-[#68748d]">Siap Jalan</span>
                </div>
            </div>
            <div class="p-6">
                <div class="eyebrow-label !text-[11px] mb-1">RENTANG TAHUN</div>
                <div class="text-[28px] md:text-[36px] font-semibold text-[#001733] leading-[1.1] tracking-[-1.368px]">
                    {{ $stats['min_year'] ?? date('Y') }}–{{ $stats['max_year'] ?? date('Y') }}
                </div>
            </div>
            <div class="p-6">
                <div class="eyebrow-label !text-[11px] mb-1">TARIF HARIAN MULAI</div>
                <div class="text-[28px] md:text-[36px] font-semibold text-[#001733] leading-[1.1] tracking-[-1.368px]">
                    Rp {{ number_format(($stats['min_price'] ?? 0) / 1000, 0, ',', '.') }}rb<span class="text-[14px] font-normal text-[#68748d]">/hari</span>
                </div>
            </div>
        </div>



    </div>
</section>

{{-- 2. FILTER, SEARCH & SORT COCKPIT BAR --}}
<section class="pb-10 bg-white">
    <div class="aurora-container">
        <div class="card p-4 md:p-5 flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4">
            
            {{-- Search Form --}}
            <form id="searchForm" method="GET" action="{{ route('landing.pricing') }}#armada" class="flex-1 flex items-center gap-2">
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <div class="relative flex-1">
                    <svg class="w-4 h-4 text-[#68748d] absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input id="searchInput"
                           type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari unit mobil (merk, tipe, nomor plat)..."
                           class="input-aurora !pl-11 !pr-10">
                    @if(request('search'))
                        <button type="button"
                                onclick="clearSearch()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 w-6 h-6 rounded-[4px] flex items-center justify-center text-[#68748d] hover:text-[#001733] hover:bg-[#f3f4f8] transition-colors"
                                aria-label="Hapus pencarian">
                            ✕
                        </button>
                    @endif
                </div>
                <button type="submit" class="button-pill !py-3 !px-5 flex-shrink-0">
                    <span>Cari</span>
                </button>
            </form>

            {{-- Quick Model Pills & Sort Selector --}}
            <div class="flex flex-wrap items-center justify-between lg:justify-end gap-3">
                <div class="flex flex-wrap items-center gap-1.5">
                    <a href="{{ route('landing.pricing') }}#armada"
                       class="px-3 py-2 rounded-[8px] text-[13px] font-medium transition-colors {{ !request('search') ? 'bg-[#001733] text-white' : 'bg-white border border-[#e6e9f0] text-[#001733] hover:border-[#006aed]' }}">
                        Semua
                    </a>
                    @foreach($quickModels ?? [] as $quickModel)
                        <a href="{{ route('landing.pricing', ['search' => $quickModel, 'sort' => request('sort')]) }}#armada"
                           class="px-3 py-2 rounded-[8px] text-[13px] font-medium transition-colors {{ strtolower(request('search', '')) === strtolower($quickModel) ? 'bg-[#006aed] text-white' : 'bg-white border border-[#e6e9f0] text-[#001733] hover:border-[#006aed]' }}">
                            {{ $quickModel }}
                        </a>
                    @endforeach
                </div>

                <form method="GET" action="{{ route('landing.pricing') }}#armada" class="flex-shrink-0">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <label for="sortSelect" class="sr-only">Urutkan armada</label>
                    <select id="sortSelect"
                            name="sort"
                            onchange="this.form.submit()"
                            class="input-aurora !w-auto !py-2.5 !pr-9 cursor-pointer font-medium">
                        <option value="price_low" {{ request('sort', 'price_low') == 'price_low' ? 'selected' : '' }}>Urutkan: Tarif Terendah</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Urutkan: Tarif Tertinggi</option>
                        <option value="year_new" {{ request('sort') == 'year_new' ? 'selected' : '' }}>Urutkan: Tahun Terbaru</option>
                    </select>
                </form>
            </div>

        </div>
    </div>
</section>

{{-- 3. ARMADA GRID --}}
<section class="pb-24 bg-white">
    <div class="aurora-container">
        @if(isset($error))
            <div class="mb-8 p-4 rounded-[8px] bg-[#f3f4f8] border border-[#d1d6e0] text-[#001733] text-[14px]">
                {{ $error }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($cars as $car)
                @php
                    $imageUrl = null;
                    if ($car->image) {
                        if (filter_var($car->image, FILTER_VALIDATE_URL)) {
                            $imageUrl = $car->image;
                        } elseif (file_exists(public_path('storage/cars/' . $car->image))) {
                            $imageUrl = url('storage/cars/' . $car->image);
                        } elseif (file_exists(public_path('storage/' . $car->image))) {
                            $imageUrl = url('storage/' . $car->image);
                        }
                    }
                    if (!$imageUrl && $car->image_url) {
                        $imageUrl = $car->image_url;
                    }
                    if (!$imageUrl && $car->images) {
                        $galleryImages = is_string($car->images) ? json_decode($car->images, true) : $car->images;
                        if (is_array($galleryImages) && count($galleryImages) > 0) {
                            $firstImage = $galleryImages[0];
                            if (filter_var($firstImage, FILTER_VALIDATE_URL)) {
                                $imageUrl = $firstImage;
                            } elseif (file_exists(public_path('storage/cars/gallery/' . $firstImage))) {
                                $imageUrl = url('storage/cars/gallery/' . $firstImage);
                            } elseif (file_exists(public_path('storage/' . $firstImage))) {
                                $imageUrl = url('storage/' . $firstImage);
                            }
                        }
                    }
                    if (!$imageUrl) {
                        foreach ($defaultImages as $key => $url) {
                            if (stripos($car->model, $key) !== false || stripos($car->brand, $key) !== false) {
                                $imageUrl = $url;
                                break;
                            }
                        }
                    }
                    if (!$imageUrl) {
                        $imageUrl = 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80';
                    }

                    $yearParts = explode(' - ', $car->year ?? '');
                    $displayYear = count($yearParts) === 2 && $yearParts[0] !== $yearParts[1]
                        ? $yearParts[0] . '–' . $yearParts[1]
                        : ($yearParts[0] ?? date('Y'));
                @endphp

                <a href="{{ route('landing.detail', $car->id) }}" class="card flex flex-col justify-between group">
                    {{-- Image Container (8px top crop, no shadow) --}}
                    <div class="relative h-56 bg-[#e6e9f0] overflow-hidden">
                        <img src="{{ $imageUrl }}"
                             alt="Sewa Mobil {{ $car->brand }} {{ $car->model }} Cirebon - RentGo Indonesia"
                             loading="lazy"
                             decoding="async"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                        {{-- Left Brand Badge (4px radius) --}}
                        <div class="absolute top-3 left-3 bg-white/95 border border-[#e6e9f0] px-2.5 py-1 rounded-[4px] text-[11px] font-medium uppercase tracking-[0.08em] text-[#001733]">
                            {{ $car->brand }}
                        </div>

                        {{-- Right Status Badge (4px radius, Aurora palette only) --}}
                        @if($car->status == 'available')
                            <div class="absolute top-3 right-3 bg-white/95 border border-[#e6e9f0] px-2.5 py-1 rounded-[4px] text-[11px] font-medium text-[#001733] inline-flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#006aed]"></span>
                                <span>Siap Jalan</span>
                            </div>
                        @elseif($car->status == 'maintenance')
                            <div class="absolute top-3 right-3 bg-[#001733]/90 text-white px-2.5 py-1 rounded-[4px] text-[11px] font-medium">
                                Inspeksi Berkala
                            </div>
                        @else
                            <div class="absolute top-3 right-3 bg-[#f3f4f8]/95 border border-[#d1d6e0] text-[#464e5d] px-2.5 py-1 rounded-[4px] text-[11px] font-medium">
                                Sedang Disewa
                            </div>
                        @endif
                    </div>

                    {{-- Card Body (24px padding) --}}
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 text-[12px] text-[#68748d] mb-2">
                                <span>Tahun {{ $displayYear }}</span>
                                <span>•</span>
                                <span>{{ ucfirst($car->transmission ?? 'Automatic') }}</span>
                                <span>•</span>
                                <span>{{ $car->seat_capacity ?? 7 }} Kursi</span>
                            </div>

                            <h2 class="text-[20px] font-semibold text-[#001733] tracking-[-0.6px] group-hover:text-[#006aed] transition-colors mb-4">
                                {{ $car->brand }} {{ $car->model }}
                            </h2>

                            <div class="flex flex-wrap gap-1.5 mb-6">
                                <span class="px-2.5 py-1 rounded-[4px] bg-[#f0f7ff] border border-[#d6e8ff] text-[12px] font-medium text-[#006aed]">{{ $car->category }}</span>
                                @if($car->fuel_type)
                                    <span class="px-2.5 py-1 rounded-[4px] bg-white border border-[#e6e9f0] text-[12px] text-[#464e5d]">{{ strtoupper($car->fuel_type) }}</span>
                                @endif
                                <span class="px-2.5 py-1 rounded-[4px] bg-white border border-[#e6e9f0] text-[12px] text-[#464e5d]">Inspeksi 21 Titik</span>
                                <span class="px-2.5 py-1 rounded-[4px] bg-white border border-[#e6e9f0] text-[12px] text-[#464e5d]">Lepas Kunci / Supir</span>
                            </div>
                        </div>

                        {{-- Bottom Row: Daily Rate + Circular Arrow Button --}}
                        <div class="pt-4 border-t border-[#e6e9f0] flex items-center justify-between gap-4">
                            <div>
                                <div class="text-[12px] text-[#68748d]">Tarif sewa mulai</div>
                                <div class="text-[20px] font-semibold text-[#001733] tracking-[-0.6px]">
                                    Rp {{ number_format($car->price_per_day, 0, ',', '.') }}
                                    <span class="text-[12px] font-normal text-[#68748d]">/ 24 jam</span>
                                </div>
                            </div>

                            <span class="button-circle-arrow" aria-hidden="true">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full card p-12 text-center">
                    <div class="eyebrow-label mb-2">HASIL PENCARIAN</div>
                    <h3 class="text-[24px] font-semibold text-[#001733] tracking-[-0.72px] mb-2">Unit Tidak Ditemukan</h3>
                    <p class="text-[14px] text-[#68748d] mb-6 max-w-md mx-auto">
                        Tidak ada armada yang cocok dengan kata kunci "{{ request('search') }}". Silakan reset filter atau hubungi tim kami untuk cek ketersediaan unit terbaru.
                    </p>
                    <div class="flex justify-center gap-3">
                        <a href="{{ route('landing.pricing') }}#armada" class="button-pill">
                            <span>Tampilkan Seluruh Armada</span>
                        </a>
                        <a href="https://wa.me/6285601700507" target="_blank" class="button-ghost">
                            <span>Tanya via WhatsApp</span>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Rectilinear 8px Pagination --}}
        @if($cars->hasPages())
            <div class="mt-14 pt-8 border-t border-[#e6e9f0] flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-[13px] text-[#68748d]">
                    Menampilkan <span class="font-semibold text-[#001733]">{{ $cars->firstItem() }}–{{ $cars->lastItem() }}</span> dari <span class="font-semibold text-[#001733]">{{ $cars->total() }}</span> unit armada
                </p>

                <nav class="aurora-pagination" style="display: inline-flex; align-items: center; gap: 8px;" aria-label="Navigasi halaman armada">
                    {{-- Previous Page Link --}}
                    @if($cars->onFirstPage())
                        <span class="aurora-pagination__item is-disabled" style="display: inline-flex; align-items: center; justify-content: center; width: 44px; height: 44px; min-width: 44px; max-width: 44px; border-radius: 8px; border: 1px solid #e6e9f0; background-color: #f3f4f8; color: #94a3b8; cursor: not-allowed;" aria-disabled="true" aria-label="Halaman sebelumnya">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 18l-6-6 6-6"/>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $cars->previousPageUrl() }}#armada" class="aurora-pagination__item" style="display: inline-flex; align-items: center; justify-content: center; width: 44px; height: 44px; min-width: 44px; max-width: 44px; border-radius: 8px; border: 1px solid #e6e9f0; background-color: #ffffff; color: #001733; font-weight: 500;" aria-label="Halaman sebelumnya">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 18l-6-6 6-6"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach($cars->getUrlRange(1, $cars->lastPage()) as $page => $url)
                        @if($page == $cars->currentPage())
                            <span class="aurora-pagination__item is-active" style="display: inline-flex; align-items: center; justify-content: center; width: 44px; height: 44px; min-width: 44px; max-width: 44px; border-radius: 8px; background-color: #006aed; border: 1px solid #006aed; color: #ffffff; font-weight: 600; cursor: default;" aria-current="page">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}#armada" class="aurora-pagination__item" style="display: inline-flex; align-items: center; justify-content: center; width: 44px; height: 44px; min-width: 44px; max-width: 44px; border-radius: 8px; border: 1px solid #e6e9f0; background-color: #ffffff; color: #001733; font-weight: 500;">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if($cars->hasMorePages())
                        <a href="{{ $cars->nextPageUrl() }}#armada" class="aurora-pagination__item" style="display: inline-flex; align-items: center; justify-content: center; width: 44px; height: 44px; min-width: 44px; max-width: 44px; border-radius: 8px; border: 1px solid #e6e9f0; background-color: #ffffff; color: #001733; font-weight: 500;" aria-label="Halaman berikutnya">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </a>
                    @else
                        <span class="aurora-pagination__item is-disabled" style="display: inline-flex; align-items: center; justify-content: center; width: 44px; height: 44px; min-width: 44px; max-width: 44px; border-radius: 8px; border: 1px solid #e6e9f0; background-color: #f3f4f8; color: #94a3b8; cursor: not-allowed;" aria-disabled="true" aria-label="Halaman berikutnya">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </span>
                    @endif
                </nav>
            </div>
        @endif
    </div>
</section>


<script>
function clearSearch() {
    const input = document.getElementById('searchInput');
    if (input) {
        input.value = '';
        document.getElementById('searchForm').submit();
    }
}
</script>

@endsection

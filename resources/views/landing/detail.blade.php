@extends('layouts.app')

@section('title', 'Sewa ' . $car->brand . ' ' . $car->model . ' Cirebon - Tarif Rp ' . number_format($car->price_per_day, 0, ',', '.') . '/Hari | RentGo')
@section('meta_description', 'Rental mobil ' . $car->brand . ' ' . $car->model . ' ' . explode(' - ', $car->year)[0] . ' di Cirebon lepas kunci atau plus supir. Tarif Rp ' . number_format($car->price_per_day, 0, ',', '.') . '/24 jam, bersih, inspeksi 21 titik, antar stasiun gratis.')
@section('og_type', 'product')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "Product",
  "name": "Sewa {{ $car->brand }} {{ $car->model }} Cirebon",
  "description": "Layanan sewa {{ $car->brand }} {{ $car->model }} transmisi {{ $car->transmission ?? 'Automatic' }} kapasitas {{ $car->seat_capacity ?? 7 }} kursi di Cirebon. Lolos inspeksi 21 titik, opsi lepas kunci atau dengan supir.",
  "brand": {
    "@type": "Brand",
    "name": "{{ $car->brand }}"
  },
  "offers": {
    "@type": "Offer",
    "url": "{{ url()->current() }}",
    "priceCurrency": "IDR",
    "price": "{{ $car->price_per_day }}",
    "priceValidUntil": "{{ date('Y-12-31') }}",
    "itemCondition": "https://schema.org/UsedCondition",
    "availability": "{{ $car->status === 'available' ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
    "seller": {
      "@type": "AutoRental",
      "name": "RentGo Indonesia",
      "telephone": "+6285601700507",
      "url": "{{ url('/') }}"
    }
  }
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

    $imageUrl = null;
    $galleryList = [];

    if ($car->image) {
        if (file_exists(public_path('storage/cars/' . $car->image))) {
            $imageUrl = url('storage/cars/' . $car->image);
            $galleryList[] = $imageUrl;
        } elseif (file_exists(public_path('storage/' . $car->image))) {
            $imageUrl = url('storage/' . $car->image);
            $galleryList[] = $imageUrl;
        }
    }

    if ($car->images) {
        $galleryImages = is_string($car->images) ? json_decode($car->images, true) : $car->images;
        if (is_array($galleryImages)) {
            foreach ($galleryImages as $img) {
                if (file_exists(public_path('storage/cars/gallery/' . $img))) {
                    $u = url('storage/cars/gallery/' . $img);
                    if (!in_array($u, $galleryList)) $galleryList[] = $u;
                } elseif (file_exists(public_path('storage/' . $img))) {
                    $u = url('storage/' . $img);
                    if (!in_array($u, $galleryList)) $galleryList[] = $u;
                }
            }
        }
    }

    if (!$imageUrl && count($galleryList) > 0) {
        $imageUrl = $galleryList[0];
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

    $cleanYear = explode(' - ', $car->year)[0];
@endphp

{{-- 1. BREADCRUMB & PRIMARY SHOWCASE --}}
<section class="py-12 md:py-16 bg-white">
    <div class="aurora-container">
        
        {{-- Breadcrumb (Inter 14px weight 500) --}}
        <nav class="flex items-center gap-2 text-[14px] font-medium text-[#68748d] mb-8" aria-label="Breadcrumb">
            <a href="{{ route('landing.home') }}" class="hover:text-[#001733] transition-colors">Beranda</a>
            <span>/</span>
            <a href="{{ route('landing.pricing') }}#armada" class="hover:text-[#001733] transition-colors">Armada</a>
            <span>/</span>
            <span class="text-[#001733]">{{ $car->brand }} {{ $car->model }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
            
            {{-- Left Column (58%): Product Image Frame (8px radius, Hailstone surface, Mist border) --}}
            <div class="lg:col-span-7 space-y-4">
                <div class="card overflow-hidden">
                    <div class="relative aspect-[16/10] bg-[#e6e9f0] overflow-hidden">
                        <img id="mainCarImage"
                             src="{{ $imageUrl }}"
                             alt="{{ $car->brand }} {{ $car->model }}"
                             class="w-full h-full object-cover" />

                        <div class="absolute top-4 left-4 bg-white/95 border border-[#e6e9f0] px-3 py-1 rounded-[4px] text-[11px] font-medium uppercase tracking-[0.08em] text-[#001733]">
                            {{ $car->brand }}
                        </div>
                    </div>

                    @if(count($galleryList) > 1)
                        <div class="p-4 bg-[#f3f4f8] border-t border-[#e6e9f0] flex gap-3 overflow-x-auto">
                            @foreach($galleryList as $thumb)
                                <button type="button"
                                        onclick="document.getElementById('mainCarImage').src = '{{ $thumb }}'"
                                        class="w-20 h-14 rounded-[4px] overflow-hidden border border-[#d1d6e0] hover:border-[#006aed] flex-shrink-0 transition-colors">
                                    <img src="{{ $thumb }}" alt="Galeri {{ $car->model }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Inspection Highlights Bar --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="card p-4">
                        <div class="eyebrow-label !text-[10px] mb-1">STATUS INSPEKSI</div>
                        <div class="text-[14px] font-semibold text-[#001733]">Lolos 21 Titik</div>
                    </div>
                    <div class="card p-4">
                        <div class="eyebrow-label !text-[10px] mb-1">KONDISI KABIN</div>
                        <div class="text-[14px] font-semibold text-[#001733]">Sanitasi Bersih</div>
                    </div>
                    <div class="card p-4">
                        <div class="eyebrow-label !text-[10px] mb-1">PENGANTARAN</div>
                        <div class="text-[14px] font-semibold text-[#001733]">Gratis Kota Cirebon</div>
                    </div>
                </div>
            </div>

            {{-- Right Column (42%): Specification & Direct Booking Cockpit --}}
            <div class="lg:col-span-5 space-y-6">
                <div>
                    <div class="flex items-center gap-2.5 flex-wrap mb-3">
                        <span class="px-2.5 py-1 bg-[#f0f7ff] border border-[#d6e8ff] rounded-[4px] text-[11px] font-medium text-[#006aed]">{{ $car->category }}</span>
                        @if($car->status == 'available')
                            <span class="px-2.5 py-1 bg-[#f3f4f8] border border-[#e6e9f0] rounded-[4px] text-[11px] font-medium text-[#001733] inline-flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#006aed]"></span>
                                <span>UNIT SIAP JALAN</span>
                            </span>
                        @elseif($car->status == 'maintenance')
                            <span class="px-2.5 py-1 bg-[#001733] text-white rounded-[4px] text-[11px] font-medium uppercase tracking-[0.08em]">
                                SEDANG INSPEKSI BERKALA
                            </span>
                        @else
                            <span class="px-2.5 py-1 bg-[#f3f4f8] border border-[#d1d6e0] text-[#464e5d] rounded-[4px] text-[11px] font-medium uppercase tracking-[0.08em]">
                                SEDANG DISEWA
                            </span>
                        @endif
                        <span class="text-[12px] font-medium text-[#68748d]">Tahun {{ $cleanYear }}</span>
                    </div>

                    <h1 class="text-[36px] md:text-[44px] font-semibold text-[#001733] leading-[1.0] tracking-[-1.672px]">
                        {{ $car->brand }} {{ $car->model }}
                    </h1>
                </div>

                {{-- Price Panel (Hailstone card, 8px radius, no shadow) --}}
                <div class="card p-6">
                    <div class="eyebrow-label !text-[10px] mb-1">TARIF SEWA HARIAN (LEPAS KUNCI)</div>
                    <div class="text-[36px] font-semibold text-[#001733] leading-[1.1] tracking-[-1.368px]">
                        Rp {{ number_format($car->price_per_day, 0, ',', '.') }}
                        <span class="text-[14px] font-normal text-[#68748d] tracking-normal">/ 24 jam</span>
                    </div>
                    <p class="text-[13px] text-[#68748d] mt-2">
                        Opsi dengan pengemudi tersedia dengan tambahan Rp 150.000 / 12 jam area Cirebon.
                    </p>
                </div>

                {{-- Key Technical Specs Grid (2x2) --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="card-paper p-4">
                        <div class="text-[12px] text-[#68748d] mb-0.5">Kapasitas Penumpang</div>
                        <div class="text-[15px] font-semibold text-[#001733]">{{ $car->seat_capacity ?? '7' }} Kursi</div>
                    </div>
                    <div class="card-paper p-4">
                        <div class="text-[12px] text-[#68748d] mb-0.5">Transmisi</div>
                        <div class="text-[15px] font-semibold text-[#001733]">{{ ucfirst($car->transmission ?? 'Automatic') }}</div>
                    </div>
                    <div class="card-paper p-4">
                        <div class="text-[12px] text-[#68748d] mb-0.5">Bahan Bakar / Tipe</div>
                        <div class="text-[15px] font-semibold text-[#001733]">{{ strtoupper($car->fuel_type ?? 'Bensin') }}</div>
                    </div>
                    <div class="card-paper p-4">
                        <div class="text-[12px] text-[#68748d] mb-0.5">Warna Unit</div>
                        <div class="text-[15px] font-semibold text-[#001733]">{{ ucfirst($car->color ?? 'Hitam / Putih') }}</div>
                    </div>
                </div>

                {{-- Action CTA --}}
                @if($car->status == 'available')
                    <div class="space-y-3 pt-2">
                        <a href="https://wa.me/6285601700507?text={{ urlencode('Halo RentGo, saya ingin memesan unit ' . $car->brand . ' ' . $car->model . ' (Tahun ' . $cleanYear . ') dengan tarif Rp ' . number_format($car->price_per_day, 0, ',', '.') . '/hari. Mohon info ketersediaan untuk jadwal saya.') }}"
                           target="_blank"
                           class="button-pill w-full">
                            <span class="button-pill__inner justify-center">
                                <span>Pesan Unit Ini via WhatsApp</span>
                                <span class="text-[12px]">→</span>
                            </span>
                        </a>
                        <a href="{{ route('landing.pricing') }}#armada" class="button-ghost w-full">
                            <span>Bandingkan dengan Unit Lain</span>
                        </a>
                    </div>
                @else
                    <div class="card p-5 space-y-3">
                        <p class="text-[14px] text-[#001733] font-medium">
                            Unit ini sedang dalam jadwal sewa atau inspeksi berkala.
                        </p>
                        <p class="text-[13px] text-[#68748d]">
                            Hubungi admin kami untuk mengecek jam kepulangan unit ini atau rekomendasi unit setara yang siap jalan hari ini.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 pt-1">
                            <a href="https://wa.me/6285601700507?text={{ urlencode('Halo RentGo, kapan unit ' . $car->brand . ' ' . $car->model . ' kembali tersedia?') }}"
                               target="_blank"
                               class="button-pill flex-1">
                                <span>Tanya Jadwal Unit →</span>
                            </a>
                            <a href="{{ route('landing.pricing') }}#armada" class="button-ghost flex-1">
                                <span>Lihat Unit Lain</span>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

{{-- 1px Mist Section Divider --}}
<div class="aurora-container">
    <div class="section-divider"></div>
</div>

{{-- 2. SPESIFIKASI & KELENGKAPAN UNIT --}}
<section class="py-20 bg-white">
    <div class="aurora-container">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <div class="lg:col-span-7 space-y-6">
                <div>
                    <div class="eyebrow-label mb-2">KELENGKAPAN STANDAR</div>
                    <h2 class="text-[28px] md:text-[36px] font-semibold text-[#001733] leading-[1.1] tracking-[-1.368px]">
                        Kesiapan teknis {{ $car->brand }} {{ $car->model }}
                    </h2>
                </div>

                <p class="text-[16px] text-[#68748d] leading-[1.5]">
                    Unit {{ $car->brand }} {{ $car->model }} tahun {{ $cleanYear }} dirawat secara berkala sesuai standar pabrikan. Cocok untuk mobilitas bisnis di dalam Kota Cirebon, penjemputan tamu VIP di Stasiun Kejaksan, maupun perjalanan keluarga menuju Kuningan dan Majalengka.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="card p-5">
                        <div class="text-[14px] font-semibold text-[#001733] mb-1">AC Dingin & Kabin Bebas Asap</div>
                        <p class="text-[13px] text-[#68748d]">Sirkulasi AC diperiksa dan kabin disanitasi setiap selesai masa sewa.</p>
                    </div>
                    <div class="card p-5">
                        <div class="text-[14px] font-semibold text-[#001733] mb-1">Pengereman & Ban Prima</div>
                        <p class="text-[13px] text-[#68748d]">Ketebalan kampas rem, tekanan keempat ban, dan ban cadangan terverifikasi.</p>
                    </div>
                    <div class="card p-5">
                        <div class="text-[14px] font-semibold text-[#001733] mb-1">Audio Bluetooth & Port Daya</div>
                        <p class="text-[13px] text-[#68748d]">Konektivitas hiburan dan pengisian daya perangkat selama di perjalanan.</p>
                    </div>
                    <div class="card p-5">
                        <div class="text-[14px] font-semibold text-[#001733] mb-1">Perlengkapan Darurat Lengkap</div>
                        <p class="text-[13px] text-[#68748d]">Tersedia dongkrak, kunci roda, segitiga pengaman, dan kotak P3K.</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="card p-6 md:p-8 space-y-4">
                    <div class="eyebrow-label !text-[10px]">RINGKASAN ADMINISTRASI</div>
                    <h3 class="text-[20px] font-semibold text-[#001733] tracking-[-0.6px]">Informasi Unit & Layanan</h3>

                    <div class="divide-y divide-[#e6e9f0] text-[14px]">
                        <div class="py-3 flex justify-between">
                            <span class="text-[#68748d]">Nomor Polisi</span>
                            <span class="font-medium text-[#001733]">{{ $car->plate_number ?? 'Terdaftar Resmi' }}</span>
                        </div>
                        <div class="py-3 flex justify-between">
                            <span class="text-[#68748d]">Proteksi Asuransi</span>
                            <span class="font-medium text-[#001733]">Termasuk</span>
                        </div>
                        <div class="py-3 flex justify-between">
                            <span class="text-[#68748d]">Antar-Jemput Stasiun/Hotel</span>
                            <span class="font-medium text-[#006aed]">Gratis (Kota Cirebon)</span>
                        </div>
                        <div class="py-3 flex justify-between">
                            <span class="text-[#68748d]">Bantuan Teknis</span>
                            <span class="font-medium text-[#001733]">Siaga 24 Jam</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- 3. RELATED CARS --}}
@if(isset($relatedCars) && $relatedCars->count() > 0)
<div class="aurora-container">
    <div class="section-divider"></div>
</div>

<section class="py-20 bg-white">
    <div class="aurora-container">
        <div class="flex items-end justify-between mb-10">
            <div>
                <div class="eyebrow-label mb-2">REKOMENDASI SETARA</div>
                <h2 class="text-[28px] md:text-[36px] font-semibold text-[#001733] leading-[1.1] tracking-[-1.368px]">
                    Unit Serupa Lainnya
                </h2>
            </div>
            <a href="{{ route('landing.pricing') }}#armada" class="link-ghost">
                <span>Lihat Semua Armada →</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedCars as $rel)
                @php
                    $relImg = null;
                    if ($rel->image && file_exists(public_path('storage/cars/' . $rel->image))) {
                        $relImg = url('storage/cars/' . $rel->image);
                    } elseif ($rel->images) {
                        $rg = is_string($rel->images) ? json_decode($rel->images, true) : $rel->images;
                        if (is_array($rg) && count($rg) > 0 && file_exists(public_path('storage/cars/gallery/' . $rg[0]))) {
                            $relImg = url('storage/cars/gallery/' . $rg[0]);
                        }
                    }
                    if (!$relImg) {
                        foreach ($defaultImages as $key => $url) {
                            if (stripos($rel->model, $key) !== false || stripos($rel->brand, $key) !== false) {
                                $relImg = $url;
                                break;
                            }
                        }
                    }
                    if (!$relImg) {
                        $relImg = 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80';
                    }
                @endphp
                <a href="{{ route('landing.detail', $rel->id) }}" class="card flex flex-col justify-between group">
                    <div class="relative h-48 bg-[#e6e9f0] overflow-hidden">
                        <img src="{{ $relImg }}" alt="{{ $rel->brand }} {{ $rel->model }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-5 flex items-center justify-between gap-4">
                        <div>
                            <div class="text-[12px] text-[#68748d]">Tahun {{ explode(' - ', $rel->year)[0] }}</div>
                            <div class="text-[18px] font-semibold text-[#001733] group-hover:text-[#006aed] transition-colors">
                                {{ $rel->brand }} {{ $rel->model }}
                            </div>
                            <div class="text-[14px] font-medium text-[#001733] mt-1">
                                Rp {{ number_format($rel->price_per_day, 0, ',', '.') }} <span class="text-[12px] font-normal text-[#68748d]">/ 24 jam</span>
                            </div>
                        </div>
                        <span class="button-circle-arrow !w-10 !h-10" aria-hidden="true">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

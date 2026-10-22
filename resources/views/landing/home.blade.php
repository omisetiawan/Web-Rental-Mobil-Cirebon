@extends('layouts.app')

@section('title', 'Rental Mobil Cirebon Terpercaya & 24 Jam - RentGo Indonesia')
@section('meta_description', 'Sewa mobil Cirebon lepas kunci atau dengan pengemudi. Unit prima, inspeksi 21 titik, tarif transparan tanpa biaya tersembunyi. Layanan 24 jam siap antar stasiun.')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Apa saja dokumen persyaratan untuk sewa mobil lepas kunci di Cirebon?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Penyewa cukup menyiapkan e-KTP asli, SIM A aktif, serta satu dokumen pendukung (ID Card Karyawan, NPWP, atau bukti pemesanan tiket kereta/hotel bagi wisatawan luar kota). Verifikasi dilakukan secara cepat melalui WhatsApp."
      }
    },
    {
      "@type": "Question",
      "name": "Bagaimana perhitungan durasi sewa harian dan ketentuan overtime?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Durasi sewa harian dihitung penuh 24 jam sejak waktu serah terima unit. Apabila terdapat kelebihan waktu pemakaian (overtime), biaya dihitung proporsional sebesar 10% per jam dari tarif sewa harian."
      }
    },
    {
      "@type": "Question",
      "name": "Apakah tersedia layanan antar-jemput ke Stasiun Cirebon atau hotel?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Ya, pengantaran dan penjemputan unit ke Stasiun Kejaksan, Stasiun Prujakan, maupun hotel di wilayah Kota Cirebon tidak dikenakan biaya tambahan (gratis)."
      }
    },
    {
      "@type": "Question",
      "name": "Bagaimana prosedur pembayaran untuk mengamankan jadwal unit?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Pemesanan unit dapat dikunci dengan pembayaran uang muka (DP) melalui transfer bank resmi atau QRIS. Pelunasan dilakukan saat unit diserahterimakan kepada Anda."
      }
    }
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

{{-- 1. HERO SECTION (Aurora 100svh Full Screen & Full-Bleed 100% Scale) --}}
<section class="hero h-[100svh] min-h-[100svh] max-h-[100svh] w-full relative overflow-hidden bg-[#001733] flex flex-col justify-between">
    {{-- Full-bleed Highway Perspective Photography --}}
    <div class="hero__media absolute inset-0 w-full h-full z-0">
        <picture>
            <source srcset="{{ asset('images/hero_highway_car.webp') }}" type="image/webp">
            <img src="{{ asset('images/hero_highway_car.jpg') }}"
                 alt="Rental Mobil Cirebon Lepas Kunci & Supir - Armada RentGo Siap Jalan"
                 fetchpriority="high"
                 decoding="async"
                 width="1376"
                 height="768"
                 class="w-full h-full object-cover object-center" />
        </picture>
    </div>

    {{-- Horizon Navy Scrim Overlay --}}
    <div class="hero__scrim absolute inset-0 z-1 pointer-events-none"
         style="background: linear-gradient(180deg, rgba(0, 23, 51, 0.55) 0%, rgba(0, 23, 51, 0.15) 30%, rgba(0, 23, 51, 0.68) 100%);"></div>

    {{-- Hero Content Layer --}}
    <div class="hero__content relative z-10 flex flex-col justify-between h-full pt-[80px] w-full">
        {{-- Inner: Lower-Left Architectural Headline --}}
        <div class="hero__content-inner w-full px-6 md:px-10 lg:px-14 xl:px-16 flex-1 flex flex-col justify-end pb-8 md:pb-12">
            
            {{-- Architectural Display Headline with Search Engine Semantics --}}
            <div class="max-w-[820px]">
                <h1 class="hero__headline">
                    <span class="sr-only">Rental Mobil Cirebon Lepas Kunci & Plus Supir - </span>Armada prima.<br>Siap jalan.
                </h1>
                <p class="mt-4 text-[16px] md:text-[18px] text-white/90 font-normal leading-[1.5] max-w-[580px]">
                    Layanan rental dan sewa mobil Cirebon lepas kunci maupun dengan pengemudi untuk perjalanan bisnis dan keluarga. Unit prima lolos inspeksi 21 titik, tarif transparan, siap 24 jam.
                </p>
                <div class="mt-7 flex flex-wrap items-center gap-3.5">
                    <a href="{{ route('landing.pricing') }}#armada" class="button-pill !py-[13px] !px-[22px]">
                        <span class="button-pill__inner">
                            <span>Pilih Armada Sekarang</span>
                            <span class="text-[12px]">→</span>
                        </span>
                    </a>
                    <a href="#korporat" class="button-ghost !bg-white/95 !text-[#001733] !border-white !py-[13px] !px-[22px]">
                        <span>Layanan Korporat &amp; Bisnis</span>
                    </a>
                </div>
            </div>

        </div>

        {{-- Hero Bottom Stats Bar (Aurora: Transparent Frosted Strip with White Text) --}}
        <div class="hero__stats-bar w-full">
            <div class="hero__stats-grid w-full px-6 md:px-10 lg:px-14 xl:px-16">
                <div class="hero__stat-item">
                    <div class="hero__stat-label">TOTAL ARMADA</div>
                    <div class="hero__stat-value">{{ $stats['total_cars'] ?? 0 }} Unit Terawat</div>
                </div>
                <div class="hero__stat-item">
                    <div class="hero__stat-label">STATUS KESIAPAN</div>
                    <div class="hero__stat-value">{{ $stats['available_cars'] ?? 0 }} Unit Siap Jalan</div>
                </div>
                <div class="hero__stat-item">
                    <div class="hero__stat-label">STANDAR TEKNIS</div>
                    <div class="hero__stat-value">Inspeksi 21 Titik</div>
                </div>
                <div class="hero__stat-item">
                    <div class="hero__stat-label">LAYANAN OPERASIONAL</div>
                    <div class="hero__stat-value">Siaga 24 Jam Cirebon</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 2. EDITORIAL SCROLL-REVEAL SECTION (design.md: 40% Left Stacked Masonry Photos, 55% Right Scroll-Driven Text Reveal) --}}
<section class="py-24 bg-white">
    <div class="aurora-container">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            {{-- Left Column (40%): Stacked documentary car photography in loose masonry, 8px radius, 24px vertical gap --}}
            <div class="lg:col-span-5 space-y-6">
                <figure class="rounded-[8px] overflow-hidden border border-[#e6e9f0] bg-[#f3f4f8]">
                    <picture>
                        <source srcset="{{ asset('images/car_cockpit.webp') }}" type="image/webp">
                        <img src="{{ asset('images/car_cockpit.jpg') }}"
                             alt="Kondisi Kabin Bersih & Terawat Sewa Mobil Cirebon"
                             loading="lazy"
                             decoding="async"
                             width="1200"
                             height="896"
                             class="w-full aspect-[4/3] object-cover" />
                    </picture>
                </figure>
                <figure class="rounded-[8px] overflow-hidden border border-[#e6e9f0] bg-[#f3f4f8]">
                    <picture>
                        <source srcset="{{ asset('images/experience_card_car.webp') }}" type="image/webp">
                        <img src="{{ asset('images/experience_card_car.jpg') }}"
                             alt="Armada Eksekutif Siap Antar Jemput Stasiun Kejaksan Cirebon"
                             loading="lazy"
                             decoding="async"
                             width="1376"
                             height="768"
                             class="w-full aspect-[3/2] object-cover" />
                    </picture>
                </figure>
                <div class="flex items-center justify-between text-[12px] font-medium text-[#68748d] pt-1">
                    <span>Dokumentasi Kabin & Eksterior Unit</span>
                    <span>Cirebon, Jawa Barat</span>
                </div>
            </div>

            {{-- Right Column (55%): Scroll-driven editorial copy (Fog #d1d6e0 -> Horizon Navy #001733) --}}
            <div class="lg:col-span-7 lg:pl-6">
                <div class="eyebrow-label mb-3">ETOS OPERASIONAL RENTGO</div>

                <h2 class="text-[36px] md:text-[44px] font-semibold text-[#001733] leading-[1.0] tracking-[-1.672px] mb-10">
                    Kepastian kondisi kendaraan sebelum Anda memutar kunci kontak.
                </h2>

                <div class="space-y-10 max-w-[560px]">
                    <p class="js-text-reveal text-[22px] md:text-[26px] font-normal leading-[1.4] tracking-[-0.03em] text-[#001733]">
                        Perjalanan yang tenang dimulai dari kepastian bahwa unit yang Anda pesan tiba tepat waktu, bersih menyeluruh, dan prima secara mekanis di titik penjemputan.
                    </p>

                    <p class="js-text-reveal text-[22px] md:text-[26px] font-normal leading-[1.4] tracking-[-0.03em] text-[#001733]">
                        Di RentGo Cirebon, setiap armada melewati pemeriksaan 21 titik meliputi sistem pengereman, tekanan ban, kelistrikan, hingga sanitasi kabin sebelum diserahkan kepada Anda.
                    </p>

                    <p class="text-[16px] font-normal leading-[1.5] text-[#68748d]">
                        Baik untuk kebutuhan lepas kunci maupun dengan dukungan pengemudi profesional, seluruh rincian biaya disampaikan di awal secara transparan tanpa biaya tambahan tersembunyi.
                    </p>
                </div>

                <div class="mt-10 pt-8 border-t border-[#e6e9f0] flex flex-wrap items-center gap-6">
                    <a href="{{ route('landing.pricing') }}#armada" class="button-pill">
                        <span class="button-pill__inner">
                            <span>Lihat Seluruh Armada</span>
                            <span class="text-[12px]">→</span>
                        </span>
                    </a>
                    <a href="{{ route('landing.about') }}" class="link-ghost">
                        <span>Pelajari Standar Inspeksi 21 Titik</span>
                        <span class="text-[12px]">→</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- 1px Mist Section Divider --}}
<div class="aurora-container">
    <div class="section-divider"></div>
</div>

{{-- 3. KATALOG ARMADA SIAP PAKAI (#armada) --}}
<section id="armada" class="py-24 bg-white">
    <div class="aurora-container">
        
        {{-- Left-aligned Section Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="max-w-[640px]">
                <div class="eyebrow-label mb-3">ARMADA SIAP JALAN</div>
                <h2 class="text-[36px] md:text-[44px] font-semibold text-[#001733] leading-[1.0] tracking-[-1.672px]">
                    Pilihan unit untuk rute dalam kota maupun perjalanan antarkota.
                </h2>
            </div>
            <a href="{{ route('landing.pricing') }}#armada" class="link-ghost flex-shrink-0">
                <span>Buka Katalog Lengkap ({{ $stats['total_cars'] ?? 0 }} Unit)</span>
                <span class="text-[12px]">→</span>
            </a>
        </div>



        {{-- Featured Cars Grid (Hailstone #f3f4f8 cards, 8px radius, 1px Mist border, Circular Arrow Button) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($featuredCars as $car)
                @php
                    $carImg = null;
                    if ($car->image && file_exists(public_path('storage/cars/' . $car->image))) {
                        $carImg = url('storage/cars/' . $car->image);
                    } elseif ($car->image && file_exists(public_path('storage/' . $car->image))) {
                        $carImg = url('storage/' . $car->image);
                    } elseif ($car->images) {
                        $g = is_string($car->images) ? json_decode($car->images, true) : $car->images;
                        if (is_array($g) && count($g) > 0) {
                            if (file_exists(public_path('storage/cars/gallery/' . $g[0]))) {
                                $carImg = url('storage/cars/gallery/' . $g[0]);
                            } elseif (file_exists(public_path('storage/' . $g[0]))) {
                                $carImg = url('storage/' . $g[0]);
                            }
                        }
                    }

                    if (!$carImg) {
                        foreach ($defaultImages as $key => $url) {
                            if (stripos($car->model, $key) !== false || stripos($car->brand, $key) !== false) {
                                $carImg = $url;
                                break;
                            }
                        }
                    }
                    if (!$carImg) {
                        $carImg = 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?auto=format&fit=crop&w=800&q=80';
                    }

                    $cleanYear = explode(' - ', $car->year)[0];
                @endphp

                <a href="{{ route('landing.detail', $car->id) }}" class="card flex flex-col justify-between group">
                    {{-- Top Full-Bleed Image --}}
                    <div class="relative h-56 bg-[#e6e9f0] overflow-hidden">
                        <img src="{{ $carImg }}"
                             alt="Sewa Mobil {{ $car->brand }} {{ $car->model }} Cirebon - RentGo Indonesia"
                             loading="lazy"
                             decoding="async"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        
                        {{-- 4px Radius Badge (design.md: badges are 4px radius) --}}
                        <div class="absolute top-3 left-3 bg-white/95 border border-[#e6e9f0] px-2.5 py-1 rounded-[4px] text-[11px] font-medium uppercase tracking-[0.08em] text-[#001733]">
                            {{ $car->brand }}
                        </div>

                        <div class="absolute top-3 right-3 bg-white/95 border border-[#e6e9f0] px-2.5 py-1 rounded-[4px] text-[11px] font-medium text-[#001733] inline-flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#006aed]"></span>
                            <span>Siap Jalan</span>
                        </div>
                    </div>

                    {{-- Card Body (24px padding) --}}
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 text-[12px] text-[#68748d] mb-2">
                                <span>Tahun {{ $cleanYear }}</span>
                                <span>•</span>
                                <span>{{ ucfirst($car->transmission ?? 'Automatic') }}</span>
                                <span>•</span>
                                <span>{{ $car->seat_capacity ?? 7 }} Kursi</span>
                            </div>

                            <h3 class="text-[20px] font-semibold text-[#001733] tracking-[-0.6px] group-hover:text-[#006aed] transition-colors mb-4">
                                {{ $car->brand }} {{ $car->model }}
                            </h3>

                            <div class="flex flex-wrap gap-1.5 mb-6">
                                <span class="px-2.5 py-1 rounded-[4px] bg-[#f0f7ff] border border-[#d6e8ff] text-[12px] font-medium text-[#006aed]">{{ $car->category }}</span>
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
                    <p class="text-[16px] text-[#68748d] mb-4">Data armada sedang diperbarui.</p>
                    <a href="https://wa.me/6285601700507" target="_blank" class="button-pill">
                        <span>Tanyakan Ketersediaan via WhatsApp →</span>
                    </a>
                </div>
            @endforelse
        </div>

    </div>
</section>

{{-- 1px Mist Section Divider --}}
<div class="aurora-container">
    <div class="section-divider"></div>
</div>

{{-- 4. SOLUSI MOBILITAS KORPORAT & BISNIS (#korporat) --}}
<section id="korporat" class="py-24 bg-white scroll-mt-20 relative">
    <a id="tarif" class="sr-only"></a>
    <div class="aurora-container">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            {{-- Left Column (40%): Corporate & Business Mobility Solutions --}}
            <div class="lg:col-span-5">
                <div class="eyebrow-label mb-3">LAYANAN KORPORAT &amp; BISNIS</div>
                <h2 class="text-[36px] md:text-[44px] font-semibold text-[#001733] leading-[1.05] tracking-[-1.672px] mb-6">
                    Mobilitas eksekutif dan kemitraan terpercaya untuk instansi Anda.
                </h2>
                <p class="text-[16px] text-[#68748d] leading-[1.6] mb-8">
                    RentGo menghadirkan solusi transportasi terintegrasi bagi korporasi, instansi pemerintah, dan tamu VIP di wilayah Cirebon Raya. Didukung kepatuhan administrasi penuh, invoicing resmi, serta armada premium yang selalu terawat prima.
                </p>

                <div class="card p-6 space-y-5 border border-[#e6e9f0] bg-[#fafbfd]">
                    <div class="flex items-center justify-between border-b border-[#e6e9f0] pb-3">
                        <div class="eyebrow-label !text-[11px] text-[#006aed]">FASILITAS KEMITRAAN KORPORAT</div>
                        <span class="text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">Invoicing &amp; PPN Resmi</span>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-[#006aed]/10 text-[#006aed] flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-[14px] font-semibold text-[#001733]">Kepatuhan Administrasi &amp; Faktur Pajak</div>
                                <div class="text-[12px] text-[#68748d] leading-normal">Mendukung sistem penagihan tempo (TOP), kuitansi resmi bermeterai, dan kelengkapan SPJ kedinasan.</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-[#006aed]/10 text-[#006aed] flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-[14px] font-semibold text-[#001733]">Armada Eksekutif &amp; Terstandarisasi</div>
                                <div class="text-[12px] text-[#68748d] leading-normal">Pilihan MPV premium dan SUV eksekutif (Innova Zenix, Fortuner, Alphard) dalam kondisi higienis dan hening.</div>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-5 h-5 rounded-full bg-[#006aed]/10 text-[#006aed] flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-[14px] font-semibold text-[#001733]">Dedicated Coordinator &amp; Pengemudi VVIP</div>
                                <div class="text-[12px] text-[#68748d] leading-normal">Pengemudi berbusana rapi, paham etika bisnis, pengawalan tamu prioritas, serta jaminan unit pengganti cepat.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <a href="https://wa.me/6285601700507?text=Halo%20RentGo,%20saya%20ingin%20konsultasi%20mengenai%20layanan%20rental%20mobil%20korporat%20/%20kedinasan"
                       target="_blank"
                       class="inline-flex items-center gap-2 text-[14px] font-semibold text-[#006aed] hover:text-[#0052b8] transition-colors">
                        <span>Konsultasi Pengadaan Mobilitas Korporat</span>
                        <span class="text-[12px]">→</span>
                    </a>
                </div>
            </div>

            {{-- Right Column (60%): Skema Kemitraan & Paket Mobilitas Korporat --}}
            <div class="lg:col-span-7">
                <div class="card p-6 md:p-8 space-y-6 bg-white border border-[#e6e9f0]">
                    {{-- Header Card --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-4 border-b border-[#e6e9f0] gap-3">
                        <div>
                            <div class="eyebrow-label !text-[11px] text-[#006aed]">PILIHAN SKEMA KEMITRAAN</div>
                            <h3 class="text-[20px] md:text-[22px] font-semibold text-[#001733] tracking-[-0.6px] mt-0.5">
                                Paket Mobilitas Bisnis &amp; Kedinasan
                            </h3>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-[11px] font-medium text-emerald-800 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200 self-start sm:self-auto">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            Kontrak Fleksibel &amp; Siap SPJ
                        </span>
                    </div>

                    {{-- 3 Distinct Business Scheme Cards --}}
                    <div class="space-y-4">
                        {{-- Skema 1 --}}
                        <div class="p-4 md:p-5 rounded-[10px] border border-[#e6e9f0] bg-[#fafbfd] hover:border-[#006aed]/40 hover:bg-white transition-all duration-200">
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 h-7 rounded-[6px] bg-[#006aed]/10 text-[#006aed] flex items-center justify-center font-bold text-[12px]">01</span>
                                    <div>
                                        <h4 class="text-[15px] font-semibold text-[#001733]">Sewa Operasional Bulanan &amp; Tahunan</h4>
                                        <div class="text-[12px] text-[#68748d]">Manajemen fleet kantor cabang &amp; proyek perusahaan</div>
                                    </div>
                                </div>
                                <span class="text-[11px] font-semibold text-[#006aed] bg-[#f0f7ff] px-2.5 py-0.5 rounded border border-[#d6e8ff] flex-shrink-0">
                                    Fleet Kontrak
                                </span>
                            </div>
                            <p class="text-[13px] text-[#475569] leading-relaxed mb-3">
                                Efisiensi mobilitas tanpa beban investasi dan depresiasi aset. Meliputi perawatan berkala resmi, asuransi all-risk, dan penyediaan armada pengganti dalam 1x24 jam saat servis rutin.
                            </p>
                            <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-[#edf0f6] text-[11px] text-[#68748d]">
                                <span class="font-medium text-[#001733]">Rekomendasi Armada:</span>
                                <span class="bg-white px-2 py-0.5 rounded border border-[#e2e8f0]">Toyota Avanza</span>
                                <span class="bg-white px-2 py-0.5 rounded border border-[#e2e8f0]">Innova Zenix</span>
                                <span class="bg-white px-2 py-0.5 rounded border border-[#e2e8f0]">Mitsubishi Xpander</span>
                            </div>
                        </div>

                        {{-- Skema 2 --}}
                        <div class="p-4 md:p-5 rounded-[10px] border border-[#e6e9f0] bg-[#fafbfd] hover:border-[#006aed]/40 hover:bg-white transition-all duration-200">
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 h-7 rounded-[6px] bg-[#006aed]/10 text-[#006aed] flex items-center justify-center font-bold text-[12px]">02</span>
                                    <div>
                                        <h4 class="text-[15px] font-semibold text-[#001733]">Protokoler Kedinasan &amp; Tamu VVIP</h4>
                                        <div class="text-[12px] text-[#68748d]">Kunjungan kementerian, BUMN, audit regional, &amp; direksi</div>
                                    </div>
                                </div>
                                <span class="text-[11px] font-semibold text-purple-700 bg-purple-50 px-2.5 py-0.5 rounded border border-purple-200 flex-shrink-0">
                                    Executive VVIP
                                </span>
                            </div>
                            <p class="text-[13px] text-[#475569] leading-relaxed mb-3">
                                Layanan berstandar protokoler ketat dengan pengemudi profesional berbusana formal, berpengalaman rute Cirebon, Kuningan, Majalengka, Indramayu, hingga penjemputan Bandara Kertajati (BIJB) &amp; Stasiun Kejaksan.
                            </p>
                            <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-[#edf0f6] text-[11px] text-[#68748d]">
                                <span class="font-medium text-[#001733]">Rekomendasi Armada:</span>
                                <span class="bg-white px-2 py-0.5 rounded border border-[#e2e8f0]">Toyota Alphard</span>
                                <span class="bg-white px-2 py-0.5 rounded border border-[#e2e8f0]">Innova Zenix Hybrid</span>
                                <span class="bg-white px-2 py-0.5 rounded border border-[#e2e8f0]">Toyota Fortuner</span>
                            </div>
                        </div>

                        {{-- Skema 3 --}}
                        <div class="p-4 md:p-5 rounded-[10px] border border-[#e6e9f0] bg-[#fafbfd] hover:border-[#006aed]/40 hover:bg-white transition-all duration-200">
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-7 h-7 rounded-[6px] bg-[#006aed]/10 text-[#006aed] flex items-center justify-center font-bold text-[12px]">03</span>
                                    <div>
                                        <h4 class="text-[15px] font-semibold text-[#001733]">Transportasi Event &amp; Shuttle Delegasi</h4>
                                        <div class="text-[12px] text-[#68748d]">Rombongan seminar instansi, diklat dinas, &amp; kunjungan kerja</div>
                                    </div>
                                </div>
                                <span class="text-[11px] font-semibold text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded border border-amber-200 flex-shrink-0">
                                    Grup &amp; Shuttle
                                </span>
                            </div>
                            <p class="text-[13px] text-[#475569] leading-relaxed mb-3">
                                Solusi logistik penumpang untuk rombongan staf atau delegasi dengan koordinator lapangan terdedikasi, jadwal terkoordinasi presisi, dan armada mikrobus nyaman berkapasitas 14–19 kursi.
                            </p>
                            <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-[#edf0f6] text-[11px] text-[#68748d]">
                                <span class="font-medium text-[#001733]">Rekomendasi Armada:</span>
                                <span class="bg-white px-2 py-0.5 rounded border border-[#e2e8f0]">Toyota Hiace Premio</span>
                                <span class="bg-white px-2 py-0.5 rounded border border-[#e2e8f0]">Hiace Commuter</span>
                                <span class="bg-white px-2 py-0.5 rounded border border-[#e2e8f0]">Isuzu Elf Long</span>
                            </div>
                        </div>
                    </div>

                    {{-- 3-Step Governance Workflow Strip --}}
                    <div class="p-4 rounded-[8px] bg-[#f8fafc] border border-[#e2e8f0]">
                        <div class="text-[11px] font-bold uppercase tracking-[0.08em] text-[#68748d] mb-3">
                            ALUR KERJASAMA TERTIB ADMINISTRASI
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-left">
                            <div class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-[#006aed] text-white text-[10px] font-bold flex items-center justify-center flex-shrink-0 mt-0.5">1</span>
                                <div>
                                    <div class="text-[12px] font-semibold text-[#001733]">Konsultasi &amp; SPH</div>
                                    <div class="text-[11px] text-[#68748d] leading-snug">Penerbitan Surat Penawaran Harga resmi sesuai spesifikasi.</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-[#006aed] text-white text-[10px] font-bold flex items-center justify-center flex-shrink-0 mt-0.5">2</span>
                                <div>
                                    <div class="text-[12px] font-semibold text-[#001733]">PO / Kontrak MoU</div>
                                    <div class="text-[11px] text-[#68748d] leading-snug">Konfirmasi pemesanan, penjadwalan unit, &amp; data driver.</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-2.5">
                                <span class="w-5 h-5 rounded-full bg-[#006aed] text-white text-[10px] font-bold flex items-center justify-center flex-shrink-0 mt-0.5">3</span>
                                <div>
                                    <div class="text-[12px] font-semibold text-[#001733]">Layanan &amp; Invoicing</div>
                                    <div class="text-[11px] text-[#68748d] leading-snug">Pelaksanaan tugas, penagihan Invoice, kuitansi, &amp; e-Faktur.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bottom Action Box --}}
                    <div class="pt-2 flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-t border-[#e6e9f0]">
                        <div>
                            <div class="text-[13px] font-semibold text-[#001733]">Butuh Surat Penawaran Harga (SPH) Resmi?</div>
                            <div class="text-[12px] text-[#68748d]">Tim Corporate Account Manager siap melayani kebutuhan instansi Anda.</div>
                        </div>
                        <a href="https://wa.me/6285601700507?text=Halo%20RentGo,%20kami%20dari%20instansi%20/%20perusahaan%20ingin%20meminta%20Surat%20Penawaran%20Resmi%20(SPH)%20untuk%20kebutuhan%20sewa%20mobil%20korporat"
                           target="_blank"
                           class="button-pill flex-shrink-0">
                            <span class="button-pill__inner !px-5 !py-2.5">
                                <span>Minta Penawaran SPH</span>
                                <span class="text-[12px]">→</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- 1px Mist Section Divider --}}
<div class="aurora-container">
    <div class="section-divider"></div>
</div>

{{-- 5. STANDAR KEANDALAN & PROTOKOL LAYANAN (4 Rectilinear Pillars) --}}
<section class="py-24 bg-white">
    <div class="aurora-container">
        <div class="max-w-[640px] mb-14">
            <div class="eyebrow-label mb-3">STANDAR KUALITAS</div>
            <h2 class="text-[36px] md:text-[44px] font-semibold text-[#001733] leading-[1.0] tracking-[-1.672px]">
                Dirancang untuk ketepatan waktu dan rasa aman di jalan.
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="card p-7 flex flex-col justify-between">
                <div>
                    <div class="text-[12px] font-medium uppercase tracking-[0.12em] text-[#006aed] mb-4">01 / MEKANIKAL</div>
                    <h3 class="text-[20px] font-semibold text-[#001733] tracking-[-0.6px] mb-3">Inspeksi 21 Titik</h3>
                    <p class="text-[14px] text-[#68748d] leading-[1.5]">
                        Pemeriksaan menyeluruh pada sistem pengereman, oli mesin, air radiator, tekanan ban, dan fungsi kelistrikan sebelum serah terima.
                    </p>
                </div>
                <div class="pt-6 mt-6 border-t border-[#e6e9f0] text-[12px] font-medium text-[#001733]">
                    Standar wajib seluruh unit
                </div>
            </div>

            <div class="card p-7 flex flex-col justify-between">
                <div>
                    <div class="text-[12px] font-medium uppercase tracking-[0.12em] text-[#006aed] mb-4">02 / TRANSPARANSI</div>
                    <h3 class="text-[20px] font-semibold text-[#001733] tracking-[-0.6px] mb-3">Tarif Final di Awal</h3>
                    <p class="text-[14px] text-[#68748d] leading-[1.5]">
                        Harga yang tertera dan disepakati saat reservasi adalah nominal akhir. Tidak ada biaya administrasi mendadak saat pengembalian.
                    </p>
                </div>
                <div class="pt-6 mt-6 border-t border-[#e6e9f0] text-[12px] font-medium text-[#001733]">
                    Rincian jelas & tertulis
                </div>
            </div>

            <div class="card p-7 flex flex-col justify-between">
                <div>
                    <div class="text-[12px] font-medium uppercase tracking-[0.12em] text-[#006aed] mb-4">03 / MOBILITAS</div>
                    <h3 class="text-[20px] font-semibold text-[#001733] tracking-[-0.6px] mb-3">Antar Jemput Presisi</h3>
                    <p class="text-[14px] text-[#68748d] leading-[1.5]">
                        Unit disiapkan 15 menit sebelum jadwal kedatangan kereta Anda di Stasiun Kejaksan, Stasiun Prujakan, atau lobi hotel.
                    </p>
                </div>
                <div class="pt-6 mt-6 border-t border-[#e6e9f0] text-[12px] font-medium text-[#001733]">
                    Gratis area Kota Cirebon
                </div>
            </div>

            <div class="card p-7 flex flex-col justify-between">
                <div>
                    <div class="text-[12px] font-medium uppercase tracking-[0.12em] text-[#006aed] mb-4">04 / PROTEKSI</div>
                    <h3 class="text-[20px] font-semibold text-[#001733] tracking-[-0.6px] mb-3">Dukungan Darurat 24/7</h3>
                    <p class="text-[14px] text-[#68748d] leading-[1.5]">
                        Tim teknis dan unit pengganti selalu siaga apabila terjadi kendala teknis di sepanjang rute perjalanan Anda.
                    </p>
                </div>
                <div class="pt-6 mt-6 border-t border-[#e6e9f0] text-[12px] font-medium text-[#001733]">
                    Siaga lintas Ciayumajakuning
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 1px Mist Section Divider --}}
<div class="aurora-container">
    <div class="section-divider"></div>
</div>

{{-- 6. WILAYAH JANGKAUAN & TITIK SERAH TERIMA (#jangkauan) --}}
<section id="jangkauan" class="py-24 bg-white">
    <div class="aurora-container">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <div class="lg:col-span-5">
                <div class="eyebrow-label mb-3">KORIDOR LAYANAN</div>
                <h2 class="text-[36px] md:text-[44px] font-semibold text-[#001733] leading-[1.0] tracking-[-1.672px] mb-6">
                    Melayani simpul transportasi Cirebon & Ciayumajakuning.
                </h2>
                <p class="text-[16px] text-[#68748d] leading-[1.5] mb-8">
                    Kami mengintegrasikan layanan pengantaran unit langsung ke titik kedatangan Anda agar waktu perjalanan tidak terbuang.
                </p>

                <div class="space-y-3 text-[14px] text-[#001733]">
                    <div class="flex items-center gap-3 py-2 border-b border-[#e6e9f0]">
                        <span class="w-2 h-2 rounded-[2px] bg-[#006aed]"></span>
                        <span class="font-medium">Kota & Kabupaten Cirebon</span>
                        <span class="ml-auto text-[12px] text-[#68748d]">Antar Gratis</span>
                    </div>
                    <div class="flex items-center gap-3 py-2 border-b border-[#e6e9f0]">
                        <span class="w-2 h-2 rounded-[2px] bg-[#006aed]"></span>
                        <span class="font-medium">Kuningan & Kaki Gunung Ciremai</span>
                        <span class="ml-auto text-[12px] text-[#68748d]">Rute Wisata & Dinas</span>
                    </div>
                    <div class="flex items-center gap-3 py-2 border-b border-[#e6e9f0]">
                        <span class="w-2 h-2 rounded-[2px] bg-[#006aed]"></span>
                        <span class="font-medium">Majalengka & Bandara Kertajati (BIJB)</span>
                        <span class="ml-auto text-[12px] text-[#68748d]">Transfer Bandara</span>
                    </div>
                    <div class="flex items-center gap-3 py-2 border-b border-[#e6e9f0]">
                        <span class="w-2 h-2 rounded-[2px] bg-[#006aed]"></span>
                        <span class="font-medium">Indramayu & Kawasan Pantura</span>
                        <span class="ml-auto text-[12px] text-[#68748d]">Kunjungan Industri</span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="card p-6">
                    <div class="eyebrow-label !text-[10px] mb-2">TITIK JEMPUT 01</div>
                    <h3 class="text-[18px] font-semibold text-[#001733] mb-2">Stasiun Kejaksan & Prujakan</h3>
                    <p class="text-[14px] text-[#68748d] leading-[1.5]">
                        Serah terima praktis di area parkir stasiun begitu kereta Anda tiba di Cirebon tanpa perlu berpindah moda transportasi.
                    </p>
                </div>

                <div class="card p-6">
                    <div class="eyebrow-label !text-[10px] mb-2">TITIK JEMPUT 02</div>
                    <h3 class="text-[18px] font-semibold text-[#001733] mb-2">Bandara Internasional Kertajati</h3>
                    <p class="text-[14px] text-[#68748d] leading-[1.5]">
                        Layanan penjemputan terjadwal di terminal kedatangan BIJB Majalengka menuju pusat Kota Cirebon atau Kuningan.
                    </p>
                </div>

                <div class="card p-6">
                    <div class="eyebrow-label !text-[10px] mb-2">TITIK JEMPUT 03</div>
                    <h3 class="text-[18px] font-semibold text-[#001733] mb-2">Hotel & Kediaman Pribadi</h3>
                    <p class="text-[14px] text-[#68748d] leading-[1.5]">
                        Pengantaran unit langsung ke lobi hotel atau alamat rumah Anda di wilayah Cirebon sesuai jam keberangkatan.
                    </p>
                </div>

                <div class="card p-6">
                    <div class="eyebrow-label !text-[10px] mb-2">TITIK JEMPUT 04</div>
                    <h3 class="text-[18px] font-semibold text-[#001733] mb-2">Operasional Dinas & Korporat</h3>
                    <p class="text-[14px] text-[#68748d] leading-[1.5]">
                        Penyediaan armada harian, mingguan, hingga kontrak bulanan lengkap dengan faktur resmi untuk instansi dan perusahaan.
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- 1px Mist Section Divider --}}
<div class="aurora-container">
    <div class="section-divider"></div>
</div>

{{-- 7. PERTANYAAN UMUM SPESIFIK RENTAL MOBIL (FAQ) --}}
<section class="py-24 bg-white">
    <div class="aurora-container">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            <div class="lg:col-span-5">
                <div class="eyebrow-label mb-3">INFORMASI PENYEWAAN</div>
                <h2 class="text-[36px] md:text-[44px] font-semibold text-[#001733] leading-[1.0] tracking-[-1.672px] mb-6">
                    Ketentuan sewa yang sering ditanyakan.
                </h2>
                <p class="text-[16px] text-[#68748d] leading-[1.5] mb-8">
                    Persyaratan dokumen dan mekanisme operasional kami susun secara ringkas agar proses verifikasi selesai dalam hitungan menit.
                </p>
                <a href="{{ route('landing.contact') }}" class="link-ghost">
                    <span>Ajukan Pertanyaan Lainnya</span>
                    <span class="text-[12px]">→</span>
                </a>
            </div>

            <div class="lg:col-span-7 space-y-3">
                <details class="card group" open>
                    <summary class="p-5 cursor-pointer list-none flex items-center justify-between gap-4 text-[16px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">
                        <span>Apa saja dokumen persyaratan untuk sewa mobil lepas kunci?</span>
                        <span class="text-[12px] text-[#68748d] group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="px-5 pb-5 pt-3 border-t border-[#e6e9f0] text-[14px] text-[#68748d] leading-[1.5]">
                        Penyewa cukup menyiapkan e-KTP asli, SIM A aktif, serta satu dokumen pendukung (ID Card Karyawan, NPWP, atau bukti pemesanan tiket kereta/hotel bagi wisatawan luar kota). Verifikasi dilakukan secara cepat melalui WhatsApp.
                    </div>
                </details>

                <details class="card group">
                    <summary class="p-5 cursor-pointer list-none flex items-center justify-between gap-4 text-[16px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">
                        <span>Bagaimana perhitungan durasi sewa harian dan ketentuan overtime?</span>
                        <span class="text-[12px] text-[#68748d] group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="px-5 pb-5 pt-3 border-t border-[#e6e9f0] text-[14px] text-[#68748d] leading-[1.5]">
                        Durasi sewa harian dihitung penuh 24 jam sejak waktu serah terima unit. Apabila terdapat kelebihan waktu pemakaian (overtime), biaya dihitung proporsional sebesar 10% per jam dari tarif sewa harian.
                    </div>
                </details>

                <details class="card group">
                    <summary class="p-5 cursor-pointer list-none flex items-center justify-between gap-4 text-[16px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">
                        <span>Apakah tersedia layanan antar-jemput ke Stasiun Cirebon atau hotel?</span>
                        <span class="text-[12px] text-[#68748d] group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="px-5 pb-5 pt-3 border-t border-[#e6e9f0] text-[14px] text-[#68748d] leading-[1.5]">
                        Ya, pengantaran dan penjemputan unit ke Stasiun Kejaksan, Stasiun Prujakan, maupun hotel di wilayah Kota Cirebon tidak dikenakan biaya tambahan (gratis).
                    </div>
                </details>

                <details class="card group">
                    <summary class="p-5 cursor-pointer list-none flex items-center justify-between gap-4 text-[16px] font-medium text-[#001733] hover:text-[#006aed] transition-colors">
                        <span>Bagaimana prosedur pembayaran untuk mengamankan jadwal unit?</span>
                        <span class="text-[12px] text-[#68748d] group-open:rotate-180 transition-transform">▼</span>
                    </summary>
                    <div class="px-5 pb-5 pt-3 border-t border-[#e6e9f0] text-[14px] text-[#68748d] leading-[1.5]">
                        Pemesanan unit dapat dikunci dengan pembayaran uang muka (DP) melalui transfer bank resmi atau QRIS. Pelunasan dilakukan saat unit diserahterimakan kepada Anda.
                    </div>
                </details>
            </div>

        </div>
    </div>
</section>

{{-- 1px Mist Section Divider --}}
<div class="aurora-container">
    <div class="section-divider"></div>
</div>

{{-- 8. INSTAGRAM BRANDING & SOCIAL PROOF (@rentgo.id) --}}
<section id="instagram" class="py-24 bg-[#fafbfd] border-y border-[#e6e9f0]/70 relative overflow-hidden">
    {{-- Subtle decorative ambient glow --}}
    <div class="absolute -top-24 right-0 w-96 h-96 bg-gradient-to-br from-[#f09433]/5 via-[#dc2743]/5 to-[#bc1888]/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 left-0 w-96 h-96 bg-[#006aed]/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="aurora-container relative z-10">
        {{-- Section Header & Profile Card --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-12">
            <div class="max-w-[620px]">
                <div class="eyebrow-label mb-3 inline-flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888]"></span>
                    <span>DOKUMENTASI &amp; MEDIA SOSIAL</span>
                </div>
                <h2 class="text-[36px] md:text-[44px] font-semibold text-[#001733] leading-[1.0] tracking-[-1.672px] mb-4">
                    Ikuti perjalanan nyata kami di Instagram <a href="https://www.instagram.com/rentgo.id/" target="_blank" rel="noopener noreferrer" class="text-transparent bg-clip-text bg-gradient-to-r from-[#f09433] via-[#dc2743] to-[#bc1888] hover:opacity-85 transition-opacity">@rentgo.id</a>
                </h2>
                <p class="text-[16px] text-[#68748d] leading-[1.5]">
                    Dokumentasi harian serah terima armada di Stasiun Cirebon, review jujur penyewa, rute jelajah Ciayumajakuning, hingga promo rental eksklusif setiap minggunya.
                </p>
            </div>

            {{-- Instagram Profile Mini Header Badge --}}
            <div class="card p-4 sm:p-5 bg-white border border-[#e6e9f0] shadow-sm flex items-center gap-4 flex-shrink-0 self-start lg:self-auto">
                <a href="https://www.instagram.com/rentgo.id/" target="_blank" rel="noopener noreferrer" class="block flex-shrink-0 group">
                    <img src="{{ asset('assets/rentgo_dark.png') }}"
                         alt="RentGo Indonesia"
                         class="h-10 sm:h-11 w-auto object-contain group-hover:scale-105 transition-transform" />
                </a>

                <div class="min-w-0 pr-2 border-l border-[#e6e9f0] pl-4">
                    <div class="flex items-center gap-1.5">
                        <a href="https://www.instagram.com/rentgo.id/" target="_blank" rel="noopener noreferrer" class="text-[16px] font-bold text-[#001733] hover:text-[#dc2743] transition-colors truncate">
                            @rentgo.id
                        </a>
                        <span class="w-4 h-4 rounded-full bg-[#006aed] text-white inline-flex items-center justify-center text-[9px] font-black" title="Akun Resmi">✓</span>
                    </div>
                    <div class="text-[12px] font-medium text-[#68748d]">RentGo Indonesia • Cirebon</div>
                    <div class="text-[11px] text-[#006aed] font-medium mt-0.5">Rental Mobil Resmi &amp; Terpercaya</div>
                </div>

                <a href="https://www.instagram.com/rentgo.id/"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="button-pill !py-[9px] !px-[16px] !min-h-[36px] flex-shrink-0 ml-auto">
                    <span class="button-pill__inner !text-[12px]">
                        <span>Ikuti</span>
                        <span class="text-[10px]">↗</span>
                    </span>
                </a>
            </div>
        </div>

        {{-- Curated 4-Post Grid with Authentic Instagram Post Anatomy --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- Instagram Card 01: Zenix di Keraton Cirebon --}}
            <a href="https://www.instagram.com/rentgo.id/"
               target="_blank"
               rel="noopener noreferrer"
               class="card bg-white border border-[#e6e9f0] overflow-hidden flex flex-col justify-between group hover:shadow-md hover:border-[#dc2743]/40 transition-all duration-300">
                <div>
                    {{-- Post Top Bar --}}
                    <div class="p-3.5 flex items-center justify-between border-b border-[#f3f4f8]">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-7 h-7 rounded-full p-[1.5px] bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] flex-shrink-0">
                                <img src="{{ asset('assets/logo.jpeg') }}" alt="rentgo.id" class="w-full h-full rounded-full object-cover" />
                            </div>
                            <div class="min-w-0">
                                <div class="text-[12px] font-semibold text-[#001733] truncate">rentgo.id</div>
                                <div class="text-[10px] text-[#68748d] truncate">Keraton Kasepuhan, Cirebon</div>
                            </div>
                        </div>
                        <svg class="w-3.5 h-3.5 fill-current text-[#68748d] group-hover:text-[#dc2743] transition-colors" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>

                    {{-- Post Media Thumbnail --}}
                    <div class="relative aspect-[4/3] bg-[#e6e9f0] overflow-hidden">
                        <img src="{{ asset('images/cirebon_keraton_zenix.webp') }}"
                             alt="Innova Zenix Keraton Cirebon - RentGo Instagram"
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded-[4px] bg-white/95 text-[#001733] text-[10px] font-semibold border border-[#e6e9f0]">
                            Kunjungan Dinas
                        </span>
                    </div>

                    {{-- Post Actions Bar --}}
                    <div class="p-3.5 pb-2">
                        <div class="flex items-center justify-between text-[#001733] mb-2">
                            <div class="flex items-center gap-3 text-[14px]">
                                <span class="text-[#dc2743]">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </span>
                                <span class="text-[#68748d] hover:text-[#001733]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </span>
                                <span class="text-[#68748d] hover:text-[#001733]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </span>
                            </div>
                            <span class="text-[#68748d]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                            </span>
                        </div>
                        <div class="text-[12px] font-bold text-[#001733] mb-1">189 suka</div>
                        <p class="text-[12px] text-[#475569] leading-[1.5] line-clamp-3">
                            <span class="font-semibold text-[#001733]">rentgo.id</span> Penyerahan unit Toyota Innova Zenix Hybrid untuk rombongan dinas di Keraton Kasepuhan Cirebon. Hening, elegan, dan siap menunjang agenda penting.
                        </p>
                    </div>
                </div>

                <div class="px-3.5 pb-3.5 pt-1 text-[11px] font-medium text-[#006aed]">
                    #RentGoCirebon #ZenixCirebon #DinasCirebon
                </div>
            </a>

            {{-- Instagram Card 02: Kabin Bersih 21 Titik --}}
            <a href="https://www.instagram.com/rentgo.id/"
               target="_blank"
               rel="noopener noreferrer"
               class="card bg-white border border-[#e6e9f0] overflow-hidden flex flex-col justify-between group hover:shadow-md hover:border-[#dc2743]/40 transition-all duration-300">
                <div>
                    {{-- Post Top Bar --}}
                    <div class="p-3.5 flex items-center justify-between border-b border-[#f3f4f8]">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-7 h-7 rounded-full p-[1.5px] bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] flex-shrink-0">
                                <img src="{{ asset('assets/logo.jpeg') }}" alt="rentgo.id" class="w-full h-full rounded-full object-cover" />
                            </div>
                            <div class="min-w-0">
                                <div class="text-[12px] font-semibold text-[#001733] truncate">rentgo.id</div>
                                <div class="text-[10px] text-[#68748d] truncate">Garasi RentGo Talun, Cirebon</div>
                            </div>
                        </div>
                        <svg class="w-3.5 h-3.5 fill-current text-[#68748d] group-hover:text-[#dc2743] transition-colors" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>

                    {{-- Post Media Thumbnail --}}
                    <div class="relative aspect-[4/3] bg-[#e6e9f0] overflow-hidden">
                        <img src="{{ asset('images/car_cockpit.webp') }}"
                             alt="Standar Kebersihan Kabin - RentGo Instagram"
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded-[4px] bg-white/95 text-[#001733] text-[10px] font-semibold border border-[#e6e9f0]">
                            Inspeksi 21 Titik
                        </span>
                    </div>

                    {{-- Post Actions Bar --}}
                    <div class="p-3.5 pb-2">
                        <div class="flex items-center justify-between text-[#001733] mb-2">
                            <div class="flex items-center gap-3 text-[14px]">
                                <span class="text-[#dc2743]">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </span>
                                <span class="text-[#68748d] hover:text-[#001733]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </span>
                                <span class="text-[#68748d] hover:text-[#001733]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </span>
                            </div>
                            <span class="text-[#68748d]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                            </span>
                        </div>
                        <div class="text-[12px] font-bold text-[#001733] mb-1">245 suka</div>
                        <p class="text-[12px] text-[#475569] leading-[1.5] line-clamp-3">
                            <span class="font-semibold text-[#001733]">rentgo.id</span> Kenyamanan Anda tidak bisa ditawar. Setiap unit dibersihkan menyeluruh, kabin disterilisasi, dan 21 titik mekanis diuji sebelum serah terima.
                        </p>
                    </div>
                </div>

                <div class="px-3.5 pb-3.5 pt-1 text-[11px] font-medium text-[#006aed]">
                    #MobilBersih #RentalMobilCirebon #StandarPrima
                </div>
            </a>

            {{-- Instagram Card 03: Wisata Lereng Ciremai Kuningan --}}
            <a href="https://www.instagram.com/rentgo.id/"
               target="_blank"
               rel="noopener noreferrer"
               class="card bg-white border border-[#e6e9f0] overflow-hidden flex flex-col justify-between group hover:shadow-md hover:border-[#dc2743]/40 transition-all duration-300">
                <div>
                    {{-- Post Top Bar --}}
                    <div class="p-3.5 flex items-center justify-between border-b border-[#f3f4f8]">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-7 h-7 rounded-full p-[1.5px] bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] flex-shrink-0">
                                <img src="{{ asset('assets/logo.jpeg') }}" alt="rentgo.id" class="w-full h-full rounded-full object-cover" />
                            </div>
                            <div class="min-w-0">
                                <div class="text-[12px] font-semibold text-[#001733] truncate">rentgo.id</div>
                                <div class="text-[10px] text-[#68748d] truncate">Lereng Gn. Ciremai, Kuningan</div>
                            </div>
                        </div>
                        <svg class="w-3.5 h-3.5 fill-current text-[#68748d] group-hover:text-[#dc2743] transition-colors" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>

                    {{-- Post Media Thumbnail --}}
                    <div class="relative aspect-[4/3] bg-[#e6e9f0] overflow-hidden">
                        <img src="{{ asset('images/cirebon_toll_ciremai.webp') }}"
                             alt="Wisata Kuningan Ciremai - RentGo Instagram"
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded-[4px] bg-white/95 text-[#001733] text-[10px] font-semibold border border-[#e6e9f0]">
                            Trip Wisata
                        </span>
                    </div>

                    {{-- Post Actions Bar --}}
                    <div class="p-3.5 pb-2">
                        <div class="flex items-center justify-between text-[#001733] mb-2">
                            <div class="flex items-center gap-3 text-[14px]">
                                <span class="text-[#dc2743]">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </span>
                                <span class="text-[#68748d] hover:text-[#001733]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </span>
                                <span class="text-[#68748d] hover:text-[#001733]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </span>
                            </div>
                            <span class="text-[#68748d]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                            </span>
                        </div>
                        <div class="text-[12px] font-bold text-[#001733] mb-1">312 suka</div>
                        <p class="text-[12px] text-[#475569] leading-[1.5] line-clamp-3">
                            <span class="font-semibold text-[#001733]">rentgo.id</span> Akhir pekan santai menikmati udara sejuk Palutungan dan Waduk Darma Kuningan. Lepas kunci mudah, rute tanjakan dilibas aman tanpa khawatir.
                        </p>
                    </div>
                </div>

                <div class="px-3.5 pb-3.5 pt-1 text-[11px] font-medium text-[#006aed]">
                    #WisataCirebon #WisataKuningan #JelajahCiremai
                </div>
            </a>

            {{-- Instagram Card 04: Antar Jemput Stasiun Kejaksan --}}
            <a href="https://www.instagram.com/rentgo.id/"
               target="_blank"
               rel="noopener noreferrer"
               class="card bg-white border border-[#e6e9f0] overflow-hidden flex flex-col justify-between group hover:shadow-md hover:border-[#dc2743]/40 transition-all duration-300">
                <div>
                    {{-- Post Top Bar --}}
                    <div class="p-3.5 flex items-center justify-between border-b border-[#f3f4f8]">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-7 h-7 rounded-full p-[1.5px] bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] flex-shrink-0">
                                <img src="{{ asset('assets/logo.jpeg') }}" alt="rentgo.id" class="w-full h-full rounded-full object-cover" />
                            </div>
                            <div class="min-w-0">
                                <div class="text-[12px] font-semibold text-[#001733] truncate">rentgo.id</div>
                                <div class="text-[10px] text-[#68748d] truncate">Stasiun Kejaksan, Cirebon</div>
                            </div>
                        </div>
                        <svg class="w-3.5 h-3.5 fill-current text-[#68748d] group-hover:text-[#dc2743] transition-colors" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </div>

                    {{-- Post Media Thumbnail --}}
                    <div class="relative aspect-[4/3] bg-[#e6e9f0] overflow-hidden">
                        <img src="{{ asset('images/experience_card_car.webp') }}"
                             alt="Antar Stasiun Cirebon - RentGo Instagram"
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        <span class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded-[4px] bg-white/95 text-[#001733] text-[10px] font-semibold border border-[#e6e9f0]">
                            Serah Terima Stasiun
                        </span>
                    </div>

                    {{-- Post Actions Bar --}}
                    <div class="p-3.5 pb-2">
                        <div class="flex items-center justify-between text-[#001733] mb-2">
                            <div class="flex items-center gap-3 text-[14px]">
                                <span class="text-[#dc2743]">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </span>
                                <span class="text-[#68748d] hover:text-[#001733]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                </span>
                                <span class="text-[#68748d] hover:text-[#001733]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </span>
                            </div>
                            <span class="text-[#68748d]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                            </span>
                        </div>
                        <div class="text-[12px] font-bold text-[#001733] mb-1">198 suka</div>
                        <p class="text-[12px] text-[#475569] leading-[1.5] line-clamp-3">
                            <span class="font-semibold text-[#001733]">rentgo.id</span> Turun dari kereta Argo Cheribon langsung serah terima kunci di parkiran stasiun. Tanpa nunggu lama, tanpa biaya antar tambahan untuk area Kota Cirebon.
                        </p>
                    </div>
                </div>

                <div class="px-3.5 pb-3.5 pt-1 text-[11px] font-medium text-[#006aed]">
                    #StasiunKejaksan #RentalStasiunCirebon #RentGo
                </div>
            </a>

        </div>

        {{-- Bottom Tag & Community Banner --}}
        <div class="mt-10 card p-6 md:p-8 bg-white border border-[#e6e9f0] flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-start md:items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] flex items-center justify-center text-white flex-shrink-0 shadow-sm">
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </div>
                <div>
                    <div class="text-[14px] font-semibold text-[#001733] flex items-center gap-2">
                        <span>Bagikan Cerita Perjalanan Anda Bersama RentGo</span>
                        <span class="text-[11px] font-normal text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">#JelajahBersamaRentGo</span>
                    </div>
                    <div class="text-[13px] text-[#68748d] mt-0.5">
                        Tag akun resmi <strong class="text-[#001733]">@rentgo.id</strong> pada postingan atau story Anda untuk kesempatan mendapatkan voucher sewa spesial!
                    </div>
                </div>
            </div>

            <a href="https://www.instagram.com/rentgo.id/"
               target="_blank"
               rel="noopener noreferrer"
               class="button-pill flex-shrink-0 self-start md:self-auto">
                <span class="button-pill__inner">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span>Buka Instagram @rentgo.id</span>
                    <span class="text-[12px]">↗</span>
                </span>
            </a>
        </div>
    </div>
</section>

{{-- 9. HORIZON NAVY SPOTLIGHT CTA (design.md: Horizon Navy #001733 field + rare Aurora Spectrum gradient accent) --}}
<section class="py-12 bg-white">
    <div class="aurora-container">
        <div class="rounded-[8px] bg-[#001733] p-8 md:p-16 text-white relative overflow-hidden">
            {{-- Signature Aurora Spectrum Gradient Bar (#18dcdc -> #006aed) --}}
            <div class="absolute top-0 left-0 w-full h-1.5 aurora-spectrum-bg"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
                <div class="lg:col-span-8">
                    <div class="text-[11px] font-medium uppercase tracking-[0.12em] text-[#18dcdc] mb-3">
                        RESERVASI & KONSULTASI RUTE
                    </div>
                    <h2 class="text-[36px] md:text-[52px] font-semibold text-white leading-[0.97] tracking-[-2.08px] mb-4">
                        Jadwalkan kendaraan Anda hari ini.
                    </h2>
                    <p class="text-[16px] text-[#d1d6e0] leading-[1.5] max-w-[540px]">
                        Tim operasional RentGo aktif 24 jam untuk membantu pengecekan ketersediaan unit, penjemputan stasiun, maupun kebutuhan sewa korporat.
                    </p>
                </div>

                <div class="lg:col-span-4 flex flex-wrap lg:justify-end gap-3">
                    <a href="https://wa.me/6285601700507" target="_blank" class="button-pill">
                        <span class="button-pill__inner">
                            <span>Hubungi WhatsApp</span>
                            <span class="text-[12px]">→</span>
                        </span>
                    </a>
                    <a href="{{ route('landing.pricing') }}#armada" class="button-ghost !bg-transparent !text-white !border-white/25 hover:!bg-white/10">
                        <span>Katalog Armada</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@extends('layouts.app')

@section('title', 'Tentang Kami - RentGo Indonesia | Rental Mobil Profesional Cirebon')
@section('meta_description', 'Mengenal RentGo Indonesia, penyedia jasa rental mobil terpercaya di Cirebon. Komitmen pada protokol inspeksi 21 titik, transparansi tarif, dan layanan 24 jam.')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "AboutPage",
  "@id": "{{ url('/about') }}#about",
  "name": "Tentang RentGo Indonesia",
  "description": "Profil penyedia jasa sewa mobil terpercaya di Cirebon dengan standar inspeksi 21 titik dan tarif transparan.",
  "url": "{{ url('/about') }}",
  "inLanguage": "id-ID",
  "mainEntity": {
    "@type": "AutoRental",
    "name": "RentGo Indonesia",
    "url": "{{ url('/') }}",
    "sameAs": [
      "https://www.instagram.com/rentgo.id/"
    ],
    "telephone": "+6285601700507",
    "email": "rentgo.idcirebon@gmail.com",
    "address": {
      "@type": "PostalAddress",
      "addressLocality": "Cirebon",
      "addressRegion": "Jawa Barat",
      "addressCountry": "ID"
    }
  }
}
</script>
@endsection

@section('content')

{{-- 1. EDITORIAL HEADER & METRICS BAR --}}
<section class="pt-16 pb-20 bg-white">
    <div class="aurora-container">
        <div class="max-w-[780px] mb-14">
            <div class="eyebrow-label mb-3">TENTANG RENTGO INDONESIA</div>
            <h1 class="text-[44px] md:text-[64px] font-semibold text-[#001733] leading-[0.96] tracking-[-2.56px] mb-6">
                Standar presisi untuk setiap perjalanan.
            </h1>
            <p class="text-[16px] md:text-[18px] text-[#68748d] leading-[1.5] max-w-[620px]">
                RentGo berdiri di Cirebon dengan satu tujuan jelas: menghadirkan layanan sewa mobil yang terjadwal, terukur secara mekanis, dan bebas dari biaya tersembunyi.
            </p>
        </div>

        {{-- 4-Column Rectilinear Metrics Bar (Hailstone surface, 1px Mist hairlines, 8px radius) --}}
        <div class="rounded-[8px] bg-[#f3f4f8] border border-[#e6e9f0] grid grid-cols-2 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-[#e6e9f0]">
            <div class="p-6 md:p-8">
                <div class="eyebrow-label !text-[11px] mb-1">ARMADA AKTIF</div>
                <div class="text-[32px] md:text-[44px] font-semibold text-[#001733] leading-[1.0] tracking-[-1.672px]">
                    {{ $stats['total_cars'] ?? 0 }}+
                </div>
                <div class="text-[13px] text-[#68748d] mt-2">Unit terawat & siap jalan</div>
            </div>
            <div class="p-6 md:p-8">
                <div class="eyebrow-label !text-[11px] mb-1">PELANGGAN TERLAYANI</div>
                <div class="text-[32px] md:text-[44px] font-semibold text-[#001733] leading-[1.0] tracking-[-1.672px]">
                    {{ max($stats['total_customers'] ?? 0, 120) }}+
                </div>
                <div class="text-[13px] text-[#68748d] mt-2">Pribadi, wisata & instansi</div>
            </div>
            <div class="p-6 md:p-8">
                <div class="eyebrow-label !text-[11px] mb-1">STANDAR INSPEKSI</div>
                <div class="text-[32px] md:text-[44px] font-semibold text-[#006aed] leading-[1.0] tracking-[-1.672px]">
                    21 Titik
                </div>
                <div class="text-[13px] text-[#68748d] mt-2">Wajib sebelum serah terima</div>
            </div>
            <div class="p-6 md:p-8">
                <div class="eyebrow-label !text-[11px] mb-1">DUKUNGAN TEKNIS</div>
                <div class="text-[32px] md:text-[44px] font-semibold text-[#001733] leading-[1.0] tracking-[-1.672px]">
                    24 Jam
                </div>
                <div class="text-[13px] text-[#68748d] mt-2">Siaga lintas Ciayumajakuning</div>
            </div>
        </div>
    </div>
</section>

{{-- 1px Mist Section Divider --}}
<div class="aurora-container">
    <div class="section-divider"></div>
</div>

{{-- 2. ASYMMETRIC EDITORIAL STORY (40% Left Stacked Masonry / 55% Right Scroll-Driven Text Reveal) --}}
<section class="py-24 bg-white">
    <div class="aurora-container">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            {{-- Left Column (40%): Stacked Documentary Photography --}}
            <div class="lg:col-span-5 space-y-6">
                <figure class="rounded-[8px] overflow-hidden border border-[#e6e9f0] bg-[#f3f4f8]">
                    <img src="{{ asset('images/car_cockpit.jpg') }}"
                         alt="Standar Kebersihan Kabin RentGo Indonesia"
                         class="w-full aspect-[4/3] object-cover" />
                </figure>
                <figure class="rounded-[8px] overflow-hidden border border-[#e6e9f0] bg-[#f3f4f8]">
                    <img src="{{ asset('images/hero_highway_car.jpg') }}"
                         alt="Armada RentGo Melintas di Jalur Utama Cirebon"
                         class="w-full aspect-[3/2] object-cover" />
                </figure>
                <div class="flex items-center justify-between text-[12px] font-medium text-[#68748d]">
                    <span>Standar Kesiapan Armada</span>
                    <span>Talun & Weru, Cirebon</span>
                </div>
            </div>

            {{-- Right Column (55%): Scroll-Reveal Narrative & 4 Core Values --}}
            <div class="lg:col-span-7 lg:pl-6">
                <div class="eyebrow-label mb-3">FILOSOFI PELAYANAN</div>
                <h2 class="text-[36px] md:text-[44px] font-semibold text-[#001733] leading-[1.0] tracking-[-1.672px] mb-10">
                    Bukan sekadar menyewakan kunci, melainkan memberi rasa aman.
                </h2>

                <div class="space-y-8 max-w-[580px] mb-12">
                    <p class="js-text-reveal text-[22px] md:text-[26px] font-normal leading-[1.4] tracking-[-0.03em] text-[#001733]">
                        Kami memahami bahwa setiap perjalanan memiliki agenda penting, baik itu kunjungan kerja yang terjadwal ketat, penjemputan tamu di stasiun, maupun perjalanan keluarga lintas kota.
                    </p>
                    <p class="text-[16px] text-[#68748d] leading-[1.5]">
                        Karena itu kami menolak kompromi dalam pemeliharaan unit. Setiap mobil yang kembali ke garasi langsung melalui pembersihan menyeluruh, pengecekan pengereman, dan pemeriksaan tekanan ban sebelum dijadwalkan untuk penyewa berikutnya.
                    </p>
                </div>

                {{-- 2x2 Rectilinear Hailstone Cards --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="card p-6">
                        <div class="text-[12px] font-medium uppercase tracking-[0.12em] text-[#006aed] mb-2">01 / TRANSPARANSI</div>
                        <h3 class="text-[18px] font-semibold text-[#001733] mb-2">Tarif Terbuka & Pasti</h3>
                        <p class="text-[14px] text-[#68748d] leading-[1.5]">
                            Nominal sewa yang disepakati di awal adalah tarif akhir. Tidak ada biaya tersembunyi saat pengembalian unit.
                        </p>
                    </div>

                    <div class="card p-6">
                        <div class="text-[12px] font-medium uppercase tracking-[0.12em] text-[#006aed] mb-2">02 / HIGIENITAS</div>
                        <h3 class="text-[18px] font-semibold text-[#001733] mb-2">Kabin Bersih & Bebas Bau</h3>
                        <p class="text-[14px] text-[#68748d] leading-[1.5]">
                            Interior selalu divakum, disanitasi, dan dipastikan bebas residu asap rokok demi kenyamanan seluruh penumpang.
                        </p>
                    </div>

                    <div class="card p-6">
                        <div class="text-[12px] font-medium uppercase tracking-[0.12em] text-[#006aed] mb-2">03 / KECEPATAN</div>
                        <h3 class="text-[18px] font-semibold text-[#001733] mb-2">Verifikasi 5 Menit</h3>
                        <p class="text-[14px] text-[#68748d] leading-[1.5]">
                            Proses administrasi dan verifikasi dokumen digital melalui WhatsApp dirancang ringkas tanpa menahan waktu keberangkatan Anda.
                        </p>
                    </div>

                    <div class="card p-6">
                        <div class="text-[12px] font-medium uppercase tracking-[0.12em] text-[#006aed] mb-2">04 / HOSPITALITY</div>
                        <h3 class="text-[18px] font-semibold text-[#001733] mb-2">Pengemudi Berpengalaman</h3>
                        <p class="text-[14px] text-[#68748d] leading-[1.5]">
                            Mitra pengemudi kami terlatih dalam etika pelayanan, tepat waktu, serta menguasai rute Cirebon, Kuningan, dan jalur Pantura.
                        </p>
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

{{-- 3. PROTOKOL INSPEKSI 21 TITIK --}}
<section class="py-24 bg-white">
    <div class="aurora-container">
        <div class="max-w-[680px] mb-14">
            <div class="eyebrow-label mb-3">PROTOKOL KEAMANAN ARMADA</div>
            <h2 class="text-[36px] md:text-[44px] font-semibold text-[#001733] leading-[1.0] tracking-[-1.672px] mb-4">
                Inspeksi 21 titik sebelum kunci diserahkan.
            </h2>
            <p class="text-[16px] text-[#68748d] leading-[1.5]">
                Setiap unit wajib melewati daftar periksa mekanikal dan kelengkapan kabin berikut sebelum keluar dari garasi operasional kami.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card p-7">
                <div class="text-[12px] font-medium uppercase tracking-[0.12em] text-[#006aed] mb-2">BAGIAN 01</div>
                <h3 class="text-[20px] font-semibold text-[#001733] tracking-[-0.6px] mb-5 pb-4 border-b border-[#e6e9f0]">
                    Sistem Mesin & Mekanikal
                </h3>
                <ul class="space-y-3 text-[14px] text-[#464e5d]">
                    <li class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006aed] flex-shrink-0"></span>
                        <span>Volume & kualitas oli mesin</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006aed] flex-shrink-0"></span>
                        <span>Cairan pendingin radiator & reservoir</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006aed] flex-shrink-0"></span>
                        <span>Tegangan aki & respons sistem starter</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006aed] flex-shrink-0"></span>
                        <span>Ketebalan kampas rem & minyak rem</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006aed] flex-shrink-0"></span>
                        <span>Kondisi belt mesin & bebas kebocoran</span>
                    </li>
                </ul>
            </div>

            <div class="card p-7">
                <div class="text-[12px] font-medium uppercase tracking-[0.12em] text-[#006aed] mb-2">BAGIAN 02</div>
                <h3 class="text-[20px] font-semibold text-[#001733] tracking-[-0.6px] mb-5 pb-4 border-b border-[#e6e9f0]">
                    Roda, Ban & Kaki-Kaki
                </h3>
                <ul class="space-y-3 text-[14px] text-[#464e5d]">
                    <li class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006aed] flex-shrink-0"></span>
                        <span>Tekanan angin presisi keempat roda</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006aed] flex-shrink-0"></span>
                        <span>Kedalaman alur tapak ban utama</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006aed] flex-shrink-0"></span>
                        <span>Kesiapan & tekanan ban cadangan</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006aed] flex-shrink-0"></span>
                        <span>Kelengkapan dongkrak, kunci roda & segitiga</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006aed] flex-shrink-0"></span>
                        <span>Kestabilan kemudi & redaman suspensi</span>
                    </li>
                </ul>
            </div>

            <div class="card p-7">
                <div class="text-[12px] font-medium uppercase tracking-[0.12em] text-[#006aed] mb-2">BAGIAN 03</div>
                <h3 class="text-[20px] font-semibold text-[#001733] tracking-[-0.6px] mb-5 pb-4 border-b border-[#e6e9f0]">
                    Kabin, AC & Elektrikal
                </h3>
                <ul class="space-y-3 text-[14px] text-[#464e5d]">
                    <li class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006aed] flex-shrink-0"></span>
                        <span>Suhu dingin AC hingga baris belakang</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006aed] flex-shrink-0"></span>
                        <span>Lampu utama, lampu jauh, sein & hazard</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006aed] flex-shrink-0"></span>
                        <span>Fungsi wiper kaca & cairan pembersih</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006aed] flex-shrink-0"></span>
                        <span>Head unit audio, Bluetooth & soket pengisi daya</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#006aed] flex-shrink-0"></span>
                        <span>Sanitasi jok, karpet dasar & dokumen STNK</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- 1px Mist Section Divider --}}
<div class="aurora-container">
    <div class="section-divider"></div>
</div>

{{-- 4. BASIS OPERASIONAL & LAYANAN KORPORAT (#korporat) --}}
<section id="korporat" class="py-24 bg-white">
    <div class="aurora-container">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            {{-- Left Column: Real Garage & Office Locations --}}
            <div class="lg:col-span-6 space-y-6">
                <div>
                    <div class="eyebrow-label mb-3">BASIS OPERASIONAL RESMI</div>
                    <h2 class="text-[36px] md:text-[44px] font-semibold text-[#001733] leading-[1.0] tracking-[-1.672px] mb-4">
                        Lokasi fisik jelas di Cirebon.
                    </h2>
                    <p class="text-[16px] text-[#68748d] leading-[1.5]">
                        Kantor administrasi dan garasi perawatan armada kami beroperasi secara resmi dan dapat dikunjungi langsung.
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="card p-6">
                        <div class="eyebrow-label !text-[10px] mb-1">KANTOR UTAMA • TALUN</div>
                        <h3 class="text-[18px] font-semibold text-[#001733] mb-1">Kantor Operasional RentGo</h3>
                        <p class="text-[14px] text-[#68748d] leading-[1.5]">
                            Jl. Flamboyan XIII No D.341, Griya Cempaka Arum, Wanasaba Lor, Kec. Talun, Kabupaten Cirebon, Jawa Barat 45171
                        </p>
                    </div>

                    <div class="card p-6">
                        <div class="eyebrow-label !text-[10px] mb-1">POOL ARMADA • WERU</div>
                        <h3 class="text-[18px] font-semibold text-[#001733] mb-1">Garasi &amp; Workshop Inspeksi</h3>
                        <p class="text-[14px] text-[#68748d] leading-[1.5]">
                            Jl. Ki Sulaeman Blok Gembulu RT.003 RW.002, Desa Megu Cilik, Kec. Weru, Kabupaten Cirebon, Jawa Barat
                        </p>
                    </div>

                    <a href="https://www.instagram.com/rentgo.id/"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="card p-5 flex items-center justify-between group hover:border-[#dc2743]/40 transition-colors">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] flex items-center justify-center text-white flex-shrink-0 shadow-sm group-hover:scale-105 transition-transform">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="eyebrow-label !text-[10px] mb-0.5">DOKUMENTASI RESMI</div>
                                <h3 class="text-[16px] font-semibold text-[#001733] group-hover:text-[#dc2743] transition-colors truncate">
                                    Instagram @rentgo.id
                                </h3>
                                <p class="text-[12px] text-[#68748d] truncate">
                                    Dokumentasi serah terima harian &amp; aktivitas armada 24 jam
                                </p>
                            </div>
                        </div>
                        <span class="button-circle-arrow flex-shrink-0" aria-hidden="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>

            {{-- Right Column: Horizon Navy B2B Corporate Spotlight --}}
            <div class="lg:col-span-6">
                <div class="rounded-[8px] bg-[#001733] p-8 md:p-12 text-white relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1.5 aurora-spectrum-bg"></div>

                    <div class="text-[11px] font-medium uppercase tracking-[0.12em] text-[#18dcdc] mb-3">
                        KEMITRAAN KORPORAT & B2B
                    </div>
                    <h3 class="text-[28px] md:text-[36px] font-semibold text-white leading-[1.1] tracking-[-1.368px] mb-4">
                        Layanan Sewa Jangka Panjang untuk Instansi & Perusahaan
                    </h3>
                    <p class="text-[15px] text-[#d1d6e0] leading-[1.5] mb-8">
                        Kami melayani pengadaan kendaraan operasional mingguan, bulanan, hingga kontrak tahunan untuk perusahaan swasta, perbankan, BUMN, dan instansi di wilayah Ciayumajakuning.
                    </p>

                    <ul class="space-y-3 text-[14px] text-white/90 mb-8 border-t border-white/15 pt-6">
                        <li class="flex items-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#18dcdc]"></span>
                            <span>Kelengkapan faktur resmi dan administrasi perpajakan</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#18dcdc]"></span>
                            <span>Jadwal servis berkala ditangani penuh oleh tim RentGo</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#18dcdc]"></span>
                            <span>Garansi unit pengganti setara apabila terjadi perawatan</span>
                        </li>
                    </ul>

                    <div class="flex flex-wrap gap-3">
                        <a href="https://wa.me/6285601700507?text=Halo%20RentGo,%20saya%20ingin%20konsultasi%20mengenai%20kerjasama%20sewa%20mobil%20korporat/bulanan."
                           target="_blank"
                           class="button-pill">
                            <span class="button-pill__inner">
                                <span>Hubungi Tim Korporat</span>
                                <span class="text-[12px]">→</span>
                            </span>
                        </a>
                        <a href="{{ route('landing.pricing') }}#armada" class="button-ghost !bg-transparent !text-white !border-white/25 hover:!bg-white/10">
                            <span>Lihat Katalog Unit</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

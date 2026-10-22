@extends('layouts.app')

@section('title', 'Hubungi Kami & Reservasi 24 Jam - RentGo Indonesia Cirebon')
@section('meta_description', 'Hubungi RentGo Indonesia untuk sewa mobil di Cirebon. Layanan WhatsApp aktif 24 jam, telepon, email, dan alamat garasi resmi di Talun & Weru Cirebon.')

@section('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "ContactPage",
  "@id": "{{ url('/contact') }}#contact",
  "name": "Hubungi & Reservasi RentGo Indonesia",
  "description": "Layanan pelanggan dan reservasi rental mobil Cirebon 24 jam via WhatsApp, Telepon, dan Email.",
  "url": "{{ url('/contact') }}",
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
    "openingHours": "Mo-Su 00:00-23:59"
  }
}
</script>
@endsection

@section('content')

{{-- 1. EDITORIAL HEADER --}}
<section class="pt-16 pb-14 bg-white">
    <div class="aurora-container">
        <div class="max-w-[760px]">
            <div class="eyebrow-label mb-3">HUBUNGI TIM OPERASIONAL</div>
            <h1 class="text-[44px] md:text-[64px] font-semibold text-[#001733] leading-[0.96] tracking-[-2.56px] mb-5">
                Koneksi langsung.<br>Siaga 24 jam.
            </h1>
            <p class="text-[16px] md:text-[18px] text-[#68748d] leading-[1.5] max-w-[580px]">
                Tim operasional kami siap membantu pengecekan ketersediaan unit, penjadwalan antar-jemput stasiun, maupun konsultasi sewa korporat setiap hari.
            </p>
        </div>
    </div>
</section>

{{-- 2. DIRECT CONTACT CHANNELS (4 Hailstone Cards with Icons & Circular Arrow Buttons) --}}
<section class="pb-24 bg-white">
    <div class="aurora-container">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            {{-- Channel 01: WhatsApp --}}
            <a href="https://wa.me/6285601700507" target="_blank" class="card p-7 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-11 h-11 rounded-[8px] bg-white border border-[#e6e9f0] flex items-center justify-center text-[#001733]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </div>
                        <span class="badge-topic badge-topic--gray">RESPONS TERCEPAT</span>
                    </div>
                    <h2 class="text-[20px] font-semibold text-[#001733] tracking-[-0.6px] mb-2">WhatsApp Operasional</h2>
                    <p class="text-[14px] text-[#68748d] leading-[1.5] mb-6">
                        Jalur tercepat untuk cek ketersediaan unit dan verifikasi dokumen sewa (rata-rata respons 5 menit).
                    </p>
                </div>

                <div class="pt-4 border-t border-[#e6e9f0] flex items-center justify-between gap-4">
                    <div>
                        <div class="text-[11px] uppercase tracking-[0.08em] text-[#68748d]">NOMOR WHATSAPP</div>
                        <div class="text-[15px] font-semibold text-[#001733] group-hover:text-[#006aed] transition-colors">+62 856-0170-0507</div>
                    </div>
                    <span class="button-circle-arrow" aria-hidden="true">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </span>
                </div>
            </a>

            {{-- Channel 02: Telepon --}}
            <a href="tel:+6285601700507" class="card p-7 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-11 h-11 rounded-[8px] bg-white border border-[#e6e9f0] flex items-center justify-center text-[#001733]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <span class="badge-topic badge-topic--gray">SIAGA 24 JAM</span>
                    </div>
                    <h2 class="text-[20px] font-semibold text-[#001733] tracking-[-0.6px] mb-2">Sambungan Telepon</h2>
                    <p class="text-[14px] text-[#68748d] leading-[1.5] mb-6">
                        Butuh koordinasi penjemputan mendadak di Stasiun Kejaksan, Prujakan, atau Bandara BIJB? Hubungi langsung.
                    </p>
                </div>

                <div class="pt-4 border-t border-[#e6e9f0] flex items-center justify-between gap-4">
                    <div>
                        <div class="text-[11px] uppercase tracking-[0.08em] text-[#68748d]">TELEPON LANGSUNG</div>
                        <div class="text-[15px] font-semibold text-[#001733] group-hover:text-[#006aed] transition-colors">+62 856-0170-0507</div>
                    </div>
                    <span class="button-circle-arrow" aria-hidden="true">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </span>
                </div>
            </a>

            {{-- Channel 03: Instagram Resmi --}}
            <a href="https://www.instagram.com/rentgo.id/" target="_blank" rel="noopener noreferrer" class="card p-7 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-11 h-11 rounded-[8px] bg-white border border-[#e6e9f0] flex items-center justify-center text-[#e1306c] group-hover:border-[#e1306c]/40 group-hover:scale-105 transition-all">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </div>
                        <span class="badge-topic badge-topic--gray">MEDIA RESMI</span>
                    </div>
                    <h2 class="text-[20px] font-semibold text-[#001733] tracking-[-0.6px] mb-2">Instagram @rentgo.id</h2>
                    <p class="text-[14px] text-[#68748d] leading-[1.5] mb-6">
                        Dokumentasi harian serah terima armada, review jujur pelanggan, inspirasi wisata, &amp; promo mingguan.
                    </p>
                </div>

                <div class="pt-4 border-t border-[#e6e9f0] flex items-center justify-between gap-4">
                    <div class="min-w-0">
                        <div class="text-[11px] uppercase tracking-[0.08em] text-[#68748d]">PROFIL INSTAGRAM</div>
                        <div class="text-[15px] font-semibold text-[#001733] group-hover:text-[#e1306c] transition-colors truncate">@rentgo.id</div>
                    </div>
                    <span class="button-circle-arrow" aria-hidden="true">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </span>
                </div>
            </a>

            {{-- Channel 04: Email --}}
            <a href="mailto:rentgo.idcirebon@gmail.com" class="card p-7 flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-11 h-11 rounded-[8px] bg-white border border-[#e6e9f0] flex items-center justify-center text-[#001733]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="badge-topic badge-topic--gray">RESMI &amp; B2B</span>
                    </div>
                    <h2 class="text-[20px] font-semibold text-[#001733] tracking-[-0.6px] mb-2">Email Administrasi</h2>
                    <p class="text-[14px] text-[#68748d] leading-[1.5] mb-6">
                        Untuk pengajuan surat penawaran harga korporat, kerjasama kontrak bulanan, atau permohonan faktur sewa.
                    </p>
                </div>

                <div class="pt-4 border-t border-[#e6e9f0] flex items-center justify-between gap-4">
                    <div class="min-w-0">
                        <div class="text-[11px] uppercase tracking-[0.08em] text-[#68748d]">ALAMAT EMAIL</div>
                        <div class="text-[14px] font-semibold text-[#001733] group-hover:text-[#006aed] transition-colors truncate">rentgo.idcirebon@gmail.com</div>
                    </div>
                    <span class="button-circle-arrow" aria-hidden="true">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </span>
                </div>
            </a>

        </div>
    </div>
</section>

{{-- 1px Mist Section Divider --}}
<div class="aurora-container">
    <div class="section-divider"></div>
</div>

{{-- 3. ASYMMETRIC LOCATION MAP & CONTACT FORM --}}
<section class="py-24 bg-white">
    <div class="aurora-container">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">
            
            {{-- Left Column (42%): Location Details & Map --}}
            <div class="lg:col-span-5 space-y-6">
                <div>
                    <div class="eyebrow-label mb-2">LOKASI KANTOR & GARASI</div>
                    <h2 class="text-[32px] md:text-[36px] font-semibold text-[#001733] leading-[1.1] tracking-[-1.368px] mb-3">
                        Kunjungi garasi operasional kami.
                    </h2>
                    <p class="text-[15px] text-[#68748d] leading-[1.5]">
                        Anda dapat mengambil unit langsung di garasi kami maupun meminta pengantaran ke titik lokasi Anda di Cirebon.
                    </p>
                </div>

                <div class="card p-5 space-y-4">
                    <div>
                        <div class="eyebrow-label !text-[10px] mb-1">KANTOR UTAMA • TALUN</div>
                        <p class="text-[14px] text-[#001733] font-medium">Griya Cempaka Arum, Kec. Talun</p>
                        <p class="text-[13px] text-[#68748d] mt-0.5">Jl. Flamboyan XIII No D.341, Wanasaba Lor, Kab. Cirebon (45171)</p>
                    </div>
                    <div class="pt-4 border-t border-[#e6e9f0]">
                        <div class="eyebrow-label !text-[10px] mb-1">GARASI & WORKSHOP • WERU</div>
                        <p class="text-[14px] text-[#001733] font-medium">Desa Megu Cilik, Kec. Weru</p>
                        <p class="text-[13px] text-[#68748d] mt-0.5">Jl. Ki Sulaeman Blok Gembulu RT.003 RW.002, Kab. Cirebon</p>
                    </div>
                </div>

                {{-- Rectilinear 8px Map Frame --}}
                <div class="card overflow-hidden">
                    <iframe
                        title="Peta Lokasi RentGo Indonesia Cirebon"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3549.361275872814!2d108.50275527499505!3d-6.760379593236244!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6f1f000b53c6d7%3A0xfaef57e929a116b2!2sRentGo%20Indonesia!5e1!3m2!1sid!2sid!4v1763447609288!5m2!1sid!2sid"
                        width="100%"
                        height="280"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <div class="p-4 bg-white border-t border-[#e6e9f0] flex items-center justify-between">
                        <span class="text-[13px] font-medium text-[#001733]">Koordinat Google Maps</span>
                        <a href="https://www.google.com/maps/place/RentGo+Indonesia/@-6.7603796,108.5027553,17z/"
                           target="_blank"
                           class="link-ghost !text-[13px]">
                            <span>Buka Petunjuk Arah →</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right Column (58%): Contact Form in Hailstone Card with Paper White Input Wells --}}
            <div class="lg:col-span-7">
                <div class="card p-6 md:p-10">
                    <div class="mb-8">
                        <div class="eyebrow-label mb-2">FORMULIR PESAN LANGSUNG</div>
                        <h2 class="text-[28px] md:text-[36px] font-semibold text-[#001733] leading-[1.1] tracking-[-1.368px]">
                            Kirim rincian kebutuhan Anda.
                        </h2>
                        <p class="text-[14px] text-[#68748d] mt-2">
                            Tim kami akan membalas pesan Anda melalui WhatsApp atau email dalam waktu maksimal 2 jam kerja.
                        </p>
                    </div>

                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-[8px] bg-white border border-[#006aed] text-[#001733] text-[14px] flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-[#006aed] flex-shrink-0"></span>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 rounded-[8px] bg-white border border-[#001733] text-[#001733] text-[14px]">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 rounded-[8px] bg-white border border-[#001733] text-[#001733] text-[14px]">
                            Mohon periksa kembali isian formulir Anda di bawah ini.
                        </div>
                    @endif

                    <form id="contactForm" action="{{ route('landing.contact.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="contactName" class="block text-[12px] font-medium uppercase tracking-[0.08em] text-[#001733] mb-2">
                                    Nama Lengkap
                                </label>
                                <input id="contactName"
                                       type="text"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required
                                       class="input-aurora"
                                       placeholder="Masukkan nama lengkap">
                                @error('name')
                                    <p class="text-[#006aed] text-[12px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="contactPhone" class="block text-[12px] font-medium uppercase tracking-[0.08em] text-[#001733] mb-2">
                                    Nomor WhatsApp
                                </label>
                                <input id="contactPhone"
                                       type="tel"
                                       name="phone"
                                       value="{{ old('phone') }}"
                                       required
                                       class="input-aurora"
                                       placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <p class="text-[#006aed] text-[12px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="contactEmail" class="block text-[12px] font-medium uppercase tracking-[0.08em] text-[#001733] mb-2">
                                    Alamat Email
                                </label>
                                <input id="contactEmail"
                                       type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       class="input-aurora"
                                       placeholder="nama@perusahaan.com">
                                @error('email')
                                    <p class="text-[#006aed] text-[12px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="contactPurpose" class="block text-[12px] font-medium uppercase tracking-[0.08em] text-[#001733] mb-2">
                                    Keperluan
                                </label>
                                <select id="contactPurpose" name="purpose" required class="input-aurora">
                                    <option value="">Pilih kategori keperluan...</option>
                                    <option value="booking" {{ old('purpose') == 'booking' ? 'selected' : '' }}>Reservasi / Booking Unit</option>
                                    <option value="info" {{ old('purpose') == 'info' ? 'selected' : '' }}>Informasi Ketersediaan & Tarif</option>
                                    <option value="partnership" {{ old('purpose') == 'partnership' ? 'selected' : '' }}>Kerjasama Sewa Korporat (B2B)</option>
                                    <option value="complaint" {{ old('purpose') == 'complaint' ? 'selected' : '' }}>Evaluasi Layanan</option>
                                    <option value="other" {{ old('purpose') == 'other' ? 'selected' : '' }}>Keperluan Lainnya</option>
                                </select>
                                @error('purpose')
                                    <p class="text-[#006aed] text-[12px] mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="contactMessage" class="block text-[12px] font-medium uppercase tracking-[0.08em] text-[#001733] mb-2">
                                Detail Pesan / Rencana Perjalanan
                            </label>
                            <textarea id="contactMessage"
                                      name="message"
                                      rows="4"
                                      required
                                      class="input-aurora resize-none"
                                      placeholder="Tuliskan tanggal rencana sewa, pilihan unit, atau pertanyaan Anda...">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-[#006aed] text-[12px] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-2 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <p class="text-[13px] text-[#68748d]">
                                Butuh konfirmasi instan? <a href="https://wa.me/6285601700507" target="_blank" class="text-[#006aed] font-medium hover:underline">Chat langsung via WhatsApp</a>.
                            </p>

                            <button type="submit" id="submitBtn" class="button-pill">
                                <span class="button-pill__inner">
                                    <span id="submitText">Kirim Pesan</span>
                                    <span class="text-[12px]">→</span>
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const contactForm = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    if (contactForm && submitBtn && submitText) {
        contactForm.addEventListener('submit', function (e) {
            if (submitBtn.disabled) { e.preventDefault(); return; }
            submitBtn.disabled = true;
            submitText.textContent = 'Mengirim...';
        });
    }
});
</script>

@endsection

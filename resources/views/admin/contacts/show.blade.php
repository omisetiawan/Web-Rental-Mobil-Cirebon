@extends('layouts.admin')

@section('title', 'Detail Pesan #' . $contact->id . ' - ' . $contact->name)

@section('content')
<div class="contact-detail-wrapper">
    <!-- Breadcrumb & Top Action Toolbar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('admin.contacts.index') }}" class="text-muted text-decoration-none small hover-primary">
                    <i class="fas fa-inbox me-1"></i> Kotak Masuk
                </a>
                <span class="text-muted small">/</span>
                <span class="text-slate-800 small fw-semibold">Detail Pesan #{{ $contact->id }}</span>
            </div>
            <h1 class="h4 fw-bold text-slate-900 mb-0" style="letter-spacing: -0.02em;">
                Pesan dari {{ $contact->name }}
            </h1>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-light border border-slate-200 px-3 fw-semibold text-slate-700 rounded-3 shadow-2xs">
                <i class="fas fa-arrow-left me-1 text-muted"></i> Kembali
            </a>
            
            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pesan dari {{ $contact->name }} ini secara permanen?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger px-3 fw-semibold rounded-3 shadow-2xs">
                    <i class="far fa-trash-can me-1"></i> Hapus Pesan
                </button>
            </form>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 py-2.5 px-3 mb-4" role="alert">
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; font-size: 0.85rem;">
                <i class="fas fa-check"></i>
            </div>
            <div class="small flex-grow-1 text-success-emphasis fw-medium">{{ session('success') }}</div>
            <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 py-2.5 px-3 mb-4" role="alert">
            <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; font-size: 0.85rem;">
                <i class="fas fa-exclamation"></i>
            </div>
            <div class="small flex-grow-1 text-danger-emphasis fw-medium">{{ session('error') }}</div>
            <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- LEFT COLUMN: MESSAGE CONTENT & DETAILS (8 COLS) -->
        <div class="col-lg-8">
            <div class="card border border-slate-200 rounded-3 shadow-2xs bg-white mb-4 overflow-hidden">
                <!-- Message Header -->
                <div class="card-header bg-white border-bottom border-slate-100 p-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-start gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold shadow-sm flex-shrink-0" style="width: 48px; height: 48px; font-size: 1.15rem;">
                                {{ strtoupper(substr($contact->name, 0, 1)) }}
                            </div>
                            <div>
                                <h2 class="h5 fw-bold text-slate-900 mb-1" style="font-size: 1.05rem;">{{ $contact->name }}</h2>
                                <div class="d-flex flex-wrap align-items-center gap-2 text-muted small" style="font-size: 0.775rem;">
                                    <span class="text-slate-600"><i class="far fa-envelope me-1 text-primary"></i>{{ $contact->email }}</span>
                                    <span>•</span>
                                    <span class="text-slate-600"><i class="fas fa-phone me-1 text-emerald-600"></i>{{ $contact->phone }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <!-- Purpose Badge -->
                            @if($contact->purpose == 'booking')
                                <span class="badge bg-sky-50 text-sky-700 border border-sky-200 px-2.5 py-1 rounded fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-calendar-check me-1 text-sky-600"></i> Booking Mobil
                                </span>
                            @elseif($contact->purpose == 'partnership')
                                <span class="badge bg-purple-50 text-purple-700 border border-purple-200 px-2.5 py-1 rounded fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-handshake me-1 text-purple-600"></i> Kerjasama
                                </span>
                            @elseif($contact->purpose == 'complaint')
                                <span class="badge bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-1 rounded fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-triangle-exclamation me-1 text-rose-600"></i> Keluhan
                                </span>
                            @elseif($contact->purpose == 'info')
                                <span class="badge bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-circle-info me-1 text-blue-600"></i> Informasi
                                </span>
                            @else
                                <span class="badge bg-slate-100 text-slate-700 border border-slate-200 px-2.5 py-1 rounded fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-question-circle me-1 text-slate-500"></i> {{ $contact->purpose_label }}
                                </span>
                            @endif

                            <!-- Status Badge -->
                            @if($contact->status == 'unread')
                                <span class="badge bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-pill fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-circle text-amber-500 me-1" style="font-size: 0.45rem;"></i> Belum Dibaca
                                </span>
                            @elseif($contact->status == 'read')
                                <span class="badge bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-pill fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-circle text-blue-500 me-1" style="font-size: 0.45rem;"></i> Sudah Dibaca
                                </span>
                            @else
                                <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-pill fw-semibold" style="font-size: 0.75rem;">
                                    <i class="fas fa-circle text-emerald-500 me-1" style="font-size: 0.45rem;"></i> Sudah Dibalas
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Message Body -->
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="text-muted fw-semibold small text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                            <i class="fas fa-align-left me-1 text-primary"></i> Isi Pesan / Pertanyaan
                        </span>
                        <span class="text-muted small" style="font-size: 0.75rem;">
                            <i class="far fa-clock me-1"></i> {{ $contact->created_at->translatedFormat('l, d F Y - H:i') }} WIB ({{ $contact->created_at->diffForHumans() }})
                        </span>
                    </div>

                    <div class="p-3.5 rounded-3 bg-slate-50 border border-slate-200" style="min-height: 140px;">
                        <p class="text-slate-800 mb-0" style="font-size: 0.925rem; line-height: 1.7; white-space: pre-line;">
                            {{ $contact->message }}
                        </p>
                    </div>

                    <!-- Follow-up Quick Action Strip -->
                    @php
                        $waPhone = preg_replace('/[^0-9]/', '', $contact->phone);
                        if (str_starts_with($waPhone, '0')) {
                            $waPhone = '62' . substr($waPhone, 1);
                        }
                        $waDraft = urlencode("Halo Bpk/Ibu " . $contact->name . ",\n\nTerima kasih telah menghubungi RentGo Transportasi Cirebon terkait permohonan *" . $contact->purpose_label . "*.\n\nMenanggapi pesan Anda:\n\"" . Str::limit($contact->message, 80) . "\"\n\nBerikut kami informasikan...");
                        $mailSubject = urlencode("Tanggapan: " . $contact->purpose_label . " - RentGo Transportasi Cirebon");
                        $mailBody = urlencode("Halo " . $contact->name . ",\n\nTerima kasih telah menghubungi RentGo Transportasi Cirebon.\n\nMenindaklanjuti pesan Anda:\n" . $contact->message . "\n\nSalam,\nTim Layanan Pelanggan RentGo");
                    @endphp

                    <div class="mt-4 pt-3 border-top border-slate-100 d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="text-muted small" style="font-size: 0.775rem;">
                            Tindak lanjuti pertanyaan pelanggan secara langsung:
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            @if($contact->phone)
                                <a href="https://wa.me/{{ $waPhone }}?text={{ $waDraft }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-success px-3 fw-semibold rounded-3 d-inline-flex align-items-center gap-2 shadow-2xs">
                                    <i class="fab fa-whatsapp" style="font-size: 1rem;"></i>
                                    <span>Balas via WhatsApp</span>
                                </a>
                            @endif

                            <a href="mailto:{{ $contact->email }}?subject={{ $mailSubject }}&body={{ $mailBody }}" 
                               class="btn btn-sm btn-light border border-slate-200 text-slate-700 px-3 fw-semibold rounded-3 d-inline-flex align-items-center gap-2 shadow-2xs">
                                <i class="far fa-envelope text-primary"></i>
                                <span>Balas via Email</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: STATUS MANAGER & METADATA (4 COLS) -->
        <div class="col-lg-4">
            <!-- 1. Manage Status Card -->
            <div class="card border border-slate-200 rounded-3 shadow-2xs bg-white mb-4">
                <div class="card-header bg-white border-bottom border-slate-100 p-3.5">
                    <h3 class="h6 fw-bold text-slate-900 mb-0" style="font-size: 0.9375rem;">
                        <i class="fas fa-tags text-primary me-2"></i>Kelola Status Pesan
                    </h3>
                </div>
                <div class="card-body p-3.5">
                    <form action="{{ route('admin.contacts.updateStatus', $contact) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-semibold" style="font-size: 0.75rem;">Status Tindak Lanjut</label>
                            <select name="status" class="form-select form-select-sm border-slate-200 rounded-3 text-slate-800 fw-semibold" style="font-size: 0.8125rem;">
                                <option value="unread" {{ $contact->status == 'unread' ? 'selected' : '' }}>📥 Belum Dibaca</option>
                                <option value="read" {{ $contact->status == 'read' ? 'selected' : '' }}>👁️ Sudah Dibaca</option>
                                <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>✅ Sudah Dibalas / Ditanggapi</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary w-100 fw-semibold rounded-3 shadow-2xs py-2" style="font-size: 0.8125rem;">
                            <i class="fas fa-sync me-1.5"></i> Perbarui Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- 2. Customer Contact Details Card -->
            <div class="card border border-slate-200 rounded-3 shadow-2xs bg-white mb-4">
                <div class="card-header bg-white border-bottom border-slate-100 p-3.5">
                    <h3 class="h6 fw-bold text-slate-900 mb-0" style="font-size: 0.9375rem;">
                        <i class="fas fa-address-card text-emerald-600 me-2"></i>Informasi Kontak
                    </h3>
                </div>
                <div class="card-body p-3.5">
                    <div class="d-flex flex-column gap-3 small">
                        <div class="d-flex align-items-start gap-2.5">
                            <div class="rounded-2 bg-slate-100 text-slate-500 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="text-muted" style="font-size: 0.7rem;">Nama Lengkap</div>
                                <div class="fw-bold text-slate-900">{{ $contact->name }}</div>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-2.5">
                            <div class="rounded-2 bg-slate-100 text-slate-500 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="text-muted" style="font-size: 0.7rem;">Email</div>
                                <a href="mailto:{{ $contact->email }}" class="fw-bold text-primary text-decoration-none hover-underline text-truncate d-block">
                                    {{ $contact->email }}
                                </a>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-2.5">
                            <div class="rounded-2 bg-slate-100 text-slate-500 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="text-muted" style="font-size: 0.7rem;">Nomor Telepon / WhatsApp</div>
                                <a href="https://wa.me/{{ $waPhone }}" target="_blank" class="fw-bold text-emerald-600 text-decoration-none hover-underline">
                                    {{ $contact->phone }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. System Audit Metadata Card -->
            <div class="card border border-slate-200 rounded-3 shadow-2xs bg-white">
                <div class="card-header bg-white border-bottom border-slate-100 p-3.5">
                    <h3 class="h6 fw-bold text-slate-900 mb-0" style="font-size: 0.9375rem;">
                        <i class="fas fa-info-circle text-slate-500 me-2"></i>Informasi Sistem
                    </h3>
                </div>
                <div class="card-body p-3.5">
                    <div class="d-flex flex-column gap-2 small text-muted" style="font-size: 0.75rem;">
                        <div class="d-flex justify-content-between">
                            <span>ID Pesan:</span>
                            <strong class="text-slate-800">#{{ $contact->id }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Waktu Dikirim:</span>
                            <strong class="text-slate-800">{{ $contact->created_at->format('d/m/Y H:i') }} WIB</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Pembaruan Terakhir:</span>
                            <strong class="text-slate-800">{{ $contact->updated_at->diffForHumans() }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Rubick Slate & Modern Theme Utility Classes */
.text-slate-900 { color: #0f172a !important; }
.text-slate-800 { color: #1e293b !important; }
.text-slate-700 { color: #334155 !important; }
.text-slate-600 { color: #475569 !important; }
.text-slate-500 { color: #64748b !important; }
.border-slate-100 { border-color: #f1f5f9 !important; }
.border-slate-200 { border-color: #e2e8f0 !important; }
.bg-slate-50 { background-color: #f8fafc !important; }
.bg-slate-100 { background-color: #f1f5f9 !important; }

/* Custom Badge Colors */
.bg-emerald-50 { background-color: #ecfdf5 !important; }
.text-emerald-700 { color: #047857 !important; }
.text-emerald-600 { color: #059669 !important; }
.border-emerald-200 { border-color: #a7f3d0 !important; }

.bg-blue-50 { background-color: #eff6ff !important; }
.text-blue-700 { color: #1d4ed8 !important; }
.text-blue-600 { color: #2563eb !important; }
.border-blue-200 { border-color: #bfdbfe !important; }

.bg-sky-50 { background-color: #f0f9ff !important; }
.text-sky-700 { color: #0369a1 !important; }
.text-sky-600 { color: #0284c7 !important; }
.border-sky-200 { border-color: #bae6fd !important; }

.bg-amber-50 { background-color: #fffbeb !important; }
.text-amber-700 { color: #b45309 !important; }
.border-amber-200 { border-color: #fde68a !important; }

.bg-purple-50 { background-color: #faf5ff !important; }
.text-purple-700 { color: #7e22ce !important; }
.border-purple-200 { border-color: #e9d5ff !important; }

.bg-rose-50 { background-color: #fff1f2 !important; }
.text-rose-700 { color: #be123c !important; }
.border-rose-200 { border-color: #fecdd3 !important; }

.shadow-2xs {
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.04);
}

.hover-primary:hover {
    color: #1b3bbb !important;
}

.hover-underline:hover {
    text-decoration: underline !important;
}

.contact-detail-wrapper {
    animation: fadeInContactDetail 0.3s ease-in-out;
}

@keyframes fadeInContactDetail {
    from { opacity: 0; transform: translateY(6px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection

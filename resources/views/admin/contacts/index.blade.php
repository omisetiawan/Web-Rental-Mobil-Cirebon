@extends('layouts.admin')

@section('title', 'Manajemen Kotak Masuk & Kontak Pelanggan')

@section('content')
<div class="contacts-page-wrapper">
    <!-- Header Section with Action Toolbar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="badge bg-primary-subtle text-primary fw-semibold px-2.5 py-1 rounded-pill" style="font-size: 0.75rem; letter-spacing: 0.03em;">
                    <i class="fas fa-headset me-1"></i> LAYANAN PELANGGAN & INQUIRY
                </span>
                <span class="text-muted" style="font-size: 0.8rem;">•</span>
                <span class="text-muted small">Kotak Masuk Terpadu</span>
            </div>
            <h1 class="h3 fw-bold text-slate-900 mb-1" style="letter-spacing: -0.02em;">Manajemen Kontak & Kotak Pesan Masuk</h1>
            <p class="text-muted small mb-0">Kelola semua pertanyaan sewa, proposal kemitraan, permohonan informasi, dan keluhan pelanggan secara terpusat.</p>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            @if($unreadCount > 0)
                <form action="{{ route('admin.contacts.markAllRead') }}" method="POST" class="d-inline" onsubmit="return confirm('Tandai semua {{ $unreadCount }} pesan yang belum dibaca sebagai sudah dibaca?')">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-secondary px-3 fw-semibold rounded-3 d-flex align-items-center gap-2 shadow-2xs" style="font-size: 0.8125rem; height: 36px;">
                        <i class="fas fa-check-double text-primary"></i>
                        <span>Tandai Semua Dibaca</span>
                    </button>
                </form>
            @endif

            <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-light border border-slate-200 px-3 fw-semibold text-slate-700 rounded-3 d-flex align-items-center gap-1.5 shadow-2xs" style="font-size: 0.8125rem; height: 36px;" title="Muat Ulang Halaman">
                <i class="fas fa-arrows-rotate text-muted"></i>
                <span class="d-none d-sm-inline">Segarkan</span>
            </a>
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

    <!-- 4 KPI SUMMARY CARDS GRID -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Messages -->
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('admin.contacts.index') }}" class="text-decoration-none">
                <div class="card border border-slate-200 rounded-3 shadow-2xs bg-white p-3 h-100 card-kpi-hover {{ !request('status') ? 'border-primary' : '' }}">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted fw-semibold small text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">Total Pesan Masuk</span>
                        <div class="rounded-3 bg-blue-50 text-blue-600 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="fas fa-inbox" style="font-size: 1rem;"></i>
                        </div>
                    </div>
                    <div class="h4 fw-bold text-slate-900 mb-1" style="letter-spacing: -0.02em;">
                        {{ number_format($totalCount) }} <span class="text-muted fw-normal fs-6">Pesan</span>
                    </div>
                    <div class="small text-muted" style="font-size: 0.75rem;">
                        Semua riwayat formulir & inquiry kontak
                    </div>
                </div>
            </a>
        </div>

        <!-- 2. Unread Messages -->
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('admin.contacts.index', ['status' => 'unread']) }}" class="text-decoration-none">
                <div class="card border border-slate-200 rounded-3 shadow-2xs bg-white p-3 h-100 card-kpi-hover {{ request('status') == 'unread' ? 'border-amber-400' : '' }}">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted fw-semibold small text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">Belum Dibaca</span>
                        <div class="rounded-3 bg-amber-50 text-amber-600 d-flex align-items-center justify-content-center position-relative" style="width: 36px; height: 36px;">
                            <i class="fas fa-envelope" style="font-size: 1rem;"></i>
                            @if($unreadCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle p-1.5 bg-danger border border-white rounded-circle">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="h4 fw-bold text-amber-600 mb-1" style="letter-spacing: -0.02em;">
                        {{ number_format($unreadCount) }} <span class="text-muted fw-normal fs-6">Pesan Baru</span>
                    </div>
                    <div class="small text-muted" style="font-size: 0.75rem;">
                        @if($unreadCount > 0)
                            <span class="text-danger fw-semibold"><i class="fas fa-circle-exclamation me-1"></i> Perlu perhatian admin</span>
                        @else
                            <span class="text-success"><i class="fas fa-check-circle me-1"></i> Semua pesan telah ditinjau</span>
                        @endif
                    </div>
                </div>
            </a>
        </div>

        <!-- 3. Read Messages -->
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('admin.contacts.index', ['status' => 'read']) }}" class="text-decoration-none">
                <div class="card border border-slate-200 rounded-3 shadow-2xs bg-white p-3 h-100 card-kpi-hover {{ request('status') == 'read' ? 'border-sky-400' : '' }}">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted fw-semibold small text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">Sudah Dibaca</span>
                        <div class="rounded-3 bg-sky-50 text-sky-600 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="fas fa-envelope-open" style="font-size: 1rem;"></i>
                        </div>
                    </div>
                    <div class="h4 fw-bold text-slate-900 mb-1" style="letter-spacing: -0.02em;">
                        {{ number_format($readCount) }} <span class="text-muted fw-normal fs-6">Pesan</span>
                    </div>
                    <div class="small text-muted" style="font-size: 0.75rem;">
                        Telah dibuka & diverifikasi oleh tim
                    </div>
                </div>
            </a>
        </div>

        <!-- 4. Replied Messages -->
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('admin.contacts.index', ['status' => 'replied']) }}" class="text-decoration-none">
                <div class="card border border-slate-200 rounded-3 shadow-2xs bg-white p-3 h-100 card-kpi-hover {{ request('status') == 'replied' ? 'border-emerald-400' : '' }}">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="text-muted fw-semibold small text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.05em;">Sudah Dibalas</span>
                        <div class="rounded-3 bg-emerald-50 text-emerald-600 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="fas fa-reply-all" style="font-size: 1rem;"></i>
                        </div>
                    </div>
                    <div class="h4 fw-bold text-emerald-600 mb-1" style="letter-spacing: -0.02em;">
                        {{ number_format($repliedCount) }} <span class="text-muted fw-normal fs-6">Selesai</span>
                    </div>
                    <div class="small text-muted" style="font-size: 0.75rem;">
                        Telah ditindaklanjuti via WA / Email
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- MAIN CONTACTS TABLE CARD -->
    <div class="card border border-slate-200 rounded-3 shadow-2xs bg-white overflow-hidden mb-4">
        <!-- Filter & Search Toolbar -->
        <div class="card-header bg-white border-bottom border-slate-100 p-3.5">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                <!-- Status Tab Pills -->
                <div class="nav nav-pills gap-1.5" role="tablist">
                    <a href="{{ route('admin.contacts.index', array_merge(request()->except('status', 'page'), [])) }}" 
                       class="nav-link btn-tab-pill {{ !request('status') ? 'active' : '' }}">
                        Semua
                        <span class="badge bg-slate-200 text-slate-700 rounded-pill ms-1 px-1.5">{{ $totalCount }}</span>
                    </a>
                    <a href="{{ route('admin.contacts.index', array_merge(request()->except('status', 'page'), ['status' => 'unread'])) }}" 
                       class="nav-link btn-tab-pill {{ request('status') == 'unread' ? 'active' : '' }}">
                        <span class="indicator-dot bg-amber-500 rounded-circle me-1" style="width: 6px; height: 6px; display: inline-block;"></span>
                        Belum Dibaca
                        <span class="badge bg-amber-100 text-amber-800 rounded-pill ms-1 px-1.5">{{ $unreadCount }}</span>
                    </a>
                    <a href="{{ route('admin.contacts.index', array_merge(request()->except('status', 'page'), ['status' => 'read'])) }}" 
                       class="nav-link btn-tab-pill {{ request('status') == 'read' ? 'active' : '' }}">
                        Sudah Dibaca
                        <span class="badge bg-slate-200 text-slate-700 rounded-pill ms-1 px-1.5">{{ $readCount }}</span>
                    </a>
                    <a href="{{ route('admin.contacts.index', array_merge(request()->except('status', 'page'), ['status' => 'replied'])) }}" 
                       class="nav-link btn-tab-pill {{ request('status') == 'replied' ? 'active' : '' }}">
                        Sudah Dibalas
                        <span class="badge bg-emerald-100 text-emerald-800 rounded-pill ms-1 px-1.5">{{ $repliedCount }}</span>
                    </a>
                </div>

                <!-- Search & Purpose Filter Form -->
                <form action="{{ route('admin.contacts.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2">
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif

                    <!-- Purpose Filter -->
                    <select name="purpose" class="form-select form-select-sm border-slate-200 rounded-3 text-slate-700" style="font-size: 0.8125rem; width: auto; min-width: 140px;" onchange="this.form.submit()">
                        <option value="">Semua Keperluan</option>
                        <option value="booking" {{ request('purpose') == 'booking' ? 'selected' : '' }}>Booking Mobil</option>
                        <option value="info" {{ request('purpose') == 'info' ? 'selected' : '' }}>Informasi</option>
                        <option value="partnership" {{ request('purpose') == 'partnership' ? 'selected' : '' }}>Kerjasama</option>
                        <option value="complaint" {{ request('purpose') == 'complaint' ? 'selected' : '' }}>Keluhan / Komplain</option>
                        <option value="other" {{ request('purpose') == 'other' ? 'selected' : '' }}>Lainnya</option>
                    </select>

                    <!-- Search Input -->
                    <div class="input-group input-group-sm shadow-2xs rounded-3 overflow-hidden border border-slate-200 bg-white" style="min-width: 220px;">
                        <span class="input-group-text bg-white border-0 text-muted ps-2.5 pe-1">
                            <i class="fas fa-search text-slate-400" style="font-size: 0.8rem;"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm border-0 ps-1.5" placeholder="Cari nama, email, pesan..." style="font-size: 0.8125rem;">
                        @if(request('search') || request('purpose'))
                            <a href="{{ route('admin.contacts.index', request('status') ? ['status' => request('status')] : []) }}" class="btn btn-sm btn-light border-0 px-2 text-danger" title="Hapus Filter">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                        <button type="submit" class="btn btn-sm btn-light border-start border-slate-200 px-2.5 text-slate-700 fw-semibold" style="font-size: 0.75rem;">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bulk Action Floating Bar (Reveals when items checked) -->
        <form id="bulkActionForm" action="{{ route('admin.contacts.bulkAction') }}" method="POST">
            @csrf
            <div id="bulkActionBar" class="p-2.5 bg-slate-900 text-white d-none align-items-center justify-content-between px-3">
                <div class="d-flex align-items-center gap-2 small">
                    <i class="fas fa-check-square text-primary"></i>
                    <span><strong id="selectedCount">0</strong> pesan dipilih:</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <button type="submit" name="action" value="mark_read" class="btn btn-xs btn-outline-light text-white py-1 px-2.5 fw-semibold rounded" style="font-size: 0.75rem;">
                        <i class="fas fa-envelope-open me-1 text-sky-400"></i> Tandai Dibaca
                    </button>
                    <button type="submit" name="action" value="mark_replied" class="btn btn-xs btn-outline-light text-white py-1 px-2.5 fw-semibold rounded" style="font-size: 0.75rem;">
                        <i class="fas fa-reply me-1 text-emerald-400"></i> Tandai Dibalas
                    </button>
                    <button type="submit" name="action" value="delete" class="btn btn-xs btn-danger py-1 px-2.5 fw-semibold rounded" style="font-size: 0.75rem;" onclick="return confirm('Yakin ingin menghapus semua pesan terpilih?')">
                        <i class="fas fa-trash me-1"></i> Hapus
                    </button>
                </div>
            </div>

            <!-- Table Content -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="font-size: 0.8125rem;">
                    <thead class="bg-slate-50 text-slate-600 border-bottom border-slate-100" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <tr>
                            <th class="ps-3.5 py-3" style="width: 38px;">
                                <input type="checkbox" id="selectAllCheckbox" class="form-check-input" title="Pilih Semua">
                            </th>
                            <th class="py-3" style="min-width: 220px;">Pengirim & Kontak</th>
                            <th class="py-3" style="min-width: 140px;">Keperluan</th>
                            <th class="py-3" style="min-width: 260px;">Cuplikan Pesan</th>
                            <th class="py-3" style="min-width: 150px;">Status Tindak Lanjut</th>
                            <th class="py-3" style="min-width: 140px;">Waktu Masuk</th>
                            <th class="text-end pe-3.5 py-3" style="min-width: 130px;">Aksi Cepat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($contacts as $contact)
                        <tr class="{{ $contact->status == 'unread' ? 'bg-amber-50-subtle' : '' }} contact-row-item">
                            <td class="ps-3.5 py-3">
                                <input type="checkbox" name="contacts[]" value="{{ $contact->id }}" class="form-check-input contact-checkbox">
                            </td>
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white flex-shrink-0 shadow-2xs" 
                                         style="width: 36px; height: 36px; font-size: 0.8rem; background-color: {{ ['#1b3bbb', '#0284c7', '#059669', '#d97706', '#7c3aed', '#db2777'][$loop->index % 6] }};">
                                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                                    </div>
                                    <div class="overflow-hidden">
                                        <div class="fw-bold text-slate-900 text-truncate d-flex align-items-center gap-1.5" style="max-width: 200px;">
                                            <a href="{{ route('admin.contacts.show', $contact) }}" class="text-slate-900 text-decoration-none hover-primary">
                                                {{ $contact->name }}
                                            </a>
                                            @if($contact->status == 'unread')
                                                <span class="badge bg-danger rounded-circle p-1" title="Pesan Belum Dibaca" style="width: 6px; height: 6px;"></span>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center gap-2 text-muted small mt-0.5" style="font-size: 0.725rem;">
                                            <a href="mailto:{{ $contact->email }}" class="text-muted text-decoration-none hover-underline text-truncate" style="max-width: 140px;">
                                                <i class="far fa-envelope me-1 text-slate-400"></i>{{ $contact->email }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                @if($contact->purpose == 'booking')
                                    <span class="badge bg-sky-50 text-sky-700 border border-sky-200 px-2 py-1 rounded fw-semibold" style="font-size: 0.725rem;">
                                        <i class="fas fa-calendar-check me-1 text-sky-600"></i> Booking Mobil
                                    </span>
                                @elseif($contact->purpose == 'partnership')
                                    <span class="badge bg-purple-50 text-purple-700 border border-purple-200 px-2 py-1 rounded fw-semibold" style="font-size: 0.725rem;">
                                        <i class="fas fa-handshake me-1 text-purple-600"></i> Kerjasama
                                    </span>
                                @elseif($contact->purpose == 'complaint')
                                    <span class="badge bg-rose-50 text-rose-700 border border-rose-200 px-2 py-1 rounded fw-semibold" style="font-size: 0.725rem;">
                                        <i class="fas fa-triangle-exclamation me-1 text-rose-600"></i> Keluhan
                                    </span>
                                @elseif($contact->purpose == 'info')
                                    <span class="badge bg-blue-50 text-blue-700 border border-blue-200 px-2 py-1 rounded fw-semibold" style="font-size: 0.725rem;">
                                        <i class="fas fa-circle-info me-1 text-blue-600"></i> Informasi
                                    </span>
                                @else
                                    <span class="badge bg-slate-100 text-slate-700 border border-slate-200 px-2 py-1 rounded fw-semibold" style="font-size: 0.725rem;">
                                        <i class="fas fa-question-circle me-1 text-slate-500"></i> {{ $contact->purpose_label }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3">
                                <div class="text-slate-700 text-truncate" style="max-width: 320px;" title="{{ $contact->message }}">
                                    {{ Str::limit($contact->message, 75) }}
                                </div>
                                <div class="mt-1">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" class="text-primary text-decoration-none small fw-semibold" style="font-size: 0.725rem;">
                                        Baca selengkapnya <i class="fas fa-arrow-right ms-0.5" style="font-size: 0.65rem;"></i>
                                    </a>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="dropdown">
                                    <button class="btn btn-sm py-1 px-2.5 rounded-pill dropdown-toggle d-inline-flex align-items-center gap-1.5 fw-semibold border" 
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.725rem;
                                            @if($contact->status == 'unread') background-color: #fffbeb; color: #b45309; border-color: #fde68a !important;
                                            @elseif($contact->status == 'read') background-color: #eff6ff; color: #1d4ed8; border-color: #bfdbfe !important;
                                            @else background-color: #ecfdf5; color: #047857; border-color: #a7f3d0 !important; @endif">
                                        @if($contact->status == 'unread')
                                            <i class="fas fa-circle text-amber-500" style="font-size: 0.45rem;"></i> Belum Dibaca
                                        @elseif($contact->status == 'read')
                                            <i class="fas fa-circle text-blue-500" style="font-size: 0.45rem;"></i> Sudah Dibaca
                                        @else
                                            <i class="fas fa-circle text-emerald-500" style="font-size: 0.45rem;"></i> Sudah Dibalas
                                        @endif
                                    </button>
                                    <ul class="dropdown-menu shadow-lg border-slate-200 rounded-3 py-1" style="font-size: 0.775rem;">
                                        <li><h6 class="dropdown-header text-uppercase text-muted fw-bold" style="font-size: 0.65rem;">Ubah Status Pesan</h6></li>
                                        <li>
                                            <form action="{{ route('admin.contacts.updateStatus', $contact) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="unread">
                                                <button type="submit" class="dropdown-item py-1.5 d-flex align-items-center gap-2 {{ $contact->status == 'unread' ? 'active' : '' }}">
                                                    <i class="fas fa-circle text-amber-500" style="font-size: 0.45rem;"></i> Belum Dibaca
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.contacts.updateStatus', $contact) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="read">
                                                <button type="submit" class="dropdown-item py-1.5 d-flex align-items-center gap-2 {{ $contact->status == 'read' ? 'active' : '' }}">
                                                    <i class="fas fa-circle text-blue-500" style="font-size: 0.45rem;"></i> Sudah Dibaca
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.contacts.updateStatus', $contact) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="replied">
                                                <button type="submit" class="dropdown-item py-1.5 d-flex align-items-center gap-2 {{ $contact->status == 'replied' ? 'active' : '' }}">
                                                    <i class="fas fa-circle text-emerald-500" style="font-size: 0.45rem;"></i> Sudah Dibalas
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="py-3">
                                <div class="text-slate-800 fw-semibold" style="font-size: 0.75rem;">{{ $contact->created_at->translatedFormat('d M Y') }}</div>
                                <div class="text-muted small" style="font-size: 0.7rem;">
                                    <i class="far fa-clock me-1"></i>{{ $contact->created_at->format('H:i') }} WIB ({{ $contact->created_at->diffForHumans() }})
                                </div>
                            </td>
                            <td class="text-end pe-3.5 py-3">
                                @php
                                    $waPhone = preg_replace('/[^0-9]/', '', $contact->phone);
                                    if (str_starts_with($waPhone, '0')) {
                                        $waPhone = '62' . substr($waPhone, 1);
                                    }
                                    $waDraft = urlencode("Halo Kak " . $contact->name . ", kami dari Admin RentGo Cirebon merespons pertanyaan Anda mengenai " . $contact->purpose_label . "...");
                                @endphp

                                <div class="d-flex align-items-center justify-content-end gap-1.5">
                                    <!-- View Detail -->
                                    <a href="{{ route('admin.contacts.show', $contact) }}" 
                                       class="btn btn-sm btn-light border border-slate-200 text-slate-700 p-1.5 rounded-2" 
                                       title="Lihat Detail Pesan" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-eye" style="font-size: 0.8rem;"></i>
                                    </a>

                                    <!-- Direct WhatsApp Chat -->
                                    @if($contact->phone)
                                        <a href="https://wa.me/{{ $waPhone }}?text={{ $waDraft }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-light border border-emerald-200 text-emerald-700 p-1.5 rounded-2" 
                                           title="Balas Langsung via WhatsApp" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; background-color: #ecfdf5;">
                                            <i class="fab fa-whatsapp" style="font-size: 0.95rem;"></i>
                                        </a>
                                    @endif

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pesan dari {{ $contact->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-light border border-slate-200 text-danger p-1.5 rounded-2" 
                                                title="Hapus Pesan" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                            <i class="far fa-trash-can" style="font-size: 0.8rem;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <div class="rounded-circle bg-slate-100 text-slate-400 d-inline-flex align-items-center justify-content-center mb-3" style="width: 56px; height: 56px;">
                                        <i class="far fa-envelope-open" style="font-size: 1.5rem;"></i>
                                    </div>
                                    <h5 class="fw-bold text-slate-800 mb-1" style="font-size: 0.95rem;">Tidak Ada Pesan Masuk</h5>
                                    <p class="text-muted small mb-3">Tidak ditemukan data pesan yang sesuai dengan kriteria filter saat ini.</p>
                                    @if(request('status') || request('purpose') || request('search'))
                                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-primary px-3 rounded-3 fw-semibold">
                                            Reset Semua Filter
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <!-- Pagination Section -->
        @if($contacts->hasPages())
            <div class="card-footer bg-white border-top border-slate-100 p-3.5 d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2">
                <div class="text-muted small" style="font-size: 0.775rem;">
                    Menampilkan <strong>{{ $contacts->firstItem() }}</strong> sampai <strong>{{ $contacts->lastItem() }}</strong> dari <strong>{{ $contacts->total() }}</strong> pesan
                </div>
                <div>
                    {{ $contacts->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
</div>

<style>
/* Rubick Palette & Utility Classes */
.text-slate-900 { color: #0f172a !important; }
.text-slate-800 { color: #1e293b !important; }
.text-slate-700 { color: #334155 !important; }
.text-slate-600 { color: #475569 !important; }
.text-slate-400 { color: #94a3b8 !important; }
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
.text-amber-600 { color: #d97706 !important; }
.border-amber-200 { border-color: #fde68a !important; }

.bg-purple-50 { background-color: #faf5ff !important; }
.text-purple-700 { color: #7e22ce !important; }
.border-purple-200 { border-color: #e9d5ff !important; }

.bg-rose-50 { background-color: #fff1f2 !important; }
.text-rose-700 { color: #be123c !important; }
.border-rose-200 { border-color: #fecdd3 !important; }

.bg-amber-50-subtle {
    background-color: #fffdf5 !important;
}

.shadow-2xs {
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.04);
}

.card-kpi-hover {
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}
.card-kpi-hover:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px 0 rgba(15, 23, 42, 0.06);
}

.btn-tab-pill {
    font-size: 0.8125rem;
    padding: 6px 12px;
    border-radius: 6px;
    color: #475569;
    font-weight: 500;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}
.btn-tab-pill:hover {
    background-color: #f1f5f9;
    color: #0f172a;
}
.btn-tab-pill.active {
    background-color: #eff6ff !important;
    color: #1d4ed8 !important;
    font-weight: 700;
    border-color: #bfdbfe;
}

.hover-primary:hover {
    color: #1b3bbb !important;
}

.hover-underline:hover {
    text-decoration: underline !important;
}

.contacts-page-wrapper {
    animation: fadeInContacts 0.3s ease-in-out;
}

@keyframes fadeInContacts {
    from { opacity: 0; transform: translateY(6px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    const bulkBar = document.getElementById('bulkActionBar');
    const selectedCount = document.getElementById('selectedCount');

    function updateBulkBar() {
        const checked = document.querySelectorAll('.contact-checkbox:checked');
        if (selectedCount) {
            selectedCount.textContent = checked.length;
        }
        if (bulkBar) {
            if (checked.length > 0) {
                bulkBar.classList.remove('d-none');
                bulkBar.classList.add('d-flex');
            } else {
                bulkBar.classList.add('d-none');
                bulkBar.classList.remove('d-flex');
            }
        }
    }

    if (selectAll) {
        selectAll.addEventListener('change', function() {
            checkboxes.forEach(cb => {
                cb.checked = selectAll.checked;
            });
            updateBulkBar();
        });
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            if (!this.checked && selectAll) {
                selectAll.checked = false;
            }
            updateBulkBar();
        });
    });
});
</script>
@endsection

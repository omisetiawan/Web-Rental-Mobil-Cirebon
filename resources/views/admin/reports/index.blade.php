@extends('layouts.admin')

@section('title', 'Laporan & Ekspor')

@section('content')
<div class="container-fluid p-0">

    <!-- ----------------------------------------------------
         1. PAGE HEADER CARD WITH INTEGRATED FILTER TOOLBAR
    ---------------------------------------------------- -->
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 38px; height: 38px; background-color: var(--rubick-blue-light); color: var(--rubick-blue); flex-shrink: 0;">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-0">Laporan Operasional & Keuangan</h4>
                </div>
                <p class="text-muted small mb-0 ms-md-4 ps-md-3">
                    Rekapitulasi data transaksi booking, performa pendapatan sewa, dan utilisasi armada mobil secara terpusat.
                </p>
            </div>
            
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <!-- Clean Bootstrap Input Groups for Date Filtering -->
                <form action="{{ route('admin.reports.index') }}" method="GET" class="d-flex align-items-center gap-2 flex-wrap m-0">
                    <div class="input-group input-group-sm" style="width: auto;">
                        <span class="input-group-text bg-light text-secondary border-end-0 fw-semibold" style="font-size: 0.78rem;">
                            <i class="far fa-calendar-alt text-primary me-1.5"></i> Dari
                        </span>
                        <input type="date" name="start_date" value="{{ request('start_date', $startDate) }}" 
                               class="form-control form-control-sm border-start-0 ps-1" 
                               style="font-size: 0.8125rem; min-width: 140px;">
                    </div>
                    <div class="input-group input-group-sm" style="width: auto;">
                        <span class="input-group-text bg-light text-secondary border-end-0 fw-semibold" style="font-size: 0.78rem;">
                            <i class="far fa-calendar-check text-primary me-1.5"></i> Sampai
                        </span>
                        <input type="date" name="end_date" value="{{ request('end_date', $endDate) }}" 
                               class="form-control form-control-sm border-start-0 ps-1" 
                               style="font-size: 0.8125rem; min-width: 140px;">
                    </div>
                    <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1.5">
                        <i class="fas fa-filter"></i>
                        <span>Filter</span>
                    </button>
                    @if(request('start_date') || request('end_date'))
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-rubick-outline text-danger d-inline-flex align-items-center gap-1">
                            <i class="fas fa-rotate-left"></i>
                            <span>Reset</span>
                        </a>
                    @endif
                    <button type="button" class="btn btn-rubick-outline d-inline-flex align-items-center gap-1.5 text-dark" data-bs-toggle="modal" data-bs-target="#exportPdfModal">
                        <i class="fas fa-file-pdf text-danger"></i>
                        <span>Cetak PDF</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-3 d-flex align-items-center gap-3 py-2.5 px-3 mb-4" role="alert">
            <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; font-size: 0.85rem;">
                <i class="fas fa-exclamation"></i>
            </div>
            <div class="small flex-grow-1 text-danger-emphasis fw-medium">{{ session('error') }}</div>
            <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- ----------------------------------------------------
         2. CORE OPERATIONAL & FINANCIAL KPI GRID (4 CARDS)
    ---------------------------------------------------- -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Pendapatan -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Total Pendapatan</span>
                        <h3 class="fw-extrabold text-dark mb-0 mt-1" style="font-size: 1.55rem; letter-spacing: -0.02em;">
                            Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}
                        </h3>
                        <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                            Transaksi disetujui & selesai
                        </small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 48px; height: 48px; background-color: var(--rubick-blue-light); color: var(--rubick-blue); font-size: 1.25rem;">
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Total Booking -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Total Booking</span>
                        <h3 class="fw-extrabold text-dark mb-0 mt-1" style="font-size: 1.55rem; letter-spacing: -0.02em;">
                            {{ number_format($stats['total_bookings']) }} <span class="fs-6 fw-normal text-muted">Pesanan</span>
                        </h3>
                        <small class="d-flex align-items-center gap-1.5 mt-1" style="font-size: 0.75rem;">
                            <span class="text-success fw-semibold">{{ $stats['completed_bookings'] }} Selesai</span>
                            <span class="text-muted">•</span>
                            <span class="text-primary fw-semibold">{{ $stats['approved_bookings'] }} Aktif</span>
                            <span class="text-muted">•</span>
                            <span class="text-warning fw-semibold">{{ $stats['pending_bookings'] }} Menunggu</span>
                        </small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 48px; height: 48px; background-color: #ecfdf5; color: #059669; font-size: 1.25rem;">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Rata-rata Nilai Booking -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Rata-Rata Nilai Booking</span>
                        <h3 class="fw-extrabold text-dark mb-0 mt-1" style="font-size: 1.55rem; letter-spacing: -0.02em;">
                            Rp {{ number_format($stats['average_order_value'], 0, ',', '.') }}
                        </h3>
                        <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                            Rata-rata durasi: <strong class="text-dark">{{ $stats['average_duration'] }} hari</strong>
                        </small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 48px; height: 48px; background-color: #f5f3ff; color: #7c3aed; font-size: 1.25rem;">
                        <i class="fas fa-receipt"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Utilisasi Armada -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Utilisasi Armada</span>
                        <h3 class="fw-extrabold text-dark mb-0 mt-1" style="font-size: 1.55rem; letter-spacing: -0.02em;">
                            {{ $stats['utilization_rate'] }}%
                        </h3>
                        <small class="d-flex align-items-center gap-1.5 mt-1" style="font-size: 0.75rem;">
                            <span class="text-warning fw-semibold">{{ $stats['rented_cars'] }} Disewa</span>
                            <span class="text-muted">•</span>
                            <span class="text-success fw-semibold">{{ $stats['available_cars'] }} Siap</span>
                            <span class="text-muted">•</span>
                            <span class="text-muted">{{ $stats['maintenance_cars'] }} Bengkel</span>
                        </small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" 
                         style="width: 48px; height: 48px; background-color: #fffbeb; color: #d97706; font-size: 1.25rem;">
                        <i class="fas fa-gauge-high"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------
         3. ANALYTICAL CHARTS GRID (6 CARDS - 5W1H LOGIC)
    ---------------------------------------------------- -->

    <!-- ROW 1: Finansial & Karakteristik Pelanggan -->
    <div class="row g-4 mb-4">
        <!-- Chart 1: Financial & Volume Trajectory -->
        <div class="col-12 col-lg-6">
            <div class="card mb-0 border-0 shadow-sm h-100 d-flex flex-column justify-content-between" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-3.5 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px; background-color: #eff6ff; color: #1b3bbb; font-size: 0.875rem;">
                            <i class="fas fa-chart-area"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9375rem;">Tren Pertumbuhan Finansial & Volume Transaksi</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">Pergerakan omzet dan kuantitas pemesanan dalam 6 bulan terakhir</small>
                        </div>
                    </div>
                    <span class="badge bg-light text-secondary border px-2.5 py-1 rounded-pill" style="font-size: 0.7rem;">
                        Omzet & Volume
                    </span>
                </div>
                <div class="card-body p-3.5">
                    <div style="height: 260px; position: relative;">
                        <canvas id="financialTrajectoryChart"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-light border-top px-3.5 py-2.5" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                    <div class="d-flex align-items-center justify-content-between small text-muted" style="font-size: 0.75rem;">
                        <div>Total Akumulasi: <strong class="text-dark">Rp {{ number_format(array_sum($revenueData), 0, ',', '.') }}</strong></div>
                        <div>Total Pemesanan: <strong class="text-dark">{{ array_sum($bookingCountData) }} Trip</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart 2: Customer Profiling & Rental Duration -->
        <div class="col-12 col-lg-6">
            <div class="card mb-0 border-0 shadow-sm h-100 d-flex flex-column justify-content-between" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-3.5 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px; background-color: #ecfdf5; color: #059669; font-size: 0.875rem;">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9375rem;">Segmentasi Pelanggan & Durasi Pemesanan</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">Distribusi durasi sewa harian, dinas bisnis, wisata, dan mingguan</small>
                        </div>
                    </div>
                    <span class="badge bg-light text-secondary border px-2.5 py-1 rounded-pill" style="font-size: 0.7rem;">
                        Durasi & Loyalitas
                    </span>
                </div>
                <div class="card-body p-3.5">
                    <div style="height: 260px; position: relative;">
                        <canvas id="customerDemographicsChart"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-light border-top px-3.5 py-2.5" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                    <div class="d-flex align-items-center justify-content-between small text-muted" style="font-size: 0.75rem;">
                        <div>Pelanggan Unik: <strong class="text-dark">{{ $customerSegments['unique_customers'] }} Orang</strong></div>
                        <div>Repeat Order: <strong class="text-dark">{{ $customerSegments['repeat_customers'] }} Klien</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 2: Koridor Rute & Siklus Waktu -->
    <div class="row g-4 mb-4">
        <!-- Chart 3: Regional Corridor & Dispatch Coverage -->
        <div class="col-12 col-lg-6">
            <div class="card mb-0 border-0 shadow-sm h-100 d-flex flex-column justify-content-between" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-3.5 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px; background-color: #f0f9ff; color: #0284c7; font-size: 0.875rem;">
                            <i class="fas fa-map-location-dot"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9375rem;">Distribusi Destinasi & Koridor Rute</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">Sebaran jangkauan rute operasional dan titik tujuan sewa</small>
                        </div>
                    </div>
                    <span class="badge bg-light text-secondary border px-2.5 py-1 rounded-pill" style="font-size: 0.7rem;">
                        Wilayah Operasi
                    </span>
                </div>
                <div class="card-body p-3.5">
                    <div style="height: 260px; position: relative;">
                        <canvas id="regionalRoutesChart"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-light border-top px-3.5 py-2.5" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                    <div class="d-flex align-items-center justify-content-between small text-muted" style="font-size: 0.75rem;">
                        <div>Titik Antar-Jemput: <strong class="text-dark">{{ $regionalCorridors['primary_hub'] }}</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart 4: Weekly Temporal Demand Fluctuations -->
        <div class="col-12 col-lg-6">
            <div class="card mb-0 border-0 shadow-sm h-100 d-flex flex-column justify-content-between" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-3.5 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px; background-color: #fffbeb; color: #d97706; font-size: 0.875rem;">
                            <i class="fas fa-calendar-week"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9375rem;">Siklus Pola Permintaan Mingguan</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">Fluktuasi volume pemesanan hari Senin s/d Minggu</small>
                        </div>
                    </div>
                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2.5 py-1 rounded-pill" style="font-size: 0.7rem;">
                        Puncak: {{ $weeklyDemand['peak_day'] }}
                    </span>
                </div>
                <div class="card-body p-3.5">
                    <div style="height: 260px; position: relative;">
                        <canvas id="temporalDemandChart"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-light border-top px-3.5 py-2.5" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                    <div class="d-flex align-items-center justify-content-between small text-muted" style="font-size: 0.75rem;">
                        <div>Konsentrasi Permintaan: <strong class="text-dark">Akhir Pekan (Jumat - Minggu)</strong></div>
                        <div>Hari Tersibuk: <strong class="text-dark">{{ $weeklyDemand['peak_day'] }}</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ROW 3: Preferensi Kategori Armada & Kesiapan Operasional -->
    <div class="row g-4 mb-4">
        <!-- Chart 5: Fleet Category Preferences & Motive -->
        <div class="col-12 col-lg-6">
            <div class="card mb-0 border-0 shadow-sm h-100 d-flex flex-column justify-content-between" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-3.5 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px; background-color: #f5f3ff; color: #7c3aed; font-size: 0.875rem;">
                            <i class="fas fa-car-side"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9375rem;">Preferensi Kategori Armada & Kebutuhan Sewa</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">Proporsi pemesanan mobil berdasarkan tipe kategori unit</small>
                        </div>
                    </div>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 rounded-pill" style="font-size: 0.7rem;">
                        Favorit: {{ $categoryPreferences['top_category'] }}
                    </span>
                </div>
                <div class="card-body p-3.5">
                    <div style="height: 260px; position: relative;">
                        <canvas id="fleetPreferenceChart"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-light border-top px-3.5 py-2.5" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                    <div class="d-flex align-items-center justify-content-between small text-muted" style="font-size: 0.75rem;">
                        <div>Kategori Dominan: <strong class="text-dark">{{ $categoryPreferences['top_category'] }}</strong></div>
                        <div>Total Segmen: <strong class="text-dark">4 Kategori Mobil</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart 6: Transaction Fulfillment & Fleet Readiness -->
        <div class="col-12 col-lg-6">
            <div class="card mb-0 border-0 shadow-sm h-100 d-flex flex-column justify-content-between" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-3.5 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px; background-color: #fff1f2; color: #e11d48; font-size: 0.875rem;">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9375rem;">Status Pemenuhan Transaksi & Kesiapan Unit</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">Rasio status penyelesaian booking dan kesiapan armada pool</small>
                        </div>
                    </div>
                    <span class="badge bg-light text-secondary border px-2.5 py-1 rounded-pill" style="font-size: 0.7rem;">
                        Kesiapan Pool
                    </span>
                </div>
                <div class="card-body p-3.5">
                    <div style="height: 260px; position: relative;">
                        <canvas id="acquisitionPaymentChart"></canvas>
                    </div>
                </div>
                <div class="card-footer bg-light border-top px-3.5 py-2.5" style="border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                    <div class="d-flex align-items-center justify-content-between small text-muted" style="font-size: 0.75rem;">
                        <div>Unit Ready: <strong class="text-success">{{ $fleetReadiness['available'] }} Unit</strong></div>
                        <div>Sedang Disewa: <strong class="text-warning">{{ $fleetReadiness['rented'] }} Unit</strong></div>
                        <div>Transmisi Otomatis: <strong class="text-dark">{{ $fleetReadiness['automatic'] }} Unit</strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------
         4. DATA TABLES: POPULAR CARS & RECENT TRANSACTIONS
    ---------------------------------------------------- -->
    <div class="row g-4 mb-4">
        <!-- Most Popular Vehicles -->
        <div class="col-lg-5">
            <div class="card mb-0 border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-3.5 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px; background-color: #fffbeb; color: #d97706; font-size: 0.875rem;">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9375rem;">Armada Terpopuler</h6>
                            <small class="text-muted">Unit dengan frekuensi sewa tertinggi</small>
                        </div>
                    </div>
                    <a href="{{ route('admin.cars.index') }}" class="btn btn-sm btn-rubick-outline px-2.5 py-1">
                        Semua Mobil
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive border-0">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.8125rem;">
                            <thead class="bg-light text-secondary border-bottom" style="font-size: 0.7rem; text-transform: uppercase;">
                                <tr>
                                    <th class="ps-3.5 py-2.5">Kendaraan</th>
                                    <th class="py-2.5">Tarif</th>
                                    <th class="text-center py-2.5">Frekuensi</th>
                                    <th class="text-end pe-3.5 py-2.5">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($popularCars as $car)
                                <tr>
                                    <td class="ps-3.5 py-2.5">
                                        <div class="fw-bold text-dark">{{ $car->brand }} {{ $car->model }}</div>
                                        <div class="text-muted small" style="font-size: 0.7rem;">{{ $car->plate_number }} • {{ $car->category }}</div>
                                    </td>
                                    <td class="py-2.5">
                                        <div class="fw-semibold text-dark">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="text-center py-2.5">
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-0.5 rounded-pill fw-bold">
                                            {{ $car->bookings_count }}x
                                        </span>
                                    </td>
                                    <td class="text-end pe-3.5 py-2.5">
                                        @if($car->status == 'available')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5 rounded-pill">Ready</span>
                                        @elseif($car->status == 'rented')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-0.5 rounded-pill">Disewa</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-0.5 rounded-pill">Servis</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted small">Belum ada data armada</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Booking Transactions -->
        <div class="col-lg-7">
            <div class="card mb-0 border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-3.5 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle d-flex align-items-center justify-content-center" 
                             style="width: 32px; height: 32px; background-color: var(--rubick-blue-light); color: var(--rubick-blue); font-size: 0.875rem;">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-size: 0.9375rem;">Riwayat Transaksi Booking</h6>
                            <small class="text-muted">Data transaksi sesuai periode filter</small>
                        </div>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-rubick-outline px-2.5 py-1">
                        Kelola Booking
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive border-0">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.8125rem;">
                            <thead class="bg-light text-secondary border-bottom" style="font-size: 0.7rem; text-transform: uppercase;">
                                <tr>
                                    <th class="ps-3.5 py-2.5">ID & Pelanggan</th>
                                    <th class="py-2.5">Mobil</th>
                                    <th class="py-2.5">Durasi</th>
                                    <th class="py-2.5">Total Tarif</th>
                                    <th class="text-end pe-3.5 py-2.5">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentBookings as $b)
                                <tr>
                                    <td class="ps-3.5 py-2.5">
                                        <div class="fw-bold text-dark">#{{ $b->id }} - {{ $b->customer_name }}</div>
                                        <div class="text-muted small" style="font-size: 0.7rem;">{{ $b->customer_phone }}</div>
                                    </td>
                                    <td class="py-2.5">
                                        <div class="text-dark fw-medium">{{ $b->car ? ($b->car->brand . ' ' . $b->car->model) : '-' }}</div>
                                    </td>
                                    <td class="py-2.5">
                                        <span class="text-secondary">{{ $b->duration }} Hari</span>
                                    </td>
                                    <td class="py-2.5">
                                        <div class="fw-bold text-dark">Rp {{ number_format($b->total_price, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="text-end pe-3.5 py-2.5">
                                        @if($b->status == 'approved')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5 rounded-pill">Disetujui</span>
                                        @elseif($b->status == 'pending')
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-0.5 rounded-pill">Menunggu</span>
                                        @elseif($b->status == 'completed')
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-0.5 rounded-pill">Selesai</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-0.5 rounded-pill">{{ ucfirst($b->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted small">Tidak ada transaksi pada periode ini</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ----------------------------------------------------
     5. MODAL: EXPORT PDF
---------------------------------------------------- -->
<div class="modal fade" id="exportPdfModal" tabindex="-1" aria-labelledby="exportPdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg overflow-hidden" style="border-radius: 16px;">
            <div class="modal-header bg-dark text-white px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-file-pdf text-danger"></i>
                    <h5 class="modal-title fw-bold fs-6 mb-0" id="exportPdfModalLabel">Cetak Dokumen Laporan (PDF)</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.reports.pdf') }}" method="GET" target="_blank" class="m-0">
                <div class="modal-body p-4">
                    <p class="text-muted small mb-3">Pilih format laporan yang ingin dicetak sesuai kebutuhan operasional Anda:</p>
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Jenis Dokumen Laporan</label>
                        <select name="type" class="form-select form-select-sm">
                            <option value="bookings" selected>Laporan Transaksi Booking</option>
                            <option value="revenue">Laporan Pendapatan Sewa</option>
                            <option value="cars">Laporan Kesiapan Armada</option>
                            <option value="full">Laporan Rekapitulasi Lengkap</option>
                        </select>
                    </div>

                    <div class="row g-2">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Tanggal Mulai</label>
                            <input type="date" name="start_date" value="{{ request('start_date', $startDate) }}" class="form-control form-control-sm">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-dark">Tanggal Akhir</label>
                            <input type="date" name="end_date" value="{{ request('end_date', $endDate) }}" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-top px-4 py-3">
                    <button type="button" class="btn btn-sm btn-rubick-outline" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-print me-1"></i> Buka / Cetak PDF
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fontSettings = { family: "'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif" };

    // 1. CHART 1: FINANCIAL TRAJECTORY & BOOKING VOLUME
    const ctxFin = document.getElementById('financialTrajectoryChart');
    if (ctxFin) {
        new Chart(ctxFin.getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($months),
                datasets: [
                    {
                        type: 'line',
                        label: 'Omzet (Rp)',
                        data: @json($revenueData),
                        borderColor: '#1b3bbb',
                        backgroundColor: 'rgba(27, 59, 187, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        yAxisID: 'yRevenue',
                        pointBackgroundColor: '#1b3bbb',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        type: 'bar',
                        label: 'Volume Trip',
                        data: @json($bookingCountData),
                        backgroundColor: '#10b981',
                        borderRadius: 6,
                        barThickness: 20,
                        yAxisID: 'yCount'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { ...fontSettings, size: 10.5 }, color: '#64748b' }
                    },
                    yRevenue: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(val) {
                                if (val >= 1000000) return 'Rp ' + (val / 1000000).toFixed(1) + ' jt';
                                if (val >= 1000) return 'Rp ' + (val / 1000).toFixed(0) + ' rb';
                                return 'Rp ' + val;
                            },
                            font: { ...fontSettings, size: 10 },
                            color: '#64748b'
                        }
                    },
                    yCount: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: { display: false },
                        ticks: {
                            stepSize: 1,
                            font: { ...fontSettings, size: 10 },
                            color: '#64748b'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
                            font: { ...fontSettings, size: 11, weight: 600 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 0) {
                                    return ' ' + context.dataset.label + ': Rp ' + Number(context.raw).toLocaleString('id-ID');
                                }
                                return ' ' + context.dataset.label + ': ' + context.raw + ' pesanan';
                            }
                        }
                    }
                }
            }
        });
    }

    // 2. CHART 2: CUSTOMER SEGMENTATION & DURATION
    const ctxCustomer = document.getElementById('customerDemographicsChart');
    if (ctxCustomer) {
        const segData = @json($customerSegments);
        new Chart(ctxCustomer.getContext('2d'), {
            type: 'bar',
            data: {
                labels: segData.labels,
                datasets: [{
                    label: 'Jumlah Booking',
                    data: segData.data,
                    backgroundColor: ['#0ea5e9', '#1b3bbb', '#10b981', '#f59e0b'],
                    borderRadius: 6,
                    barThickness: 26
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' Total: ' + context.raw + ' pesanan';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { ...fontSettings, size: 10 }, color: '#64748b' }
                    },
                    y: {
                        ticks: { stepSize: 1, font: { ...fontSettings, size: 10 }, color: '#64748b' },
                        grid: { color: '#f1f5f9' }
                    }
                }
            }
        });
    }

    // 3. CHART 3: REGIONAL CORRIDORS & DESTINATIONS
    const ctxRegional = document.getElementById('regionalRoutesChart');
    if (ctxRegional) {
        const regData = @json($regionalCorridors);
        new Chart(ctxRegional.getContext('2d'), {
            type: 'bar',
            data: {
                labels: regData.labels,
                datasets: [{
                    label: 'Indeks Mobilitas',
                    data: regData.data,
                    backgroundColor: ['#38bdf8', '#818cf8', '#34d399', '#fbbf24'],
                    borderRadius: 6,
                    barThickness: 18
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' Frekuensi Unit: ' + context.raw + ' armada';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { stepSize: 1, font: { ...fontSettings, size: 10 }, color: '#64748b' },
                        grid: { color: '#f1f5f9' }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { ...fontSettings, size: 10.5 }, color: '#334155' }
                    }
                }
            }
        });
    }

    // 4. CHART 4: WEEKLY TEMPORAL DEMAND
    const ctxWeekly = document.getElementById('temporalDemandChart');
    if (ctxWeekly) {
        const weekData = @json($weeklyDemand);
        new Chart(ctxWeekly.getContext('2d'), {
            type: 'bar',
            data: {
                labels: weekData.labels,
                datasets: [{
                    label: 'Frekuensi Keberangkatan',
                    data: weekData.data,
                    backgroundColor: function(context) {
                        const val = context.raw;
                        return val >= 2 ? '#f59e0b' : '#3b82f6';
                    },
                    borderRadius: 6,
                    barThickness: 22
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' Volume: ' + context.raw + ' keberangkatan';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { ...fontSettings, size: 10.5 }, color: '#64748b' }
                    },
                    y: {
                        ticks: { stepSize: 1, font: { ...fontSettings, size: 10 }, color: '#64748b' },
                        grid: { color: '#f1f5f9' }
                    }
                }
            }
        });
    }

    // 5. CHART 5: FLEET PREFERENCES
    const ctxFleet = document.getElementById('fleetPreferenceChart');
    if (ctxFleet) {
        const fleetData = @json($categoryPreferences);
        new Chart(ctxFleet.getContext('2d'), {
            type: 'bar',
            data: {
                labels: fleetData.labels,
                datasets: [{
                    label: 'Jumlah Booking',
                    data: fleetData.data,
                    backgroundColor: ['#1b3bbb', '#0ea5e9', '#10b981', '#f59e0b'],
                    borderRadius: 6,
                    barThickness: 24
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.raw + ' pesanan';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { ...fontSettings, size: 10.5 }, color: '#64748b' }
                    },
                    y: {
                        ticks: { stepSize: 1, font: { ...fontSettings, size: 10 }, color: '#64748b' },
                        grid: { color: '#f1f5f9' }
                    }
                }
            }
        });
    }

    // 6. CHART 6: STATUS & READINESS
    const ctxStatus = document.getElementById('acquisitionPaymentChart');
    if (ctxStatus) {
        const statusData = @json($statusDistribution);
        new Chart(ctxStatus.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: statusData.labels,
                datasets: [{
                    data: statusData.data,
                    backgroundColor: ['#10b981', '#1b3bbb', '#f59e0b', '#ef4444'],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
                            padding: 12,
                            font: { ...fontSettings, size: 10.5, weight: 500 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.raw + ' transaksi';
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection

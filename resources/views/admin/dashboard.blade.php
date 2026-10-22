@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid p-0">

    <!-- ----------------------------------------------------
         TOP OPERATIONAL STATUS BANNER
    ---------------------------------------------------- -->
    <div class="alert alert-dismissible fade show border-0 mb-4 px-4 py-3 text-white d-flex align-items-center justify-content-between flex-wrap gap-2 shadow-xs" 
         style="background: linear-gradient(90deg, #1b3bbb 0%, #2563eb 100%); border-radius: 14px;">
        <div class="d-flex align-items-center gap-3">
            <div class="d-flex align-items-center justify-content-center bg-white/20 rounded-circle" style="width: 36px; height: 36px; flex-shrink: 0;">
                <i class="fas fa-car-side text-white"></i>
            </div>
            <div>
                <span class="fw-bold">Status Operasional RentGo:</span>
                <span class="opacity-90 ms-1">{{ $availableCars }} unit mobil standby di garasi dari total {{ $totalCars }} armada.</span>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-light text-primary fw-bold px-3 rounded-pill shadow-xs">
                Kelola Booking ({{ $pendingBookings }} Menunggu)
            </a>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>

    <!-- ----------------------------------------------------
         ROW 1: REAL OPERATIONAL & FINANCIAL KPI CARDS
    ---------------------------------------------------- -->
    <div class="row g-4 mb-4">
        <!-- Card 1: Total Revenue -->
        <div class="col-xl-5 col-lg-6">
            <div class="card h-100 mb-0 border border-slate-200">
                <div class="card-header bg-transparent border-bottom-0 pb-0 pt-4 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Total Pendapatan</h5>
                        <small class="text-muted">Realisasi transaksi booking disetujui & selesai</small>
                    </div>
                    <div class="d-inline-flex p-2 bg-amber-50 text-amber-600 rounded-3" style="background-color: #fffbeb; color: #d97706;">
                        <i class="fas fa-wallet fa-lg"></i>
                    </div>
                </div>
                <div class="card-body px-4 pt-3 pb-4">
                    <div class="row g-3 align-items-center">
                        <div class="col-sm-6 border-end-sm">
                            <h3 class="fw-extrabold text-dark mb-1">Rp {{ number_format($grossRevenue, 0, ',', '.') }}</h3>
                            <p class="text-muted small mb-3">Total nilai sewa terkonfirmasi dari seluruh transaksi pelanggan.</p>
                            <a href="{{ route('admin.reports.index') }}" class="btn btn-rubick-outline btn-sm w-100 justify-content-center">
                                <i class="fas fa-file-lines me-1"></i> Buka Laporan Detail
                            </a>
                        </div>
                        <div class="col-sm-6 ps-sm-3">
                            <div class="d-flex flex-column gap-2.5">
                                <div>
                                    <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">Total Pesanan</div>
                                    <div class="d-flex align-items-center justify-content-between mt-0.5">
                                        <span class="fw-bold text-dark fs-6">{{ $totalBookings }} Transaksi</span>
                                    </div>
                                </div>
                                <div class="border-top pt-2">
                                    <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">Rincian Status</div>
                                    <div class="d-flex align-items-center justify-content-between mt-0.5">
                                        <span class="small text-muted">{{ $completedBookings }} Selesai • {{ $approvedBookings }} Aktif</span>
                                    </div>
                                </div>
                                <div class="border-top pt-2">
                                    <div class="text-muted small text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.05em;">Rata-rata Nilai Sewa</div>
                                    <div class="d-flex align-items-center justify-content-between mt-0.5">
                                        <span class="fw-bold text-dark fs-6">Rp {{ number_format($avgRentalValue, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Fleet Status Readiness -->
        <div class="col-xl-3 col-lg-6">
            <div class="card h-100 mb-0 border border-slate-200">
                <div class="card-header bg-transparent border-bottom-0 pb-0 pt-4 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Status Armada</h5>
                        <small class="text-muted">Kesiapan unit di garasi</small>
                    </div>
                    <a href="{{ route('admin.cars.index') }}" class="text-primary small fw-semibold text-decoration-none">
                        Kelola
                    </a>
                </div>
                <div class="card-body px-4 pt-3 pb-4 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-baseline gap-2 mb-1">
                            <h2 class="display-6 fw-bold text-dark mb-0">{{ $availableCars }}</h2>
                            <span class="text-muted fw-semibold">/ {{ $totalCars }} Unit Siap</span>
                        </div>
                        @php
                            $readinessPercent = $totalCars > 0 ? round(($availableCars / $totalCars) * 100) : 0;
                        @endphp
                        <div class="progress my-3" style="height: 8px; border-radius: 9999px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $readinessPercent }}%;" aria-valuenow="{{ $readinessPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted d-block mb-3">Tingkat kesiapan armada: <strong>{{ $readinessPercent }}%</strong> siap jalan</small>
                    </div>

                    <!-- Breakdown List -->
                    <div class="d-flex flex-column gap-2 pt-2 border-top">
                        <div class="d-flex align-items-center justify-content-between small">
                            <span class="d-flex align-items-center gap-2 text-muted">
                                <span class="badge rounded-circle p-1 bg-success"> </span>
                                Unit Ready Disewa
                            </span>
                            <span class="fw-bold text-dark">{{ $availableCars }} Unit</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between small">
                            <span class="d-flex align-items-center gap-2 text-muted">
                                <span class="badge rounded-circle p-1 bg-warning"> </span>
                                Sedang Disewa
                            </span>
                            <span class="fw-bold text-dark">{{ $rentedCars }} Unit</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between small">
                            <span class="d-flex align-items-center gap-2 text-muted">
                                <span class="badge rounded-circle p-1 bg-danger"> </span>
                                Servis Berkala
                            </span>
                            <span class="fw-bold text-dark">{{ $maintenanceCars }} Unit</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Vehicle Category Ratio (Donut Chart) -->
        <div class="col-xl-4 col-lg-12">
            <div class="card h-100 mb-0 border border-slate-200">
                <div class="card-header bg-transparent border-bottom-0 pb-0 pt-4 px-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Kategori Armada</h5>
                        <small class="text-muted">Komposisi tipe kendaraan</small>
                    </div>
                    <span class="badge" style="background: #eff6ff; color: #1d4ed8;">{{ $totalCars }} Total Unit</span>
                </div>
                <div class="card-body px-4 pt-2 pb-4">
                    <div class="row align-items-center">
                        <div class="col-sm-6 text-center position-relative py-2">
                            <div style="height: 140px; width: 140px; margin: 0 auto; position: relative;">
                                <canvas id="categoryDonutChart"></canvas>
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); pointer-events: none;">
                                    <div class="fw-extrabold fs-4 text-dark line-height-1">{{ $totalCars }}</div>
                                    <div class="text-muted" style="font-size: 0.65rem; text-transform: uppercase;">Armada</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex flex-column gap-2 small">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="d-flex align-items-center gap-2 text-muted">
                                        <span style="width: 10px; height: 10px; background-color: #1b3bbb; border-radius: 3px; display: inline-block;"></span>
                                        MPV Family
                                    </span>
                                    <span class="fw-bold text-dark">{{ $categories['MPV Family'] }} unit</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="d-flex align-items-center gap-2 text-muted">
                                        <span style="width: 10px; height: 10px; background-color: #0ea5e9; border-radius: 3px; display: inline-block;"></span>
                                        SUV Premium
                                    </span>
                                    <span class="fw-bold text-dark">{{ $categories['SUV Premium'] }} unit</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="d-flex align-items-center gap-2 text-muted">
                                        <span style="width: 10px; height: 10px; background-color: #10b981; border-radius: 3px; display: inline-block;"></span>
                                        City Car
                                    </span>
                                    <span class="fw-bold text-dark">{{ $categories['City Car'] }} unit</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="d-flex align-items-center gap-2 text-muted">
                                        <span style="width: 10px; height: 10px; background-color: #f59e0b; border-radius: 3px; display: inline-block;"></span>
                                        Luxury / VIP
                                    </span>
                                    <span class="fw-bold text-dark">{{ $categories['Luxury / VIP'] ?? $categories['Luxury / Sedan'] ?? 0 }} unit</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------
         ROW 2: REAL 6-MONTH CHART & BEST PERFORMING CARS
    ---------------------------------------------------- -->
    <div class="row g-4 mb-4">
        <!-- Real Revenue Trajectory Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card h-100 mb-0 border border-slate-200">
                <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2 py-3 px-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Tren Pendapatan & Booking Bulanan</h5>
                        <small class="text-muted">Data aktual 6 bulan terakhir dari sistem</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-slate-100 text-slate-700 border border-slate-200 px-2 py-1 rounded" style="font-size: 0.72rem;">
                            <i class="fas fa-chart-line text-primary me-1"></i> Pendapatan (Rp)
                        </span>
                        <span class="badge bg-slate-100 text-slate-700 border border-slate-200 px-2 py-1 rounded" style="font-size: 0.72rem;">
                            <i class="fas fa-calendar-check text-emerald-600 me-1"></i> Volume Booking
                        </span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div style="height: 280px; position: relative;">
                        <canvas id="monthlyTrajectoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Weekly Best Sellers (Armada Paling Sering Disewa) -->
        <div class="col-xl-4 col-lg-5">
            <div class="card h-100 mb-0 border border-slate-200">
                <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between py-3 px-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Armada Terpopuler</h5>
                        <small class="text-muted">Paling sering dibooking pelanggan</small>
                    </div>
                    <a href="{{ route('admin.cars.index') }}" class="btn-rubick-outline btn-sm px-2 py-1 text-decoration-none">
                        Semua Armada
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush border-0">
                        @forelse($bestSellers as $car)
                            <div class="list-group-item d-flex align-items-center justify-content-between p-3 border-bottom-light">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 overflow-hidden border" style="width: 52px; height: 40px; flex-shrink: 0; background: #f8fafc;">
                                        @if($car->image)
                                            <img src="{{ asset('storage/' . $car->image) }}" 
                                                 alt="{{ $car->brand }} {{ $car->model }}" 
                                                 style="width: 100%; height: 100%; object-fit: cover;"
                                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=100&auto=format&fit=crop';">
                                        @else
                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                                <i class="fas fa-car text-xs"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="fw-bold text-dark mb-0 fs-6">{{ $car->brand }} {{ $car->model }}</h6>
                                        <div class="d-flex align-items-center gap-2 mt-1">
                                            <span class="badge" style="background-color: #f1f5f9; color: #475569; font-size: 0.68rem;">{{ $car->plate_number }}</span>
                                            <span class="text-muted small">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}/hr</span>
                                        </div>
                                    </div>
                                </div>
                                <span class="badge" style="background-color: #ecfdf5; color: #047857; font-weight: 700; font-size: 0.75rem;">
                                    {{ $car->total_rented ?? 0 }}x Sewa
                                </span>
                            </div>
                        @empty
                            <div class="p-4 text-center text-muted">Belum ada data armada</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------
         ROW 3: QUICK OPERATIONAL SHORTCUTS
    ---------------------------------------------------- -->
    <div class="card border border-slate-200 mb-4 p-3.5 bg-white">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h6 class="fw-bold text-dark mb-0">Aksi Cepat Operasional</h6>
                <small class="text-muted">Pintasan menu untuk kelola armada, transaksi, dan artikel</small>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('admin.bookings.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Booking
                </a>
                <a href="{{ route('admin.cars.create') }}" class="btn btn-sm btn-rubick-outline">
                    <i class="fas fa-car me-1"></i> Tambah Mobil
                </a>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-rubick-outline">
                    <i class="fas fa-pen me-1"></i> Tulis Artikel Blog
                </a>
                <a href="{{ route('admin.reports.index') }}" class="btn btn-sm btn-rubick-outline">
                    <i class="fas fa-file-export me-1"></i> Ekspor Laporan
                </a>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------
         ROW 4: DATA TABLE - TRANSAKSI BOOKING TERKINI
    ---------------------------------------------------- -->
    <div class="card border border-slate-200 mb-4">
        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2 py-3 px-4">
            <div>
                <h5 class="fw-bold text-dark mb-0">Transaksi Booking Terkini</h5>
                <small class="text-muted">Daftar pemesanan rental terbaru yang tercatat di sistem</small>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-rubick-outline">
                    Lihat Semua Booking
                </a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive border-0">
                <table class="table align-middle table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Unit Mobil</th>
                            <th>Pelanggan</th>
                            <th>Jadwal Sewa</th>
                            <th>Total Tarif</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBookings as $booking)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 overflow-hidden border" style="width: 48px; height: 36px; flex-shrink: 0; background: #f8fafc;">
                                            @if($booking->car && $booking->car->image)
                                                <img src="{{ asset('storage/' . $booking->car->image) }}" 
                                                     alt="{{ $booking->car->brand }}" 
                                                     style="width: 100%; height: 100%; object-fit: cover;"
                                                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=100&auto=format&fit=crop';">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                                    <i class="fas fa-car text-xs"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $booking->car->brand ?? 'Armada' }} {{ $booking->car->model ?? '' }}</div>
                                            <small class="text-muted">{{ $booking->car->plate_number ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $booking->customer_name }}</div>
                                    <small class="text-muted"><i class="fas fa-phone text-xs me-1"></i>{{ $booking->customer_phone }}</small>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">
                                        {{ \Carbon\Carbon::parse($booking->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                                    </div>
                                    <small class="text-muted">{{ $booking->duration }} Hari Sewa</small>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                                    <small class="text-muted">Total Pembayaran</small>
                                </td>
                                <td>
                                    @if($booking->status == 'approved')
                                        <span class="badge" style="background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">Disetujui</span>
                                    @elseif($booking->status == 'pending')
                                        <span class="badge" style="background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a;">Menunggu</span>
                                    @elseif($booking->status == 'completed')
                                        <span class="badge" style="background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;">Selesai</span>
                                    @else
                                        <span class="badge" style="background-color: #fff1f2; color: #be123c; border: 1px solid #fecdd3;">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-rubick-outline px-2 py-1" title="Lihat Detail">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        @if($booking->customer_phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->customer_phone) }}?text=Halo%20{{ urlencode($booking->customer_name) }},%20kami%20dari%20RentGo%20Cirebon" 
                                           target="_blank" class="btn btn-sm btn-rubick-outline px-2 py-1 text-success" title="WhatsApp Pelanggan">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada riwayat booking</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------
         ROW 5: RECENT ACTIVITIES & INCOMING INQUIRIES
    ---------------------------------------------------- -->
    <div class="row g-4">
        <!-- Col 1: Real Activity Log (from database) -->
        <div class="col-lg-6">
            <div class="card h-100 mb-0 border border-slate-200">
                <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between py-3 px-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Aktivitas Terkini</h5>
                        <small class="text-muted">Pencatatan real-time booking dan kontak dari database</small>
                    </div>
                    <span class="badge bg-light text-muted border">Live Database</span>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex flex-column gap-3">
                        @forelse($recentActivities as $act)
                        <div class="d-flex gap-3 align-items-start">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white" 
                                 style="width: 34px; height: 34px; flex-shrink: 0; background-color: {{ $act['color'] === 'success' ? '#10b981' : ($act['color'] === 'warning' ? '#f59e0b' : ($act['color'] === 'info' ? '#0ea5e9' : '#1b3bbb')) }};">
                                <i class="{{ $act['icon'] }} text-xs"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="fw-semibold text-dark small">{{ $act['title'] }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">{{ $act['desc'] }}</div>
                                <small class="text-muted" style="font-size: 0.7rem;"><i class="far fa-clock me-1"></i>{{ $act['time'] }}</small>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted small">Belum ada aktivitas yang tercatat</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Col 2: Incoming Inquiries (Pesan Masuk) -->
        <div class="col-lg-6">
            <div class="card h-100 mb-0 border border-slate-200">
                <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between py-3 px-4">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Pesan Masuk Terbaru</h5>
                        <small class="text-muted">Inquiry kontak dari formulir website</small>
                    </div>
                    <a href="{{ route('admin.contacts.index') }}" class="btn-rubick-outline btn-sm px-2 py-1 text-decoration-none">
                        Semua ({{ $unreadContactsCount }} Belum Dibaca)
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush border-0">
                        @forelse($recentContacts as $contact)
                            <div class="list-group-item p-3 border-bottom-light">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center text-dark fw-bold" style="width: 28px; height: 28px; font-size: 0.75rem; border: 1px solid #e2e8f0;">
                                            {{ strtoupper(substr($contact->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-bold text-dark small">{{ $contact->name }}</span>
                                    </div>
                                    <span class="badge" style="background-color: #f1f5f9; color: #475569; font-size: 0.65rem;">
                                        {{ $contact->created_at ? $contact->created_at->diffForHumans() : '' }}
                                    </span>
                                </div>
                                <p class="text-muted small mb-2 text-truncate" style="max-width: 420px;">
                                    {{ $contact->message }}
                                </p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="badge" style="background-color: #eff6ff; color: #1d4ed8; font-size: 0.68rem;">
                                        {{ $contact->purpose_label ?? 'Informasi' }}
                                    </span>
                                    @if($contact->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->phone) }}?text=Halo%20{{ urlencode($contact->name) }},%20terima%20kasih%20telah%20menghubungi%20RentGo%20Cirebon" 
                                       target="_blank" class="btn btn-sm btn-rubick-outline py-0 px-2 text-success" style="font-size: 0.72rem;">
                                        <i class="fab fa-whatsapp me-1"></i> Balas WhatsApp
                                    </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-muted">Belum ada pesan masuk</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Render Category Donut Chart
    const donutCtx = document.getElementById('categoryDonutChart');
    if (donutCtx) {
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['MPV Family', 'SUV Premium', 'City Car', 'Luxury / VIP'],
                datasets: [{
                    data: [
                        {{ $categories['MPV Family'] ?? 0 }},
                        {{ $categories['SUV Premium'] ?? 0 }},
                        {{ $categories['City Car'] ?? 0 }},
                        {{ $categories['Luxury / VIP'] ?? $categories['Luxury / Sedan'] ?? 0 }}
                    ],
                    backgroundColor: [
                        '#1b3bbb',
                        '#0ea5e9',
                        '#10b981',
                        '#f59e0b'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.raw + ' unit';
                            }
                        }
                    }
                }
            }
        });
    }

    // 2. Render Monthly Trajectory Chart (Real Data)
    const trajectoryCtx = document.getElementById('monthlyTrajectoryChart');
    if (trajectoryCtx) {
        new Chart(trajectoryCtx, {
            type: 'bar',
            data: {
                labels: @json($months),
                datasets: [
                    {
                        type: 'line',
                        label: 'Pendapatan (Rp)',
                        data: @json($monthlyRevenue),
                        borderColor: '#1b3bbb',
                        backgroundColor: 'rgba(27, 59, 187, 0.08)',
                        borderWidth: 2.5,
                        fill: true,
                        tension: 0.35,
                        yAxisID: 'yRevenue',
                        pointBackgroundColor: '#1b3bbb',
                        pointRadius: 4
                    },
                    {
                        type: 'bar',
                        label: 'Total Booking',
                        data: @json($monthlyBookings),
                        backgroundColor: '#10b981',
                        borderRadius: 6,
                        barThickness: 24,
                        yAxisID: 'yCount'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, family: "'Plus Jakarta Sans', sans-serif" }, color: '#64748b' }
                    },
                    yRevenue: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        grid: { color: '#f1f5f9' },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) return 'Rp ' + (value / 1000000).toFixed(1) + ' jt';
                                if (value >= 1000) return 'Rp ' + (value / 1000).toFixed(0) + ' rb';
                                return 'Rp ' + value;
                            },
                            font: { size: 10, family: "'Plus Jakarta Sans', sans-serif" },
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
                            font: { size: 10, family: "'Plus Jakarta Sans', sans-serif" },
                            color: '#64748b'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 12,
                            boxHeight: 12,
                            font: { size: 11, family: "'Plus Jakarta Sans', sans-serif", weight: 600 }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                if (context.datasetIndex === 0) {
                                    return ' ' + context.dataset.label + ': Rp ' + Number(context.raw).toLocaleString('id-ID');
                                }
                                return ' ' + context.dataset.label + ': ' + context.raw + ' booking';
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

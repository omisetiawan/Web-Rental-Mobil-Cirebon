@extends('layouts.admin')

@section('title', 'Manajemen Booking')

@section('content')
<div class="container-fluid p-0">

    <!-- ----------------------------------------------------
         PAGE HEADER CARD
    ---------------------------------------------------- -->
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; background-color: var(--rubick-blue-light); color: var(--rubick-blue);">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-0">Manajemen Reservasi Sewa</h4>
                </div>
                <p class="text-muted small mb-0 ms-md-4 ps-md-3">
                    Pantau jadwal peminjaman armada, konfirmasi status reservasi pelanggan, dan kelola administrasi pembayaran rental.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <!-- Export / Print Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-rubick-outline dropdown-toggle d-inline-flex align-items-center gap-1.5" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-arrow-up-from-bracket text-secondary"></i>
                        <span>Ekspor</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 p-1" style="min-width: 175px;">
                        <li>
                            <button class="dropdown-item py-2 rounded-2 small" onclick="window.print()">
                                <i class="fas fa-print me-2 text-muted"></i> Cetak Laporan (Print)
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item py-2 rounded-2 small" onclick="exportBookingsToCSV('data-reservasi-rentgo.csv')">
                                <i class="fas fa-file-csv me-2 text-success"></i> Ekspor ke CSV / Excel
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Tambah Booking Baru -->
                <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Booking</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------
         KPI STAT METRIC FILTER CARDS (Rubick 4-Grid)
    ---------------------------------------------------- -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Booking -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 filter-stat-card active" data-filter="all" style="cursor: pointer; border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Total Reservasi</span>
                        <h3 class="fw-extrabold text-dark mb-0 mt-1" style="font-size: 1.65rem;">{{ $stats->total ?? 0 }}</h3>
                        <small class="text-muted" style="font-size: 0.75rem;">Nilai: Rp {{ number_format($revenue ?? 0, 0, ',', '.') }}</small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: var(--rubick-blue-light); color: var(--rubick-blue); font-size: 1.3rem;">
                        <i class="fas fa-layer-group"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Pending Approval -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 filter-stat-card" data-filter="pending" style="cursor: pointer; border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Perlu Konfirmasi</span>
                        <h3 class="fw-extrabold text-dark mb-0 mt-1" style="font-size: 1.65rem;">{{ $stats->pending ?? 0 }}</h3>
                        <small class="text-warning fw-semibold" style="font-size: 0.75rem;">
                            <i class="fas fa-clock me-1"></i>Menunggu persetujuan
                        </small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: #fffbeb; color: #d97706; font-size: 1.3rem;">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Approved / Terkonfirmasi -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 filter-stat-card" data-filter="approved" style="cursor: pointer; border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Terkonfirmasi</span>
                        <h3 class="fw-extrabold text-dark mb-0 mt-1" style="font-size: 1.65rem;">{{ $stats->approved ?? 0 }}</h3>
                        <small class="text-success fw-semibold" style="font-size: 0.75rem;">
                            <i class="fas fa-check-circle me-1"></i>Jadwal aktif disetujui
                        </small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: #ecfdf5; color: #059669; font-size: 1.3rem;">
                        <i class="fas fa-badge-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Selesai / Completed -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 filter-stat-card" data-filter="completed" style="cursor: pointer; border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Rental Selesai</span>
                        <h3 class="fw-extrabold text-dark mb-0 mt-1" style="font-size: 1.65rem;">{{ $stats->completed ?? 0 }}</h3>
                        <small class="text-primary fw-semibold" style="font-size: 0.75rem;">
                            <i class="fas fa-flag-checkered me-1"></i>Unit telah dikembalikan
                        </small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: #eff6ff; color: #1d4ed8; font-size: 1.3rem;">
                        <i class="fas fa-circle-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------
         MAIN BOOKINGS INVENTORY CARD & TOOLBAR
    ---------------------------------------------------- -->
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 16px;">
        <!-- Filter Toolbar -->
        <div class="card-header bg-transparent border-bottom p-3 p-md-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <!-- Search & Filters -->
                <div class="d-flex align-items-center gap-2 flex-wrap flex-grow-1" style="max-width: 850px;">
                    <!-- Live Search Input -->
                    <div class="rubick-search-pill" style="min-width: 250px; flex-grow: 1;">
                        <i class="fas fa-search"></i>
                        <input type="text" id="bookingTableSearch" placeholder="Cari nama pelanggan, nomor WA, mobil, plat..." value="{{ request('search') }}">
                    </div>

                    <!-- Filter Status Dropdown -->
                    <select id="filterBookingStatus" class="form-select form-select-sm" style="width: 165px; border-radius: 9999px;">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved (Disetujui)</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected (Dibatalkan)</option>
                    </select>

                    <!-- Reset Filter Button -->
                    <button id="btnResetBookingFilter" class="btn btn-sm btn-rubick-outline rounded-pill d-none" type="button" title="Bersihkan semua filter">
                        <i class="fas fa-rotate-left me-1"></i> Reset
                    </button>
                </div>

                <!-- Showing Counter -->
                <div class="text-muted small fw-semibold">
                    Menampilkan <span id="showingBookingCount" class="text-dark fw-bold">{{ $bookings->total() }}</span> Transaksi
                </div>
            </div>
        </div>

        <!-- Table View -->
        <div class="card-body p-0">
            <div class="table-responsive border-0">
                <table class="table align-middle table-hover mb-0" id="bookingsTable">
                    <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                        <tr>
                            <th class="ps-4" style="width: 45px;">#</th>
                            <th style="min-width: 200px;">Pelanggan / Pemesan</th>
                            <th style="min-width: 220px;">Unit Kendaraan</th>
                            <th style="min-width: 170px;">Jadwal & Durasi</th>
                            <th style="min-width: 140px;">Total Biaya</th>
                            <th style="min-width: 155px;">Status Reservasi</th>
                            <th class="text-end pe-4" style="width: 135px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            @php
                                $start = \Carbon\Carbon::parse($booking->start_date);
                                $end = \Carbon\Carbon::parse($booking->end_date);
                                $durationDays = max(1, $start->diffInDays($end));
                                
                                // Format phone for WhatsApp link
                                $phoneClean = preg_replace('/[^0-9]/', '', $booking->customer_phone);
                                if (str_starts_with($phoneClean, '0')) {
                                    $waNumber = '62' . substr($phoneClean, 1);
                                } elseif (!str_starts_with($phoneClean, '62')) {
                                    $waNumber = '62' . $phoneClean;
                                } else {
                                    $waNumber = $phoneClean;
                                }
                                $carName = $booking->car ? ($booking->car->brand . ' ' . $booking->car->model) : 'Armada RentGo';
                                $waText = rawurlencode("Halo {$booking->customer_name}, kami dari RentGo Cirebon ingin mengonfirmasi jadwal reservasi unit {$carName} Anda pada tanggal {$start->format('d M Y')}. Apakah ada yang bisa kami bantu?");
                            @endphp
                            <tr class="booking-table-row" 
                                data-status="{{ strtolower($booking->status) }}"
                                data-search="{{ strtolower($booking->customer_name . ' ' . $booking->customer_phone . ' ' . ($booking->car ? $booking->car->brand . ' ' . $booking->car->model . ' ' . $booking->car->category . ' ' . $booking->car->plate_number : '') . ' ' . $booking->status) }}">
                                
                                <!-- No -->
                                <td class="ps-4 text-muted fw-semibold small">
                                    {{ sprintf('%02d', $loop->iteration + ($bookings->currentPage() - 1) * $bookings->perPage()) }}
                                </td>

                                <!-- Pelanggan -->
                                <td>
                                    <div class="d-flex align-items-center gap-2.5">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-xs" 
                                             style="width: 38px; height: 38px; font-size: 0.85rem; flex-shrink: 0; background-color: var(--rubick-blue);">
                                            {{ strtoupper(substr($booking->customer_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6">{{ $booking->customer_name }}</div>
                                            <div class="d-flex align-items-center gap-1.5 mt-0.5">
                                                <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank" class="text-decoration-none text-muted small hover-success d-inline-flex align-items-center gap-1" title="Kirim WhatsApp">
                                                    <i class="fab fa-whatsapp text-success" style="font-size: 0.85rem;"></i>
                                                    <span>{{ $booking->customer_phone }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Unit Kendaraan -->
                                <td>
                                    @if($booking->car)
                                        <div class="d-flex align-items-center gap-2.5">
                                            <div class="rounded-2 overflow-hidden border position-relative" style="width: 58px; height: 40px; flex-shrink: 0; background-color: #f8fafc;">
                                                <img src="{{ $booking->car->image_url }}" 
                                                     alt="{{ $booking->car->brand }} {{ $booking->car->model }}" 
                                                     style="width: 100%; height: 100%; object-fit: cover;"
                                                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=150&auto=format&fit=crop';">
                                            </div>
                                            <div>
                                                <a href="{{ route('admin.cars.show', $booking->car) }}" class="fw-bold text-dark text-decoration-none hover-primary small d-block">
                                                    {{ $booking->car->brand }} {{ $booking->car->model }}
                                                </a>
                                                <div class="d-flex align-items-center gap-1 mt-0.5">
                                                    <span class="font-monospace fw-semibold px-1.5 py-0.2 rounded border text-muted" style="background: #f8fafc; font-size: 0.72rem;">
                                                        {{ $booking->car->plate_number }}
                                                    </span>
                                                    <span class="badge" style="background: #eff6ff; color: #1d4ed8; font-size: 0.65rem; font-weight: 600;">
                                                        {{ $booking->car->category }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-danger small">
                                            <i class="fas fa-triangle-exclamation me-1"></i>Unit Telah Dihapus
                                        </div>
                                    @endif
                                </td>

                                <!-- Jadwal & Durasi -->
                                <td>
                                    <div class="small fw-semibold text-dark">
                                        <i class="far fa-calendar-check me-1 text-success" style="font-size: 0.75rem;"></i>{{ $start->format('d M Y') }}
                                    </div>
                                    <div class="text-muted small mt-0.5" style="font-size: 0.75rem;">
                                        s/d {{ $end->format('d M Y') }}
                                        <span class="badge ms-1" style="background: #f1f5f9; color: #475569; font-size: 0.68rem;">
                                            {{ $durationDays }} Hari
                                        </span>
                                    </div>
                                </td>

                                <!-- Total Biaya -->
                                <td>
                                    <div class="fw-bold text-dark fs-6">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </div>
                                    <small class="text-muted" style="font-size: 0.72rem;">Lunas / Terverifikasi</small>
                                </td>

                                <!-- Status Switcher Dropdown -->
                                <td>
                                    <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="m-0">
                                        @csrf
                                        <select name="status" 
                                                onchange="this.form.submit()" 
                                                class="form-select form-select-sm status-dropdown-select"
                                                style="width: 145px; border-radius: 9999px; font-size: 0.78rem; font-weight: 600; cursor: pointer;
                                                @if($booking->status == 'approved') background-color: #ecfdf5; color: #047857; border-color: #a7f3d0;
                                                @elseif($booking->status == 'pending') background-color: #fffbeb; color: #b45309; border-color: #fde68a;
                                                @elseif($booking->status == 'completed') background-color: #eff6ff; color: #1d4ed8; border-color: #bfdbfe;
                                                @else background-color: #fff1f2; color: #be123c; border-color: #fecdd3; @endif">
                                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>● Pending</option>
                                            <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>● Terkonfirmasi</option>
                                            <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>● Selesai</option>
                                            <option value="rejected" {{ $booking->status == 'rejected' ? 'selected' : '' }}>● Dibatalkan</option>
                                        </select>
                                    </form>
                                </td>

                                <!-- Actions -->
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-1">
                                        <!-- Quick Modal Trigger -->
                                        <button type="button" 
                                                class="btn btn-sm btn-rubick-outline px-2 py-1" 
                                                onclick="openBookingQuickView({{ $booking->id }})"
                                                title="Lihat Detail Reservasi">
                                            <i class="far fa-eye text-primary"></i>
                                        </button>

                                        <!-- WhatsApp Chat Link -->
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" 
                                           target="_blank"
                                           class="btn btn-sm btn-rubick-outline px-2 py-1 text-success" 
                                           title="Chat WhatsApp Pelanggan">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>

                                        <!-- Edit Link -->
                                        <a href="{{ route('admin.bookings.edit', $booking) }}" 
                                           class="btn btn-sm btn-rubick-outline px-2 py-1 text-secondary" 
                                           title="Ubah Data Booking">
                                            <i class="far fa-pen-to-square"></i>
                                        </a>

                                        <!-- Delete Confirmation Trigger -->
                                        <button type="button" 
                                                class="btn btn-sm btn-rubick-outline px-2 py-1 text-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteBookingModal{{ $booking->id }}"
                                                title="Hapus Booking">
                                            <i class="far fa-trash-can"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteBookingModal{{ $booking->id }}" tabindex="-1" aria-hidden="true" style="text-align: left;">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                                                <div class="modal-body p-4 text-center">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                                         style="width: 52px; height: 52px; background-color: #fff1f2; color: #e11d48; font-size: 1.5rem;">
                                                        <i class="far fa-trash-can"></i>
                                                    </div>
                                                    <h6 class="fw-bold text-dark mb-1">Batalkan / Hapus Booking?</h6>
                                                    <p class="text-muted small mb-3">
                                                        Reservasi atas nama <strong>{{ $booking->customer_name }}</strong> ({{ $carName }}) akan dihapus dari sistem.
                                                    </p>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <button type="button" class="btn btn-sm btn-rubick-outline px-3" data-bs-dismiss="modal">Tutup</button>
                                                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="m-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger px-3">
                                                                Ya, Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="p-4">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 text-muted" style="width: 56px; height: 56px; background-color: #f1f5f9;">
                                            <i class="fas fa-calendar-xmark fa-lg"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">Tidak Ada Data Reservasi</h6>
                                        <p class="text-muted small mb-3">Belum ada pemesanan yang sesuai dengan filter atau kata kunci pencarian Anda.</p>
                                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-rubick-outline me-2">
                                            <i class="fas fa-rotate-left me-1"></i> Reset Filter
                                        </a>
                                        <a href="{{ route('admin.bookings.create') }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus me-1"></i> Buat Booking Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            @if($bookings->hasPages())
                <div class="p-3.5 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <small class="text-muted">
                        Menampilkan {{ $bookings->firstItem() }} sampai {{ $bookings->lastItem() }} dari {{ $bookings->total() }} reservasi
                    </small>
                    <div class="m-0">
                        {{ $bookings->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>

<!-- ----------------------------------------------------
     QUICK VIEW BOOKING MODAL
---------------------------------------------------- -->
<div class="modal fade" id="bookingQuickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-bottom p-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: var(--rubick-blue-light); color: var(--rubick-blue);">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark mb-0">Rincian Reservasi Kendaraan</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <!-- Left: Customer & Status -->
                    <div class="col-md-5 border-end">
                        <div class="text-center p-3 rounded-3 mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white mx-auto mb-2" 
                                 id="qbCustomerAvatar" style="width: 54px; height: 54px; font-size: 1.3rem; background: var(--rubick-blue);">
                                A
                            </div>
                            <h5 class="fw-bold text-dark mb-0" id="qbCustomerName">Nama Pelanggan</h5>
                            <div class="text-muted small mt-1" id="qbCustomerPhone">08123456789</div>
                            
                            <div class="mt-3">
                                <span class="badge" id="qbStatusBadge" style="font-size: 0.8rem; padding: 0.45rem 0.85rem; border-radius: 9999px;">
                                    Terkonfirmasi
                                </span>
                            </div>
                        </div>

                        <!-- WhatsApp Action Button -->
                        <a id="qbWhatsAppBtn" href="#" target="_blank" class="btn btn-outline-success w-100 py-2 d-inline-flex align-items-center justify-content-center gap-2 mb-2">
                            <i class="fab fa-whatsapp fa-lg"></i>
                            <span>Hubungi Pelanggan via WhatsApp</span>
                        </a>
                    </div>

                    <!-- Right: Car & Rental Calculation -->
                    <div class="col-md-7">
                        <h6 class="fw-bold text-dark mb-3">Informasi Sewa & Armada</h6>
                        
                        <div class="d-flex align-items-center gap-3 p-2.5 rounded-3 mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="rounded-2 overflow-hidden border" style="width: 64px; height: 44px; flex-shrink: 0; background: #fff;">
                                <img id="qbCarImg" src="" alt="Mobil" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0" id="qbCarName">Toyota Avanza</h6>
                                <span class="font-monospace fw-semibold px-1.5 py-0.2 rounded border text-muted" id="qbCarPlate" style="background: #fff; font-size: 0.72rem;">
                                    E 1234 AB
                                </span>
                            </div>
                        </div>

                        <div class="p-3 rounded-3 mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="row g-2 text-sm">
                                <div class="col-6">
                                    <span class="text-muted small">Mulai Sewa:</span>
                                    <div class="fw-bold text-dark" id="qbStartDate">01 Nov 2026</div>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted small">Selesai Sewa:</span>
                                    <div class="fw-bold text-dark" id="qbEndDate">04 Nov 2026</div>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted small">Total Durasi:</span>
                                    <div class="fw-bold text-dark" id="qbDuration">3 Hari</div>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted small">Total Biaya Rental:</span>
                                    <div class="fw-extrabold text-primary fs-6" id="qbTotalPrice">Rp 1.050.000</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-end gap-2 pt-2">
                            <a id="qbFullDetailBtn" href="#" class="btn btn-sm btn-rubick-outline px-3">
                                <i class="fas fa-up-right-from-square me-1"></i> Buka Halaman Lengkap
                            </a>
                            <a id="qbEditBtn" href="#" class="btn btn-sm btn-primary px-3">
                                <i class="far fa-pen-to-square me-1"></i> Edit Reservasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Data store for quick view modal
const bookingsDataMap = {
    @foreach($bookings as $booking)
        @php
            $bStart = \Carbon\Carbon::parse($booking->start_date);
            $bEnd = \Carbon\Carbon::parse($booking->end_date);
            $bDuration = max(1, $bStart->diffInDays($bEnd));
            $bPhoneClean = preg_replace('/[^0-9]/', '', $booking->customer_phone);
            if (str_starts_with($bPhoneClean, '0')) {
                $bWa = '62' . substr($bPhoneClean, 1);
            } elseif (!str_starts_with($bPhoneClean, '62')) {
                $bWa = '62' . $bPhoneClean;
            } else {
                $bWa = $bPhoneClean;
            }
            $bCarName = $booking->car ? ($booking->car->brand . ' ' . $booking->car->model) : 'Armada RentGo';
        @endphp
        {{ $booking->id }}: {
            id: {{ $booking->id }},
            customer_name: "{{ addslashes($booking->customer_name) }}",
            customer_phone: "{{ addslashes($booking->customer_phone) }}",
            wa_url: "https://wa.me/{{ $bWa }}?text={{ rawurlencode("Halo {$booking->customer_name}, kami dari RentGo Cirebon mengonfirmasi pesanan rental {$bCarName}.") }}",
            car_name: "{{ addslashes($bCarName) }}",
            car_plate: "{{ addslashes($booking->car ? $booking->car->plate_number : '-') }}",
            car_image: "{{ $booking->car ? $booking->car->image_url : 'https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=200' }}",
            start_date: "{{ $bStart->format('d M Y') }}",
            end_date: "{{ $bEnd->format('d M Y') }}",
            duration: "{{ $bDuration }} Hari",
            total_price: "Rp {{ number_format($booking->total_price, 0, ',', '.') }}",
            status: "{{ $booking->status }}",
            show_url: "{{ route('admin.bookings.show', $booking) }}",
            edit_url: "{{ route('admin.bookings.edit', $booking) }}"
        },
    @endforeach
};

function openBookingQuickView(bookingId) {
    const b = bookingsDataMap[bookingId];
    if (!b) return;

    document.getElementById('qbCustomerAvatar').textContent = b.customer_name.charAt(0).toUpperCase();
    document.getElementById('qbCustomerName').textContent = b.customer_name;
    document.getElementById('qbCustomerPhone').textContent = b.customer_phone;
    document.getElementById('qbWhatsAppBtn').href = b.wa_url;

    document.getElementById('qbCarName').textContent = b.car_name;
    document.getElementById('qbCarPlate').textContent = b.car_plate;
    document.getElementById('qbCarImg').src = b.car_image;
    document.getElementById('qbStartDate').textContent = b.start_date;
    document.getElementById('qbEndDate').textContent = b.end_date;
    document.getElementById('qbDuration').textContent = b.duration;
    document.getElementById('qbTotalPrice').textContent = b.total_price;

    const badge = document.getElementById('qbStatusBadge');
    if (b.status === 'approved') {
        badge.textContent = '✓ Terkonfirmasi';
        badge.style.backgroundColor = '#ecfdf5';
        badge.style.color = '#047857';
        badge.style.border = '1px solid #a7f3d0';
    } else if (b.status === 'pending') {
        badge.textContent = '⏱ Menunggu Approval';
        badge.style.backgroundColor = '#fffbeb';
        badge.style.color = '#b45309';
        badge.style.border = '1px solid #fde68a';
    } else if (b.status === 'completed') {
        badge.textContent = '✓ Selesai';
        badge.style.backgroundColor = '#eff6ff';
        badge.style.color = '#1d4ed8';
        badge.style.border = '1px solid #bfdbfe';
    } else {
        badge.textContent = '✕ Dibatalkan';
        badge.style.backgroundColor = '#fff1f2';
        badge.style.color = '#be123c';
        badge.style.border = '1px solid #fecdd3';
    }

    document.getElementById('qbFullDetailBtn').href = b.show_url;
    document.getElementById('qbEditBtn').href = b.edit_url;

    const modal = new bootstrap.Modal(document.getElementById('bookingQuickViewModal'));
    modal.show();
}

// Client-Side Live Filter System
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('bookingTableSearch');
    const filterStatus = document.getElementById('filterBookingStatus');
    const btnReset = document.getElementById('btnResetBookingFilter');
    const statCards = document.querySelectorAll('.filter-stat-card');
    const rows = document.querySelectorAll('.booking-table-row');
    const countBadge = document.getElementById('showingBookingCount');

    let currentStatFilter = 'all';

    function applyFilters() {
        const query = (searchInput?.value || '').toLowerCase().trim();
        const statusSelect = (filterStatus?.value || '').toLowerCase().trim();

        let visibleCount = 0;

        rows.forEach(row => {
            const rowSearch = row.getAttribute('data-search') || '';
            const rowStatus = row.getAttribute('data-status') || '';

            const matchQuery = !query || rowSearch.includes(query);
            const activeStatusCriterion = statusSelect || (currentStatFilter !== 'all' ? currentStatFilter : '');
            const matchStatus = !activeStatusCriterion || (rowStatus === activeStatusCriterion);

            if (matchQuery && matchStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (countBadge) {
            countBadge.textContent = visibleCount;
        }

        // Show/hide reset button
        if (query || statusSelect || currentStatFilter !== 'all') {
            btnReset?.classList.remove('d-none');
        } else {
            btnReset?.classList.add('d-none');
        }
    }

    searchInput?.addEventListener('input', applyFilters);
    filterStatus?.addEventListener('change', function() {
        currentStatFilter = this.value || 'all';
        statCards.forEach(c => {
            if (c.getAttribute('data-filter') === currentStatFilter) {
                c.classList.add('active');
            } else {
                c.classList.remove('active');
            }
        });
        applyFilters();
    });

    statCards.forEach(card => {
        card.addEventListener('click', function() {
            statCards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            currentStatFilter = this.getAttribute('data-filter') || 'all';
            
            if (filterStatus) {
                filterStatus.value = currentStatFilter === 'all' ? '' : currentStatFilter;
            }
            applyFilters();
        });
    });

    btnReset?.addEventListener('click', function() {
        if (searchInput) searchInput.value = '';
        if (filterStatus) filterStatus.value = '';
        currentStatFilter = 'all';
        statCards.forEach(c => c.classList.remove('active'));
        document.querySelector('.filter-stat-card[data-filter="all"]')?.classList.add('active');
        applyFilters();
    });
});

// Export to CSV
function exportBookingsToCSV(filename) {
    const rows = document.querySelectorAll('#bookingsTable tr');
    let csv = [];
    
    rows.forEach(row => {
        if (row.style.display === 'none') return;
        
        let rowData = [];
        const cols = row.querySelectorAll('th, td');
        for (let i = 0; i < Math.min(cols.length, 6); i++) {
            let text = cols[i].innerText.replace(/(\r\n|\n|\r)/gm, ' ').replace(/"/g, '""').trim();
            rowData.push('"' + text + '"');
        }
        if (rowData.length > 0) {
            csv.push(rowData.join(','));
        }
    });

    const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
    const downloadLink = document.createElement('a');
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = 'none';
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}
</script>

<style>
/* Stat filter card active indicator */
.filter-stat-card {
    transition: all 0.18s ease;
    border: 1px solid var(--rubick-border);
}
.filter-stat-card:hover {
    border-color: #cbd5e1;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}
.filter-stat-card.active {
    border-color: var(--rubick-blue) !important;
    background-color: #ffffff;
    box-shadow: 0 4px 14px rgba(27, 59, 187, 0.09) !important;
}

.hover-success:hover {
    color: #16a34a !important;
}
.hover-primary:hover {
    color: var(--rubick-blue) !important;
}

/* Print styling */
@media print {
    .rubick-sidebar,
    .rubick-topbar,
    .filter-stat-card,
    .btn,
    .status-dropdown-select,
    .pagination,
    th:last-child,
    td:last-child {
        display: none !important;
    }
    .rubick-main-canvas {
        margin: 0 !important;
        border-radius: 0 !important;
        background: #fff !important;
        padding: 0 !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    table {
        width: 100% !important;
        font-size: 11pt !important;
    }
}
</style>
@endsection

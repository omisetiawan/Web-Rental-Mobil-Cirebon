@extends('layouts.admin')

@section('title', 'Detail Reservasi - ' . $booking->customer_name)

@section('content')
<div class="container-fluid p-0">

    <!-- Page Header Card -->
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: var(--rubick-blue-light); color: var(--rubick-blue);">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-0">Rincian Reservasi #{{ sprintf('%04d', $booking->id) }}</h4>
                    <span class="badge ms-2" style="font-size: 0.8rem; padding: 0.4rem 0.8rem; border-radius: 9999px;
                        @if($booking->status == 'approved') background-color: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;
                        @elseif($booking->status == 'pending') background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a;
                        @elseif($booking->status == 'completed') background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;
                        @else background-color: #fff1f2; color: #be123c; border: 1px solid #fecdd3; @endif">
                        {{ ucfirst($booking->status) }}
                    </span>
                </div>
                <p class="text-muted small mb-0 ms-md-4 ps-md-2">
                    Dibuat pada {{ $booking->created_at->translatedFormat('d F Y, H:i') }} WIB
                </p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button onclick="window.print()" class="btn btn-rubick-outline d-inline-flex align-items-center gap-1.5">
                    <i class="fas fa-print text-muted"></i>
                    <span>Cetak Invoice</span>
                </button>
                <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-primary d-inline-flex align-items-center gap-1.5">
                    <i class="far fa-pen-to-square"></i>
                    <span>Edit Booking</span>
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-rubick-outline d-inline-flex align-items-center gap-1.5">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>
    </div>

    @php
        $start = \Carbon\Carbon::parse($booking->start_date);
        $end = \Carbon\Carbon::parse($booking->end_date);
        $durationDays = max(1, $start->diffInDays($end));
        $phoneClean = preg_replace('/[^0-9]/', '', $booking->customer_phone);
        if (str_starts_with($phoneClean, '0')) {
            $waNumber = '62' . substr($phoneClean, 1);
        } elseif (!str_starts_with($phoneClean, '62')) {
            $waNumber = '62' . $phoneClean;
        } else {
            $waNumber = $phoneClean;
        }
        $carName = $booking->car ? ($booking->car->brand . ' ' . $booking->car->model) : 'Armada RentGo';
        $waText = rawurlencode("Halo {$booking->customer_name}, terima kasih telah menyewa kendaraan di RentGo Cirebon. Berikut rincian reservasi unit {$carName} Anda pada {$start->format('d M Y')}.");
    @endphp

    <div class="row g-4 mb-4">
        <!-- Left: Customer Details & Car Details -->
        <div class="col-lg-8">
            <!-- Customer Card -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-4">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fas fa-user-circle me-2 text-primary"></i>Data Penyewa / Customer
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-xs" 
                                 style="width: 54px; height: 54px; font-size: 1.35rem; background-color: var(--rubick-blue);">
                                {{ strtoupper(substr($booking->customer_name, 0, 1)) }}
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0.5">{{ $booking->customer_name }}</h5>
                                <div class="text-muted small">
                                    <i class="fas fa-phone me-1.5 text-secondary"></i>{{ $booking->customer_phone }}
                                </div>
                            </div>
                        </div>

                        <div>
                            <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank" class="btn btn-outline-success d-inline-flex align-items-center gap-2 px-3 py-2">
                                <i class="fab fa-whatsapp fa-lg"></i>
                                <span>Hubungi via WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vehicle Details Card -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-4">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fas fa-car-side me-2 text-primary"></i>Unit Kendaraan yang Disewa
                    </h6>
                </div>
                <div class="card-body p-4">
                    @if($booking->car)
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <div class="rounded-3 overflow-hidden border shadow-xs" style="width: 140px; height: 95px; flex-shrink: 0; background-color: #f8fafc;">
                                <img src="{{ $booking->car->image_url }}" 
                                     alt="{{ $booking->car->brand }} {{ $booking->car->model }}" 
                                     style="width: 100%; height: 100%; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=300&auto=format&fit=crop';">
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex align-items-baseline justify-content-between flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <h5 class="fw-bold text-dark mb-0">{{ $booking->car->brand }} {{ $booking->car->model }}</h5>
                                        <span class="badge" style="background: #eff6ff; color: #1d4ed8; font-size: 0.72rem; font-weight: 600;">
                                            {{ $booking->car->category }}
                                        </span>
                                    </div>
                                    <span class="font-monospace fw-bold px-2 py-0.5 rounded border text-dark" style="background: #f8fafc; font-size: 0.85rem;">
                                        {{ $booking->car->plate_number }}
                                    </span>
                                </div>
                                <div class="text-muted small mt-1">
                                    {{ $booking->car->year }} • Transmisi {{ ucfirst($booking->car->transmission ?? 'Manual') }} • {{ $booking->car->seat_capacity ?? 7 }} Penumpang
                                </div>
                                <div class="mt-2 text-primary fw-bold">
                                    Rp {{ number_format($booking->car->price_per_day, 0, ',', '.') }} <small class="text-muted fw-normal">/ hari</small>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-3 bg-light rounded text-danger small">
                            <i class="fas fa-triangle-exclamation me-1"></i>Data unit kendaraan ini telah dinonaktifkan atau dihapus dari sistem.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Schedule Card -->
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-4">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="far fa-calendar-alt me-2 text-primary"></i>Jadwal Penggunaan Kendaraan
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3 text-center">
                        <div class="col-md-5">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <span class="text-muted small d-block">Tanggal Pengambilan (Start)</span>
                                <div class="fw-extrabold text-success fs-5 mt-1">{{ $start->translatedFormat('d F Y') }}</div>
                                <small class="text-muted">Pukul 08:00 WIB (Standar)</small>
                            </div>
                        </div>

                        <div class="col-md-2 d-flex align-items-center justify-content-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-muted" style="width: 38px; height: 38px; background: #f1f5f9;">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <span class="text-muted small d-block">Tanggal Pengembalian (End)</span>
                                <div class="fw-extrabold text-danger fs-5 mt-1">{{ $end->translatedFormat('d F Y') }}</div>
                                <small class="text-muted">Pukul 08:00 WIB (Standar)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Financial Summary & Status Control -->
        <div class="col-lg-4">
            <!-- Payment & Billing Card -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-4">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fas fa-receipt me-2 text-primary"></i>Rincian Penagihan
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between py-2 border-bottom text-sm">
                        <span class="text-muted">Durasi Sewa:</span>
                        <span class="fw-bold text-dark">{{ $durationDays }} Hari</span>
                    </div>
                    @if($booking->car)
                    <div class="d-flex justify-content-between py-2 border-bottom text-sm">
                        <span class="text-muted">Tarif Satuan / Hari:</span>
                        <span class="text-dark">Rp {{ number_format($booking->car->price_per_day, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="d-flex justify-content-between align-items-baseline pt-3">
                        <span class="fw-bold text-dark fs-6">Total Tagihan:</span>
                        <div class="fw-extrabold text-primary fs-4">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Control Card -->
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-4">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fas fa-toggle-on me-2 text-primary"></i>Perbarui Status Booking
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.bookings.updateStatus', $booking) }}" method="POST" class="m-0">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-semibold">Pilih Status Reservasi:</label>
                            <select name="status" class="form-select" style="border-radius: 10px;">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>● Pending (Menunggu Persetujuan)</option>
                                <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>● Approved (Terkonfirmasi Aktif)</option>
                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>● Completed (Sewa Selesai)</option>
                                <option value="rejected" {{ $booking->status == 'rejected' ? 'selected' : '' }}>● Rejected (Dibatalkan)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 d-inline-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-check"></i>
                            <span>Simpan Status</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

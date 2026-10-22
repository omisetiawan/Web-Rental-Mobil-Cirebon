@extends('layouts.admin')

@section('title', 'Detail Unit: ' . $car->brand . ' ' . $car->model)

@section('content')
<div class="container-fluid p-0">

    <!-- Page Header Card -->
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: var(--rubick-blue-light); color: var(--rubick-blue);">
                        <i class="fas fa-car"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-0">{{ $car->brand }} {{ $car->model }}</h4>
                    <span class="font-monospace fw-bold px-2 py-0.5 rounded border text-dark ms-2" style="background: #f8fafc; font-size: 0.82rem;">
                        {{ $car->plate_number }}
                    </span>
                </div>
                <p class="text-muted small mb-0 ms-md-4 ps-md-2 d-flex align-items-center gap-2 flex-wrap">
                    @php
                        $catName = $car->category;
                        $catBadgeStyle = match($catName) {
                            'SUV Premium' => 'background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd;',
                            'City Car' => 'background: #d1fae5; color: #059669; border: 1px solid #a7f3d0;',
                            'Luxury / VIP' => 'background: #fef3c7; color: #d97706; border: 1px solid #fde68a;',
                            default => 'background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;',
                        };
                    @endphp
                    <span class="badge" style="{{ $catBadgeStyle }} font-size: 0.72rem; font-weight: 600;">{{ $catName }}</span>
                    <span>•</span>
                    <span>Tahun {{ $car->year }}</span>
                    <span>•</span>
                    <span>Transmisi {{ ucfirst($car->transmission ?? 'Manual') }}</span>
                    <span>•</span>
                    <span>{{ $car->seat_capacity ?? 7 }} Penumpang</span>
                </p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
                    <i class="far fa-pen-to-square"></i>
                    <span>Edit Armada</span>
                </a>
                <a href="{{ route('admin.cars.index') }}" class="btn btn-rubick-outline d-inline-flex align-items-center gap-2">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Inventaris</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Left: Photo & Specifications -->
        <div class="col-lg-7">
            <!-- Main Photo Card -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; overflow: hidden;">
                <div class="position-relative" style="height: 340px; background: #f8fafc;">
                    <img src="{{ $car->image_url }}" 
                         alt="{{ $car->brand }} {{ $car->model }}" 
                         style="width: 100%; height: 100%; object-fit: cover;"
                         onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=800&auto=format&fit=crop';">
                    
                    <!-- Live Status Badge Overlay -->
                    <div class="position-absolute top-0 end-0 m-3">
                        @if($car->status == 'available')
                            <span class="badge px-3 py-2 rounded-pill fw-bold" style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; font-size: 0.8rem;">
                                ✓ Siap Jalan (Ready)
                            </span>
                        @elseif($car->status == 'rented')
                            <span class="badge px-3 py-2 rounded-pill fw-bold" style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a; font-size: 0.8rem;">
                                ⏱ Sedang Disewa
                            </span>
                        @else
                            <span class="badge px-3 py-2 rounded-pill fw-bold" style="background: #fff1f2; color: #be123c; border: 1px solid #fecdd3; font-size: 0.8rem;">
                                🔧 Dalam Perawatan
                            </span>
                        @endif
                    </div>
                </div>

                @if($car->gallery_urls && count($car->gallery_urls) > 0)
                    <div class="p-3 bg-light border-top d-flex gap-2 overflow-auto">
                        @foreach($car->gallery_urls as $imgUrl)
                            <div class="rounded-2 overflow-hidden border" style="width: 80px; height: 56px; flex-shrink: 0; cursor: pointer;">
                                <img src="{{ $imgUrl }}" alt="Galeri" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Full Specifications Grid -->
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-4">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fas fa-list-check me-2 text-primary"></i>Spesifikasi Lengkap Unit
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <span class="text-muted small d-block">Merk & Model</span>
                                <div class="fw-bold text-dark fs-6">{{ $car->brand }} {{ $car->model }}</div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <span class="text-muted small d-block">Kategori Armada</span>
                                <div class="fw-bold fs-6" style="color: var(--rubick-blue, #1b3bbb);">{{ $car->category }}</div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <span class="text-muted small d-block">Nomor Registrasi / Plat</span>
                                <div class="font-monospace fw-bold text-dark fs-6">{{ $car->plate_number }}</div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <span class="text-muted small d-block">Tahun Produksi</span>
                                <div class="fw-bold text-dark fs-6">{{ $car->year }}</div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <span class="text-muted small d-block">Tipe Transmisi</span>
                                <div class="fw-bold text-dark fs-6">{{ ucfirst($car->transmission ?? 'Manual') }}</div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <span class="text-muted small d-block">Bahan Bakar</span>
                                <div class="fw-bold text-dark fs-6">{{ ucfirst($car->fuel_type ?? 'Bensin') }}</div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <span class="text-muted small d-block">Kapasitas Kursi</span>
                                <div class="fw-bold text-dark fs-6">{{ $car->seat_capacity ?? 7 }} Orang Penumpang</div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="p-3 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <span class="text-muted small d-block">Warna Eksterior</span>
                                <div class="fw-bold text-dark fs-6">{{ $car->color ?? 'Standar Pabrik' }}</div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="p-3 rounded-3" style="background: #eff6ff; border: 1px solid #bfdbfe;">
                                <span class="text-primary small d-block fw-semibold">Tarif Sewa Harian</span>
                                <div class="fw-extrabold text-primary fs-5">Rp {{ number_format($car->price_per_day, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Operations & Booking History -->
        <div class="col-lg-5">
            <!-- Quick Status Updater Card -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-4">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fas fa-toggle-on me-2 text-primary"></i>Ubah Status Kesiapan
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.cars.updateStatus', $car) }}" method="POST" class="m-0">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-semibold">Pilih Status Operasional:</label>
                            <select name="status" class="form-select" style="border-radius: 10px;">
                                <option value="available" {{ $car->status == 'available' ? 'selected' : '' }}>✓ Siap Jalan (Tersedia disewa)</option>
                                <option value="rented" {{ $car->status == 'rented' ? 'selected' : '' }}>⏱ Sedang Disewa (Digunakan customer)</option>
                                <option value="maintenance" {{ $car->status == 'maintenance' ? 'selected' : '' }}>🔧 Dalam Perawatan Bengkel</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 d-inline-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-floppy-disk"></i>
                            <span>Simpan Status Unit</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Booking History Card -->
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-bottom p-4 d-flex align-items-center justify-content-between">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fas fa-calendar-check me-2 text-primary"></i>Riwayat Reservasi Unit
                    </h6>
                    <span class="badge bg-light text-dark">{{ $bookings->total() }} total</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive border-0">
                        <table class="table align-middle table-hover mb-0" style="font-size: 0.85rem;">
                            <thead style="background: #f8fafc;">
                                <tr>
                                    <th class="ps-4">Pelanggan</th>
                                    <th>Periode</th>
                                    <th>Total</th>
                                    <th class="pe-4 text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $booking->customer_name }}</div>
                                            <small class="text-muted">{{ $booking->customer_phone }}</small>
                                        </td>
                                        <td>
                                            <div>{{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/y') }}</div>
                                            <small class="text-muted">s/d {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/y') }}</small>
                                        </td>
                                        <td>
                                            <span class="fw-semibold text-dark">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="pe-4 text-end">
                                            @if($booking->status == 'confirmed' || $booking->status == 'completed')
                                                <span class="badge" style="background: #ecfdf5; color: #047857;">Selesai</span>
                                            @elseif($booking->status == 'pending')
                                                <span class="badge" style="background: #fffbeb; color: #b45309;">Pending</span>
                                            @else
                                                <span class="badge" style="background: #fff1f2; color: #be123c;">Batal</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted small">
                                            Belum ada riwayat booking untuk unit ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($bookings->hasPages())
                        <div class="p-3 border-top">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
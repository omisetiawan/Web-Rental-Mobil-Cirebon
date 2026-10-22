@extends('layouts.admin')

@section('title', 'Manajemen Mobil')

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
                        <i class="fas fa-car-side"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-0">Inventaris Armada Kendaraan</h4>
                </div>
                <p class="text-muted small mb-0 ms-md-4 ps-md-3">
                    Pantau ketersediaan armada, ubah status operasional, perbarui tarif sewa harian, dan kelola spesifikasi unit secara terpusat.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <!-- Unit Diarsipkan Button -->
                <a href="{{ route('admin.cars.trashed') }}" class="btn btn-rubick-outline d-inline-flex align-items-center gap-2" title="Lihat mobil yang dinonaktifkan">
                    <i class="far fa-trash-can text-danger"></i>
                    <span>Unit Diarsipkan</span>
                    @if(isset($trashedCount) && $trashedCount > 0)
                        <span class="badge bg-danger rounded-pill px-2" style="font-size: 0.7rem;">{{ $trashedCount }}</span>
                    @endif
                </a>

                <!-- Export / Print Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-rubick-outline dropdown-toggle d-inline-flex align-items-center gap-1.5" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-arrow-up-from-bracket text-secondary"></i>
                        <span>Ekspor</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 p-1" style="min-width: 170px;">
                        <li>
                            <button class="dropdown-item py-2 rounded-2 small" onclick="window.print()">
                                <i class="fas fa-print me-2 text-muted"></i> Cetak Daftar (Print)
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item py-2 rounded-2 small" onclick="exportTableToCSV('daftar-armada-rentgo.csv')">
                                <i class="fas fa-file-csv me-2 text-success"></i> Ekspor ke CSV / Excel
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Tambah Mobil Baru -->
                <a href="{{ route('admin.cars.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Mobil Baru</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------
         KPI STAT METRIC FILTER CARDS (Rubick 4-Grid)
    ---------------------------------------------------- -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Armada -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 filter-stat-card active" data-filter="all" style="cursor: pointer; border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Total Armada</span>
                        <h3 class="fw-extrabold text-dark mb-0 mt-1" style="font-size: 1.65rem;">{{ $stats->total }}</h3>
                        <small class="text-muted" style="font-size: 0.75rem;">100% unit terdaftar</small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: var(--rubick-blue-light); color: var(--rubick-blue); font-size: 1.3rem;">
                        <i class="fas fa-car"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Siap Jalan -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 filter-stat-card" data-filter="available" style="cursor: pointer; border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Siap Jalan (Ready)</span>
                        <h3 class="fw-extrabold text-dark mb-0 mt-1" style="font-size: 1.65rem;">{{ $stats->available }}</h3>
                        <small class="text-success fw-semibold" style="font-size: 0.75rem;">
                            <i class="fas fa-check-circle me-1"></i>{{ $stats->total > 0 ? round(($stats->available / $stats->total) * 100) : 0 }}% kapasitas siap
                        </small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: #ecfdf5; color: #059669; font-size: 1.3rem;">
                        <i class="fas fa-shield-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Sedang Disewa -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 filter-stat-card" data-filter="rented" style="cursor: pointer; border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Sedang Disewa</span>
                        <h3 class="fw-extrabold text-dark mb-0 mt-1" style="font-size: 1.65rem;">{{ $stats->rented }}</h3>
                        <small class="text-warning fw-semibold" style="font-size: 0.75rem;">
                            <i class="fas fa-key me-1"></i>{{ $stats->total > 0 ? round(($stats->rented / $stats->total) * 100) : 0 }}% aktif di jalan
                        </small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: #fffbeb; color: #d97706; font-size: 1.3rem;">
                        <i class="fas fa-road"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Perawatan Bengkel -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 filter-stat-card" data-filter="maintenance" style="cursor: pointer; border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Perawatan Bengkel</span>
                        <h3 class="fw-extrabold text-dark mb-0 mt-1" style="font-size: 1.65rem;">{{ $stats->maintenance }}</h3>
                        <small class="text-danger fw-semibold" style="font-size: 0.75rem;">
                            <i class="fas fa-wrench me-1"></i>Servis berkala
                        </small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: #fff1f2; color: #e11d48; font-size: 1.3rem;">
                        <i class="fas fa-screwdriver-wrench"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------
         MAIN CARS INVENTORY CARD & TOOLBAR
    ---------------------------------------------------- -->
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 16px;">
        <!-- Filter Toolbar -->
        <div class="card-header bg-transparent border-bottom p-3 p-md-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <!-- Search & Filter Controls -->
                <div class="d-flex align-items-center gap-2 flex-wrap flex-grow-1" style="max-width: 900px;">
                    <!-- Live Search Input -->
                    <div class="rubick-search-pill" style="min-width: 250px; flex-grow: 1;">
                        <i class="fas fa-search"></i>
                        <input type="text" id="carTableSearch" placeholder="Cari merk, model, nomor plat, tipe..." value="{{ request('search') }}">
                    </div>

                    <!-- Filter Brand -->
                    <select id="filterBrand" class="form-select form-select-sm" style="width: 145px; border-radius: 9999px;">
                        <option value="">Semua Merk</option>
                        @if(isset($brands))
                            @foreach($brands as $brand)
                                <option value="{{ strtolower($brand) }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        @else
                            <option value="toyota">Toyota</option>
                            <option value="honda">Honda</option>
                            <option value="mitsubishi">Mitsubishi</option>
                            <option value="daihatsu">Daihatsu</option>
                            <option value="suzuki">Suzuki</option>
                        @endif
                    </select>

                    <!-- Filter Kategori -->
                    <select id="filterCategory" class="form-select form-select-sm" style="width: 150px; border-radius: 9999px;">
                        <option value="">Semua Kategori</option>
                        <option value="mpv family">MPV Family</option>
                        <option value="suv premium">SUV Premium</option>
                        <option value="city car">City Car</option>
                        <option value="luxury / vip">Luxury / VIP</option>
                    </select>

                    <!-- Filter Transmisi -->
                    <select id="filterTransmission" class="form-select form-select-sm" style="width: 150px; border-radius: 9999px;">
                        <option value="">Semua Transmisi</option>
                        <option value="automatic" {{ strtolower(request('transmission', '')) == 'automatic' ? 'selected' : '' }}>Automatic (Matic)</option>
                        <option value="manual" {{ strtolower(request('transmission', '')) == 'manual' ? 'selected' : '' }}>Manual</option>
                    </select>

                    <!-- Filter Status -->
                    <select id="filterStatus" class="form-select form-select-sm" style="width: 145px; border-radius: 9999px;">
                        <option value="">Semua Status</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Siap Jalan</option>
                        <option value="rented" {{ request('status') == 'rented' ? 'selected' : '' }}>Sedang Disewa</option>
                        <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Perawatan</option>
                    </select>

                    <!-- Reset Filter Button -->
                    <button id="btnResetFilter" class="btn btn-sm btn-rubick-outline rounded-pill d-none" type="button" title="Bersihkan semua filter">
                        <i class="fas fa-rotate-left me-1"></i> Reset
                    </button>
                </div>

                <!-- Showing Counter -->
                <div class="text-muted small fw-semibold">
                    Menampilkan <span id="showingCount" class="text-dark fw-bold">{{ $cars->total() }}</span> Unit Armada
                </div>
            </div>
        </div>

        <!-- Table View -->
        <div class="card-body p-0">
            <div class="table-responsive border-0">
                <table class="table align-middle table-hover mb-0" id="carsTable">
                    <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                        <tr>
                            <th class="ps-4" style="width: 45px;">#</th>
                            <th style="min-width: 260px;">Unit Kendaraan</th>
                            <th style="min-width: 160px;">No. Plat & Warna</th>
                            <th style="min-width: 150px;">Spesifikasi</th>
                            <th style="min-width: 140px;">Tarif Sewa</th>
                            <th style="min-width: 150px;">Status Kesiapan</th>
                            <th class="text-end pe-4" style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cars as $car)
                            @php
                                $catName = $car->category;
                                $catBadgeStyle = match($catName) {
                                    'SUV Premium' => 'background: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd;',
                                    'City Car' => 'background: #d1fae5; color: #059669; border: 1px solid #a7f3d0;',
                                    'Luxury / VIP' => 'background: #fef3c7; color: #d97706; border: 1px solid #fde68a;',
                                    default => 'background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe;',
                                };
                            @endphp
                            <tr class="car-table-row" 
                                data-brand="{{ strtolower($car->brand) }}" 
                                data-category="{{ strtolower($catName) }}"
                                data-transmission="{{ strtolower($car->transmission ?? '') }}"
                                data-status="{{ strtolower($car->status) }}"
                                data-search="{{ strtolower($car->brand . ' ' . $car->model . ' ' . $car->plate_number . ' ' . $car->color . ' ' . $catName . ' ' . $car->transmission . ' ' . $car->fuel_type) }}">
                                
                                <!-- No -->
                                <td class="ps-4 text-muted fw-semibold small">
                                    {{ sprintf('%02d', $loop->iteration + ($cars->currentPage() - 1) * $cars->perPage()) }}
                                </td>

                                <!-- Vehicle Photo & Info -->
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <!-- Photo Thumbnail with Zoom Effect -->
                                        <div class="rounded-3 overflow-hidden border position-relative car-thumb-wrapper" 
                                             style="width: 72px; height: 50px; flex-shrink: 0; background-color: #f8fafc; cursor: pointer;"
                                             onclick="openQuickView({{ $car->id }})">
                                            <img src="{{ $car->image_url }}" 
                                                 alt="{{ $car->brand }} {{ $car->model }}" 
                                                 class="car-thumb-img"
                                                 style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.25s ease;"
                                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=200&auto=format&fit=crop';">
                                            @if($car->gallery_count > 0)
                                                <span class="position-absolute bottom-0 end-0 bg-dark text-white rounded-start px-1" style="font-size: 0.6rem; opacity: 0.85;">
                                                    <i class="fas fa-camera"></i> {{ $car->gallery_count }}
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Title & Badges -->
                                        <div>
                                            <a href="{{ route('admin.cars.show', $car) }}" class="fw-bold text-dark text-decoration-none text-hover-primary fs-6 d-block">
                                                {{ $car->brand }} {{ $car->model }}
                                            </a>
                                            <div class="d-flex align-items-center gap-1.5 mt-1">
                                                <span class="badge" style="background: #f1f5f9; color: #475569; font-size: 0.68rem; font-weight: 600;">
                                                    {{ $car->year }}
                                                </span>
                                                <span class="badge" style="{{ $catBadgeStyle }} font-size: 0.68rem; font-weight: 600;">
                                                    {{ $catName }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Plate Number & Color -->
                                <td>
                                    <div class="d-inline-block font-monospace fw-bold px-2 py-0.5 rounded border text-dark plate-pill" style="background-color: #f8fafc; font-size: 0.78rem; letter-spacing: 0.05em; border-color: #cbd5e1 !important;">
                                        {{ $car->plate_number }}
                                    </div>
                                    <div class="text-muted small mt-1" style="font-size: 0.78rem;">
                                        <i class="fas fa-circle me-1" style="font-size: 0.5rem; color: #94a3b8;"></i>{{ $car->color ?? 'Standar' }}
                                        <span class="mx-1 text-slate-300">•</span>
                                        <i class="fas fa-user-group me-1" style="font-size: 0.65rem; color: #94a3b8;"></i>{{ $car->seat_capacity ?? '7' }} Seat
                                    </div>
                                </td>

                                <!-- Specs (Transmission & Fuel) -->
                                <td>
                                    <div>
                                        @if(strtolower($car->transmission) == 'automatic')
                                            <span class="badge" style="background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; font-size: 0.72rem;">
                                                <i class="fas fa-circle-notch fa-spin-pulse me-1" style="font-size: 0.65rem;"></i> Matic
                                            </span>
                                        @else
                                            <span class="badge" style="background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; font-size: 0.72rem;">
                                                <i class="fas fa-gear me-1" style="font-size: 0.65rem;"></i> Manual
                                            </span>
                                        @endif
                                    </div>
                                    <div class="text-muted small mt-1" style="font-size: 0.78rem;">
                                        <i class="fas fa-gas-pump me-1 text-secondary" style="font-size: 0.7rem;"></i>{{ ucfirst($car->fuel_type ?? 'Bensin') }}
                                    </div>
                                </td>

                                <!-- Rental Price -->
                                <td>
                                    <div class="fw-bold text-dark fs-6">
                                        Rp {{ number_format($car->price_per_day, 0, ',', '.') }}
                                    </div>
                                    <small class="text-muted" style="font-size: 0.75rem;">/ 24 jam</small>
                                </td>

                                <!-- Live Status Switcher Dropdown -->
                                <td>
                                    <form action="{{ route('admin.cars.updateStatus', $car) }}" method="POST" class="m-0 status-form">
                                        @csrf
                                        <select name="status" 
                                                onchange="this.form.submit()" 
                                                class="form-select form-select-sm status-dropdown-select"
                                                style="width: 140px; border-radius: 9999px; font-size: 0.78rem; font-weight: 600; cursor: pointer;
                                                @if($car->status == 'available') background-color: #ecfdf5; color: #047857; border-color: #a7f3d0;
                                                @elseif($car->status == 'rented') background-color: #fffbeb; color: #b45309; border-color: #fde68a;
                                                @else background-color: #fff1f2; color: #be123c; border-color: #fecdd3; @endif">
                                            <option value="available" {{ $car->status == 'available' ? 'selected' : '' }}>● Siap Jalan</option>
                                            <option value="rented" {{ $car->status == 'rented' ? 'selected' : '' }}>● Sedang Disewa</option>
                                            <option value="maintenance" {{ $car->status == 'maintenance' ? 'selected' : '' }}>● Perawatan</option>
                                        </select>
                                    </form>
                                </td>

                                <!-- Actions -->
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-1">
                                        <!-- Quick View Modal Trigger -->
                                        <button type="button" 
                                                class="btn btn-sm btn-rubick-outline px-2 py-1" 
                                                onclick="openQuickView({{ $car->id }})"
                                                title="Lihat Pratinjau Cepat">
                                            <i class="far fa-eye text-primary"></i>
                                        </button>

                                        <!-- Edit Link -->
                                        <a href="{{ route('admin.cars.edit', $car) }}" 
                                           class="btn btn-sm btn-rubick-outline px-2 py-1" 
                                           title="Ubah Data Armada">
                                            <i class="far fa-pen-to-square text-secondary"></i>
                                        </a>

                                        <!-- Delete / Archive Trigger -->
                                        <button type="button" 
                                                class="btn btn-sm btn-rubick-outline px-2 py-1 text-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteCarModal{{ $car->id }}"
                                                title="Arsipkan Mobil">
                                            <i class="far fa-trash-can"></i>
                                        </button>
                                    </div>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="deleteCarModal{{ $car->id }}" tabindex="-1" aria-hidden="true" style="text-align: left;">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                                                <div class="modal-body p-4 text-center">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                                         style="width: 52px; height: 52px; background-color: #fff1f2; color: #e11d48; font-size: 1.5rem;">
                                                        <i class="far fa-trash-can"></i>
                                                    </div>
                                                    <h6 class="fw-bold text-dark mb-1">Arsipkan Mobil Ini?</h6>
                                                    <p class="text-muted small mb-3">
                                                        Unit <strong>{{ $car->brand }} {{ $car->model }}</strong> ({{ $car->plate_number }}) akan dinonaktifkan dan dipindahkan ke folder arsip.
                                                    </p>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <button type="button" class="btn btn-sm btn-rubick-outline px-3" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="m-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger px-3">
                                                                Ya, Arsipkan
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
                                            <i class="fas fa-car fa-lg"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">Tidak Ada Armada Ditemukan</h6>
                                        <p class="text-muted small mb-3">Tidak ada unit kendaraan yang sesuai dengan kriteria pencarian atau filter Anda.</p>
                                        <a href="{{ route('admin.cars.index') }}" class="btn btn-sm btn-rubick-outline me-2">
                                            <i class="fas fa-rotate-left me-1"></i> Reset Pencarian
                                        </a>
                                        <a href="{{ route('admin.cars.create') }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus me-1"></i> Tambah Mobil Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            @if($cars->hasPages())
                <div class="p-3.5 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <small class="text-muted">
                        Menampilkan {{ $cars->firstItem() }} sampai {{ $cars->lastItem() }} dari {{ $cars->total() }} kendaraan armada
                    </small>
                    <div class="m-0">
                        {{ $cars->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>

<!-- ----------------------------------------------------
     QUICK VIEW CAR MODAL (AJAX / Client-Side Preview)
---------------------------------------------------- -->
<div class="modal fade" id="carQuickViewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header border-bottom p-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: var(--rubick-blue-light); color: var(--rubick-blue);">
                        <i class="fas fa-car"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark mb-0" id="quickModalTitle">Detail Kendaraan</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <!-- Photo -->
                    <div class="col-md-5">
                        <div class="rounded-3 overflow-hidden border shadow-xs" style="height: 220px; background: #f8fafc;">
                            <img id="quickModalImg" src="" alt="Mobil" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div class="mt-3 text-center">
                            <span class="badge" id="quickModalStatusBadge" style="font-size: 0.8rem; padding: 0.45rem 0.85rem; border-radius: 9999px;">
                                Siap Jalan
                            </span>
                        </div>
                    </div>

                    <!-- Specs Details Grid -->
                    <div class="col-md-7">
                        <div class="d-flex align-items-baseline justify-content-between mb-2">
                            <h4 class="fw-bold text-dark mb-0" id="quickModalName">Toyota Avanza</h4>
                            <div class="font-monospace fw-bold px-2 py-0.5 rounded border text-dark" id="quickModalPlate" style="background: #f8fafc; font-size: 0.85rem;">
                                E 1234 AB
                            </div>
                        </div>

                        <div class="p-3 rounded-3 mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="row g-2 text-sm">
                                <div class="col-6">
                                    <span class="text-muted small">Tahun Pembuatan:</span>
                                    <div class="fw-semibold text-dark" id="quickModalYear">2024</div>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted small">Transmisi:</span>
                                    <div class="fw-semibold text-dark" id="quickModalTrans">Automatic</div>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted small">Bahan Bakar:</span>
                                    <div class="fw-semibold text-dark" id="quickModalFuel">Bensin</div>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted small">Kapasitas Kursi:</span>
                                    <div class="fw-semibold text-dark" id="quickModalSeats">7 Penumpang</div>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted small">Warna Bodi:</span>
                                    <div class="fw-semibold text-dark" id="quickModalColor">Hitam</div>
                                </div>
                                <div class="col-6">
                                    <span class="text-muted small">Tarif Sewa:</span>
                                    <div class="fw-bold text-primary fs-6" id="quickModalPrice">Rp 350.000 / hari</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-end gap-2 pt-2">
                            <a id="quickModalFullDetailBtn" href="#" class="btn btn-sm btn-rubick-outline px-3">
                                <i class="fas fa-up-right-from-square me-1"></i> Buka Halaman Lengkap
                            </a>
                            <a id="quickModalEditBtn" href="#" class="btn btn-sm btn-primary px-3">
                                <i class="far fa-pen-to-square me-1"></i> Edit Data
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
// Car data store for quick view modal
const carsDataMap = {
    @foreach($cars as $car)
        {{ $car->id }}: {
            id: {{ $car->id }},
            brand: "{{ addslashes($car->brand) }}",
            model: "{{ addslashes($car->model) }}",
            plate_number: "{{ addslashes($car->plate_number) }}",
            year: "{{ addslashes($car->year) }}",
            transmission: "{{ addslashes(ucfirst($car->transmission ?? 'Manual')) }}",
            fuel_type: "{{ addslashes(ucfirst($car->fuel_type ?? 'Bensin')) }}",
            seat_capacity: "{{ $car->seat_capacity ?? 7 }}",
            color: "{{ addslashes($car->color ?? 'Standar') }}",
            price: "Rp {{ number_format($car->price_per_day, 0, ',', '.') }}",
            status: "{{ $car->status }}",
            image_url: "{{ $car->image_url }}",
            show_url: "{{ route('admin.cars.show', $car) }}",
            edit_url: "{{ route('admin.cars.edit', $car) }}"
        },
    @endforeach
};

function openQuickView(carId) {
    const car = carsDataMap[carId];
    if (!car) return;

    document.getElementById('quickModalTitle').textContent = car.brand + ' ' + car.model;
    document.getElementById('quickModalName').textContent = car.brand + ' ' + car.model;
    document.getElementById('quickModalPlate').textContent = car.plate_number;
    document.getElementById('quickModalImg').src = car.image_url;
    document.getElementById('quickModalYear').textContent = car.year;
    document.getElementById('quickModalTrans').textContent = car.transmission;
    document.getElementById('quickModalFuel').textContent = car.fuel_type;
    document.getElementById('quickModalSeats').textContent = car.seat_capacity + ' Penumpang';
    document.getElementById('quickModalColor').textContent = car.color;
    document.getElementById('quickModalPrice').textContent = car.price + ' / hari';

    // Status badge styling
    const badge = document.getElementById('quickModalStatusBadge');
    if (car.status === 'available') {
        badge.textContent = '✓ Siap Jalan (Tersedia)';
        badge.style.backgroundColor = '#ecfdf5';
        badge.style.color = '#047857';
        badge.style.border = '1px solid #a7f3d0';
    } else if (car.status === 'rented') {
        badge.textContent = '⏱ Sedang Disewa';
        badge.style.backgroundColor = '#fffbeb';
        badge.style.color = '#b45309';
        badge.style.border = '1px solid #fde68a';
    } else {
        badge.textContent = '🔧 Dalam Perawatan';
        badge.style.backgroundColor = '#fff1f2';
        badge.style.color = '#be123c';
        badge.style.border = '1px solid #fecdd3';
    }

    document.getElementById('quickModalFullDetailBtn').href = car.show_url;
    document.getElementById('quickModalEditBtn').href = car.edit_url;

    const modal = new bootstrap.Modal(document.getElementById('carQuickViewModal'));
    modal.show();
}

// Client-Side Live Filter & Status Tab System
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('carTableSearch');
    const filterBrand = document.getElementById('filterBrand');
    const filterCategory = document.getElementById('filterCategory');
    const filterTransmission = document.getElementById('filterTransmission');
    const filterStatus = document.getElementById('filterStatus');
    const btnResetFilter = document.getElementById('btnResetFilter');
    const statCards = document.querySelectorAll('.filter-stat-card');
    const rows = document.querySelectorAll('.car-table-row');
    const countBadge = document.getElementById('showingCount');

    let currentStatFilter = 'all';

    function applyFilters() {
        const query = (searchInput?.value || '').toLowerCase().trim();
        const brand = (filterBrand?.value || '').toLowerCase().trim();
        const cat = (filterCategory?.value || '').toLowerCase().trim();
        const trans = (filterTransmission?.value || '').toLowerCase().trim();
        const statusSelect = (filterStatus?.value || '').toLowerCase().trim();

        let visibleCount = 0;

        rows.forEach(row => {
            const rowSearch = row.getAttribute('data-search') || '';
            const rowBrand = row.getAttribute('data-brand') || '';
            const rowCategory = row.getAttribute('data-category') || '';
            const rowTrans = row.getAttribute('data-transmission') || '';
            const rowStatus = row.getAttribute('data-status') || '';

            const matchQuery = !query || rowSearch.includes(query);
            const matchBrand = !brand || rowBrand.includes(brand);
            const matchCategory = !cat || rowCategory === cat;
            const matchTrans = !trans || rowTrans.includes(trans);
            
            // Priority: if filterStatus is chosen, use it; otherwise use currentStatFilter from cards
            const activeStatusCriterion = statusSelect || (currentStatFilter !== 'all' ? currentStatFilter : '');
            const matchStatus = !activeStatusCriterion || (rowStatus === activeStatusCriterion);

            if (matchQuery && matchBrand && matchCategory && matchTrans && matchStatus) {
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
        if (query || brand || cat || trans || statusSelect || currentStatFilter !== 'all') {
            btnResetFilter?.classList.remove('d-none');
        } else {
            btnResetFilter?.classList.add('d-none');
        }
    }

    // Input listeners
    searchInput?.addEventListener('input', applyFilters);
    filterBrand?.addEventListener('change', applyFilters);
    filterCategory?.addEventListener('change', applyFilters);
    filterTransmission?.addEventListener('change', applyFilters);
    filterStatus?.addEventListener('change', function() {
        // synchronize with stat cards
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

    // Stat card click listeners
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

    // Reset button
    btnResetFilter?.addEventListener('click', function() {
        if (searchInput) searchInput.value = '';
        if (filterBrand) filterBrand.value = '';
        if (filterCategory) filterCategory.value = '';
        if (filterTransmission) filterTransmission.value = '';
        if (filterStatus) filterStatus.value = '';
        currentStatFilter = 'all';
        statCards.forEach(c => c.classList.remove('active'));
        document.querySelector('.filter-stat-card[data-filter="all"]')?.classList.add('active');
        applyFilters();
    });
});

// Export Table to CSV
function exportTableToCSV(filename) {
    const rows = document.querySelectorAll('#carsTable tr');
    let csv = [];
    
    rows.forEach(row => {
        // Skip hidden filtered rows
        if (row.style.display === 'none') return;
        
        let rowData = [];
        const cols = row.querySelectorAll('th, td');
        // Extract text up to column 6 (skip actions)
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

/* Hover thumbnail zoom */
.car-thumb-wrapper:hover .car-thumb-img {
    transform: scale(1.08);
}

.text-hover-primary:hover {
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

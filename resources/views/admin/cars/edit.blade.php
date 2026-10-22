@extends('layouts.admin')

@section('title', 'Edit Mobil - ' . $car->brand . ' ' . $car->model)

@section('content')
<div class="container-fluid p-0">

    <!-- Page Header Card -->
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: var(--rubick-blue-light); color: var(--rubick-blue);">
                        <i class="fas fa-pen-to-square"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-0">Ubah Data Armada: {{ $car->brand }} {{ $car->model }}</h4>
                </div>
                <p class="text-muted small mb-0 ms-md-4 ps-md-2">
                    Perbarui informasi spesifikasi, nomor plat polisi, tarif sewa harian, atau status operasional unit.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.cars.show', $car) }}" class="btn btn-rubick-outline">
                    <i class="far fa-eye me-1.5 text-primary"></i>
                    <span>Lihat Detail</span>
                </a>
                <a href="{{ route('admin.cars.index') }}" class="btn btn-rubick-outline">
                    <i class="fas fa-arrow-left me-1.5"></i>
                    <span>Kembali ke Daftar</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
        <div class="card-header bg-transparent border-bottom p-4">
            <h6 class="fw-bold text-dark mb-0">
                <i class="fas fa-sliders me-2 text-primary"></i>Formulir Pembaruan Data Kendaraan
            </h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.cars.update', $car) }}" method="POST" id="carEditForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Section 1: Informasi Utama Kendaraan -->
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 pb-2 mb-3 border-bottom">
                        <span class="badge bg-primary rounded-circle" style="width: 22px; height: 22px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center;">1</span>
                        <h6 class="fw-bold text-dark mb-0">Informasi Dasar & Identitas</h6>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="brand" class="form-label small fw-bold text-secondary">
                                Merk Kendaraan <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('brand') is-invalid @enderror" 
                                   id="brand" 
                                   name="brand" 
                                   value="{{ old('brand', $car->brand) }}" 
                                   required>
                            @error('brand')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="model" class="form-label small fw-bold text-secondary">
                                Model / Tipe Kendaraan <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('model') is-invalid @enderror" 
                                   id="model" 
                                   name="model" 
                                   value="{{ old('model', $car->model) }}" 
                                   required>
                            @error('model')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="category" class="form-label small fw-bold text-secondary">
                                Kategori Armada <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" 
                                    name="category" 
                                    required>
                                <option value="MPV Family" {{ old('category', $car->category) == 'MPV Family' ? 'selected' : '' }}>MPV Family (Avanza, Innova, Ertiga)</option>
                                <option value="SUV Premium" {{ old('category', $car->category) == 'SUV Premium' ? 'selected' : '' }}>SUV Premium (Fortuner, Pajero, HR-V)</option>
                                <option value="City Car" {{ old('category', $car->category) == 'City Car' ? 'selected' : '' }}>City Car (Brio, Yaris, Agya)</option>
                                <option value="Luxury / VIP" {{ old('category', $car->category) == 'Luxury / VIP' ? 'selected' : '' }}>Luxury / VIP (Alphard, Civic, Camry)</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="plate_number" class="form-label small fw-bold text-secondary">
                                Nomor Plat Polisi <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control font-monospace @error('plate_number') is-invalid @enderror" 
                                   id="plate_number" 
                                   name="plate_number" 
                                   value="{{ old('plate_number', $car->plate_number) }}" 
                                   required>
                            @error('plate_number')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="year" class="form-label small fw-bold text-secondary">
                                Tahun Produksi <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('year') is-invalid @enderror" 
                                   id="year" 
                                   name="year" 
                                   value="{{ old('year', $car->year) }}" 
                                   required>
                            @error('year')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="color" class="form-label small fw-bold text-secondary">
                                Warna Eksterior
                            </label>
                            <input type="text" 
                                   class="form-control @error('color') is-invalid @enderror" 
                                   id="color" 
                                   name="color" 
                                   value="{{ old('color', $car->color) }}" 
                                   placeholder="Contoh: Hitam Metalik">
                            @error('color')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Spesifikasi Teknis & Kapasitas -->
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 pb-2 mb-3 border-bottom">
                        <span class="badge bg-primary rounded-circle" style="width: 22px; height: 22px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center;">2</span>
                        <h6 class="fw-bold text-dark mb-0">Spesifikasi Teknis & Kenyamanan</h6>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="transmission" class="form-label small fw-bold text-secondary">
                                Tipe Transmisi <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('transmission') is-invalid @enderror" id="transmission" name="transmission" required>
                                <option value="automatic" {{ old('transmission', strtolower($car->transmission)) == 'automatic' ? 'selected' : '' }}>Automatic (Matic)</option>
                                <option value="manual" {{ old('transmission', strtolower($car->transmission)) == 'manual' ? 'selected' : '' }}>Manual</option>
                            </select>
                            @error('transmission')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="fuel_type" class="form-label small fw-bold text-secondary">
                                Jenis Bahan Bakar
                            </label>
                            <select class="form-select @error('fuel_type') is-invalid @enderror" id="fuel_type" name="fuel_type">
                                <option value="bensin" {{ old('fuel_type', strtolower($car->fuel_type ?? 'bensin')) == 'bensin' ? 'selected' : '' }}>Bensin</option>
                                <option value="solar" {{ old('fuel_type', strtolower($car->fuel_type ?? '')) == 'solar' ? 'selected' : '' }}>Solar / Diesel</option>
                                <option value="hybrid" {{ old('fuel_type', strtolower($car->fuel_type ?? '')) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                <option value="listrik" {{ old('fuel_type', strtolower($car->fuel_type ?? '')) == 'listrik' ? 'selected' : '' }}>Listrik (EV)</option>
                            </select>
                            @error('fuel_type')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="seat_capacity" class="form-label small fw-bold text-secondary">
                                Kapasitas Kursi (Penumpang)
                            </label>
                            <input type="number" 
                                   class="form-control @error('seat_capacity') is-invalid @enderror" 
                                   id="seat_capacity" 
                                   name="seat_capacity" 
                                   value="{{ old('seat_capacity', $car->seat_capacity ?? 7) }}" 
                                   min="1" max="20">
                            @error('seat_capacity')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Tarif Sewa & Status Operasional -->
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 pb-2 mb-3 border-bottom">
                        <span class="badge bg-primary rounded-circle" style="width: 22px; height: 22px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center;">3</span>
                        <h6 class="fw-bold text-dark mb-0">Tarif Sewa & Status Kesiapan</h6>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="price_per_day" class="form-label small fw-bold text-secondary">
                                Tarif Sewa Harian (per 24 Jam) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted fw-bold">Rp</span>
                                <input type="number" 
                                       class="form-control @error('price_per_day') is-invalid @enderror" 
                                       id="price_per_day" 
                                       name="price_per_day" 
                                       value="{{ old('price_per_day', $car->price_per_day) }}" 
                                       min="0" step="5000" 
                                       required>
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">Format tanpa tanda titik atau koma.</small>
                            @error('price_per_day')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label small fw-bold text-secondary">
                                Status Kesiapan Operasional <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="available" {{ old('status', $car->status) == 'available' ? 'selected' : '' }}>✓ Siap Jalan (Tersedia untuk disewa)</option>
                                <option value="rented" {{ old('status', $car->status) == 'rented' ? 'selected' : '' }}>⏱ Sedang Disewa (Dalam masa pakai pelanggan)</option>
                                <option value="maintenance" {{ old('status', $car->status) == 'maintenance' ? 'selected' : '' }}>🔧 Perawatan (Di bengkel untuk servis/perbaikan)</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 4: Foto & Dokumentasi Unit -->
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 pb-2 mb-3 border-bottom">
                        <span class="badge bg-primary rounded-circle" style="width: 22px; height: 22px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center;">4</span>
                        <h6 class="fw-bold text-dark mb-0">Foto & Dokumentasi Unit</h6>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-secondary">
                                Foto Saat Ini
                            </label>
                            <div class="d-flex align-items-center gap-3 p-2 rounded-3 border bg-light">
                                <div class="rounded-2 overflow-hidden border" style="width: 80px; height: 56px; flex-shrink: 0; background: #fff;">
                                    <img src="{{ $car->image_url }}" alt="{{ $car->brand }} {{ $car->model }}" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                                <div>
                                    <span class="text-dark small fw-semibold d-block">Foto Utama Terpasang</span>
                                    <small class="text-muted">Pilih file baru di bawah jika ingin mengganti.</small>
                                </div>
                            </div>

                            <div class="mt-2">
                                <label for="image" class="form-label small text-secondary">Ganti Foto Utama</label>
                                <input type="file" 
                                       class="form-control form-control-sm @error('image') is-invalid @enderror" 
                                       id="image" 
                                       name="image" 
                                       accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="images" class="form-label small fw-bold text-secondary">
                                Tambah Galeri Foto Lainnya
                            </label>
                            <input type="file" 
                                   class="form-control form-control-sm @error('images.*') is-invalid @enderror" 
                                   id="images" 
                                   name="images[]" 
                                   multiple 
                                   accept="image/*">
                            <small class="text-muted" style="font-size: 0.75rem;">Unggah foto tambahan untuk galeri unit (interior, bagasi, dll).</small>
                            @error('images.*')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Submit Actions -->
                <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.cars.index') }}" class="btn btn-rubick-outline px-4">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary px-4 d-inline-flex align-items-center gap-2">
                        <i class="fas fa-check"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

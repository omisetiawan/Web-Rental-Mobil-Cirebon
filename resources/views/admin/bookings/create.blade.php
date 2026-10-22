@extends('layouts.admin')

@section('title', 'Tambah Booking Baru')

@section('content')
<div class="container-fluid p-0">

    <!-- Page Header Card -->
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: var(--rubick-blue-light); color: var(--rubick-blue);">
                        <i class="fas fa-plus"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-0">Tambah Reservasi Baru</h4>
                </div>
                <p class="text-muted small mb-0 ms-md-4 ps-md-2">
                    Buat pemesanan rental armada baru secara manual untuk pelanggan offline atau WhatsApp.
                </p>
            </div>
            <div>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-rubick-outline">
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
                <i class="fas fa-file-invoice me-2 text-primary"></i>Formulir Data Pemesanan
            </h6>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.bookings.store') }}" method="POST" id="bookingForm">
                @csrf

                <!-- Section 1: Customer Info -->
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 pb-2 mb-3 border-bottom">
                        <span class="badge bg-primary rounded-circle" style="width: 22px; height: 22px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center;">1</span>
                        <h6 class="fw-bold text-dark mb-0">Informasi Pelanggan</h6>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="customer_name" class="form-label small fw-bold text-secondary">
                                Nama Lengkap Pelanggan <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('customer_name') is-invalid @enderror" 
                                   id="customer_name" 
                                   name="customer_name" 
                                   value="{{ old('customer_name') }}" 
                                   placeholder="Contoh: Budi Santoso" 
                                   required>
                            @error('customer_name')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="customer_phone" class="form-label small fw-bold text-secondary">
                                Nomor WhatsApp / Telepon <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('customer_phone') is-invalid @enderror" 
                                   id="customer_phone" 
                                   name="customer_phone" 
                                   value="{{ old('customer_phone') }}" 
                                   placeholder="Contoh: 081234567890" 
                                   required>
                            @error('customer_phone')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 2: Unit Kendaraan & Status -->
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 pb-2 mb-3 border-bottom">
                        <span class="badge bg-primary rounded-circle" style="width: 22px; height: 22px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center;">2</span>
                        <h6 class="fw-bold text-dark mb-0">Pilihan Unit Kendaraan & Status</h6>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="car_id" class="form-label small fw-bold text-secondary">
                                Pilih Mobil Tersedia <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('car_id') is-invalid @enderror" id="car_id" name="car_id" required onchange="calculatePriceAuto()">
                                <option value="" disabled selected>-- Pilih Unit Armada --</option>
                                @foreach($cars as $car)
                                    <option value="{{ $car->id }}" 
                                            {{ old('car_id') == $car->id ? 'selected' : '' }} 
                                            data-price="{{ $car->price_per_day }}">
                                        {{ $car->brand }} {{ $car->model }} [{{ $car->category }}] ({{ $car->plate_number }}) - Rp {{ number_format($car->price_per_day, 0, ',', '.') }}/hari
                                    </option>
                                @endforeach
                            </select>
                            @error('car_id')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label small fw-bold text-secondary">
                                Status Reservasi <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>● Pending (Menunggu Persetujuan)</option>
                                <option value="approved" {{ old('status', 'approved') == 'approved' ? 'selected' : '' }}>● Approved (Terkonfirmasi)</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>● Completed (Selesai)</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>● Rejected (Dibatalkan)</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section 3: Tanggal Sewa & Kalkulasi Biaya -->
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 pb-2 mb-3 border-bottom">
                        <span class="badge bg-primary rounded-circle" style="width: 22px; height: 22px; font-size: 0.7rem; display: flex; align-items: center; justify-content: center;">3</span>
                        <h6 class="fw-bold text-dark mb-0">Periode Sewa & Rincian Biaya</h6>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label small fw-bold text-secondary">
                                Tanggal Mulai Sewa <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('start_date') is-invalid @enderror" 
                                   id="start_date" 
                                   name="start_date" 
                                   value="{{ old('start_date', date('Y-m-d')) }}" 
                                   required 
                                   onchange="calculatePriceAuto()">
                            @error('start_date')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="end_date" class="form-label small fw-bold text-secondary">
                                Tanggal Selesai Sewa <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   class="form-control @error('end_date') is-invalid @enderror" 
                                   id="end_date" 
                                   name="end_date" 
                                   value="{{ old('end_date', date('Y-m-d', strtotime('+1 day'))) }}" 
                                   required 
                                   onchange="calculatePriceAuto()">
                            @error('end_date')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="total_price" class="form-label small fw-bold text-secondary">
                                Total Biaya Sewa (Rp) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted fw-bold">Rp</span>
                                <input type="number" 
                                       class="form-control fw-bold text-primary @error('total_price') is-invalid @enderror" 
                                       id="total_price" 
                                       name="total_price" 
                                       value="{{ old('total_price') }}" 
                                       required 
                                       readonly>
                            </div>
                            <small class="text-muted" id="priceNote" style="font-size: 0.75rem;">Otomatis dihitung berdasarkan durasi.</small>
                            @error('total_price')
                                <div class="invalid-feedback d-block small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Submit Actions -->
                <div class="d-flex align-items-center justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-rubick-outline px-4">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary px-4 d-inline-flex align-items-center gap-2">
                        <i class="fas fa-check"></i>
                        <span>Simpan Reservasi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
function calculatePriceAuto() {
    const carSelect = document.getElementById('car_id');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const totalPriceInput = document.getElementById('total_price');
    const priceNote = document.getElementById('priceNote');

    if (!carSelect || !startDateInput || !endDateInput) return;

    const selectedOption = carSelect.options[carSelect.selectedIndex];
    const dailyPrice = selectedOption ? parseFloat(selectedOption.getAttribute('data-price') || 0) : 0;
    const startVal = startDateInput.value;
    const endVal = endDateInput.value;

    if (dailyPrice > 0 && startVal && endVal) {
        const d1 = new Date(startVal);
        const d2 = new Date(endVal);
        const diffTime = d2.getTime() - d1.getTime();
        const diffDays = Math.max(1, Math.round(diffTime / (1000 * 3600 * 24)));

        const total = diffDays * dailyPrice;
        totalPriceInput.value = total;
        priceNote.textContent = diffDays + ' hari x Rp ' + dailyPrice.toLocaleString('id-ID') + ' = Rp ' + total.toLocaleString('id-ID');
    }
}
document.addEventListener('DOMContentLoaded', calculatePriceAuto);
</script>
@endsection

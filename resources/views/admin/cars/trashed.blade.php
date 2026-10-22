@extends('layouts.admin')

@section('title', 'Unit Mobil Diarsipkan')

@section('content')
<div class="container-fluid p-0">

    <!-- Page Header Card -->
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #fff1f2; color: #e11d48;">
                        <i class="far fa-trash-can"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-0">Arsip Kendaraan Nonaktif</h4>
                </div>
                <p class="text-muted small mb-0 ms-md-4 ps-md-2">
                    Daftar unit mobil yang dinonaktifkan sementara dari operasional. Anda dapat memulihkan unit kembali aktif atau menghapus permanen.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.cars.index') }}" class="btn btn-rubick-outline">
                    <i class="fas fa-arrow-left me-1.5"></i>
                    <span>Kembali ke Inventaris</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Trashed Table Card -->
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header bg-transparent border-bottom p-3 p-md-4 d-flex align-items-center justify-content-between">
            <h6 class="fw-bold text-dark mb-0">
                <i class="fas fa-box-archive me-2 text-muted"></i>Unit Terarsip ({{ $cars->total() }})
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive border-0">
                <table class="table align-middle table-hover mb-0">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th class="ps-4" style="width: 50px;">#</th>
                            <th>Unit Kendaraan</th>
                            <th>No. Plat</th>
                            <th>Tarif Terakhir</th>
                            <th>Tanggal Diarsipkan</th>
                            <th class="text-end pe-4" style="width: 220px;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cars as $car)
                            <tr>
                                <td class="ps-4 text-muted fw-semibold small">
                                    {{ sprintf('%02d', $loop->iteration + ($cars->currentPage() - 1) * $cars->perPage()) }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 overflow-hidden border position-relative" style="width: 64px; height: 46px; flex-shrink: 0; background-color: #f8fafc;">
                                            <img src="{{ $car->image_url }}" 
                                                 alt="{{ $car->brand }} {{ $car->model }}" 
                                                 style="width: 100%; height: 100%; object-fit: cover;"
                                                 onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1549399542-7e3f8b79c341?w=120&auto=format&fit=crop';">
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-6">{{ $car->brand }} {{ $car->model }}</div>
                                            <small class="text-muted">{{ $car->year }} • {{ $car->transmission ?? 'Manual' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-inline-block font-monospace fw-bold px-2 py-0.5 rounded border text-dark" style="background-color: #f8fafc; font-size: 0.78rem;">
                                        {{ $car->plate_number }}
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-6">
                                        Rp {{ number_format($car->price_per_day, 0, ',', '.') }}
                                    </div>
                                    <small class="text-muted">/ hari</small>
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        {{ $car->deleted_at ? $car->deleted_at->translatedFormat('d M Y, H:i') : '-' }} WIB
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-2">
                                        <!-- Restore Form -->
                                        <form action="{{ route('admin.cars.restore', $car->id) }}" method="POST" class="m-0">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success px-2.5 py-1" title="Pulihkan Mobil">
                                                <i class="fas fa-rotate-left me-1"></i> Pulihkan
                                            </button>
                                        </form>

                                        <!-- Permanent Delete Modal Trigger -->
                                        <button type="button" class="btn btn-sm btn-outline-danger px-2 py-1" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#forceDeleteModal{{ $car->id }}"
                                                title="Hapus Permanen">
                                            <i class="far fa-trash-can"></i>
                                        </button>
                                    </div>

                                    <!-- Force Delete Modal -->
                                    <div class="modal fade" id="forceDeleteModal{{ $car->id }}" tabindex="-1" aria-hidden="true" style="text-align: left;">
                                        <div class="modal-dialog modal-dialog-centered modal-sm">
                                            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                                                <div class="modal-body p-4 text-center">
                                                    <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                                         style="width: 52px; height: 52px; background-color: #fff1f2; color: #e11d48; font-size: 1.5rem;">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                    </div>
                                                    <h6 class="fw-bold text-dark mb-1">Hapus Permanen?</h6>
                                                    <p class="text-muted small mb-3">
                                                        Data <strong>{{ $car->brand }} {{ $car->model }}</strong> ({{ $car->plate_number }}) akan dihapus selamanya dari database dan tidak dapat dipulihkan.
                                                    </p>
                                                    <div class="d-flex gap-2 justify-content-center">
                                                        <button type="button" class="btn btn-sm btn-rubick-outline px-3" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('admin.cars.forceDelete', $car->id) }}" method="POST" class="m-0">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger px-3">
                                                                Ya, Hapus Permanen
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
                                <td colspan="6" class="text-center py-5">
                                    <div class="p-4">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 text-muted" style="width: 56px; height: 56px; background-color: #f1f5f9;">
                                            <i class="far fa-trash-can fa-lg"></i>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-1">Tidak Ada Mobil Diarsipkan</h6>
                                        <p class="text-muted small mb-3">Semua unit armada saat ini aktif dalam sistem inventaris operasional.</p>
                                        <a href="{{ route('admin.cars.index') }}" class="btn btn-sm btn-rubick-outline">
                                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Inventaris
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($cars->hasPages())
                <div class="p-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <small class="text-muted">
                        Menampilkan {{ $cars->firstItem() }} sampai {{ $cars->lastItem() }} dari {{ $cars->total() }} kendaraan terarsip
                    </small>
                    <div class="m-0">
                        {{ $cars->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

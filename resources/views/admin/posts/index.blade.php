@extends('layouts.admin')

@section('title', 'Artikel & Yoast SEO')

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
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h4 class="fw-bold text-dark mb-0">Artikel & Yoast SEO Center</h4>
                </div>
                <p class="text-muted small mb-0 ms-md-4 ps-md-3">
                    Kelola publikasi blog, analisis keterbacaan, meta deskripsi SERP, dan kepatuhan standar Yoast SEO untuk memuncaki peringkat Google Cirebon.
                </p>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <!-- Lihat Blog Publik -->
                <a href="{{ route('landing.blog.index') }}" target="_blank" class="btn btn-rubick-outline d-inline-flex align-items-center gap-2">
                    <i class="fas fa-arrow-up-right-from-square text-secondary"></i>
                    <span>Lihat Halaman Blog</span>
                </a>

                <!-- Tulis Artikel Baru -->
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
                    <i class="fas fa-plus"></i>
                    <span>Tulis Artikel Baru</span>
                </a>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------
         KPI STAT METRIC CARDS (Yoast SEO Performance)
    ---------------------------------------------------- -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Artikel -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Total Artikel</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1" style="font-size: 1.65rem;">{{ $stats['total'] }}</h3>
                        <small class="text-muted" style="font-size: 0.75rem;">Semua draf & rilis</small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: var(--rubick-blue-light); color: var(--rubick-blue); font-size: 1.3rem;">
                        <i class="fas fa-file-lines"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Terbit Publik -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Diterbitkan (Live)</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1" style="font-size: 1.65rem;">{{ $stats['published'] }}</h3>
                        <small class="text-success fw-semibold" style="font-size: 0.75rem;">
                            <i class="fas fa-check-circle me-1"></i>Tampil di publik
                        </small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: #ecfdf5; color: #059669; font-size: 1.3rem;">
                        <i class="fas fa-globe"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Yoast SEO Bagus -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Yoast SEO Hijau (Good)</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1" style="font-size: 1.65rem;">{{ $stats['seo_good'] }}</h3>
                        <small class="text-success fw-semibold" style="font-size: 0.75rem;">
                            {{ $stats['total'] > 0 ? round(($stats['seo_good'] / $stats['total']) * 100) : 0 }}% standar optimal
                        </small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: #dcfce7; color: #15803d; font-size: 1.3rem;">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Total Pembaca -->
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100 mb-0 border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-3.5 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold" style="font-size: 0.68rem; letter-spacing: 0.06em;">Total Tayangan</span>
                        <h3 class="fw-bold text-dark mb-0 mt-1" style="font-size: 1.65rem;">{{ number_format($stats['total_views']) }}</h3>
                        <small class="text-muted" style="font-size: 0.75rem;">Akumulasi pembaca artikel</small>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 46px; height: 46px; background: #eff6ff; color: #3b82f6; font-size: 1.3rem;">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ----------------------------------------------------
         FILTER & SEARCH BAR
    ---------------------------------------------------- -->
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-body p-3">
            <form action="{{ route('admin.posts.index') }}" method="GET" class="row g-2 align-items-center">
                <!-- Search Input -->
                <div class="col-lg-4 col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted" style="border-radius: 10px 0 0 10px;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               class="form-control border-start-0" 
                               placeholder="Cari judul, keyword, atau konten..." 
                               style="border-radius: 0 10px 10px 0;">
                    </div>
                </div>

                <!-- Kategori Dropdown -->
                <div class="col-lg-2 col-md-3">
                    <select name="category" class="form-select" style="border-radius: 10px;">
                        <option value="all">Semua Kategori</option>
                        @foreach($categories as $catKey => $catLabel)
                            <option value="{{ $catKey }}" {{ request('category') === $catKey ? 'selected' : '' }}>
                                {{ $catKey }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Dropdown -->
                <div class="col-lg-2 col-md-3">
                    <select name="status" class="form-select" style="border-radius: 10px;">
                        <option value="all">Semua Status</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Diterbitkan</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draf</option>
                        <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                    </select>
                </div>

                <!-- Skor Yoast SEO Dropdown -->
                <div class="col-lg-2 col-md-6">
                    <select name="seo_score" class="form-select" style="border-radius: 10px;">
                        <option value="all">Semua Skor Yoast</option>
                        <option value="good" {{ request('seo_score') === 'good' ? 'selected' : '' }}>🟢 Baik (Good)</option>
                        <option value="ok" {{ request('seo_score') === 'ok' ? 'selected' : '' }}>🟡 Cukup (OK)</option>
                        <option value="bad" {{ request('seo_score') === 'bad' ? 'selected' : '' }}>🔴 Perlu Perbaikan</option>
                    </select>
                </div>

                <!-- Filter Actions -->
                <div class="col-lg-2 col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100" style="border-radius: 10px;">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['search', 'category', 'status', 'seo_score']))
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-light border" style="border-radius: 10px;" title="Reset Filter">
                            <i class="fas fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- ----------------------------------------------------
         POSTS DATA TABLE
    ---------------------------------------------------- -->
    <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                <thead class="bg-light text-muted small text-uppercase fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.05em;">
                    <tr>
                        <th class="ps-4 py-3" style="width: 45%;">Artikel & Target Kata Kunci</th>
                        <th class="py-3">Kategori</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Skor Yoast SEO</th>
                        <th class="py-3 text-center">Statistik</th>
                        <th class="py-3">Tanggal Rilis</th>
                        <th class="pe-4 py-3 text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($posts as $post)
                    @php
                        $seoDetails = $post->seo_score_details;
                    @endphp
                    <tr>
                        <!-- Artikel, Thumbnail, Keyword -->
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $post->image_url }}" 
                                     alt="{{ $post->image_alt ?: $post->title }}"
                                     class="rounded-3 object-fit-cover shadow-xs border flex-shrink-0" 
                                     style="width: 58px; height: 58px;"
                                     onerror="this.src='{{ asset('assets/og_image.jpg') }}'">
                                <div style="min-width: 0;">
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="fw-bold text-dark text-decoration-none d-block text-truncate mb-1" style="max-width: 380px;" title="{{ $post->title }}">
                                        {{ $post->title }}
                                    </a>
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        @if($post->focus_keyword)
                                            <span class="badge bg-light text-dark border px-2 py-1" style="font-size: 0.72rem; font-weight: 500;">
                                                <i class="fas fa-bullseye text-primary me-1"></i>{{ $post->focus_keyword }}
                                            </span>
                                        @else
                                            <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 0.72rem;">
                                                Belum ada keyword
                                            </span>
                                        @endif
                                        <span class="text-muted" style="font-size: 0.75rem;">
                                            oleh {{ $post->user ? $post->user->name : 'Admin' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Kategori -->
                        <td class="py-3">
                            <span class="badge bg-blue-light text-primary border border-primary-subtle px-2.5 py-1.5 rounded-pill" style="font-size: 0.75rem; background-color: var(--rubick-blue-light); color: var(--rubick-blue);">
                                {{ $post->category }}
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="py-3">
                            @if($post->status === 'published')
                                <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-pill d-inline-flex align-items-center gap-1.5" style="font-size: 0.75rem; background: #ecfdf5; color: #047857; border-color: #a7f3d0 !important;">
                                    <span class="rounded-circle" style="width: 6px; height: 6px; background-color: #10b981;"></span>
                                    Diterbitkan
                                </span>
                            @elseif($post->status === 'draft')
                                <span class="badge bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-pill d-inline-flex align-items-center gap-1.5" style="font-size: 0.75rem; background: #fffbeb; color: #b45309; border-color: #fde68a !important;">
                                    <span class="rounded-circle" style="width: 6px; height: 6px; background-color: #f59e0b;"></span>
                                    Draf
                                </span>
                            @else
                                <span class="badge bg-gray-50 text-gray-600 border border-gray-200 px-2.5 py-1 rounded-pill" style="font-size: 0.75rem; background: #f8fafc; color: #64748b;">
                                    Diarsipkan
                                </span>
                            @endif
                        </td>

                        <!-- Yoast SEO Score Pill -->
                        <td class="py-3">
                            <div class="d-flex flex-column gap-1">
                                <span class="badge d-inline-flex align-items-center gap-1.5 px-2.5 py-1 rounded-pill" 
                                      style="font-size: 0.75rem; width: fit-content; background-color: {{ $seoDetails['color'] }}15; color: {{ $seoDetails['color'] }}; border: 1px solid {{ $seoDetails['color'] }}40;"
                                      title="Yoast SEO Score: {{ $seoDetails['label'] }}">
                                    <i class="fas {{ $seoDetails['icon'] }}"></i>
                                    <span>{{ $seoDetails['label'] }}</span>
                                </span>
                                <small class="text-muted" style="font-size: 0.72rem;">
                                    Keterbacaan: <strong>{{ ucfirst($post->readability_score ?? 'ok') }}</strong>
                                </small>
                            </div>
                        </td>

                        <!-- Statistik: Views & Reading time -->
                        <td class="py-3 text-center">
                            <div class="d-inline-flex flex-column align-items-center">
                                <span class="fw-bold text-dark" style="font-size: 0.85rem;">
                                    <i class="far fa-eye text-primary me-1"></i>{{ number_format($post->views_count) }}
                                </span>
                                <span class="text-muted" style="font-size: 0.7rem;">
                                    {{ $post->reading_time ?? 3 }} mnt baca
                                </span>
                            </div>
                        </td>

                        <!-- Tanggal Rilis -->
                        <td class="py-3">
                            <span class="text-dark small d-block">
                                {{ $post->published_at ? $post->published_at->translatedFormat('d M Y') : 'Belum Terbit' }}
                            </span>
                            <span class="text-muted" style="font-size: 0.72rem;">
                                {{ $post->created_at->diffForHumans() }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="pe-4 py-3 text-end">
                            <div class="d-inline-flex align-items-center gap-1">
                                <!-- Preview on Frontend -->
                                @if($post->status === 'published')
                                    <a href="{{ route('landing.blog.show', $post->slug) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-light border text-secondary" 
                                       title="Lihat Halaman Publik">
                                        <i class="fas fa-arrow-up-right-from-square"></i>
                                    </a>
                                @endif

                                <!-- Edit -->
                                <a href="{{ route('admin.posts.edit', $post->id) }}" 
                                   class="btn btn-sm btn-light border text-primary" 
                                   title="Edit Artikel & SEO">
                                    <i class="fas fa-pen-to-square"></i>
                                </a>

                                <!-- Delete Trigger -->
                                <button type="button" 
                                        class="btn btn-sm btn-light border text-danger" 
                                        onclick="confirmDeletePost('{{ route('admin.posts.destroy', $post->id) }}', '{{ addslashes($post->title) }}')"
                                        title="Hapus Artikel">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-5 text-center text-muted">
                            <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                <i class="fas fa-newspaper fa-3x text-secondary opacity-50 mb-3"></i>
                                <h6 class="fw-bold text-dark">Belum Ada Artikel Ditemukan</h6>
                                <p class="small text-muted mb-3" style="max-width: 400px;">
                                    Tidak ada data artikel yang sesuai dengan kriteria filter saat ini.
                                </p>
                                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i> Buat Artikel Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
        <div class="card-footer bg-white border-top p-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <span class="small text-muted">
                Menampilkan {{ $posts->firstItem() ?? 0 }} - {{ $posts->lastItem() ?? 0 }} dari {{ $posts->total() }} artikel
            </span>
            <div>
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>

</div>

<!-- ----------------------------------------------------
     DELETE CONFIRMATION MODAL
---------------------------------------------------- -->
<div class="modal fade" id="deletePostModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow" style="border-radius: 16px;">
            <div class="modal-body p-4 text-center">
                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 54px; height: 54px; background: #fee2e2; color: #dc2626;">
                    <i class="fas fa-trash-can fa-lg"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">Hapus Artikel Ini?</h5>
                <p class="text-muted small mb-4" id="deletePostTitleDisplay">
                    Artikel ini akan dihapus secara permanen dari sistem.
                </p>
                <form id="deletePostForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light border px-3" data-bs-dismiss="modal" style="border-radius: 8px;">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-danger px-3" style="border-radius: 8px;">
                            Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDeletePost(actionUrl, postTitle) {
    const modal = new bootstrap.Modal(document.getElementById('deletePostModal'));
    document.getElementById('deletePostForm').action = actionUrl;
    document.getElementById('deletePostTitleDisplay').innerText = `Apakah Anda yakin ingin menghapus "${postTitle}"? Tindakan ini tidak dapat dibatalkan.`;
    modal.show();
}
</script>
@endsection

@extends('layouts.admin')

@section('title', 'Edit Artikel: ' . $post->title)

@section('styles')
<!-- Quill 2.0 Rich Text Editor Theme -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<style>
/* ----------------------------------------------------
   PROFESSIONAL QUILL WYSIWYG STYLING
---------------------------------------------------- */
.ql-toolbar.ql-snow {
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    border-color: #cbd5e1;
    background: #f8fafc;
    padding: 10px 14px;
    font-family: inherit;
}
.ql-container.ql-snow {
    border-bottom-left-radius: 12px;
    border-bottom-right-radius: 12px;
    border-color: #cbd5e1;
    background: #ffffff;
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    font-size: 0.95rem;
}
.ql-editor {
    min-height: 380px;
    max-height: 650px;
    overflow-y: auto;
    line-height: 1.75;
    color: #1e293b;
    padding: 1.25rem 1.5rem;
}
.ql-editor.ql-blank::before {
    color: #94a3b8;
    font-style: normal;
    font-size: 0.95rem;
}
.ql-editor h2 {
    font-size: 1.45rem;
    font-weight: 700;
    color: #0f172a;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    line-height: 1.35;
}
.ql-editor h3 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #1e293b;
    margin-top: 1.25rem;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}
.ql-editor p {
    margin-bottom: 1rem;
}
.ql-editor strong {
    font-weight: 700;
    color: #0f172a;
}
.ql-editor em {
    font-style: italic;
}
.ql-editor blockquote {
    border-left: 4px solid var(--rubick-blue, #1b3bbb);
    background: #eff6ff;
    padding: 0.75rem 1.25rem;
    margin: 1rem 0;
    border-radius: 0 8px 8px 0;
    color: #1e3a8a;
    font-style: italic;
}
.ql-editor ul, .ql-editor ol {
    padding-left: 1.5rem;
    margin-bottom: 1rem;
}
.ql-editor li {
    margin-bottom: 0.35rem;
}
.ql-editor a {
    color: #1b3bbb;
    text-decoration: underline;
}
.ql-snow .ql-picker.ql-header {
    width: 140px;
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="2"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="2"]::before {
    content: 'Heading 2 (H2)';
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="3"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="3"]::before {
    content: 'Heading 3 (H3)';
}
.ql-snow .ql-picker.ql-header .ql-picker-label:not([data-value])::before,
.ql-snow .ql-picker.ql-header .ql-picker-item:not([data-value])::before {
    content: 'Paragraf Normal';
}
</style>
@endsection

@section('content')
<div class="container-fluid p-0">

    <!-- Back & Title Bar -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.posts.index') }}" class="btn btn-light border rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;" title="Kembali ke Daftar">
                <i class="fas fa-arrow-left text-secondary"></i>
            </a>
            <div>
                <div class="d-flex align-items-center gap-2">
                    <h4 class="fw-bold text-dark mb-0">Edit Artikel & Optimasi SEO</h4>
                    @if($post->status === 'published')
                        <a href="{{ route('landing.blog.show', $post->slug) }}" target="_blank" class="badge bg-light text-primary border text-decoration-none px-2 py-1" style="font-size: 0.72rem;">
                            <i class="fas fa-arrow-up-right-from-square me-1"></i>Lihat di Web
                        </a>
                    @endif
                </div>
                <p class="text-muted small mb-0">Terakhir diperbarui: {{ $post->updated_at->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.posts.index') }}" class="btn btn-light border px-3" style="border-radius: 10px;">
                Batal
            </a>
            <button type="button" onclick="submitPostForm('draft')" class="btn btn-outline-secondary px-3" style="border-radius: 10px;">
                <i class="fas fa-bookmark me-1"></i> Simpan Draf
            </button>
            <button type="button" onclick="submitPostForm('published')" class="btn btn-primary px-4" style="border-radius: 10px;">
                <i class="fas fa-check me-1"></i> Perbarui Artikel
            </button>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="d-flex align-items-center gap-2 mb-1">
                <i class="fas fa-triangle-exclamation"></i>
                <strong>Terdapat beberapa kesalahan input:</strong>
            </div>
            <ul class="mb-0 small ps-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="postForm" action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Hidden input for Status -->
        <input type="hidden" name="status" id="statusInput" value="{{ old('status', $post->status) }}">
        <!-- Hidden inputs for calculated Yoast Scores -->
        <input type="hidden" name="seo_score" id="seoScoreInput" value="{{ old('seo_score', $post->seo_score ?? 'ok') }}">
        <input type="hidden" name="readability_score" id="readabilityScoreInput" value="{{ old('readability_score', $post->readability_score ?? 'ok') }}">

        <div class="row g-4">
            
            <!-- LEFT / MAIN CONTENT COLUMN -->
            <div class="col-lg-8">
                
                <!-- Main Post Content Card -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                    <div class="card-body p-4">
                        
                        <!-- Post Title -->
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark" style="font-size: 0.9rem;">
                                Judul Artikel <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="postTitle" 
                                   value="{{ old('title', $post->title) }}" 
                                   class="form-control form-control-lg fw-semibold" 
                                   placeholder="Contoh: 7 Tempat Wisata Cirebon Paling Populer yang Wajib Dikunjungi" 
                                   style="border-radius: 12px; font-size: 1.15rem;" 
                                   required>
                        </div>

                        <!-- Slug / Permalink -->
                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-muted d-flex justify-content-between align-items-center mb-1">
                                <span>Permalink / URL Slug</span>
                                <span class="text-primary" role="button" onclick="autoGenerateSlug()" style="font-size: 0.75rem; cursor: pointer;">
                                    <i class="fas fa-rotate me-1"></i>Generate dari Judul
                                </span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted small border-end-0" style="border-radius: 10px 0 0 10px; font-size: 0.8rem;">
                                    {{ url('/blog') }}/
                                </span>
                                <input type="text" 
                                       name="slug" 
                                       id="postSlug" 
                                       value="{{ old('slug', $post->slug) }}" 
                                       class="form-control border-start-0" 
                                       placeholder="url-artikel-cirebon" 
                                       style="border-radius: 0 10px 10px 0; font-size: 0.85rem;">
                            </div>
                            <small class="text-muted" style="font-size: 0.72rem;">Gunakan huruf kecil dan tanda hubung (-). Pastikan mengandung kata kunci fokus Anda.</small>
                        </div>

                        <!-- Excerpt / Ringkasan Singkat -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark" style="font-size: 0.9rem;">
                                Ringkasan Singkat (Excerpt)
                            </label>
                            <textarea name="excerpt" 
                                      id="postExcerpt" 
                                      rows="2" 
                                      class="form-control" 
                                      placeholder="Ringkasan pengantar 1-2 kalimat untuk kartu artikel dan pengantar pembaca..." 
                                      style="border-radius: 10px; font-size: 0.875rem;">{{ old('excerpt', $post->excerpt) }}</textarea>
                        </div>

                        <!-- Content Editor (WYSIWYG Rich Text Editor) -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.9rem;">
                                        Isi Konten Artikel <span class="text-danger">*</span>
                                    </label>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle" style="font-size: 0.7rem;">
                                        <i class="fas fa-wand-magic-sparkles me-1"></i>WYSIWYG Standar
                                    </span>
                                </div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <!-- Mode Switcher: Visual vs Kode HTML -->
                                    <div class="btn-group btn-group-sm p-0.5 bg-light rounded-2 border" role="group" aria-label="Editor Mode">
                                        <button type="button" class="btn btn-sm btn-primary active px-2.5 py-1 fw-semibold" id="btnModeVisual" onclick="switchEditorMode('visual')" style="font-size: 0.75rem; border-radius: 6px;">
                                            <i class="fas fa-eye me-1"></i> Visual
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light text-muted px-2.5 py-1 fw-semibold" id="btnModeHtml" onclick="switchEditorMode('html')" style="font-size: 0.75rem; border-radius: 6px;">
                                            <i class="fas fa-code me-1"></i> Kode HTML
                                        </button>
                                    </div>
                                    <span class="badge bg-light text-dark border px-2 py-1.5" id="wordCountBadge" style="font-size: 0.75rem;">
                                        <i class="fas fa-font me-1 text-muted"></i>0 Kata
                                    </span>
                                    <span class="badge bg-light text-muted border px-2 py-1.5" id="readingTimeBadge" style="font-size: 0.75rem;">
                                        <i class="far fa-clock me-1"></i>~{{ $post->reading_time ?? 1 }} mnt baca
                                    </span>
                                </div>
                            </div>

                            <!-- Visual WYSIWYG Container (Quill) -->
                            <div id="visualEditorWrapper">
                                <div id="quillToolbar">
                                    <span class="ql-formats">
                                        <select class="ql-header">
                                            <option selected></option>
                                            <option value="2"></option>
                                            <option value="3"></option>
                                        </select>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-bold" title="Tebal (Ctrl+B)"></button>
                                        <button class="ql-italic" title="Miring (Ctrl+I)"></button>
                                        <button class="ql-underline" title="Garis Bawah (Ctrl+U)"></button>
                                        <button class="ql-strike" title="Coret"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <select class="ql-color" title="Warna Teks"></select>
                                        <select class="ql-background" title="Warna Sorotan"></select>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-list" value="ordered" title="Daftar Nomor"></button>
                                        <button class="ql-list" value="bullet" title="Daftar Poin"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-blockquote" title="Kutipan (Blockquote)"></button>
                                        <button class="ql-code-block" title="Blok Kode"></button>
                                    </span>
                                    <span class="ql-formats">
                                        <button class="ql-link" title="Sisipkan Tautan"></button>
                                        <button class="ql-clean" title="Hapus Format"></button>
                                    </span>
                                </div>
                                <div id="quillEditor"></div>
                            </div>

                            <!-- Raw HTML Code Editor Container (Optional mode for power users) -->
                            <div id="htmlEditorWrapper" style="display: none;">
                                <div class="bg-dark text-white px-3 py-1.5 rounded-top d-flex justify-content-between align-items-center" style="font-size: 0.75rem;">
                                    <span><i class="fas fa-code me-1 text-warning"></i>Editor Sumber HTML</span>
                                    <span class="text-white-50">Perubahan akan langsung disinkronkan ke mode Visual</span>
                                </div>
                                <textarea id="rawHtmlTextarea" 
                                          rows="16" 
                                          class="form-control font-monospace border-top-0" 
                                          placeholder="Edit kode HTML di sini..." 
                                          style="border-radius: 0 0 12px 12px; font-size: 0.85rem; line-height: 1.6; background: #0f172a; color: #f8fafc;"></textarea>
                            </div>

                            <!-- Hidden Form Field for Form POST submission -->
                            <textarea name="content" id="postContent" style="display: none;" required>{{ old('content', $post->content) }}</textarea>
                            <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                                <i class="fas fa-circle-info text-primary me-1"></i>Editor visual standar: Teks diformat langsung seperti tampilan asli artikel. Gunakan subjudul H2 dan H3 untuk keterbacaan SEO.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- ----------------------------------------------------
                     YOAST SEO COCKPIT (THE AUTHENTIC YOAST SEO PANEL)
                ---------------------------------------------------- -->
                <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                    <!-- Yoast Cockpit Header -->
                    <div class="card-header bg-white p-3.5 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; background: #a4286a; color: #ffffff;">
                                <strong style="font-size: 0.95rem;">Y</strong>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">Yoast SEO Cockpit</h6>
                                <small class="text-muted" style="font-size: 0.72rem;">Standar optimasi mesin pencari Google Indonesia</small>
                            </div>
                        </div>

                        <!-- 1-Click Auto SEO & Overall Score Badge -->
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <button type="button" onclick="autoGenerateAllSeo(true)" class="btn btn-sm btn-outline-primary fw-semibold d-inline-flex align-items-center gap-1.5" style="border-radius: 8px;">
                                <i class="fas fa-wand-magic-sparkles text-primary"></i>
                                <span>⚡ Auto-Isi SEO (1-Klik)</span>
                            </button>
                            <span id="overallYoastBadge" class="badge px-3 py-1.5 rounded-pill d-inline-flex align-items-center gap-1.5" style="font-size: 0.8rem; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0;">
                                <i class="fas fa-circle-check"></i>
                                <span>🟢 Baik (Good)</span>
                            </span>
                        </div>
                    </div>

                    <!-- Yoast Navigation Tabs -->
                    <div class="bg-light px-3 pt-2 border-bottom">
                        <ul class="nav nav-tabs border-0" id="yoastTabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active fw-semibold small py-2 px-3 border-0 bg-transparent text-dark" id="tab-seo-btn" data-bs-toggle="tab" data-bs-target="#tab-seo" type="button" role="tab">
                                    <i class="fas fa-magnifying-glass text-primary me-1"></i> Optimasi SEO & SERP
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-semibold small py-2 px-3 border-0 bg-transparent text-muted" id="tab-readability-btn" data-bs-toggle="tab" data-bs-target="#tab-readability" type="button" role="tab">
                                    <i class="fas fa-book-open text-secondary me-1"></i> Keterbacaan (Readability)
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link fw-semibold small py-2 px-3 border-0 bg-transparent text-muted" id="tab-social-btn" data-bs-toggle="tab" data-bs-target="#tab-social" type="button" role="tab">
                                    <i class="fas fa-share-nodes text-secondary me-1"></i> Pratinjau Sosial (OpenGraph)
                                </button>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body p-4">
                        <div class="tab-content" id="yoastTabsContent">
                            
                            <!-- TAB 1: SEO OPTIMIZATION & SERP PREVIEW -->
                            <div class="tab-pane fade show active" id="tab-seo" role="tabpanel">
                                
                                <!-- AUTO-SEO SMART BANNER -->
                                <div class="alert alert-info border-0 shadow-xs mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-radius: 12px; background: #eff6ff; color: #1e40af;">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-wand-magic-sparkles fa-lg text-primary flex-shrink-0"></i>
                                        <div style="font-size: 0.8rem;">
                                            <strong>Mode SEO Otomatis Aktif!</strong> Jika Anda tidak mengisi kolom SEO satu per satu, sistem secara otomatis mengekstrak kata kunci fokus, memformat judul Google (50-60 huruf), dan menyusun meta deskripsi saat artikel disimpan.
                                        </div>
                                    </div>
                                    <button type="button" onclick="autoGenerateAllSeo(true)" class="btn btn-sm btn-primary px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1 flex-shrink-0" style="border-radius: 8px;">
                                        <i class="fas fa-bolt"></i>
                                        <span>Isi Otomatis Sekarang</span>
                                    </button>
                                </div>

                                <!-- Focus Keyword Input -->
                                <div class="mb-4 p-3 bg-light rounded-3 border">
                                    <label class="form-label fw-bold text-dark d-flex justify-content-between align-items-center mb-1" style="font-size: 0.88rem;">
                                        <span><i class="fas fa-bullseye text-primary me-1"></i> Frasa Kunci Utama (Focus Keyword)</span>
                                        <span class="badge bg-primary-subtle text-primary" style="font-size: 0.7rem;">Otomatis Disarankan</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="text" 
                                               name="focus_keyword" 
                                               id="focusKeyword" 
                                               value="{{ old('focus_keyword', $post->focus_keyword) }}" 
                                               class="form-control" 
                                               placeholder="Contoh: rental mobil cirebon" 
                                               style="border-radius: 8px 0 0 8px;">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" onclick="autoSuggestKeyword()" title="Rekomendasikan ulang kata kunci dari judul" style="border-radius: 0 8px 8px 0;">
                                            <i class="fas fa-rotate me-1"></i> Rekomendasi
                                        </button>
                                    </div>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                                        Kata atau frasa yang paling sering dicari calon pelanggan di Google. Sistem otomatis merekomendasikan kata kunci dari judul Anda.
                                    </small>
                                </div>

                                <!-- SERP Snippet Preview (Interactive Mobile & Desktop) -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="fw-bold text-dark small">Pratinjau Cuplikan Google (SERP Preview)</span>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-secondary active" id="btnPreviewMobile" onclick="switchSnippetView('mobile')">
                                                <i class="fas fa-mobile-screen me-1"></i> Mobile
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" id="btnPreviewDesktop" onclick="switchSnippetView('desktop')">
                                                <i class="fas fa-desktop me-1"></i> Desktop
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Google SERP Card Container -->
                                    <div class="p-3 bg-white border rounded-3 shadow-xs" id="serpContainer" style="max-width: 650px;">
                                        <!-- Breadcrumb & Favicon -->
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-light border flex-shrink-0" style="width: 22px; height: 22px;">
                                                <img src="{{ asset('assets/rentgo_light.png') }}" style="width: 14px; height: 14px; object-fit: contain;">
                                            </div>
                                            <div class="text-truncate" style="font-size: 0.8rem; line-height: 1.2;">
                                                <span class="text-dark fw-semibold">RentGo Indonesia</span>
                                                <span class="text-muted ms-1" id="serpUrlDisplay">https://rentgoindonesia.com › blog › {{ $post->slug }}</span>
                                            </div>
                                        </div>

                                        <!-- Title in Blue -->
                                        <div class="mb-1">
                                            <a href="javascript:void(0)" id="serpTitleDisplay" class="text-decoration-none fw-semibold" style="color: #1a0dab; font-size: 1.15rem; line-height: 1.3; font-family: arial, sans-serif;">
                                                {{ $post->seo_title_display }}
                                            </a>
                                        </div>

                                        <!-- Meta Description -->
                                        <div id="serpDescDisplay" class="text-secondary" style="font-size: 0.85rem; line-height: 1.4; color: #4d5156; font-family: arial, sans-serif;">
                                            {{ $post->meta_description_display }}
                                        </div>
                                    </div>
                                </div>

                                <!-- SEO Title Input & Live Meter -->
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.85rem;">
                                            Judul SEO (SEO Title)
                                        </label>
                                        <span class="small text-muted" id="seoTitleCounter" style="font-size: 0.75rem;">0 / 60 karakter</span>
                                    </div>
                                    <input type="text" 
                                           name="seo_title" 
                                           id="seoTitleInput" 
                                           value="{{ old('seo_title', $post->seo_title) }}" 
                                           class="form-control" 
                                           placeholder="Judul SEO optimal (Direkomendasikan 45 - 60 karakter)" 
                                           style="border-radius: 8px;">
                                    
                                    <!-- Progress Meter Bar -->
                                    <div class="progress mt-1.5" style="height: 6px; border-radius: 4px; background: #e2e8f0;">
                                        <div id="seoTitleProgress" class="progress-bar bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small id="seoTitleFeedback" class="text-muted d-block mt-1" style="font-size: 0.72rem;">
                                        Kosongkan jika ingin menggunakan judul utama artikel secara otomatis.
                                    </small>
                                </div>

                                <!-- Meta Description Input & Live Meter -->
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label fw-bold text-dark mb-0" style="font-size: 0.85rem;">
                                            Deskripsi Meta (Meta Description)
                                        </label>
                                        <span class="small text-muted" id="metaDescCounter" style="font-size: 0.75rem;">0 / 160 karakter</span>
                                    </div>
                                    <textarea name="meta_description" 
                                              id="metaDescInput" 
                                              rows="3" 
                                              class="form-control" 
                                              placeholder="Tulis ringkasan singkat 120 - 160 karakter yang memuat kata kunci fokus Anda..." 
                                              style="border-radius: 8px; font-size: 0.875rem;">{{ old('meta_description', $post->meta_description) }}</textarea>
                                    
                                    <!-- Progress Meter Bar -->
                                    <div class="progress mt-1.5" style="height: 6px; border-radius: 4px; background: #e2e8f0;">
                                        <div id="metaDescProgress" class="progress-bar bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small id="metaDescFeedback" class="text-muted d-block mt-1" style="font-size: 0.72rem;">
                                        Panjang optimal antara 120 hingga 160 karakter agar tidak terpotong oleh Google.
                                    </small>
                                </div>

                                <!-- Canonical URL & Index Settings Accordion -->
                                <div class="mb-4">
                                    <a class="text-decoration-none small fw-semibold text-secondary d-inline-flex align-items-center gap-1" data-bs-toggle="collapse" href="#advancedSeoCollapse" role="button">
                                        <i class="fas fa-sliders"></i> Pengaturan Lanjutan (Canonical URL & Indexing)
                                        <i class="fas fa-chevron-down ms-1" style="font-size: 0.7rem;"></i>
                                    </a>
                                    <div class="collapse mt-2" id="advancedSeoCollapse">
                                        <div class="p-3 bg-light rounded-3 border">
                                            <div class="mb-3">
                                                <label class="form-label small fw-semibold text-dark">Canonical URL Kustom</label>
                                                <input type="url" name="canonical_url" value="{{ old('canonical_url', $post->canonical_url) }}" class="form-control form-control-sm" placeholder="https://example.com/original-article">
                                                <small class="text-muted" style="font-size: 0.7rem;">Biarkan kosong untuk menggunakan URL otomatis dari halaman ini.</small>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="is_indexed" value="1" id="isIndexedCheck" {{ $post->is_indexed ? 'checked' : '' }}>
                                                <label class="form-check-label small fw-semibold text-dark" for="isIndexedCheck">
                                                    Izinkan Mesin Pencari Mengindeks Halaman Ini (index, follow)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                <!-- REAL-TIME YOAST SEO AUDIT CHECKLIST -->
                                <div>
                                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                                        <i class="fas fa-list-check text-primary"></i>
                                        <span>Hasil Analisis Yoast SEO On-Page</span>
                                    </h6>

                                    <div class="d-flex flex-column gap-2" id="yoastChecklistContainer">
                                        <!-- Items will be evaluated in real-time by JavaScript -->
                                        <div class="yoast-check-item p-2.5 rounded-2 d-flex align-items-start gap-2.5 bg-light border" id="chkKeywordTitle">
                                            <span class="chk-icon mt-0.5"><i class="fas fa-circle-dot text-secondary"></i></span>
                                            <div style="font-size: 0.8rem;" class="chk-text">Kata kunci dalam Judul SEO</div>
                                        </div>
                                        <div class="yoast-check-item p-2.5 rounded-2 d-flex align-items-start gap-2.5 bg-light border" id="chkTitleLength">
                                            <span class="chk-icon mt-0.5"><i class="fas fa-circle-dot text-secondary"></i></span>
                                            <div style="font-size: 0.8rem;" class="chk-text">Lebar / Panjang Judul SEO</div>
                                        </div>
                                        <div class="yoast-check-item p-2.5 rounded-2 d-flex align-items-start gap-2.5 bg-light border" id="chkKeywordDesc">
                                            <span class="chk-icon mt-0.5"><i class="fas fa-circle-dot text-secondary"></i></span>
                                            <div style="font-size: 0.8rem;" class="chk-text">Kata kunci dalam Deskripsi Meta</div>
                                        </div>
                                        <div class="yoast-check-item p-2.5 rounded-2 d-flex align-items-start gap-2.5 bg-light border" id="chkDescLength">
                                            <span class="chk-icon mt-0.5"><i class="fas fa-circle-dot text-secondary"></i></span>
                                            <div style="font-size: 0.8rem;" class="chk-text">Panjang Deskripsi Meta</div>
                                        </div>
                                        <div class="yoast-check-item p-2.5 rounded-2 d-flex align-items-start gap-2.5 bg-light border" id="chkKeywordSlug">
                                            <span class="chk-icon mt-0.5"><i class="fas fa-circle-dot text-secondary"></i></span>
                                            <div style="font-size: 0.8rem;" class="chk-text">Kata kunci dalam URL Slug</div>
                                        </div>
                                        <div class="yoast-check-item p-2.5 rounded-2 d-flex align-items-start gap-2.5 bg-light border" id="chkKeywordIntro">
                                            <span class="chk-icon mt-0.5"><i class="fas fa-circle-dot text-secondary"></i></span>
                                            <div style="font-size: 0.8rem;" class="chk-text">Kata kunci di Paragraf Pembuka</div>
                                        </div>
                                        <div class="yoast-check-item p-2.5 rounded-2 d-flex align-items-start gap-2.5 bg-light border" id="chkDensity">
                                            <span class="chk-icon mt-0.5"><i class="fas fa-circle-dot text-secondary"></i></span>
                                            <div style="font-size: 0.8rem;" class="chk-text">Kepadatan Kata Kunci (Keyword Density)</div>
                                        </div>
                                        <div class="yoast-check-item p-2.5 rounded-2 d-flex align-items-start gap-2.5 bg-light border" id="chkWordCount">
                                            <span class="chk-icon mt-0.5"><i class="fas fa-circle-dot text-secondary"></i></span>
                                            <div style="font-size: 0.8rem;" class="chk-text">Jumlah Kata Konten (Minimal 300 kata)</div>
                                        </div>
                                        <div class="yoast-check-item p-2.5 rounded-2 d-flex align-items-start gap-2.5 bg-light border" id="chkHeadings">
                                            <span class="chk-icon mt-0.5"><i class="fas fa-circle-dot text-secondary"></i></span>
                                            <div style="font-size: 0.8rem;" class="chk-text">Distribusi Subjudul (H2 / H3)</div>
                                        </div>
                                        <div class="yoast-check-item p-2.5 rounded-2 d-flex align-items-start gap-2.5 bg-light border" id="chkImageAlt">
                                            <span class="chk-icon mt-0.5"><i class="fas fa-circle-dot text-secondary"></i></span>
                                            <div style="font-size: 0.8rem;" class="chk-text">Atribut Alt Gambar mencakup kata kunci</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 2: READABILITY (KETERBACAAN) -->
                            <div class="tab-pane fade" id="tab-readability" role="tabpanel">
                                <div class="p-3 bg-light rounded-3 border mb-3">
                                    <h6 class="fw-bold text-dark mb-1">Analisis Keterbacaan Pembaca Indonesia</h6>
                                    <p class="text-muted small mb-0">Memastikan struktur kalimat mudah dipahami, tidak berbelit, dan nyaman dibaca di smartphone.</p>
                                </div>

                                <div class="d-flex flex-column gap-2" id="readabilityChecklistContainer">
                                    <div class="p-2.5 rounded-2 d-flex align-items-start gap-2.5 bg-light border" id="chkParagraphLength">
                                        <span class="chk-icon-read mt-0.5"><i class="fas fa-circle-check text-success"></i></span>
                                        <div style="font-size: 0.8rem;"><strong>Panjang Paragraf:</strong> Paragraf terjaga ringkas dan nyaman bagi mata pembaca mobile.</div>
                                    </div>
                                    <div class="p-2.5 rounded-2 d-flex align-items-start gap-2.5 bg-light border" id="chkSentenceLength">
                                        <span class="chk-icon-read mt-0.5"><i class="fas fa-circle-check text-success"></i></span>
                                        <div style="font-size: 0.8rem;"><strong>Panjang Kalimat:</strong> Tidak didominasi kalimat majemuk berlebihan.</div>
                                    </div>
                                    <div class="p-2.5 rounded-2 d-flex align-items-start gap-2.5 bg-light border" id="chkSubheadingsRead">
                                        <span class="chk-icon-read mt-0.5"><i class="fas fa-circle-check text-success"></i></span>
                                        <div style="font-size: 0.8rem;"><strong>Struktur Subjudul:</strong> Memiliki heading untuk memecah teks panjang.</div>
                                    </div>
                                </div>
                            </div>

                            <!-- TAB 3: SOCIAL OPENGRAPH PREVIEW -->
                            <div class="tab-pane fade" id="tab-social" role="tabpanel">
                                <div class="p-3 bg-light rounded-3 border mb-4">
                                    <h6 class="fw-bold text-dark mb-1">Pratinjau Tampilan Berbagi Sosial (WhatsApp / Facebook)</h6>
                                    <p class="text-muted small mb-0">Begini tampilan kartu artikel saat dibagikan ke obrolan WhatsApp atau linimasa media sosial.</p>
                                </div>

                                <div class="border rounded-3 overflow-hidden shadow-xs bg-white" style="max-width: 500px;">
                                    <div style="height: 240px; background: #e2e8f0; overflow: hidden; position: relative;">
                                        <img id="ogPreviewImage" src="{{ $post->image_url }}" class="w-100 h-100 object-fit-cover" alt="Social Preview">
                                    </div>
                                    <div class="p-3 bg-light border-top">
                                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem;">RENTGOINDONESIA.COM</small>
                                        <h6 class="fw-bold text-dark mb-1 mt-1 text-truncate" id="ogPreviewTitle">{{ $post->title }}</h6>
                                        <p class="text-muted small mb-0 text-truncate-2" id="ogPreviewDesc" style="font-size: 0.8rem; line-height: 1.3;">
                                            {{ $post->meta_description_display }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT / SIDEBAR COLUMN -->
            <div class="col-lg-4">
                
                <!-- Category & Publish Setting Card -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                    <div class="card-header bg-white p-3.5 border-bottom">
                        <h6 class="fw-bold text-dark mb-0">Publikasi & Kategori</h6>
                    </div>
                    <div class="card-body p-3.5">
                        
                        <!-- Kategori -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Kategori Artikel <span class="text-danger">*</span></label>
                            <select name="category" class="form-select" style="border-radius: 10px;" required>
                                @foreach($categories as $catKey => $catLabel)
                                    <option value="{{ $catKey }}" {{ old('category', $post->category) === $catKey ? 'selected' : '' }}>
                                        {{ $catKey }} ({{ $catLabel }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Author -->
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-dark">Penulis (Author)</label>
                            <input type="text" class="form-control form-control-sm bg-light" value="{{ $post->user ? $post->user->name : 'Administrator' }}" readonly style="border-radius: 8px;">
                        </div>

                        <!-- Status Selector -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-dark">Status Rilis</label>
                            <select id="statusSelect" class="form-select" onchange="syncStatusInput(this.value)" style="border-radius: 10px;">
                                <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>🟢 Terbitkan Sekarang (Published)</option>
                                <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>🟡 Draf (Draft)</option>
                                <option value="archived" {{ old('status', $post->status) === 'archived' ? 'selected' : '' }}>⚪ Arsipkan (Archived)</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-2.5 fw-semibold" style="border-radius: 10px;">
                                <i class="fas fa-check me-1.5"></i> Perbarui Artikel
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Featured Image Card with Alt Input (Crucial for Yoast) -->
                <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                    <div class="card-header bg-white p-3.5 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold text-dark mb-0">Gambar Utama (Featured Image)</h6>
                        <span class="badge bg-light text-muted border" style="font-size: 0.68rem;">SEO Image</span>
                    </div>
                    <div class="card-body p-3.5">
                        
                        <!-- Image Preview Box -->
                        <div class="mb-3 rounded-3 overflow-hidden border bg-light d-flex align-items-center justify-content-center position-relative" style="height: 180px;">
                            <img id="imagePreview" src="{{ $post->image_url }}" class="w-100 h-100 object-fit-cover" alt="Preview Gambar">
                        </div>

                        <!-- File Upload -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-dark">Ganti Berkas Gambar</label>
                            <input type="file" 
                                   name="image_file" 
                                   id="imageFileInput" 
                                   class="form-control form-control-sm" 
                                   accept="image/*" 
                                   onchange="previewUploadedImage(this)"
                                   style="border-radius: 8px;">
                            <small class="text-muted" style="font-size: 0.7rem;">Maksimal 3MB. Format: JPG, PNG, WEBP.</small>
                        </div>

                        <div class="text-center my-2 text-muted small">— ATAU URL EKSTERNAL —</div>

                        <!-- URL Input -->
                        <div class="mb-3">
                            <input type="url" 
                                   name="image_url_input" 
                                   id="imageUrlInput" 
                                   value="{{ old('image_url_input', Str::startsWith($post->image, ['http://', 'https://']) ? $post->image : '') }}" 
                                   class="form-control form-control-sm" 
                                   placeholder="https://images.unsplash.com/..." 
                                   oninput="previewFromUrl(this.value)"
                                   style="border-radius: 8px;">
                        </div>

                        <!-- Image Alt Text (Crucial Yoast Item) -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark d-flex justify-content-between">
                                <span>Teks Alt Gambar (Alt Attribute) <span class="text-danger">*</span></span>
                                <span class="badge bg-danger-subtle text-danger" style="font-size: 0.65rem;">Yoast Rule</span>
                            </label>
                            <input type="text" 
                                   name="image_alt" 
                                   id="imageAltInput" 
                                   value="{{ old('image_alt', $post->image_alt) }}" 
                                   class="form-control form-control-sm" 
                                   placeholder="Wajib memuat kata kunci fokus..." 
                                   style="border-radius: 8px;">
                            <small class="text-muted" style="font-size: 0.7rem;">Deskripsikan isi gambar dengan menyertakan kata kunci utama agar terindeks Google Image.</small>
                        </div>

                        <!-- Caption -->
                        <div>
                            <label class="form-label small fw-semibold text-dark">Keterangan Gambar (Caption)</label>
                            <input type="text" 
                                   name="image_caption" 
                                   value="{{ old('image_caption', $post->image_caption) }}" 
                                   class="form-control form-control-sm" 
                                   placeholder="Contoh: Suasana Keraton Kasepuhan Cirebon" 
                                   style="border-radius: 8px;">
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </form>
</div>

@endsection

@section('scripts')
<!-- Quill 2.0 Rich Text Editor JS -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

<!-- ----------------------------------------------------
     AUTHENTIC YOAST SEO REAL-TIME ENGINE JAVASCRIPT
---------------------------------------------------- -->
<script>
// Global editor variables
let quill;
let editorCurrentMode = 'visual';

// Initialize Quill Editor
function initQuillEditor() {
    quill = new Quill('#quillEditor', {
        theme: 'snow',
        placeholder: 'Tuliskan isi artikel Anda di sini... Gunakan format Heading 2 dan Heading 3 untuk struktur artikel yang rapi.',
        modules: {
            toolbar: '#quillToolbar'
        }
    });

    // Populate initial content
    const initialContent = @json(old('content', $post->content ?? ''));
    if (initialContent) {
        quill.root.innerHTML = initialContent;
        document.getElementById('rawHtmlTextarea').value = initialContent;
        document.getElementById('postContent').value = initialContent;
    }

    // Live sync on text change in Quill
    quill.on('text-change', function() {
        const html = quill.root.innerHTML;
        document.getElementById('postContent').value = html;
        if (editorCurrentMode === 'visual') {
            document.getElementById('rawHtmlTextarea').value = html;
        }
        runYoastSEOAnalysis();
    });

    // Live sync when editing in raw HTML mode
    const rawTextarea = document.getElementById('rawHtmlTextarea');
    if (rawTextarea) {
        rawTextarea.addEventListener('input', function() {
            const rawHtml = this.value;
            document.getElementById('postContent').value = rawHtml;
            quill.root.innerHTML = rawHtml;
            runYoastSEOAnalysis();
        });
    }
}

// Switch Editor Mode: Visual vs HTML
function switchEditorMode(mode) {
    const visualWrapper = document.getElementById('visualEditorWrapper');
    const htmlWrapper = document.getElementById('htmlEditorWrapper');
    const btnVisual = document.getElementById('btnModeVisual');
    const btnHtml = document.getElementById('btnModeHtml');

    if (mode === 'html') {
        editorCurrentMode = 'html';
        document.getElementById('rawHtmlTextarea').value = quill.root.innerHTML;
        visualWrapper.style.display = 'none';
        htmlWrapper.style.display = 'block';

        btnHtml.className = 'btn btn-sm btn-primary active px-2.5 py-1 fw-semibold';
        btnVisual.className = 'btn btn-sm btn-light text-muted px-2.5 py-1 fw-semibold';
    } else {
        editorCurrentMode = 'visual';
        quill.root.innerHTML = document.getElementById('rawHtmlTextarea').value;
        document.getElementById('postContent').value = quill.root.innerHTML;
        htmlWrapper.style.display = 'none';
        visualWrapper.style.display = 'block';

        btnVisual.className = 'btn btn-sm btn-primary active px-2.5 py-1 fw-semibold';
        btnHtml.className = 'btn btn-sm btn-light text-muted px-2.5 py-1 fw-semibold';
        runYoastSEOAnalysis();
    }
}

// Sync Status Helper
function syncStatusInput(val) {
    document.getElementById('statusInput').value = val;
}

function submitPostForm(status) {
    document.getElementById('statusInput').value = status;
    if (editorCurrentMode === 'html') {
        document.getElementById('postContent').value = document.getElementById('rawHtmlTextarea').value;
    } else if (quill) {
        document.getElementById('postContent').value = quill.root.innerHTML;
    }
    document.getElementById('postForm').submit();
}

// Auto Slug Helper
function autoGenerateSlug() {
    const title = document.getElementById('postTitle').value;
    if (!title) return;
    const slug = title.toLowerCase()
        .replace(/[^\w\s-]/g, '')
        .trim()
        .replace(/[\s_-]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('postSlug').value = slug;
    runYoastSEOAnalysis();
}

// Smart Focus Keyword Extractor
function extractSmartKeywordFromTitle(title) {
    if (!title) return 'rental mobil cirebon';
    const lower = title.toLowerCase();
    const known = [
        'rental mobil cirebon',
        'sewa mobil cirebon',
        'wisata cirebon',
        'lepas kunci cirebon',
        'stasiun cirebon',
        'wisata kuningan ciremai',
        'wisata kuningan',
        'wisata majalengka',
        'perawatan mobil matic',
        'rental mobil avanza',
        'rental mobil innova',
        'rental mobil',
        'sewa mobil',
        'mobil matic'
    ];
    for (let k of known) {
        if (lower.includes(k)) return k;
    }
    const stopWords = ['di', 'dan', 'yang', 'untuk', 'ke', 'dari', 'ini', 'itu', 'pada', 'dengan', 'oleh', 'saat', 'cara', 'tips', 'panduan', 'lengkap', 'terbaru', '2026', '2025'];
    const words = lower.replace(/[^\w\s]/g, '').split(/\s+/).filter(w => !stopWords.includes(w) && w.length > 2);
    if (words.length >= 2) return words[0] + ' ' + words[1];
    if (words.length === 1) return words[0];
    return 'rental mobil cirebon';
}

function autoSuggestKeyword() {
    const title = document.getElementById('postTitle').value.trim();
    if (!title) {
        alert('Tuliskan judul artikel terlebih dahulu.');
        document.getElementById('postTitle').focus();
        return;
    }
    const kw = extractSmartKeywordFromTitle(title);
    document.getElementById('focusKeyword').value = kw;
    runYoastSEOAnalysis();
}

// 1-Click All SEO Auto Generator
function autoGenerateAllSeo(showToast = false) {
    const title = document.getElementById('postTitle').value.trim();
    const content = quill ? quill.root.innerHTML : document.getElementById('postContent').value.trim();
    if (!title && !content) {
        alert('Silakan tulis judul artikel terlebih dahulu.');
        document.getElementById('postTitle').focus();
        return;
    }

    // 1. Keyword
    const smartKeyword = extractSmartKeywordFromTitle(title);
    document.getElementById('focusKeyword').value = smartKeyword;

    // 2. Slug
    autoGenerateSlug();

    // 3. Optimal SEO Title (45-60 chars)
    const brand = ' - RentGo Cirebon';
    let baseTitle = title;
    if ((baseTitle + brand).length > 62) {
        baseTitle = baseTitle.substring(0, 62 - brand.length - 3) + '...';
    }
    document.getElementById('seoTitleInput').value = baseTitle + brand;

    // 4. Optimal Meta Description (120-155 chars with keyword)
    const cleanContent = quill ? quill.getText().trim() : content.replace(/<[^>]*>?/gm, ' ').replace(/\s+/g, ' ').trim();
    let metaDesc = '';
    if (cleanContent.length >= 120) {
        let sub = cleanContent.substring(0, 150);
        let lastPeriod = sub.lastIndexOf('.');
        if (lastPeriod > 100) {
            metaDesc = sub.substring(0, lastPeriod + 1);
        } else {
            let lastSpace = sub.lastIndexOf(' ');
            metaDesc = (lastSpace > 110 ? sub.substring(0, lastSpace) : sub) + '...';
        }
    } else {
        metaDesc = `Panduan ${smartKeyword} terpercaya dari RentGo Indonesia. Dapatkan armada prima, verifikasi instan, dan gratis antar stasiun Cirebon.`;
    }
    document.getElementById('metaDescInput').value = metaDesc;

    // 5. Excerpt
    if (!document.getElementById('postExcerpt').value) {
        document.getElementById('postExcerpt').value = metaDesc;
    }

    // 6. Image Alt
    document.getElementById('imageAltInput').value = `${title} - ${smartKeyword}`;

    // Re-run analysis
    runYoastSEOAnalysis();

    if (showToast) {
        const toast = document.createElement('div');
        toast.className = 'position-fixed bottom-0 end-0 p-3';
        toast.style.zIndex = '9999';
        toast.innerHTML = `
            <div class="toast align-items-center text-white bg-success border-0 show shadow-lg" role="alert" style="border-radius: 12px; background: #059669 !important;">
                <div class="d-flex">
                    <div class="toast-body d-flex align-items-center gap-2">
                        <i class="fas fa-circle-check fa-lg"></i>
                        <div>
                            <strong>Yoast SEO Otomatis Berhasil Diisi!</strong><br>
                            <small>Kata kunci, judul SERP, deskripsi meta, dan Alt gambar otomatis optimal.</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.closest('.position-fixed').remove()"></button>
                </div>
            </div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }
}

// Image Preview from Local File
function previewUploadedImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('ogPreviewImage').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
        runYoastSEOAnalysis();
    }
}

// Image Preview from External URL
function previewFromUrl(url) {
    if (url && url.startsWith('http')) {
        document.getElementById('imagePreview').src = url;
        document.getElementById('ogPreviewImage').src = url;
    }
    runYoastSEOAnalysis();
}

// Switch SERP Mobile vs Desktop view
function switchSnippetView(mode) {
    const container = document.getElementById('serpContainer');
    const btnM = document.getElementById('btnPreviewMobile');
    const btnD = document.getElementById('btnPreviewDesktop');
    if (mode === 'mobile') {
        container.style.maxWidth = '380px';
        btnM.classList.add('active');
        btnD.classList.remove('active');
    } else {
        container.style.maxWidth = '650px';
        btnD.classList.add('active');
        btnM.classList.remove('active');
    }
}

// ----------------------------------------------------
// THE CORE REAL-TIME YOAST SEO EVALUATOR
// ----------------------------------------------------
function runYoastSEOAnalysis() {
    const postTitle = document.getElementById('postTitle').value.trim();
    const slug = document.getElementById('postSlug').value.trim();
    
    let contentHtml = '';
    let plainText = '';
    if (quill) {
        contentHtml = quill.root.innerHTML;
        plainText = quill.getText().trim();
    } else {
        contentHtml = document.getElementById('postContent').value.trim();
        plainText = contentHtml.replace(/<[^>]*>?/gm, ' ').replace(/\s+/g, ' ').trim();
    }

    const focusKeyword = document.getElementById('focusKeyword').value.trim().toLowerCase();
    const customSeoTitle = document.getElementById('seoTitleInput').value.trim();
    const customMetaDesc = document.getElementById('metaDescInput').value.trim();
    const imageAlt = document.getElementById('imageAltInput').value.trim().toLowerCase();

    // 1. Resolve Effective SEO Title & Meta Description
    const effectiveTitle = customSeoTitle || (postTitle ? postTitle + ' - RentGo Indonesia' : 'Judul Artikel Anda');
    const effectiveDesc = customMetaDesc || (document.getElementById('postExcerpt').value.trim() || 'Tuliskan meta deskripsi yang menarik untuk memikat calon pembaca agar mengklik tautan Anda di hasil pencarian Google.');

    // 2. Update SERP Displays
    document.getElementById('serpTitleDisplay').innerText = effectiveTitle;
    document.getElementById('serpDescDisplay').innerText = effectiveDesc;
    document.getElementById('serpUrlDisplay').innerText = `https://rentgoindonesia.com › blog › ${slug || 'artikel-cirebon'}`;

    // Update Social OG Preview
    document.getElementById('ogPreviewTitle').innerText = effectiveTitle;
    document.getElementById('ogPreviewDesc').innerText = effectiveDesc;

    // 3. Word Count & Reading Time Calculation (Plain Text)
    const wordsArray = plainText.match(/\b[\w'-]+\b/g) || [];
    const wordCount = wordsArray.length;
    document.getElementById('wordCountBadge').innerHTML = `<i class="fas fa-font me-1 text-muted"></i>${wordCount} Kata`;
    const readingTime = Math.max(1, Math.ceil(wordCount / 200));
    document.getElementById('readingTimeBadge').innerHTML = `<i class="far fa-clock me-1"></i>~${readingTime} mnt baca`;

    // 4. Character Meters: SEO Title
    const titleLen = effectiveTitle.length;
    document.getElementById('seoTitleCounter').innerText = `${titleLen} / 60 karakter`;
    const titleBar = document.getElementById('seoTitleProgress');
    const titleFeedback = document.getElementById('seoTitleFeedback');
    
    if (titleLen === 0) {
        titleBar.style.width = '0%';
        titleBar.className = 'progress-bar bg-secondary';
        titleFeedback.innerText = 'Kosongkan jika ingin memakai judul artikel secara otomatis.';
    } else if (titleLen < 40) {
        titleBar.style.width = Math.min(100, (titleLen / 60) * 100) + '%';
        titleBar.className = 'progress-bar bg-warning';
        titleFeedback.innerHTML = '<span class="text-warning">Terlalu pendek</span> (Optimal 45 - 60 karakter).';
    } else if (titleLen <= 65) {
        titleBar.style.width = '100%';
        titleBar.className = 'progress-bar bg-success';
        titleFeedback.innerHTML = '<span class="text-success fw-semibold"><i class="fas fa-check me-1"></i>Panjang judul SEO optimal!</span>';
    } else {
        titleBar.style.width = '100%';
        titleBar.className = 'progress-bar bg-danger';
        titleFeedback.innerHTML = '<span class="text-danger">Terlalu panjang!</span> Google akan memotong judul dengan tanda titik tiga (...).';
    }

    // 5. Character Meters: Meta Description
    const descLen = customMetaDesc.length;
    document.getElementById('metaDescCounter').innerText = `${descLen} / 160 karakter`;
    const descBar = document.getElementById('metaDescProgress');
    const descFeedback = document.getElementById('metaDescFeedback');

    if (descLen === 0) {
        descBar.style.width = '0%';
        descBar.className = 'progress-bar bg-secondary';
        descFeedback.innerText = 'Panjang optimal antara 120 hingga 160 karakter.';
    } else if (descLen < 120) {
        descBar.style.width = Math.min(100, (descLen / 160) * 100) + '%';
        descBar.className = 'progress-bar bg-warning';
        descFeedback.innerHTML = '<span class="text-warning">Terlalu pendek</span> (Optimal 120 - 160 karakter).';
    } else if (descLen <= 160) {
        descBar.style.width = '100%';
        descBar.className = 'progress-bar bg-success';
        descFeedback.innerHTML = '<span class="text-success fw-semibold"><i class="fas fa-check me-1"></i>Panjang deskripsi meta sempurna!</span>';
    } else {
        descBar.style.width = '100%';
        descBar.className = 'progress-bar bg-danger';
        descFeedback.innerHTML = '<span class="text-danger">Terlalu panjang!</span> Ringkaslah di bawah 160 karakter agar tidak terpotong.';
    }

    // 6. CHECKLIST EVALUATION
    let greenCount = 0;
    let yellowCount = 0;
    let redCount = 0;

    function setCheckState(elementId, state, message) {
        const item = document.getElementById(elementId);
        if (!item) return;
        const iconSpan = item.querySelector('.chk-icon');
        const textDiv = item.querySelector('.chk-text');

        if (state === 'green') {
            greenCount++;
            if (iconSpan) iconSpan.innerHTML = '<i class="fas fa-circle-check text-success"></i>';
            if (textDiv) textDiv.innerHTML = `<span class="text-dark"><strong>${message.title}:</strong> ${message.desc}</span>`;
            item.className = 'yoast-check-item p-2 rounded-2 d-flex align-items-start gap-2 bg-emerald-50 border border-success-subtle';
        } else if (state === 'yellow') {
            yellowCount++;
            if (iconSpan) iconSpan.innerHTML = '<i class="fas fa-circle-dot text-warning"></i>';
            if (textDiv) textDiv.innerHTML = `<span class="text-dark"><strong>${message.title}:</strong> ${message.desc}</span>`;
            item.className = 'yoast-check-item p-2 rounded-2 d-flex align-items-start gap-2 bg-amber-50 border border-warning-subtle';
        } else {
            redCount++;
            if (iconSpan) iconSpan.innerHTML = '<i class="fas fa-circle-xmark text-danger"></i>';
            if (textDiv) textDiv.innerHTML = `<span class="text-dark"><strong>${message.title}:</strong> ${message.desc}</span>`;
            item.className = 'yoast-check-item p-2 rounded-2 d-flex align-items-start gap-2 bg-rose-50 border border-danger-subtle';
        }
    }

    // Check 1: Keyword in Title
    if (!focusKeyword) {
        setCheckState('chkKeywordTitle', 'red', { title: 'Frasa Kunci di Judul SEO', desc: 'Frasa kunci fokus belum ditentukan.' });
    } else if (effectiveTitle.toLowerCase().includes(focusKeyword)) {
        setCheckState('chkKeywordTitle', 'green', { title: 'Frasa Kunci di Judul SEO', desc: `Frasa kunci "${focusKeyword}" ditemukan di dalam judul SEO.` });
    } else {
        setCheckState('chkKeywordTitle', 'red', { title: 'Frasa Kunci di Judul SEO', desc: `Frasa kunci "${focusKeyword}" tidak ditemukan di dalam judul SEO.` });
    }

    // Check 2: Title Length
    if (titleLen >= 40 && titleLen <= 65) {
        setCheckState('chkTitleLength', 'green', { title: 'Lebar Judul SEO', desc: `Panjang ${titleLen} karakter pas dengan batas aman SERP Google.` });
    } else if (titleLen > 0 && titleLen < 40) {
        setCheckState('chkTitleLength', 'yellow', { title: 'Lebar Judul SEO', desc: `Panjang ${titleLen} karakter agak pendek. Manfaatkan ruang judul untuk menarik klik.` });
    } else if (titleLen > 65) {
        setCheckState('chkTitleLength', 'red', { title: 'Lebar Judul SEO', desc: `Panjang ${titleLen} karakter melebihi batas 65 karakter.` });
    } else {
        setCheckState('chkTitleLength', 'red', { title: 'Lebar Judul SEO', desc: 'Judul artikel masih kosong.' });
    }

    // Check 3: Keyword in Meta Desc
    if (!focusKeyword) {
        setCheckState('chkKeywordDesc', 'red', { title: 'Frasa Kunci di Deskripsi Meta', desc: 'Frasa kunci fokus belum ditentukan.' });
    } else if (customMetaDesc.toLowerCase().includes(focusKeyword)) {
        setCheckState('chkKeywordDesc', 'green', { title: 'Frasa Kunci di Deskripsi Meta', desc: 'Frasa kunci muncul di dalam deskripsi meta.' });
    } else {
        setCheckState('chkKeywordDesc', 'red', { title: 'Frasa Kunci di Deskripsi Meta', desc: 'Deskripsi meta belum mengandung frasa kunci fokus.' });
    }

    // Check 4: Meta Desc Length
    if (descLen >= 120 && descLen <= 160) {
        setCheckState('chkDescLength', 'green', { title: 'Panjang Deskripsi Meta', desc: `Panjang ${descLen} karakter ideal untuk tampilan Google.` });
    } else if (descLen > 0 && descLen < 120) {
        setCheckState('chkDescLength', 'yellow', { title: 'Panjang Deskripsi Meta', desc: `Panjang ${descLen} karakter agak pendek (disarankan 120-160).` });
    } else if (descLen > 160) {
        setCheckState('chkDescLength', 'red', { title: 'Panjang Deskripsi Meta', desc: `Panjang ${descLen} karakter terlalu panjang.` });
    } else {
        setCheckState('chkDescLength', 'yellow', { title: 'Panjang Deskripsi Meta', desc: 'Deskripsi meta belum ditulis manual.' });
    }

    // Check 5: Keyword in Slug
    if (!focusKeyword) {
        setCheckState('chkKeywordSlug', 'red', { title: 'Frasa Kunci dalam Slug', desc: 'Frasa kunci belum ditentukan.' });
    } else {
        const cleanKeywordSlug = focusKeyword.replace(/\s+/g, '-');
        if (slug.toLowerCase().includes(cleanKeywordSlug) || slug.toLowerCase().includes(focusKeyword)) {
            setCheckState('chkKeywordSlug', 'green', { title: 'Frasa Kunci dalam Slug', desc: 'Frasa kunci terdapat dalam permalink / URL slug.' });
        } else {
            setCheckState('chkKeywordSlug', 'yellow', { title: 'Frasa Kunci dalam Slug', desc: 'Sangat disarankan menyertakan frasa kunci dalam slug URL.' });
        }
    }

    // Check 6: Keyword in First Paragraph (Intro)
    if (!focusKeyword) {
        setCheckState('chkKeywordIntro', 'red', { title: 'Frasa Kunci di Pengantar', desc: 'Frasa kunci belum ditentukan.' });
    } else {
        const first100Words = wordsArray.slice(0, 100).join(' ').toLowerCase();
        if (first100Words.includes(focusKeyword)) {
            setCheckState('chkKeywordIntro', 'green', { title: 'Frasa Kunci di Pengantar', desc: 'Frasa kunci muncul di paragraf awal (100 kata pertama).' });
        } else {
            setCheckState('chkKeywordIntro', 'red', { title: 'Frasa Kunci di Pengantar', desc: 'Frasa kunci tidak ditemukan di 100 kata pertama artikel.' });
        }
    }

    // Check 7: Keyword Density
    if (!focusKeyword || wordCount === 0) {
        setCheckState('chkDensity', 'red', { title: 'Kepadatan Frasa Kunci', desc: 'Frasa kunci atau teks konten belum tersedia.' });
    } else {
        const safeKw = focusKeyword.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const matches = (plainText.toLowerCase().match(new RegExp(safeKw, 'g')) || []).length;
        const density = ((matches / wordCount) * 100).toFixed(1);
        if (matches === 0) {
            setCheckState('chkDensity', 'red', { title: 'Kepadatan Frasa Kunci', desc: 'Frasa kunci tidak ditemukan di dalam isi konten.' });
        } else if (density >= 0.5 && density <= 2.5) {
            setCheckState('chkDensity', 'green', { title: 'Kepadatan Frasa Kunci', desc: `Kepadatan ${density}% (${matches} kali muncul) adalah rasio optimal.` });
        } else if (density < 0.5) {
            setCheckState('chkDensity', 'yellow', { title: 'Kepadatan Frasa Kunci', desc: `Kepadatan ${density}% agak rendah (${matches} kali). Tingkatkan penyebutan alami.` });
        } else {
            setCheckState('chkDensity', 'red', { title: 'Kepadatan Frasa Kunci', desc: `Kepadatan ${density}% terlalu tinggi (${matches} kali). Hindari keyword stuffing.` });
        }
    }

    // Check 8: Word Count
    if (wordCount >= 500) {
        setCheckState('chkWordCount', 'green', { title: 'Panjang Konten Teks', desc: `Artikel berisi ${wordCount} kata. Sangat baik untuk mendalamnya topik.` });
    } else if (wordCount >= 300) {
        setCheckState('chkWordCount', 'green', { title: 'Panjang Konten Teks', desc: `Artikel berisi ${wordCount} kata. Memenuhi batas minimum 300 kata.` });
    } else if (wordCount > 100) {
        setCheckState('chkWordCount', 'yellow', { title: 'Panjang Konten Teks', desc: `Artikel baru ${wordCount} kata. Disarankan minimal 300 kata untuk peringkat Google.` });
    } else {
        setCheckState('chkWordCount', 'red', { title: 'Panjang Konten Teks', desc: `Konten terlalu sedikit (${wordCount} kata). Minimal 300 kata disyaratkan.` });
    }

    // Check 9: Headings presence (H2 / H3)
    let hasH2 = false;
    let hasH3 = false;
    if (quill) {
        hasH2 = quill.root.querySelectorAll('h2').length > 0;
        hasH3 = quill.root.querySelectorAll('h3').length > 0;
    } else {
        hasH2 = /<h2[^>]*>/i.test(contentHtml);
        hasH3 = /<h3[^>]*>/i.test(contentHtml);
    }
    if (hasH2 || hasH3) {
        setCheckState('chkHeadings', 'green', { title: 'Distribusi Subjudul', desc: 'Konten telah menggunakan subjudul (H2/H3) untuk keterbacaan yang rapi.' });
    } else {
        setCheckState('chkHeadings', 'yellow', { title: 'Distribusi Subjudul', desc: 'Belum ada tag H2 atau H3. Tambahkan subjudul untuk memecah teks panjang.' });
    }

    // Check 10: Image Alt with Keyword
    if (!imageAlt) {
        setCheckState('chkImageAlt', 'red', { title: 'Alt Gambar', desc: 'Atribut Alt gambar utama belum diisi.' });
    } else if (focusKeyword && imageAlt.includes(focusKeyword)) {
        setCheckState('chkImageAlt', 'green', { title: 'Alt Gambar', desc: 'Atribut Alt gambar utama memuat frasa kunci fokus.' });
    } else {
        setCheckState('chkImageAlt', 'yellow', { title: 'Alt Gambar', desc: 'Atribut Alt gambar terisi tetapi belum memuat frasa kunci fokus.' });
    }

    // 7. Overall Traffic Light Score Calculation
    let overallScore = 'ok';
    const overallBadge = document.getElementById('overallYoastBadge');
    const scoreInput = document.getElementById('seoScoreInput');

    if (greenCount >= 7 && redCount <= 1) {
        overallScore = 'good';
        overallBadge.style.background = '#ecfdf5';
        overallBadge.style.color = '#047857';
        overallBadge.style.borderColor = '#a7f3d0';
        overallBadge.innerHTML = '<i class="fas fa-circle-check"></i> <span>🟢 Baik (Good)</span>';
    } else if (greenCount >= 4 && redCount <= 3) {
        overallScore = 'ok';
        overallBadge.style.background = '#fffbeb';
        overallBadge.style.color = '#b45309';
        overallBadge.style.borderColor = '#fde68a';
        overallBadge.innerHTML = '<i class="fas fa-circle-dot"></i> <span>🟡 Cukup (OK)</span>';
    } else {
        overallScore = 'bad';
        overallBadge.style.background = '#fef2f2';
        overallBadge.style.color = '#b91c1c';
        overallBadge.style.borderColor = '#fecaca';
        overallBadge.innerHTML = '<i class="fas fa-circle-xmark"></i> <span>🔴 Perlu Perbaikan (Needs Work)</span>';
    }

    scoreInput.value = overallScore;
}

// Attach live event listeners to all relevant input fields
document.addEventListener('DOMContentLoaded', function() {
    initQuillEditor();

    const triggerElements = [
        'postTitle',
        'postSlug',
        'postExcerpt',
        'focusKeyword',
        'seoTitleInput',
        'metaDescInput',
        'imageAltInput'
    ];

    triggerElements.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', runYoastSEOAnalysis);
            el.addEventListener('change', runYoastSEOAnalysis);
        }
    });

    const postForm = document.getElementById('postForm');
    if (postForm) {
        postForm.addEventListener('submit', function() {
            if (editorCurrentMode === 'html') {
                document.getElementById('postContent').value = document.getElementById('rawHtmlTextarea').value;
            } else if (quill) {
                document.getElementById('postContent').value = quill.root.innerHTML;
            }
        });
    }

    // Run initial analysis with loaded values
    setTimeout(runYoastSEOAnalysis, 150);
});
</script>
@endsection

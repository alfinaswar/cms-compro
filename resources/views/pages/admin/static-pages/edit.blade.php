@extends('layouts.app')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('') }}assets/plugins/summernote/summernote-bs4.css">
        <style>
            .tab-content {
                padding-top: 20px;
            }

            .seo-preview {
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 12px;
                margin-bottom: 16px;
                font-family: arial, sans-serif;
            }

            .seo-preview .seo-title {
                color: #1a0dab;
                font-size: 18px;
                line-height: 22px;
                margin-bottom: 2px;
                word-break: break-word;
            }

            .seo-preview .seo-url {
                color: #006621;
                font-size: 13px;
                margin-bottom: 3px;
                word-break: break-all;
            }

            .seo-preview .seo-desc {
                color: #545454;
                font-size: 13px;
                line-height: 1.45;
            }

            .seo-preview-header {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 4px;
            }

            .seo-preview-favicon {
                width: 20px;
                height: 20px;
                border-radius: 50%;
                background: #f1f3f4;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .seo-preview-favicon i {
                font-size: 10px;
                color: #5f6368;
            }

            .seo-preview-domain {
                color: #202124;
                font-size: 12px;
            }
        </style>
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <i class="{{ $page->Icon }} mr-2"></i>
                        Edit {{ $page->Label }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('static-pages.index') }}">Halaman Statis</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <form action="{{ route('static-pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                {{-- KOLOM KIRI: KONTEN --}}
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0">
                                <i class="{{ $page->Icon }} text-primary mr-2"></i>
                                <strong>Konten {{ $page->Label }}</strong>
                            </h5>
                        </div>
                        <div class="card-body">
                            {{-- TABS BAHASA --}}
                            <ul class="nav nav-tabs mb-4" id="langTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tab-id">
                                        🇮🇩 Bahasa Indonesia <span class="text-danger">*</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tab-en">🇬🇧 English</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                {{-- TAB INDONESIA --}}
                                <div class="tab-pane fade show active" id="tab-id">
                                    <div class="form-group">
                                        <label><strong>Judul</strong> <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-heading"></i></span>
                                            </div>
                                            <input type="text" name="translations[id][Judul]" id="JudulId"
                                                class="form-control form-control-lg @error('translations.id.Judul') is-invalid @enderror"
                                                value="{{ old('translations.id.Judul', $page->translate('id')->Judul) }}"
                                                required placeholder="Masukkan judul halaman">
                                        </div>
                                        @error('translations.id.Judul')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Konten Lengkap</strong></label>
                                        <textarea name="translations[id][Konten]" id="summernoteId"
                                            class="form-control @error('translations.id.Konten') is-invalid @enderror">{{ old('translations.id.Konten', $page->translate('id')->Konten) }}</textarea>
                                        @error('translations.id.Konten')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- TAB ENGLISH --}}
                                <div class="tab-pane fade" id="tab-en">
                                    <div class="form-group">
                                        <label><strong>Title</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-heading"></i></span>
                                            </div>
                                            <input type="text" name="translations[en][Judul]" id="JudulEn"
                                                class="form-control form-control-lg @error('translations.en.Judul') is-invalid @enderror"
                                                value="{{ old('translations.en.Judul', $page->translate('en')->Judul) }}"
                                                placeholder="Enter page title">
                                        </div>
                                        @error('translations.en.Judul')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label><strong>Full Content</strong></label>
                                        <textarea name="translations[en][Konten]" id="summernoteEn"
                                            class="form-control @error('translations.en.Konten') is-invalid @enderror">{{ old('translations.en.Konten', $page->translate('en')->Konten) }}</textarea>
                                        @error('translations.en.Konten')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="form-group">
                                <label><strong>Slug URL</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">{{ url('/') }}/</span>
                                    </div>
                                    <input type="text" name="Slug" id="Slug" class="form-control"
                                        value="{{ old('Slug', $page->Slug) }}" placeholder="slug-halaman">
                                </div>
                                <small class="text-muted">URL publik halaman ini</small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: PUBLIKASI & SEO --}}
                <div class="col-lg-4">
                    {{-- THUMBNAIL --}}
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-image text-warning mr-2"></i><strong>Gambar Cover</strong>
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <div id="thumbPlaceholder" class="mb-3 text-muted"
                                style="height: 150px; display: {{ $page->Thumbnail ? 'none' : 'flex' }}; align-items: center; justify-content: center; border: 2px dashed #cbd5e1; border-radius: 8px; background-color: #f8fafc;">
                                <div>
                                    <i class="fa fa-image fa-2x mb-2" style="opacity: 0.5;"></i>
                                    <p class="mb-0 small">Belum ada gambar</p>
                                </div>
                            </div>
                            <img id="previewThumb"
                                src="{{ $page->Thumbnail ? asset('storage/' . $page->Thumbnail) : '' }}"
                                class="img-fluid mb-3"
                                style="max-height: 150px; border-radius: 8px; border: 1px solid #ddd; display: {{ $page->Thumbnail ? 'block' : 'none' }}; object-fit: cover; width: 100%;">
                            <input type="file" name="Thumbnail" class="form-control form-control-sm" accept="image/*"
                                onchange="previewImage(this)">
                            <small class="text-muted d-block mt-2">Maks 2MB. JPG, PNG, WebP.</small>
                        </div>
                    </div>

                    {{-- PUBLIKASI --}}
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i
                                    class="fa fa-paper-plane text-primary mr-2"></i><strong>Publikasi</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="IsPublished" name="IsPublished"
                                    value="1" {{ old('IsPublished', $page->IsPublished) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="IsPublished">
                                    <strong>Publikasikan Halaman</strong>
                                </label>
                            </div>
                            <small class="text-muted d-block mt-2">
                                Halaman akan dapat diakses publik jika diaktifkan.
                            </small>
                        </div>
                    </div>

                    {{-- SEO (INDONESIA) --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-search text-warning mr-2"></i><strong>SEO
                                    (Indonesia)</strong></h5>
                        </div>
                        <div class="card-body">
                            {{-- Preview Google --}}
                            <div class="seo-preview">
                                <small class="text-muted d-block mb-2">
                                    <i class="fa fa-eye mr-1"></i>Preview Google:
                                </small>
                                <div class="seo-preview-header">
                                    <span class="seo-preview-favicon"><i class="fa fa-globe"></i></span>
                                    <span class="seo-preview-domain">{{ parse_url(url('/'), PHP_URL_HOST) }}</span>
                                </div>
                                <div id="seoPreviewTitle" class="seo-title">Judul Halaman</div>
                                <div id="seoPreviewUrl" class="seo-url">{{ url('/') }}/{{ $page->Slug ?: 'slug' }}
                                </div>
                                <div id="seoPreviewDesc" class="seo-desc">Deskripsi halaman akan muncul di sini...</div>
                            </div>

                            <div class="form-group">
                                <label>
                                    SEO Title
                                    <span class="float-right text-muted" id="counterTitle">0/70</span>
                                </label>
                                <input type="text" name="translations[id][SEOTitle]" id="inputSEOTitle"
                                    class="form-control" maxlength="70"
                                    value="{{ old('translations.id.SEOTitle', $page->translate('id')->SEOTitle) }}"
                                    placeholder="Kosongkan untuk pakai Judul">
                            </div>

                            <div class="form-group">
                                <label>
                                    Meta Description
                                    <span class="float-right text-muted" id="counterDesc">0/160</span>
                                </label>
                                <textarea name="translations[id][SEODescription]" id="inputSEODesc" class="form-control" rows="3"
                                    maxlength="160">{{ old('translations.id.SEODescription', $page->translate('id')->SEODescription) }}</textarea>
                            </div>

                            <div class="form-group mb-0">
                                <label>SEO Keywords</label>
                                <input type="text" name="translations[id][SEOKeywords]" class="form-control"
                                    value="{{ old('translations.id.SEOKeywords', $page->translate('id')->SEOKeywords) }}"
                                    placeholder="keyword1, keyword2">
                                <small class="text-muted">Pisahkan dengan koma.</small>
                            </div>
                        </div>
                    </div>

                    {{-- ACTION BUTTONS --}}
                    <div class="mt-3 d-flex justify-content-between">
                        <a href="{{ route('static-pages.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save mr-1"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Summernote Indonesia
            $('#summernoteId').summernote({
                height: 400,
                placeholder: 'Tulis konten halaman di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        uploadSummernoteImage(files[0], '#summernoteId');
                    }
                }
            });

            // Summernote English
            $('#summernoteEn').summernote({
                height: 400,
                placeholder: 'Write page content here...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        uploadSummernoteImage(files[0], '#summernoteEn');
                    }
                }
            });

            // Upload gambar dari Summernote
            function uploadSummernoteImage(file, editorId) {
                var data = new FormData();
                data.append('image', file);
                data.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: '{{ route('static-pages.upload-image') }}',
                    method: 'POST',
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $(editorId).summernote('insertImage', response.url);
                    },
                    error: function() {
                        Swal.fire('Error', 'Gagal mengunggah gambar.', 'error');
                    }
                });
            }

            // Preview Thumbnail
            window.previewImage = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewThumb').attr('src', e.target.result).show();
                        $('#thumbPlaceholder').hide();
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            };

            // SEO Preview Real-time
            var baseUrl = '{{ url('/') }}';

            function updateSEOPreview() {
                var judul = $('#JudulId').val() || 'Judul Halaman';
                var seoTitle = $('#inputSEOTitle').val() || judul;
                var seoDesc = $('#inputSEODesc').val() || 'Deskripsi halaman akan muncul di sini...';
                var slug = $('#Slug').val() || '{{ $page->Slug ?: 'slug' }}';

                $('#seoPreviewTitle').text(seoTitle);
                $('#seoPreviewUrl').text(baseUrl + '/' + slug);
                $('#seoPreviewDesc').text(seoDesc);
            }

            function updateCounters() {
                $('#counterTitle').text($('#inputSEOTitle').val().length + '/70');
                $('#counterDesc').text($('#inputSEODesc').val().length + '/160');
            }

            $('#JudulId, #inputSEOTitle, #inputSEODesc, #Slug').on('input', function() {
                updateSEOPreview();
                updateCounters();
            });

            // Auto generate slug
            $('#JudulId').on('input', function() {
                if (!$('#Slug').data('manual-edit')) {
                    let slug = $(this).val().toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                    $('#Slug').val(slug);
                    updateSEOPreview();
                }
            });

            $('#Slug').on('input', function() {
                $(this).data('manual-edit', true);
            });

            // Inisialisasi
            updateSEOPreview();
            updateCounters();

            // Auto-switch tab jika ada error EN
            @if ($errors->has('translations.en.*'))
                $('a[href="#tab-en"]').tab('show');
            @endif
        });
    </script>
@endpush

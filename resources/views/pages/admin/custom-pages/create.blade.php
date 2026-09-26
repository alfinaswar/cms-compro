@extends('layouts.app')

@section('content')
    @push('styles')
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('') }}assets/plugins/summernote/summernote-bs4.css">
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Halaman Custom</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('custom-pages.index') }}">Halaman Custom</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <form action="{{ route('custom-pages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-file-alt text-primary mr-2"></i><strong>Konten
                                    Halaman</strong></h5>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs mb-4" id="langTabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-id">🇮🇩 Bahasa
                                        Indonesia <span class="text-danger">*</span></a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab-en">🇬🇧 English</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab-id">
                                    <div class="form-group">
                                        <label><strong>Judul Halaman</strong> <span class="text-danger">*</span></label>
                                        <input type="text" name="translations[id][Judul]"
                                            class="form-control form-control-lg" value="{{ old('translations.id.Judul') }}"
                                            required placeholder="Masukkan judul halaman">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Deskripsi Singkat</strong></label>
                                        <textarea name="translations[id][DeskripsiSingkat]" class="form-control" rows="3"
                                            placeholder="Tulis deskripsi singkat halaman">{{ old('translations.id.DeskripsiSingkat') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Konten Lengkap</strong> <span class="text-danger">*</span></label>
                                        <textarea name="translations[id][Konten]" id="summernoteId" class="form-control"
                                            placeholder="Tulis konten lengkap di sini ...">{{ old('translations.id.Konten') }}</textarea>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-en">
                                    <div class="form-group">
                                        <label><strong>Page Title</strong></label>
                                        <input type="text" name="translations[en][Judul]"
                                            class="form-control form-control-lg" value="{{ old('translations.en.Judul') }}"
                                            placeholder="Enter page title">
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Short Description</strong></label>
                                        <textarea name="translations[en][DeskripsiSingkat]" class="form-control" rows="3"
                                            placeholder="Write a short description">{{ old('translations.en.DeskripsiSingkat') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Full Content</strong></label>
                                        <textarea name="translations[en][Konten]" id="summernoteEn" class="form-control"
                                            placeholder="Write full content here ...">{{ old('translations.en.Konten') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Parent Halaman (Hirarki)</strong></label>
                                        <select name="ParentId" class="form-control select2">
                                            <option value="">-- Halaman Utama (Root) --</option>
                                            @foreach ($parentPages as $parent)
                                                <option value="{{ $parent->id }}"
                                                    {{ old('ParentId') == $parent->id ? 'selected' : '' }}>
                                                    {{ $parent->translate('id')->Judul }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Pilih parent jika ini adalah sub-halaman</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Urutan</strong></label>
                                        <input type="number" name="Urutan" class="form-control"
                                            value="{{ old('Urutan', 0) }}" min="0"
                                            placeholder="Masukkan urutan tampilan (default 0)">
                                        <small class="text-muted">Urutan tampil (0 = paling atas)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><strong>Slug</strong></label>
                                <input type="text" name="Slug" id="Slug" class="form-control"
                                    placeholder="otomatis-terbentuk-jika-dikosongkan" value="{{ old('Slug') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-image text-warning mr-2"></i><strong>Gambar Cover</strong>
                            </h5>
                        </div>
                        <div class="card-body">
                            <input type="file" name="Thumbnail" class="form-control" accept="image/*" id="Thumbnail"
                                placeholder="Pilih file gambar">
                            <div id="previewThumbnail" class="mt-3" style="display:none;">
                                <img src="" class="img-thumbnail"
                                    style="width:100%; height:auto; object-fit:cover;">
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i
                                    class="fa fa-paper-plane text-primary mr-2"></i><strong>Publikasi</strong></h5>
                        </div>
                        <div class="card-body">
                            <select name="IsPublished" class="form-control">
                                <option value="0">Draft</option>
                                <option value="1" selected>Publikasikan</option>
                            </select>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-search text-warning mr-2"></i><strong>SEO
                                    (Indonesia)</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>SEO Title</label>
                                <input type="text" name="translations[id][SEOTitle]" class="form-control"
                                    maxlength="70" value="{{ old('translations.id.SEOTitle') }}"
                                    placeholder="Masukkan judul SEO (max 70 karakter)">
                            </div>
                            <div class="form-group">
                                <label>Meta Description</label>
                                <textarea name="translations[id][SEODescription]" class="form-control" rows="3" maxlength="160"
                                    placeholder="Tuliskan deskripsi SEO (max 160 karakter)">{{ old('translations.id.SEODescription') }}</textarea>
                            </div>
                            <div class="form-group mb-0">
                                <label>SEO Keywords</label>
                                <input type="text" name="translations[id][SEOKeywords]" class="form-control"
                                    value="{{ old('translations.id.SEOKeywords') }}"
                                    placeholder="Contoh: keyword1, keyword2, ...">
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-end">
                        <a href="{{ route('custom-pages.index') }}" class="btn btn-secondary mr-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            $('#summernoteId').summernote({
                height: 350,
                placeholder: 'Tulis konten di sini...'
            });
            $('#summernoteEn').summernote({
                height: 350,
                placeholder: 'Write content here...'
            });

            $('#Thumbnail').on('change', function(e) {
                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(ev) {
                        $('#previewThumbnail img').attr('src', ev.target.result);
                        $('#previewThumbnail').show();
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Auto-generate slug
            $('input[name="translations[id][Judul]"]').on('input', function() {
                if (!$('#Slug').val()) {
                    let slug = $(this).val().toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                    $('#Slug').val(slug);
                }
            });
        });
    </script>
@endpush

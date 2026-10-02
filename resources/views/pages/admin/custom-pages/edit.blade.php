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
                    <h1>Edit Halaman Custom</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('custom-pages.index') }}">Halaman Custom</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <form action="{{ route('custom-pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
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
                                            class="form-control form-control-lg @error('translations.id.Judul') is-invalid @enderror"
                                            value="{{ old('translations.id.Judul', $page->translate('id')->Judul) }}"
                                            required placeholder="Masukkan judul halaman">
                                        @error('translations.id.Judul')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Deskripsi Singkat</strong></label>
                                        <textarea name="translations[id][DeskripsiSingkat]"
                                            class="form-control @error('translations.id.DeskripsiSingkat') is-invalid @enderror" rows="3"
                                            placeholder="Tulis deskripsi singkat halaman">{{ old('translations.id.DeskripsiSingkat', $page->translate('id')->DeskripsiSingkat) }}</textarea>
                                        @error('translations.id.DeskripsiSingkat')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Konten Lengkap</strong> <span class="text-danger">*</span></label>
                                        <textarea name="translations[id][Konten]" id="summernoteId"
                                            class="form-control @error('translations.id.Konten') is-invalid @enderror"
                                            placeholder="Tulis konten lengkap di sini ...">{{ old('translations.id.Konten', $page->translate('id')->Konten) }}</textarea>
                                        @error('translations.id.Konten')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-en">
                                    <div class="form-group">
                                        <label><strong>Page Title</strong></label>
                                        <input type="text" name="translations[en][Judul]"
                                            class="form-control form-control-lg @error('translations.en.Judul') is-invalid @enderror"
                                            value="{{ old('translations.en.Judul', $page->translate('en')->Judul) }}"
                                            placeholder="Enter page title">
                                        @error('translations.en.Judul')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Short Description</strong></label>
                                        <textarea name="translations[en][DeskripsiSingkat]"
                                            class="form-control @error('translations.en.DeskripsiSingkat') is-invalid @enderror" rows="3"
                                            placeholder="Write a short description">{{ old('translations.en.DeskripsiSingkat', $page->translate('en')->DeskripsiSingkat) }}</textarea>
                                        @error('translations.en.DeskripsiSingkat')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Full Content</strong></label>
                                        <textarea name="translations[en][Konten]" id="summernoteEn"
                                            class="form-control @error('translations.en.Konten') is-invalid @enderror"
                                            placeholder="Write full content here ...">{{ old('translations.en.Konten', $page->translate('en')->Konten) }}</textarea>
                                        @error('translations.en.Konten')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Parent Halaman (Hirarki)</strong></label>
                                        <select name="ParentId"
                                            class="form-control select2 @error('ParentId') is-invalid @enderror">
                                            <option value="">-- Halaman Utama (Root) --</option>
                                            @foreach ($parentPages as $parent)
                                                <option value="{{ $parent->id }}"
                                                    {{ old('ParentId', $page->ParentId) == $parent->id ? 'selected' : '' }}>
                                                    {{ $parent->translate('id')->Judul }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('ParentId')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted">Pilih parent jika ini adalah sub-halaman</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Urutan</strong></label>
                                        <input type="number" name="Urutan"
                                            class="form-control @error('Urutan') is-invalid @enderror"
                                            value="{{ old('Urutan', $page->Urutan) }}" min="0"
                                            placeholder="Masukkan urutan tampilan (default 0)">
                                        @error('Urutan')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted">Urutan tampil (0 = paling atas)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><strong>Slug</strong></label>
                                <input type="text" name="Slug" id="Slug"
                                    class="form-control @error('Slug') is-invalid @enderror"
                                    placeholder="otomatis-terbentuk-jika-dikosongkan"
                                    value="{{ old('Slug', $page->Slug) }}">
                                @error('Slug')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
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
                            <input type="file" name="Thumbnail" class="form-control" accept="image/*"
                                id="Thumbnail">

                            {{-- Preview Gambar Lama atau Baru --}}
                            @if ($page->Thumbnail)
                                <div id="previewThumbnail" class="mt-3">
                                    <img src="{{ asset('storage/' . $page->Thumbnail) }}" class="img-thumbnail"
                                        style="width:100%; height:auto; object-fit:cover;">
                                    <small class="text-muted d-block mt-1">Gambar saat ini. Pilih file baru untuk
                                        mengganti.</small>
                                </div>
                            @else
                                <div id="previewThumbnail" class="mt-3" style="display:none;">
                                    <img src="" class="img-thumbnail"
                                        style="width:100%; height:auto; object-fit:cover;">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i
                                    class="fa fa-paper-plane text-primary mr-2"></i><strong>Publikasi</strong></h5>
                        </div>
                        <div class="card-body">
                            <select name="IsPublished" class="form-control @error('IsPublished') is-invalid @enderror">
                                <option value="0"
                                    {{ old('IsPublished', $page->IsPublished) == 0 ? 'selected' : '' }}>Draft</option>
                                <option value="1"
                                    {{ old('IsPublished', $page->IsPublished) == 1 ? 'selected' : '' }}>Publikasikan
                                </option>
                            </select>
                            @error('IsPublished')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
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
                                <input type="text" name="translations[id][SEOTitle]"
                                    class="form-control @error('translations.id.SEOTitle') is-invalid @enderror"
                                    maxlength="70"
                                    value="{{ old('translations.id.SEOTitle', $page->translate('id')->SEOTitle) }}"
                                    placeholder="Masukkan judul SEO (max 70 karakter)">
                                @error('translations.id.SEOTitle')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Meta Description</label>
                                <textarea name="translations[id][SEODescription]"
                                    class="form-control @error('translations.id.SEODescription') is-invalid @enderror" rows="3"
                                    maxlength="160" placeholder="Tuliskan deskripsi SEO (max 160 karakter)">{{ old('translations.id.SEODescription', $page->translate('id')->SEODescription) }}</textarea>
                                @error('translations.id.SEODescription')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <label>SEO Keywords</label>
                                <input type="text" name="translations[id][SEOKeywords]"
                                    class="form-control @error('translations.id.SEOKeywords') is-invalid @enderror"
                                    value="{{ old('translations.id.SEOKeywords', $page->translate('id')->SEOKeywords) }}"
                                    placeholder="Contoh: keyword1, keyword2, ...">
                                @error('translations.id.SEOKeywords')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 d-flex justify-content-end">
                        <a href="{{ route('custom-pages.index') }}" class="btn btn-secondary mr-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
                        // Jika sebelumnya tidak ada gambar, buat element img-nya dulu
                        if ($('#previewThumbnail img').length === 0) {
                            $('#previewThumbnail').html(
                                '<img src="" class="img-thumbnail" style="width:100%; height:auto; object-fit:cover;">'
                                ).show();
                        }
                        $('#previewThumbnail img').attr('src', ev.target.result);
                        $('#previewThumbnail').show();
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Auto-generate slug (hanya jika slug masih kosong atau user belum mengeditnya secara manual)
            let isSlugEdited = $('#Slug').val() !== '';

            $('input[name="translations[id][Judul]"]').on('input', function() {
                if (!isSlugEdited && !$('#Slug').val()) {
                    let slug = $(this).val().toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-')
                        .replace(/-+/g, '-');
                    $('#Slug').val(slug);
                }
            });

            // Tandai jika user mengedit slug secara manual agar tidak ditimpa otomatis
            $('#Slug').on('input', function() {
                isSlugEdited = true;
            });
        });
    </script>
@endpush

@extends('layouts.app')

@section('content')
   @push('styles')
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('') }}assets/plugins/summernote/summernote-bs4.css">
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Buat Solusi Baru</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('halaman-solusi.index') }}">Solusi</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <form action="{{ route('halaman-solusi.store') }}" method="POST" enctype="multipart/form-data" id="formSolusi">
            @csrf
            <div class="row">
                {{-- ================= KOLOM KIRI ================= --}}
                <div class="col-lg-8">

                    {{-- DATA UTAMA DENGAN TABS BAHASA --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-cogs text-primary mr-2"></i><strong>Data Utama</strong></h5>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs mb-4" id="mainLangTabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#main-id">🇮🇩 Bahasa Indonesia <span class="text-danger">*</span></a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#main-en">🇬🇧 English</a></li>
                            </ul>

                            <div class="tab-content">
                                <!-- TAB INDONESIA -->
                                <div class="tab-pane fade show active" id="main-id">
                                    <div class="form-group">
                                        <label><strong>Judul Solusi</strong> <span class="text-danger">*</span></label>
                                        <input type="text" name="translations[id][Judul]" id="JudulId" class="form-control form-control-lg @error('translations.id.Judul') is-invalid @enderror" placeholder="Tulis judul solusi..." value="{{ old('translations.id.Judul') }}" required autofocus>
                                        @error('translations.id.Judul') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Deskripsi Singkat</strong></label>
                                        <textarea name="translations[id][DeskripsiSingkat]" class="form-control" rows="3" placeholder="Tulis deskripsi singkat...">{{ old('translations.id.DeskripsiSingkat') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Konten Lengkap</strong> <span class="text-danger">*</span></label>
                                        <textarea name="translations[id][Konten]" id="summernoteId" class="form-control @error('translations.id.Konten') is-invalid @enderror" placeholder="Tulis konten solusi lengkap di sini...">{{ old('translations.id.Konten') }}</textarea>
                                        @error('translations.id.Konten') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- TAB ENGLISH -->
                                <div class="tab-pane fade" id="main-en">
                                    <div class="form-group">
                                        <label><strong>Solution Title</strong></label>
                                        <input type="text" name="translations[en][Judul]" id="JudulEn" class="form-control form-control-lg @error('translations.en.Judul') is-invalid @enderror" placeholder="Write solution title..." value="{{ old('translations.en.Judul') }}">
                                        @error('translations.en.Judul') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Short Description</strong></label>
                                        <textarea name="translations[en][DeskripsiSingkat]" class="form-control" rows="3" placeholder="Write short description...">{{ old('translations.en.DeskripsiSingkat') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Full Content</strong></label>
                                        <textarea name="translations[en][Konten]" id="summernoteEn" class="form-control @error('translations.en.Konten') is-invalid @enderror" placeholder="Write full solution content here...">{{ old('translations.en.Konten') }}</textarea>
                                        @error('translations.en.Konten') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">
                            <div class="form-group">
                                <label><strong>Slug</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-link"></i></span></div>
                                    <input type="text" name="Slug" id="Slug" class="form-control @error('Slug') is-invalid @enderror" placeholder="Otomatis terbentuk jika dikosongkan" value="{{ old('Slug') }}">
                                </div>
                                <small class="text-muted">Kosongkan untuk generate otomatis dari Judul Indonesia.</small>
                            </div>
                        </div>
                    </div>

                    {{-- DETAIL SOLUSI --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom d-flex align-items-center" style="position: relative;">
                            <h5 class="mb-0"><i class="fa fa-list text-success mr-2"></i><strong>Detail Solusi</strong></h5>
                            <button type="button" class="btn btn-success btn-sm px-3" id="btnTambahDetailSolusi" style="position: absolute; right: 20px;">
                                <i class="fa fa-plus mr-1"></i>Tambah Detail
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="detail-solusi-wrapper">
                                @php $details = old('details', [['translations' => ['id' => ['Judul' => '', 'Keterangan' => ''], 'en' => ['Judul' => '', 'Keterangan' => '']], 'gambar' => '']]); @endphp
                                @foreach ($details as $i => $detail)
                                    <div class="detail-solusi-item border rounded p-3 mb-3 position-relative bg-light" data-index="{{ $i }}">
                                        <ul class="nav nav-tabs mb-2" role="tablist">
                                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#detail-id-{{ $i }}">🇮🇩 ID</a></li>
                                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#detail-en-{{ $i }}">🇬🇧 EN</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="detail-id-{{ $i }}">
                                                <div class="form-group mb-2">
                                                    <label>Judul Detail (ID) <span class="text-danger">*</span></label>
                                                    <input type="text" name="details[{{ $i }}][translations][id][Judul]" class="form-control" value="{{ $detail['translations']['id']['Judul'] ?? '' }}" placeholder="Tulis judul detail..." required>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Keterangan (ID)</label>
                                                    <input type="text" name="details[{{ $i }}][translations][id][Keterangan]" class="form-control" value="{{ $detail['translations']['id']['Keterangan'] ?? '' }}" placeholder="Tulis keterangan detail...">
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="detail-en-{{ $i }}">
                                                <div class="form-group mb-2">
                                                    <label>Detail Title (EN)</label>
                                                    <input type="text" name="details[{{ $i }}][translations][en][Judul]" class="form-control" value="{{ $detail['translations']['en']['Judul'] ?? '' }}" placeholder="Write detail title...">
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Description (EN)</label>
                                                    <input type="text" name="details[{{ $i }}][translations][en][Keterangan]" class="form-control" value="{{ $detail['translations']['en']['Keterangan'] ?? '' }}" placeholder="Write detail description...">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label><strong>Gambar Detail</strong></label>
                                            <input type="file" name="details[{{ $i }}][gambar]" class="form-control-file" accept="image/*">
                                            @if(!empty($detail['gambar']))
                                                <img src="{{ asset('storage/' . $detail['gambar']) }}" class="mt-2" style="max-height: 60px;">
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm position-absolute" style="top:-10px; right:-10px; border-radius:50%; width:28px; height:28px; padding:0;" onclick="hapusDetailSolusi(this)"><i class="fa fa-times"></i></button>
                                    </div>
                                @endforeach
                            </div>
                            <div class="alert alert-info mt-2 mb-0 py-2 px-3" style="font-size:13px;">
                                <i class="fa fa-info-circle mr-1"></i> Tambahkan satu atau lebih detail solusi untuk menjelaskan fitur/layanan secara terpisah.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ================= KOLOM KANAN ================= --}}
                <div class="col-lg-4">
                    {{-- THUMBNAIL --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-image text-warning mr-2"></i><strong>Gambar Cover</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="custom-file">
                                <input type="file" name="Thumbnail" class="custom-file-input" id="Thumbnail" accept="image/*">
                                <label class="custom-file-label" for="Thumbnail">Pilih gambar cover...</label>
                            </div>
                            <small class="text-muted d-block mt-2">Disarankan ukuran 312×240 px.</small>
                            <div id="previewThumbnail" class="mt-3" style="display:none;">
                                <img src="" class="img-thumbnail" style="width:100%; height:auto; object-fit:cover;">
                            </div>
                        </div>
                    </div>

                    {{-- PUBLIKASI --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-paper-plane text-primary mr-2"></i><strong>Publikasi</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label><strong>Status</strong></label>
                                <select name="IsPublished" class="form-control">
                                    <option value="0" {{ old('IsPublished') == '0' ? 'selected' : '' }}>Draft</option>
                                    <option value="1" {{ old('IsPublished') == '1' ? 'selected' : '' }}>Publikasikan</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('halaman-solusi.index') }}" class="btn btn-secondary px-4"><i class="fa fa-arrow-left mr-1"></i> Kembali</a>
                                <button type="submit" class="btn btn-success px-4"><i class="fa fa-save mr-1"></i> Simpan</button>
                            </div>
                        </div>
                    </div>

                    {{-- SEO (KHUSUS INDONESIA) --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-search text-warning mr-2"></i><strong>Pengaturan SEO (ID)</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label><strong>SEO Title</strong> <span class="float-right text-muted" id="counterTitle">0/70</span></label>
                                <input type="text" name="translations[id][SEOTitle]" id="inputSEOTitle" class="form-control" maxlength="70" value="{{ old('translations.id.SEOTitle') }}" placeholder="Tulis judul SEO...">
                            </div>
                            <div class="form-group">
                                <label><strong>Meta Description</strong> <span class="float-right text-muted" id="counterDesc">0/160</span></label>
                                <textarea name="translations[id][SEODescription]" id="inputSEODesc" class="form-control" rows="3" maxlength="160" placeholder="Tulis meta description...">{{ old('translations.id.SEODescription') }}</textarea>
                            </div>
                            <div class="form-group mb-0">
                                <label><strong>SEO Keywords</strong></label>
                                <input type="text" name="translations[id][SEOKeywords]" class="form-control" value="{{ old('translations.id.SEOKeywords') }}" placeholder="pisahkan dengan koma, contoh: contoh, solusi, software">
                            </div>
                        </div>
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
            // 1. SUMMERNOTE ID & EN
            $('#summernoteId').summernote({
                height: 350,
                placeholder: 'Tulis konten solusi lengkap di sini...',
                toolbar: [['style', ['bold', 'italic', 'underline', 'clear']], ['para', ['ul', 'ol', 'paragraph']], ['insert', ['link', 'picture']], ['view', ['fullscreen', 'codeview']]]
            });
            $('#summernoteEn').summernote({
                height: 350,
                placeholder: 'Write full solution content here...',
                toolbar: [['style', ['bold', 'italic', 'underline', 'clear']], ['para', ['ul', 'ol', 'paragraph']], ['insert', ['link', 'picture']], ['view', ['fullscreen', 'codeview']]]
            });

            // 2. PREVIEW THUMBNAIL
            $('#Thumbnail').on('change', function(e) {
                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(ev) {
                        $('#previewThumbnail img').attr('src', ev.target.result);
                        $('#previewThumbnail').show();
                    }
                    reader.readAsDataURL(this.files[0]);
                    $(this).siblings('.custom-file-label').html(this.files[0].name);
                }
            });

            // 3. SEO COUNTER & PREVIEW
            function updateSEOPreview() {
                var judul = $('#JudulId').val() || 'Judul Solusi';
                var slug = $('#Slug').val() || 'slug-solusi';
                var seoTitle = $('#inputSEOTitle').val() || judul;
                var seoDesc = $('#inputSEODesc').val() || 'Deskripsi solusi akan muncul di sini...';
                $('#seoPreviewTitle').text(seoTitle);
                $('#seoPreviewSlug').text(slug);
                $('#seoPreviewDesc').text(seoDesc);
            }
            $('#JudulId, #Slug, #inputSEOTitle, #inputSEODesc').on('input', updateSEOPreview);
            $('#inputSEOTitle').on('input', function() { $('#counterTitle').text($(this).val().length + '/70'); });
            $('#inputSEODesc').on('input', function() { $('#counterDesc').text($(this).val().length + '/160'); });

            // 4. AUTO SLUG
            $('#JudulId').on('input', function() {
                if ($('#Slug').data('manual')) return;
                let slug = $(this).val().toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
                $('#Slug').val(slug);
                updateSEOPreview();
            });
            $('#Slug').on('input', function() { $(this).data('manual', true); });

            // 5. DETAIL SOLUSI DINAMIS
            $('#btnTambahDetailSolusi').click(function() {
                let idx = $('#detail-solusi-wrapper .detail-solusi-item').length;
                let html = `
                <div class="detail-solusi-item border rounded p-3 mb-3 position-relative bg-light" data-index="` + idx + `">
                    <ul class="nav nav-tabs mb-2" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#detail-id-` + idx + `">🇮🇩 ID</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#detail-en-` + idx + `">🇬🇧 EN</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="detail-id-` + idx + `">
                            <div class="form-group mb-2">
                                <label>Judul Detail (ID) <span class="text-danger">*</span></label>
                                <input type="text" name="details[` + idx + `][translations][id][Judul]" class="form-control" required placeholder="Tulis judul detail...">
                            </div>
                            <div class="form-group mb-2">
                                <label>Keterangan (ID)</label>
                                <input type="text" name="details[` + idx + `][translations][id][Keterangan]" class="form-control" placeholder="Tulis keterangan detail...">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="detail-en-` + idx + `">
                            <div class="form-group mb-2">
                                <label>Detail Title (EN)</label>
                                <input type="text" name="details[` + idx + `][translations][en][Judul]" class="form-control" placeholder="Write detail title...">
                            </div>
                            <div class="form-group mb-2">
                                <label>Description (EN)</label>
                                <input type="text" name="details[` + idx + `][translations][en][Keterangan]" class="form-control" placeholder="Write detail description...">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label><strong>Gambar Detail</strong></label>
                        <input type="file" name="details[` + idx + `][gambar]" class="form-control-file" accept="image/*">
                    </div>
                    <button type="button" class="btn btn-danger btn-sm position-absolute" style="top:-10px; right:-10px; border-radius:50%; width:28px; height:28px; padding:0;" onclick="hapusDetailSolusi(this)"><i class="fa fa-times"></i></button>
                </div>`;
                $('#detail-solusi-wrapper').append(html);
            });
        });

        function hapusDetailSolusi(btn) {
            if ($('.detail-solusi-item').length <= 1) {
                Swal.fire('Oops!', 'Minimal harus ada satu detail solusi.', 'warning');
                return;
            }
            $(btn).closest('.detail-solusi-item').fadeOut(200, function() { $(this).remove(); });
        }
    </script>
@endpush

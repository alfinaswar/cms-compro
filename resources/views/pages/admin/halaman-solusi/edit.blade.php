@extends('layouts.app')

@section('content')
    @push('styles')
         <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('') }}assets/plugins/summernote/summernote-bs4.css">
        <style>
            .invalid-feedback { animation: fadeIn .3s ease-in-out; }
            @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
            .custom-file-label::after { content: "Browse"; }
        </style>
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Edit Solusi</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('halaman-solusi.index') }}">Solusi</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        {{-- Gunakan $data->id atau encrypt($data->id) sesuai routing Anda --}}
        <form action="{{ route('halaman-solusi.update', $data->id) }}" method="POST" enctype="multipart/form-data" id="formSolusi">
            @csrf
            @method('PUT')
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
                                        <input type="text" name="translations[id][Judul]" id="JudulId"
                                            class="form-control form-control-lg @error('translations.id.Judul') is-invalid @enderror"
                                            placeholder="Tulis judul solusi..."
                                            value="{{ old('translations.id.Judul', $data->translate('id')->Judul ?? $data->Judul) }}" required autofocus>
                                        @error('translations.id.Judul') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Deskripsi Singkat</strong></label>
                                        <textarea name="translations[id][DeskripsiSingkat]" id="DeskripsiSingkatId"
                                            class="form-control @error('translations.id.DeskripsiSingkat') is-invalid @enderror"
                                            placeholder="Tulis deskripsi singkat solusi..." rows="3">{{ old('translations.id.DeskripsiSingkat', $data->translate('id')->DeskripsiSingkat ?? $data->DeskripsiSingkat) }}</textarea>
                                        @error('translations.id.DeskripsiSingkat') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Konten Lengkap</strong> <span class="text-danger">*</span></label>
                                        <textarea name="translations[id][Konten]" id="summernoteId"
                                            class="form-control @error('translations.id.Konten') is-invalid @enderror">{{ old('translations.id.Konten', $data->translate('id')->Konten ?? $data->Konten) }}</textarea>
                                        @error('translations.id.Konten') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- TAB ENGLISH -->
                                <div class="tab-pane fade" id="main-en">
                                    <div class="form-group">
                                        <label><strong>Solution Title</strong></label>
                                        <input type="text" name="translations[en][Judul]" id="JudulEn"
                                            class="form-control form-control-lg @error('translations.en.Judul') is-invalid @enderror"
                                            placeholder="Write solution title..."
                                            value="{{ old('translations.en.Judul', $data->translate('en')->Judul) }}">
                                        @error('translations.en.Judul') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Short Description</strong></label>
                                        <textarea name="translations[en][DeskripsiSingkat]" id="DeskripsiSingkatEn"
                                            class="form-control @error('translations.en.DeskripsiSingkat') is-invalid @enderror"
                                            placeholder="Write short description..." rows="3">{{ old('translations.en.DeskripsiSingkat', $data->translate('en')->DeskripsiSingkat) }}</textarea>
                                        @error('translations.en.DeskripsiSingkat') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Full Content</strong></label>
                                        <textarea name="translations[en][Konten]" id="summernoteEn"
                                            class="form-control @error('translations.en.Konten') is-invalid @enderror">{{ old('translations.en.Konten', $data->translate('en')->Konten) }}</textarea>
                                        @error('translations.en.Konten') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">
                            <div class="form-group">
                                <label><strong>Slug</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-link"></i></span></div>
                                    <input type="text" name="Slug" id="Slug" class="form-control @error('Slug') is-invalid @enderror"
                                        placeholder="otomatis-terbentuk-jika-dikosongkan" value="{{ old('Slug', $data->Slug) }}">
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
                                @php
                                    $existingDetails = $data->details()->get();
                                    $details = old('details');

                                    if (!$details) {
                                        $details = [];
                                        if ($existingDetails->count() > 0) {
                                            foreach ($existingDetails as $item) {
                                                $details[] = [
                                                    'gambar' => $item->Gambar,
                                                    'translations' => [
                                                        'id' => [
                                                            'Judul' => $item->translate('id')->Judul ?? $item->Judul,
                                                            'Keterangan' => $item->translate('id')->Keterangan ?? $item->Keterangan,
                                                        ],
                                                        'en' => [
                                                            'Judul' => $item->translate('en')->Judul ?? '',
                                                            'Keterangan' => $item->translate('en')->Keterangan ?? '',
                                                        ]
                                                    ]
                                                ];
                                            }
                                        } else {
                                            $details[] = [
                                                'gambar' => '',
                                                'translations' => [
                                                    'id' => ['Judul' => '', 'Keterangan' => ''],
                                                    'en' => ['Judul' => '', 'Keterangan' => '']
                                                ]
                                            ];
                                        }
                                    }
                                @endphp

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
                                                    <input type="text" name="details[{{ $i }}][translations][id][Judul]" class="form-control"
                                                        value="{{ old('details.'.$i.'.translations.id.Judul', $detail['translations']['id']['Judul'] ?? '') }}" required>
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Keterangan (ID)</label>
                                                    <input type="text" name="details[{{ $i }}][translations][id][Keterangan]" class="form-control"
                                                        value="{{ old('details.'.$i.'.translations.id.Keterangan', $detail['translations']['id']['Keterangan'] ?? '') }}">
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="detail-en-{{ $i }}">
                                                <div class="form-group mb-2">
                                                    <label>Detail Title (EN)</label>
                                                    <input type="text" name="details[{{ $i }}][translations][en][Judul]" class="form-control"
                                                        value="{{ old('details.'.$i.'.translations.en.Judul', $detail['translations']['en']['Judul'] ?? '') }}">
                                                </div>
                                                <div class="form-group mb-2">
                                                    <label>Description (EN)</label>
                                                    <input type="text" name="details[{{ $i }}][translations][en][Keterangan]" class="form-control"
                                                        value="{{ old('details.'.$i.'.translations.en.Keterangan', $detail['translations']['en']['Keterangan'] ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label><strong>Gambar Detail</strong></label>
                                            <input type="file" name="details[{{ $i }}][gambar]" class="form-control-file" accept="image/*" id="gambar-{{ $i }}">
                                            @if(!empty($detail['gambar']))
                                                <div class="mt-1">
                                                    <img src="{{ asset('storage/' . $detail['gambar']) }}" alt="Gambar Detail" style="max-width:100px; border-radius: 4px;">
                                                </div>
                                            @endif
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm position-absolute"
                                            style="top:-10px; right:-10px; border-radius:50%; width:28px; height:28px; padding:0;"
                                            onclick="hapusDetailSolusi(this)"><i class="fa fa-times"></i></button>
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
                    {{-- THUMBNAIL / COVER --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-image text-warning mr-2"></i><strong>Gambar Cover</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="custom-file">
                                <input type="file" name="Thumbnail" class="custom-file-input" id="Thumbnail" accept="image/*">
                                <label class="custom-file-label" for="Thumbnail">Pilih gambar cover baru...</label>
                            </div>
                            <small class="text-muted d-block mt-2">Disarankan ukuran 312×240 px.<br>Kosongkan jika tidak ingin mengubah.</small>

                            @if (!empty($data->Thumbnail))
                                <div class="mt-3" id="oldThumbnailPreview">
                                    <img src="{{ asset('storage/' . $data->Thumbnail) }}" class="img-thumbnail" style="max-width:312px; max-height:240px; width:100%; object-fit:cover;" alt="Thumbnail Lama">
                                    <small class="text-muted d-block mt-1">Preview gambar cover saat ini.</small>
                                </div>
                            @endif
                            <div id="previewThumbnail" class="mt-3" style="display:none;">
                                <img src="" class="img-thumbnail" style="max-width:312px; max-height:240px; width:100%; object-fit:cover;">
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
                                <select name="IsPublished" id="IsPublished" class="form-control">
                                    <option value="0" {{ old('IsPublished', $data->IsPublished) == '0' ? 'selected' : '' }}>Draft (Tidak Dipublikasikan)</option>
                                    <option value="1" {{ old('IsPublished', $data->IsPublished) == '1' ? 'selected' : '' }}>Publikasikan</option>
                                </select>
                                <small class="text-muted">Pilih "Publikasikan" agar solusi tampil di website.</small>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('halaman-solusi.index') }}" class="btn btn-secondary px-4">
                                    <i class="fa fa-arrow-left mr-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fa fa-save mr-1"></i> Update
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- SEO (KHUSUS INDONESIA) --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-search text-warning mr-2"></i><strong>Pengaturan SEO (ID)</strong></h5>
                        </div>
                        <div class="card-body">
                            {{-- Preview Google --}}
                            <div class="alert alert-light border mb-3 px-3 pt-2 pb-1">
                                <small class="text-muted d-block mb-1">Preview Google:</small>
                                <div style="font-family: arial, sans-serif;">
                                    <div id="seoPreviewTitle" style="color:#1a0dab; font-size:17px; line-height:20px; margin-bottom:2px;">Judul Solusi</div>
                                    <div style="color:#006621; font-size:13px; margin-bottom:2px;">{{ url('/solusi') }}/<span id="seoPreviewSlug">slug-solusi</span></div>
                                    <div id="seoPreviewDesc" style="color:#545454; font-size:13px; line-height:1.4;">Deskripsi solusi akan muncul di sini...</div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><strong>SEO Title</strong> <span class="float-right text-muted" id="counterTitle">0/70</span></label>
                                <input type="text" name="translations[id][SEOTitle]" id="inputSEOTitle" class="form-control" maxlength="70"
                                    value="{{ old('translations.id.SEOTitle', $data->translate('id')->SEOTitle ?? $data->SEOTitle) }}" placeholder="Kosongkan untuk pakai Judul">
                            </div>

                            <div class="form-group">
                                <label><strong>Meta Description</strong> <span class="float-right text-muted" id="counterDesc">0/160</span></label>
                                <textarea name="translations[id][SEODescription]" id="inputSEODesc" class="form-control" rows="3" maxlength="160"
                                    placeholder="Deskripsi untuk hasil pencarian Google">{{ old('translations.id.SEODescription', $data->translate('id')->SEODescription ?? $data->SEODescription) }}</textarea>
                            </div>

                            <div class="form-group mb-0">
                                <label><strong>SEO Keywords</strong></label>
                                <input type="text" name="translations[id][SEOKeywords]" class="form-control"
                                    value="{{ old('translations.id.SEOKeywords', $data->translate('id')->SEOKeywords ?? $data->SEOKeywords) }}" placeholder="solusi, inovasi, keyword...">
                                <small class="text-muted">Pisahkan dengan koma.</small>
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
            // 1. SUMMERNOTE ID & EN (Pisahkan ID agar tidak bentrok)
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

            // 2. CUSTOM FILE LABEL & PREVIEW THUMBNAIL
            $(document).on('change', '.custom-file-input', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).siblings('.custom-file-label').addClass('selected').html(fileName || 'Pilih file');
            });

            $('#Thumbnail').on('change', function(e) {
                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(ev) {
                        $('#previewThumbnail img').attr('src', ev.target.result);
                        $('#previewThumbnail').show();
                        $('#oldThumbnailPreview').hide(); // Sembunyikan preview lama saat ada file baru
                    }
                    reader.readAsDataURL(this.files[0]);
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
            $('#inputSEOTitle').on('input', function() { $('#counterTitle').text($(this).val().length + '/70'); }).trigger('input');
            $('#inputSEODesc').on('input', function() { $('#counterDesc').text($(this).val().length + '/160'); }).trigger('input');

            // Auto-generate slug dari judul (jika slug kosong)
            $('#JudulId').on('input', function() {
                if ($('#Slug').data('manual')) return;
                let slug = $(this).val().toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-');
                $('#Slug').val(slug);
                updateSEOPreview();
            });
            $('#Slug').on('input', function() { $(this).data('manual', true); });
            updateSEOPreview(); // Jalankan sekali saat load

            // 4. DETAIL SOLUSI DINAMIS
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
                                <input type="text" name="details[` + idx + `][translations][id][Judul]" class="form-control" required>
                            </div>
                            <div class="form-group mb-2">
                                <label>Keterangan (ID)</label>
                                <input type="text" name="details[` + idx + `][translations][id][Keterangan]" class="form-control">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="detail-en-` + idx + `">
                            <div class="form-group mb-2">
                                <label>Detail Title (EN)</label>
                                <input type="text" name="details[` + idx + `][translations][en][Judul]" class="form-control">
                            </div>
                            <div class="form-group mb-2">
                                <label>Description (EN)</label>
                                <input type="text" name="details[` + idx + `][translations][en][Keterangan]" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-2">
                        <label><strong>Gambar Detail</strong></label>
                        <input type="file" name="details[` + idx + `][gambar]" class="form-control-file" accept="image/*" id="gambar-` + idx + `">
                    </div>
                    <button type="button" class="btn btn-danger btn-sm position-absolute"
                        style="top:-10px; right:-10px; border-radius:50%; width:28px; height:28px; padding:0;"
                        onclick="hapusDetailSolusi(this)"><i class="fa fa-times"></i></button>
                </div>`;
                $('#detail-solusi-wrapper').append(html);
            });
        });

        function hapusDetailSolusi(btn) {
            if ($('.detail-solusi-item').length <= 1) {
                Swal.fire('Oops!', 'Minimal harus ada satu detail solusi.', 'warning');
                return;
            }
            $(btn).closest('.detail-solusi-item').fadeOut(200, function() {
                $(this).remove();
            });
        }
    </script>
@endpush

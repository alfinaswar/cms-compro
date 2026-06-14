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
                    <h1>Buat Solusi Baru</h1>
                </div>
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

                    {{-- DATA UTAMA --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-cogs text-primary mr-2"></i><strong>Data Utama</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="Judul"><strong>Judul Solusi</strong> <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="Judul" id="Judul"
                                    class="form-control form-control-lg @error('Judul') is-invalid @enderror"
                                    placeholder="Tulis judul solusi..." value="{{ old('Judul') }}" required autofocus>
                                @error('Judul')
                                    <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Judul akan tampil sebagai heading halaman solusi.</small>
                            </div>

                            <div class="form-group">
                                <label for="Slug"><strong>Slug</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-link"></i></span>
                                    </div>
                                    <input type="text" name="Slug" id="Slug"
                                        class="form-control @error('Slug') is-invalid @enderror"
                                        placeholder="otomatis-terbentuk-jika-dikosongkan" value="{{ old('Slug') }}">
                                    @error('Slug')
                                        <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <small class="text-muted">Kosongkan untuk generate otomatis dari judul.</small>
                            </div>
                            <div class="form-group">
                                <label for="DeskripsiSingkat"><strong>Deksripsi Singkat</strong></label>
                                <textarea name="DeskripsiSingkat" id="DeskripsiSingkat"
                                    class="form-control @error('DeskripsiSingkat') is-invalid @enderror" placeholder="Tulis deskripsi singkat solusi..."
                                    rows="3">{{ old('DeskripsiSingkat') }}</textarea>
                                @error('DeskripsiSingkat')
                                    <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Deskripsi singkat tentang solusi (opsional).</small>
                            </div>


                        </div>
                    </div>

                    {{-- KONTEN --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-edit text-primary mr-2"></i><strong>Konten</strong></h5>
                        </div>
                        <div class="card-body">
                            <textarea name="Konten" id="summernote" class="form-control @error('Konten') is-invalid @enderror" rows="8">{{ old('Konten') }}</textarea>
                            @error('Konten')
                                <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- DETAIL SOLUSI --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom d-flex align-items-center"
                            style="position: relative;">
                            <h5 class="mb-0"><i class="fa fa-list text-success mr-2"></i><strong>Detail Solusi</strong>
                            </h5>
                            <button type="button" class="btn btn-success btn-sm px-3" id="btnTambahDetailSolusi"
                                style="position: absolute; right: 20px;">
                                <i class="fa fa-plus mr-1"></i>Tambah Detail
                            </button>
                        </div>

                        <div class="card-body">
                            <div id="detail-solusi-wrapper">
                                @php $details = old('detail', [ ['judul'=>'', 'gambar'=>'', 'keterangan'=>''] ] ); @endphp
                                @foreach ($details as $i => $detail)
                                    <div class="detail-solusi-item border rounded p-3 mb-3 position-relative bg-light">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group mb-2">
                                                    <label><strong>Judul</strong> <span class="text-danger">*</span></label>
                                                    <input type="text" name="detail[{{ $i }}][judul]"
                                                        class="form-control" value="{{ $detail['judul'] ?? '' }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-2">
                                                    <label><strong>Gambar</strong> <span
                                                            class="text-danger">*</span></label>
                                                    <div class="custom-file">
                                                        <input type="file" name="detail[{{ $i }}][gambar]"
                                                            class="custom-file-input" accept="image/*"
                                                            id="gambar-{{ $i }}">
                                                        <label class="custom-file-label"
                                                            for="gambar-{{ $i }}">Pilih file</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-2">
                                                    <label><strong>Keterangan</strong></label>
                                                    <input type="text" name="detail[{{ $i }}][keterangan]"
                                                        class="form-control" value="{{ $detail['keterangan'] ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm position-absolute"
                                            style="top:-10px; right:-10px; border-radius:50%; width:28px; height:28px; padding:0;"
                                            onclick="hapusDetailSolusi(this)"><i class="fa fa-times"></i></button>
                                    </div>
                                @endforeach
                            </div>

                            <div class="alert alert-info mt-2 mb-0 py-2 px-3" style="font-size:13px;">
                                <i class="fa fa-info-circle mr-1"></i>
                                Tambahkan satu atau lebih detail solusi untuk menjelaskan fitur/layanan secara terpisah.
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ================= KOLOM KANAN ================= --}}
                <div class="col-lg-4">
                    {{-- THUMBNAIL / COVER --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-image text-warning mr-2"></i><strong>Gambar Cover</strong>
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="custom-file">
                                <input type="file" name="Thumbnail" class="custom-file-input" id="Thumbnail"
                                    accept="image/*">
                                <label class="custom-file-label" for="Thumbnail">Pilih gambar cover...</label>
                            </div>
                            <small class="text-muted d-block mt-2">
                                Disarankan ukuran 312×240 px dan rasio 13:10 untuk hasil terbaik.
                            </small>

                            <div id="previewThumbnail" class="mt-3" style="display:none;">
                                <img src="" class="img-thumbnail"
                                    style="width:312px; height:240px; object-fit:cover;">
                            </div>

                        </div>
                    </div>
                    {{-- PUBLIKASI --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i
                                    class="fa fa-paper-plane text-primary mr-2"></i><strong>Publikasi</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label><strong>Status</strong></label>
                                <select name="IsPublished" id="IsPublished" class="form-control">
                                    <option value="0" {{ old('IsPublished') == '0' ? 'selected' : '' }}>Draft (Tidak
                                        Dipublikasikan)</option>
                                    <option value="1" {{ old('IsPublished') == '1' ? 'selected' : '' }}>Publikasikan
                                    </option>
                                </select>
                                <small class="text-muted">Pilih "Publikasikan" agar solusi tampil di website.</small>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('halaman-solusi.index') }}" class="btn btn-secondary px-4">
                                    <i class="fa fa-arrow-left mr-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fa fa-save mr-1"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>



                    {{-- SEO --}}
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-search text-warning mr-2"></i><strong>Pengaturan
                                    SEO</strong></h5>
                        </div>
                        <div class="card-body">
                            {{-- Preview Google --}}
                            <div class="alert alert-light border mb-3 px-3 pt-2 pb-1">
                                <small class="text-muted d-block mb-1">Preview Google:</small>
                                <div style="font-family: arial, sans-serif;">
                                    <div id="seoPreviewTitle"
                                        style="color:#1a0dab; font-size:17px; line-height:20px; margin-bottom:2px;">
                                        Judul Solusi</div>
                                    <div style="color:#006621; font-size:13px; margin-bottom:2px;">
                                        {{ url('/solusi') }}/<span id="seoPreviewSlug">slug-solusi</span>
                                    </div>
                                    <div id="seoPreviewDesc" style="color:#545454; font-size:13px; line-height:1.4;">
                                        Deskripsi solusi akan muncul di sini...
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><strong>SEO Title</strong>
                                    <span class="float-right text-muted" id="counterTitle">0/70</span>
                                </label>
                                <input type="text" name="SEOTitle" id="inputSEOTitle" class="form-control"
                                    maxlength="70" value="{{ old('SEOTitle') }}"
                                    placeholder="Kosongkan untuk pakai Judul">
                            </div>

                            <div class="form-group">
                                <label><strong>Meta Description</strong>
                                    <span class="float-right text-muted" id="counterDesc">0/160</span>
                                </label>
                                <textarea name="SEODescription" id="inputSEODesc" class="form-control" rows="3" maxlength="160"
                                    placeholder="Deskripsi untuk hasil pencarian Google">{{ old('SEODescription') }}</textarea>
                            </div>

                            <div class="form-group mb-0">
                                <label><strong>SEO Keywords</strong></label>
                                <input type="text" name="SEOKeywords" class="form-control"
                                    value="{{ old('SEOKeywords') }}" placeholder="solusi, inovasi, keyword...">
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
            // Summernote
            $('#summernote').summernote({
                height: 350,
                placeholder: 'Tulis konten solusi lengkap di sini...',
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });

            // Custom file label
            $(document).on('change', '.custom-file-input', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
            });

            // Preview Thumbnail
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

            // SEO counter
            $('#inputSEOTitle').on('input', function() {
                $('#counterTitle').text($(this).val().length + '/70');
            }).trigger('input');
            $('#inputSEODesc').on('input', function() {
                $('#counterDesc').text($(this).val().length + '/160');
            }).trigger('input');

            // SEO Preview
            function updateSEOPreview() {
                var judul = $('#Judul').val() || 'Judul Solusi';
                var slug = $('#Slug').val() || 'slug-solusi';
                var seoTitle = $('#inputSEOTitle').val() || judul;
                var seoDesc = $('#inputSEODesc').val() || 'Deskripsi solusi akan muncul di sini...';
                $('#seoPreviewTitle').text(seoTitle);
                $('#seoPreviewSlug').text(slug);
                $('#seoPreviewDesc').text(seoDesc);
            }
            $('#Judul, #Slug, #inputSEOTitle, #inputSEODesc').on('input', updateSEOPreview);
            updateSEOPreview();

            // Auto-generate slug dari judul (jika slug kosong)
            $('#Judul').on('input', function() {
                if ($('#Slug').data('manual')) return;
                let slug = $(this).val().toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                $('#Slug').val(slug);
                updateSEOPreview();
            });
            $('#Slug').on('input', function() {
                $(this).data('manual', true);
            });

            // Detail Solusi Dinamis
            $('#btnTambahDetailSolusi').click(function() {
                let idx = $('#detail-solusi-wrapper .detail-solusi-item').length;
                let html = `
                <div class="detail-solusi-item border rounded p-3 mb-3 position-relative bg-light" data-index="` +
                    idx + `">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group mb-2">
                                <label><strong>Judul</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="detail[` + idx + `][judul]" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-2">
                                <label><strong>Gambar</strong> <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="detail[` + idx +
                    `][gambar]" class="custom-file-input" accept="image/*" id="gambar-` + idx + `">
                                    <label class="custom-file-label" for="gambar-` + idx + `">Pilih file</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-2">
                                <label><strong>Keterangan</strong></label>
                                <input type="text" name="detail[` + idx + `][keterangan]" class="form-control">
                            </div>
                        </div>
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

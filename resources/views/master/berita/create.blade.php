@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tulis Berita Baru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('master.berita.index') }}">Berita</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <form action="{{ route('master.berita.store') }}" method="POST" enctype="multipart/form-data" id="formBerita">
            @csrf

            <div class="row">
                <!-- ==================== KOLOM KIRI: KONTEN UTAMA ==================== -->
                <div class="col-lg-8">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-newspaper mr-2"></i>Konten Berita</h3>
                        </div>
                        <div class="card-body">
                            {{-- Judul --}}
                            <div class="form-group">
                                <label for="Judul"><strong>Judul Berita</strong> <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-heading"></i></span>
                                    </div>
                                    <input type="text" name="Judul" id="Judul"
                                        class="form-control form-control-lg @error('Judul') is-invalid @enderror"
                                        placeholder="Tulis judul berita yang menarik..." value="{{ old('Judul') }}"
                                        required autofocus>
                                </div>
                                @error('Judul')
                                    <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Kategori & Tags --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Kategori</strong> <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select name="Kategori" id="selectKategori"
                                                class="form-control select2-kategori @error('Kategori') is-invalid @enderror"
                                                required>
                                                <option value="">-- Pilih Kategori --</option>
                                                @foreach ($kategoris as $kat)
                                                    <option value="{{ $kat->NamaKategori }}"
                                                        {{ old('Kategori') == $kat->NamaKategori ? 'selected' : '' }}>
                                                        {{ $kat->NamaKategori }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-success" data-toggle="modal"
                                                    data-target="#modalTambahKategori" title="Tambah Kategori Baru">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @error('Kategori')
                                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Tags</strong> <small class="text-muted">(Pisahkan dengan
                                                koma)</small></label>
                                        <select name="Tags[]" class="form-control select2-tags" multiple="multiple"
                                            data-placeholder="Ketik & Enter untuk tambah tag">
                                            @if (old('Tags'))
                                                @foreach (old('Tags') as $tag)
                                                    <option value="{{ $tag }}" selected>{{ $tag }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Ringkasan --}}
                            <div class="form-group">
                                <label><strong>Ringkasan (Excerpt)</strong></label>
                                <textarea name="Ringkasan" class="form-control" rows="3"
                                    placeholder="Tulis ringkasan singkat berita (1-2 kalimat)...">{{ old('Ringkasan') }}</textarea>
                                <small class="text-muted"><i class="fa fa-info-circle"></i> Tampilan singkat di halaman list
                                    berita dan meta description.</small>
                            </div>

                            {{-- Konten --}}
                            <div class="form-group">
                                <label><strong>Konten Lengkap</strong> <span class="text-danger">*</span></label>
                                <textarea name="Konten" id="summernote" class="form-control">{{ old('Konten') }}</textarea>
                                @error('Konten')
                                    <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ==================== KOLOM KANAN: MEDIA, PUBLIKASI, SEO ==================== -->
                <div class="col-lg-4">

                    <!-- THUMBNAIL -->
                    <div class="card card-outline card-info mb-3">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-image mr-2"></i>Thumbnail Berita</h3>
                        </div>
                        <div class="card-body text-center">
                            <img id="previewThumb" src="{{ asset('img/no-image.png') }}" class="img-fluid mb-3"
                                style="max-height: 180px; border-radius: 8px; border: 1px solid #ddd;">
                            <input type="file" name="PathThumbnail" class="form-control form-control-sm" accept="image/*"
                                onchange="previewImage(this, 'previewThumb')" required>
                            @error('PathThumbnail')
                                <span class="text-danger text-sm d-block mt-1">{{ $message }}</span>
                            @enderror
                            <small class="text-muted d-block mt-2">
                                <i class="fa fa-info-circle"></i> Ukuran maks 2MB. Rasio 16:9 disarankan (1200x630px).
                            </small>
                        </div>
                    </div>

                    <!-- PUBLIKASI -->
                    <div class="card card-outline card-success mb-3">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-calendar-check mr-2"></i>Publikasi</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label><strong>Status</strong></label>
                                <select name="Status" class="form-control">
                                    <option value="Draf" {{ old('Status') == 'Draf' ? 'selected' : '' }}>📝 Draf (Belum
                                        tayang)</option>
                                    <option value="Diterbitkan" {{ old('Status') == 'Diterbitkan' ? 'selected' : '' }}>✅
                                        Diterbitkan</option>
                                    <option value="Arsip" {{ old('Status') == 'Arsip' ? 'selected' : '' }}>📦 Arsip
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><strong>Tanggal Publikasi</strong></label>
                                <input type="datetime-local" name="TanggalPublikasi" class="form-control"
                                    value="{{ old('TanggalPublikasi') }}">
                                <small class="text-muted">Kosongkan untuk publish sekarang.</small>
                            </div>
                        </div>
                    </div>

                    <!-- SEO SETTINGS -->
                    <div class="card card-outline card-warning">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-search mr-2"></i>Pengaturan SEO</h3>
                        </div>
                        <div class="card-body">
                            <!-- SEO Preview Box -->
                            <div class="alert alert-light border mb-3">
                                <small class="text-muted d-block mb-1">Preview Google Search:</small>
                                <div style="font-family: arial, sans-serif;">
                                    <div id="seoPreviewTitle"
                                        style="color: #1a0dab; font-size: 18px; line-height: 21px; margin-bottom: 2px;">
                                        Judul Berita</div>
                                    <div style="color: #006621; font-size: 14px; margin-bottom: 2px;">
                                        jasuindo.com/berita/judul-berita</div>
                                    <div id="seoPreviewDesc" style="color: #545454; font-size: 13px; line-height: 1.4;">
                                        Deskripsi berita akan muncul di sini...</div>
                                </div>
                            </div>

                            <!-- SEO Title -->
                            <div class="form-group">
                                <label>
                                    <strong>SEO Title</strong>
                                    <span class="float-right text-muted" id="counterTitle">0/70</span>
                                </label>
                                <input type="text" name="SEOTitle" id="inputSEOTitle" class="form-control"
                                    maxlength="70" value="{{ old('SEOTitle') }}"
                                    placeholder="Kosongkan untuk pakai Judul Berita">
                                <small class="text-muted">Judul yang muncul di hasil pencarian Google.</small>
                            </div>

                            <!-- SEO Description -->
                            <div class="form-group">
                                <label>
                                    <strong>Meta Description</strong>
                                    <span class="float-right text-muted" id="counterDesc">0/160</span>
                                </label>
                                <textarea name="SEODescription" id="inputSEODesc" class="form-control" rows="3" maxlength="160"
                                    placeholder="Deskripsi singkat untuk hasil pencarian Google">{{ old('SEODescription') }}</textarea>
                                <small class="text-muted">Ringkasan yang muncul di bawah judul pada hasil Google.</small>
                            </div>

                            <!-- SEO Keywords -->
                            <div class="form-group">
                                <label><strong>Meta Keywords</strong></label>
                                <input type="text" name="SEOKeywords" class="form-control"
                                    value="{{ old('SEOKeywords') }}"
                                    placeholder="jasuindo, konstruksi, berita perusahaan">
                                <small class="text-muted">Pisahkan dengan koma.</small>
                            </div>

                            <!-- OG Image -->
                            <div class="form-group">
                                <label><strong>Open Graph Image</strong></label>
                                <input type="file" name="SEOOgImage" class="form-control form-control-sm"
                                    accept="image/*">
                                <small class="text-muted">Ukuran ideal: 1200x630px. Kosongkan untuk pakai
                                    Thumbnail.</small>
                            </div>

                            <!-- OG Type -->
                            <div class="form-group">
                                <label><strong>Open Graph Type</strong></label>
                                <select name="SEOOgType" class="form-control">
                                    <option value="article" selected>Article</option>
                                    <option value="website">Website</option>
                                    <option value="product">Product</option>
                                </select>
                            </div>

                            <!-- Twitter Card -->
                            <div class="form-group">
                                <label><strong>Twitter Card Type</strong></label>
                                <select name="SEOTwitterCard" class="form-control">
                                    <option value="summary_large_image" selected>Summary Large Image</option>
                                    <option value="summary">Summary</option>
                                    <option value="app">App</option>
                                    <option value="player">Player</option>
                                </select>
                            </div>

                            <!-- Twitter Site -->
                            <div class="form-group">
                                <label><strong>Twitter Site</strong></label>
                                <input type="text" name="SEOTwitterSite" class="form-control"
                                    value="{{ old('SEOTwitterSite') }}" placeholder="@jasuindo">
                            </div>

                            <!-- Canonical URL -->
                            <div class="form-group">
                                <label><strong>Canonical URL</strong></label>
                                <input type="url" name="SEOCanonical" class="form-control"
                                    value="{{ old('SEOCanonical') }}" placeholder="https://jasuindo.com/berita/...">
                                <small class="text-muted">Gunakan jika artikel ini duplikat dari sumber lain.</small>
                            </div>

                            <!-- Robots -->
                            <div class="form-group">
                                <label><strong>Robots Meta</strong></label>
                                <select name="SEORobots" class="form-control">
                                    <option value="index,follow" selected>index, follow (Default - Muncul di Google)
                                    </option>
                                    <option value="noindex,follow">noindex, follow (Sembunyikan dari Google)</option>
                                    <option value="index,nofollow">index, nofollow</option>
                                    <option value="noindex,nofollow">noindex, nofollow (Sembunyikan total)</option>
                                </select>
                            </div>

                            <!-- Author -->
                            <div class="form-group">
                                <label><strong>Author</strong></label>
                                <input type="text" name="SEOAuthor" class="form-control"
                                    value="{{ old('SEOAuthor', auth()->user()->name) }}"
                                    placeholder="Nama penulis artikel">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==================== FOOTER ACTIONS ==================== -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <a href="{{ route('master.berita.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left mr-2"></i> Kembali
                            </a>
                            <div>
                                <button type="submit" name="action" value="draft" class="btn btn-info mr-2">
                                    <i class="fa fa-save mr-1"></i> Simpan Draf
                                </button>
                                <button type="submit" name="action" value="publish" class="btn btn-success">
                                    <i class="fa fa-paper-plane mr-1"></i> Publikasi Sekarang
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- ==================== MODAL TAMBAH KATEGORI ==================== -->
        <div class="modal fade" id="modalTambahKategori" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="fa fa-plus-circle mr-2"></i>Tambah Kategori Baru</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formKategoriBaru">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nama Kategori</label>
                                <input type="text" name="NamaKategori" id="inputNamaKategori" class="form-control"
                                    placeholder="Contoh: Prestasi" required>
                                <small class="text-danger" id="kategoriError" style="display:none;"></small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success btn-sm" id="btnSimpanKategori">
                                <i class="fa fa-save mr-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <!-- Summernote -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <!-- Summernote -->
    <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // ========== SUMMERNOTE ==========
            $('#summernote').summernote({
                height: 400,
                placeholder: 'Tulis konten berita lengkap di sini...',
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
                        // Upload image to server (opsional)
                        var data = new FormData();
                        data.append('image', files[0]);
                        data.append('_token', '{{ csrf_token() }}');
                        $.ajax({
                            url: '{{ route('master.berita.upload-image') }}',
                            method: 'POST',
                            data: data,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                $('#summernote').summernote('insertImage', response.url);
                            }
                        });
                    }
                }
            });

            // ========== SELECT2 KATEGORI ==========
            $('#selectKategori').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Kategori --',
                allowClear: true
            });

            // ========== SELECT2 TAGS ==========
            $('.select2-tags').select2({
                theme: 'bootstrap4',
                tags: true,
                tokenSeparators: [','],
                placeholder: 'Ketik & Enter untuk tambah tag'
            });

            // ========== SEO PREVIEW REAL-TIME ==========
            function updateSEOPreview() {
                var judul = $('#Judul').val() || 'Judul Berita';
                var seoTitle = $('#inputSEOTitle').val() || judul;
                var seoDesc = $('#inputSEODesc').val() || 'Deskripsi berita akan muncul di sini...';

                $('#seoPreviewTitle').text(seoTitle);
                $('#seoPreviewDesc').text(seoDesc);
            }

            $('#Judul, #inputSEOTitle, #inputSEODesc').on('input', updateSEOPreview);

            // Character Counter
            $('#inputSEOTitle').on('input', function() {
                $('#counterTitle').text($(this).val().length + '/70');
            });
            $('#inputSEODesc').on('input', function() {
                $('#counterDesc').text($(this).val().length + '/160');
            });

            // ========== TAMBAH KATEGORI ON-THE-FLY ==========
            $('#formKategoriBaru').on('submit', function(e) {
                e.preventDefault();

                var btn = $('#btnSimpanKategori');
                var input = $('#inputNamaKategori');
                var errorMsg = $('#kategoriError');

                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan...');
                input.removeClass('is-invalid');
                errorMsg.hide();

                $.ajax({
                    url: '{{ route('master.kategori-berita.store') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 200) {
                            var newOption = new Option(response.data.NamaKategori, response.data
                                .NamaKategori, false, true);
                            $('#selectKategori').append(newOption).trigger('change');
                            input.val('');
                            $('#modalTambahKategori').modal('hide');

                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors && errors.NamaKategori) {
                            input.addClass('is-invalid');
                            errorMsg.text(errors.NamaKategori[0]).show();
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false).html(
                            '<i class="fa fa-save mr-1"></i> Simpan');
                    }
                });
            });

            // Reset modal saat ditutup
            $('#modalTambahKategori').on('hidden.bs.modal', function() {
                $('#inputNamaKategori').val('').removeClass('is-invalid');
                $('#kategoriError').hide();
            });

            // ========== BUTTON ACTION (DRAFT/PUBLISH) ==========
            $('button[name="action"]').on('click', function() {
                var action = $(this).val();
                if (action === 'publish') {
                    $('select[name="Status"]').val('Diterbitkan');
                } else if (action === 'draft') {
                    $('select[name="Status"]').val('Draf');
                }
            });
        });

        // ========== PREVIEW IMAGE ==========
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush

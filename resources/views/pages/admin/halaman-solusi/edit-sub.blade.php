@extends('layouts.app')

@section('content')
    @php
        // Helper nilai terjemahan: ambil nilai field per locale untuk form.
        // Locale 'id' fallback ke kolom utama (data lama yang tersimpan tanpa terjemahan).
        $tv = function ($model, $locale, $field) {
            if (!$model) {
                return null;
            }
            $trans = $model->translations->firstWhere('Locale', $locale);
            $value = $trans->{$field} ?? null;
            if ($locale === 'id' && ($value === null || $value === '')) {
                $value = $model->{$field} ?? null;
            }
            return $value;
        };
    @endphp

    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}">
        <style>
            .repeater-item {
                background: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                padding: 20px 20px 16px;
                margin-bottom: 12px;
                position: relative;
                transition: all 0.2s;
            }

            .repeater-item:hover {
                border-color: #cfd8dc;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
            }

            .repeater-item .btn-remove {
                position: absolute;
                top: 10px;
                right: 10px;
                padding: 4px 8px;
                font-size: 12px;
            }

            .img-preview-box {
                width: 100px;
                height: 70px;
                border: 1px dashed #ccc;
                border-radius: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                background: #fff;
                margin-top: 6px;
            }

            .img-preview-box.icon-box {
                width: 64px;
                height: 64px;
            }

            .img-preview-box img {
                max-width: 100%;
                max-height: 100%;
                object-fit: cover;
            }

            .img-preview-box .placeholder-icon {
                color: #adb5bd;
                font-size: 24px;
            }

            .list-item-row {
                display: flex;
                gap: 8px;
                margin-bottom: 6px;
            }

            .list-item-row input {
                flex: 1;
            }

            .section-divider {
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 1px;
                color: #6c757d;
                font-weight: 700;
                margin: 24px 0 12px;
                padding-bottom: 8px;
                border-bottom: 1px solid #e9ecef;
            }

            .form-label-sm {
                font-size: 12px;
                font-weight: 600;
                color: #495057;
                margin-bottom: 4px;
                display: block;
            }

            template {
                display: none;
            }
        </style>
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <a href="{{ route('halaman-solusi.index') }}" class="text-muted mr-2" title="Kembali ke daftar solusi">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        Edit Subhalaman — {{ $detail->t('Judul') ?: ($subpage->Judul ?? 'Subhalaman') }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('halaman-solusi.index') }}">Solusi</a></li>
                        <li class="breadcrumb-item active">Subhalaman</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-ban"></i> Ada kesalahan input:</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('halaman-solusi.detail.update', encrypt($detail->id)) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-layer-group mr-2"></i>
                        Konten Subhalaman — {{ $detail->t('Judul') ?: ($subpage->Judul ?? '') }}
                    </h3>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="subhalaman-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab-hero">
                                <i class="fa fa-home mr-1"></i> Hero
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-komponen">
                                <i class="fa fa-cogs mr-1"></i> Section 1
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-solusi">
                                <i class="fa fa-lightbulb mr-1"></i> Section 2
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-security">
                                <i class="fa fa-shield-alt mr-1"></i> Section 3
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-faq">
                                <i class="fa fa-question-circle mr-1"></i> FAQ
                            </a>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content pt-3">

                        <!-- ==================== TAB HERO ==================== -->
                        <div class="tab-pane fade show active" id="tab-hero">
                            <div class="row">
                                <div class="col-md-8">
                                    {{-- Tab bahasa (ID/EN) untuk konten hero --}}
                                    <ul class="nav nav-tabs mb-3" id="heroLangTabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#hero-id" role="tab">
                                                <i class="fa fa-flag mr-1"></i> Bahasa Indonesia <span class="text-danger">*</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#hero-en" role="tab">
                                                <i class="fa fa-globe mr-1"></i> English
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        @foreach (['id' => 'Bahasa Indonesia', 'en' => 'English'] as $langCode => $langLabel)
                                            <div class="tab-pane fade {{ $langCode === 'id' ? 'show active' : '' }}" id="hero-{{ $langCode }}" role="tabpanel">
                                                <div class="form-group">
                                                    <label>Judul Halaman @if ($langCode === 'id')<span class="text-danger">*</span>@endif</label>
                                                    <input type="text" name="translations[{{ $langCode }}][Judul]"
                                                        class="form-control @error('translations.'.$langCode.'.Judul') is-invalid @enderror"
                                                        value="{{ old('translations.'.$langCode.'.Judul', $tv($subpage, $langCode, 'Judul')) }}"
                                                        placeholder="Judul halaman ({{ $langLabel }})" @if ($langCode === 'id') required @endif>
                                                    @error('translations.'.$langCode.'.Judul')
                                                        <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Sub Judul</label>
                                                    <input type="text" name="translations[{{ $langCode }}][SubJudul]" class="form-control"
                                                        value="{{ old('translations.'.$langCode.'.SubJudul', $tv($subpage, $langCode, 'SubJudul')) }}"
                                                        placeholder="Sub judul hero ({{ $langLabel }})">
                                                </div>
                                                <div class="form-group">
                                                    <label>Deskripsi Hero</label>
                                                    <textarea name="translations[{{ $langCode }}][Deskripsi]" class="form-control" rows="3"
                                                        placeholder="Deskripsi hero ({{ $langLabel }})">{{ old('translations.'.$langCode.'.Deskripsi', $tv($subpage, $langCode, 'Deskripsi')) }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Konten Utama (Rich Text)</label>
                                                    <textarea name="translations[{{ $langCode }}][Konten]" id="summernote-hero-{{ $langCode }}"
                                                        class="form-control summernote" rows="5">{{ old('translations.'.$langCode.'.Konten', $tv($subpage, $langCode, 'Konten')) }}</textarea>
                                                    <small class="text-muted">Opsional. Untuk konten tambahan di luar
                                                        section-section.</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Slug URL <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">/solusi/</span>
                                            </div>
                                            <input type="text" name="Slug" class="form-control"
                                                value="{{ old('Slug', $subpage->Slug ?: \Str::slug($subpage->Judul ?: ($detail->t('Judul') ?? ''))) }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Gambar Hero</label>
                                        <input type="file" name="GambarHero" class="form-control-file img-input"
                                            accept="image/*">
                                        @if ($subpage->GambarHero)
                                            <small class="text-muted d-block">Kosongkan jika tetap memakai
                                                gambar lama.</small>
                                            <div class="img-preview-box mt-2">
                                                <img src="{{ asset('storage/' . $subpage->GambarHero) }}" alt="preview">
                                            </div>
                                        @else
                                            <small class="text-muted d-block">Maks. 2MB. Format: JPG, PNG, WebP</small>
                                            <div class="img-preview-box mt-2">
                                                <i class="fa fa-image placeholder-icon"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group mt-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="IsPublished"
                                                name="IsPublished" value="1"
                                                @checked(old('IsPublished', $subpage->IsPublished))>
                                            <label class="custom-control-label" for="IsPublished">
                                                <strong>Publikasikan</strong>
                                            </label>
                                        </div>
                                        <small class="text-muted d-block mt-1">Halaman akan muncul di website jika
                                            dicentang.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ==================== TAB SECTION 1 (KOMPONEN) ==================== -->
                        <div class="tab-pane fade" id="tab-komponen">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle mr-2"></i>
                                Section komponen. Tipe <strong>Besar</strong> untuk 3 kolom atas, tipe
                                <strong>Horizontal</strong> untuk 2 kolom bawah.
                            </div>

                            <div class="section-divider">Sub Judul, Judul & Deskripsi</div>
                            @include('pages.admin.halaman-solusi.partials.subpage.section-header-tabs', ['prefix' => 'Sec1', 'paneBase' => 'sec1', 'rows' => 2])

                            <div class="section-divider">
                                Detail Komponen (Gambar, Judul, Sub Judul & Poin Keunggulan)
                                <button type="button" class="btn btn-primary btn-sm float-right" id="btnAddKomponen">
                                    <i class="fa fa-plus mr-1"></i> Tambah Komponen
                                </button>
                            </div>

                            <div id="komponenRepeater">
                                @foreach ($subpage->itemsBySection('section1') as $i => $item)
                                    @include('pages.admin.halaman-solusi.partials.subpage.komponen-row', ['i' => $i, 'item' => $item])
                                @endforeach
                            </div>

                            <template id="tpl-komponen">
                                @include('pages.admin.halaman-solusi.partials.subpage.komponen-row', ['i' => '__IDX__', 'item' => null])
                            </template>
                        </div>

                        <!-- ==================== TAB SECTION 2 (SOLUSI) ==================== -->
                        <div class="tab-pane fade" id="tab-solusi">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle mr-2"></i>
                                Section solusi berisi tabel detail berupa <strong>Icon (gambar), Judul dan
                                    Deskripsi</strong> tiap poin.
                            </div>

                            <div class="section-divider">Sub Judul, Judul & Deskripsi</div>
                            @include('pages.admin.halaman-solusi.partials.subpage.section-header-tabs', ['prefix' => 'Sec2', 'paneBase' => 'sec2', 'rows' => 3])

                            <div class="section-divider">
                                Detail (Icon, Judul & Deskripsi)
                                <button type="button" class="btn btn-primary btn-sm float-right" id="btnAddSolusi">
                                    <i class="fa fa-plus mr-1"></i> Tambah Item
                                </button>
                            </div>

                            <div id="solusiItemRepeater">
                                @foreach ($subpage->itemsBySection('section2') as $i => $item)
                                    @include('pages.admin.halaman-solusi.partials.subpage.icon-item-row', ['i' => $i, 'item' => $item, 'prefix' => 'solusi_items'])
                                @endforeach
                            </div>

                            <template id="tpl-solusi-item">
                                @include('pages.admin.halaman-solusi.partials.subpage.icon-item-row', ['i' => '__IDX__', 'item' => null, 'prefix' => 'solusi_items'])
                            </template>
                        </div>

                        <!-- ==================== TAB SECTION 3 (KEAMANAN) ==================== -->
                        <div class="tab-pane fade" id="tab-security">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle mr-2"></i>
                                Section keamanan, strukturnya sama seperti Section 2: tabel detail berupa
                                <strong>Icon (gambar), Judul dan Deskripsi</strong>.
                            </div>

                            <div class="section-divider">Sub Judul, Judul & Deskripsi</div>
                            @include('pages.admin.halaman-solusi.partials.subpage.section-header-tabs', ['prefix' => 'Sec3', 'paneBase' => 'sec3', 'rows' => 2])

                            <div class="section-divider">
                                Detail (Icon, Judul & Deskripsi)
                                <button type="button" class="btn btn-primary btn-sm float-right" id="btnAddSecurity">
                                    <i class="fa fa-plus mr-1"></i> Tambah Item
                                </button>
                            </div>

                            <div id="securityItemRepeater">
                                @foreach ($subpage->itemsBySection('section3') as $i => $item)
                                    @include('pages.admin.halaman-solusi.partials.subpage.icon-item-row', ['i' => $i, 'item' => $item, 'prefix' => 'security_items'])
                                @endforeach
                            </div>

                            <template id="tpl-security-item">
                                @include('pages.admin.halaman-solusi.partials.subpage.icon-item-row', ['i' => '__IDX__', 'item' => null, 'prefix' => 'security_items'])
                            </template>
                        </div>

                        <!-- ==================== TAB FAQ ==================== -->
                        <div class="tab-pane fade" id="tab-faq">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle mr-2"></i>
                                Section FAQ (Frequently Asked Questions) untuk halaman solusi.
                            </div>

                            <div class="section-divider">Sub Judul, Judul & Deskripsi</div>
                            @include('pages.admin.halaman-solusi.partials.subpage.section-header-tabs', ['prefix' => 'Faq', 'paneBase' => 'faq-head', 'rows' => 2])

                            <div class="section-divider">
                                Daftar FAQ
                                <button type="button" class="btn btn-primary btn-sm float-right" id="btnAddFaq">
                                    <i class="fa fa-plus mr-1"></i> Tambah FAQ
                                </button>
                            </div>

                            <div id="faqRepeater">
                                @foreach ($subpage->itemsBySection('faq') as $i => $item)
                                    @include('pages.admin.halaman-solusi.partials.subpage.faq-row', ['i' => $i, 'item' => $item])
                                @endforeach
                            </div>

                            <template id="tpl-faq">
                                @include('pages.admin.halaman-solusi.partials.subpage.faq-row', ['i' => '__IDX__', 'item' => null])
                            </template>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('halaman-solusi.index') }}" class="btn btn-secondary mr-2">
                        <i class="fa fa-times mr-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save mr-1"></i> Simpan Subhalaman
                    </button>
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
            $('.summernote').summernote({
                height: 300,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview']]
                ]
            });

            // Preview gambar setelah dipilih
            $(document).on('change', '.img-input', function() {
                const box = $(this).closest('.form-group').find('.img-preview-box');
                if (this.files && this.files[0]) {
                    box.html('<img src="' + URL.createObjectURL(this.files[0]) + '" alt="preview">');
                }
            });

            // Remove repeater item
            $(document).on('click', '.btn-remove', function() {
                if (confirm('Hapus item ini? Perubahan tersimpan saat form disimpan.')) {
                    $(this).closest('.repeater-item').remove();
                }
            });

            // Remove list item
            $(document).on('click', '.btn-remove-item', function() {
                $(this).closest('.list-item-row').remove();
            });

            // Add list item (poin keunggulan)
            $(document).on('click', '.btn-add-item', function() {
                const container = $(this).siblings('.list-items-container');
                const inputName = container.find('input[type=text]').first().attr('name');
                if (!inputName) return;
                container.append(`
                    <div class="list-item-row">
                        <input type="text" name="${inputName}" class="form-control form-control-sm" placeholder="Poin keunggulan...">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-item">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                `);
            });

            // Helper: inject template repeater
            function appendFromTemplate(tplId, containerId, idx) {
                const tpl = document.getElementById(tplId);
                if (!tpl) return;
                $(containerId).append(
                    tpl.innerHTML.split('__IDX__').join(idx)
                );
            }

            // Add Komponen (Section 1)
            let komponenIdx = {{ $subpage->itemsBySection('section1')->count() }};
            $('#btnAddKomponen').click(function() {
                appendFromTemplate('tpl-komponen', '#komponenRepeater', komponenIdx++);
            });

            // Add Item (Section 2)
            let solusiIdx = {{ $subpage->itemsBySection('section2')->count() }};
            $('#btnAddSolusi').click(function() {
                appendFromTemplate('tpl-solusi-item', '#solusiItemRepeater', solusiIdx++);
            });

            // Add Item (Section 3)
            let securityIdx = {{ $subpage->itemsBySection('section3')->count() }};
            $('#btnAddSecurity').click(function() {
                appendFromTemplate('tpl-security-item', '#securityItemRepeater', securityIdx++);
            });

            // Add FAQ
            let faqIdx = {{ $subpage->itemsBySection('faq')->count() }};
            $('#btnAddFaq').click(function() {
                appendFromTemplate('tpl-faq', '#faqRepeater', faqIdx++);
            });

            // Success modal
            @if (Session::get('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ Session::get('success') }}',
                    iconColor: '#4BCC1F',
                    confirmButtonColor: '#4BCC1F'
                });
            @endif
        });
    </script>
@endpush

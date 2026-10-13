@extends('layouts.app')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}">
        <style>
            .detail-preview {
                width: 64px;
                height: 64px;
                border: 1px dashed #ccc;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                background: #fafafa;
            }

            .detail-preview img {
                max-width: 100%;
                max-height: 100%;
            }

            .section-hint {
                font-size: 12px;
                color: #6c757d;
            }

            /* Language Toggle */
            .lang-toggle {
                display: inline-flex;
                background: #f1f3f5;
                border-radius: 8px;
                padding: 3px;
                gap: 2px;
            }

            .lang-toggle button {
                border: none;
                background: transparent;
                padding: 6px 14px;
                font-size: 13px;
                font-weight: 600;
                border-radius: 6px;
                cursor: pointer;
                color: #6c757d;
                transition: all 0.2s;
            }

            .lang-toggle button.active {
                background: #fff;
                color: #007bff;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .lang-field {
                display: none;
            }

            .lang-field.active {
                display: block;
            }
        </style>
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tentang Kami <small class="text-muted">(Multi-Bahasa)</small></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Tentang Kami</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <form action="{{ route('about-us.update') }}" method="POST" enctype="multipart/form-data" id="formAboutUs">
            @csrf
            @method('PUT')

            <div class="card card-primary card-outline">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-building mr-2"></i>
                        Kelola Konten Halaman Tentang Kami
                    </h3>
                    {{-- ✅ GLOBAL LANGUAGE TOGGLE --}}
                    <div class="lang-toggle d-flex justify-content-end" id="globalLangToggle">
                        <button type="button" class="active" data-lang="id">🇮🇩 ID</button>
                        <button type="button" data-lang="en">🇬🇧 EN</button>
                    </div>


                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Semua section dikelola di sini. Gunakan toggle bahasa di kanan atas untuk mengisi versi ID / EN.
                    </p>

                    <ul class="nav nav-tabs" id="about-tabs" role="tablist">
                        @foreach ($sectionConfig as $id => $config)
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $config['key'] }}-tab"
                                    data-toggle="tab" href="#tab-{{ $config['key'] }}" role="tab">
                                    {{ $config['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content pt-3" id="about-tabs-content">
                        @foreach ($sectionConfig as $id => $config)
                            @php
                                $about = $sections[$id] ?? null;
                                $details = $about ? $about->getDetail : collect();

                                // Ambil data translations per locale
                                $transId = $about ? $about->translations->firstWhere('Locale', 'id') : null;
                                $transEn = $about ? $about->translations->firstWhere('Locale', 'en') : null;

                                $isMeta = !empty($config['meta_keys']);
                                if ($isMeta) {
                                    $meta = [];
                                    foreach ($config['meta_keys'] as $key => $label) {
                                        $meta[$key] = optional($details->firstWhere('Judul', $key))->Deskripsi;
                                    }
                                }
                            @endphp

                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{ $config['key'] }}"
                                role="tabpanel">

                                <p class="section-hint mb-3">
                                    <i class="fa fa-info-circle"></i> {{ $config['hint'] }}
                                </p>

                                {{-- SUB JUDUL (2 bahasa) --}}
                                <div class="form-group">
                                    <label>Sub Judul</label>
                                    <div class="lang-field active" data-lang="id">
                                        <input type="text"
                                            name="sections[{{ $id }}][translations][id][SubJudul]"
                                            class="form-control"
                                            value="{{ old("sections.$id.translations.id.SubJudul", $transId->SubJudul ?? ($about->SubJudul ?? '')) }}"
                                            placeholder="Sub judul section (ID)">
                                    </div>
                                    <div class="lang-field" data-lang="en">
                                        <input type="text"
                                            name="sections[{{ $id }}][translations][en][SubJudul]"
                                            class="form-control"
                                            value="{{ old("sections.$id.translations.en.SubJudul", $transEn->SubJudul ?? '') }}"
                                            placeholder="Section subtitle (EN)">
                                    </div>
                                </div>

                                {{-- JUDUL (2 bahasa) --}}
                                <div class="form-group">
                                    <label>Judul</label>
                                    <div class="lang-field active" data-lang="id">
                                        <input type="text" name="sections[{{ $id }}][translations][id][Judul]"
                                            class="form-control"
                                            value="{{ old("sections.$id.translations.id.Judul", $transId->Judul ?? ($about->Judul ?? '')) }}"
                                            placeholder="Judul section (ID)">
                                    </div>
                                    <div class="lang-field" data-lang="en">
                                        <input type="text" name="sections[{{ $id }}][translations][en][Judul]"
                                            class="form-control"
                                            value="{{ old("sections.$id.translations.en.Judul", $transEn->Judul ?? '') }}"
                                            placeholder="Section title (EN)">
                                    </div>
                                </div>

                                {{-- DESKRIPSI (2 bahasa dengan Summernote) --}}
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <div class="lang-field active" data-lang="id">
                                        <textarea name="sections[{{ $id }}][translations][id][Deskripsi]" class="form-control summernote-about"
                                            rows="5" placeholder="Deskripsi (ID)">{{ old("sections.$id.translations.id.Deskripsi", $transId->Deskripsi ?? ($about->Deskripsi ?? '')) }}</textarea>
                                    </div>
                                    <div class="lang-field" data-lang="en">
                                        <textarea name="sections[{{ $id }}][translations][en][Deskripsi]" class="form-control summernote-about"
                                            rows="5" placeholder="Description (EN)">{{ old("sections.$id.translations.en.Deskripsi", $transEn->Deskripsi ?? '') }}</textarea>
                                    </div>
                                </div>

                                {{-- GAMBAR (TIDAK di-translate, single file) --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gambar</label>
                                            <input type="file" name="sections[{{ $id }}][Gambar]"
                                                class="form-control-file" accept="image/*">
                                            <small class="text-muted">Opsional. Maks. 2MB. (Gambar sama untuk semua
                                                bahasa)</small>
                                            @if (
                                                !empty($about->Gambar) &&
                                                    !str_contains($about->Gambar, 'fa-') &&
                                                    \Illuminate\Support\Facades\Storage::disk('public')->exists($about->Gambar))
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $about->Gambar) }}"
                                                        class="img-thumbnail" style="max-height: 120px;" alt="Preview">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- META fields (Video & Quote) --}}
                                @if ($isMeta)
                                    <hr>
                                    <h5 class="mb-3">Pengaturan Tambahan</h5>
                                    <div class="row">
                                        @foreach ($config['meta_keys'] as $key => $label)
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ $label }}</label>
                                                    <input type="text"
                                                        name="sections[{{ $id }}][meta][{{ $key }}]"
                                                        class="form-control"
                                                        value="{{ old("sections.$id.meta.$key", $meta[$key] ?? '') }}"
                                                        placeholder="{{ $label }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- DETAIL REPEATER (dengan support multi-bahasa) --}}
                                @if (!empty($config['detail_labels']))
                                    @php
                                        $dl = $config['detail_labels'];
                                        $hasIcon = !empty($dl['has_icon']);
                                    @endphp
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0">Item Detail</h5>
                                        <button type="button" class="btn btn-sm btn-primary btn-tambah-detail"
                                            data-section="{{ $id }}"
                                            data-has-icon="{{ $hasIcon ? '1' : '0' }}"
                                            data-label-judul="{{ $dl['Judul'] }}"
                                            data-label-deskripsi="{{ $dl['Deskripsi'] }}">
                                            <i class="fa fa-plus"></i> Tambah Item
                                        </button>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <thead class="bg-light">
                                                <tr>
                                                    <th style="width:5%" class="text-center">#</th>
                                                    <th style="width:22%">Gambar{{ $hasIcon ? ' / Icon FA' : '' }}</th>
                                                    <th style="width:22%">{{ $dl['Judul'] }}</th>
                                                    <th>{{ $dl['Deskripsi'] }}</th>
                                                    <th style="width:5%"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="detail-container" data-section="{{ $id }}">
                                                @foreach ($details as $idx => $detail)
                                                    @php
                                                        $isFa =
                                                            $detail->Gambar &&
                                                            str_contains((string) $detail->Gambar, 'fa-');
                                                        $dtId = $detail->translations->firstWhere('Locale', 'id');
                                                        $dtEn = $detail->translations->firstWhere('Locale', 'en');
                                                    @endphp
                                                    <tr class="detail-row">
                                                        <td class="text-center row-number">{{ $idx + 1 }}</td>
                                                        <td>
                                                            <input type="hidden"
                                                                name="sections[{{ $id }}][details][{{ $idx }}][id]"
                                                                value="{{ $detail->id }}">
                                                            <div class="d-flex align-items-start">
                                                                <div class="detail-preview mr-2">
                                                                    @if ($detail->Gambar && !$isFa && \Illuminate\Support\Facades\Storage::disk('public')->exists($detail->Gambar))
                                                                        <img src="{{ asset('storage/' . $detail->Gambar) }}"
                                                                            class="img-preview" alt="">
                                                                        <i class="fa fa-image text-muted preview-placeholder"
                                                                            style="display:none;"></i>
                                                                    @else
                                                                        <img class="img-preview" style="display:none"
                                                                            alt="">
                                                                        <i
                                                                            class="fa fa-image text-muted preview-placeholder"></i>
                                                                    @endif
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <input type="file"
                                                                        name="sections[{{ $id }}][details][{{ $idx }}][Gambar]"
                                                                        class="form-control-file input-gambar mb-1"
                                                                        accept="image/*">
                                                                    @if ($hasIcon)
                                                                        <input type="text"
                                                                            name="sections[{{ $id }}][details][{{ $idx }}][IconFa]"
                                                                            class="form-control form-control-sm"
                                                                            placeholder="fa-solid fa-gem"
                                                                            value="{{ $isFa ? $detail->Gambar : '' }}">
                                                                        <small class="text-muted">Isi class FA ATAU upload
                                                                            gambar</small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="lang-field active" data-lang="id">
                                                                <input type="text"
                                                                    name="sections[{{ $id }}][details][{{ $idx }}][translations][id][Judul]"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ $dtId->Judul ?? ($detail->Judul ?? '') }}"
                                                                    placeholder="{{ $dl['Judul'] }} (ID)">
                                                            </div>
                                                            <div class="lang-field" data-lang="en">
                                                                <input type="text"
                                                                    name="sections[{{ $id }}][details][{{ $idx }}][translations][en][Judul]"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ $dtEn->Judul ?? '' }}"
                                                                    placeholder="{{ $dl['Judul'] }} (EN)">
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="lang-field active" data-lang="id">
                                                                <textarea name="sections[{{ $id }}][details][{{ $idx }}][translations][id][Deskripsi]"
                                                                    class="form-control form-control-sm" rows="3" placeholder="{{ $dl['Deskripsi'] }} (ID)">{{ $dtId->Deskripsi ?? ($detail->Deskripsi ?? '') }}</textarea>
                                                            </div>
                                                            <div class="lang-field" data-lang="en">
                                                                <textarea name="sections[{{ $id }}][details][{{ $idx }}][translations][en][Deskripsi]"
                                                                    class="form-control form-control-sm" rows="3" placeholder="{{ $dl['Deskripsi'] }} (EN)">{{ $dtEn->Deskripsi ?? '' }}</textarea>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm btn-hapus-detail">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer text-right">
                    @canany(['tentang-kami.create', 'tentang-kami.edit'])
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa fa-save mr-1"></i> Simpan Semua Konten
                        </button>
                    @endcanany
                </div>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: @json(session('success')),
                    timer: 2000,
                    showConfirmButton: false
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: @json(session('error')),
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            // Summernote untuk semua textarea (termasuk EN yang hidden)
            $('.summernote-about').summernote({
                height: 180,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });

            // ============================================
            // ✅ GLOBAL LANGUAGE TOGGLE
            // ============================================
            $('#globalLangToggle button').on('click', function() {
                const lang = $(this).data('lang');
                $('#globalLangToggle button').removeClass('active');
                $(this).addClass('active');

                // Toggle semua lang-field di semua section
                $('.lang-field').removeClass('active');
                $(`.lang-field[data-lang="${lang}"]`).addClass('active');

                // Re-sync Summernote karena textarea yang di-toggle butuh refresh
                setTimeout(() => {
                    $('.summernote-about').each(function() {
                        if ($(this).closest('.lang-field').hasClass('active')) {
                            $(this).summernote('code', $(this).val());
                        }
                    });
                }, 50);
            });

            // ============================================
            // DETAIL REPEATER
            // ============================================
            const rowCounters = {};
            $('.detail-container').each(function() {
                rowCounters[$(this).data('section')] = $(this).find('tr').length;
            });

            function updateRowNumbers(sectionId) {
                $(`.detail-container[data-section="${sectionId}"] tr`).each(function(i) {
                    $(this).find('.row-number').text(i + 1);
                });
            }

            $('.btn-tambah-detail').on('click', function() {
                const sectionId = $(this).data('section');
                const hasIcon = $(this).data('has-icon') == '1';
                const labelJudul = $(this).data('label-judul');
                const labelDeskripsi = $(this).data('label-deskripsi');
                const idx = rowCounters[sectionId] || 0;
                rowCounters[sectionId] = idx + 1;

                const currentLang = $('#globalLangToggle button.active').data('lang');

                let iconField = '';
                if (hasIcon) {
                    iconField = `<input type="text" name="sections[${sectionId}][details][${idx}][IconFa]"
                        class="form-control form-control-sm" placeholder="fa-solid fa-gem">
                        <small class="text-muted">Isi class FA ATAU upload gambar</small>`;
                }

                const row = `
                    <tr class="detail-row">
                        <td class="text-center row-number"></td>
                        <td>
                            <div class="d-flex align-items-start">
                                <div class="detail-preview mr-2">
                                    <img class="img-preview" style="display:none" alt="">
                                    <i class="fa fa-image text-muted preview-placeholder"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="sections[${sectionId}][details][${idx}][Gambar]"
                                        class="form-control-file input-gambar mb-1" accept="image/*">
                                    ${iconField}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="lang-field ${currentLang === 'id' ? 'active' : ''}" data-lang="id">
                                <input type="text" name="sections[${sectionId}][details][${idx}][translations][id][Judul]"
                                    class="form-control form-control-sm" placeholder="${labelJudul} (ID)">
                            </div>
                            <div class="lang-field ${currentLang === 'en' ? 'active' : ''}" data-lang="en">
                                <input type="text" name="sections[${sectionId}][details][${idx}][translations][en][Judul]"
                                    class="form-control form-control-sm" placeholder="${labelJudul} (EN)">
                            </div>
                        </td>
                        <td>
                            <div class="lang-field ${currentLang === 'id' ? 'active' : ''}" data-lang="id">
                                <textarea name="sections[${sectionId}][details][${idx}][translations][id][Deskripsi]"
                                    class="form-control form-control-sm" rows="3"
                                    placeholder="${labelDeskripsi} (ID)"></textarea>
                            </div>
                            <div class="lang-field ${currentLang === 'en' ? 'active' : ''}" data-lang="en">
                                <textarea name="sections[${sectionId}][details][${idx}][translations][en][Deskripsi]"
                                    class="form-control form-control-sm" rows="3"
                                    placeholder="${labelDeskripsi} (EN)"></textarea>
                            </div>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm btn-hapus-detail">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                $(`.detail-container[data-section="${sectionId}"]`).append(row);
                updateRowNumbers(sectionId);
            });

            $('body').on('click', '.btn-hapus-detail', function() {
                const container = $(this).closest('tbody');
                $(this).closest('tr').remove();
                updateRowNumbers(container.data('section'));
            });

            $('body').on('change', '.input-gambar', function() {
                const file = this.files[0];
                const cell = $(this).closest('td');
                const preview = cell.find('.img-preview');
                const placeholder = cell.find('.preview-placeholder');
                if (!file) {
                    preview.hide();
                    placeholder.show();
                    return;
                }
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire('Error!', 'Ukuran gambar maksimal 2MB', 'error');
                    $(this).val('');
                    return;
                }
                const reader = new FileReader();
                reader.onload = e => {
                    preview.attr('src', e.target.result).show();
                    placeholder.hide();
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush

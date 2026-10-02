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
        </style>
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tentang Kami</h1>
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
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-building mr-2"></i>
                        Kelola Konten Halaman Tentang Kami
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Semua section halaman About dikelola di sini. Simpan sekali untuk memperbarui seluruh konten.
                    </p>

                    <ul class="nav nav-tabs" id="about-tabs" role="tablist">
                        @foreach ($sectionConfig as $id => $config)
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                    id="tab-{{ $config['key'] }}-tab"
                                    data-toggle="tab"
                                    href="#tab-{{ $config['key'] }}"
                                    role="tab">
                                    {{ $config['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content pt-3" id="about-tabs-content">
                        @foreach ($sectionConfig as $id => $config)
                            @php
                                $about = $sections[$id] ?? null;
                                $details = collect($about?->getDetail ?? []);
                                if (!empty($config['meta_keys'])) {
                                    $meta = [];
                                    foreach ($config['meta_keys'] as $key => $label) {
                                        $meta[$key] = optional($details->firstWhere('Judul', $key))->Deskripsi;
                                    }
                                    $details = collect(); // meta pakai form khusus
                                }
                            @endphp

                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                id="tab-{{ $config['key'] }}" role="tabpanel">

                                <p class="section-hint mb-3">
                                    <i class="fa fa-info-circle"></i> {{ $config['hint'] }}
                                </p>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Sub Judul</label>
                                            <input type="text"
                                                name="sections[{{ $id }}][SubJudul]"
                                                class="form-control"
                                                value="{{ old("sections.$id.SubJudul", $about->SubJudul ?? '') }}"
                                                placeholder="Sub judul section">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Judul</label>
                                            <input type="text"
                                                name="sections[{{ $id }}][Judul]"
                                                class="form-control"
                                                value="{{ old("sections.$id.Judul", $about->Judul ?? '') }}"
                                                placeholder="Judul section">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <textarea name="sections[{{ $id }}][Deskripsi]"
                                                class="form-control summernote-about"
                                                rows="5"
                                                placeholder="Deskripsi">{{ old("sections.$id.Deskripsi", $about->Deskripsi ?? '') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Gambar</label>
                                            <input type="file"
                                                name="sections[{{ $id }}][Gambar]"
                                                class="form-control-file"
                                                accept="image/*">
                                            <small class="text-muted">Opsional. Maks. 2MB.</small>
                                            @if (!empty($about->Gambar) && !str_contains($about->Gambar, 'fa-'))
                                                <div class="mt-2">
                                                    <img src="{{ asset('storage/' . $about->Gambar) }}"
                                                        class="img-thumbnail" style="max-height: 120px;" alt="Preview">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Meta fields (Video & Quote) --}}
                                @if (!empty($config['meta_keys']))
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

                                {{-- Detail repeater --}}
                                @if (!empty($config['detail_labels']))
                                    @php
                                        $dl = $config['detail_labels'];
                                        $hasIcon = !empty($dl['has_icon']);
                                    @endphp
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0">Item Detail</h5>
                                        <button type="button"
                                            class="btn btn-sm btn-primary btn-tambah-detail"
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
                                                        $isFa = $detail->Gambar && (str_starts_with($detail->Gambar, 'fa-') || str_contains($detail->Gambar, ' fa-') || str_starts_with($detail->Gambar, 'fa '));
                                                    @endphp
                                                    <tr class="detail-row">
                                                        <td class="text-center row-number">{{ $idx + 1 }}</td>
                                                        <td>
                                                            <input type="hidden"
                                                                name="sections[{{ $id }}][details][{{ $idx }}][id]"
                                                                value="{{ $detail->id }}">
                                                            <div class="d-flex align-items-start">
                                                                <div class="detail-preview mr-2">
                                                                    @if ($detail->Gambar && !$isFa)
                                                                        <img src="{{ asset('storage/' . $detail->Gambar) }}"
                                                                            class="img-preview" alt="">
                                                                    @else
                                                                        <img src="" class="img-preview" style="display:none" alt="">
                                                                        <i class="fa fa-image text-muted preview-placeholder"></i>
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
                                                                        <small class="text-muted">Isi class FA ATAU upload gambar</small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                                name="sections[{{ $id }}][details][{{ $idx }}][Judul]"
                                                                class="form-control form-control-sm"
                                                                value="{{ $detail->Judul }}"
                                                                placeholder="{{ $dl['Judul'] }}">
                                                        </td>
                                                        <td>
                                                            <textarea name="sections[{{ $id }}][details][{{ $idx }}][Deskripsi]"
                                                                class="form-control form-control-sm" rows="3"
                                                                placeholder="{{ $dl['Deskripsi'] }}">{{ $detail->Deskripsi }}</textarea>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-danger btn-sm btn-hapus-detail">
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

            $('.summernote-about').summernote({
                height: 180,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']]
                ]
            });

            const rowCounters = {};
            $('.detail-container').each(function() {
                const sid = $(this).data('section');
                rowCounters[sid] = $(this).find('tr').length;
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

                let iconField = '';
                if (hasIcon) {
                    iconField = `
                        <input type="text" name="sections[${sectionId}][details][${idx}][IconFa]"
                            class="form-control form-control-sm" placeholder="fa-solid fa-gem">
                        <small class="text-muted">Isi class FA ATAU upload gambar</small>`;
                }

                const row = `
                    <tr class="detail-row">
                        <td class="text-center row-number"></td>
                        <td>
                            <div class="d-flex align-items-start">
                                <div class="detail-preview mr-2">
                                    <img src="" class="img-preview" style="display:none" alt="">
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
                            <input type="text" name="sections[${sectionId}][details][${idx}][Judul]"
                                class="form-control form-control-sm" placeholder="${labelJudul}">
                        </td>
                        <td>
                            <textarea name="sections[${sectionId}][details][${idx}][Deskripsi]"
                                class="form-control form-control-sm" rows="3"
                                placeholder="${labelDeskripsi}"></textarea>
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
                const sectionId = container.data('section');
                $(this).closest('tr').remove();
                updateRowNumbers(sectionId);
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
                reader.onload = function(e) {
                    preview.attr('src', e.target.result).show();
                    placeholder.hide();
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush

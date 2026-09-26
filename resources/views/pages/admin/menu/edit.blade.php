@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            /* Styling konsisten dengan halaman lain */
            .card-modern {
                background: #ffffff;
                border-radius: 12px;
                border: 1px solid #eef2f5;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
            }

            .card-header-modern {
                padding: 16px 20px;
                border-bottom: 1px solid #edf2f7;
                font-weight: 600;
                font-size: 15px;
                color: #1a202c;
                background: #fcfcfd;
                border-radius: 12px 12px 0 0;
            }

            .form-control-custom {
                border-radius: 8px;
                border: 1px solid #e2e8f0;
                height: 42px;
                font-size: 13px;
                color: #4a5568;
            }

            .form-control-custom:focus {
                border-color: #2563eb;
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            }

            .nav-tabs .nav-link {
                border: none;
                color: #718096;
                font-weight: 600;
                font-size: 13px;
                padding: 12px 20px;
                border-bottom: 2px solid transparent;
            }

            .nav-tabs .nav-link.active {
                color: #2563eb;
                border-bottom: 2px solid #2563eb;
                background: transparent;
            }

            .btn-custom-primary {
                background-color: #2563eb;
                border-color: #2563eb;
                color: white;
                border-radius: 8px;
                font-weight: 500;
                font-size: 13px;
                padding: 10px 20px;
            }

            .btn-custom-primary:hover {
                background-color: #1d4ed8;
                color: white;
            }

            .btn-custom-secondary {
                background-color: #ffffff;
                border: 1px solid #e2e8f0;
                color: #4a5568;
                border-radius: 8px;
                font-weight: 500;
                font-size: 13px;
                padding: 10px 20px;
            }

            .btn-custom-secondary:hover {
                background-color: #f7fafc;
                color: #2d3748;
            }

            .info-box {
                background: #f0f9ff;
                border-left: 4px solid #2563eb;
                padding: 12px 16px;
                border-radius: 8px;
                margin-bottom: 20px;
                font-size: 13px;
                color: #1e40af;
            }
        </style>
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold" style="font-size: 20px; color: #1a202c;">
                        <i class="fa fa-edit mr-2 text-primary"></i>Edit Menu
                    </h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a class="btn btn-custom-secondary" href="{{ route('menu.index') }}">
                        <i class="fa fa-arrow-left mr-2"></i> Kembali ke Daftar Menu
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('menu.update', $menu->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- KOLOM KIRI: TRANSLATION & LINK -->
                    <div class="col-lg-8">
                        <div class="card-modern mb-4">
                            <div class="card-header-modern">
                                <i class="fa fa-language text-primary mr-2"></i> Nama Menu (Multi-Bahasa)
                            </div>
                            <div class="card-body p-4">
                                <ul class="nav nav-tabs mb-4" id="langTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tab-id-tab" data-toggle="tab" href="#tab-id"
                                            role="tab">
                                            🇮🇩 Bahasa Indonesia <span class="text-danger">*</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab-en-tab" data-toggle="tab" href="#tab-en" role="tab">
                                            🇬🇧 English
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="langTabsContent">
                                    <!-- TAB INDONESIA -->
                                    <div class="tab-pane fade show active" id="tab-id" role="tabpanel">
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold text-dark mb-2">Nama Menu <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="translations[id][NamaMenu]"
                                                class="form-control form-control-custom @error('translations.id.NamaMenu') is-invalid @enderror"
                                                value="{{ old('translations.id.NamaMenu', $menu->translate('id')->NamaMenu) }}"
                                                placeholder="Contoh: Hubungan Investor" required>
                                            @error('translations.id.NamaMenu')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- TAB ENGLISH -->
                                    <div class="tab-pane fade" id="tab-en" role="tabpanel">
                                        <div class="form-group mb-3">
                                            <label class="font-weight-bold text-dark mb-2">Menu Name</label>
                                            <input type="text" name="translations[en][NamaMenu]"
                                                class="form-control form-control-custom @error('translations.en.NamaMenu') is-invalid @enderror"
                                                value="{{ old('translations.en.NamaMenu', $menu->translate('en')->NamaMenu) }}"
                                                placeholder="e.g. Investor Relations">
                                            @error('translations.en.NamaMenu')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PENGATURAN TAUTAN -->
                        <div class="card-modern mb-4">
                            <div class="card-header-modern">
                                <i class="fa fa-link text-success mr-2"></i> Pengaturan Tautan
                            </div>
                            <div class="card-body p-4">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-dark mb-2">Jenis Tautan <span
                                            class="text-danger">*</span></label>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="jenisHalamanCMS" name="JenisLink"
                                            class="custom-control-input" value="page"
                                            {{ old('JenisLink', $menu->JenisLink) == 'page' ? 'checked' : '' }}
                                            onchange="toggleLinkType()">
                                        <label class="custom-control-label" for="jenisHalamanCMS">Halaman CMS</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="jenisURLKustom" name="JenisLink"
                                            class="custom-control-input" value="custom"
                                            {{ old('JenisLink', $menu->JenisLink) == 'custom' ? 'checked' : '' }}
                                            onchange="toggleLinkType()">
                                        <label class="custom-control-label" for="jenisURLKustom">URL Kustom</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="jenisRoute" name="JenisLink" class="custom-control-input"
                                            value="route"
                                            {{ old('JenisLink', $menu->JenisLink) == 'route' ? 'checked' : '' }}
                                            onchange="toggleLinkType()">
                                        <label class="custom-control-label" for="jenisRoute">Route Laravel</label>
                                    </div>
                                    @error('JenisLink')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Pilih Halaman CMS -->
                                <div class="form-group mb-3" id="groupPilihHalaman"
                                    style="display: {{ old('JenisLink', $menu->JenisLink) == 'page' ? 'block' : 'none' }};">
                                    <label class="font-weight-bold text-dark mb-2">Pilih Halaman CMS:</label>
                                    <select class="form-control form-control-custom @error('Url') is-invalid @enderror"
                                        id="Url" name="Url">
                                        <option value="">-- Pilih Halaman --</option>
                                        <option value="/tentang-kami"
                                            {{ old('Url', $menu->Url) == '/tentang-kami' ? 'selected' : '' }}>Tentang Kami
                                        </option>
                                        <option value="/solusi"
                                            {{ old('Url', $menu->Url) == '/solusi' ? 'selected' : '' }}>Solusi & Layanan
                                        </option>
                                        <option value="/karir" {{ old('Url', $menu->Url) == '/karir' ? 'selected' : '' }}>
                                            Karir</option>
                                        <option value="/kontak"
                                            {{ old('Url', $menu->Url) == '/kontak' ? 'selected' : '' }}>Kontak</option>
                                        <option value="/berita"
                                            {{ old('Url', $menu->Url) == '/berita' ? 'selected' : '' }}>Berita & Artikel
                                        </option>
                                    </select>
                                    @error('Url')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- URL Kustom -->
                                <div class="form-group mb-3" id="groupUrlKustom"
                                    style="display: {{ old('JenisLink', $menu->JenisLink) == 'custom' ? 'block' : 'none' }};">
                                    <label class="font-weight-bold text-dark mb-2">URL Kustom:</label>
                                    <input type="text"
                                        class="form-control form-control-custom @error('Url') is-invalid @enderror"
                                        id="UrlKustom" name="Url" value="{{ old('Url', $menu->Url) }}"
                                        placeholder="https://example.com atau /custom-page">
                                    @error('Url')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Route Laravel -->
                                <div class="form-group mb-0" id="groupRoute"
                                    style="display: {{ old('JenisLink', $menu->JenisLink) == 'route' ? 'block' : 'none' }};">
                                    <label class="font-weight-bold text-dark mb-2">Route Name:</label>
                                    <select
                                        class="form-control form-control-custom @error('RouteName') is-invalid @enderror"
                                        id="RouteName" name="RouteName">
                                        <option value="">-- Pilih Route --</option>
                                        @foreach ($availableRoutes as $route)
                                            <option value="{{ $route['name'] }}"
                                                {{ old('RouteName', $menu->RouteName) == $route['name'] ? 'selected' : '' }}>
                                                {{ $route['name'] }} ({{ $route['uri'] }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('RouteName')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted" style="font-size: 12px;">Pilih route Laravel yang sudah
                                        terdaftar.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: PENGATURAN LAINNYA -->
                    <div class="col-lg-4">
                        <!-- HIRARKI & URUTAN -->
                        <div class="card-modern mb-4">
                            <div class="card-header-modern">
                                <i class="fa fa-sitemap text-warning mr-2"></i> Hirarki & Urutan
                            </div>
                            <div class="card-body p-4">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-dark mb-2">Parent Menu</label>
                                    <select
                                        class="form-control form-control-custom @error('ParentId') is-invalid @enderror"
                                        id="ParentId" name="ParentId">
                                        <option value="">-- Tingkat Utama (Root) --</option>
                                        @foreach ($parentMenus as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ old('ParentId', $menu->ParentId) == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->translate('id')->NamaMenu ?? $parent->NamaMenu }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ParentId')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted" style="font-size: 12px;">Pilih parent jika ini adalah
                                        sub-menu.</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-dark mb-2">Urutan Tampil</label>
                                    <input type="number"
                                        class="form-control form-control-custom @error('Urutan') is-invalid @enderror"
                                        id="Urutan" name="Urutan" value="{{ old('Urutan', $menu->Urutan) }}"
                                        min="0" placeholder="0 = paling atas">
                                    @error('Urutan')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-0">
                                    <label class="font-weight-bold text-dark mb-2">Icon (Optional)</label>
                                    <div class="input-group">
                                        <input type="text"
                                            class="form-control form-control-custom @error('Icon') is-invalid @enderror"
                                            id="Icon" name="Icon" value="{{ old('Icon', $menu->Icon) }}"
                                            placeholder="fa fa-home">
                                        @error('Icon')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <small class="text-muted" style="font-size: 12px;">Contoh: fa fa-home, fa
                                        fa-users</small>
                                </div>
                            </div>
                        </div>

                        <!-- PENGATURAN TAMPILAN -->
                        <div class="card-modern mb-4">
                            <div class="card-header-modern">
                                <i class="fa fa-eye text-info mr-2"></i> Pengaturan Tampilan
                            </div>
                            <div class="card-body p-4">
                                <div class="form-group mb-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="StatusAktif"
                                            name="StatusAktif" value="1"
                                            {{ old('StatusAktif', $menu->StatusAktif) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="StatusAktif">Status Aktif</label>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="TampilkanDiHeader"
                                            name="TampilkanDiHeader" value="1"
                                            {{ old('TampilkanDiHeader', $menu->TampilkanDiHeader) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="TampilkanDiHeader">Tampilkan di
                                            Header</label>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="TampilkanDiFooter"
                                            name="TampilkanDiFooter" value="1"
                                            {{ old('TampilkanDiFooter', $menu->TampilkanDiFooter) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="TampilkanDiFooter">Tampilkan di
                                            Footer</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- INFO BOX -->
                        <div class="info-box">
                            <i class="fa fa-info-circle mr-1"></i>
                            <strong>Slug:</strong> <code>{{ $menu->SlugMenu }}</code><br>
                            <small>Slug dibuat otomatis dan tidak dapat diubah.</small>
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div class="d-flex">
                            <a href="{{ route('menu.index') }}" class="btn btn-custom-secondary flex-fill mr-2">
                                <i class="fa fa-times mr-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-custom-primary flex-fill">
                                <i class="fa fa-save mr-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Toggle jenis tautan
            function toggleLinkType() {
                var jenis = $('input[name="JenisLink"]:checked').val();

                $('#groupPilihHalaman').hide();
                $('#groupUrlKustom').hide();
                $('#groupRoute').hide();

                if (jenis === 'page') {
                    $('#groupPilihHalaman').show();
                } else if (jenis === 'custom') {
                    $('#groupUrlKustom').show();
                } else if (jenis === 'route') {
                    $('#groupRoute').show();
                }
            }

            // Jalankan saat halaman dimuat
            toggleLinkType();

            // Auto-switch ke tab EN jika ada error di sana
            @if ($errors->has('translations.en.*'))
                $('#tab-en-tab').tab('show');
            @endif
        });
    </script>
@endpush

@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa-edit mr-2"></i>Edit Menu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('menu.index') }}">Menu</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
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
                        <!-- KARTU NAMA MENU -->
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="mb-0"><i class="fa fa-language text-primary mr-2"></i><strong>Nama Menu
                                        (Multi-Bahasa)</strong></h5>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs mb-4" id="langTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="tab-id-tab" data-toggle="tab" href="#tab-id"
                                            role="tab">
                                            🇮🇩 Bahasa Indonesia <span class="text-danger">*</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="tab-en-tab" data-toggle="tab" href="#tab-en" role="tab">
                                            🇬 English
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="langTabsContent">
                                    <!-- TAB INDONESIA -->
                                    <div class="tab-pane fade show active" id="tab-id" role="tabpanel">
                                        <div class="form-group">
                                            <label><strong>Nama Menu</strong> <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-tag"></i></span>
                                                </div>
                                                <input type="text" name="translations[id][NamaMenu]"
                                                    class="form-control @error('translations.id.NamaMenu') is-invalid @enderror"
                                                    value="{{ old('translations.id.NamaMenu', $menu->translate('id')->NamaMenu) }}"
                                                    placeholder="Contoh: Hubungan Investor" required>
                                            </div>
                                            @error('translations.id.NamaMenu')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- TAB ENGLISH -->
                                    <div class="tab-pane fade" id="tab-en" role="tabpanel">
                                        <div class="form-group">
                                            <label><strong>Menu Name</strong></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-tag"></i></span>
                                                </div>
                                                <input type="text" name="translations[en][NamaMenu]"
                                                    class="form-control @error('translations.en.NamaMenu') is-invalid @enderror"
                                                    value="{{ old('translations.en.NamaMenu', $menu->translate('en')->NamaMenu) }}"
                                                    placeholder="e.g. Investor Relations">
                                            </div>
                                            @error('translations.en.NamaMenu')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- KARTU PENGATURAN TAUTAN -->
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="mb-0"><i class="fa fa-link text-success mr-2"></i><strong>Pengaturan
                                        Tautan</strong></h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label><strong>Jenis Tautan</strong> <span class="text-danger">*</span></label>
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
                                <div class="form-group" id="groupPilihHalaman"
                                    style="display: {{ old('JenisLink', $menu->JenisLink) == 'page' ? 'block' : 'none' }};">
                                    <label><strong>Pilih Halaman CMS:</strong></label>
                                    <select class="form-control select2 @error('Url') is-invalid @enderror" id="Url"
                                        name="Url">
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
                                <div class="form-group" id="groupUrlKustom"
                                    style="display: {{ old('JenisLink', $menu->JenisLink) == 'custom' ? 'block' : 'none' }};">
                                    <label><strong>URL Kustom:</strong></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-globe"></i></span>
                                        </div>
                                        <input type="text" class="form-control @error('Url') is-invalid @enderror"
                                            id="UrlKustom" name="Url" value="{{ old('Url', $menu->Url) }}"
                                            placeholder="https://example.com atau /custom-page">
                                    </div>
                                    @error('Url')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Route Laravel -->
                                <div class="form-group" id="groupRoute"
                                    style="display: {{ old('JenisLink', $menu->JenisLink) == 'route' ? 'block' : 'none' }};">
                                    <label><strong>Route Name:</strong></label>
                                    <select class="form-control select2-search @error('RouteName') is-invalid @enderror"
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
                                    <small class="text-muted">Pilih route Laravel yang sudah terdaftar.</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KOLOM KANAN: PENGATURAN LAINNYA -->
                    <div class="col-lg-4">
                        <!-- KARTU HIRARKI & URUTAN -->
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="mb-0"><i class="fa fa-sitemap text-warning mr-2"></i><strong>Hirarki &
                                        Urutan</strong></h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label><strong>Parent Menu</strong></label>
                                    <select class="form-control select2 @error('ParentId') is-invalid @enderror"
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
                                    <small class="text-muted">Pilih parent jika ini adalah sub-menu.</small>
                                </div>

                                <div class="form-group">
                                    <label><strong>Urutan Tampil</strong></label>
                                    <input type="number" class="form-control @error('Urutan') is-invalid @enderror"
                                        id="Urutan" name="Urutan" value="{{ old('Urutan', $menu->Urutan) }}"
                                        min="0" placeholder="0 = paling atas">
                                    @error('Urutan')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Urutan tampil (0 = paling atas)</small>
                                </div>

                                <div class="form-group mb-0">
                                    <label><strong>Icon (Optional)</strong></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-icons"></i></span>
                                        </div>
                                        <input type="text" class="form-control @error('Icon') is-invalid @enderror"
                                            id="Icon" name="Icon" value="{{ old('Icon', $menu->Icon) }}"
                                            placeholder="fa fa-home">
                                    </div>
                                    @error('Icon')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Contoh: fa fa-home, fa fa-users</small>
                                </div>
                            </div>
                        </div>

                        <!-- KARTU PENGATURAN TAMPILAN -->
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="mb-0"><i class="fa fa-eye text-info mr-2"></i><strong>Pengaturan
                                        Tampilan</strong></h5>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="StatusAktif"
                                            name="StatusAktif" value="1"
                                            {{ old('StatusAktif', $menu->StatusAktif) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="StatusAktif">Status Aktif</label>
                                    </div>
                                    <small class="text-muted d-block ml-4">Menu dapat diakses user.</small>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="TampilkanDiHeader"
                                            name="TampilkanDiHeader" value="1"
                                            {{ old('TampilkanDiHeader', $menu->TampilkanDiHeader) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="TampilkanDiHeader">Tampilkan di
                                            Header</label>
                                    </div>
                                    <small class="text-muted d-block ml-4">Muncul di navigasi utama website.</small>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="TampilkanDiFooter"
                                            name="TampilkanDiFooter" value="1"
                                            {{ old('TampilkanDiFooter', $menu->TampilkanDiFooter) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="TampilkanDiFooter">Tampilkan di
                                            Footer</label>
                                    </div>
                                    <small class="text-muted d-block ml-4">Muncul di bagian bawah website.</small>
                                </div>
                            </div>
                        </div>

                        <!-- INFO BOX SLUG -->
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle mr-1"></i>
                            <strong>Slug URL:</strong> <code>{{ $menu->SlugMenu ?? '-' }}</code><br>
                            <small>Slug dibuat otomatis dan tidak dapat diubah.</small>
                        </div>

                        <!-- TOMBOL AKSI -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('menu.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left mr-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
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
            // Inisialisasi Select2
            $('.select2, .select2-search').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

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

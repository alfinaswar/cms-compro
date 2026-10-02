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
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form action="{{ route('menu.update', $menu->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-edit mr-2"></i> Form Edit Menu</h3>
                        </div>
                        <div class="card-body">

                            <!-- TABS BAHASA -->
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
                                    <div class="form-group">
                                        <label><strong>Nama Menu</strong> <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-tag"></i></span>
                                            </div>
                                            <input type="text" name="translations[id][NamaMenu]"
                                                class="form-control @error('translations.id.NamaMenu') is-invalid @enderror"
                                                placeholder="Contoh: Tentang Kami"
                                                value="{{ old('translations.id.NamaMenu', $menu->translate('id')->NamaMenu) }}"
                                                required>
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
                                                placeholder="Example: About Us"
                                                value="{{ old('translations.en.NamaMenu', $menu->translate('en')->NamaMenu) }}">
                                        </div>
                                        @error('translations.en.NamaMenu')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">
                            <h6><strong>Data Umum (Tidak Diterjemahkan)</strong></h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ParentId"><strong>Parent Menu</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-sitemap"></i></span>
                                            </div>
                                            <select name="ParentId" id="ParentId"
                                                class="form-control select2 @error('ParentId') is-invalid @enderror">
                                                <option value="">-- Menu Utama (Tidak Ada Parent) --</option>
                                                @foreach ($parentMenus as $parent)
                                                    <option value="{{ $parent->id }}"
                                                        {{ old('ParentId', $menu->ParentId) == $parent->id ? 'selected' : '' }}>
                                                        {{ $parent->translate('id')->NamaMenu ?? $parent->NamaMenu }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('ParentId')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Icon"><strong>Icon (Optional)</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-icons"></i></span>
                                            </div>
                                            <input type="text" name="Icon" id="Icon"
                                                class="form-control @error('Icon') is-invalid @enderror"
                                                placeholder="fa fa-home" value="{{ old('Icon', $menu->Icon) }}">
                                        </div>
                                        @error('Icon')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted">Contoh: fa fa-home, fab fa-facebook</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="JenisLink"><strong>Jenis Link</strong> <span
                                                class="text-danger">*</span></label>
                                        <select name="JenisLink" id="JenisLink"
                                            class="form-control @error('JenisLink') is-invalid @enderror" required>
                                            <option value="custom"
                                                {{ old('JenisLink', $menu->JenisLink) == 'custom' ? 'selected' : '' }}>
                                                Custom URL</option>
                                            <option value="route"
                                                {{ old('JenisLink', $menu->JenisLink) == 'route' ? 'selected' : '' }}>Route
                                                Laravel</option>
                                            <option value="page"
                                                {{ old('JenisLink', $menu->JenisLink) == 'page' ? 'selected' : '' }}>
                                                Halaman Internal</option>
                                        </select>
                                        @error('JenisLink')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" id="groupUrl">
                                        <label for="Url"><strong>URL</strong></label>
                                        <input type="text" name="Url" id="Url"
                                            class="form-control @error('Url') is-invalid @enderror"
                                            placeholder="https://example.com atau /about"
                                            value="{{ old('Url', $menu->Url) }}">
                                        @error('Url')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group" id="groupRoute" style="display: none;">
                                        <label for="RouteName"><strong>Route Name</strong></label>
                                        <select name="RouteName" id="RouteName"
                                            class="form-control select2-search @error('RouteName') is-invalid @enderror">
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
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Target"><strong>Target</strong></label>
                                        <select name="Target" id="Target"
                                            class="form-control @error('Target') is-invalid @enderror">
                                            <option value="_self"
                                                {{ old('Target', $menu->Target ?? '_self') == '_self' ? 'selected' : '' }}>
                                                Tab Sama (_self)</option>
                                            <option value="_blank"
                                                {{ old('Target', $menu->Target) == '_blank' ? 'selected' : '' }}>Tab Baru
                                                (_blank)</option>
                                        </select>
                                        @error('Target')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Urutan"><strong>Urutan</strong></label>
                                        <input type="number" name="Urutan" id="Urutan"
                                            class="form-control @error('Urutan') is-invalid @enderror"
                                            placeholder="Kosongkan untuk auto"
                                            value="{{ old('Urutan', $menu->Urutan) }}">
                                        @error('Urutan')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Slug URL</strong></label>
                                        <input type="text" class="form-control bg-light"
                                            value="{{ $menu->SlugMenu }}" readonly>
                                        <small class="text-muted">Slug dibuat otomatis dan tidak dapat diubah.</small>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <h6><strong>Pengaturan Tampilan</strong></h6>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="StatusAktif"
                                            name="StatusAktif" value="1"
                                            {{ old('StatusAktif', $menu->StatusAktif) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="StatusAktif">Status Aktif</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="TampilkanDiHeader"
                                            name="TampilkanDiHeader" value="1"
                                            {{ old('TampilkanDiHeader', $menu->TampilkanDiHeader) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="TampilkanDiHeader">Tampilkan di
                                            Header</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
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
                        <div class="card-footer d-flex justify-content-end">
                            <a href="{{ route('menu.index') }}" class="btn btn-secondary mr-2">
                                <i class="fa fa-times mr-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
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
            $('#JenisLink').change(function() {
                var jenis = $(this).val();
                if (jenis === 'route') {
                    $('#groupUrl').hide();
                    $('#groupRoute').show();
                } else {
                    $('#groupUrl').show();
                    $('#groupRoute').hide();
                }
            }).trigger('change'); // Penting: trigger change agar sesuai dengan data lama saat halaman dimuat

            // Auto switch ke tab EN jika ada error validasi di sana
            @if ($errors->has('translations.en.*'))
                $('#tab-en-tab').tab('show');
            @endif
        });
    </script>
@endpush

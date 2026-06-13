@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Menu</h1>
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
                            <h3 class="card-title">
                                <i class="fa fa-edit mr-2"></i> Form Edit Menu
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="NamaMenu"><strong>Nama Menu</strong> <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-tag"></i></span>
                                            </div>
                                            <input type="text" name="NamaMenu" id="NamaMenu"
                                                class="form-control @error('NamaMenu') is-invalid @enderror"
                                                placeholder="Contoh: About Us"
                                                value="{{ old('NamaMenu', $menu->NamaMenu) }}" required>
                                        </div>
                                        @error('NamaMenu')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ParentId"><strong>Parent Menu</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-sitemap"></i></span>
                                            </div>
                                            <select name="ParentId" id="ParentId" class="form-control select2">
                                                <option value="">-- Menu Utama (Tidak Ada Parent) --</option>
                                                @foreach ($parentMenus as $parent)
                                                    <option value="{{ $parent->id }}"
                                                        {{ old('ParentId', $menu->ParentId) == $parent->id ? 'selected' : '' }}>
                                                        {{ $parent->NamaMenu }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <small class="text-muted">Pilih parent jika ini adalah sub-menu</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="JenisLink"><strong>Jenis Link</strong> <span
                                                class="text-danger">*</span></label>
                                        <select name="JenisLink" id="JenisLink" class="form-control" required>
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
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group" id="groupUrl">
                                        <label for="Url"><strong>URL</strong></label>
                                        <input type="text" name="Url" id="Url" class="form-control"
                                            placeholder="https://example.com atau /about"
                                            value="{{ old('Url', $menu->Url) }}">
                                    </div>
                                    <div class="form-group" id="groupRoute" style="display: none;">
                                        <label for="RouteName"><strong>Route Name</strong></label>
                                        <select name="RouteName" id="RouteName" class="form-control select2-search">
                                            <option value="">-- Pilih Route --</option>
                                            @foreach ($availableRoutes as $route)
                                                <option value="{{ $route['name'] }}"
                                                    {{ old('RouteName', $menu->RouteName) == $route['name'] ? 'selected' : '' }}>
                                                    {{ $route['name'] }} ({{ $route['uri'] }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Target"><strong>Target</strong></label>
                                        <select name="Target" id="Target" class="form-control">
                                            <option value="_self"
                                                {{ old('Target', $menu->Target) == '_self' ? 'selected' : '' }}>Tab Sama
                                                (_self)</option>
                                            <option value="_blank"
                                                {{ old('Target', $menu->Target) == '_blank' ? 'selected' : '' }}>Tab Baru
                                                (_blank)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Icon"><strong>Icon (Optional)</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-icons"></i></span>
                                            </div>
                                            <input type="text" name="Icon" id="Icon" class="form-control"
                                                placeholder="fa fa-home" value="{{ old('Icon', $menu->Icon) }}">
                                        </div>
                                        <small class="text-muted">Contoh: fa fa-home, fab fa-facebook</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Urutan"><strong>Urutan</strong></label>
                                        <input type="number" name="Urutan" id="Urutan" class="form-control"
                                            placeholder="Kosongkan untuk auto"
                                            value="{{ old('Urutan', $menu->Urutan) }}">
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
                                <i class="fa fa-save mr-1"></i> Update Menu
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
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });
            $('.select2-search').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            function toggleJenisLink() {
                var jenis = $('#JenisLink').val();
                if (jenis === 'route') {
                    $('#groupUrl').hide();
                    $('#groupRoute').show();
                } else {
                    $('#groupUrl').show();
                    $('#groupRoute').hide();
                }
            }
            toggleJenisLink();
            $('#JenisLink').change(function() {
                toggleJenisLink();
            });
        });
    </script>
@endpush

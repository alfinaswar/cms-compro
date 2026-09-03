@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Edit Logo</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('client-logo.index') }}">Client Logos</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form action="{{ route('client-logo.update', $logo->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="card card-outline card-warning shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-edit mr-2"></i>Edit Logo: {{ $logo->NamaPartner }}</h3>
                        </div>
                        <div class="card-body">

                            {{-- Nama Partner --}}
                            <div class="form-group">
                                <label for="NamaPartner"><strong>Nama Partner / Sertifikasi</strong> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-building"></i></span></div>
                                    <input type="text" name="NamaPartner" id="NamaPartner"
                                           class="form-control @error('NamaPartner') is-invalid @enderror"
                                           placeholder="Contoh: PT Jasuindo, ISO 9001, Google Partner"
                                           value="{{ old('NamaPartner', $logo->NamaPartner) }}" required autofocus>
                                </div>
                                @error('NamaPartner') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Tipe & Urutan --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Tipe"><strong>Tipe Logo</strong> <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tag"></i></span></div>
                                            <select name="Tipe" id="Tipe" class="form-control @error('Tipe') is-invalid @enderror" required>
                                                <option value="Partner" {{ old('Tipe', $logo->Tipe) == 'Partner' ? 'selected' : '' }}>🤝 Partner / Klien</option>
                                                <option value="Sertifikasi" {{ old('Tipe', $logo->Tipe) == 'Sertifikasi' ? 'selected' : '' }}>🏆 Sertifikasi / Penghargaan</option>
                                            </select>
                                        </div>
                                        @error('Tipe') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Urutan"><strong>Urutan Tampil</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-sort-numeric-down"></i></span></div>
                                            <input type="number" name="Urutan" id="Urutan"
                                                   class="form-control @error('Urutan') is-invalid @enderror"
                                                   value="{{ old('Urutan', $logo->Urutan) }}" min="0">
                                        </div>
                                        @error('Urutan') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                        <small class="text-muted">Semakin kecil angka, semakin kiri/atas posisinya.</small>
                                    </div>
                                </div>
                            </div>

                            {{-- Upload Logo --}}
                            <div class="form-group">
                                <label for="PathLogo"><strong>Upload File Logo</strong> <small class="text-muted">(Kosongkan jika tidak ingin mengganti)</small></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-upload"></i></span></div>
                                    <div class="custom-file">
                                        <input type="file" name="PathLogo" id="PathLogo"
                                               class="custom-file-input @error('PathLogo') is-invalid @enderror"
                                               accept="image/*" onchange="previewImage(this, 'previewLogo')">
                                        <label class="custom-file-label" for="PathLogo">Pilih file logo baru...</label>
                                    </div>
                                </div>
                                @error('PathLogo') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror

                                {{-- Preview Logo Lama --}}
                                @if($logo->PathLogo)
                                    <div class="mt-3 text-center">
                                        <small class="text-muted d-block mb-2">Logo saat ini:</small>
                                        <img id="previewLogo" src="{{ Storage::url($logo->PathLogo) }}"
                                             class="img-fluid rounded" style="max-height: 120px; border: 1px solid #ddd; background: #f8f9fa; padding: 10px;">
                                        <small class="text-muted d-block mt-2"><i class="fa fa-info-circle"></i> Upload file baru untuk mengganti.</small>
                                    </div>
                                @else
                                    <div class="mt-3 text-center" id="containerPreview" style="display: none;">
                                        <small class="text-muted d-block mb-2">Preview:</small>
                                        <img id="previewLogo" src="#" class="img-fluid rounded" style="max-height: 120px; border: 1px solid #ddd; background: #f8f9fa; padding: 10px;">
                                    </div>
                                @endif
                                <small class="text-muted"><i class="fa fa-info-circle"></i> Format: JPG, PNG, SVG, WebP. Maks 2MB.</small>
                            </div>

                            {{-- Website URL --}}
                            <div class="form-group">
                                <label for="UrlWebsite"><strong>Website Partner</strong> <small class="text-muted">(Opsional)</small></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-globe"></i></span></div>
                                    <input type="url" name="UrlWebsite" id="UrlWebsite"
                                           class="form-control @error('UrlWebsite') is-invalid @enderror"
                                           placeholder="https://example.com"
                                           value="{{ old('UrlWebsite', $logo->UrlWebsite) }}">
                                </div>
                                @error('UrlWebsite') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Status --}}
                            <div class="form-group">
                                <label for="Status"><strong>Status Tampil</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-toggle-on"></i></span></div>
                                    <select name="Status" id="Status" class="form-control">
                                        <option value="Aktif" {{ old('Status', $logo->Status) == 'Aktif' ? 'selected' : '' }}>✅ Aktif (Tampil di Website)</option>
                                        <option value="Nonaktif" {{ old('Status', $logo->Status) == 'Nonaktif' ? 'selected' : '' }}>❌ Nonaktif (Sembunyikan)</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Audit Info --}}
                            <div class="alert alert-info mt-4 mb-0 d-flex justify-content-between">
                                <small><i class="fa fa-user mr-1"></i> Dibuat oleh: <strong>{{ $logo->UserCreate ?? '-' }}</strong></small>
                                @if($logo->UserUpdate)
                                    <small><i class="fa fa-edit mr-1"></i> Terakhir diupdate: <strong>{{ $logo->UserUpdate }}</strong></small>
                                @endif
                            </div>

                        </div>
                        <div class="card-footer d-flex justify-content-end gap-3">
                            <a href="{{ route('client-logo.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-save mr-2"></i>Update Logo
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
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result);
                    if ($('#containerPreview').length) $('#containerPreview').show();
                }
                reader.readAsDataURL(input.files[0]);
                $(input).next('.custom-file-label').text(input.files[0].name);
            }
        }
        $('#PathLogo').on('change', function() {
            if (this.files.length === 0) {
                $(this).next('.custom-file-label').text('Pilih file logo baru...');
            }
        });
    </script>
@endpush

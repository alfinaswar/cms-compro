@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Tambah Detail Penghargaan</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('client-logo.index') }}">Client Logos</a></li>
                        <li class="breadcrumb-item active">Tambah Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form action="{{ route('client-logo.store-detail') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- IdClientLogo, hidden --}}
                    <input type="hidden" name="IdClientLogo" value="{{ $idClient ?? old('IdClientLogo') }}">
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-certificate mr-2"></i>Tambah Detail Penghargaan</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    {{-- SubJudul --}}
                                    <div class="form-group">
                                        <label for="SubJudul"><strong>Sub Judul</strong></label>
                                        <input type="text" name="SubJudul" id="SubJudul"
                                               class="form-control @error('SubJudul') is-invalid @enderror"
                                               placeholder="Sub judul penghargaan (opsional)"
                                               value="{{ old('SubJudul') }}">
                                        @error('SubJudul') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Judul --}}
                                    <div class="form-group">
                                        <label for="Judul"><strong>Judul <span class="text-danger">*</span></strong></label>
                                        <input type="text" name="Judul" id="Judul"
                                               class="form-control @error('Judul') is-invalid @enderror"
                                               placeholder="Nama penghargaan atau partner"
                                               value="{{ old('Judul') }}" required>
                                        @error('Judul') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Deskripsi --}}
                                    <div class="form-group">
                                        <label for="Deskripsi"><strong>Deskripsi</strong></label>
                                        <textarea name="Deskripsi" id="Deskripsi"
                                                  class="form-control @error('Deskripsi') is-invalid @enderror"
                                                  placeholder="Deskripsi singkat penghargaan (opsional)"
                                                  rows="2">{{ old('Deskripsi') }}</textarea>
                                        @error('Deskripsi') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Website URL --}}
                                    <div class="form-group">
                                        <label for="UrlWebsite"><strong>Website Partner</strong> <small class="text-muted">(Opsional)</small></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-globe"></i></span></div>
                                            <input type="url" name="UrlWebsite" id="UrlWebsite"
                                                class="form-control @error('UrlWebsite') is-invalid @enderror"
                                                placeholder="https://example.com"
                                                value="{{ old('UrlWebsite') }}">
                                        </div>
                                        @error('UrlWebsite') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                        <small class="text-muted">Jika diisi, logo akan menjadi link clickable di frontend.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    {{-- Upload Logo --}}
                                    <div class="form-group">
                                        <label for="PathLogo"><strong>Upload File Logo</strong> <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-upload"></i></span></div>
                                            <div class="custom-file">
                                                <input type="file" name="PathLogo" id="PathLogo"
                                                    class="custom-file-input @error('PathLogo') is-invalid @enderror"
                                                    accept="image/*" onchange="previewImage(this, 'previewLogo')">
                                                <label class="custom-file-label" for="PathLogo">Pilih file logo...</label>
                                            </div>
                                        </div>
                                        @error('PathLogo') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror

                                        <div class="mt-3 text-center" id="containerPreview" style="display: none;">
                                            <small class="text-muted d-block mb-2">Preview:</small>
                                            <img id="previewLogo" src="#" class="img-fluid rounded" style="max-height: 120px; border: 1px solid #ddd; background: #f8f9fa; padding: 10px;">
                                        </div>
                                        <small class="text-muted"><i class="fa fa-info-circle"></i> Format: JPG, PNG, SVG, WebP. Maks 2MB. Disarankan background transparan.</small>
                                    </div>

                                    {{-- Urutan --}}
                                    <div class="form-group">
                                        <label for="Urutan"><strong>Urutan Tampil</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-sort-numeric-down"></i></span></div>
                                            <input type="number" name="Urutan" id="Urutan"
                                                class="form-control @error('Urutan') is-invalid @enderror"
                                                value="{{ old('Urutan', 0) }}" min="0">
                                        </div>
                                        @error('Urutan') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                        <small class="text-muted">Semakin kecil angka, semakin kiri/atas posisinya.</small>
                                    </div>

                                    {{-- Status --}}
                                    <div class="form-group">
                                        <label for="Status"><strong>Status Tampil</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-toggle-on"></i></span></div>
                                            <select name="Status" id="Status" class="form-control">
                                                <option value="Aktif" {{ old('Status') == 'Aktif' ? 'selected' : '' }}>✅ Aktif (Tampil di Website)</option>
                                                <option value="Nonaktif" {{ old('Status') == 'Nonaktif' ? 'selected' : '' }}>❌ Nonaktif (Sembunyikan)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end gap-3">
                            <a href="{{ route('client-logo.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-2"></i>Simpan Detail
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
        // Preview Gambar Logo
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result);
                    $('#containerPreview').show();
                }
                reader.readAsDataURL(input.files[0]);
                $(input).next('.custom-file-label').text(input.files[0].name);
            }
        }
        $('#PathLogo').on('change', function() {
            if (this.files.length === 0) {
                $(this).next('.custom-file-label').text('Pilih file logo...');
            }
        });
    </script>
@endpush

@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Struktur Organisasi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('struktur-organisasi.index') }}">Struktur
                                Organisasi</a></li>
                        <li class="breadcrumb-item active">Edit Section</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form action="{{ route('struktur-organisasi.update', $section->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa fa-edit mr-2"></i>Edit Section: {{ $section->JudulSection }}
                            </h3>
                        </div>
                        <div class="card-body">

                            {{-- Judul Section --}}
                            <div class="form-group">
                                <label for="JudulSection"><strong>Judul Section</strong> <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-heading"></i></span>
                                    </div>
                                    <input type="text" name="JudulSection" id="JudulSection"
                                        class="form-control @error('JudulSection') is-invalid @enderror"
                                        placeholder="Contoh: Dewan Direksi, Manajemen, Tim Operasional"
                                        value="{{ old('JudulSection', $section->JudulSection) }}" required autofocus>
                                </div>
                                @error('JudulSection')
                                    <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                                <small class="text-muted"><i class="fa fa-info-circle"></i> Judul akan ditampilkan sebagai
                                    header section.</small>
                            </div>

                            {{-- Gambar Header --}}
                            <div class="form-group">
                                <label for="PathGambarHeader"><strong>Gambar Header Section</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-image"></i></span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="PathGambarHeader" id="PathGambarHeader"
                                            class="custom-file-input @error('PathGambarHeader') is-invalid @enderror"
                                            accept="image/*" onchange="previewImage(this, 'previewHeader')">
                                        <label class="custom-file-label" for="PathGambarHeader">Pilih gambar...</label>
                                    </div>
                                </div>
                                @error('PathGambarHeader')
                                    <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror

                                {{-- Preview Gambar Lama --}}
                                @if ($section->PathGambarHeader)
                                    <div class="mt-3 text-center">
                                        <small class="text-muted d-block mb-2">Gambar saat ini:</small>
                                        <img id="previewHeader" src="{{ Storage::url($section->PathGambarHeader) }}"
                                            class="img-fluid rounded" style="max-height: 150px; border: 1px solid #ddd;">
                                        <small class="text-muted d-block mt-2"><i class="fa fa-info-circle"></i> Upload
                                            gambar baru untuk mengganti.</small>
                                    </div>
                                @else
                                    <div class="mt-3 text-center" id="containerPreviewHeader" style="display: none;">
                                        <small class="text-muted d-block mb-2">Preview:</small>
                                        <img id="previewHeader" src="#" class="img-fluid rounded"
                                            style="max-height: 150px; border: 1px solid #ddd;">
                                    </div>
                                @endif

                                <small class="text-muted"><i class="fa fa-info-circle"></i> Ukuran maks 2MB. Disarankan
                                    rasio 16:9 atau 4:3.</small>
                            </div>

                            {{-- Deskripsi Section --}}
                            <div class="form-group">
                                <label for="DeskripsiSection"><strong>Deskripsi Section</strong></label>
                                <textarea name="DeskripsiSection" id="DeskripsiSection"
                                    class="form-control @error('DeskripsiSection') is-invalid @enderror" rows="4"
                                    placeholder="Jelaskan secara singkat tentang section ini...">{{ old('DeskripsiSection', $section->DeskripsiSection) }}</textarea>
                                @error('DeskripsiSection')
                                    <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                                <small class="text-muted"><i class="fa fa-info-circle"></i> Deskripsi akan muncul di bawah
                                    judul section.</small>
                            </div>

                            {{-- Urutan & Status --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Urutan"><strong>Urutan Tampil</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i
                                                        class="fa fa-sort-numeric-down"></i></span>
                                            </div>
                                            <input type="number" name="Urutan" id="Urutan"
                                                class="form-control @error('Urutan') is-invalid @enderror"
                                                value="{{ old('Urutan', $section->Urutan) }}" min="0">
                                        </div>
                                        @error('Urutan')
                                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted">Semakin kecil angka, semakin atas posisinya.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Status"><strong>Status Section</strong> <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-toggle-on"></i></span>
                                            </div>
                                            <select name="Status" id="Status"
                                                class="form-control @error('Status') is-invalid @enderror" required>
                                                <option value="Aktif"
                                                    {{ old('Status', $section->Status) == 'Aktif' ? 'selected' : '' }}>✅
                                                    Aktif (Tampil di Website)</option>
                                                <option value="Nonaktif"
                                                    {{ old('Status', $section->Status) == 'Nonaktif' ? 'selected' : '' }}>❌
                                                    Nonaktif (Sembunyikan)</option>
                                            </select>
                                        </div>
                                        @error('Status')
                                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Audit Info --}}
                            <div class="alert alert-info mt-4 mb-0 d-flex justify-content-between">
                                <small><i class="fa fa-user mr-1"></i> Dibuat oleh:
                                    <strong>{{ $section->UserCreate ?? '-' }}</strong></small>
                                @if ($section->UserUpdate)
                                    <small><i class="fa fa-edit mr-1"></i> Terakhir diupdate:
                                        <strong>{{ $section->UserUpdate }}</strong></small>
                                @endif
                            </div>

                        </div>
                        <div class="card-footer d-flex justify-content-end gap-3">
                            <a href="{{ route('struktur-organisasi.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-2"></i>Update Section
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
        // Preview Gambar Header
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + previewId).attr('src', e.target.result);
                    // Tampilkan container preview jika sebelumnya hidden
                    if ($('#containerPreviewHeader').length) {
                        $('#containerPreviewHeader').show();
                    }
                }
                reader.readAsDataURL(input.files[0]);

                // Update label custom file input
                var fileName = input.files[0].name;
                $(input).next('.custom-file-label').text(fileName);
            }
        }

        // Reset label saat file dibatalkan
        $('#PathGambarHeader').on('change', function() {
            if (this.files.length === 0) {
                $(this).next('.custom-file-label').text('Pilih gambar...');
            }
        });
    </script>
@endpush

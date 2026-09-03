@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            .invalid-feedback { animation: fadeIn .3s ease-in-out; }
            @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
            .custom-file-label::after { content: "Browse"; }
            .preview-img { max-height: 120px; object-fit: contain; border: 1px dashed #ccc; padding: 5px; border-radius: 4px; }
        </style>
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Tambah Why Choose Us</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('why-choose-us.index') }}">Why Choose Us</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-10">
                <form action="{{ route('why-choose-us.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h3 class="card-title mb-0"><i class="fa fa-plus text-primary mr-2"></i><strong>Form Keunggulan</strong></h3>
                        </div>
                        <div class="card-body">

                            {{-- UPLOAD ICON --}}
                            <div class="form-group">
                                <label><strong>Upload Icon / Gambar</strong> <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="Icon" class="custom-file-input @error('Icon') is-invalid @enderror" id="Icon" accept="image/*" required>
                                    <label class="custom-file-label" for="Icon" placeholder="Pilih file gambar...">Pilih file gambar...</label>
                                </div>
                                @error('Icon') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                <small class="text-muted">Format: PNG, JPG, JPEG, SVG, WEBP. Maksimal 2MB.</small>
                                <div id="previewIcon" class="mt-2" style="display:none;">
                                    <img src="" class="preview-img" alt="Preview Icon">
                                </div>
                            </div>

                            <div class="form-group">
                                <label><strong>Judul</strong> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-heading"></i></span></div>
                                    <input type="text" name="Judul" class="form-control @error('Judul') is-invalid @enderror" value="{{ old('Judul') }}" required placeholder="Masukkan judul keunggulan">
                                    @error('Judul') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label><strong>Deskripsi</strong> <span class="text-danger">*</span></label>
                                <textarea name="Deskripsi" rows="4" class="form-control @error('Deskripsi') is-invalid @enderror" required placeholder="Masukkan deskripsi keunggulan">{{ old('Deskripsi') }}</textarea>
                                @error('Deskripsi') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Urutan Tampil</strong></label>
                                        <input type="number" name="Urutan" class="form-control @error('Urutan') is-invalid @enderror" value="{{ old('Urutan', 1) }}" min="1" placeholder="Masukkan urutan tampil">
                                        @error('Urutan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Status</strong> <span class="text-danger">*</span></label>
                                        <select name="Status" class="form-control @error('Status') is-invalid @enderror" required>
                                            <option value="1" {{ old('Status', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ old('Status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                        @error('Status') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top d-flex justify-content-end">
                            <a href="{{ route('why-choose-us.index') }}" class="btn btn-light border px-4 mr-2"><i class="fa fa-arrow-left mr-1"></i> Kembali</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="fa fa-save mr-1"></i> Simpan</button>
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
        // Custom file label & preview
        $('#Icon').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).siblings('.custom-file-label').addClass('selected').html(fileName);

            // Preview image
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewIcon img').attr('src', e.target.result);
                    $('#previewIcon').show();
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endpush

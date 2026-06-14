@extends('layouts.app')

@section('content')
    @push('styles')
        <!-- summernote -->
        <link rel="stylesheet" href="{{ asset('') }}assets/plugins/summernote/summernote-bs4.css">
    @endpush
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Buat Value Perusahaan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('value-perusahaan.index') }}">Value Perusahaan</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <form action="{{ route('value-perusahaan.store') }}" method="POST" enctype="multipart/form-data"
            id="formValuePerusahaan">
            @csrf
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-star text-primary mr-2"></i><strong>Form Value
                                    Perusahaan</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="Judul"><strong>Judul</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="Judul" id="Judul"
                                    class="form-control @error('Judul') is-invalid @enderror"
                                    placeholder="Tulis judul value perusahaan..." value="{{ old('Judul') }}" required
                                    autofocus>
                                @error('Judul')
                                    <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Judul value perusahaan.</small>
                            </div>
                            <div class="form-group">
                                <label for="Keterangan"><strong>Keterangan</strong></label>
                                <textarea name="Keterangan" id="summernote" class="form-control @error('Keterangan') is-invalid @enderror"
                                    rows="8">{{ old('Keterangan') }}</textarea>
                                @error('Keterangan')
                                    <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Keterangan lengkap value perusahaan.</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="{{ route('value-perusahaan.index') }}" class="btn btn-secondary px-4">
                                    <i class="fa fa-arrow-left mr-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fa fa-save mr-1"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Summernote
            $('#summernote').summernote({
                height: 350,
                placeholder: 'Tulis keterangan value perusahaan di sini...',
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        });
    </script>
@endpush

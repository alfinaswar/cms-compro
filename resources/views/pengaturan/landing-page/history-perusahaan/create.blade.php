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
                    <h1>Buat History Perusahaan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('history-perusahaan.index') }}">History Perusahaan</a>
                        </li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <form action="{{ route('history-perusahaan.store') }}" method="POST" enctype="multipart/form-data"
            id="formHistoryPerusahaan">
            @csrf
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-history text-primary mr-2"></i><strong>Form History
                                    Perusahaan</strong></h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="Judul"><strong>Judul</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="Judul" id="Judul"
                                    class="form-control @error('Judul') is-invalid @enderror"
                                    placeholder="Tulis judul sejarah..." value="{{ old('Judul') }}" required autofocus>
                                @error('Judul')
                                    <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Judul history perusahaan.</small>
                            </div>
                            <div class="form-group">
                                <label for="Deskripsi"><strong>Deskripsi</strong></label>
                                <textarea name="Deskripsi" id="summernote" class="form-control @error('Deskripsi') is-invalid @enderror" rows="8">{{ old('Deskripsi') }}</textarea>
                                @error('Deskripsi')
                                    <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Deskripsi lengkap history perusahaan.</small>
                            </div>
                            <div class="form-group">
                                <label for="Tahun"><strong>Tahun</strong> <span class="text-danger">*</span></label>
                                <input type="number" name="Tahun" id="Tahun"
                                    class="form-control @error('Tahun') is-invalid @enderror"
                                    placeholder="Masukkan tahun..." value="{{ old('Tahun') }}" required min="1900"
                                    max="2100">
                                @error('Tahun')
                                    <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Tahun peristiwa/kejadian history perusahaan.</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="{{ route('history-perusahaan.index') }}" class="btn btn-secondary px-4">
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
                placeholder: 'Tulis deskripsi history perusahaan di sini...',
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

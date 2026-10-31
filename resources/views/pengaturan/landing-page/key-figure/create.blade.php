@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Key Figure</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pengaturan-key-figure.index') }}">Key Figures</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form action="{{ route('pengaturan-key-figure.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa fa-plus mr-2"></i> Form Tambah Key Figure
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="Icon"><strong>Icon (Upload Gambar/Optional)</strong></label>
                                <input type="file" name="Icon" id="Icon"
                                    class="form-control-file @error('Icon') is-invalid @enderror" accept="image/*">
                                @error('Icon')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Upload gambar icon untuk menampilkan icon di atas angka/key figure
                                    (Opsional).</small>
                            </div>

                            {{-- KONTEN MULTI BAHASA --}}
                            <ul class="nav nav-tabs mb-3" id="keyFigureLangTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-id" data-toggle="tab" href="#panel-id" role="tab">
                                        🇮🇩 Bahasa Indonesia
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-en" data-toggle="tab" href="#panel-en" role="tab">
                                        🇬🇧 English
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content" id="keyFigureLangTabContent">
                                {{-- PANEL BAHASA INDONESIA --}}
                                <div class="tab-pane fade show active" id="panel-id" role="tabpanel">
                                    <div class="form-group">
                                        <label for="Konten"><strong>Angka</strong> <span class="text-danger">*</span></label>
                                        <input type="number" name="Konten" id="Konten"
                                            class="form-control @error('Konten') is-invalid @enderror" placeholder="contoh: 1000"
                                            value="{{ old('Konten') }}" required>
                                        @error('Konten')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="Keterangan"><strong>Deskripsi</strong> <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="Keterangan" id="Keterangan"
                                            class="form-control @error('Keterangan') is-invalid @enderror"
                                            placeholder="contoh: Pelanggan Puas" value="{{ old('Keterangan') }}" required>
                                        @error('Keterangan')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- PANEL ENGLISH --}}
                                <div class="tab-pane fade" id="panel-en" role="tabpanel">
                                    <div class="alert alert-info py-2" style="font-size: 13px;">
                                        <i class="fa fa-info-circle mr-1"></i>
                                        Isi kolom English agar konten otomatis tampil saat frontend menggunakan bahasa Inggris.
                                        Jika kosong, sistem akan menampilkan teks Bahasa Indonesia (fallback).
                                    </div>
                                    <div class="form-group">
                                        <label for="KontenEn"><strong>Number (English)</strong></label>
                                        <input type="number" name="KontenEn" id="KontenEn"
                                            class="form-control @error('KontenEn') is-invalid @enderror"
                                            placeholder="e.g. 1000" value="{{ old('KontenEn') }}">
                                        @error('KontenEn')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="KeteranganEn"><strong>Description (English)</strong></label>
                                        <input type="text" name="KeteranganEn" id="KeteranganEn"
                                            class="form-control @error('KeteranganEn') is-invalid @enderror"
                                            placeholder="e.g. Satisfied Customers" value="{{ old('KeteranganEn') }}">
                                        @error('KeteranganEn')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <a href="{{ route('pengaturan-key-figure.index') }}" class="btn btn-secondary mr-2">
                                <i class="fa fa-times mr-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-1"></i> Simpan Key Figure
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
            // Auto-sync: jika user mengetik angka/deskripsi Indonesia, kolom English ikut terisi
            // (mempercepat input; admin bisa menggantinya dengan terjemahan). Jika kolom EN dikosongkan
            // saat submit, controller tetap fallback ke Bahasa Indonesia.
            $('#Konten').on('input', function() {
                var en = $('#KontenEn');
                if (!en.data('touched')) en.val($(this).val());
            });
            $('#KontenEn').on('input', function() {
                $(this).data('touched', $(this).val() !== '');
            });
            $('#Keterangan').on('input', function() {
                var en = $('#KeteranganEn');
                if (!en.data('touched')) en.val($(this).val());
            });
            $('#KeteranganEn').on('input', function() {
                $(this).data('touched', $(this).val() !== '');
            });

            // Tandai tab English bila ada error validasi di dalamnya
            @if ($errors->has('KontenEn') || $errors->has('KeteranganEn'))
                $('#tab-en').tab('show');
            @endif
        });
    </script>
@endpush

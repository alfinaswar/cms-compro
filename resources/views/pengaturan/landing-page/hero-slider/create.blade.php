@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tambah Hero Slider</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('hero-slider.index') }}">Hero Slider</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form action="{{ route('hero-slider.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa fa-plus mr-2"></i> Form Tambah Hero Slider
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="SubJudul"><strong>Sub Judul</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="SubJudul" id="SubJudul"
                                    class="form-control @error('SubJudul') is-invalid @enderror"
                                    placeholder="contoh: Selamat Datang di Situs Kami" value="{{ old('SubJudul') }}"
                                    required>
                                @error('SubJudul')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="JudulUtama"><strong>Judul Utama</strong> <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="JudulUtama" id="JudulUtama"
                                    class="form-control @error('JudulUtama') is-invalid @enderror"
                                    placeholder="contoh: Dapatkan Solusi Terbaik" value="{{ old('JudulUtama') }}" required>
                                @error('JudulUtama')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="GambarLatar"><strong>Gambar Latar</strong> <span
                                        class="text-danger">*</span></label>
                                <input type="file" name="GambarLatar" id="GambarLatar"
                                    class="form-control-file @error('GambarLatar') is-invalid @enderror" accept="image/*"
                                    required>
                                @error('GambarLatar')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Upload gambar latar untuk hero slider</small>
                            </div>
                            <div class="form-group">
                                <label for="GambarBentuk"><strong>Gambar Bentuk (Opsional)</strong></label>
                                <input type="file" name="GambarBentuk" id="GambarBentuk"
                                    class="form-control-file @error('GambarBentuk') is-invalid @enderror" accept="image/*">
                                @error('GambarBentuk')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Upload gambar bentuk opsional untuk dekorasi slider</small>
                            </div>

                            <div class="form-group">
                                <label for="Status"><strong>Status</strong> <span class="text-danger">*</span></label>
                                <select name="Status" id="Status"
                                    class="form-control @error('Status') is-invalid @enderror" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="1" {{ old('Status') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('Status') == '0' ? 'selected' : '' }}>Tidak Aktif
                                    </option>
                                </select>
                                @error('Status')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <a href="{{ route('hero-slider.index') }}" class="btn btn-secondary mr-2">
                                <i class="fa fa-times mr-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-1"></i> Simpan Hero Slider
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
            // Jika ingin menambah interaksi javascript khusus Hero Slider silakan tambahkan di sini
        });
    </script>
@endpush

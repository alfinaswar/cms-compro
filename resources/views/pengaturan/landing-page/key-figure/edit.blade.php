@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Key Figure</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pengaturan-key-figure.index') }}">Key Figures</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form action="{{ route('pengaturan-key-figure.update', $keyFigure->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa fa-edit mr-2"></i> Form Edit Key Figure
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

                                @if ($keyFigure->Icon)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $keyFigure->Icon) }}" alt="Current Icon"
                                            style="height:60px;max-width:80px;object-fit:contain;">
                                        <p class="text-muted mb-0">Icon Saat Ini</p>
                                    </div>
                                @endif

                                <small class="text-muted">Upload gambar icon untuk menampilkan icon di atas angka/key figure
                                    (Opsional). Biarkan kosong jika tidak ingin mengganti.</small>
                            </div>
                            <div class="form-group">
                                <label for="Konten"><strong>Angka</strong> <span class="text-danger">*</span></label>
                                <input type="number" name="Konten" id="Konten"
                                    class="form-control @error('Konten') is-invalid @enderror" placeholder="contoh: 1000"
                                    value="{{ old('Konten', $keyFigure->Konten) }}" required>
                                @error('Konten')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="Keterangan"><strong>Deskripsi</strong> <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="Keterangan" id="Keterangan"
                                    class="form-control @error('Keterangan') is-invalid @enderror"
                                    placeholder="contoh: Pelanggan Puas"
                                    value="{{ old('Keterangan', $keyFigure->Keterangan) }}" required>
                                @error('Keterangan')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <a href="{{ route('pengaturan-key-figure.index') }}" class="btn btn-secondary mr-2">
                                <i class="fa fa-times mr-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-1"></i> Update Key Figure
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
            // Jika ingin menambah interaksi javascript khusus Key Figure silakan tambahkan di sini
        });
    </script>
@endpush

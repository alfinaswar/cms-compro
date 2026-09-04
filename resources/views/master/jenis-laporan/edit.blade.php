@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Edit Jenis Laporan</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('jenis-laporan.index') }}">Jenis Laporan</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="{{ route('jenis-laporan.update', $jenis->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="card card-outline card-warning shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-edit mr-2"></i>Edit: {{ $jenis->NamaJenis }}</h3>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label><strong>Nama Jenis Laporan</strong> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tag"></i></span></div>
                                    <input type="text" name="NamaJenis" class="form-control @error('NamaJenis') is-invalid @enderror"
                                           value="{{ old('NamaJenis', $jenis->NamaJenis) }}" required>
                                </div>
                                @error('NamaJenis') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label><strong>Deskripsi</strong></label>
                                <textarea name="Deskripsi" class="form-control @error('Deskripsi') is-invalid @enderror" rows="3">{{ old('Deskripsi', $jenis->Deskripsi) }}</textarea>
                                @error('Deskripsi') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Icon Kategori</strong> <span class="text-danger">*</span></label>
                                        <select name="IconKategori" class="form-control @error('IconKategori') is-invalid @enderror" required>
                                            @foreach(['fa-file-alt','fa-calendar-alt','fa-calendar-week','fa-chart-line','fa-info-circle','fa-book','fa-chart-pie','fa-balance-scale'] as $icon)
                                                <option value="{{ $icon }}" {{ old('IconKategori', $jenis->IconKategori) == $icon ? 'selected' : '' }}>
                                                    <i class="fa {{ $icon }}"></i> {{ $icon }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('IconKategori') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Warna Badge</strong> <span class="text-danger">*</span></label>
                                        <select name="WarnaBadge" class="form-control @error('WarnaBadge') is-invalid @enderror" required>
                                            @foreach(['primary','secondary','success','danger','warning','info'] as $color)
                                                <option value="{{ $color }}" {{ old('WarnaBadge', $jenis->WarnaBadge) == $color ? 'selected' : '' }}>{{ ucfirst($color) }}</option>
                                            @endforeach
                                        </select>
                                        @error('WarnaBadge') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Urutan Tampil</strong></label>
                                        <input type="number" name="Urutan" class="form-control" value="{{ old('Urutan', $jenis->Urutan) }}" min="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Status</strong></label>
                                        <select name="Status" class="form-control">
                                            <option value="Aktif" {{ old('Status', $jenis->Status) == 'Aktif' ? 'selected' : '' }}>✅ Aktif</option>
                                            <option value="Nonaktif" {{ old('Status', $jenis->Status) == 'Nonaktif' ? 'selected' : '' }}>❌ Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info mt-4 mb-0 d-flex justify-content-between">
                                <small><i class="fa fa-user mr-1"></i> Dibuat: <strong>{{ $jenis->UserCreate ?? '-' }}</strong></small>
                                <small><i class="fa fa-link mr-1"></i> Slug: <code>{{ $jenis->Slug }}</code></small>
                            </div>

                        </div>
                        <div class="card-footer d-flex justify-content-end gap-3">
                            <a href="{{ route('jenis-laporan.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-save mr-2"></i>Update Jenis Laporan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

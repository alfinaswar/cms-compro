@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Tambah Jenis Laporan</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('jenis-laporan.index') }}">Jenis Laporan</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form action="{{ route('jenis-laporan.store') }}" method="POST">
                    @csrf
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-layer-group mr-2"></i>Informasi Jenis Laporan</h3>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label><strong>Nama Jenis Laporan</strong> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-tag"></i></span></div>
                                    <input type="text" name="NamaJenis" class="form-control @error('NamaJenis') is-invalid @enderror"
                                           placeholder="Contoh: Annual Report, Quarterly Report" value="{{ old('NamaJenis') }}" required autofocus>
                                </div>
                                @error('NamaJenis') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                <small class="text-muted">Nama akan otomatis di-convert ke slug untuk URL.</small>
                            </div>

                            <div class="form-group">
                                <label><strong>Deskripsi</strong></label>
                                <textarea name="Deskripsi" class="form-control @error('Deskripsi') is-invalid @enderror" rows="3"
                                          placeholder="Penjelasan singkat tentang jenis laporan ini...">{{ old('Deskripsi') }}</textarea>
                                @error('Deskripsi') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Icon Kategori</strong> <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-icons"></i></span></div>
                                            <select name="IconKategori" class="form-control @error('IconKategori') is-invalid @enderror" required>
                                                <option value="fa-file-alt" {{ old('IconKategori') == 'fa-file-alt' ? 'selected' : '' }}>📄 File Document</option>
                                                <option value="fa-calendar-alt" {{ old('IconKategori') == 'fa-calendar-alt' ? 'selected' : '' }}>📅 Calendar (Annual)</option>
                                                <option value="fa-calendar-week" {{ old('IconKategori') == 'fa-calendar-week' ? 'selected' : '' }}>📆 Calendar Week (Quarterly)</option>
                                                <option value="fa-chart-line" {{ old('IconKategori') == 'fa-chart-line' ? 'selected' : '' }}>📈 Chart Line (Highlight)</option>
                                                <option value="fa-info-circle" {{ old('IconKategori') == 'fa-info-circle' ? 'selected' : '' }}>ℹ️ Info Circle (Other)</option>
                                                <option value="fa-book" {{ old('IconKategori') == 'fa-book' ? 'selected' : '' }}>📖 Book</option>
                                                <option value="fa-chart-pie" {{ old('IconKategori') == 'fa-chart-pie' ? 'selected' : '' }}>🥧 Chart Pie</option>
                                                <option value="fa-balance-scale" {{ old('IconKategori') == 'fa-balance-scale' ? 'selected' : '' }}>⚖️ Balance Scale</option>
                                            </select>
                                        </div>
                                        @error('IconKategori') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Warna Badge</strong> <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-palette"></i></span></div>
                                            <select name="WarnaBadge" class="form-control @error('WarnaBadge') is-invalid @enderror" required>
                                                <option value="primary" {{ old('WarnaBadge') == 'primary' ? 'selected' : '' }}>🔵 Primary (Biru)</option>
                                                <option value="secondary" {{ old('WarnaBadge') == 'secondary' ? 'selected' : '' }}>⚫ Secondary (Abu)</option>
                                                <option value="success" {{ old('WarnaBadge') == 'success' ? 'selected' : '' }}> Success (Hijau)</option>
                                                <option value="danger" {{ old('WarnaBadge') == 'danger' ? 'selected' : '' }}>🔴 Danger (Merah)</option>
                                                <option value="warning" {{ old('WarnaBadge') == 'warning' ? 'selected' : '' }}>🟡 Warning (Kuning)</option>
                                                <option value="info" {{ old('WarnaBadge') == 'info' ? 'selected' : '' }}>🔵 Info (Cyan)</option>
                                            </select>
                                        </div>
                                        @error('WarnaBadge') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Urutan Tampil</strong></label>
                                        <input type="number" name="Urutan" class="form-control" value="{{ old('Urutan', 0) }}" min="0">
                                        <small class="text-muted">Angka lebih kecil tampil lebih dulu.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Status</strong></label>
                                        <select name="Status" class="form-control">
                                            <option value="Aktif" {{ old('Status') == 'Aktif' ? 'selected' : '' }}>✅ Aktif</option>
                                            <option value="Nonaktif" {{ old('Status') == 'Nonaktif' ? 'selected' : '' }}>❌ Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer d-flex justify-content-end gap-3">
                            <a href="{{ route('jenis-laporan.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-2"></i>Simpan Jenis Laporan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Kantor</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('master-kantor.index') }}">Kantor</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form action="{{ route('master-kantor.update', $kantor->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="card card-outline card-warning shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-edit mr-2"></i>Edit Data: {{ $kantor->NamaKantor }}</h3>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label><strong>Nama Kantor</strong> <span class="text-danger">*</span></label>
                                        <input type="text" name="NamaKantor"
                                            class="form-control @error('NamaKantor') is-invalid @enderror"
                                            value="{{ old('NamaKantor', $kantor->NamaKantor) }}" required>
                                        @error('NamaKantor')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>Tipe Kantor</strong> <span class="text-danger">*</span></label>
                                        <select name="TipeKantor"
                                            class="form-control @error('TipeKantor') is-invalid @enderror" required>
                                            <option value="Pusat"
                                                {{ old('TipeKantor', $kantor->TipeKantor) == 'Pusat' ? 'selected' : '' }}>🏢
                                                Kantor Pusat</option>
                                            <option value="Cabang"
                                                {{ old('TipeKantor', $kantor->TipeKantor) == 'Cabang' ? 'selected' : '' }}>
                                                🏪 Kantor Cabang</option>
                                        </select>
                                        @error('TipeKantor')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">
                            <h5 class="text-primary mb-3"><i class="fa fa-map-marker-alt mr-2"></i>Alamat & Lokasi</h5>

                            <div class="form-group">
                                <label><strong>Alamat Lengkap</strong> <span class="text-danger">*</span></label>
                                <textarea name="AlamatLengkap" class="form-control @error('AlamatLengkap') is-invalid @enderror" rows="3"
                                    required>{{ old('AlamatLengkap', $kantor->AlamatLengkap) }}</textarea>
                                @error('AlamatLengkap')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>Kota / Kabupaten</strong> <span class="text-danger">*</span></label>
                                        <input type="text" name="Kota"
                                            class="form-control @error('Kota') is-invalid @enderror"
                                            value="{{ old('Kota', $kantor->Kota) }}" required>
                                        @error('Kota')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>Provinsi</strong> <span class="text-danger">*</span></label>
                                        <input type="text" name="Provinsi"
                                            class="form-control @error('Provinsi') is-invalid @enderror"
                                            value="{{ old('Provinsi', $kantor->Provinsi) }}" required>
                                        @error('Provinsi')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>Kode Pos</strong></label>
                                        <input type="text" name="KodePos"
                                            class="form-control @error('KodePos') is-invalid @enderror"
                                            value="{{ old('KodePos', $kantor->KodePos) }}">
                                        @error('KodePos')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Tautan Google Maps</strong></label>
                                        <input type="url" name="TautanGoogleMaps"
                                            class="form-control @error('TautanGoogleMaps') is-invalid @enderror"
                                            value="{{ old('TautanGoogleMaps', $kantor->TautanGoogleMaps) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Embed Google Maps (Iframe)</strong></label>
                                        <textarea name="EmbedGoogleMaps" class="form-control @error('EmbedGoogleMaps') is-invalid @enderror" rows="2">{{ old('EmbedGoogleMaps', $kantor->EmbedGoogleMaps) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">
                            <h5 class="text-primary mb-3"><i class="fa fa-phone-alt mr-2"></i>Informasi Kontak</h5>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>Nomor Telepon</strong></label>
                                        <input type="text" name="NomorTelepon"
                                            class="form-control @error('NomorTelepon') is-invalid @enderror"
                                            value="{{ old('NomorTelepon', $kantor->NomorTelepon) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>Nomor WhatsApp</strong></label>
                                        <input type="text" name="NomorWhatsApp"
                                            class="form-control @error('NomorWhatsApp') is-invalid @enderror"
                                            value="{{ old('NomorWhatsApp', $kantor->NomorWhatsApp) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>Alamat Email</strong></label>
                                        <input type="email" name="AlamatEmail"
                                            class="form-control @error('AlamatEmail') is-invalid @enderror"
                                            value="{{ old('AlamatEmail', $kantor->AlamatEmail) }}">
                                        @error('AlamatEmail')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">
                            <h5 class="text-primary mb-3"><i class="fa fa-cog mr-2"></i>Pengaturan Tampilan</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Urutan Tampil</strong></label>
                                        <input type="number" name="Urutan" class="form-control"
                                            value="{{ old('Urutan', $kantor->Urutan) }}" min="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Status</strong></label>
                                        <select name="Status" class="form-control">
                                            <option value="Aktif"
                                                {{ old('Status', $kantor->Status) == 'Aktif' ? 'selected' : '' }}>✅ Aktif
                                                (Tampil di Website)</option>
                                            <option value="Nonaktif"
                                                {{ old('Status', $kantor->Status) == 'Nonaktif' ? 'selected' : '' }}>❌
                                                Nonaktif (Sembunyikan)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Audit Info --}}
                            <div class="alert alert-info mt-4 mb-0 d-flex justify-content-between">
                                <small><i class="fa fa-user mr-1"></i> Dibuat oleh:
                                    <strong>{{ $kantor->UserCreate ?? '-' }}</strong></small>
                                @if ($kantor->UserUpdate)
                                    <small><i class="fa fa-edit mr-1"></i> Terakhir diupdate:
                                        <strong>{{ $kantor->UserUpdate }}</strong></small>
                                @endif
                            </div>

                        </div>
                        <div class="card-footer d-flex justify-content-end gap-3">
                            <a href="{{ route('master-kantor.index') }}" class="btn btn-secondary">
                                <i class="fa fa-times mr-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fa fa-save mr-2"></i>Update Data
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

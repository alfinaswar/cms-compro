@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Anggota</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a
                                href="{{ route('struktur-organisasi.anggota.index', $section->id) }}">Anggota</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form action="{{ route('struktur-organisasi.anggota.update', [$section->id, $anggota->id]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-user-edit mr-2"></i>Edit Data:
                                {{ $anggota->NamaLengkap }}</h3>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="NamaLengkap"
                                            class="form-control @error('NamaLengkap') is-invalid @enderror"
                                            value="{{ old('NamaLengkap', $anggota->NamaLengkap) }}" required>
                                        @error('NamaLengkap')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jabatan <span class="text-danger">*</span></label>
                                        <input type="text" name="Jabatan"
                                            class="form-control @error('Jabatan') is-invalid @enderror"
                                            value="{{ old('Jabatan', $anggota->Jabatan) }}" required>
                                        @error('Jabatan')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi Singkat (Bio)</label>
                                <textarea name="DeskripsiSingkat" class="form-control" rows="3">{{ old('DeskripsiSingkat', $anggota->DeskripsiSingkat) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Foto Anggota</label>
                                        <div class="custom-file">
                                            <input type="file" name="PathFoto"
                                                class="custom-file-input @error('PathFoto') is-invalid @enderror"
                                                accept="image/*">
                                            <label class="custom-file-label">Upload foto baru...</label>
                                        </div>
                                        @error('PathFoto')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror

                                        @if ($anggota->PathFoto)
                                            <div class="mt-2">
                                                <small class="text-muted">Foto saat ini:</small><br>
                                                <img src="{{ Storage::url($anggota->PathFoto) }}"
                                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Urutan</label>
                                        <input type="number" name="Urutan" class="form-control"
                                            value="{{ old('Urutan', $anggota->Urutan) }}" min="0">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="Status" class="form-control">
                                            <option value="Aktif"
                                                {{ old('Status', $anggota->Status) == 'Aktif' ? 'selected' : '' }}>Aktif
                                            </option>
                                            <option value="Nonaktif"
                                                {{ old('Status', $anggota->Status) == 'Nonaktif' ? 'selected' : '' }}>
                                                Nonaktif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer d-flex justify-content-end gap-3">
                            <a href="{{ route('struktur-organisasi.anggota.index', $section->id) }}"
                                class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning">Update Anggota</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@extends('layouts.app')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}">
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Tambah Lowongan Kerja</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('karir.index') }}">Lowongan Kerja</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form action="{{ route('karir.store') }}" method="POST">
                    @csrf
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fa fa-briefcase mr-2"></i>Informasi Lowongan</h3>
                        </div>
                        <div class="card-body">

                            <!-- TABS BAHASA -->
                            <ul class="nav nav-tabs mb-4" id="langTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-id-tab" data-toggle="tab" href="#tab-id" role="tab">
                                        🇮 Bahasa Indonesia <span class="text-danger">*</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-en-tab" data-toggle="tab" href="#tab-en" role="tab">
                                        🇬🇧 English
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content" id="langTabsContent">
                                <!-- TAB INDONESIA -->
                                <div class="tab-pane fade show active" id="tab-id" role="tabpanel">
                                    <div class="form-group">
                                        <label><strong>Posisi / Jabatan</strong> <span class="text-danger">*</span></label>
                                        <input type="text" name="translations[id][Posisi]" class="form-control @error('translations.id.Posisi') is-invalid @enderror"
                                               placeholder="Contoh: Staff IT" value="{{ old('translations.id.Posisi') }}">
                                        @error('translations.id.Posisi') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Deskripsi Pekerjaan</strong> <span class="text-danger">*</span></label>
                                        <textarea name="translations[id][Deskripsi]" rows="4" class="form-control @error('translations.id.Deskripsi') is-invalid @enderror">{{ old('translations.id.Deskripsi') }}</textarea>
                                        @error('translations.id.Deskripsi') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Kualifikasi Kandidat</strong> <span class="text-danger">*</span></label>
                                        <textarea name="translations[id][Kualifikasi]" class="form-control summernote-id @error('translations.id.Kualifikasi') is-invalid @enderror">{{ old('translations.id.Kualifikasi') }}</textarea>
                                        @error('translations.id.Kualifikasi') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- TAB ENGLISH -->
                                <div class="tab-pane fade" id="tab-en" role="tabpanel">
                                    <div class="form-group">
                                        <label><strong>Position / Title</strong></label>
                                        <input type="text" name="translations[en][Posisi]" class="form-control @error('translations.en.Posisi') is-invalid @enderror"
                                               placeholder="Example: IT Staff" value="{{ old('translations.en.Posisi') }}">
                                        @error('translations.en.Posisi') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Job Description</strong></label>
                                        <textarea name="translations[en][Deskripsi]" rows="4" class="form-control @error('translations.en.Deskripsi') is-invalid @enderror">{{ old('translations.en.Deskripsi') }}</textarea>
                                        @error('translations.en.Deskripsi') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Candidate Qualifications</strong></label>
                                        <textarea name="translations[en][Kualifikasi]" class="form-control summernote-en @error('translations.en.Kualifikasi') is-invalid @enderror">{{ old('translations.en.Kualifikasi') }}</textarea>
                                        @error('translations.en.Kualifikasi') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- DATA UMUM (TIDAK DITERJEMAHKAN) -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Kota Penempatan</strong> <span class="text-danger">*</span></label>
                                        <select name="Kota" class="form-control select2 @error('Kota') is-invalid @enderror" required>
                                            <option value="">-- Pilih Kota --</option>
                                            @foreach ($Kota as $kota)
                                                <option value="{{ $kota->code }}" {{ old('Kota') == $kota->code ? 'selected' : '' }}>{{ $kota->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('Kota') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Batas Waktu Lamaran</strong> <span class="text-danger">*</span></label>
                                        <input type="date" name="BatasWaktu" class="form-control @error('BatasWaktu') is-invalid @enderror" value="{{ old('BatasWaktu') }}" required>
                                        @error('BatasWaktu') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><strong>Status Lowongan</strong> <span class="text-danger">*</span></label>
                                <select name="Status" class="form-control" required>
                                    <option value="Buka" {{ old('Status') == 'Buka' ? 'selected' : '' }}>Buka (Dapat Dilamar)</option>
                                    <option value="Tutup" {{ old('Status') == 'Tutup' ? 'selected' : '' }}>Tutup (Tidak Dapat Dilamar)</option>
                                </select>
                                @error('Status') <span class="invalid-feedback d-block mt-1">{{ $message }}</span> @enderror
                            </div>

                        </div>
                        <div class="card-footer d-flex justify-content-end gap-3">
                            <a href="{{ route('karir.index') }}" class="btn btn-secondary"><i class="fa fa-times mr-2"></i>Batal</a>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-2"></i>Simpan Lowongan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Summernote ID & EN (Gunakan class agar tidak bentrok)
            $('.summernote-id').summernote({ height: 250, placeholder: 'Tuliskan kualifikasi...' });
            $('.summernote-en').summernote({ height: 250, placeholder: 'Write qualifications...' });

            // Select2
            $('.select2').select2({ theme: 'bootstrap4', width: '100%' });
        });
    </script>
@endpush

@extends('layouts.app')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('') }}assets/plugins/summernote/summernote-bs4.css">
    @endpush
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Lowongan Kerja</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('karir.index') }}">Lowongan Kerja</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form action="{{ route('karir.update', $lowongan->id) }}" method="POST" id="formLowonganEdit">
                    @csrf
                    @method('PUT')
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa fa-briefcase mr-2"></i> Edit Lowongan Kerja
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Posisi"><strong>Posisi / Jabatan</strong> <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user-tie"></i></span>
                                            </div>
                                            <input type="text" name="Posisi" id="Posisi"
                                                class="form-control @error('Posisi') is-invalid @enderror"
                                                placeholder="Contoh: Staff IT, Marketing Executive"
                                                value="{{ old('Posisi', $lowongan->Posisi) }}" autofocus>
                                        </div>
                                        @error('Posisi')
                                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Kota"><strong>Kota Penempatan</strong> <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select name="Kota" id="Kota"
                                                class="form-control select2 @error('Kota') is-invalid @enderror"
                                                data-placeholder="Pilih kota penempatan">
                                                <option value="">-- Pilih Kota --</option>
                                                @foreach ($Kota as $kota)
                                                    <option value="{{ $kota->code }}"
                                                        {{ old('Kota', $lowongan->Kota) == $kota->code ? 'selected' : '' }}>
                                                        {{ $kota->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('Kota')
                                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="BatasWaktu"><strong>Batas Waktu Lamaran</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" name="BatasWaktu" id="BatasWaktu"
                                                class="form-control @error('BatasWaktu') is-invalid @enderror"
                                                value="{{ old('BatasWaktu', $lowongan->BatasWaktu) }}">
                                        </div>
                                        @error('BatasWaktu')
                                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted">Kosongkan jika tidak ada batas waktu.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Status"><strong>Status Lowongan</strong> <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-toggle-on"></i></span>
                                            </div>
                                            <select name="Status" id="Status"
                                                class="form-control @error('Status') is-invalid @enderror">
                                                <option value="Buka"
                                                    {{ old('Status', $lowongan->Status) == 'Buka' ? 'selected' : '' }}>
                                                    Buka (Dapat Dilamar)</option>
                                                <option value="Tutup"
                                                    {{ old('Status', $lowongan->Status) == 'Tutup' ? 'selected' : '' }}>
                                                    Tutup (Tidak Dapat Dilamar)</option>
                                            </select>
                                        </div>
                                        @error('Status')
                                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Deskripsi"><strong>Deskripsi Pekerjaan</strong></label>
                                <textarea name="Deskripsi" id="Deskripsi" rows="5" class="form-control @error('Deskripsi') is-invalid @enderror"
                                    placeholder="Jelaskan tanggung jawab dan deskripsi singkat pekerjaan...">{{ old('Deskripsi', $lowongan->Deskripsi) }}</textarea>
                                @error('Deskripsi')
                                    <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="Kualifikasi"><strong>Kualifikasi Kandidat</strong></label>
                                <textarea name="Kualifikasi" id="summernote" rows="6"
                                    class="form-control @error('Kualifikasi') is-invalid @enderror"
                                    placeholder="Contoh:&#10;- Minimal S1 Teknik Informatika&#10;- Pengalaman 1 tahun di bidang terkait&#10;- Menguasai Laravel & MySQL">{{ old('Kualifikasi', $lowongan->Kualifikasi) }}</textarea>
                                @error('Kualifikasi')
                                    <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">
                                    <i class="fa fa-info-circle"></i> Gunakan tanda strip (-) atau bintang (*) untuk
                                    membuat daftar poin.
                                </small>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end gap-3">
                            <a href="{{ route('karir.index') }}" class="btn btn-secondary me-3">
                                <i class="fa fa-times mr-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary ms-2">
                                <i class="fa fa-save mr-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <!-- Summernote -->
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            // ========== SUMMERNOTE - Kualifikasi ==========
            $('#summernote').summernote({
                height: 300,
                placeholder: 'Tuliskan kualifikasi kandidat...\nContoh:\n- Minimal S1 Teknik Informatika\n- Pengalaman 1 tahun di bidang terkait\n- Menguasai Laravel & MySQL',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });

            // ========== SELECT2 - Kota ==========
            $('#Kota').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Kota --',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush

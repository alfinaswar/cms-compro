@extends('layouts.app')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}">
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
                    <div class="card card-outline card-warning shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa fa-edit mr-2"></i> Edit Lowongan Kerja
                            </h3>
                        </div>
                        <div class="card-body">

                            <!-- TABS BAHASA -->
                            <ul class="nav nav-tabs mb-4" id="langTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-id-tab" data-toggle="tab" href="#tab-id" role="tab">
                                        🇮🇩 Bahasa Indonesia <span class="text-danger">*</span>
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
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user-tie"></i></span>
                                            </div>
                                            <input type="text" name="translations[id][Posisi]"
                                                class="form-control @error('translations.id.Posisi') is-invalid @enderror"
                                                placeholder="Contoh: Staff IT"
                                                value="{{ old('translations.id.Posisi', $lowongan->translate('id')->Posisi) }}">
                                        </div>
                                        @error('translations.id.Posisi')
                                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Deskripsi Pekerjaan</strong> <span class="text-danger">*</span></label>
                                        <textarea name="translations[id][Deskripsi]" rows="5"
                                            class="form-control @error('translations.id.Deskripsi') is-invalid @enderror"
                                            placeholder="Jelaskan tanggung jawab dan deskripsi singkat pekerjaan...">{{ old('translations.id.Deskripsi', $lowongan->translate('id')->Deskripsi) }}</textarea>
                                        @error('translations.id.Deskripsi')
                                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Kualifikasi Kandidat</strong> <span class="text-danger">*</span></label>
                                        <textarea name="translations[id][Kualifikasi]"
                                            class="form-control summernote-id @error('translations.id.Kualifikasi') is-invalid @enderror"
                                            placeholder="Contoh:&#10;- Minimal S1 Teknik Informatika&#10;- Pengalaman 1 tahun di bidang terkait">{{ old('translations.id.Kualifikasi', $lowongan->translate('id')->Kualifikasi) }}</textarea>
                                        @error('translations.id.Kualifikasi')
                                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted">
                                            <i class="fa fa-info-circle"></i> Gunakan tanda strip (-) atau bintang (*) untuk membuat daftar poin.
                                        </small>
                                    </div>
                                </div>

                                <!-- TAB ENGLISH -->
                                <div class="tab-pane fade" id="tab-en" role="tabpanel">
                                    <div class="form-group">
                                        <label><strong>Position / Title</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user-tie"></i></span>
                                            </div>
                                            <input type="text" name="translations[en][Posisi]"
                                                class="form-control @error('translations.en.Posisi') is-invalid @enderror"
                                                placeholder="Example: IT Staff"
                                                value="{{ old('translations.en.Posisi', $lowongan->translate('en')->Posisi) }}">
                                        </div>
                                        @error('translations.en.Posisi')
                                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Job Description</strong></label>
                                        <textarea name="translations[en][Deskripsi]" rows="5"
                                            class="form-control @error('translations.en.Deskripsi') is-invalid @enderror"
                                            placeholder="Describe responsibilities and job overview...">{{ old('translations.en.Deskripsi', $lowongan->translate('en')->Deskripsi) }}</textarea>
                                        @error('translations.en.Deskripsi')
                                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Candidate Qualifications</strong></label>
                                        <textarea name="translations[en][Kualifikasi]"
                                            class="form-control summernote-en @error('translations.en.Kualifikasi') is-invalid @enderror"
                                            placeholder="Example:&#10;- Bachelor's degree in Computer Science&#10;- 1 year experience in related field">{{ old('translations.en.Kualifikasi', $lowongan->translate('en')->Kualifikasi) }}</textarea>
                                        @error('translations.en.Kualifikasi')
                                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">
                            <h5 class="text-primary mb-3"><i class="fa fa-cog mr-2"></i>Data Umum (Tidak Diterjemahkan)</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Kota"><strong>Kota Penempatan</strong> <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                                            </div>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="BatasWaktu"><strong>Batas Waktu Lamaran</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="date" name="BatasWaktu" id="BatasWaktu"
                                                class="form-control @error('BatasWaktu') is-invalid @enderror"
                                                value="{{ old('BatasWaktu', $lowongan->BatasWaktu ? $lowongan->BatasWaktu->format('Y-m-d') : '') }}">
                                        </div>
                                        @error('BatasWaktu')
                                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted">Kosongkan jika tidak ada batas waktu.</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Status"><strong>Status Lowongan</strong> <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-toggle-on"></i></span>
                                            </div>
                                            <select name="Status" id="Status"
                                                class="form-control @error('Status') is-invalid @enderror">
                                                <option value="Buka" {{ old('Status', $lowongan->Status) == 'Buka' ? 'selected' : '' }}>
                                                    Buka (Dapat Dilamar)</option>
                                                <option value="Tutup" {{ old('Status', $lowongan->Status) == 'Tutup' ? 'selected' : '' }}>
                                                    Tutup (Tidak Dapat Dilamar)</option>
                                            </select>
                                        </div>
                                        @error('Status')
                                            <span class="invalid-feedback d-block mt-1">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Audit Info --}}
                            @if($lowongan->UserCreate || $lowongan->UserUpdate)
                                <div class="alert alert-info mt-4 mb-0 d-flex justify-content-between">
                                    <small><i class="fa fa-user mr-1"></i> Dibuat oleh: <strong>{{ $lowongan->UserCreate ?? '-' }}</strong></small>
                                    @if($lowongan->UserUpdate)
                                        <small><i class="fa fa-edit mr-1"></i> Update terakhir: <strong>{{ $lowongan->UserUpdate }}</strong></small>
                                    @endif
                                </div>
                            @endif

                        </div>
                        <div class="card-footer d-flex justify-content-end gap-3">
                            <a href="{{ route('karir.index') }}" class="btn btn-secondary me-3">
                                <i class="fa fa-times mr-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-warning ms-2">
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
            // ========== SUMMERNOTE - Bahasa Indonesia ==========
            $('.summernote-id').summernote({
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

            // ========== SUMMERNOTE - Bahasa Inggris ==========
            $('.summernote-en').summernote({
                height: 300,
                placeholder: 'Write candidate qualifications...\nExample:\n- Bachelor\'s degree in Computer Science\n- 1 year experience in related field\n- Proficient in Laravel & MySQL',
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

            // Auto-switch tab jika ada error di tab English
            @if($errors->has('translations.en.*'))
                $('#tab-en-tab').tab('show');
            @endif
        });
    </script>
@endpush

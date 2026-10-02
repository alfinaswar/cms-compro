@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            /* Animasi fadeIn untuk error feedback sesuai preferensi */
            .invalid-feedback {
                animation: fadeIn .3s ease-in-out;
            }
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-5px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .custom-file-label::after {
                content: "Browse";
            }
        </style>
    @endpush

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
            <div class="col-xl-12 col-lg-10">
                <form action="{{ route('hero-slider.store') }}" method="POST" enctype="multipart/form-data" id="formHeroSlider">
                    @csrf

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h3 class="card-title mb-0">
                                <i class="fa fa-layer-group text-primary mr-2"></i><strong>Data Utama Slider</strong>
                            </h3>
                        </div>
                        <div class="card-body">

                            {{-- TIPE MEDIA --}}
                            <div class="form-group">
                                <label><strong>Tipe Media Latar</strong> <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3">
                                    <div class="custom-control custom-radio mr-4">
                                        <input type="radio" id="tipeImage" name="TipeMedia" value="image" class="custom-control-input" checked>
                                        <label class="custom-control-label" for="tipeImage"><i class="fa fa-image mr-1"></i> Gambar</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="tipeVideo" name="TipeMedia" value="video" class="custom-control-input">
                                        <label class="custom-control-label" for="tipeVideo"><i class="fa fa-video mr-1"></i> Video</label>
                                    </div
                                </div>
                                <small class="text-muted">Pilih apakah latar belakang menggunakan gambar statis atau video.</small>
                            </div>

                            {{-- GAMBAR LATAR --}}
                            <div class="form-group" id="boxGambarLatar">
                                <label for="GambarLatar"><strong>Gambar Latar</strong> <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="GambarLatar" class="custom-file-input @error('GambarLatar') is-invalid @enderror" id="GambarLatar" accept="image/*">
                                    <label class="custom-file-label" for="GambarLatar">Pilih gambar latar...</label>
                                </div>
                                @error('GambarLatar')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Rekomendasi: 1920x1080px, format JPG/PNG, maks 2MB.</small>
                                <div id="previewGambarLatar" class="mt-2" style="display:none;">
                                    <img src="" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            </div>

                            {{-- VIDEO LATAR --}}
                            <div class="form-group d-none" id="boxVideo">
                                <label for="Video"><strong>File Video</strong> <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="Video" class="custom-file-input @error('Video') is-invalid @enderror" id="Video" accept="video/mp4,video/quicktime">
                                    <label class="custom-file-label" for="Video">Pilih file video...</label>
                                </div>
                                @error('Video')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Rekomendasi: Format MP4, durasi pendek, maks 20MB.</small>
                            </div>

                            <hr class="my-4">

                            {{-- KONTEN TEKS --}}
                            <div class="form-group">
                                <label for="SubJudul"><strong>Sub Judul</strong></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-tag"></i></span>
                                    </div>
                                    <input type="text" name="SubJudul" id="SubJudul"
                                        class="form-control @error('SubJudul') is-invalid @enderror"
                                        placeholder="contoh: Mitra Teknologi Terpercaya" value="{{ old('SubJudul') }}">
                                    @error('SubJudul')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="JudulUtama"><strong>Judul Utama</strong> <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-heading"></i></span>
                                    </div>
                                    <input type="text" name="JudulUtama" id="JudulUtama"
                                        class="form-control @error('JudulUtama') is-invalid @enderror"
                                        placeholder="contoh: Transformasi Digital Identitas & Pembayaran" value="{{ old('JudulUtama') }}" required>
                                    @error('JudulUtama')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Deskripsi"><strong>Deskripsi</strong></label>
                                <textarea name="Deskripsi" id="Deskripsi" rows="3"
                                    class="form-control @error('Deskripsi') is-invalid @enderror"
                                    placeholder="Deskripsi singkat yang muncul di bawah judul utama...">{{ old('Deskripsi') }}</textarea>
                                @error('Deskripsi')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <hr class="my-4">

                            {{-- CALL TO ACTION (CTA) --}}
                            <h6 class="text-primary mb-3"><i class="fa fa-mouse-pointer mr-2"></i><strong>Pengaturan Tombol (CTA)</strong></h6>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="TeksCTA"><strong>Teks Tombol 1</strong></label>
                                        <input type="text" name="TeksCTA" id="TeksCTA" class="form-control @error('TeksCTA') is-invalid @enderror" placeholder="contoh: Jelajahi Solusi" value="{{ old('TeksCTA') }}">
                                        @error('TeksCTA') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="LinkCTA"><strong>Link Tombol 1</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-link"></i></span>
                                            </div>
                                            <input type="url" name="LinkCTA" id="LinkCTA" class="form-control @error('LinkCTA') is-invalid @enderror" placeholder="https://..." value="{{ old('LinkCTA') }}">
                                            @error('LinkCTA') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="TeksCTA2"><strong>Teks Tombol 2 (Opsional)</strong></label>
                                        <input type="text" name="TeksCTA2" id="TeksCTA2" class="form-control @error('TeksCTA2') is-invalid @enderror" placeholder="contoh: Hubungi Kami" value="{{ old('TeksCTA2') }}">
                                        @error('TeksCTA2') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="LinkCTA2"><strong>Link Tombol 2</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-link"></i></span>
                                            </div>
                                            <input type="url" name="LinkCTA2" id="LinkCTA2" class="form-control @error('LinkCTA2') is-invalid @enderror" placeholder="https://..." value="{{ old('LinkCTA2') }}">
                                            @error('LinkCTA2') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- PENGATURAN TAMBAHAN --}}
                            <div class="row">
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="GambarBentuk"><strong>Gambar Dekorasi / Bentuk (Opsional)</strong></label>
                                        <div class="custom-file">
                                            <input type="file" name="GambarBentuk" class="custom-file-input @error('GambarBentuk') is-invalid @enderror" id="GambarBentuk" accept="image/*">
                                            <label class="custom-file-label" for="GambarBentuk">Pilih gambar dekorasi...</label>
                                        </div>
                                        @error('GambarBentuk') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        <small class="text-muted">Gambar overlay transparan (PNG) untuk estetika.</small>
                                    </div>
                                </div> --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Urutan"><strong>Urutan Tampil</strong></label>
                                        <input type="number" name="Urutan" id="Urutan" class="form-control @error('Urutan') is-invalid @enderror" value="{{ old('Urutan', 1) }}" min="1">
                                        @error('Urutan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        <small class="text-muted">Angka lebih kecil tampil lebih dulu.</small>
                                    </div>
                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Status"><strong>Status</strong> <span class="text-danger">*</span></label>
                                        <select name="Status" id="Status" class="form-control @error('Status') is-invalid @enderror" required>
                                            <option value="1" {{ old('Status', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ old('Status') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                        @error('Status') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer bg-white border-top d-flex justify-content-end align-items-center">
                            <a href="{{ route('hero-slider.index') }}" class="btn btn-light border px-4 mr-2">
                                <i class="fa fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
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
            // 1. Toggle Custom File Label
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
            });

            // 2. Toggle antara Input Gambar dan Video
            $('input[name="TipeMedia"]').on('change', function() {
                if ($(this).val() === 'image') {
                    $('#boxGambarLatar').removeClass('d-none');
                    $('#boxVideo').addClass('d-none');
                    $('#Video').removeAttr('required');
                    $('#GambarLatar').attr('required', 'required');
                } else {
                    $('#boxGambarLatar').addClass('d-none');
                    $('#boxVideo').removeClass('d-none');
                    $('#GambarLatar').removeAttr('required');
                    $('#Video').attr('required', 'required');
                }
            });

            // 3. Preview Gambar Latar saat dipilih
            $('#GambarLatar').on('change', function(e) {
                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(ev) {
                        $('#previewGambarLatar img').attr('src', ev.target.result);
                        $('#previewGambarLatar').show();
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endpush

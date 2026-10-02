@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
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
            .preview-box {
                max-height: 150px;
                object-fit: contain;
                border-radius: 0.25rem;
                border: 1px solid #dee2e6;
                padding: 4px;
                background: #f8f9fa;
            }
        </style>
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Hero Slider</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('hero-slider.index') }}">Hero Slider</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-10">
                {{-- Gunakan route update dan method PUT/PATCH --}}
                <form action="{{ route('hero-slider.update', $heroSlider->id) }}" method="POST" enctype="multipart/form-data" id="formHeroSlider">
                    @csrf
                    @method('PUT')

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h3 class="card-title mb-0">
                                <i class="fa fa-edit text-primary mr-2"></i><strong>Edit Data Hero Slider</strong>
                            </h3>
                        </div>
                        <div class="card-body">

                            {{-- TIPE MEDIA --}}
                            <div class="form-group">
                                <label><strong>Tipe Media Latar</strong> <span class="text-danger">*</span></label>
                                <div class="d-flex gap-3">
                                    <div class="custom-control custom-radio mr-4">
                                        <input type="radio" id="tipeImage" name="TipeMedia" value="image"
                                            class="custom-control-input"
                                            {{ old('TipeMedia', $heroSlider->TipeMedia) == 'image' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="tipeImage"><i class="fa fa-image mr-1"></i> Gambar</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="tipeVideo" name="TipeMedia" value="video"
                                            class="custom-control-input"
                                            {{ old('TipeMedia', $heroSlider->TipeMedia) == 'video' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="tipeVideo"><i class="fa fa-video mr-1"></i> Video</label>
                                    </div>
                                </div>
                                <small class="text-muted">Pilih apakah latar belakang menggunakan gambar statis atau video.</small>
                            </div>

                            {{-- GAMBAR LATAR --}}
                            {{-- Tambahkan d-none jika tipe media saat ini adalah video --}}
                            <div class="form-group {{ old('TipeMedia', $heroSlider->TipeMedia) == 'video' ? 'd-none' : '' }}" id="boxGambarLatar">
                                <label for="GambarLatar"><strong>Gambar Latar</strong> <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="GambarLatar" class="custom-file-input @error('GambarLatar') is-invalid @enderror" id="GambarLatar" accept="image/*">
                                    <label class="custom-file-label" for="GambarLatar">Pilih gambar baru (kosongkan jika tidak ingin mengubah)</label>
                                </div>
                                @error('GambarLatar')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Rekomendasi: 1920x1080px, format JPG/PNG, maks 2MB.</small>

                                {{-- Preview Gambar Lama --}}
                                @if($heroSlider->GambarLatar)
                                    <div id="previewGambarLatar" class="mt-2">
                                        <p class="text-muted mb-1" style="font-size: 12px;">Gambar saat ini:</p>
                                        <img src="{{ asset('storage/' . $heroSlider->GambarLatar) }}" class="preview-box" alt="Preview Gambar Lama">
                                    </div>
                                @else
                                    <div id="previewGambarLatar" class="mt-2" style="display:none;">
                                        <img src="" class="preview-box" alt="Preview Gambar Baru">
                                    </div>
                                @endif
                            </div>

                            {{-- VIDEO LATAR --}}
                            {{-- Tambahkan d-none jika tipe media saat ini adalah image --}}
                            <div class="form-group {{ old('TipeMedia', $heroSlider->TipeMedia) == 'image' ? 'd-none' : '' }}" id="boxVideo">
                                <label for="Video"><strong>File Video</strong> <span class="text-danger">*</span></label>
                                <div class="custom-file">
                                    <input type="file" name="Video" class="custom-file-input @error('Video') is-invalid @enderror" id="Video" accept="video/mp4,video/quicktime">
                                    <label class="custom-file-label" for="Video">Pilih video baru (kosongkan jika tidak ingin mengubah)</label>
                                </div>
                                @error('Video')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Rekomendasi: Format MP4, durasi pendek, maks 20MB.</small>

                                {{-- Preview Video Lama --}}
                                @if($heroSlider->Video)
                                    <div id="previewVideo" class="mt-2">
                                        <p class="text-muted mb-1" style="font-size: 12px;">Video saat ini:</p>
                                        <video src="{{ asset('storage/' . $heroSlider->Video) }}" class="preview-box" controls style="max-width: 300px;"></video>
                                    </div>
                                @else
                                    <div id="previewVideo" class="mt-2" style="display:none;">
                                        <video src="" class="preview-box" controls style="max-width: 300px;"></video>
                                    </div>
                                @endif
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
                                        placeholder="contoh: Mitra Teknologi Terpercaya"
                                        value="{{ old('SubJudul', $heroSlider->SubJudul) }}">
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
                                        placeholder="contoh: Transformasi Digital Identitas & Pembayaran"
                                        value="{{ old('JudulUtama', $heroSlider->JudulUtama) }}" required>
                                    @error('JudulUtama')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Deskripsi"><strong>Deskripsi</strong></label>
                                <textarea name="Deskripsi" id="Deskripsi" rows="3"
                                    class="form-control @error('Deskripsi') is-invalid @enderror"
                                    placeholder="Deskripsi singkat yang muncul di bawah judul utama...">{{ old('Deskripsi', $heroSlider->Deskripsi) }}</textarea>
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
                                        <input type="text" name="TeksCTA" id="TeksCTA" class="form-control @error('TeksCTA') is-invalid @enderror" placeholder="contoh: Jelajahi Solusi" value="{{ old('TeksCTA', $heroSlider->TeksCTA) }}">
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
                                            <input type="url" name="LinkCTA" id="LinkCTA" class="form-control @error('LinkCTA') is-invalid @enderror" placeholder="https://..." value="{{ old('LinkCTA', $heroSlider->LinkCTA) }}">
                                            @error('LinkCTA') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="TeksCTA2"><strong>Teks Tombol 2 (Opsional)</strong></label>
                                        <input type="text" name="TeksCTA2" id="TeksCTA2" class="form-control @error('TeksCTA2') is-invalid @enderror" placeholder="contoh: Hubungi Kami" value="{{ old('TeksCTA2', $heroSlider->TeksCTA2) }}">
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
                                            <input type="url" name="LinkCTA2" id="LinkCTA2" class="form-control @error('LinkCTA2') is-invalid @enderror" placeholder="https://..." value="{{ old('LinkCTA2', $heroSlider->LinkCTA2) }}">
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
                                            <label class="custom-file-label" for="GambarBentuk">Pilih gambar dekorasi baru...</label>
                                        </div>
                                        @error('GambarBentuk') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        <small class="text-muted">Gambar overlay transparan (PNG) untuk estetika.</small>

                                        @if($heroSlider->GambarBentuk)
                                            <div id="previewGambarBentuk" class="mt-2">
                                                <p class="text-muted mb-1" style="font-size: 12px;">Dekorasi saat ini:</p>
                                                <img src="{{ asset('storage/' . $heroSlider->GambarBentuk) }}" class="preview-box" alt="Preview Dekorasi">
                                            </div>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Urutan"><strong>Urutan Tampil</strong></label>
                                        <input type="number" name="Urutan" id="Urutan" class="form-control @error('Urutan') is-invalid @enderror" value="{{ old('Urutan', $heroSlider->Urutan) }}" min="1">
                                        @error('Urutan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        <small class="text-muted">Angka lebih kecil tampil lebih dulu.</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Status"><strong>Status</strong> <span class="text-danger">*</span></label>
                                        <select name="Status" id="Status" class="form-control @error('Status') is-invalid @enderror" required>
                                            <option value="1" {{ old('Status', $heroSlider->Status) == '1' ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ old('Status', $heroSlider->Status) == '0' ? 'selected' : '' }}>Tidak Aktif</option>
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
                                <i class="fa fa-save mr-1"></i> Update Hero Slider
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
                    // Opsional: Jika ingin memaksa upload gambar saat switch, tambahkan: $('#GambarLatar').attr('required', 'required');
                } else {
                    $('#boxGambarLatar').addClass('d-none');
                    $('#boxVideo').removeClass('d-none');
                    $('#GambarLatar').removeAttr('required');
                    // Opsional: $('#Video').attr('required', 'required');
                }
            });

            // 3. Preview Gambar Latar saat dipilih (menimpa preview lama)
            $('#GambarLatar').on('change', function(e) {
                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(ev) {
                        // Jika container preview belum ada (karena sebelumnya kosong), buat dulu
                        if ($('#previewGambarLatar img').length === 0) {
                            $('#previewGambarLatar').html('<p class="text-muted mb-1" style="font-size: 12px;">Preview gambar baru:</p><img src="" class="preview-box" alt="Preview">');
                        }
                        $('#previewGambarLatar img').attr('src', ev.target.result).show();
                        $('#previewGambarLatar').show();
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // 4. Preview Video saat dipilih
            $('#Video').on('change', function(e) {
                if (this.files && this.files[0]) {
                    let fileURL = URL.createObjectURL(this.files[0]);
                    if ($('#previewVideo video').length === 0) {
                        $('#previewVideo').html('<p class="text-muted mb-1" style="font-size: 12px;">Preview video baru:</p><video src="" class="preview-box" controls style="max-width: 300px;"></video>');
                    }
                    $('#previewVideo video').attr('src', fileURL).show();
                    $('#previewVideo').show();
                }
            });

            // 5. Preview Gambar Bentuk saat dipilih
            $('#GambarBentuk').on('change', function(e) {
                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(ev) {
                        if ($('#previewGambarBentuk img').length === 0) {
                            $('#previewGambarBentuk').html('<p class="text-muted mb-1" style="font-size: 12px;">Preview dekorasi baru:</p><img src="" class="preview-box" alt="Preview">');
                        }
                        $('#previewGambarBentuk img').attr('src', ev.target.result).show();
                        $('#previewGambarBentuk').show();
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endpush

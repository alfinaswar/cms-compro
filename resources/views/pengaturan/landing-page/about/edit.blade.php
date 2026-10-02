@extends('layouts.app')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('') }}assets/plugins/summernote/summernote-bs4.css">
    @endpush
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit About Us</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('about-us.index') }}">About Us</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    @php
        // Pastikan $aboutUs dan detail sudah dikirim ke view pada controller:
        // $aboutUs = AboutUs::with('getDetail')->findOrFail($id);
        // return view('pengaturan.landing-page.about.edit', compact('aboutUs'));
        $details = $aboutUs->getDetail ?? collect();
    @endphp

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <form action="{{ route('about-us.update', $aboutUs->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Card Utama About Us --}}
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa fa-info-circle mr-2"></i> Informasi About Us
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="SubJudul"><strong>Sub Judul</strong></label>
                                <input type="text" name="SubJudul" id="SubJudul"
                                    class="form-control @error('SubJudul') is-invalid @enderror"
                                    placeholder="contoh: Tentang Kami" value="{{ old('SubJudul', $aboutUs->SubJudul) }}">
                                @error('SubJudul')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="Judul"><strong>Judul</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="Judul" id="Judul"
                                    class="form-control @error('Judul') is-invalid @enderror"
                                    placeholder="contoh: Visi & Misi Perusahaan" value="{{ old('Judul', $aboutUs->Judul) }}"
                                    required>
                                @error('Judul')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="Deskripsi"><strong>Deskripsi</strong> <span class="text-danger">*</span></label>
                                <textarea name="Deskripsi" id="Deskripsi" rows="6"
                                    class="form-control @error('Deskripsi') is-invalid @enderror summernote"
                                    placeholder="Masukkan deskripsi lengkap tentang perusahaan..." required>{{ old('Deskripsi', $aboutUs->Deskripsi) }}</textarea>
                                @error('Deskripsi')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="Gambar"><strong>Gambar</strong></label>
                                <input type="file" name="Gambar" id="Gambar"
                                    class="form-control-file @error('Gambar') is-invalid @enderror" accept="image/*">
                                @error('Gambar')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Upload gambar latar untuk About Us.</small>
                                @if ($aboutUs->Gambar)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $aboutUs->Gambar) }}"
                                            style="max-width: 200px; max-height: 150px;" class="img-thumbnail"
                                            alt="Gambar Saat Ini">
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                    {{-- Card Detail About Us --}}
                    <div class="card card-outline card-primary shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0">
                                <i class="fa fa-list mr-2"></i> Detail About Us
                            </h3>
                            <div class="ml-auto">
                                <button type="button" class="btn btn-primary btn-sm" id="btnTambahDetail">
                                    <i class="fa fa-plus mr-1"></i> Tambah Detail
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tableDetail">
                                    <thead class="bg-light">
                                        <tr>
                                            <th style="width: 5%" class="text-center">No</th>
                                            <th style="width: 25%">Gambar</th>
                                            <th style="width: 30%">Judul</th>
                                            <th style="width: 35%">Deskripsi</th>
                                            <th style="width: 5%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="detailContainer">
                                        {{-- Jika ada data lama, tampilkan --}}
                                        @php $idx = 0; @endphp
                                        @foreach ($aboutUs->getDetail as $detail)
                                            <tr class="detail-row" data-index="{{ $idx }}">
                                                <td class="text-center row-number">{{ $idx + 1 }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="mr-2"
                                                            style="width: 80px; height: 80px; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                                            @if ($detail->Gambar)
                                                                <img src="{{ asset('storage/' . $detail->Gambar) }}"
                                                                    alt="Preview" class="img-preview"
                                                                    style="max-width: 100%; max-height: 100%;">
                                                            @else
                                                                <img src="" alt="Preview" class="img-preview"
                                                                    style="max-width: 100%; max-height: 100%; display: none;">
                                                                <i class="fa fa-image text-muted preview-placeholder"
                                                                    style="font-size: 24px;"></i>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <input type="file"
                                                                name="details[{{ $idx }}][Gambar]"
                                                                class="form-control-file input-gambar" accept="image/*">
                                                            <small class="text-muted">Maks. 2MB</small>
                                                            @if ($detail->Gambar)
                                                                <input type="hidden"
                                                                    name="details[{{ $idx }}][Gambar_lama]"
                                                                    value="{{ $detail->Gambar }}">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" name="details[{{ $idx }}][Judul]"
                                                        class="form-control" placeholder="Judul detail"
                                                        value="{{ $detail->Judul }}">
                                                </td>
                                                <td>
                                                    <textarea name="details[{{ $idx }}][Deskripsi]" class="form-control" rows="3"
                                                        placeholder="Deskripsi detail">{{ $detail->Deskripsi }}</textarea>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm btn-hapus-detail"
                                                        title="Hapus">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @php $idx++; @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <small class="text-muted">Tambahkan detail-detail tentang perusahaan (opsional).</small>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end bg-white">
                        <a href="{{ route('about-us.index') }}" class="btn btn-secondary mr-2">
                            <i class="fa fa-times mr-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save mr-1"></i> Update About Us
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            let rowIndex = $('#detailContainer tr').length || 0;

            // Inisialisasi summernote
            $('#Deskripsi').summernote({
                height: 400,
                placeholder: 'Tulis konten berita lengkap di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onImageUpload: function(files) {
                        var data = new FormData();
                        data.append('image', files[0]);
                        data.append('_token', '{{ csrf_token() }}');
                        $.ajax({
                            url: '{{ route('berita.upload-image') }}',
                            method: 'POST',
                            data: data,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                $('#summernote').summernote('insertImage', response.url);
                            }
                        });
                    }
                }
            });

            // Fungsi untuk menambah row detail
            function addDetailRow(detail = null) {
                const idx = rowIndex;
                const gambarPreview = detail && detail.Gambar ? '{{ asset('storage/') }}/' + detail.Gambar : '';
                const gambarLamaInput = detail && detail.Gambar ?
                    `<input type="hidden" name="details[${idx}][Gambar_lama]" value="${detail.Gambar}">` : '';

                const row = `
                    <tr class="detail-row" data-index="${idx}">
                        <td class="text-center row-number">${idx + 1}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="mr-2" style="width: 80px; height: 80px; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                    ${gambarPreview ? `<img src="${gambarPreview}" alt="Preview" class="img-preview" style="max-width: 100%; max-height: 100%;">` :
                                        '<img src="" alt="Preview" class="img-preview" style="max-width: 100%; max-height: 100%; display: none;">' +
                                        '<i class="fa fa-image text-muted preview-placeholder" style="font-size: 24px;"></i>'
                                    }
                                </div>
                                <div class="flex-grow-1">
                                    <input type="file" name="details[${idx}][Gambar]" class="form-control-file input-gambar" accept="image/*">
                                    <small class="text-muted">Maks. 2MB</small>
                                    ${gambarLamaInput}
                                </div>
                            </div>
                        </td>
                        <td>
                            <input type="text" name="details[${idx}][Judul]" class="form-control" placeholder="Judul detail" value="${detail ? (detail.Judul ?? '') : ''}">
                        </td>
                        <td>
                            <textarea name="details[${idx}][Deskripsi]" class="form-control" rows="3" placeholder="Deskripsi detail">${detail ? (detail.Deskripsi ?? '') : ''}</textarea>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm btn-hapus-detail" title="Hapus">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#detailContainer').append(row);
                rowIndex++;
                updateRowNumbers();
            }

            // Fungsi untuk update nomor urut
            function updateRowNumbers() {
                $('#detailContainer tr').each(function(index) {
                    $(this).find('.row-number').text(index + 1);
                });
            }

            // Event: Tambah Detail
            $('#btnTambahDetail').on('click', function() {
                addDetailRow();
            });

            // Event: Hapus Detail
            $('body').on('click', '.btn-hapus-detail', function() {
                $(this).closest('tr').remove();
                updateRowNumbers();
            });

            // Event: Preview Gambar
            $('body').on('change', '.input-gambar', function() {
                const file = this.files[0];
                const preview = $(this).closest('td').find('.img-preview');
                const placeholder = $(this).closest('td').find('.preview-placeholder');

                if (file) {
                    // Validasi ukuran file (maks 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire('Error!', 'Ukuran gambar maksimal 2MB', 'error');
                        $(this).val('');
                        preview.hide();
                        placeholder.show();
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.attr('src', e.target.result).show();
                        placeholder.hide();
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.hide();
                    placeholder.show();
                }
            });

            // Tambah row default jika kosong
            if ($('#detailContainer tr').length === 0) {
                addDetailRow();
            }
        });
    </script>
@endpush

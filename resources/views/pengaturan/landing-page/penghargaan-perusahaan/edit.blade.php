@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Penghargaan Perusahaan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('penghargaan-perusahaan.index') }}">Penghargaan
                                Perusahaan</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <form action="{{ route('penghargaan-perusahaan.update', $penghargaanPerusahaan->id) }}" method="POST"
            enctype="multipart/form-data" id="formPenghargaanPerusahaan">
            @csrf
            @method('PUT')
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="mb-0"><i class="fa fa-trophy text-primary mr-2"></i>
                                <strong>Form Edit Detail Penghargaan</strong>
                            </h5>
                        </div>
                        <div class="card-body">

                            {{-- Tabel editable untuk penghargaan --}}
                            <div class="table-responsive">
                                <table class="table table-bordered" id="penghargaanTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 35%;">Judul</th>
                                            <th style="width: 45%;">Deskripsi</th>
                                            <th style="width: 20%;">Gambar</th>
                                            <th style="width: 5%;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($penghargaanPerusahaan->details && count($penghargaanPerusahaan->details))
                                            @foreach ($penghargaanPerusahaan->details as $i => $detail)
                                                <tr>
                                                    <td>
                                                        <input type="text" name="details[{{ $i }}][Judul]"
                                                            class="form-control" required placeholder="Judul Penghargaan"
                                                            value="{{ old('details.' . $i . '.Judul', $detail->Judul) }}">
                                                    </td>
                                                    <td>
                                                        <textarea name="details[{{ $i }}][Deskripsi]" class="form-control" rows="3" required>{{ old('details.' . $i . '.Deskripsi', $detail->Deskripsi) }}</textarea>
                                                    </td>
                                                    <td>
                                                        @if (!empty($detail->Gambar))
                                                            <div class="mb-2">
                                                                <img src="{{ asset('storage/' . $detail->Gambar) }}"
                                                                    alt="Gambar Penghargaan"
                                                                    style="max-width: 90px; max-height: 80px;">
                                                            </div>
                                                        @endif
                                                        <input type="file" name="details[{{ $i }}][Gambar]"
                                                            class="form-control-file" accept="image/*">
                                                    </td>
                                                    <td class="text-center align-middle">
                                                        <button type="button" class="btn btn-danger btn-sm remove-row"
                                                            title="Hapus Baris">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>
                                                    <input type="text" name="details[0][Judul]" class="form-control"
                                                        required placeholder="Judul Penghargaan"
                                                        value="{{ old('details.0.Judul') }}">
                                                </td>
                                                <td>
                                                    <textarea name="details[0][Deskripsi]" class="form-control" rows="3" required>{{ old('details.0.Deskripsi') }}</textarea>
                                                </td>
                                                <td>
                                                    <input type="file" name="details[0][Gambar]"
                                                        class="form-control-file" accept="image/*">
                                                </td>
                                                <td class="text-center align-middle">
                                                    <button type="button" class="btn btn-danger btn-sm remove-row"
                                                        title="Hapus Baris">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-right">
                                                <button type="button" class="btn btn-primary btn-sm" id="addRowBtn"><i
                                                        class="fa fa-plus"></i> Tambah Baris</button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            {{-- Hidden input id --}}
                            <input type="hidden" name="PenghargaanId" value="{{ $penghargaanPerusahaan->id }}">

                            {{-- Informasi UserCreate, tidak bisa edit --}}
                            <div class="form-group mt-4">
                                <label for="UserCreate"><strong>User Create</strong></label>
                                <input type="text" class="form-control" id="UserCreate" name="UserCreate"
                                    value="{{ old('UserCreate', $penghargaanPerusahaan->UserCreate) }}" readonly>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="{{ route('penghargaan-perusahaan.index') }}" class="btn btn-secondary px-4">
                                    <i class="fa fa-arrow-left mr-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fa fa-save mr-1"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div> {{-- card-body --}}
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        function initSummernote() {
            $('.summernote').summernote({
                height: 120,
                placeholder: 'Tulis deskripsi penghargaan...',
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview']]
                ]
            });
        }

        $(document).ready(function() {
            initSummernote();

            $('#addRowBtn').on('click', function() {
                let idx = $('#penghargaanTable tbody tr').length;
                let newRow = `
                    <tr>
                        <td>
                            <input type="text" name="details[${idx}][Judul]" class="form-control" required placeholder="Judul Penghargaan">
                        </td>
                        <td>
                            <textarea name="details[${idx}][Deskripsi]" class="form-control" rows="3" required></textarea>
                        </td>
                        <td>
                            <input type="file" name="details[${idx}][Gambar]" class="form-control-file" accept="image/*">
                        </td>
                        <td class="text-center align-middle">
                            <button type="button" class="btn btn-danger btn-sm remove-row" title="Hapus Baris">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                $('#penghargaanTable tbody').append(newRow);
                initSummernote();
            });

            // Hapus baris penghargaan
            $('#penghargaanTable').on('click', '.remove-row', function() {
                if ($('#penghargaanTable tbody tr').length > 1) {
                    $(this).closest('tr').remove();
                } else {
                    alert('Minimal 1 baris detail penghargaan diperlukan.');
                }
            });
        });
    </script>
@endpush

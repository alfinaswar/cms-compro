@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Subjek Kontak</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Subjek Kontak</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fa fa-bookmark mr-2"></i>Daftar Subjek Kontak
                        </h3>
                        <div class="ml-auto">
                            @can('master-subject.create')
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCreateSubject">
                                    <i class="fa fa-plus mr-1"></i> Tambah Subjek
                                </button>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tableSubject" class="table table-bordered table-striped" style="width: 100%;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 5%" class="text-center">No</th>
                                    <th style="width: 45%">Nama Subjek</th>
                                    <th style="width: 35%">Nama Terjemahan</th>
                                    <th style="width: 15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== MODAL CREATE ==================== -->
    <div class="modal fade" id="modalCreateSubject" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document"> {{-- Changed from modal-sm to modal-lg --}}
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title mb-0">
                        <i class="fa fa-plus-circle mr-2"></i>Tambah Subjek Baru
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formCreateSubject">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="create_subject_nama">Nama Subjek <span class="text-danger">*</span></label>
                            <input type="text" id="create_subject_nama" name="Nama"
                                class="form-control @error('Nama') is-invalid @enderror"
                                placeholder="Contoh: Penawaran, Umum" required autofocus>
                            <span id="create_error_nama" class="invalid-feedback d-block" style="display:none;"></span>
                        </div>
                        <div class="form-group mb-0">
                            <label for="create_subject_nama_translate">Nama Terjemahan <small
                                    class="text-muted">(opsional)</small></label>
                            <input type="text" id="create_subject_nama_translate" name="NamaTranslate"
                                class="form-control" placeholder="Subject (English)">
                            <span id="create_error_nama_translate" class="invalid-feedback d-block"
                                style="display:none;"></span>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            <i class="fa fa-times mr-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm" id="btnCreateSubmit">
                            <i class="fa fa-save mr-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL EDIT ==================== -->
    <div class="modal fade" id="modalEditSubject" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document"> {{-- Changed from modal-sm to modal-lg --}}
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title mb-0">
                        <i class="fa fa-edit mr-2"></i>Edit Subjek
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditSubject">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_subject_id" name="id">
                        <div class="form-group mb-2">
                            <label for="edit_subject_nama">Nama Subjek <span class="text-danger">*</span></label>
                            <input type="text" id="edit_subject_nama" name="Nama" class="form-control" required>
                            <span id="edit_error_nama" class="invalid-feedback d-block" style="display:none;"></span>
                        </div>
                        <div class="form-group mb-0">
                            <label for="edit_subject_nama_translate">Nama Terjemahan <small
                                    class="text-muted">(opsional)</small></label>
                            <input type="text" id="edit_subject_nama_translate" name="NamaTranslate"
                                class="form-control">
                            <span id="edit_error_nama_translate" class="invalid-feedback d-block"
                                style="display:none;"></span>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            <i class="fa fa-times mr-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-warning btn-sm" id="btnEditSubmit">
                            <i class="fa fa-save mr-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#tableSubject').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('subjek.index') }}"
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Memuat...</span>',
                    emptyTable: 'Tidak ada data subjek',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    search: 'Cari:',
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'Nama',
                        name: 'Nama',
                        render: function(data) {
                            return '<strong>' + $('<div>').text(data).html() + '</strong>';
                        }
                    },
                    {
                        data: 'NamaTranslate',
                        name: 'NamaTranslate',
                        render: function(data) {
                            return data ? '<span class="text-muted">' + $('<div>').text(data)
                                .html() + '</span>' : '-';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                order: [
                    [1, 'asc']
                ]
            });

            $('#formCreateSubject').on('submit', function(e) {
                e.preventDefault();
                var btn = $('#btnCreateSubmit');
                var namaInput = $('#create_subject_nama');
                var namaTranslateInput = $('#create_subject_nama_translate');
                var errorNama = $('#create_error_nama');
                var errorNamaTranslate = $('#create_error_nama_translate');
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan...');
                namaInput.removeClass('is-invalid');
                namaTranslateInput.removeClass('is-invalid');
                errorNama.hide().text('');
                errorNamaTranslate.hide().text('');
                $.ajax({
                    url: '{{ route('subjek.store') }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            $('#modalCreateSubject').modal('hide');
                            $('#formCreateSubject')[0].reset();
                            table.ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON?.errors;
                        if (errors?.Nama) {
                            namaInput.addClass('is-invalid');
                            errorNama.text(errors.Nama[0]).show();
                        }
                        if (errors?.NamaTranslate) {
                            namaTranslateInput.addClass('is-invalid');
                            errorNamaTranslate.text(errors.NamaTranslate[0]).show();
                        }
                        if (!errors) {
                            Swal.fire('Gagal!', xhr.responseJSON?.message ??
                                'Terjadi kesalahan.', 'error');
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false).html(
                            '<i class="fa fa-save mr-1"></i> Simpan');
                    }
                });
            });

            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Subjek?',
                    html: `Apakah Anda yakin ingin menghapus subjek <strong>"${nama}"</strong>?<br><small class="text-muted">Data yang dihapus tidak bisa dikembalikan.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('subjek.destroy', ':id') }}'.replace(
                                ':id', id),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.fire('Dihapus!', res.message, 'success');
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', xhr.responseJSON?.message ??
                                    'Terjadi kesalahan.', 'error');
                            }
                        });
                    }
                });
            });

            // ========== EDIT: BUKA MODAL ==========
            $('body').on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');
                var namaTranslate = $(this).data('namatranslate') || '';

                // Isi form edit
                $('#edit_subject_id').val(id);
                $('#edit_subject_nama').val(nama);
                $('#edit_subject_nama_translate').val(namaTranslate);

                // Reset state error
                $('#edit_error_nama, #edit_error_nama_translate').hide().text('');
                $('#edit_subject_nama, #edit_subject_nama_translate').removeClass('is-invalid');

                // Buka modal
                $('#modalEditSubject').modal('show');
            });

            // ========== EDIT: SUBMIT AJAX ==========
            $('#formEditSubject').on('submit', function(e) {
                e.preventDefault();

                var btn = $('#btnEditSubmit');
                var id = $('#edit_subject_id').val();
                var namaInput = $('#edit_subject_nama');
                var namaTranslateInput = $('#edit_subject_nama_translate');
                var errorNama = $('#edit_error_nama');
                var errorNamaTranslate = $('#edit_error_nama_translate');

                // Loading state
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan...');
                namaInput.removeClass('is-invalid');
                namaTranslateInput.removeClass('is-invalid');
                errorNama.hide().text('');
                errorNamaTranslate.hide().text('');

                $.ajax({
                    url: '{{ route('subjek.update', ':id') }}'.replace(':id', id),
                    type: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    data: $(this).serialize(), // sudah termasuk @method('PUT') + @csrf
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            $('#modalEditSubject').modal('hide');
                            table.ajax.reload(null, false); // reload tanpa reset pagination
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON?.errors;
                            if (errors?.Nama) {
                                namaInput.addClass('is-invalid');
                                errorNama.text(errors.Nama[0]).show();
                            }
                            if (errors?.NamaTranslate) {
                                namaTranslateInput.addClass('is-invalid');
                                errorNamaTranslate.text(errors.NamaTranslate[0]).show();
                            }
                        } else if (xhr.status === 404) {
                            Swal.fire('Error!', 'Data tidak ditemukan.', 'error');
                            $('#modalEditSubject').modal('hide');
                            table.ajax.reload();
                        } else {
                            Swal.fire('Gagal!', xhr.responseJSON?.message ??
                                'Terjadi kesalahan.', 'error');
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false).html(
                            '<i class="fa fa-save mr-1"></i> Update');
                    }
                });
            });
            // ========== RESET MODAL WHEN CLOSED ==========
            $('#modalCreateSubject, #modalEditSubject').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').hide().text('');
            });
        });
    </script>
@endpush

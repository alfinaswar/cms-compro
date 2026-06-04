@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Kategori Berita</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Kategori Berita</li>
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
                            <i class="fa fa-tags mr-2"></i>Daftar Kategori
                        </h3>
                        <div class="ml-auto">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCreateKategori">
                                <i class="fa fa-plus mr-1"></i> Tambah Kategori
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="tableKategori" class="table table-bordered table-striped" style="width: 100%;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 5%" class="text-center">No</th>
                                    <th style="width: 45%">Nama Kategori</th>
                                    <th style="width: 30%">Slug</th>
                                    <th style="width: 20%" class="text-center">Aksi</th>
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
    <div class="modal fade" id="modalCreateKategori" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title mb-0">
                        <i class="fa fa-plus-circle mr-2"></i>Tambah Kategori Baru
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formCreateKategori">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label for="create_kategori_nama">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" id="create_kategori_nama" name="NamaKategori"
                                class="form-control @error('NamaKategori') is-invalid @enderror"
                                placeholder="Contoh: Perusahaan, Produk, Event" required autofocus>
                            <span id="create_error_msg" class="invalid-feedback d-block" style="display:none;"></span>
                            <small class="text-muted mt-1 d-block">
                                <i class="fa fa-info-circle"></i> Nama kategori harus unik.
                            </small>
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
    <div class="modal fade" id="modalEditKategori" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title mb-0">
                        <i class="fa fa-edit mr-2"></i>Edit Kategori
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditKategori">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_kategori_id" name="id">
                        <div class="form-group mb-0">
                            <label for="edit_kategori_nama">Nama Kategori <span class="text-danger">*</span></label>
                            <input type="text" id="edit_kategori_nama" name="NamaKategori" class="form-control" required>
                            <span id="edit_error_msg" class="invalid-feedback d-block" style="display:none;"></span>
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
            var table = $('#tableKategori').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('kategori-berita.index') }}"
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Memuat...</span>',
                    emptyTable: 'Tidak ada data kategori',
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
                        data: 'NamaKategori',
                        name: 'NamaKategori',
                        render: function(data) {
                            return '<strong>' + data + '</strong>';
                        }
                    },
                    {
                        data: 'Slug',
                        name: 'Slug',
                        render: function(data) {
                            return '<code class="text-muted">' + data + '</code>';
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
            $('#formCreateKategori').on('submit', function(e) {
                e.preventDefault();
                var btn = $('#btnCreateSubmit');
                var input = $('#create_kategori_nama');
                var errorMsg = $('#create_error_msg');
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan...');
                input.removeClass('is-invalid');
                errorMsg.hide().text('');
                $.ajax({
                    url: '{{ route('kategori-berita.store') }}',
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
                            $('#modalCreateKategori').modal('hide');
                            $('#formCreateKategori')[0].reset();
                            table.ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON?.errors;
                        if (errors?.NamaKategori) {
                            input.addClass('is-invalid');
                            errorMsg.text(errors.NamaKategori[0]).show();
                        } else {
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
                    title: 'Hapus Kategori?',
                    html: `Apakah Anda yakin ingin menghapus kategori <strong>"${nama}"</strong>?<br><small class="text-muted">Data yang dihapus tidak bisa dikembalikan.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('kategori-berita.destroy', ':id') }}'.replace(
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
            $('body').on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');

                $('#edit_kategori_id').val(id);
                $('#edit_kategori_nama').val(nama);
                $('#edit_error_msg').hide().text('');
                $('#edit_kategori_nama').removeClass('is-invalid');
                $('#modalEditKategori').modal('show');
            });

            // ========== EDIT: SUBMIT AJAX ==========
            $('#formEditKategori').on('submit', function(e) {
                e.preventDefault();

                var btn = $('#btnEditSubmit');
                var input = $('#edit_kategori_nama');
                var errorMsg = $('#edit_error_msg');
                var id = $('#edit_kategori_id').val();

                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Updating...');
                input.removeClass('is-invalid');
                errorMsg.hide().text('');

                $.ajax({
                    url: '{{ route('kategori-berita.update', ':id') }}'.replace(':id', id),
                    type: 'PUT',
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
                            $('#modalEditKategori').modal('hide');
                            table.ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON?.errors;
                        if (errors?.NamaKategori) {
                            input.addClass('is-invalid');
                            errorMsg.text(errors.NamaKategori[0]).show();
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
            $('#modalCreateKategori, #modalEditKategori').on('hidden.bs.modal', function() {
                $(this).find('form')[0].reset();
                $(this).find('.is-invalid').removeClass('is-invalid');
                $(this).find('.invalid-feedback').hide().text('');
            });
        });
    </script>
@endpush

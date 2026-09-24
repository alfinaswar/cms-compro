@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Email Penerima Notifikasi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Notifikasi Email</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Email Penerima Notifikasi</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#modalEmail" onclick="resetForm()">
                                    <i class="fas fa-plus"></i> Tambah Email
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tableEmail" class="table table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 35%">Email</th>
                                        <th style="width: 35%">Nama Penerima</th>
                                        <th style="width: 10%">Status</th>
                                        <th style="width: 15%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal Tambah / Edit -->
    <div class="modal fade" id="modalEmail" tabindex="-1" role="dialog" aria-labelledby="modalEmailLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="modalEmailLabel">Tambah Email Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEmail">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="id" id="emailId" value="">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="Email">Alamat Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="Email" name="Email"
                                placeholder="contoh@domain.com" required>
                            <small class="text-danger" id="error-Email"></small>
                        </div>
                        <div class="form-group">
                            <label for="Nama">Nama Penerima (Opsional)</label>
                            <input type="text" class="form-control" id="Nama" name="Nama"
                                placeholder="Contoh: Admin IT">
                            <small class="text-danger" id="error-Nama"></small>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSimpan">
                            <i class="fas fa-save"></i> Simpan
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
            // 1. Inisialisasi DataTables
            var table = $('#tableEmail').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: "{{ route('notification-email.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'Email',
                        name: 'Email'
                    },
                    {
                        data: 'Nama',
                        name: 'Nama',
                        render: function(data) {
                            return data ? data : '<span class="text-muted">-</span>';
                        }
                    },
                    {
                        data: 'Status',
                        name: 'StatusAktif',
                        className: 'text-center'
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
                ],
                // Fix footer datatables issue with layout by not using <tfoot> or by configuring dom
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "rt" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                drawCallback: function(settings) {
                    // Optionally fix any style after draw
                }
            });

            // 2. Reset Form saat modal dibuka untuk tambah
            window.resetForm = function() {
                $('#formEmail')[0].reset();
                $('#formMethod').val('POST');
                $('#emailId').val('');
                $('#modalEmailLabel').text('Tambah Email Baru');
                $('.text-danger').text('');
                $('.form-control').removeClass('is-invalid');
            };

            // 3. Handle Submit Form (Tambah / Edit)
            $('#formEmail').on('submit', function(e) {
                e.preventDefault();

                var id = $('#emailId').val();
                var method = $('#formMethod').val();
                var url = method === 'POST' ? "{{ route('notification-email.store') }}" :
                    "{{ url('notification-email') }}/" + id;
                var btn = $('#btnSimpan');

                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

                $.ajax({
                    url: url,
                    type: method === 'POST' ? 'POST' : 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#modalEmail').modal('hide');
                        table.ajax.reload(null, false); // Reload datatable tanpa reset halaman
                        Swal.fire('Berhasil!', response.message, 'success');
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $('.text-danger').text('');
                            $('.form-control').removeClass('is-invalid');

                            $.each(errors, function(key, value) {
                                $('#' + key).addClass('is-invalid');
                                $('#error-' + key).text(value[0]);
                            });
                        } else {
                            Swal.fire('Gagal!', 'Terjadi kesalahan pada server.', 'error');
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
                    }
                });
            });

            // 4. Handle Klik Edit
            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                var email = $(this).data('email');
                var nama = $(this).data('nama');

                $('#emailId').val(id);
                $('#Email').val(email);
                $('#Nama').val(nama);
                $('#formMethod').val('PUT');
                $('#modalEmailLabel').text('Edit Data Email');

                $('.text-danger').text('');
                $('.form-control').removeClass('is-invalid');
            });

            // 5. Handle Klik Hapus
            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var email = $(this).data('email');

                Swal.fire({
                    title: 'Hapus Email?',
                    html: `Apakah Anda yakin ingin menghapus email <strong>${email}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menghapus...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: "{{ url('notification-email') }}/" + id,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                table.ajax.reload(null, false);
                                Swal.fire('Dihapus!', response.message, 'success');
                            },
                            error: function() {
                                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.',
                                    'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            /* Modern Styling untuk Tabel & Card */
            .card-modern {
                background: #ffffff;
                border-radius: 12px;
                border: 1px solid #eef2f5;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
            }

            .card-header-modern {
                padding: 16px 20px;
                border-bottom: 1px solid #edf2f7;
                background: #fcfcfd;
                border-radius: 12px 12px 0 0;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .table-custom thead th {
                text-transform: uppercase;
                font-size: 11px;
                font-weight: 700;
                color: #718096;
                letter-spacing: 0.5px;
                border-bottom: 1px solid #edf2f7 !important;
                border-top: none !important;
                background-color: #fcfcfd;
                padding: 14px 16px;
            }

            .table-custom tbody td {
                vertical-align: middle !important;
                padding: 14px 16px;
                border-bottom: 1px solid #edf2f7;
                font-size: 14px;
                color: #2d3748;
            }

            .table-custom tbody tr:hover {
                background-color: #f8fafc;
            }

            .email-text {
                font-family: 'Courier New', monospace;
                font-weight: 600;
                color: #1e293b;
            }

            .btn-modern-primary {
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                color: white;
                border: none;
                border-radius: 8px;
                font-weight: 600;
                font-size: 13px;
                padding: 8px 16px;
                transition: all 0.2s;
            }

            .btn-modern-primary:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
                color: white;
            }

            /* DataTables Custom DOM spacing */
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                margin-bottom: 16px;
            }

            .dataTables_wrapper .dataTables_length select,
            .dataTables_wrapper .dataTables_filter input {
                border: 1px solid #e2e8f0;
                border-radius: 6px;
                padding: 6px 10px;
                font-size: 13px;
            }

            .dataTables_wrapper .dataTables_filter input:focus {
                border-color: #3b82f6;
                outline: none;
                box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
            }

            /* Custom Toggle Switch Styling */
            .custom-switch .custom-control-label {
                cursor: pointer;
                font-weight: 600;
                font-size: 13px;
            }

            .custom-switch .custom-control-input:checked~.custom-control-label::before {
                background-color: #10b981;
                border-color: #10b981;
            }

            .custom-switch .custom-control-input:focus~.custom-control-label::before {
                box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.25);
            }

            .custom-switch .custom-control-label::before {
                border-color: #cbd5e1;
            }

            .toggle-status {
                cursor: pointer;
            }

            /* Saat switch sedang loading */
            .toggle-switch-loading {
                opacity: 0.6;
                pointer-events: none;
            }
        </style>
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold" style="font-size: 20px; color: #1a202c;">
                        <i class="fa fa-envelope mr-2 text-primary"></i>Email Penerima Notifikasi
                    </h1>
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
                    <div class="card card-modern">
                        <div class="card-header-modern">
                            <h3 class="card-title mb-0 font-weight-bold text-dark" style="font-size: 16px;">
                                <i class="fas fa-list mr-2 text-primary"></i>Daftar Email Penerima Notifikasi
                            </h3>
                            <div class="card-tools">
                                @can('pengaturan-form-kontak.create')
                                    <button type="button" class="btn btn-modern-primary" data-toggle="modal"
                                        data-target="#modalEmail" onclick="resetForm()">
                                        <i class="fas fa-plus mr-1"></i> Tambah Email
                                    </button>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <table id="tableEmail" class="table table-custom w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 5%" class="text-center">No</th>
                                        <th style="width: 35%">Alamat Email</th>
                                        <th style="width: 35%">Nama Penerima</th>
                                        <th style="width: 10%" class="text-center">Status</th>
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold" id="modalEmailLabel">
                        <i class="fas fa-envelope mr-2"></i>Tambah Email Baru
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEmail">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" name="id" id="emailId" value="">

                    <div class="modal-body p-4">
                        <div class="form-group">
                            <label for="Email" class="font-weight-bold text-dark">Alamat Email <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i
                                            class="fas fa-at text-muted"></i></span>
                                </div>
                                <input type="email" class="form-control border-left-0" id="Email" name="Email"
                                    placeholder="contoh@domain.com" required>
                            </div>
                            <small class="text-danger" id="error-Email"></small>
                        </div>
                        <div class="form-group mb-0">
                            <label for="Nama" class="font-weight-bold text-dark">Nama Penerima <small
                                    class="text-muted font-weight-normal">(Opsional)</small></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light border-right-0"><i
                                            class="fas fa-user text-muted"></i></span>
                                </div>
                                <input type="text" class="form-control border-left-0" id="Nama" name="Nama"
                                    placeholder="Contoh: Admin IT">
                            </div>
                            <small class="text-danger" id="error-Nama"></small>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 px-4 pb-4">
                        <button type="button" class="btn btn-light border" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4" id="btnSimpan">
                            <i class="fas fa-save mr-1"></i> Simpan
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
                        name: 'Email',
                        render: function(data) {
                            return '<span class="email-text">' + data + '</span>';
                        }
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
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "rt" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        next: '<i class="fas fa-chevron-right"></i>',
                        previous: '<i class="fas fa-chevron-left"></i>'
                    }
                }
            });

            // 2. Reset Form saat modal dibuka untuk tambah
            window.resetForm = function() {
                $('#formEmail')[0].reset();
                $('#formMethod').val('POST');
                $('#emailId').val('');
                $('#modalEmailLabel').html('<i class="fas fa-envelope mr-2"></i>Tambah Email Baru');
                $('.text-danger').text('');
                $('.form-control').removeClass('is-invalid');
            };

            // 3. Handle Submit Form (Tambah / Edit)
            $('#formEmail').on('submit', function(e) {
                e.preventDefault();

                var id = $('#emailId').val();
                var method = $('#formMethod').val();

                // ✅ PERBAIKAN: Gunakan replace untuk menyisipkan ID ke dalam route helper
                var url = method === 'POST' ?
                    "{{ route('notification-email.store') }}" :
                    "{{ route('notification-email.update', ':id') }}".replace(':id', id);

                var btn = $('#btnSimpan');
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');

                $.ajax({
                    url: url,
                    type: method === 'POST' ? 'POST' : 'PUT',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#modalEmail').modal('hide');

                        setTimeout(function() {
                            table.ajax.reload(null, false);
                        }, 500);

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
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
                        btn.prop('disabled', false).html(
                            '<i class="fas fa-save mr-1"></i> Simpan');
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
                $('#modalEmailLabel').html('<i class="fas fa-edit mr-2"></i>Edit Data Email');

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
                    cancelButtonText: 'Batal',
                    reverseButtons: true
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
                            url: "{{ route('notification-email.destroy', ['id' => ':id']) }}"
                                .replace(':id', id),


                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                table.ajax.reload(null, false);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Dihapus!',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            },
                            error: function() {
                                Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus.',
                                    'error');
                            }
                        });
                    }
                });
            });
            // 6. Handle Toggle Status (Aktif/Nonaktif)
            $(document).on('change', '.toggle-status', function(e) {
                var checkbox = $(this);
                var id = checkbox.data('id');
                var newStatus = checkbox.is(':checked');
                var label = $('.status-label-' + id);
                var statusText = newStatus ? 'Aktifkan' : 'Nonaktifkan';

                // Kembalikan ke value sebelumnya sampai user konfirmasi
                checkbox.prop('checked', !newStatus);

                Swal.fire({
                    title: `Konfirmasi Ubah Status`,
                    html: `Anda yakin ingin <b>${statusText}</b> email notifikasi ini?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: `Ya, ${statusText}`,
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Set ke value baru setelah konfirmasi, dan tampilkan loading visual
                        checkbox.prop('checked', newStatus);
                        checkbox.closest('.custom-control').addClass('toggle-switch-loading');

                        $.ajax({
                            url: "{{ route('notification-email.toggle-status', ':id') }}"
                                .replace(':id', id),
                            type: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                // Update label teks
                                label.text(newStatus ? 'Aktif' : 'Nonaktif');
                                checkbox.closest('.custom-control').removeClass(
                                    'toggle-switch-loading');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Status diubah',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                            },
                            error: function(xhr) {
                                // Kembalikan ke status semula jika gagal
                                checkbox.prop('checked', !newStatus);
                                label.text(!newStatus ? 'Aktif' : 'Nonaktif');
                                checkbox.closest('.custom-control').removeClass(
                                    'toggle-switch-loading');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON?.message ||
                                        'Gagal mengubah status',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

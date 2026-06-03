@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Role</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        {{-- @can('role-create') --}}
        <div class="row mb-3">
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('roles.create') }}">
                    <i class="fa fa-plus me-2"></i> Tambah Role
                </a>
            </div>
        </div>
        {{-- @endcan --}}

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Data Role / Hak Akses Sistem</h3>
                    </div>
                    <div class="card-body">
                        <table id="tableRoles" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Role</th>
                                    <th width="200px" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @if (Session::get('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ Session::get('success') }}',
                iconColor: '#4BCC1F',
                confirmButtonText: 'Oke',
                confirmButtonColor: '#4BCC1F',
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            function loadDataTable() {
                $('#tableRoles').DataTable({
                    responsive: true,
                    serverSide: true,
                    processing: true,
                    bDestroy: true,
                    ajax: {
                        url: "{{ route('roles.index') }}",
                    },
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Memuat...</span>',
                        paginate: {
                            next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                            previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                        },
                        emptyTable: 'Tidak ada data role yang tersedia',
                        info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                        infoFiltered: '(difilter dari _MAX_ total entri)',
                        search: 'Cari:',
                        lengthMenu: 'Tampilkan _MENU_ entri',
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        }
                    ]
                });
            }

            // Delete dengan SweetAlert2 + AJAX
            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var roleName = $(this).data('name');

                Swal.fire({
                    title: 'Hapus Role?',
                    text: `Apakah Anda yakin ingin menghapus role "${roleName}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('roles.destroy', ':id') }}'.replace(':id', id),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status === 200) {
                                    Swal.fire('Dihapus!', response.message, 'success');
                                    $('#tableRoles').DataTable().ajax.reload();
                                } else {
                                    Swal.fire('Gagal!', response.message, 'error');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', xhr.responseJSON?.message ??
                                    'Terjadi kesalahan saat menghapus.', 'error');
                            }
                        });
                    }
                });
            });

            loadDataTable();
        });
    </script>
@endpush

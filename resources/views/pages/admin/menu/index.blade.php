@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Menu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Menu</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row mb-3">
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('menu.create') }}">
                    <i class="fa fa-plus mr-2"></i> Tambah Menu
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-bars mr-2"></i> Daftar Menu
                        </h3>
                    </div>
                    <div class="card-body">
                        <table id="tableMenu" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Menu</th>
                                    <th>Link</th>
                                    <th>Posisi</th>
                                    <th>Urutan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
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
            // Delete Handler
            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Menu?',
                    text: "Semua sub-menu di bawahnya juga akan terhapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('menu.destroy', ':id') }}'.replace(':id', id),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status === 200) {
                                    Swal.fire('Dihapus!', response.message, 'success');
                                    $('#tableMenu').DataTable().ajax.reload();
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', xhr.responseJSON?.message ??
                                    'Terjadi kesalahan', 'error');
                            }
                        });
                    }
                });
            });

            // Order Handler
            $('body').on('click', '.btn-up, .btn-down', function() {
                var id = $(this).data('id');
                var direction = $(this).hasClass('btn-up') ? 'up' : 'down';

                $.ajax({
                    url: '{{ route('menu.update-order') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id,
                        direction: direction
                    },
                    success: function(response) {
                        if (response.status === 200) {
                            $('#tableMenu').DataTable().ajax.reload();
                        }
                    }
                });
            });

            // DataTables
            $('#tableMenu').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: "{{ route('menu.index') }}",
                order: [
                    [4, 'asc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'NamaMenuDisplay',
                        name: 'NamaMenu',
                        orderable: false
                    },
                    {
                        data: 'LinkDisplay',
                        name: 'JenisLink',
                        orderable: false
                    },
                    {
                        data: 'PosisiBadge',
                        name: 'Posisi',
                        orderable: false
                    },
                    {
                        data: 'Urutan',
                        name: 'Urutan'
                    },
                    {
                        data: 'StatusBadge',
                        name: 'StatusAktif',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush

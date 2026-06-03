@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Lowongan Kerja</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Lowongan Kerja</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row mb-3">
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('karir.create') }}">
                    <i class="fa fa-plus mr-2"></i> Tambah Lowongan
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Data Lowongan Kerja</h3>
                    </div>
                    <div class="card-body">
                        <table id="tableLowongan" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Posisi</th>
                                    <th>Kota</th>
                                    <th>Deskripsi</th>
                                    <th>Batas Waktu</th>
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
                    title: 'Hapus Lowongan?',
                    text: "Data akan dipindahkan ke tempat sampah (soft delete).",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('karir.destroy', ':id') }}'.replace(':id',
                                id),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status === 200) {
                                    Swal.fire('Dihapus!', response.message, 'success');
                                    $('#tableLowongan').DataTable().ajax.reload();
                                } else {
                                    Swal.fire('Gagal!', response.message, 'error');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Gagal!',
                                    xhr.responseJSON?.message ??
                                    'Terjadi kesalahan saat menghapus.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            // DataTables
            $('#tableLowongan').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('karir.index') }}"
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Memuat...</span>',
                    paginate: {
                        next: '<i class="fa fa-angle-double-right"></i>',
                        previous: '<i class="fa fa-angle-double-left"></i>'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'Posisi',
                        name: 'Posisi'
                    },
                    {
                        data: 'Kota',
                        name: 'Kota'
                    },
                    {
                        data: 'DeskripsiSingkat',
                        name: 'Deskripsi',
                        orderable: false
                    },
                    {
                        data: 'BatasWaktuFormatted',
                        name: 'BatasWaktu'
                    },
                    {
                        data: 'StatusBadge',
                        name: 'Status',
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

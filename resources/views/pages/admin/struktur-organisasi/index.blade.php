@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Struktur Organisasi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Struktur Organisasi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row mb-3">
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('struktur-organisasi.create') }}">
                    <i class="fa fa-plus mr-2"></i> Tambah Section Baru
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Section Struktur</h3>
                    </div>
                    <div class="card-body">
                        <table id="tableStruktur" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Section</th>
                                    <th>Gambar Header</th>
                                    <th>Jumlah Anggota</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
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
    <script>
        $(document).ready(function() {
            // ========== MAIN TABLE (SECTIONS) ==========
            var table = $('#tableStruktur').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('struktur-organisasi.index') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'JudulSection',
                        name: 'JudulSection'
                    },
                    {
                        data: 'GambarHeader',
                        name: 'PathGambarHeader',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'JumlahAnggota',
                        name: 'JumlahAnggota',
                        orderable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'StatusBadge',
                        name: 'Status',
                        orderable: false,
                        className: 'text-center'
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

            // Delete Section
            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Section?',
                    text: "Semua anggota di section ini juga akan terhapus.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('struktur-organisasi.destroy', ':id') }}'
                                .replace(':id', id),
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
                                    'Error', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Solusi</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Solusi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row mb-3">
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('halaman-solusi.create') }}">
                    <i class="fa fa-plus mr-2"></i> Tambah Solusi Baru
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Halaman Solusi</h3>
                    </div>
                    <div class="card-body">
                        {{-- ✅ Wrapper responsive (ganti fitur responsive DataTables) --}}
                        <div class="table-responsive">
                            <table id="tableHalamanSolusi" class="table table-bordered table-striped" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;" class="text-center"></th>
                                        <th style="width: 40px;" class="text-center">No</th>
                                        <th>Judul</th>
                                        <th>Slug</th>
                                        <th>Konten</th>
                                        <th style="width: 100px;" class="text-center">Status</th>
                                        <th style="width: 120px;" class="text-center">Aksi</th>
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
@endsection

@push('styles')
    <style>
        /* Animasi icon chevron saat expand */
        .btn-detail-toggle i {
            transition: transform 0.2s ease;
        }

        .btn-detail-toggle.open i {
            transform: rotate(180deg);
        }

        /* Rapikan padding child row DataTables */
        table.dataTable tbody tr.child td.child {
            padding: 0 !important;
            background: #fcfcfd;
        }
    </style>
@endpush

@push('scripts')
    @if (Session::get('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ Session::get('success') }}',
                iconColor: '#4BCC1F',
                confirmButtonColor: '#4BCC1F'
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            var table = $('#tableHalamanSolusi').DataTable({
                // ⚠️ responsive: true DIMATIKAN agar tidak bentrok dengan child row detail
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('halaman-solusi.index') }}"
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    search: 'Cari:',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    infoEmpty: 'Menampilkan 0 sampai 0 dari 0 data',
                    infoFiltered: '(disaring dari total _MAX_ data)',
                    zeroRecords: 'Tidak ada data yang cocok',
                    emptyTable: 'Tidak ada data tersedia',
                    paginate: {
                        next: 'Selanjutnya',
                        previous: 'Sebelumnya'
                    }
                },
                columns: [{
                        data: 'Toggle',
                        name: 'Toggle',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'Judul',
                        name: 'Judul'
                    },
                    {
                        data: 'Slug',
                        name: 'Slug'
                    },
                    {
                        data: 'Konten',
                        name: 'Konten',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'Status',
                        name: 'IsPublished',
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

            // ✅ TOGGLE DETAIL ROW
            $('#tableHalamanSolusi tbody').on('click', '.btn-detail-toggle', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var btn = $(this);

                if (row.child.isShown()) {
                    // Tutup detail
                    row.child.hide();
                    btn.removeClass('open btn-primary text-white').addClass('btn-light');
                } else {
                    // Buka detail — ambil HTML dari data row (kolom DetailHtml)
                    row.child(row.data().DetailHtml).show();
                    btn.removeClass('btn-light').addClass('open btn-primary text-white');
                }
            });

            // Hapus Data
            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Halaman Solusi?',
                    text: "Data akan dihapus secara permanen.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('halaman-solusi.destroy', ':id') }}'.replace(
                                ':id', id),
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                if (response.status === 200) {
                                    Swal.fire('Dihapus!', response.message, 'success');
                                    table.ajax.reload();
                                } else {
                                    Swal.fire('Gagal!', response.message, 'error');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', xhr.responseJSON?.message ??
                                    'Terjadi kesalahan.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

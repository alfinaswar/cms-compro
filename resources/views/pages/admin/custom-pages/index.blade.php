@extends('layouts.app')

@push('styles')
    <style>
        /* Kostumisasi Tampilan Sesuai Gambar Referensi */
        .card-filter {
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #eef2f5;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
        }

        .form-control-custom {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            height: 42px;
            font-size: 13px;
            color: #4a5568;
        }

        .form-control-custom:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
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
            padding: 16px;
            border-bottom: 1px solid #edf2f7;
            font-size: 13px;
            color: #2d3748;
        }

        /* Sembunyikan elemen bawaan DataTable agar bisa diganti dengan Custom Toolbar */
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length {
            display: none !important;
        }

        .dataTables_wrapper .dataTables_info {
            font-size: 13px;
            color: #718096;
            padding-top: 15px;
        }

        .pagination .page-item .page-link {
            border-radius: 6px !important;
            margin: 0 2px;
            color: #4a5568;
            border: 1px solid #e2e8f0;
            font-size: 13px;
        }

        .pagination .page-item.active .page-link {
            background-color: #2563eb;
            border-color: #2563eb;
            color: #fff;
        }

        .btn-custom-primary {
            background-color: #2563eb;
            border-color: #2563eb;
            color: white;
            border-radius: 8px;
            font-weight: 500;
            font-size: 13px;
            padding: 10px 20px;
            transition: all 0.2s;
        }

        .btn-custom-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
            color: white;
        }
    </style>
@endpush

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold" style="font-size: 20px; color: #1a202c;">Manajemen Halaman Custom</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a class="btn btn-custom-primary px-4 py-2" href="{{ route('custom-pages.create') }}">
                        <i class="fa fa-plus mr-2"></i> Tambah Halaman Baru
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-filter p-3 mb-4">
                <!-- Filter Toolbar / Header Control -->
                <div class="row align-items-center">
                    <!-- Search Input -->
                    <div class="col-md-5 mb-3 mb-md-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0"
                                    style="border-radius: 8px 0 0 8px; border-color: #e2e8f0;">
                                    <i class="fa fa-search text-muted"></i>
                                </span>
                            </div>
                            <input type="text" id="customSearch" class="form-control form-control-custom border-left-0"
                                placeholder="Cari judul halaman..." style="border-radius: 0 8px 8px 0;">
                        </div>
                    </div>

                    <!-- Filter Status -->
                    <div class="col-md-3 mb-3 mb-md-0">
                        <select id="filterStatus" class="form-control form-control-custom">
                            <option value="">Semua Status</option>
                            <option value="Diterbitkan">Diterbitkan</option>
                            <option value="Draf">Draf</option>
                        </select>
                    </div>

                    <!-- Length Menu (Show entries) -->
                    <div class="col-md-4 d-flex align-items-center justify-content-md-end">
                        <span class="text-muted mr-2" style="font-size: 13px; white-space: nowrap;">Tampilkan:</span>
                        <select id="customLength" class="form-control form-control-custom" style="width: 110px;">
                            <option value="10">10 Data</option>
                            <option value="25">25 Data</option>
                            <option value="50">50 Data</option>
                            <option value="100">100 Data</option>
                        </select>
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="table-responsive mt-3">
                    <table id="tableCustomPages" class="table table-custom w-100">
                        <thead>
                            <tr>
                                <th style="width: 40px;">NO</th>
                                <th style="width: 100px;">THUMBNAIL</th>
                                <th>JUDUL HALAMAN (HIERARKI)</th>
                                <th style="width: 120px;">TANGGAL</th>
                                <th style="width: 100px;">STATUS</th>
                                <th style="width: 110px; text-align: center;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
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
                iconColor: '#10b981',
                confirmButtonColor: '#10b981'
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            var table = $('#tableCustomPages').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('custom-pages.index') }}",
                    data: function(d) {
                        d.status = $('#filterStatus').val();
                    }
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw text-primary"></i>',
                    info: "Menampilkan <b>_START_</b> sampai <b>_END_</b> dari <b>_TOTAL_</b> data",
                    paginate: {
                        next: '<i class="fa fa-chevron-right"></i>',
                        previous: '<i class="fa fa-chevron-left"></i>'
                    },
                    search: "",
                    lengthMenu: ""
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'Thumbnail',
                        name: 'Thumbnail',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'JudulDisplay',
                        name: 'Judul',
                        orderable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            if (!data) return '-';
                            // Format tanggal Indonesia
                            let date = new Date(data);
                            return date.toLocaleDateString('id-ID', {
                                day: 'numeric',
                                month: 'short',
                                year: 'numeric'
                            });
                        }
                    },
                    {
                        data: 'StatusBadge',
                        name: 'IsPublished',
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
                ],
                // Urutan default berdasarkan kolom Tanggal (index 3) descending
                order: [
                    [3, 'desc']
                ]
            });

            // Trigger Pencarian Custom Input
            $('#customSearch').keyup(function() {
                table.search($(this).val()).draw();
            });

            // Trigger Filter Dropdown
            $('#filterStatus').change(function() {
                table.draw();
            });

            // Trigger Custom Length Menu
            $('#customLength').change(function() {
                table.page.len($(this).val()).draw();
            });

            // Hapus Data via AJAX
            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Halaman?',
                    html: `Apakah Anda yakin ingin menghapus <strong>${nama}</strong>?<br><small class="text-muted">Sub-halaman di bawahnya harus dihapus terlebih dahulu.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#ef4444'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('custom-pages.destroy', ':id') }}'.replace(':id',
                                id),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status === 200) {
                                    Swal.fire('Dihapus!', response.message, 'success');
                                    table.ajax.reload();
                                } else {
                                    Swal.fire('Gagal!', response.message ||
                                        'Terjadi kesalahan.', 'error');
                                }
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', xhr.responseJSON?.message ||
                                    'Terjadi kesalahan pada server.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

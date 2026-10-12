@extends('layouts.app')

@push('styles')
    <style>
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
            cursor: pointer;
            user-select: none;
        }

        .table-custom thead th.sorting,
        .table-custom thead th.sorting_asc,
        .table-custom thead th.sorting_desc {
            position: relative;
            padding-right: 24px !important;
        }

        .table-custom thead th.sorting:after,
        .table-custom thead th.sorting_asc:after,
        .table-custom thead th.sorting_desc:after {
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            color: #a0aec0;
        }

        .table-custom thead th.sorting:after {
            content: "\f0dc";
        }

        .table-custom thead th.sorting_asc:after {
            content: "\f0de";
        }

        .table-custom thead th.sorting_desc:after {
            content: "\f0dd";
        }

        .table-custom tbody td {
            vertical-align: middle !important;
            padding: 16px;
            border-bottom: 1px solid #edf2f7;
            font-size: 13px;
        }

        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length {
            display: none;
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
    </style>
@endpush

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bold" style="font-size: 20px; color: #1a202c;">
                        List Berita
                    </h1>
                </div>
                <div class="col-sm-6 text-right">
                    @can('berita.create')
                        <a class="btn btn-primary px-4 py-2" href="{{ route('berita.create') }}"
                            style="border-radius: 8px; font-weight: 500;">
                            <i class="fa fa-plus mr-2"></i> Tulis Berita
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-filter p-3 mb-4">
                <!-- Toolbar Filter & Controls -->
                <div class="row align-items-center">
                    <!-- Search -->
                    <div class="col-md-4 mb-2 mb-md-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0"
                                    style="border-radius: 8px 0 0 8px; border-color: #e2e8f0;">
                                    <i class="fa fa-search text-muted"></i>
                                </span>
                            </div>
                            <input type="text" id="customSearch" class="form-control form-control-custom border-left-0"
                                placeholder="Cari berita..." style="border-radius: 0 8px 8px 0;">
                        </div>
                    </div>
                    <!-- Filter Kategori -->
                    <div class="col-md-2 mb-2 mb-md-0">
                        <select id="filterKategori" class="form-control form-control-custom">
                            <option value="">Semua Kategori</option>
                            @foreach ($kategori ?? [] as $k)
                                <option value="{{ $k->id }}">{{ $k->NamaKategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Filter Status -->
                    <div class="col-md-2 mb-2 mb-md-0">
                        <select id="filterStatus" class="form-control form-control-custom">
                            <option value="">Semua Status</option>
                            <option value="Draf">Draf</option>
                            <option value="Diterbitkan">Terbit</option>
                        </select>
                    </div>
                    <!-- Show Entries -->
                    <div class="col-md-2 mb-2 mb-md-0 d-flex align-items-center">
                        <span class="text-muted mr-2" style="font-size: 13px; white-space: nowrap;">Show</span>
                        <select id="customLength" class="form-control form-control-custom" style="width: 90px;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>

                <!-- Tabel List Berita -->
                <div class="table-responsive mt-3">
                    <table id="tableBerita" class="table table-custom w-100">
                        <thead>
                            <tr>
                                <th style="width: 40px;" class="no-sort">No</th>
                                <th style="width: 90px;" class="no-sort">Thumb</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Tags</th>
                                <th>Tanggal Terbit</th>
                                <th>Status</th>
                                <th style="width: 80px;" class="no-sort">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        {{-- <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Thumb</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Tags</th>
                                <th>Tanggal Terbit</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot> --}}
                    </table>
                    <!-- Pagination handled by DataTable, but can place manual fallback here if needed -->
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
                confirmButtonColor: '#4BCC1F'
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            var table = $('#tableBerita').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('berita.index') }}",
                    data: function(d) {
                        d.kategori = $('#filterKategori').val();
                        d.status = $('#filterStatus').val();
                    }
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw text-primary"></i>',
                    info: "Menampilkan <b>_START_</b> sampai <b>_END_</b> dari <b>_TOTAL_</b> data (disaring dari total _MAX_ berita)",
                    paginate: {
                        next: 'Selanjutnya',
                        previous: 'Sebelumnya'
                    }
                },
                columns: [{
                        // NO (auto number)
                        data: null,
                        name: 'no',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'Thumbnail',
                        name: 'PathThumbnail',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'Judul',
                        name: 'Judul',
                        orderable: true // bisa sort
                    },
                    {
                        data: 'Kategori',
                        name: 'Kategori',
                        orderable: true // bisa sort
                    },
                    {
                        data: 'Tags',
                        name: 'Tags',
                        orderable: false
                    },
                    {
                        data: 'TanggalPublikasi',
                        name: 'created_at',
                        orderable: true // bisa sort
                    },
                    {
                        data: 'StatusBadge',
                        name: 'Status',
                        orderable: true // bisa sort
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                // Index column for "NO"
                order: [
                    [5, 'desc']
                ],
                columnDefs: [{
                    targets: [0, 1, 7],
                    orderable: false
                }],
                drawCallback: function(settings) {
                    var api = this.api();
                    api.column(0, {
                        search: 'applied',
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        var pageInfo = api.page.info();
                        cell.innerHTML = pageInfo.start + i + 1;
                    });
                },
                // Enable the tfoot for DataTable pagination/footer
                initComplete: function(settings, json) {
                    // No special logic
                }
            });

            // Trigger Pencarian Custom Input
            $('#customSearch').keyup(function() {
                table.search($(this).val()).draw();
            });

            // Trigger Filter Dropdown
            $('#filterKategori, #filterStatus').change(function() {
                table.draw();
            });

            // Trigger Custom Length Menu
            $('#customLength').change(function() {
                table.page.len($(this).val()).draw();
            });

            // Table header sorting visual cue (optional if you need to highlight sort)
            $('#tableBerita thead').on('click', 'th', function() {
                var colIdx = $(this).index();
                // Only trigger if sortable (do not trigger for non-sortable columns)
                if (!$(this).hasClass("no-sort") && table.settings()[0].aoColumns[colIdx].bSortable) {
                    table.order([colIdx, table.order()[0] && table.order()[0][0] === colIdx && table
                    .order()[0][1] === 'asc' ? 'desc' : 'asc'
                    ]).draw();
                }
            });

            // Hapus Data via AJAX
            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Berita?',
                    text: "Data akan dipindahkan ke tempat sampah.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('berita.destroy', ':id') }}'.replace(':id', id),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
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

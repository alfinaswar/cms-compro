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
        }

        /* Sembunyikan elemen bawaan DataTable agar bisa diganti dengan Custom Toolbar */
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
                    <h1 class="m-0 font-weight-bold" style="font-size: 20px; color: #1a202c;">Manajemen Berita / News</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a class="btn btn-primary px-4 py-2" href="{{ route('berita.create') }}"
                        style="border-radius: 8px; font-weight: 500;">
                        <i class="fa fa-plus mr-2"></i> Tulis Berita Baru
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-filter p-3 mb-4">
                <!-- Filter Toolbar / Header Control (Sesuai Referensi Gambar) -->
                <div class="row align-items-center">
                    <!-- Search Input -->
                    <div class="col-md-5 mb-2 mb-md-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-right-0"
                                    style="border-radius: 8px 0 0 8px; border-color: #e2e8f0;">
                                    <i class="fa fa-search text-muted"></i>
                                </span>
                            </div>
                            <input type="text" id="customSearch" class="form-control form-control-custom border-left-0"
                                placeholder="Cari judul berita, tag, atau kategori..." style="border-radius: 0 8px 8px 0;">
                        </div>
                    </div>

                    <!-- Filter Kategori -->
                    <div class="col-md-2 mb-2 mb-md-0">
                        <select id="filterKategori" class="form-control form-control-custom">
                            <option value="">Semua Kategori</option>
                            <option value="IHSG">IHSG</option>
                            <option value="Inovasi Produk">Inovasi Produk</option>
                            <option value="Teknologi">Teknologi</option>
                            <option value="Investor Relation">Investor Relation</option>
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

                    <!-- Length Menu (Show entries) -->
                    <div class="col-md-3 d-flex align-items-center justify-content-md-end">
                        <span class="text-muted mr-2" style="font-size: 13px; white-space: nowrap;">Tampilkan:</span>
                        <select id="customLength" class="form-control form-control-custom" style="width: 100px;">
                            <option value="10">10 Data</option>
                            <option value="25">25 Data</option>
                            <option value="50">50 Data</option>
                            <option value="100">100 Data</option>
                        </select>
                    </div>
                </div>

                <!-- Tabel Data -->
                <div class="table-responsive mt-3">
                    <table id="tableBerita" class="table table-custom w-100">
                        <thead>
                            <tr>
                                <th style="width: 90px;">IMAGE FEATURED</th>
                                <th>JUDUL BERITA</th>
                                <th>KATEGORI</th>
                                <th>TAGS</th>
                                <th>TANGGAL</th>
                                <th>STATUS</th>
                                <th style="width: 80px;">AKSI</th>
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
                        data: 'Thumbnail',
                        name: 'PathThumbnail',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'Judul',
                        name: 'Judul'
                    },
                    {
                        data: 'Kategori',
                        name: 'Kategori',
                        orderable: false
                    },
                    {
                        data: 'Tags',
                        name: 'Tags',
                        orderable: false
                    },
                    {
                        data: 'TanggalPublikasi',
                        name: 'created_at'
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

            // Trigger Pencarian Custom Input
            $('#customSearch').keyup(function() {
                table.search($(this).val()).draw();
            });

            // Trigger Filter Dropdown
            $('#filterKategori, #filterStatus').change(function() {
                table.draw();
            });

            // Trigger Custom Length Menu (10, 25, 50 Data)
            $('#customLength').change(function() {
                table.page.len($(this).val()).draw();
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

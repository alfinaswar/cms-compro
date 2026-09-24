@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            /* ============================================
                                               MODERN CARD REDESIGN (Tanpa mengganggu DataTables)
                                               ============================================ */

            :root {
                --accent-blue: #3b82f6;
                --accent-cyan: #06b6d4;
                --accent-green: #10b981;
                --accent-orange: #f59e0b;
                --accent-purple: #8b5cf6;
                --bg-soft: #f8fafc;
                --border-soft: #e2e8f0;
            }

            /* Page Header Modern */
            .page-header-modern {
                background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
                border-radius: 12px;
                padding: 20px 24px;
                margin-bottom: 24px;
                color: #fff;
                box-shadow: 0 4px 12px rgba(30, 41, 59, 0.15);
            }

            .page-header-modern h1 {
                font-size: 22px;
                font-weight: 700;
                margin: 0;
                color: #fff;
            }

            .page-header-modern .breadcrumb {
                background: transparent;
                padding: 0;
                margin: 8px 0 0 0;
            }

            .page-header-modern .breadcrumb-item,
            .page-header-modern .breadcrumb-item a {
                color: rgba(255, 255, 255, 0.7);
                font-size: 13px;
            }

            .page-header-modern .breadcrumb-item.active {
                color: #fff;
            }

            /* Modern Card dengan Border Accent */
            .card-modern {
                background: #fff;
                border-radius: 12px;
                border: 1px solid var(--border-soft);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
                margin-bottom: 24px;
                overflow: hidden;
                transition: all 0.2s ease;
            }

            .card-modern:hover {
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            }

            .card-modern.border-accent-blue {
                border-top: 4px solid var(--accent-blue);
            }

            .card-modern.border-accent-cyan {
                border-top: 4px solid var(--accent-cyan);
            }

            .card-modern.border-accent-green {
                border-top: 4px solid var(--accent-green);
            }

            .card-modern.border-accent-orange {
                border-top: 4px solid var(--accent-orange);
            }

            .card-modern.border-accent-purple {
                border-top: 4px solid var(--accent-purple);
            }

            /* Card Header Modern */
            .card-header-modern {
                padding: 20px 24px;
                border-bottom: 1px solid var(--border-soft);
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                background: #fff;
            }

            .card-header-left {
                display: flex;
                align-items: center;
                gap: 16px;
            }

            .card-header-icon {
                width: 48px;
                height: 48px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 22px;
                flex-shrink: 0;
            }

            .card-header-icon.bg-blue {
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                color: #fff;
            }

            .card-header-icon.bg-cyan {
                background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
                color: #fff;
            }

            .card-header-icon.bg-green {
                background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                color: #fff;
            }

            .card-header-icon.bg-orange {
                background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                color: #fff;
            }

            .card-header-icon.bg-purple {
                background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
                color: #fff;
            }

            .card-header-info h3 {
                font-size: 16px;
                font-weight: 700;
                color: #1e293b;
                margin: 0;
            }

            .card-header-info p {
                font-size: 13px;
                color: #64748b;
                margin: 2px 0 0;
            }

            .badge-counter {
                background: #e0f2fe;
                color: #0284c7;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                margin-left: 8px;
            }

            /* Modern Button */
            .btn-modern {
                padding: 10px 20px;
                border-radius: 8px;
                font-weight: 600;
                font-size: 13px;
                border: none;
                transition: all 0.2s ease;
                display: inline-flex;
                align-items: center;
                gap: 6px;
                text-decoration: none;
            }

            .btn-modern-primary {
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                color: #fff;
            }

            .btn-modern-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 16px rgba(59, 130, 246, 0.35);
                color: #fff;
                text-decoration: none;
            }

            /* Card Body untuk Table */
            .card-body-table {
                padding: 20px 24px;
            }

            /* Override DataTables agar lebih rapi di card modern */
            .card-body-table .dataTables_wrapper .dataTables_length,
            .card-body-table .dataTables_wrapper .dataTables_filter {
                margin-bottom: 16px;
            }

            .card-body-table .dataTables_wrapper .dataTables_length select,
            .card-body-table .dataTables_wrapper .dataTables_filter input {
                border: 2px solid var(--border-soft);
                border-radius: 8px;
                padding: 6px 10px;
                font-size: 13px;
            }

            .card-body-table .dataTables_wrapper .dataTables_filter input:focus {
                border-color: var(--accent-blue);
                outline: none;
            }

            .card-body-table .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: var(--accent-blue) !important;
                color: #fff !important;
                border: none !important;
                border-radius: 6px;
            }
        </style>
    @endpush

    {{-- ============================================
     PAGE HEADER MODERN
     ============================================ --}}
    {{-- <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fa fa-palette mr-2"></i>Manajemen Landing Page</h1>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Landing Page</li>
                </ol>
            </div>
        </div>
    </div> --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen portal web - Homepage</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Homepage</li>
                    </ol>
                </div>
            </div>
        </div>

    </section>
    <section class="content">
        <div class="container-fluid">

            {{-- ============================================
             HERO SLIDER - TETAP PAKAI TABLE, CARD MODERN
             ============================================ --}}
            <div class="card-modern border-accent-blue">
                <div class="card-header-modern">
                    <div class="card-header-left">
                        <div class="card-header-icon bg-blue">
                            <i class="fa fa-images"></i>
                        </div>
                        <div class="card-header-info">
                            <h3>Daftar Hero Slider <span class="badge-counter">Slide Utama</span></h3>
                            <p>Media visual utama gerbang portal: video manufaktur sekuriti dan visual paspor biometrik.</p>
                        </div>
                    </div>
                    <a href="{{ route('hero-slider.create') }}" class="btn-modern btn-modern-primary">
                        <i class="fa fa-plus"></i> Tambah Slide
                    </a>
                </div>

                <div class="card-body-table">
                    {{-- ⚠️ STRUKTUR TABLE TIDAK DIUBAH --}}
                    <table id="tableHeroSlider" class="table table-bordered table-striped table-hover" style="width: 100%;">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 5%" class="text-center">No</th>
                                <th style="width: 10%" class="text-center">Tipe</th>
                                <th style="width: 25%">Judul Utama</th>
                                <th style="width: 20%">Deskripsi</th>
                                <th style="width: 10%" class="text-center">Preview</th>
                                <th style="width: 8%" class="text-center">Urutan</th>
                                <th style="width: 10%" class="text-center">Status</th>
                                <th style="width: 12%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            {{-- ============================================
             KEY FIGURE
             ============================================ --}}
            <div class="card-modern border-accent-cyan">
                <div class="card-header-modern">
                    <div class="card-header-left">
                        <div class="card-header-icon bg-cyan">
                            <i class="fa fa-chart-line"></i>
                        </div>
                        <div class="card-header-info">
                            <h3>Key Figures & Metrik Kredibilitas</h3>
                            <p>Tabel metrik pencapaian strategis pembukti kapasitas di bawah banner utama.</p>
                        </div>
                    </div>
                    <a href="{{ route('pengaturan-key-figure.create') }}" class="btn-modern btn-modern-primary">
                        <i class="fa fa-plus"></i> Tambah Key Figure
                    </a>
                </div>

                <div class="card-body-table">
                    {{-- ⚠️ STRUKTUR TABLE TIDAK DIUBAH --}}
                    <table id="tableKeyfigure" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 5%" class="text-center">No</th>
                                <th style="width: 35%">Konten</th>
                                <th style="width: 40%">Keterangan</th>
                                <th style="width: 15%">Icon</th>
                                <th style="width: 10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            {{-- ============================================
             HALAMAN SOLUSI
             ============================================ --}}
            <div class="card-modern border-accent-green">
                <div class="card-header-modern">
                    <div class="card-header-left">
                        <div class="card-header-icon bg-green">
                            <i class="fa fa-lightbulb"></i>
                        </div>
                        <div class="card-header-info">
                            <h3>Daftar Halaman Solusi</h3>
                            <p>Manajemen produk & layanan yang ditawarkan perusahaan.</p>
                        </div>
                    </div>
                    <a href="{{ route('halaman-solusi.create') }}" class="btn-modern btn-modern-primary">
                        <i class="fa fa-plus"></i> Tambah Solusi
                    </a>
                </div>

                <div class="card-body-table">
                    {{-- ⚠️ STRUKTUR TABLE TIDAK DIUBAH --}}
                    <table id="tableHalamanSolusi" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 40px;">No</th>
                                <th>Judul</th>
                                <th>Slug</th>
                                <th>Konten</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            {{-- ============================================
             WHY CHOOSE US
             ============================================ --}}
            <div class="card-modern border-accent-orange">
                <div class="card-header-modern">
                    <div class="card-header-left">
                        <div class="card-header-icon bg-orange">
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="card-header-info">
                            <h3>Daftar Keunggulan (Why Choose Us)</h3>
                            <p>Poin-poin keunggulan kompetitif perusahaan.</p>
                        </div>
                    </div>
                    <a href="{{ route('why-choose-us.create') }}" class="btn-modern btn-modern-primary">
                        <i class="fa fa-plus"></i> Tambah Keunggulan
                    </a>
                </div>

                <div class="card-body-table">
                    {{-- ⚠️ STRUKTUR TABLE TIDAK DIUBAH --}}
                    <table id="tableWhyChooseUs" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 5%" class="text-center">No</th>
                                <th style="width: 10%" class="text-center">Icon</th>
                                <th style="width: 20%">Judul</th>
                                <th style="width: 30%">Deskripsi</th>
                                <th style="width: 10%" class="text-center">Urutan</th>
                                <th style="width: 10%" class="text-center">Status</th>
                                <th style="width: 15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            {{-- ============================================
             CLIENT LOGO / PENGHARGAAN
             ============================================ --}}
            <div class="card-modern border-accent-purple">
                <div class="card-header-modern">
                    <div class="card-header-left">
                        <div class="card-header-icon bg-purple">
                            <i class="fa fa-handshake"></i>
                        </div>
                        <div class="card-header-info">
                            <h3>Daftar Logo Partner & Sertifikasi</h3>
                            <p>Logo mitra strategis dan sertifikasi yang dimiliki perusahaan.</p>
                        </div>
                    </div>
                    <a href="{{ route('client-logo.create') }}" class="btn-modern btn-modern-primary">
                        <i class="fa fa-plus"></i> Tambah Logo
                    </a>
                </div>

                <div class="card-body-table">
                    {{-- ⚠️ STRUKTUR TABLE TIDAK DIUBAH --}}
                    <table id="tableClientLogo" class="table table-bordered table-striped" style="width: 100%;">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 5%" class="text-center">No</th>
                                <th style="width: 15%" class="text-center">Preview</th>
                                <th style="width: 25%">Nama Partner</th>
                                <th style="width: 15%">Tipe</th>
                                <th style="width: 10%" class="text-center">Urutan</th>
                                <th style="width: 10%" class="text-center">Status</th>
                                <th style="width: 20%" class="text-center">Aksi</th>
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
    {{-- ✅ SEMUA SCRIPT JS YANG SUDAH WORKS TETAP DIPERTAHANKAN --}}
    <script>
        $(document).ready(function() {
            var table = $('#tableHeroSlider').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('hero-slider.index') }}"
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Memuat...</span>',
                    emptyTable: 'Tidak ada data Hero Slider',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    search: 'Cari:',
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'TipeMedia',
                        name: 'TipeMedia',
                        className: 'text-center',
                        render: function(data) {
                            if (data === 'video') {
                                return '<span class="badge badge-info"><i class="fa fa-video mr-1"></i>Video</span>';
                            }
                            return '<span class="badge badge-secondary"><i class="fa fa-image mr-1"></i>Gambar</span>';
                        }
                    },
                    {
                        data: 'JudulUtama',
                        name: 'JudulUtama',
                        render: function(data) {
                            return data ? '<strong>' + data + '</strong>' :
                                '<span class="text-muted">-</span>';
                        }
                    },
                    {
                        data: 'Deskripsi',
                        name: 'Deskripsi',
                        render: function(data) {
                            if (!data) return '<span class="text-muted">-</span>';
                            return data.length > 60 ? data.substring(0, 60) + '...' : data;
                        }
                    },
                    {
                        data: 'GambarLatar',
                        name: 'GambarLatar',
                        className: 'text-center'
                    },
                    {
                        data: 'Urutan',
                        name: 'Urutan',
                        className: 'text-center'
                    },
                    {
                        data: 'Status',
                        name: 'Status',
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
                    [5, 'asc']
                ]
            });

            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Hero Slider?',
                    html: `Apakah Anda yakin ingin menghapus slider ini?<br><small class="text-muted">Data dan file media terkait akan dihapus permanen.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545'
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
                            url: "{{ route('hero-slider.destroy', ':id') }}".replace(':id',
                                id),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON?.message ??
                                        'Terjadi kesalahan pada server.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

    {{-- SOLUSI --}}
    <script>
        $(document).ready(function() {
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
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.status === 200) {
                                    Swal.fire('Dihapus!', response.message, 'success');
                                    $('#tableHalamanSolusi').DataTable().ajax.reload();
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

            $('#tableHalamanSolusi').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('halaman-solusi.index') }}"
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
                    paginate: {
                        next: '>>',
                        previous: '<<'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>

    {{-- KEY FIGURE --}}
    <script>
        $(document).ready(function() {
            var table = $('#tableKeyfigure').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('pengaturan-key-figure.index') }}"
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Memuat...</span>',
                    emptyTable: 'Tidak ada data Key Figure',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    search: 'Cari:',
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'Konten',
                        name: 'Konten',
                        render: function(data) {
                            return '<strong>' + data + '</strong>';
                        }
                    },
                    {
                        data: 'Keterangan',
                        name: 'Keterangan'
                    },
                    {
                        data: 'Icon',
                        name: 'Icon'
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
                ]
            });

            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var konten = $(this).data('konten');
                Swal.fire({
                    title: 'Hapus Key Figure?',
                    html: `Apakah Anda yakin ingin menghapus key figure <strong>"${konten}"</strong>?<br><small class="text-muted">Data yang dihapus tidak bisa dikembalikan.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('pengaturan-key-figure.destroy', ':id') }}'
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
                                    'Terjadi kesalahan.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>

    {{-- WHY CHOOSE US --}}
    <script>
        $(document).ready(function() {
            var table = $('#tableWhyChooseUs').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('why-choose-us.index') }}"
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Memuat...</span>',
                    emptyTable: 'Tidak ada data Why Choose Us',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    search: 'Cari:',
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'Icon',
                        name: 'Icon',
                        className: 'text-center'
                    },
                    {
                        data: 'Judul',
                        name: 'Judul',
                        render: function(data) {
                            return data ? '<strong>' + data + '</strong>' :
                                '<span class="text-muted">-</span>';
                        }
                    },
                    {
                        data: 'Deskripsi',
                        name: 'Deskripsi',
                        render: function(data) {
                            if (!data) return '<span class="text-muted">-</span>';
                            return data.length > 80 ? data.substring(0, 80) + '...' : data;
                        }
                    },
                    {
                        data: 'Urutan',
                        name: 'Urutan',
                        className: 'text-center'
                    },
                    {
                        data: 'status',
                        name: 'Status',
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
                    [4, 'asc']
                ]
            });

            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Data?',
                    html: `Apakah Anda yakin ingin menghapus keunggulan ini?<br><small class="text-muted">Data yang dihapus tidak bisa dikembalikan.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545'
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
                            url: "{{ route('why-choose-us.destroy', ':id') }}".replace(
                                ':id', id),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON?.message ??
                                        'Terjadi kesalahan pada server.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>

    {{-- ICON DAN PENGHARGAAN --}}
    <script>
        $(document).ready(function() {
            var table = $('#tableClientLogo').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('client-logo.index') }}"
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>',
                    emptyTable: 'Tidak ada data logo',
                    paginate: {
                        next: '>>',
                        previous: '<<'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'PreviewLogo',
                        name: 'PathLogo',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'NamaPartner',
                        name: 'NamaPartner'
                    },
                    {
                        data: 'TipeBadge',
                        name: 'Tipe',
                        orderable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'Urutan',
                        name: 'Urutan',
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
                ],
                order: [
                    [4, 'asc']
                ]
            });

            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');
                Swal.fire({
                    title: 'Hapus Logo?',
                    html: `Apakah Anda yakin ingin menghapus logo <strong>"${nama}"</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('client-logo.destroy', ':id') }}'.replace(':id',
                                id),
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

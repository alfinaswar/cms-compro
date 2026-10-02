@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Hero Slider</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Hero Slider</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fa fa-images text-primary mr-2"></i><strong>Daftar Hero Slider</strong>
                        </h3>
                        <div class="ml-auto">
                            <a href="{{ route('hero-slider.create') }}" class="btn btn-primary btn-sm px-3">
                                <i class="fa fa-plus mr-1"></i> Tambah
                            </a>
                        </div>
                    </div>


                    <div class="card-body">
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
            </div>
        </div>
    </section>
@endsection

@push('scripts')
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
                columns: [
                    {
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
                            return data ? '<strong>' + data + '</strong>' : '<span class="text-muted">-</span>';
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
                        className: 'text-center',

                    },
                    {
                        data: 'Urutan',
                        name: 'Urutan',
                        className: 'text-center'
                    },
                    {
                        data: 'Status',
                        name: 'Status',
                        className: 'text-center',

                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                // Urutkan berdasarkan kolom 'Urutan' (index 5) secara Ascending
                order: [[5, 'asc']]
            });

            // Handler Delete
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
                        // Tampilkan loading saat proses delete
                        Swal.fire({
                            title: 'Menghapus...',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });

                        $.ajax({
                            url: "{{ route('hero-slider.destroy', ':id') }}".replace(':id', id),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: res.message, // Sesuai dengan key 'message' di controller
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON?.message ?? 'Terjadi kesalahan pada server.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

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
                <div class="card card-outline card-primary">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fa fa-images mr-2"></i>Daftar Hero Slider
                        </h3>
                        <div class="ml-auto">
                            <a href="{{ route('hero-slider.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus mr-1"></i> Tambah Hero Slider
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="tableHeroSlider" class="table table-bordered table-striped" style="width: 100%;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 5%" class="text-center">No</th>
                                    <th style="width: 20%">Sub Judul</th>
                                    <th style="width: 25%">Judul Utama</th>
                                    <th style="width: 10%">Gambar Latar</th>
                                    <th style="width: 10%">Gambar Bentuk</th>
                                    <th style="width: 10%">Urutan</th>
                                    <th style="width: 10%">Status</th>
                                    <th style="width: 10%" class="text-center">Aksi</th>
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
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'SubJudul',
                        name: 'SubJudul',
                        render: function(data) {
                            return data ? '<span>' + data + '</span>' :
                                '<span class="text-muted">-</span>';
                        }
                    },
                    {
                        data: 'JudulUtama',
                        name: 'JudulUtama'
                    },
                    {
                        data: 'GambarLatar',
                        name: 'GambarLatar'
                    },
                    {
                        data: 'GambarBentuk',
                        name: 'GambarBentuk'
                    },
                    {
                        data: 'Urutan',
                        name: 'Urutan'
                    },
                    {
                        data: 'Status',
                        name: 'Status'
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
                    html: `Apakah Anda yakin ingin menghapus Hero Slider ini?<br><small class="text-muted">Data yang dihapus tidak bisa dikembalikan.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('hero-slider.destroy', ':id') }}'
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
@endpush

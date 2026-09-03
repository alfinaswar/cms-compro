@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kantor & Cabang</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Kantor</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row mb-3">
            <div class="col-md-8">
                <!-- Opsional: Tombol shortcut ke Inbox Pesan -->
                <a href="{{ route('contact.list') }}" class="btn btn-info">
                    <i class="fa fa-inbox mr-2"></i> Lihat Inbox Pesan Masuk
                </a>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('master-kantor.create') }}">
                    <i class="fa fa-plus mr-2"></i> Tambah Kantor
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-building mr-2"></i>Daftar Lokasi Kantor</h3>
                    </div>
                    <div class="card-body">
                        <table id="tableKantor" class="table table-bordered table-striped" style="width: 100%;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 5%" class="text-center">No</th>
                                    <th style="width: 20%">Nama Kantor</th>
                                    <th style="width: 10%" class="text-center">Tipe</th>
                                    <th style="width: 25%">Lokasi</th>
                                    <th style="width: 25%">Kontak</th>
                                    <th style="width: 10%" class="text-center">Status</th>
                                    <th style="width: 5%" class="text-center">Aksi</th>
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
                confirmButtonColor: '#4BCC1F'
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            var table = $('#tableKantor').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('master-kantor.index') }}"
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>',
                    emptyTable: 'Tidak ada data kantor',
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
                        data: 'NamaKantor',
                        name: 'NamaKantor'
                    },
                    {
                        data: 'TipeBadge',
                        name: 'TipeKantor',
                        orderable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'Kota',
                        name: 'Kota',
                        render: function(data, type, row) {
                            return data + ', ' + row.Provinsi;
                        }
                    },
                    {
                        data: 'KontakInfo',
                        name: 'NomorTelepon',
                        orderable: false
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
                    [5, 'asc']
                ] // Sort by Urutan
            });

            // Delete with SweetAlert
            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Data Kantor?',
                    html: `Apakah Anda yakin ingin menghapus <strong>"${nama}"</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('master-kantor.destroy', ':id') }}'
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

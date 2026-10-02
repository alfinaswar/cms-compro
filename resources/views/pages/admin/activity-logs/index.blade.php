@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Riwayat Aktivitas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Activity Log</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row mb-3">
            <div class="col d-flex justify-content-end">
                <button class="btn btn-secondary" id="btnRefresh">
                    <i class="fa fa-sync-alt mr-2"></i> Refresh
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-history mr-2"></i> Daftar Aktivitas
                        </h3>
                    </div>
                    <div class="card-body">
                        <table id="tableActivity" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Waktu</th>
                                    <th>Deskripsi</th>
                                    <th>Pengguna</th>
                                    <th>Model</th>
                                    <th width="10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Detail Perubahan -->
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="modalDetailLabel">
                        <i class="fa fa-info-circle mr-2"></i> Detail Perubahan Data
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h6 class="text-danger font-weight-bold">
                            <i class="fa fa-arrow-left mr-1"></i> Data Lama (Old):
                        </h6>
                        <pre id="oldData" class="bg-light p-3 rounded border" style="max-height: 300px; overflow-y: auto;">-</pre>
                    </div>
                    <div>
                        <h6 class="text-success font-weight-bold">
                            <i class="fa fa-arrow-right mr-1"></i> Data Baru (New):
                        </h6>
                        <pre id="newData" class="bg-light p-3 rounded border" style="max-height: 300px; overflow-y: auto;">-</pre>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times mr-1"></i> Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
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
            // Refresh Handler
            $('#btnRefresh').click(function() {
                $('#tableActivity').DataTable().ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Data Diperbarui!',
                    text: 'Data aktivitas telah berhasil di-refresh.',
                    iconColor: '#4BCC1F',
                    confirmButtonText: 'Oke',
                    confirmButtonColor: '#4BCC1F',
                    timer: 2000,
                    showConfirmButton: false
                });
            });

            // Detail Handler
            $('body').on('click', '.btn-detail', function() {
                var properties = $(this).data('properties');

                var oldData = properties.old ? JSON.stringify(properties.old, null, 2) :
                    'Tidak ada perubahan data lama';
                var newData = properties.attributes ? JSON.stringify(properties.attributes, null, 2) :
                    'Tidak ada data baru';

                $('#oldData').text(oldData);
                $('#newData').text(newData);
                $('#modalDetail').modal('show');
            });

            // DataTables
            $('#tableActivity').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: "{{ route('log.index') }}",
                order: [
                    [1, 'desc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'waktu',
                        name: 'created_at'
                    },
                    {
                        data: 'deskripsi',
                        name: 'description',
                        orderable: false
                    },
                    {
                        data: 'pengguna',
                        name: 'causer.name',
                        orderable: false
                    },
                    {
                        data: 'model',
                        name: 'subject_type',
                        orderable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],

            });
        });
    </script>
@endpush

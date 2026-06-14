@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen History Perusahaan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">History Perusahaan</li>
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
                            <i class="fa fa-history mr-2"></i>Daftar History Perusahaan
                        </h3>
                        <div class="ml-auto">
                            <a href="{{ route('history-perusahaan.create') }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus mr-1"></i> Tambah History Perusahaan
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="tableHistoryPerusahaan" class="table table-bordered table-striped" style="width: 100%;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 5%" class="text-center">No</th>
                                    <th style="width: 15%">Tahun</th>
                                    <th style="width: 20%">Judul</th>
                                    <th style="width: 45%">Isi</th>

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
            var table = $('#tableHistoryPerusahaan').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('history-perusahaan.index') }}"
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Memuat...</span>',
                    emptyTable: 'Tidak ada data History Perusahaan',
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
                        data: 'Tahun',
                        name: 'Tahun',
                        render: function(data) {
                            return data ? '<span>' + data + '</span>' :
                                '<span class="text-muted">-</span>';
                        }
                    },
                    {
                        data: 'Judul',
                        name: 'Judul',
                        render: function(data) {
                            return data ? '<span>' + data + '</span>' :
                                '<span class="text-muted">-</span>';
                        }
                    },
                    {
                        data: 'Deskripsi',
                        name: 'Deskripsi',

                    },

                ],
                order: [
                    [1, 'desc']
                ]
            });

        });
    </script>
@endpush

@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa-file-alt mr-2"></i>Halaman Statis</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Halaman Statis</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="alert alert-info">
                <i class="fa fa-info-circle mr-2"></i>
                <strong>Halaman Statis:</strong> Halaman ini bersifat tunggal (tidak bisa ditambah/dihapus).
                Klik <strong>Edit</strong> untuk mengubah konten, atau <i class="fa fa-eye"></i> untuk melihat halaman
                publik.
            </div>

            <div class="card">
                <div class="card-body">
                    <table id="tableStaticPages" class="table table-bordered table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Halaman</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th>Terakhir Update</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#tableStaticPages').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('static-pages.index') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'JudulDisplay',
                            name: 'Label',
                            orderable: false
                        },
                        {
                            data: 'Slug',
                            name: 'Slug',
                            orderable: true
                        },
                        {
                            data: 'Status',
                            name: 'IsPublished',
                            orderable: false
                        },
                        {
                            data: 'LastUpdate',
                            name: 'updated_at',
                            orderable: true
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    order: [
                        [0, 'asc']
                    ],
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-2x"></i><br>Memuat data...',
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        search: "Cari:",
                        paginate: {
                            next: '<i class="fa fa-chevron-right"></i>',
                            previous: '<i class="fa fa-chevron-left"></i>'
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection

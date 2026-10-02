@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Penghargaan Perusahaan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Penghargaan Perusahaan</li>
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
                            <i class="fa fa-trophy mr-2"></i>Daftar Penghargaan Perusahaan
                        </h3>
                        <div class="ml-auto">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#modalTambahPenghargaan">
                                <i class="fa fa-plus mr-1"></i> Tambah Penghargaan Perusahaan
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="tablePenghargaanPerusahaan" class="table table-bordered table-striped"
                            style="width: 100%;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 5%" class="text-center">No</th>
                                    <th style="width: 25%">Judul</th>
                                    <th style="width: 70%">Keterangan</th>
                                    <th style="width: 70%">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Tambah Penghargaan --}}
        <div class="modal fade" id="modalTambahPenghargaan" tabindex="-1" role="dialog"
            aria-labelledby="modalTambahPenghargaanLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form id="formTambahPenghargaan" method="POST" action="{{ route('penghargaan-perusahaan.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahPenghargaanLabel">Tambah Penghargaan Perusahaan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="judulPenghargaan"><strong>Judul</strong> <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="Judul" id="judulPenghargaan" class="form-control"
                                    placeholder="Tulis judul penghargaan..." required autofocus>
                            </div>
                            <div class="form-group">
                                <label for="keteranganPenghargaan"><strong>Keterangan</strong></label>
                                <textarea name="Keterangan" id="keteranganPenghargaan" class="form-control" rows="4"
                                    placeholder="Tulis keterangan penghargaan..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-success">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#tablePenghargaanPerusahaan').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('penghargaan-perusahaan.index') }}"
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Memuat...</span>',
                    emptyTable: 'Tidak ada data Penghargaan Perusahaan',
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
                        data: 'Judul',
                        name: 'Judul',
                    },
                    {
                        data: 'Deskripsi',
                        name: 'Deskripsi'
                    },
                    {
                        data: 'Action',
                        name: 'Action'
                    }
                ],
                order: [
                    [1, 'desc']
                ]
            });
        });
    </script>
@endpush

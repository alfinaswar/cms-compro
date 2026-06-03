@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Kategori Berita</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Kategori Berita</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Kategori</h3>
                    </div>
                    <div class="card-body">
                        <table id="tableKategori" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 40%">Nama Kategori</th>
                                    <th style="width: 35%">Slug</th>
                                    <th style="width: 20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Edit Kategori -->
    <div class="modal fade" id="modalEditKategori" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-white"><i class="fa fa-edit mr-2"></i>Edit Kategori</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <form id="formEditKategori">
                    @csrf @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_kategori_id" name="id">
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" id="edit_kategori_nama" name="NamaKategori" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning btn-sm">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // DataTables
            var table = $('#tableKategori').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('kategori-berita.index') }}"
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'NamaKategori',
                        name: 'NamaKategori'
                    },
                    {
                        data: 'Slug',
                        name: 'Slug'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });

            // Hapus Kategori
            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Kategori?',
                    text: "Kategori yang dihapus tidak bisa dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('kategori-berita.destroy', ':id') }}'
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

            // Edit Kategori (Buka Modal)
            $('body').on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');
                $('#edit_kategori_id').val(id);
                $('#edit_kategori_nama').val(nama);
                $('#modalEditKategori').modal('show');
            });

            // Submit Edit Kategori
            $('#formEditKategori').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_kategori_id').val();
                $.ajax({
                    url: '{{ route('kategori-berita.update', ':id') }}'.replace(':id', id),
                    type: 'PUT',
                    data: $(this).serialize(),
                    success: function(res) {
                        Swal.fire('Berhasil!', res.message, 'success');
                        $('#modalEditKategori').modal('hide');
                        table.ajax.reload();
                    }
                });
            });
        });
    </script>
@endpush

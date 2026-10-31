@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Master Produk & Jasa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Master Produk & Jasa</li>
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
                            <i class="fa fa-boxes mr-2"></i>Daftar Produk & Layanan
                        </h3>
                        <div class="ml-auto">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCreateProduk">
                                <i class="fa fa-plus mr-1"></i> Tambah Produk / Jasa
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tableProduk" class="table table-bordered table-striped" style="width: 100%;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 5%" class="text-center">No</th>
                                    <th style="width: 25%">Kategori Induk</th>
                                    <th style="width: 25%">Nama (ID)</th>
                                    <th style="width: 25%">Nama Terjemahan (EN)</th>
                                    <th style="width: 8%" class="text-center">Status</th>
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

    <!-- ==================== MODAL CREATE ==================== -->
    <div class="modal fade" id="modalCreateProduk" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title mb-0">
                        <i class="fa fa-plus-circle mr-2"></i>Tambah Produk / Jasa Baru
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formCreateProduk">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="create_parent_id">Kategori Induk (Opsional)</label>
                            <select id="create_parent_id" name="parent_id" class="form-control select2">
                                <option value="">-- Kategori Utama (Tanpa Induk) --</option>
                                @foreach ($allParents as $top)
                                    <option value="{{ $top->id }}">{{ $top->Nama }}</option>
                                    @foreach ($top->children as $sub)
                                        <option value="{{ $sub->id }}">&nbsp;&nbsp;&nbsp;↳ {{ $sub->Nama }}</option>
                                        @foreach ($sub->children as $subSub)
                                            <option value="{{ $subSub->id }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳ {{ $subSub->Nama }}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Pilih kategori induk jika item ini merupakan sub-kategori.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="create_nama">Nama Produk/Jasa (Bahasa Indonesia) <span class="text-danger">*</span></label>
                                    <input type="text" id="create_nama" name="Nama" class="form-control" placeholder="Contoh: Kartu Kredit" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="create_nama_translate">Nama Terjemahan (English)</label>
                                    <input type="text" id="create_nama_translate" name="NamaTranslate" class="form-control" placeholder="Example: Credit Card">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="create_urutan">Nomor Urutan</label>
                                    <input type="number" id="create_urutan" name="Urutan" class="form-control" value="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="create_status">Status</label>
                                    <select id="create_status" name="StatusAktif" class="form-control">
                                        <option value="1" selected>Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            <i class="fa fa-times mr-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm btn-save">
                            <i class="fa fa-save mr-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL EDIT ==================== -->
    <div class="modal fade" id="modalEditProduk" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title mb-0">
                        <i class="fa fa-edit mr-2"></i>Edit Produk / Jasa
                    </h5>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditProduk">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="edit_parent_id">Kategori Induk (Opsional)</label>
                            <select id="edit_parent_id" name="parent_id" class="form-control">
                                <option value="">-- Kategori Utama (Tanpa Induk) --</option>
                                @foreach ($allParents as $top)
                                    <option value="{{ $top->id }}">{{ $top->Nama }}</option>
                                    @foreach ($top->children as $sub)
                                        <option value="{{ $sub->id }}">&nbsp;&nbsp;&nbsp;↳ {{ $sub->Nama }}</option>
                                        @foreach ($sub->children as $subSub)
                                            <option value="{{ $subSub->id }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳ {{ $subSub->Nama }}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_nama">Nama Produk/Jasa (Bahasa Indonesia) <span class="text-danger">*</span></label>
                                    <input type="text" id="edit_nama" name="Nama" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_nama_translate">Nama Terjemahan (English)</label>
                                    <input type="text" id="edit_nama_translate" name="NamaTranslate" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_urutan">Nomor Urutan</label>
                                    <input type="number" id="edit_urutan" name="Urutan" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="edit_status">Status</label>
                                    <select id="edit_status" name="StatusAktif" class="form-control">
                                        <option value="1">Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            <i class="fa fa-times mr-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-warning btn-sm btn-update">
                            <i class="fa fa-save mr-1"></i>Perbarui
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var table = $('#tableProduk').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('master-produk.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'KategoriInduk', name: 'KategoriInduk' },
                    { data: 'Nama', name: 'Nama' },
                    { data: 'NamaTranslate', name: 'NamaTranslate' },
                    { data: 'Status', name: 'Status', className: 'text-center' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[1, 'asc']]
            });

            // Submit Create
            $('#formCreateProduk').on('submit', function(e) {
                e.preventDefault();
                var btn = $(this).find('.btn-save');
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i>Menyimpan...');

                $.ajax({
                    url: "{{ route('master-produk.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) {
                        $('#modalCreateProduk').modal('hide');
                        $('#formCreateProduk')[0].reset();
                        table.ajax.reload();
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 2000, showConfirmButton: false });
                    },
                    error: function(err) {
                        var msg = err.responseJSON && err.responseJSON.message ? err.responseJSON.message : 'Terjadi kesalahan.';
                        Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="fa fa-save mr-1"></i>Simpan');
                    }
                });
            });

            // Trigger Edit
            $(document).on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');
                var namaTranslate = $(this).data('namatranslate');
                var parentId = $(this).data('parent_id');
                var urutan = $(this).data('urutan');
                var status = $(this).data('status');

                $('#edit_id').val(id);
                $('#edit_nama').val(nama);
                $('#edit_nama_translate').val(namaTranslate);
                $('#edit_parent_id').val(parentId);
                $('#edit_urutan').val(urutan);
                $('#edit_status').val(status);

                $('#modalEditProduk').modal('show');
            });

            // Submit Edit
            $('#formEditProduk').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_id').val();
                var btn = $(this).find('.btn-update');
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i>Memperbarui...');

                $.ajax({
                    url: "{{ route('master-produk.update', ':id') }}".replace(':id', id),
                    type: "POST",
                    data: $(this).serialize(),
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(res) {
                        $('#modalEditProduk').modal('hide');
                        table.ajax.reload();
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: res.message, timer: 2000, showConfirmButton: false });
                    },
                    error: function(err) {
                        var msg = err.responseJSON && err.responseJSON.message ? err.responseJSON.message : 'Terjadi kesalahan.';
                        Swal.fire({ icon: 'error', title: 'Gagal', text: msg });
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="fa fa-save mr-1"></i>Perbarui');
                    }
                });
            });

            // Trigger Delete
            $(document).on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Produk/Jasa?',
                    text: 'Apakah Anda yakin ingin menghapus "' + nama + '"? Sub-kategori terkait juga akan terhapus.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('master-produk.destroy', ':id') }}".replace(':id', id),
                            type: "DELETE",
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            success: function(res) {
                                table.ajax.reload();
                                Swal.fire({ icon: 'success', title: 'Dihapus', text: res.message, timer: 2000, showConfirmButton: false });
                            },
                            error: function(err) {
                                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal menghapus data.' });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

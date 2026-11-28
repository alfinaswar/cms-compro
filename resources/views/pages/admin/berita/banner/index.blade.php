@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Banner Artikel</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item">News & Artikel</li>
                        <li class="breadcrumb-item active">Banner Artikel</li>
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
                            <i class="fa fa-image mr-2"></i>Daftar Banner Sidebar Artikel
                        </h3>
                        <div class="ml-auto">
                            @can('berita.create')
                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCreateBanner">
                                    <i class="fa fa-plus mr-1"></i> Tambah Banner
                                </button>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="tableBanner" class="table table-bordered table-striped" style="width: 100%;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 5%" class="text-center">No</th>
                                    <th style="width: 15%" class="text-center">Preview</th>
                                    <th style="width: 20%">Judul / Label</th>
                                    <th style="width: 30%">Link URL (target _blank)</th>
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

    <!-- ==================== MODAL CREATE ==================== -->
    <div class="modal fade" id="modalCreateBanner" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title mb-0">
                        <i class="fa fa-plus-circle mr-2"></i>Tambah Banner Artikel
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formCreateBanner" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="create_title">Judul / Label Banner</label>
                            <input type="text" id="create_title" name="Title" class="form-control"
                                placeholder="Contoh: Promo Digital Marketing Solutions">
                        </div>
                        <div class="form-group">
                            <label for="create_image">Gambar Banner <span class="text-danger">*</span></label>
                            <input type="file" id="create_image" name="ImagePath" class="form-control-file"
                                accept="image/*" required>
                            <small class="text-muted d-block mt-1">Format JPG, PNG, atau WEBP. Maks 2MB.</small>
                            <div id="create_preview_box" class="mt-2" style="display:none;">
                                <img src="" class="img-thumbnail" style="max-height: 160px;" alt="Preview">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="create_link">Link URL (opsional)</label>
                            <input type="url" id="create_link" name="LinkUrl" class="form-control"
                                placeholder="https://contoh.com/promo">
                            <small class="text-muted">Saat diklik di website, link akan dibuka di tab baru (<code>target="_blank"</code>).</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="create_urutan">Urutan Tampil</label>
                                    <input type="number" id="create_urutan" name="Urutan" class="form-control"
                                        value="{{ $nextUrutan ?? 1 }}" min="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="create_active">Status</label>
                                    <select id="create_active" name="IsActive" class="form-control">
                                        <option value="1" selected>Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            <i class="fa fa-times mr-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm" id="btnCreateSubmit">
                            <i class="fa fa-save mr-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL EDIT ==================== -->
    <div class="modal fade" id="modalEditBanner" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title mb-0">
                        <i class="fa fa-edit mr-2"></i>Edit Banner Artikel
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEditBanner" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_title">Judul / Label Banner</label>
                            <input type="text" id="edit_title" name="Title" class="form-control"
                                placeholder="Contoh: Promo Digital Marketing Solutions">
                        </div>
                        <div class="form-group">
                            <label for="edit_image">Ganti Gambar Banner</label>
                            <input type="file" id="edit_image" name="ImagePath" class="form-control-file"
                                accept="image/*">
                            <small class="text-muted d-block mt-1">Kosongkan jika tidak ingin mengganti gambar.</small>
                            <div id="edit_preview_box" class="mt-2" style="display:none;">
                                <img src="" class="img-thumbnail" style="max-height: 160px;" alt="Preview">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_link">Link URL (opsional)</label>
                            <input type="url" id="edit_link" name="LinkUrl" class="form-control"
                                placeholder="https://contoh.com/promo">
                            <small class="text-muted">Dibuka di tab baru (<code>target="_blank"</code>).</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="edit_urutan">Urutan Tampil</label>
                                    <input type="number" id="edit_urutan" name="Urutan" class="form-control" min="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-0">
                                    <label for="edit_active">Status</label>
                                    <select id="edit_active" name="IsActive" class="form-control">
                                        <option value="1">Aktif</option>
                                        <option value="0">Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            <i class="fa fa-times mr-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-warning btn-sm" id="btnEditSubmit">
                            <i class="fa fa-save mr-1"></i> Update
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
            var table = $('#tableBanner').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('news-banner.index') }}"
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>',
                    emptyTable: 'Belum ada banner',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    search: 'Cari:',
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>'
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'Preview', name: 'Preview', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'Title', name: 'Title', render: function(d) { return d ? d : '<span class="text-muted">-</span>'; } },
                    { data: 'LinkDisplay', name: 'LinkUrl', orderable: false },
                    { data: 'Urutan', name: 'Urutan', className: 'text-center' },
                    { data: 'StatusBadge', name: 'IsActive', className: 'text-center' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[4, 'asc']]
            });

            function bindImagePreview(inputSelector, boxSelector) {
                $(inputSelector).on('change', function() {
                    if (this.files && this.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $(boxSelector + ' img').attr('src', e.target.result);
                            $(boxSelector).show();
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
            bindImagePreview('#create_image', '#create_preview_box');
            bindImagePreview('#edit_image', '#edit_preview_box');

            $('#formCreateBanner').on('submit', function(e) {
                e.preventDefault();
                var btn = $('#btnCreateSubmit');
                var formData = new FormData(this);
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan...');

                $.ajax({
                    url: '{{ route('news-banner.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil!', text: res.message, timer: 1500, showConfirmButton: false });
                        $('#modalCreateBanner').modal('hide');
                        $('#formCreateBanner')[0].reset();
                        $('#create_preview_box').hide();
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON?.message ?? 'Terjadi kesalahan.', 'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="fa fa-save mr-1"></i> Simpan');
                    }
                });
            });

            $('body').on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                $('#edit_id').val(id);
                $('#edit_title').val($(this).data('title') || '');
                $('#edit_link').val($(this).data('link') || '');
                $('#edit_urutan').val($(this).data('urutan') || 1);
                $('#edit_active').val($(this).data('active') ? '1' : '0');
                var img = $(this).data('image');
                if (img) {
                    $('#edit_preview_box img').attr('src', img);
                    $('#edit_preview_box').show();
                } else {
                    $('#edit_preview_box').hide();
                }
                $('#modalEditBanner').modal('show');
            });

            $('#formEditBanner').on('submit', function(e) {
                e.preventDefault();
                var btn = $('#btnEditSubmit');
                var id = $('#edit_id').val();
                var formData = new FormData(this);
                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Updating...');

                $.ajax({
                    url: '{{ route('news-banner.update', ':id') }}'.replace(':id', id),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        Swal.fire({ icon: 'success', title: 'Berhasil!', text: res.message, timer: 1500, showConfirmButton: false });
                        $('#modalEditBanner').modal('hide');
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON?.message ?? 'Terjadi kesalahan.', 'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="fa fa-save mr-1"></i> Update');
                    }
                });
            });

            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var title = $(this).data('title');
                Swal.fire({
                    title: 'Hapus Banner?',
                    html: `Apakah Anda yakin ingin menghapus <strong>"${title}"</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('news-banner.destroy', ':id') }}'.replace(':id', id),
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function(res) {
                                Swal.fire('Dihapus!', res.message, 'success');
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', xhr.responseJSON?.message ?? 'Terjadi kesalahan.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

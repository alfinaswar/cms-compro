@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail: {{ $parent->NamaPartner }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('client-logo.index') }}">Client Logos</a></li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <!-- Header Card: Info Parent -->
    <div class="card card-outline card-primary shadow-sm mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">
                <i class="fa fa-info-circle text-primary mr-2"></i>Informasi Kategori
            </h3>
            <div class="ml-auto">
                <a href="{{ route('client-logo.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Kategori</dt>
                        <dd class="col-sm-9"><strong>{{ $parent->Tipe }}</strong></dd>

                        <dt class="col-sm-3">Judul Utama</dt>
                        <dd class="col-sm-9">{{ $parent->NamaPartner }}</dd>

                        @if($parent->Deskripsi)
                            <dt class="col-sm-3">Deskripsi</dt>
                            <dd class="col-sm-9 text-muted">{{ $parent->Deskripsi }}</dd>
                        @endif

                        <dt class="col-sm-3">Tipe</dt>
                        <dd class="col-sm-9">
                            <span class="badge badge-info">{{ $parent->Tipe }}</span>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: List Detail Items -->
    <div class="card card-outline card-info shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">
                <i class="fa fa-list text-info mr-2"></i>Daftar Item Detail
            </h3>
            <div class="ml-auto">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAddDetail">
                    <i class="fa fa-plus mr-1"></i> Tambah Detail
                </button>
            </div>

        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0" style="width: 100%;">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 5%" class="text-center">#</th>
                            <th style="width: 20%">Sub Judul</th>
                            <th style="width: 18%">Judul</th>
                            <th style="width: 22%">Deskripsi</th>
                            <th style="width: 8%" class="text-center">Urutan</th>
                            <th style="width: 8%" class="text-center">Status</th>
                            <th style="width: 7%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($details as $i => $item)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>{{ $item->SubJudul ?? '-' }}</td>
                            <td><strong>{{ $item->Judul }}</strong></td>
                            <td>
                                @if($item->Deskripsi)
                                    <small class="text-muted">{{ Str::limit($item->Deskripsi, 80) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $item->Urutan }}</td>
                            <td class="text-center">
                                @if($item->Status == 'Aktif')
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button type="button"
                                            class="btn btn-warning btn-edit-detail"
                                            data-id="{{ $item->id }}"
                                            data-subjudul="{{ $item->SubJudul }}"
                                            data-judul="{{ $item->Judul }}"
                                            data-deskripsi="{{ $item->Deskripsi }}"
                                            data-url="{{ $item->UrlWebsite }}"
                                            data-urutan="{{ $item->Urutan }}"
                                            data-status="{{ $item->Status }}"
                                            title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button"
                                            class="btn btn-danger btn-delete-detail"
                                            data-id="{{ $item->id }}"
                                            data-judul="{{ $item->Judul }}"
                                            title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fa fa-folder-open fa-2x mb-2"></i><br>
                                Belum ada item detail dalam kategori ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- ==================== MODAL: TAMBAH DETAIL ==================== -->
<div class="modal fade" id="modalAddDetail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('client-logo.store-detail', $parent->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fa fa-plus-circle mr-2"></i>Tambah Item Detail</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sub Judul <small class="text-muted">(Opsional)</small></label>
                                <input type="text" name="SubJudul" class="form-control" placeholder="Contoh: Level 1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Judul <span class="text-danger">*</span></label>
                                <input type="text" name="Judul" class="form-control" required placeholder="Contoh: Sertifikasi VISA">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi <small class="text-muted">(Opsional)</small></label>
                        <textarea name="Deskripsi" class="form-control" rows="3" placeholder="Penjelasan singkat..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="number" name="Urutan" class="form-control" value="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="Status" class="form-control">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>URL Website <small class="text-muted">(Opsional)</small></label>
                                <input type="url" name="UrlWebsite" class="form-control" placeholder="https://example.com">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Detail</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ==================== MODAL: EDIT DETAIL ==================== -->
<div class="modal fade" id="modalEditDetail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formEditDetail">
                @csrf @method('PUT')
                <input type="hidden" id="edit_detail_id" name="id">

                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title"><i class="fa fa-edit mr-2"></i>Edit Item Detail</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sub Judul <small class="text-muted">(Opsional)</small></label>
                                <input type="text" name="SubJudul" id="edit_SubJudul" class="form-control" placeholder="Contoh: Level 1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Judul <span class="text-danger">*</span></label>
                                <input type="text" name="Judul" id="edit_Judul" class="form-control" required placeholder="Contoh: Sertifikasi VISA">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi <small class="text-muted">(Opsional)</small></label>
                        <textarea name="Deskripsi" id="edit_Deskripsi" class="form-control" rows="3" placeholder="Penjelasan singkat..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="number" name="Urutan" id="edit_Urutan" class="form-control" min="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="Status" id="edit_Status" class="form-control">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>URL Website <small class="text-muted">(Opsional)</small></label>
                                <input type="url" name="UrlWebsite" id="edit_UrlWebsite" class="form-control" placeholder="https://example.com">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning" id="btnUpdateDetail">
                        <i class="fa fa-save mr-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @if (Session::get('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ Session::get('success') }}', iconColor: '#4BCC1F', confirmButtonColor: '#4BCC1F' });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            // ========== EDIT DETAIL: OPEN MODAL & POPULATE DATA ==========
            $('body').on('click', '.btn-edit-detail', function() {
                var btn = $(this);
                $('#edit_detail_id').val(btn.data('id'));
                $('#edit_SubJudul').val(btn.data('subjudul') || '');
                $('#edit_Judul').val(btn.data('judul'));
                $('#edit_Deskripsi').val(btn.data('deskripsi') || '');
                $('#edit_UrlWebsite').val(btn.data('url') || '');
                $('#edit_Urutan').val(btn.data('urutan'));
                $('#edit_Status').val(btn.data('status'));
                $('#modalEditDetail').modal('show');
            });

            // ========== EDIT DETAIL: SUBMIT AJAX ==========
            $('#formEditDetail').on('submit', function(e) {
                e.preventDefault();

                var id = $('#edit_detail_id').val();
                var btn = $('#btnUpdateDetail');
                var originalBtnText = btn.html();

                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Updating...');

                var formData = new FormData(this);
                formData.append('_method', 'PUT');

                $.ajax({
                    url: '{{ route('client-logo.update-detail', ':id') }}'.replace(':id', id),
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function(res) {
                        if (res.status === 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            $('#modalEditDetail').modal('hide');
                            location.reload(); // Reload untuk update tabel
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON?.message ?? 'Terjadi kesalahan.', 'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html(originalBtnText);
                    }
                });
            });

            // ========== DELETE DETAIL: AJAX WITH SWEETALERT ==========
            $('body').on('click', '.btn-delete-detail', function() {
                var btn = $(this);
                var id = btn.data('id');
                var judul = btn.data('judul');

                Swal.fire({
                    title: 'Hapus Item?',
                    html: `Apakah Anda yakin ingin menghapus <strong>"${judul}"</strong>?<br><small class="text-muted">Data akan dipindahkan ke tempat sampah.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

                        $.ajax({
                            url: '{{ route('client-logo.destroy-detail', ':id') }}'.replace(':id', id),
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Dihapus!',
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                location.reload();
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', xhr.responseJSON?.message ?? 'Terjadi kesalahan.', 'error');
                                btn.prop('disabled', false).html('<i class="fa fa-trash"></i>');
                            }
                        });
                    }
                });
            });

            // Reset modal saat ditutup
            $('#modalEditDetail').on('hidden.bs.modal', function() {
                $('#formEditDetail')[0].reset();
            });
        });
    </script>
@endpush

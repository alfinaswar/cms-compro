@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dokumen: {{ $jenis->NamaJenis }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('jenis-laporan.index') }}">Jenis Laporan</a></li>
                        <li class="breadcrumb-item active">{{ $jenis->NamaJenis }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row mb-3">
            <div class="col-md-6">
                <a href="{{ route('jenis-laporan.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left mr-2"></i>Kembali ke Jenis Laporan
                </a>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAddDetail">
                    <i class="fa fa-plus mr-2"></i>Upload Dokumen
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-info shadow-sm">
                    <!-- ✅ HEADER DENGAN FITUR PENCARIAN -->
                    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap">
                        <h3 class="card-title mb-2 mb-md-0">
                            <span class="badge badge-{{ $jenis->WarnaBadge }} mr-2">
                                <i class="fa {{ $jenis->IconKategori }}"></i> {{ $jenis->NamaJenis }}
                            </span>
                            <small class="text-muted ml-2">{{ $jenis->Deskripsi }}</small>
                        </h3>
                        <div class="card-tools ml-auto" style="min-width: 250px;">
                            <div class="input-group input-group-sm justify-content-end">
                                <input type="text" id="searchDokumen" class="form-control" placeholder="Cari judul atau deskripsi...">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-0" style="width: 100%;">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 5%" class="text-center">#</th>
                                        <th style="width: 30%">Judul Dokumen</th>
                                        <th style="width: 12%" class="text-center">Tahun</th>
                                        <th style="width: 8%" class="text-center">Bahasa</th>
                                        <th style="width: 10%" class="text-center">File Size</th>
                                        <th style="width: 10%" class="text-center">Download</th>
                                        <th style="width: 8%" class="text-center">Status</th>
                                        <th style="width: 17%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($details as $i => $item)
                                    <tr>
                                        <td class="text-center">{{ $i + 1 }}</td>
                                        <td>
                                            <strong>{{ $item->Judul }}</strong>
                                            @if($item->Deskripsi)
                                                <br><small class="text-muted">{{ Str::limit($item->Deskripsi, 60) }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item->TahunPeriode->format('Y') }}</td>
                                        <td class="text-center"><span class="badge badge-secondary">{{ $item->Bahasa }}</span></td>
                                        <td class="text-center"><small>{{ $item->FileSize }} MB</small></td>
                                        <td class="text-center"><i class="fa fa-download text-muted"></i> {{ $item->JumlahDownload }}</td>
                                        <td class="text-center">
                                            @if($item->Status == 'Aktif')
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-danger">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-warning btn-edit-detail"
                                                        data-id="{{ $item->id }}"
                                                        data-judul="{{ $item->Judul }}"
                                                        data-deskripsi="{{ $item->Deskripsi }}"
                                                        data-tahun="{{ $item->TahunPeriode->format('Y-m-d') }}"
                                                        data-bahasa="{{ $item->Bahasa }}"
                                                        data-urutan="{{ $item->Urutan }}"
                                                        data-status="{{ $item->Status }}"
                                                        title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <a href="{{ route('laporan.download', $item->id) }}" class="btn btn-info" title="Download">
                                                    <i class="fa fa-download"></i>
                                                </a>
                                                <button class="btn btn-danger btn-delete-detail"
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
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="fa fa-folder-open fa-2x mb-2"></i><br>
                                            Belum ada dokumen dalam kategori ini.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- MODAL TAMBAH DOKUMEN -->
    <div class="modal fade" id="modalAddDetail" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('jenis-laporan.details.store', $jenis->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title"><i class="fa fa-upload mr-2"></i>Upload Dokumen Baru</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Judul Dokumen <span class="text-danger">*</span></label>
                            <input type="text" name="Judul" class="form-control" required placeholder="Contoh: Laporan Tahunan 2023">
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="Deskripsi" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tahun Periode <span class="text-danger">*</span></label>
                                    <input type="date" name="TahunPeriode" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bahasa <span class="text-danger">*</span></label>
                                    <select name="Bahasa" class="form-control" required>
                                        <option value="ID">Indonesia</option>
                                        <option value="EN">English</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Urutan</label>
                                    <input type="number" name="Urutan" class="form-control" value="0" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Upload File <span class="text-danger">*</span></label>
                            <input type="file" name="PathFile" class="form-control" accept=".pdf,.xlsx,.xls,.doc,.docx" required>
                            <small class="text-muted">PDF, Excel, Word. Maksimal 10MB.</small>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="Status" class="form-control">
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Upload Dokumen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL EDIT DOKUMEN -->
    <div class="modal fade" id="modalEditDetail" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formEditDetail">
                    @csrf @method('PUT')
                    <input type="hidden" id="edit_detail_id">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title"><i class="fa fa-edit mr-2"></i>Edit Dokumen</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Judul Dokumen <span class="text-danger">*</span></label>
                            <input type="text" name="Judul" id="edit_Judul" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="Deskripsi" id="edit_Deskripsi" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tahun Periode <span class="text-danger">*</span></label>
                                    <input type="date" name="TahunPeriode" id="edit_TahunPeriode" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bahasa <span class="text-danger">*</span></label>
                                    <select name="Bahasa" id="edit_Bahasa" class="form-control" required>
                                        <option value="ID">Indonesia</option>
                                        <option value="EN">English</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Urutan</label>
                                    <input type="number" name="Urutan" id="edit_Urutan" class="form-control" min="0">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Ganti File (Opsional)</label>
                            <input type="file" name="PathFile" class="form-control" accept=".pdf,.xlsx,.xls,.doc,.docx">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti file.</small>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="Status" id="edit_Status" class="form-control">
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
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
            // ==========================================
            // ✅ 1. FITUR PENCARIAN DOKUMEN (REAL-TIME)
            // ==========================================
            $('#searchDokumen').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                var visibleCount = 0;

                $("table tbody tr").each(function() {
                    // Abaikan baris "Belum ada dokumen" atau "Tidak ditemukan" (yang pakai colspan)
                    if ($(this).find('td').attr('colspan')) {
                        return;
                    }

                    // Cek apakah teks baris mengandung kata kunci pencarian
                    if ($(this).text().toLowerCase().indexOf(value) > -1) {
                        $(this).show();
                        visibleCount++;
                    } else {
                        $(this).hide();
                    }
                });

                // Tampilkan pesan "Tidak ditemukan" jika hasil search 0
                var $noResultRow = $('#no-result-row');
                if (visibleCount === 0 && value !== '') {
                    if ($noResultRow.length === 0) {
                        $('table tbody').append('<tr id="no-result-row"><td colspan="8" class="text-center text-muted py-4"><i class="fa fa-search fa-2x mb-2"></i><br>Dokumen tidak ditemukan.</td></tr>');
                    } else {
                        $noResultRow.show();
                    }
                } else {
                    if ($noResultRow.length > 0) {
                        $noResultRow.hide();
                    }
                }
            });

            // ==========================================
            // ✅ 2. EDIT DETAIL (AJAX)
            // ==========================================
            var jenisId = {{ $jenis->id }};

            $('body').on('click', '.btn-edit-detail', function() {
                var btn = $(this);
                $('#edit_detail_id').val(btn.data('id'));
                $('#edit_Judul').val(btn.data('judul'));
                $('#edit_Deskripsi').val(btn.data('deskripsi') || '');
                $('#edit_TahunPeriode').val(btn.data('tahun'));
                $('#edit_Bahasa').val(btn.data('bahasa'));
                $('#edit_Urutan').val(btn.data('urutan'));
                $('#edit_Status').val(btn.data('status'));
                $('#modalEditDetail').modal('show');
            });

            $('#formEditDetail').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_detail_id').val();
                var btn = $('#btnUpdateDetail');
                var formData = new FormData(this);
                formData.append('_method', 'PUT');

                btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin mr-1"></i> Updating...');

                $.ajax({
                    url: '{{ route('jenis-laporan.details.update', ['jenisId' => ':jenisId', 'id' => ':id']) }}'
                         .replace(':jenisId', jenisId)
                         .replace(':id', id),
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    success: function(res) {
                        if (res.status === 200) {
                            Swal.fire({ icon: 'success', title: 'Berhasil!', text: res.message, timer: 1500, showConfirmButton: false });
                            $('#modalEditDetail').modal('hide');
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON?.message ?? 'Terjadi kesalahan.', 'error');
                    },
                    complete: function() {
                        btn.prop('disabled', false).html('<i class="fa fa-save mr-1"></i> Update');
                    }
                });
            });

            // ==========================================
            // ✅ 3. DELETE DETAIL (AJAX)
            // ==========================================
            $('body').on('click', '.btn-delete-detail', function() {
                var btn = $(this);
                var id = btn.data('id');
                var judul = btn.data('judul');

                Swal.fire({
                    title: 'Hapus Dokumen?',
                    html: `Hapus <strong>"${judul}"</strong>?<br><small class="text-muted">File akan dihapus permanen.</small>`,
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
                            url: '{{ route('jenis-laporan.details.destroy', ['jenisId' => ':jenisId', 'id' => ':id']) }}'
                                 .replace(':jenisId', jenisId)
                                 .replace(':id', id),
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function(res) {
                                Swal.fire({ icon: 'success', title: 'Dihapus!', text: res.message, timer: 1500, showConfirmButton: false });
                                location.reload();
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', xhr.responseJSON?.message ?? 'Error', 'error');
                                btn.prop('disabled', false).html('<i class="fa fa-trash"></i>');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

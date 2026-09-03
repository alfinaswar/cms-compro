@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Anggota: {{ $section->JudulSection }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('struktur-organisasi.index') }}">Struktur Organisasi</a>
                        </li>
                        <li class="breadcrumb-item active">Anggota</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row mb-3">
            <div class="col-md-6">
                <!-- Tombol Kembali ke Section -->
                <a href="{{ route('struktur-organisasi.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left mr-2"></i>Kembali ke Struktur
                </a>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <!-- Tombol Tambah Anggota -->
                <a href="{{ route('struktur-organisasi.anggota.create', $section->id) }}" class="btn btn-primary">
                    <i class="fa fa-user-plus mr-2"></i>Tambah Anggota Baru
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-info">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fa fa-list mr-2"></i>Daftar Anggota {{ $section->JudulSection }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <table id="tableStruktur" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 5%" class="text-center">No</th>
                                    <th style="width: 15%" class="text-center">Foto</th>
                                    <th style="width: 25%">Nama Lengkap</th>
                                    <th style="width: 20%">Jabatan</th>
                                    <th style="width: 15%" class="text-center">Urutan</th>
                                    <th style="width: 10%" class="text-center">Status</th>
                                    <th style="width: 10%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data akan dimuat via AJAX oleh DataTables -->
                            </tbody>
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
            var table = $('#tableStruktur').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('struktur-organisasi.anggota.index', $section->id) }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'PathFoto',
                        name: 'PathFoto',
                        orderable: false,
                        searchable: false,
                        className: "text-center",

                    },
                    {
                        data: 'NamaLengkap',
                        name: 'NamaLengkap',
                        render: function(data, type, row) {
                            let deskripsi = row.DeskripsiSingkat ?
                                `<br><small class="text-muted">${row.DeskripsiSingkat}</small>` :
                                '';
                            return `<strong>${data}</strong>` + deskripsi;
                        }
                    },
                    {
                        data: 'Jabatan',
                        name: 'Jabatan',
                        render: function(data) {
                            return `<span class="badge badge-pill badge-outline-primary">${data}</span>`;
                        }
                    },
                    {
                        data: 'Urutan',
                        name: 'Urutan',
                        className: "text-center"
                    },
                    {
                        data: 'Status',
                        name: 'Status',
                        orderable: false,
                        searchable: false,
                        className: "text-center",

                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: "text-center"
                    }
                ],
                order: [
                    [4, 'asc']
                ],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    loadingRecords: "Memuat...",
                    zeroRecords: "Tidak ada anggota",
                    emptyTable: "Belum ada anggota di section ini.",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "›",
                        previous: "‹"
                    },
                }
            });

            // 🔥 DELETE WITH SWEETALERT2 + AJAX 🔥
            $('#tableStruktur').on('click', '.btn-delete-confirm', function(e) {
                e.preventDefault();

                var button = $(this);
                var deleteUrl = button.data('url');
                var namaAnggota = button.data('nama');

                Swal.fire({
                    title: 'Hapus Anggota?',
                    html: `Apakah Anda yakin ingin menghapus <strong>"${namaAnggota}"</strong>?<br><small class="text-muted">Data akan dipindahkan ke tempat sampah (soft delete).</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Tampilkan loading pada tombol
                        button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Dihapus!',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                // Reload tabel tanpa refresh halaman
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Gagal!',
                                    xhr.responseJSON?.message ??
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                                // Kembalikan tombol ke keadaan semula jika error
                                button.prop('disabled', false).html(
                                    '<i class="fa fa-trash"></i>');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

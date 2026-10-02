@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Daftar Pelamar</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('karir.index') }}">Lowongan Kerja</a></li>
                        <li class="breadcrumb-item active">Pelamar</li>
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
                        <h3 class="card-title">
                            <i class="fa fa-users mr-2"></i>
                            Pelamar untuk: <strong>{{ $lowongan->Posisi }}</strong>
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('karir.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fa fa-arrow-left mr-1"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="tablePelamar" class="table table-bordered table-striped" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>No. HP</th>
                                    <th>Ekspetasi Gaji</th>
                                    <th>CV</th>
                                    <th>Tanggal Lamar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Detail Pelamar -->
    <div class="modal fade" id="modalDetailPelamar" tabindex="-1" role="dialog" aria-labelledby="modalDetailPelamarLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="modalDetailPelamarLabel">
                        <i class="fa fa-user mr-2"></i> Detail Pelamar
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Nama Lengkap</th>
                                    <td id="detail-nama">-</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td id="detail-email">-</td>
                                </tr>
                                <tr>
                                    <th>No. HP</th>
                                    <td id="detail-hp">-</td>
                                </tr>
                                <tr>
                                    <th>Ekspetasi Gaji</th>
                                    <td id="detail-gaji">-</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lamar</th>
                                    <td id="detail-tanggal">-</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td id="detail-status">-</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Deskripsi Singkat:</strong></h6>
                            <div id="detail-deskripsi" class="border p-3 rounded"
                                style="min-height: 150px; max-height: 300px; overflow-y: auto;">
                                -
                            </div>
                            <div class="mt-3">
                                <h6><strong>CV:</strong></h6>
                                <div id="detail-cv">-</div>
                            </div>
                        </div>
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
    <script>
        $(document).ready(function() {
            $('#tablePelamar').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('karir.pelamar', encrypt($lowongan->id)) }}"
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Memuat...</span>',
                    paginate: {
                        next: '<i class="fa fa-angle-double-right"></i>',
                        previous: '<i class="fa fa-angle-double-left"></i>'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'NamaLengkap',
                        name: 'NamaLengkap'
                    },
                    {
                        data: 'EmailLink',
                        name: 'Email',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'NoHpLink',
                        name: 'NoHp',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'EkspetasiGajiFormatted',
                        name: 'EkspetasiGaji',
                        orderable: false
                    },
                    {
                        data: 'CV',
                        name: 'CV',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'TanggalLamar',
                        name: 'created_at'
                    },
                    {
                        data: 'StatusDropdown',
                        name: 'Status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Change Status Handler
            $('body').on('change', '.change-status', function() {
                var id = $(this).data('id');
                var newStatus = $(this).val();
                var selectElement = $(this);

                Swal.fire({
                    title: 'Ubah Status?',
                    text: "Ubah status pelamar menjadi " + newStatus + "?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Ubah!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('karir.update-status', ':id') }}'.replace(':id',
                                id),
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                Status: newStatus
                            },
                            success: function(response) {
                                if (response.status === 200) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: response.message,
                                        iconColor: '#4BCC1F',
                                        confirmButtonText: 'Oke',
                                        confirmButtonColor: '#4BCC1F',
                                    });
                                    $('#tablePelamar').DataTable().ajax.reload();
                                } else {
                                    Swal.fire('Gagal!', response.message, 'error');
                                    selectElement.val(selectElement.find(
                                        'option:selected').prev().val());
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Gagal!',
                                    xhr.responseJSON?.message ??
                                    'Terjadi kesalahan saat mengubah status.',
                                    'error'
                                );
                                selectElement.val(selectElement.find('option:selected')
                                    .prev().val());
                            }
                        });
                    } else {
                        selectElement.val(selectElement.find('option:selected').prev().val());
                    }
                });
            });

            // Detail Handler
            $('body').on('click', '.btn-detail', function() {
                $('#detail-nama').text($(this).data('nama'));

                var email = $(this).data('email');
                $('#detail-email').html('<a href="mailto:' + email +
                    '" class="text-primary"><i class="fa fa-envelope mr-1"></i>' + email + '</a>');

                var hp = $(this).data('hp');
                var waNumber = hp.replace(/^0/, '62').replace(/[^0-9]/g, '');
                $('#detail-hp').html('<a href="https://wa.me/' + waNumber +
                    '" target="_blank" class="text-success"><i class="fab fa-whatsapp mr-1"></i>' + hp +
                    '</a>');

                $('#detail-gaji').text($(this).data('gaji'));
                $('#detail-tanggal').text($(this).data('tanggal'));
                $('#detail-deskripsi').html($(this).data('deskripsi'));

                var status = $(this).data('status');
                var badgeClass = {
                    'Menunggu': 'badge-warning',
                    'Diterima': 'badge-success',
                    'Ditolak': 'badge-danger'
                } [status] || 'badge-secondary';
                $('#detail-status').html('<span class="badge ' + badgeClass + '">' + status + '</span>');

                var cv = $(this).data('cv');
                if (cv) {
                    $('#detail-cv').html('<a href="' + cv +
                        '" target="_blank" class="btn btn-sm btn-info"><i class="fa fa-download mr-1"></i> Download CV</a>'
                    );
                } else {
                    $('#detail-cv').html('<span class="text-muted">Tidak ada CV</span>');
                }

                $('#modalDetailPelamar').modal('show');
            });
        });
    </script>
@endpush

@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Logo Klien</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Logo Klien</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row mb-3">
            <div class="col d-flex justify-content-end">
                <a class="btn btn-primary" href="{{ route('client-logo.create') }}">
                    <i class="fa fa-plus mr-2"></i> Tambah Logo Baru
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fa fa-images mr-2"></i>Daftar Logo Partner & Sertifikasi
                        </h3>
                    </div>
                    <div class="card-body">
                        <table id="tableClientLogo" class="table table-bordered table-striped" style="width: 100%;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 5%" class="text-center">No</th>
                                    <th style="width: 15%" class="text-center">Preview</th>
                                    <th style="width: 25%">Nama Partner</th>
                                    <th style="width: 15%">Tipe</th>
                                    <th style="width: 10%" class="text-center">Urutan</th>
                                    <th style="width: 10%" class="text-center">Status</th>
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
@endsection

@push('scripts')
    @if (Session::get('success'))
        <script>
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: '{{ Session::get('success') }}', iconColor: '#4BCC1F', confirmButtonColor: '#4BCC1F' });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            // DataTables
            var table = $('#tableClientLogo').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: { url: "{{ route('client-logo.index') }}" },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>',
                    emptyTable: 'Tidak ada data logo',
                    paginate: { next: '>>', previous: '<<' }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'PreviewLogo', name: 'PathLogo', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'NamaPartner', name: 'NamaPartner' },
                    { data: 'TipeBadge', name: 'Tipe', orderable: false, className: 'text-center' },
                    { data: 'Urutan', name: 'Urutan', className: 'text-center' },
                    { data: 'StatusBadge', name: 'Status', orderable: false, className: 'text-center' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ],
                order: [[4, 'asc']] // Sort by Urutan
            });

            // Delete with SweetAlert
            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Logo?',
                    html: `Apakah Anda yakin ingin menghapus logo <strong>"${nama}"</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('client-logo.destroy', ':id') }}'.replace(':id', id),
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            success: function(res) {
                                Swal.fire('Dihapus!', res.message, 'success');
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', xhr.responseJSON?.message ?? 'Error', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

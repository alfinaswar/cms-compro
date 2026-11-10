@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Lapisan Keamanan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('homepage.index') }}">Homepage</a></li>
                        <li class="breadcrumb-item active">Lapisan Keamanan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fa fa-shield-alt text-primary mr-2"></i><strong>Daftar Lapisan Keamanan (Security Tiers)</strong>
                        </h3>
                        <div class="ml-auto">
                            @can('homepage.create')
                            <a href="{{ route('security-tier.create') }}" class="btn btn-primary btn-sm px-3">
                                <i class="fa fa-plus mr-1"></i> Tambah Lapisan Keamanan
                            </a>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="tableSecurityTier" class="table table-bordered table-striped" style="width: 100%;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 5%" class="text-center">No</th>
                                    <th style="width: 8%" class="text-center">Tier</th>
                                    <th style="width: 8%" class="text-center">Icon</th>
                                    <th style="width: 20%">Judul (ID)</th>
                                    <th style="width: 24%">Deskripsi (ID)</th>
                                    <th style="width: 20%">Sub-Fitur</th>
                                    <th style="width: 5%" class="text-center">Urutan</th>
                                    <th style="width: 5%" class="text-center">Status</th>
                                    <th style="width: 5%" class="text-center">Aksi</th>
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
<script>
    $(document).ready(function() {
        var table = $('#tableSecurityTier').DataTable({
            responsive: true,
            serverSide: true,
            processing: true,
            bDestroy: true,
            ajax: {
                url: "{{ route('security-tier.index') }}"
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
                { data: 'NomorTier', name: 'NomorTier', className: 'text-center' },
                { data: 'Icon', name: 'Icon', className: 'text-center' },
                { data: 'Judul', name: 'Judul' },
                { data: 'Deskripsi', name: 'Deskripsi' },
                { data: 'SubFitur', name: 'SubFitur' },
                { data: 'Urutan', name: 'Urutan', className: 'text-center' },
                { data: 'status', name: 'status', className: 'text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ]
        });

        $(document).on('click', '.btn-delete-tier', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data lapisan keamanan ini akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('admin/pengaturan/landing-page/security-tier') }}/" + id,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', response.message || 'Data berhasil dihapus.', 'success');
                            table.ajax.reload(null, false);
                        },
                        error: function(xhr) {
                            Swal.fire('Error!', xhr.responseJSON ? xhr.responseJSON.message : 'Gagal menghapus data.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

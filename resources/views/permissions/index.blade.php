@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fa fa-key mr-2"></i>Manajemen Permission</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Permission</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Daftar Permission</h3>
                        <a href="{{ route('permissions.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus mr-1"></i> Tambah Permission
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="permissionsTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="25%">Permission Name</th>
                                    <th width="15%">Modul</th>
                                    <th width="20%">Aksi</th>
                                    <th width="15%">Created At</th>
                                    <th width="20%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
$(function() {
    var table = $('#permissionsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('permissions.index') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'module', name: 'module'},
            {data: 'action_name', name: 'action_name'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        order: [[1, 'asc']],
        pageLength: 25,
        language: {
            search: "Cari:",
            paginate: {
                next: "Next >",
                previous: "< Prev"
            }
        }
    });

    // Delete confirmation
    $(document).on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');

        if (confirm('Apakah Anda yakin ingin menghapus permission "' + name + '"?')) {
            $.ajax({
                url: '{{ route("permissions.index") }}/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    table.draw();
                    alert('Permission berhasil dihapus.');
                },
                error: function() {
                    alert('Terjadi kesalahan saat menghapus permission.');
                }
            });
        }
    });
});
</script>
@endpush
@endsection

@extends('layouts.app')

@section('content')
@push('styles')
<style>
    .permission-preview {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        margin-top: 20px;
    }
    .permission-preview-text {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        font-family: monospace;
    }
    /* .form-control-modern {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.2s ease;
    }
    .form-control-modern:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    } */
</style>
@endpush

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fa fa-edit mr-2"></i>Edit Permission</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">Permission</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-key mr-2"></i>Informasi Permission</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle mr-2"></i>
                            <strong>Format Permission:</strong> <code>modul.aksi</code> (contoh: <code>berita.view</code>, <code>user.create</code>)
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="module"><strong>Pilih Modul</strong> <span class="text-danger">*</span></label>
                                    <select name="module" id="module" class="form-control form-control-modern @error('module') is-invalid @enderror" required>
                                        <option value="">-- Pilih Modul --</option>
                                        @foreach($modules as $value => $label)
                                            <option value="{{ $value }}" {{ $module == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('module')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="action"><strong>Pilih Aksi</strong> <span class="text-danger">*</span></label>
                                    <select name="action" id="action" class="form-control form-control-modern @error('action') is-invalid @enderror" required>
                                        <option value="">-- Pilih Aksi --</option>
                                        @foreach($actions as $value => $label)
                                            <option value="{{ $value }}" {{ $action == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('action')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="permission-preview">
                            <p class="mb-2 text-muted">Permission Name:</p>
                            <div class="permission-preview-text" id="permissionPreview">{{ $permission->name }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h3 class="card-title mb-0"><i class="fa fa-info-circle mr-2"></i>Informasi</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Permission Saat Ini:</strong></p>
                        <code class="d-block p-2 bg-light rounded mb-3">{{ $permission->name }}</code>
                        <p class="mb-0"><small class="text-muted">Ubah modul atau aksi di atas untuk mengubah nama permission.</small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary" style="padding: 10px 32px; font-weight: 600;">
                            <i class="fa fa-save mr-2"></i>Update Permission
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

@push('scripts')
<script>
$(document).ready(function() {
    function updatePreview() {
        var module = $('#module').val();
        var action = $('#action').val();

        if (module && action) {
            $('#permissionPreview').text(module + '.' + action);
        }
    }

    $('#module, #action').on('change', updatePreview);
});
</script>
@endpush
@endsection

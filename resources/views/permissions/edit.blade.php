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

            .form-control[readonly] {
                background-color: #f1f5f9 !important;
                cursor: not-allowed;
            }

            .permission-locked-notice {
                background: #fef3c7;
                border: 1px solid #fbbf24;
                border-radius: 8px;
                padding: 12px 16px;
                color: #92400e;
                font-size: 13px;
            }
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
        <form action="{{ route('permissions.update', $permission->id) }}" method="POST" id="formPermission">
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
                                <strong>Format Permission:</strong> <code>modul.aksi</code> (contoh:
                                <code>berita.view</code>, <code>user.create</code>)
                            </div>

                            {{-- ✅ Peringatan jika permission terikat role --}}
                            @if ($permission->roles()->count() > 0)
                                <div class="permission-locked-notice mb-3">
                                    <i class="fa fa-lock mr-2"></i>
                                    <strong>Nama tidak dapat diubah</strong> karena permission ini sudah digunakan oleh
                                    <strong>{{ $permission->roles()->count() }} role</strong>.
                                    Hapus permission ini dan buat baru jika butuh nama berbeda.
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="module"><strong>Pilih Modul</strong> <span
                                                class="text-danger">*</span></label>
                                        <select name="module" id="module"
                                            class="form-control @error('module') is-invalid @enderror"
                                            {{ !empty($customName) ? 'readonly' : '' }}>
                                            <option value="">-- Pilih Modul --</option>
                                            @foreach ($modules as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ old('module', $module) == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('module')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted">Modul atau grup dari permission ini</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="action"><strong>Pilih Aksi</strong> <span
                                                class="text-danger">*</span></label>
                                        <select name="action" id="action"
                                            class="form-control @error('action') is-invalid @enderror"
                                            {{ !empty($customName) ? 'readonly' : '' }}>
                                            <option value="">-- Pilih Aksi --</option>
                                            @foreach ($actions as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ old('action', $action) == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('action')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                        <small class="text-muted">Aksi yang dapat dilakukan pada modul</small>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="custom_name"><strong>Atau Tulis Manual</strong></label>
                                <input type="text" name="custom_name" id="custom_name" class="form-control"
                                    placeholder="Contoh: berita.view, user.manage"
                                    value="{{ old('custom_name', $customName) }}">
                                <small class="text-muted">Kosongkan jika menggunakan pilihan di atas. Format:
                                    <code>modul.aksi</code></small>
                                @error('custom_name')
                                    <span class="text-danger d-block mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Preview Permission Name --}}
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

                            <h6><strong>Contoh Format:</strong></h6>
                            <ul class="mb-0" style="padding-left: 20px;">
                                <li class="mb-2"><code>berita.view</code></li>
                                <li class="mb-2"><code>berita.create</code></li>
                                <li class="mb-2"><code>user.edit</code></li>
                                <li class="mb-2"><code>role.delete</code></li>
                            </ul>
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
                var originalName = '{{ $permission->name }}';

                function updatePreview() {
                    var module = $('#module').val();
                    var action = $('#action').val();
                    var custom = $('#custom_name').val().trim();

                    if (custom) {
                        $('#permissionPreview').text(custom);
                        $('#module, #action').prop('readonly', true);
                    } else {
                        $('#module, #action').prop('readonly', false);
                        if (module && action) {
                            $('#permissionPreview').text(module + '.' + action);
                        } else {
                            $('#permissionPreview').text('modul.aksi');
                        }
                    }

                    // ✅ Validasi visual: nama tidak boleh diubah
                    var previewText = $('#permissionPreview').text();
                    if (previewText !== 'modul.aksi' && previewText !== originalName) {
                        $('#permissionPreview').css('color', '#dc2626');
                        if (!$('#nameChangeWarning').length) {
                            $('.permission-preview').append(
                                '<div id="nameChangeWarning" class="mt-2 text-danger small">' +
                                '<i class="fa fa-exclamation-triangle mr-1"></i>' +
                                'Nama akan berubah! Permission terikat role tidak boleh diubah namanya.' +
                                '</div>'
                            );
                        }
                    } else {
                        $('#permissionPreview').css('color', '#1e293b');
                        $('#nameChangeWarning').remove();
                    }
                }

                $('#module, #action, #custom_name').on('input change', updatePreview);

                // ✅ Sebelum submit: pastikan field readonly tetap terkirim
                $('#formPermission').on('submit', function() {
                    $('#module, #action').prop('readonly', false);
                });

                updatePreview();
            });
        </script>
    @endpush
@endsection

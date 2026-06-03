@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Role</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12">
                <form action="{{ route('roles.store') }}" method="POST" id="formRoleCreate">
                    @csrf
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h3 class="card-title mb-0">
                                <i class="fa fa-user-tag me-2 text-primary"></i>
                                Tambah Role / Hak Akses Baru
                            </h3>
                        </div>
                        <div class="card-body">
                            {{-- Name Field --}}
                            <div class="form-group mb-4">
                                <label for="name" class="form-label">
                                    <strong><i class="fa fa-tag me-1 text-muted"></i> Nama Role</strong>
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">
                                        <i class="fa fa-user-tag text-muted"></i>
                                    </span>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Contoh: Admin, Staff, Manager" value="{{ old('name') }}" autofocus>
                                </div>
                                @error('name')
                                    <span class="invalid-feedback d-block mt-1 fadeIn">
                                        <i class="fa fa-exclamation-circle me-1"></i> {{ $message }}
                                    </span>
                                @enderror
                                <small class="form-text text-muted mt-1">
                                    <i class="fa fa-info-circle"></i> Gunakan nama yang jelas dan deskriptif.
                                </small>
                            </div>

                            {{-- Permissions Field --}}
                            <div class="form-group mb-3">
                                <label class="form-label">
                                    <strong><i class="fa fa-key me-1 text-muted"></i> Permission</strong>
                                </label>
                                <div class="card bg-light border-0">
                                    <div class="card-body py-3" style="max-height: 300px; overflow-y: auto;">
                                        <div class="row">
                                            @foreach ($permission as $value)
                                                <div class="col-md-6 col-lg-4 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="permission[]"
                                                            value="{{ $value->id }}" id="permission_{{ $value->id }}"
                                                            {{ collect(old('permission'))->contains($value->id) ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="permission_{{ $value->id }}">
                                                            {{ $value->name }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @error('permission')
                                    <span class="invalid-feedback d-block mt-1 fadeIn">
                                        <i class="fa fa-exclamation-circle me-1"></i> {{ $message }}
                                    </span>
                                @enderror
                                <small class="form-text text-muted mt-1">
                                    <i class="fa fa-lightbulb"></i> Pilih minimal satu permission untuk role ini.
                                </small>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary me-3">
                                <i class="fa fa-times me-2"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary ms-2">
                                <i class="fa fa-save me-2"></i> Simpan Role
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fadeIn {
            animation: fadeIn 0.2s ease-in-out;
        }

        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        .card-body::-webkit-scrollbar {
            width: 6px;
        }

        .card-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .card-body::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .card-body::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#select-all').on('click', function() {
                $('.form-check-input[name="permission[]"]').prop('checked', this.checked);
            });
            $('.form-check-input[name="permission[]"]').on('change', function() {
                if (!this.checked) {
                    $('#select-all').prop('checked', false);
                }
            });
        });
    </script>
@endpush

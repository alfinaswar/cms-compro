@extends('layouts.app')

@section('content')
@push('styles')
<style>
    /* Modern Role Form Styling */
    .role-form-container {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }

    .module-group {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.2s ease;
    }

    .module-group:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }

    .module-header {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .module-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .module-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #fff;
    }

    .module-info h5 {
        margin: 0;
        font-weight: 700;
        font-size: 15px;
        color: #1e293b;
    }

    .module-info small {
        color: #64748b;
        font-size: 12px;
    }

    .module-badge {
        background: #e0f2fe;
        color: #0284c7;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .module-body {
        padding: 20px;
    }

    .permission-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    @media (max-width: 768px) {
        .permission-grid {
            grid-template-columns: 1fr;
        }
    }

    .permission-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }

    .permission-item:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
        transform: translateY(-1px);
    }

    .permission-item.checked {
        background: #eff6ff;
        border-color: #3b82f6;
    }

    .permission-item input[type="checkbox"] {
        width: 18px;
        height: 18px;
        margin-right: 10px;
        cursor: pointer;
        accent-color: #3b82f6;
    }

    .permission-item label {
        margin: 0;
        cursor: pointer;
        font-size: 14px;
        color: #334155;
        font-weight: 500;
        flex: 1;
    }

    .permission-item.checked label {
        color: #1e40af;
        font-weight: 600;
    }

    .module-select-all {
        display: flex;
        align-items: center;
        padding: 10px 16px;
        background: #f1f5f9;
        border-radius: 8px;
        margin-bottom: 12px;
        cursor: pointer;
    }

    .module-select-all input {
        width: 18px;
        height: 18px;
        margin-right: 10px;
        accent-color: #3b82f6;
    }

    .module-select-all label {
        margin: 0;
        font-weight: 600;
        font-size: 14px;
        color: #475569;
        cursor: pointer;
    }

    /* Top action bar */
    .top-action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 16px 20px;
        background: #f8fafc;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }

    .btn-mark-all {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-mark-all:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .btn-mark-all.unmark {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .btn-mark-all.unmark:hover {
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    .form-control-modern {
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .form-control-modern:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .section-subtitle {
        font-size: 13px;
        color: #64748b;
    }
</style>
@endpush

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fa fa-user-shield mr-2"></i>Tambah Role Baru</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <form action="{{ route('roles.store') }}" method="POST" id="roleForm">
        @csrf
        <div class="row">
            <div class="col-lg-12">

                {{-- IDENTITAS ROLE --}}
                <div class="role-form-container p-4 mb-4">
                    <h4 class="section-title">
                        <i class="fa fa-id-card mr-2 text-primary"></i>Identitas Peran Pengguna
                    </h4>
                    <p class="section-subtitle mb-3">Informasi dasar untuk role yang akan dibuat</p>

                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <div class="form-group mb-0">
                                <label for="name"><strong>Nama Role</strong> <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control form-control-modern @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    placeholder="Contoh: Admin, Editor, Viewer"
                                    required>
                                @error('name')
                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <small class="text-muted">Nama role harus unik dan wajib diisi</small>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <button type="button" class="btn-mark-all" id="btnMarkAll">
                                <i class="fa fa-check-double"></i>
                                <span id="markAllText">Tandai Semua Modul</span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- PENGATURAN HAK AKSES --}}
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="section-title mb-1">
                            <i class="fa fa-shield-alt mr-2 text-primary"></i>Pengaturan Hak Akses
                        </h4>
                        <p class="section-subtitle mb-0">Pilih wewenang operasional untuk role ini</p>
                    </div>
                    <span class="badge badge-info" style="font-size: 13px; padding: 6px 12px;">
                        {{ count($groupedPermissions) }} Grup Kategori
                    </span>
                </div>

                {{-- MODULE GROUPS --}}
                @foreach ($groupedPermissions as $module => $permissions)
                    @php
                        $meta = $moduleMeta[$module] ?? $moduleMeta['general'];
                        $moduleCount = count($permissions);
                    @endphp
                    <div class="module-group" data-module="{{ $module }}">
                        <div class="module-header">
                            <div class="module-title">
                                <div class="module-icon bg-{{ $meta['color'] }}">
                                    <i class="fa {{ $meta['icon'] }}"></i>
                                </div>
                                <div class="module-info">
                                    <h5>{{ $meta['label'] }}</h5>
                                    <small>{{ $meta['description'] }}</small>
                                </div>
                            </div>
                            <span class="module-badge">{{ $moduleCount }} Modul</span>
                        </div>
                        <div class="module-body">
                            {{-- Select All untuk modul ini --}}
                            <div class="module-select-all" data-module="{{ $module }}">
                                <input type="checkbox" id="select-all-{{ $module }}" class="module-checkbox">
                                <label for="select-all-{{ $module }}">Pilih semua permission di modul ini</label>
                            </div>

                            <div class="permission-grid">
                                @foreach ($permissions as $perm)
                                    <div class="permission-item" data-permission="{{ $perm['name'] }}">
                                        <input type="checkbox"
                                            name="permissions[]"
                                            value="{{ $perm['name'] }}"
                                            id="perm-{{ Str::slug($perm['name']) }}"
                                            class="permission-checkbox"
                                            data-module="{{ $module }}">
                                        <label for="perm-{{ Str::slug($perm['name']) }}">
                                            {{ $perm['label'] }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- ACTION BUTTONS --}}
                <div class="role-form-container p-4 mt-4">

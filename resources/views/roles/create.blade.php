@extends('layouts.app')

@section('content')
@push('styles')
<style>
    .role-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 20px;
        overflow: hidden;
        transition: all 0.2s ease;
    }
    .role-card:hover {
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        border-color: #cbd5e1;
    }
    .role-card-header {
        background: #f8fafc;
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .role-card-title {
        font-weight: 700;
        font-size: 15px;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .role-card-title i {
        color: #3b82f6;
    }
    .role-badge {
        background: #e0f2fe;
        color: #0284c7;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .role-card-body {
        padding: 20px;
    }
    .permission-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 12px;
    }
    .permission-item {
        display: flex;
        align-items: center;
        padding: 10px 14px;
        background: #f8fafc;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .permission-item:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
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
    .select-all-wrapper {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        background: #f1f5f9;
        border-radius: 8px;
        margin-bottom: 16px;
        cursor: pointer;
        border: 1px dashed #cbd5e1;
    }
    .select-all-wrapper input {
        width: 18px;
        height: 18px;
        margin-right: 10px;
        accent-color: #3b82f6;
    }
    .select-all-wrapper label {
        margin: 0;
        font-weight: 600;
        font-size: 14px;
        color: #475569;
        cursor: pointer;
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
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h5 class="mb-3"><i class="fa fa-id-card mr-2 text-primary"></i>Identitas Peran</h5>
                        <div class="row">
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
                                </div>
                            </div>
                            <div class="col-md-6 d-flex align-items-end justify-content-end">
                                <button type="button" class="btn btn-info" id="btnToggleAll" style="min-width: 180px;">
                                    <i class="fa fa-check-double mr-2"></i>
                                    <span id="toggleAllText">Pilih Semua Permission</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DAFTAR PERMISSION TERKELOMPOK --}}
                @foreach ($groupedPermissions as $module => $permissions)
                    <div class="role-card" data-module="{{ $module }}">
                        <div class="role-card-header">
                            <div class="role-card-title">
                                <i class="fa fa-folder-open"></i>
                                {{ $module }}
                            </div>
                            <span class="role-badge">{{ count($permissions) }} Hak Akses</span>
                        </div>
                        <div class="role-card-body">
                            {{-- Select All per Modul --}}
                            <div class="select-all-wrapper" data-module="{{ $module }}">
                                <input type="checkbox" id="select-all-{{ $module }}" class="module-checkbox">
                                <label for="select-all-{{ $module }}">Pilih semua di modul ini</label>
                            </div>

                            <div class="permission-grid">
                                @foreach ($permissions as $perm)
                                    <div class="permission-item" data-permission="{{ $perm['name'] }}">
                                        <input type="checkbox"
                                            name="permission[]"
                                            value="{{ $perm['id'] }}"
                                            id="perm-{{ $perm['id'] }}"
                                            class="permission-checkbox"
                                            data-module="{{ $module }}">
                                        <label for="perm-{{ $perm['id'] }}">
                                            {{ $perm['label'] }}
                                            <small class="text-muted d-block" style="font-size: 11px; font-weight: 400;">({{ $perm['name'] }})</small>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- ACTION BUTTONS --}}
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left mr-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary" style="padding: 10px 32px; font-weight: 600;">
                            <i class="fa fa-save mr-2"></i>Simpan Role
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
    // 1. Toggle visual style saat checkbox berubah
    $(document).on('change', '.permission-checkbox', function() {
        const item = $(this).closest('.permission-item');
        if ($(this).is(':checked')) {
            item.addClass('checked');
        } else {
            item.removeClass('checked');
        }
        updateModuleCheckbox($(this).data('module'));
        updateToggleAllButton();
    });

    // 2. Klik pada area permission-item juga toggle checkbox
    $(document).on('click', '.permission-item', function(e) {
        if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'LABEL' && e.target.tagName !== 'SMALL') {
            const checkbox = $(this).find('.permission-checkbox');
            checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
        }
    });

    // 3. Select All per modul
    $(document).on('change', '.module-checkbox', function() {
        const module = $(this).closest('.select-all-wrapper').data('module');
        const isChecked = $(this).is(':checked');

        $(`.permission-checkbox[data-module="${module}"]`).prop('checked', isChecked).trigger('change');
        updateToggleAllButton();
    });

    // 4. Toggle Semua Modul (Global)
    let allMarked = false;
    $('#btnToggleAll').on('click', function() {
        allMarked = !allMarked;
        $('.permission-checkbox').prop('checked', allMarked).trigger('change');
        $('.module-checkbox').prop('checked', allMarked).prop('indeterminate', false);

        if (allMarked) {
            $(this).removeClass('btn-info').addClass('btn-danger');
            $('#toggleAllText').text('Batal Pilih Semua');
        } else {
            $(this).removeClass('btn-danger').addClass('btn-info');
            $('#toggleAllText').text('Pilih Semua Permission');
        }
    });

    // 5. Update status checkbox modul (checked, unchecked, atau indeterminate)
    function updateModuleCheckbox(module) {
        const total = $(`.permission-checkbox[data-module="${module}"]`).length;
        const checked = $(`.permission-checkbox[data-module="${module}"]:checked`).length;
        const moduleCheckbox = $(`#select-all-${module}`);

        if (checked === 0) {
            moduleCheckbox.prop('checked', false).prop('indeterminate', false);
        } else if (checked === total) {
            moduleCheckbox.prop('checked', true).prop('indeterminate', false);
        } else {
            moduleCheckbox.prop('checked', false).prop('indeterminate', true);
        }
    }

    // 6. Update tombol global
    function updateToggleAllButton() {
        const total = $('.permission-checkbox').length;
        const checked = $('.permission-checkbox:checked').length;

        if (checked === total && total > 0) {
            allMarked = true;
            $('#btnToggleAll').removeClass('btn-info').addClass('btn-danger');
            $('#toggleAllText').text('Batal Pilih Semua');
        } else {
            allMarked = false;
            $('#btnToggleAll').removeClass('btn-danger').addClass('btn-info');
            $('#toggleAllText').text('Pilih Semua Permission');
        }
    }

    // 7. Konfirmasi jika submit tanpa permission
    $('#roleForm').on('submit', function(e) {
        if ($('.permission-checkbox:checked').length === 0) {
            if (!confirm('Anda belum memilih hak akses apapun. Yakin ingin melanjutkan?')) {
                e.preventDefault();
            }
        }
    });
});
</script>
@endpush
@endsection

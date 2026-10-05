@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            body {
                background: #f7fafc !important;
            }

            /* ===== LAYOUT UTAMA ===== */
            .role-layout {
                display: grid;
                grid-template-columns: 330px 1fr;
                gap: 28px;
                align-items: flex-start;
                margin-bottom: 0;
            }

            @media (max-width: 991px) {
                .role-layout {
                    grid-template-columns: 1fr;
                    gap: 10px;
                }

                .role-sidebar {
                    position: static !important;
                    top: auto !important;
                    max-height: none !important;
                }

                .sidebar-card {
                    max-height: none !important;
                }

                .sidebar-body {
                    max-height: 400px;
                }

                /* Mobile: scroll internal terbatas */
            }

            /* ===== SIDEBAR ===== */
            .role-sidebar {
                position: sticky;
                top: 32px;
                align-self: start;
                max-height: calc(100vh - 80px);
            }

            .sidebar-card {
                background: #fff;
                border-radius: 14px;
                box-shadow: 0 3px 24px rgba(43, 56, 92, 0.06);
                border: none;
                margin-bottom: 0;
                /* ✅ FLEX LAYOUT agar header fixed & body scrollable */
                display: flex;
                flex-direction: column;
                height: 100%;
                max-height: calc(100vh - 80px);
                overflow: hidden;
            }

            .sidebar-header {
                background: linear-gradient(122deg, #2563eb 0%, #3b82f6 100%);
                color: #fff;
                padding: 18px 20px;
                border-bottom: 1px solid #edf2fa;
                flex-shrink: 0;
                /* ✅ Header tidak ikut scroll */
            }

            .sidebar-header h5 {
                margin: 0 0 0.25em 0;
                font-size: 15px;
                font-weight: 600;
                letter-spacing: 0.5px;
            }

            .sidebar-header p {
                margin: 0;
                font-size: 12px;
                opacity: 0.83;
                font-weight: 400;
            }

            /* ✅ BODY SIDEBAR - INI YANG DI-SCROLL */
            .sidebar-body {
                flex: 1;
                overflow-y: auto;
                overflow-x: hidden;
                padding: 18px 18px 18px 18px;
                scrollbar-width: thin;
                scrollbar-color: #cbd5e1 transparent;
            }

            .sidebar-body::-webkit-scrollbar {
                width: 6px;
            }

            .sidebar-body::-webkit-scrollbar-track {
                background: transparent;
            }

            .sidebar-body::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 3px;
            }

            .sidebar-body::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            /* Counter */
            .total-counter {
                background: #f1f7ff;
                border-radius: 10px;
                padding: 16px;
                margin-bottom: 20px;
                display: flex;
                flex-direction: column;
                align-items: center;
                border: 1px dashed #cbd5e1;
                flex-shrink: 0;
            }

            .total-counter .count-number {
                font-size: 26px;
                font-weight: 700;
                color: #1e293b;
                margin-bottom: 3px;
                letter-spacing: 0.2px;
            }

            .total-counter .count-label {
                color: #5f7685;
                font-size: 12px;
                text-transform: uppercase;
                font-weight: 600;
                letter-spacing: 0.6px;
            }

            /* Navigasi Modul */
            .module-nav {
                list-style: none;
                padding: 0;
                margin: 0 0 18px 0;
            }

            .module-nav-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 4px;
                background: #f7fafd;
                border-radius: 9px;
                padding: 10px 15px;
                cursor: pointer;
                font-size: 14px;
                font-weight: 500;
                color: #445266;
                border: 2px solid transparent;
                transition: all 0.15s;
            }

            .module-nav-item.active {
                background: #e9f3ff;
                color: #2157d6;
                border-color: #2992fa;
                font-weight: 600;
            }

            .module-nav-item:hover:not(.active) {
                background: #f0f7ff;
            }

            .module-nav-item .nav-left {
                display: flex;
                align-items: center;
                gap: 10px;
                min-width: 0;
                flex: 1;
            }

            .module-nav-item .nav-left i {
                color: #94a3b8;
                font-size: 14px;
                flex-shrink: 0;
            }

            .module-nav-item.active .nav-left i {
                color: #2563eb;
            }

            .module-nav-item .nav-label {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .module-nav-item .nav-count {
                background: #dbeafe;
                color: #2563eb;
                font-size: 11px;
                font-weight: 700;
                padding: 2px 10px;
                border-radius: 12px;
                min-width: 40px;
                text-align: center;
                flex-shrink: 0;
            }

            .module-nav-item.active .nav-count {
                background: #2563eb;
                color: #fff;
            }

            .module-nav-item.has-checked .nav-count {
                background: #12b972;
                color: #fff;
            }

            .module-nav-item.has-checked.active .nav-count {
                background: #079767;
            }

            /* Global Actions */
            .global-actions {
                display: flex;
                flex-direction: column;
                gap: 9px;
                margin-top: 8px;
                padding-top: 16px;
                border-top: 1px solid #edf2fa;
                flex-shrink: 0;
            }

            .btn-global {
                width: 100%;
                padding: 11px;
                font-size: 13.5px;
                font-weight: 600;
                border-radius: 8px;
                border: none;
                cursor: pointer;
                background: #e7efff;
                color: #2157d6;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
                transition: all 0.16s;
            }

            .btn-global:active {
                filter: brightness(0.98);
            }

            .btn-select-all {
                background: linear-gradient(90deg, #2992fa 0%, #2563eb 91%);
                color: #fff;
            }

            .btn-select-all:hover {
                background: linear-gradient(90deg, #2563eb 0%, #2992fa 100%);
                color: #fff;
            }

            .btn-select-all.active {
                background: #ef4444;
                color: #fff;
            }

            .btn-select-all.active:hover {
                background: #dc2626;
            }

            .btn-select-all .fa {
                font-size: 15px;
            }

            .btn-reset {
                background: #fff;
                color: #475569;
                border: 1px solid #e2e8f0;
            }

            .btn-reset:hover,
            .btn-reset:focus {
                background: #f1f5f9;
                color: #2c3947;
            }

            /* ===== CONTENT AREA ===== */
            .role-content {
                background: #fff;
                border-radius: 14px;
                border: none;
                box-shadow: 0 3px 18px rgba(43, 56, 92, 0.066);
                min-height: 500px;
                margin-bottom: 0;
            }

            .content-header {
                padding: 22px 30px 16px 30px;
                background: #f4f8fc;
                border-bottom: 1px solid #edf2fa;
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-radius: 13px 13px 0 0;
            }

            .content-title {
                display: flex;
                align-items: center;
                gap: 14px;
            }

            .title-icon {
                width: 42px;
                height: 42px;
                border-radius: 11px;
                background: #e6f0ff;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #2563eb;
                font-size: 20px;
            }

            .content-title h4 {
                margin: 0;
                font-size: 16.5px;
                font-weight: 700;
                color: #2157d6;
                letter-spacing: 0.24px;
            }

            .content-title p {
                margin: 2px 0 0;
                font-size: 12.5px;
                color: #64748b;
            }

            /* Select All per Modul */
            .select-all-module {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 11px 22px;
                background: #f3f7fb;
                border-radius: 9px;
                cursor: pointer;
                border: 1.3px dashed #cbd5e1;
                margin: 22px 30px 13px 30px;
                transition: all 0.14s;
            }

            .select-all-module:hover {
                background: #e9f4ff;
            }

            .select-all-module input[type="checkbox"].module-checkbox {
                width: 20px;
                height: 20px;
                accent-color: #2563eb;
                cursor: pointer;
                flex-shrink: 0;
            }

            .select-all-module span {
                font-size: 13px;
                color: #4c5965;
            }

            .select-all-module strong {
                color: #2157d6;
            }

            .select-all-module .count-info {
                font-size: 12px;
                color: #64748b;
                font-weight: 500;
                margin-left: auto;
            }

            /* Permission Grid */
            .permission-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
                gap: 12px;
                padding: 0 30px 26px 30px;
            }

            .permission-item {
                display: flex;
                align-items: flex-start;
                gap: 11px;
                padding: 13px 16px 10px 12px;
                background: #f8fbfd;
                border: 2px solid #e2e8f0;
                border-radius: 8.5px;
                cursor: pointer;
                transition: all 0.15s;
                font-size: 13.5px;
            }

            .permission-item:hover {
                background: #f2f7fd;
                border-color: #b6dbfd;
                box-shadow: 0 1px 8px 0 rgba(0, 128, 255, 0.08);
            }

            .permission-item.checked {
                background: #e6f0ff;
                border-color: #3b82f6;
            }

            .permission-item input[type="checkbox"].permission-checkbox {
                width: 19px;
                height: 19px;
                margin-top: 1.5px;
                accent-color: #2563eb;
                flex-shrink: 0;
            }

            .permission-item label {
                margin: 0;
                cursor: pointer;
                font-size: 13.5px;
                color: #334155;
                font-weight: 500;
                line-height: 1.32;
                flex: 1;
                min-width: 0;
            }

            .permission-item.checked label {
                color: #2157d6;
                font-weight: 700;
            }

            .permission-item label small {
                display: block;
                font-size: 11px;
                font-family: 'Fira Mono', 'Courier New', monospace;
                color: #8aa5c1;
                margin-top: 2px;
                font-weight: 400;
                word-break: break-all;
            }

            .permission-item.checked label small {
                color: #56aaff;
            }

            /* Form */
            .form-control-modern {
                border: 2px solid #e2e8f0;
                border-radius: 9px;
                padding: 10px 16px;
                font-size: 15px;
                transition: all 0.18s;
                width: 100%;
                background: #f7fbff;
                color: #1e293b;
                font-weight: 500;
            }

            .form-control-modern:focus {
                border-color: #2563eb;
                box-shadow: 0 0 0 2.5px rgba(59, 130, 246, 0.12);
                outline: none;
            }

            /* Action Bar */
            .action-bar {
                background: #fff;
                border-radius: 14px;
                box-shadow: 0 2px 12px rgba(43, 56, 92, 0.065);
                border: none;
                margin-top: 24px;
                padding: 18px 24px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .action-bar .btn {
                min-width: 140px;
                font-size: 15px;
                padding: 10px 0;
                border-radius: 8px;
                font-weight: 600;
            }

            /* Tabs */
            .tab-pane {
                display: none;
            }

            .tab-pane.active {
                display: block;
            }

            /* ===== RESPONSIVE ===== */
            @media (max-width: 600px) {
                .permission-grid {
                    padding: 0 9px 20px 9px;
                }

                .content-header,
                .select-all-module {
                    margin-left: 8px;
                    margin-right: 8px;
                }
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
        <div class="container-fluid">
            <form action="{{ route('roles.store') }}" method="POST" id="roleForm">
                @csrf

                {{-- FORM IDENTITAS ROLE (Compact di atas) --}}
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body py-3 px-4">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <label for="name" class="mb-1 font-weight-bold" style="font-size: 13px;">
                                    <i class="fa fa-id-card mr-1 text-primary"></i> Nama Role <span
                                        class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" name="name" id="name"
                                    class="form-control-modern @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="Contoh: Admin, Editor, Viewer" required>
                                @error('name')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- LAYOUT 2 KOLOM: SIDEBAR + KONTEN --}}
                <div class="role-layout">

                    {{-- ========== SIDEBAR KIRI ========== --}}
                    <aside class="role-sidebar">
                        <div class="sidebar-card">
                            <div class="sidebar-header">
                                <h5><i class="fa fa-layer-group mr-2"></i>Modul Hak Akses</h5>
                                <p>Pilih modul untuk mengatur permission</p>
                            </div>

                            <div class="sidebar-body">
                                {{-- Counter Total --}}
                                <div class="total-counter">
                                    <div class="count-number">
                                        <span id="checkedCount">0</span>
                                        <small style="font-size: 14px; color: #94a3b8; font-weight: 400;">/</small>
                                        <span style="font-size: 16px; color: #64748b;">{{ $totalPermissions ?? 0 }}</span>
                                    </div>
                                    <div class="count-label">Permission Dipilih</div>
                                </div>
                                {{-- Tombol Global --}}
                                <div class="global-actions mb-3">
                                    <button type="button" class="btn-global btn-select-all" id="btnToggleAll">
                                        <i class="fa fa-check-double"></i>
                                        <span id="toggleAllText">Pilih Semua</span>
                                    </button>
                                    <button type="button" class="btn-global btn-reset" id="btnResetAll">
                                        <i class="fa fa-undo"></i>
                                        Reset Semua
                                    </button>
                                </div>
                                {{-- Navigasi Modul --}}
                                <ul class="module-nav" id="moduleNav">
                                    @foreach ($groupedPermissions as $module => $permissions)
                                        <li class="module-nav-item {{ $loop->first ? 'active' : '' }}"
                                            data-module="{{ $module }}">
                                            <div class="nav-left">
                                                <i class="fa fa-folder"></i>
                                                <span class="nav-label">{{ ucfirst($module) }}</span>
                                            </div>
                                            <span class="nav-count" data-module-count="{{ $module }}">
                                                0/{{ count($permissions) }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>


                            </div>
                        </div>
                    </aside>

                    {{-- ========== KONTEN KANAN ========== --}}
                    <main class="role-content">
                        @foreach ($groupedPermissions as $module => $permissions)
                            <div class="tab-pane {{ $loop->first ? 'active' : '' }}" data-tab="{{ $module }}">
                                <div class="content-header">
                                    <div class="content-title">
                                        <div class="title-icon">
                                            <i class="fa fa-folder-open"></i>
                                        </div>
                                        <div>
                                            <h4>{{ ucfirst($module) }}</h4>
                                            <p>{{ count($permissions) }} permission tersedia</p>
                                        </div>
                                    </div>
                                </div>

                                {{-- Select All per Modul --}}
                                <label class="select-all-module" data-module="{{ $module }}">
                                    <input type="checkbox" class="module-checkbox" data-module="{{ $module }}">
                                    <span>Pilih semua permission di modul <strong>{{ ucfirst($module) }}</strong></span>
                                    <span class="count-info"
                                        id="moduleCount-{{ $module }}">0/{{ count($permissions) }}</span>
                                </label>

                                {{-- Grid Permission --}}
                                <div class="permission-grid">
                                    @foreach ($permissions as $perm)
                                        <div class="permission-item" data-permission="{{ $perm['name'] }}">
                                            <input type="checkbox" name="permission[]" value="{{ $perm['id'] }}"
                                                id="perm-{{ $perm['id'] }}" class="permission-checkbox"
                                                data-module="{{ $module }}">
                                            <label for="perm-{{ $perm['id'] }}">
                                                {{ $perm['label'] }}
                                                <small>{{ $perm['name'] }}</small>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </main>
                </div>

                {{-- ACTION BAR --}}
                <div class="action-bar">
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <button type="submit" class="btn btn-primary" style="padding: 10px 32px; font-weight: 600;">
                        <i class="fa fa-save mr-2"></i>Simpan Role
                    </button>
                </div>
            </form>
        </div>
    </section>

    @push('scripts')
        <script>
            $(document).ready(function() {

                // ==========================================
                // 1. NAVIGASI MODUL (Switch Tab)
                // ==========================================
                $(document).on('click', '.module-nav-item', function() {
                    const module = $(this).data('module');

                    // Update nav active state
                    $('.module-nav-item').removeClass('active');
                    $(this).addClass('active');

                    // Switch tab content
                    $('.tab-pane').removeClass('active');
                    $(`.tab-pane[data-tab="${module}"]`).addClass('active');
                });

                // ==========================================
                // 2. TOGGLE VISUAL PERMISSION ITEM
                // ==========================================
                $(document).on('change', '.permission-checkbox', function() {
                    const item = $(this).closest('.permission-item');
                    const module = $(this).data('module');

                    if ($(this).is(':checked')) {
                        item.addClass('checked');
                    } else {
                        item.removeClass('checked');
                    }

                    updateModuleCheckbox(module);
                    updateAllCounters();
                });

                // Klik area item = toggle checkbox
                $(document).on('click', '.permission-item', function(e) {
                    if (!$(e.target).is('input, label, small')) {
                        const checkbox = $(this).find('.permission-checkbox');
                        checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
                    }
                });

                // ==========================================
                // 3. SELECT ALL PER MODUL
                // ==========================================
                $(document).on('change', '.module-checkbox', function() {
                    const module = $(this).data('module');
                    const isChecked = $(this).is(':checked');

                    $(`.permission-checkbox[data-module="${module}"]`).prop('checked', isChecked).trigger(
                        'change');
                });

                // Klik area select-all = toggle
                $(document).on('click', '.select-all-module', function(e) {
                    if (!$(e.target).is('input')) {
                        const checkbox = $(this).find('.module-checkbox');
                        checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
                    }
                });

                // ==========================================
                // 4. UPDATE MODULE CHECKBOX (indeterminate state)
                // ==========================================
                function updateModuleCheckbox(module) {
                    const $checkboxes = $(`.permission-checkbox[data-module="${module}"]`);
                    const total = $checkboxes.length;
                    const checked = $checkboxes.filter(':checked').length;
                    const $moduleCheckbox = $(`.module-checkbox[data-module="${module}"]`);

                    if (checked === 0) {
                        $moduleCheckbox.prop({
                            checked: false,
                            indeterminate: false
                        });
                    } else if (checked === total) {
                        $moduleCheckbox.prop({
                            checked: true,
                            indeterminate: false
                        });
                    } else {
                        $moduleCheckbox.prop({
                            checked: false,
                            indeterminate: true
                        });
                    }

                    // Update counter per modul di content
                    $(`#moduleCount-${module}`).text(`${checked}/${total}`);

                    // Update counter di sidebar nav
                    const $navCount = $(`.nav-count[data-module-count="${module}"]`);
                    $navCount.text(`${checked}/${total}`);

                    // Visual indicator jika ada yang dipilih
                    const $navItem = $(`.module-nav-item[data-module="${module}"]`);
                    if (checked > 0) {
                        $navItem.addClass('has-checked');
                    } else {
                        $navItem.removeClass('has-checked');
                    }
                }

                // ==========================================
                // 5. UPDATE COUNTER GLOBAL
                // ==========================================
                function updateAllCounters() {
                    const $allCheckboxes = $('.permission-checkbox');
                    const total = $allCheckboxes.length;
                    const checked = $allCheckboxes.filter(':checked').length;

                    $('#checkedCount').text(checked);

                    // Update tombol toggle all
                    const $btnToggle = $('#btnToggleAll');
                    const $toggleText = $('#toggleAllText');

                    if (checked === total && total > 0) {
                        $btnToggle.addClass('active');
                        $toggleText.text('Batal Pilih Semua');
                    } else {
                        $btnToggle.removeClass('active');
                        $toggleText.text('Pilih Semua');
                    }
                }

                // ==========================================
                // 6. TOMBOL GLOBAL: SELECT ALL / RESET
                // ==========================================
                $('#btnToggleAll').on('click', function() {
                    const $allCheckboxes = $('.permission-checkbox');
                    const allChecked = $allCheckboxes.length === $allCheckboxes.filter(':checked').length;
                    const newState = !allChecked;

                    $allCheckboxes.prop('checked', newState);
                    $('.module-checkbox').prop({
                        checked: newState,
                        indeterminate: false
                    });

                    // Update visual semua item
                    if (newState) {
                        $('.permission-item').addClass('checked');
                        $('.module-nav-item').addClass('has-checked');
                    } else {
                        $('.permission-item').removeClass('checked');
                        $('.module-nav-item').removeClass('has-checked');
                    }

                    // Update semua counter
                    const modules = new Set();
                    $allCheckboxes.each(function() {
                        modules.add($(this).data('module'));
                    });
                    modules.forEach(m => updateModuleCheckbox(m));
                    updateAllCounters();
                });

                $('#btnResetAll').on('click', function() {
                    if ($('.permission-checkbox:checked').length === 0) return;

                    if (!confirm('Reset semua pilihan permission?')) return;

                    $('.permission-checkbox').prop('checked', false);
                    $('.module-checkbox').prop({
                        checked: false,
                        indeterminate: false
                    });
                    $('.permission-item').removeClass('checked');
                    $('.module-nav-item').removeClass('has-checked');

                    const modules = new Set();
                    $('.permission-checkbox').each(function() {
                        modules.add($(this).data('module'));
                    });
                    modules.forEach(m => updateModuleCheckbox(m));
                    updateAllCounters();
                });

                // ==========================================
                // 7. INISIALISASI AWAL
                // ==========================================
                function initCounters() {
                    const modules = new Set();
                    $('.permission-checkbox').each(function() {
                        modules.add($(this).data('module'));
                    });
                    modules.forEach(m => updateModuleCheckbox(m));
                    updateAllCounters();
                }
                initCounters();

                // ==========================================
                // 8. KONFIRMASI SUBMIT
                // ==========================================
                $('#roleForm').on('submit', function(e) {
                    const name = $('#name').val().trim();
                    const checkedCount = $('.permission-checkbox:checked').length;

                    if (!name) {
                        e.preventDefault();
                        Swal.fire('Peringatan', 'Nama role harus diisi.', 'warning');
                        $('#name').focus();
                        return false;
                    }

                    if (checkedCount === 0) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Tanpa Permission?',
                            text: 'Anda belum memilih hak akses apapun. Role ini tidak akan memiliki akses ke fitur manapun. Lanjutkan?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Ya, Lanjutkan',
                            cancelButtonText: 'Batal',
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                e.currentTarget.submit();
                            }
                        });
                        return false;
                    }
                });

                // ==========================================
                // 9. KEYBOARD SHORTCUT (A = Select All di modul aktif)
                // ==========================================
                $(document).on('keydown', function(e) {
                    // Ignore jika fokus di input
                    if ($(e.target).is('input, textarea, select')) return;

                    // Alt + A = Toggle Select All di modul aktif
                    if (e.altKey && e.key.toLowerCase() === 'a') {
                        e.preventDefault();
                        const activeModule = $('.module-nav-item.active').data('module');
                        if (activeModule) {
                            const $moduleCheckbox = $(`.module-checkbox[data-module="${activeModule}"]`);
                            $moduleCheckbox.prop('checked', !$moduleCheckbox.prop('checked')).trigger('change');
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection

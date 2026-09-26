@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            .menu-list-container {
                background: #f8f9fa;
                border-radius: 8px;
                padding: 16px;
                min-height: 600px;
            }

            .menu-item-row {
                background: white;
                border: 1px solid #dee2e6;
                border-radius: 6px;
                padding: 12px 16px;
                margin-bottom: 8px;
                display: flex;
                align-items: center;
                transition: all 0.2s;
            }

            .menu-item-row:hover {
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                border-color: #80bdff;
            }

            .menu-drag-handle {
                cursor: move;
                color: #6c757d;
                margin-right: 12px;
                font-size: 18px;
            }

            .menu-icon {
                width: 32px;
                text-align: center;
                margin-right: 12px;
                color: #007bff;
            }

            .menu-content {
                flex: 1;
            }

            .menu-title {
                font-weight: 600;
                color: #212529;
                margin-bottom: 2px;
            }

            .menu-subtitle {
                font-size: 13px;
                color: #6c757d;
            }

            .menu-badges {
                margin-left: 8px;
            }

            .menu-actions {
                margin-left: 12px;
            }

            .edit-panel {
                background: white;
                border-radius: 8px;
                border: 1px solid #dee2e6;
                padding: 20px;
                position: sticky;
                top: 20px;
            }

            .form-group label {
                font-weight: 600;
                font-size: 14px;
                color: #495057;
                margin-bottom: 6px;
            }

            .btn-save-menu {
                width: 100%;
                padding: 10px;
                font-weight: 600;
            }
        </style>
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fa fa-bars mr-2"></i>Manajemen Menu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Menu</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- LEFT: Menu List -->
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0">
                                <i class="fa fa-list mr-2"></i>Daftar Hierarki Menu Header
                            </h3>
                            <div>
                                <button type="button" class="btn btn-sm btn-link" onclick="expandAll()">
                                    <i class="fa fa-expand-alt mr-1"></i>Buka Semua
                                </button>
                                <button type="button" class="btn btn-sm btn-link" onclick="collapseAll()">
                                    <i class="fa fa-compress-alt mr-1"></i>Ciutkan Semua
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="menu-list-container" id="menuListContainer">
                                <!-- Menu items will be loaded here via DataTables or directly -->
                                @foreach ($allMenus as $menu)
                                    @if (is_null($menu->ParentId))
                                        @include('pages.admin.menu._menu_item', [
                                            'menu' => $menu,
                                            'level' => 0,
                                        ])
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">
                                <i class="fa fa-info-circle mr-1"></i>
                                Total: {{ $allMenus->whereNull('ParentId')->count() }} Menu Utama &
                                {{ $allMenus->whereNotNull('ParentId')->count() }} Sub-menu terdaftar.
                            </small>
                            <span class="float-right">
                                <small class="text-muted">Auto-save: <span class="text-success">Aktif</span></small>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: Edit Panel -->
                <div class="col-lg-5">
                    <div class="edit-panel">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">
                                <i class="fa fa-edit mr-2 text-primary"></i>Tambah / Edit Item Menu
                            </h5>
                            <span class="badge badge-secondary" id="editModeBadge">Baru</span>
                        </div>

                        <form id="formMenu" method="POST" action="{{ route('menu.store') }}">
                            @csrf
                            <input type="hidden" name="_method" id="formMethod" value="POST">
                            <input type="hidden" name="id" id="menuId" value="">

                            <!-- Nama Menu Indonesia -->
                            <div class="form-group">
                                <label for="NamaMenuId">Nama Menu (Indonesia) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="NamaMenuId" name="translations[id][NamaMenu]"
                                    placeholder="Contoh: Hubungan Investor" required>
                            </div>

                            <!-- Nama Menu English -->
                            <div class="form-group">
                                <label for="NamaMenuEn">Nama Menu (English) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="NamaMenuEn" name="translations[en][NamaMenu]"
                                    placeholder="e.g. Investor Relations" required>
                            </div>

                            <!-- Jenis Tautan -->
                            <div class="form-group">
                                <label>Jenis Tautan:</label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="jenisHalamanCMS" name="JenisLink" class="custom-control-input"
                                        value="page" checked onchange="toggleLinkType()">
                                    <label class="custom-control-label" for="jenisHalamanCMS">Halaman CMS</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="jenisURLKustom" name="JenisLink" class="custom-control-input"
                                        value="custom" onchange="toggleLinkType()">
                                    <label class="custom-control-label" for="jenisURLKustom">URL Kustom</label>
                                </div>
                            </div>

                            <!-- Pilih Halaman CMS -->
                            <div class="form-group" id="groupPilihHalaman">
                                <label for="Url">Pilih Halaman CMS:</label>
                                <select class="form-control" id="Url" name="Url">
                                    <option value="">-- Pilih Halaman --</option>
                                    <option value="/tentang-kami">Tentang Kami</option>
                                    <option value="/solusi">Solusi & Layanan</option>
                                    <option value="/karir">Karir</option>
                                    <option value="/kontak">Kontak</option>
                                </select>
                            </div>

                            <!-- URL Kustom -->
                            <div class="form-group" id="groupUrlKustom" style="display:none;">
                                <label for="UrlKustom">URL Kustom:</label>
                                <input type="text" class="form-control" id="UrlKustom" name="Url"
                                    placeholder="https://example.com atau /custom-page">
                            </div>

                            <!-- Parent Menu -->
                            <div class="form-group">
                                <label for="ParentId">Parent Menu (Hierarki):</label>
                                <select class="form-control" id="ParentId" name="ParentId">
                                    <option value="">-- Tingkat Utama (Root) --</option>
                                    @foreach ($parentMenus as $parent)
                                        <option value="{{ $parent->id }}">
                                            {{ $parent->translate('id')->NamaMenu ?? $parent->NamaMenu }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Icon -->
                            <div class="form-group">
                                <label for="Icon">Icon (Optional):</label>
                                <input type="text" class="form-control" id="Icon" name="Icon"
                                    placeholder="fa fa-home" value="{{ old('Icon') }}">
                                <small class="text-muted">Contoh: fa fa-home, fa fa-users</small>
                            </div>

                            <!-- Urutan -->
                            <div class="form-group">
                                <label for="Urutan">Urutan:</label>
                                <input type="number" class="form-control" id="Urutan" name="Urutan"
                                    placeholder="Auto" value="{{ old('Urutan') }}">
                            </div>

                            <!-- Status Aktif -->
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="StatusAktif"
                                        name="StatusAktif" value="1" checked>
                                    <label class="custom-control-label" for="StatusAktif">Status Aktif</label>
                                </div>
                            </div>

                            <!-- Tampilkan di Header -->
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="TampilkanDiHeader"
                                        name="TampilkanDiHeader" value="1" checked>
                                    <label class="custom-control-label" for="TampilkanDiHeader">Tampilkan di
                                        Header</label>
                                </div>
                            </div>

                            <!-- Tampilkan di Footer -->
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="TampilkanDiFooter"
                                        name="TampilkanDiFooter" value="1">
                                    <label class="custom-control-label" for="TampilkanDiFooter">Tampilkan di
                                        Footer</label>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="form-group mb-0">
                                <button type="button" class="btn btn-default" onclick="resetForm()">
                                    <i class="fa fa-undo mr-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary btn-save-menu">
                                    <i class="fa fa-save mr-1"></i> Simpan Item Menu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Edit (Alternative) -->
    <div class="modal fade" id="modalEditMenu" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title">Edit Menu</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form edit akan dimuat via AJAX -->
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- 1. Load Library SortableJS untuk Drag & Drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <script>
        $(document).ready(function() {

            // ==========================================
            // 1. FUNGSI UTILITAS FORM
            // ==========================================
            window.toggleLinkType = function() {
                if ($('#jenisHalamanCMS').is(':checked')) {
                    $('#groupPilihHalaman').show();
                    $('#groupUrlKustom').hide();
                } else {
                    $('#groupPilihHalaman').hide();
                    $('#groupUrlKustom').show();
                }
            }

            window.resetForm = function() {
                $('#formMenu')[0].reset();
                $('#menuId').val('');
                $('#formMethod').val('POST');
                $('#editModeBadge').text('Baru');
                $('#formMenu').attr('action', '{{ route('menu.store') }}');
                toggleLinkType(); // Reset tampilan radio button
            }

            window.expandAll = function() {
                $('.submenu').slideDown(200);
            }

            window.collapseAll = function() {
                $('.submenu').slideUp(200);
            }

            // ==========================================
            // 2. EDIT MENU VIA AJAX
            // ==========================================
            window.editMenu = function(id) {
                // Tampilkan loading pada badge
                $('#editModeBadge').text('Memuat...');

                $.get('/admin/menu/' + id + '/edit', function(data) {
                    // Isi form dengan data yang diterima
                    $('#menuId').val(data.id);
                    $('#NamaMenuId').val(data.translations.id?.NamaMenu || '');
                    $('#NamaMenuEn').val(data.translations.en?.NamaMenu || '');
                    $('#ParentId').val(data.ParentId || '');
                    $('#Icon').val(data.Icon || '');
                    $('#Urutan').val(data.Urutan || '');

                    // Handle radio button JenisLink
                    if (data.JenisLink === 'page') {
                        $('#jenisHalamanCMS').prop('checked', true);
                        $('#Url').val(data.Url || '');
                    } else {
                        $('#jenisURLKustom').prop('checked', true);
                        $('#UrlKustom').val(data.Url || '');
                    }
                    toggleLinkType();

                    // Handle checkboxes
                    $('#StatusAktif').prop('checked', data.StatusAktif == 1);
                    $('#TampilkanDiHeader').prop('checked', data.TampilkanDiHeader == 1);
                    $('#TampilkanDiFooter').prop('checked', data.TampilkanDiFooter == 1);

                    // Ubah mode form menjadi Edit
                    $('#formMethod').val('PUT');
                    $('#editModeBadge').text('Edit');
                    $('#formMenu').attr('action', '/admin/menu/' + id);

                    // Scroll halus ke panel form
                    $('html, body').animate({
                        scrollTop: $('.edit-panel').offset().top - 20
                    }, 300);
                }).fail(function() {
                    Swal.fire('Gagal!', 'Tidak dapat memuat data menu.', 'error');
                    $('#editModeBadge').text('Baru');
                });
            }

            // Delegasi event untuk tombol Edit
            $('body').on('click', '.btn-edit', function() {
                var id = $(this).data('id');
                editMenu(id);
            });

            // ==========================================
            // 3. HAPUS MENU VIA AJAX
            // ==========================================
            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                var nama = $(this).data('nama');

                Swal.fire({
                    title: 'Hapus Menu?',
                    html: `Apakah Anda yakin ingin menghapus menu <strong>${nama}</strong>?<br><small class="text-muted">Semua sub-menu di bawahnya juga akan ikut terhapus.</small>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Menghapus...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: '{{ url('menu') }}/' + id,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: response.message ||
                                        'Menu berhasil dihapus.',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location
                                        .reload(); // Reload halaman untuk refresh tree
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: xhr.responseJSON?.message ||
                                        'Terjadi kesalahan pada server.'
                                });
                            }
                        });
                    }
                });
            });

            // ==========================================
            // 4. DRAG & DROP (SORTABLE) LOGIC
            // ==========================================
            function initSortable() {
                const containers = document.querySelectorAll('.menu-list-container, .submenu');

                containers.forEach(container => {
                    new Sortable(container, {
                        group: 'nested-menus',
                        animation: 150,
                        handle: '.menu-drag-handle',
                        ghostClass: 'bg-light',
                        onEnd: function(evt) {
                            // Tampilkan indikator "Menyimpan..."
                            const statusEl = document.querySelector('.float-right small');
                            const originalHtml = statusEl.innerHTML;
                            statusEl.innerHTML =
                                '<span class="text-warning"><i class="fa fa-spinner fa-spin"></i> Menyimpan urutan...</span>';

                            // Baca struktur DOM baru
                            const newOrder = buildOrderData(document.getElementById(
                                'menuListContainer'));

                            // Gunakan $.ajax agar lebih stabil daripada fetch
                            $.ajax({
                                url: '{{ route('menu.update-order') }}',
                                type: 'POST', // Paksa method POST
                                contentType: 'application/json',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                data: JSON.stringify({
                                    order: newOrder
                                }),
                                success: function(data) {
                                    if (data.success) {
                                        statusEl.innerHTML =
                                            '<span class="text-success"><i class="fa fa-check"></i> Urutan tersimpan</span>';
                                        setTimeout(() => {
                                            statusEl.innerHTML =
                                                originalHtml;
                                        }, 2000);
                                    } else {
                                        statusEl.innerHTML =
                                            '<span class="text-danger"><i class="fa fa-times"></i> Gagal menyimpan</span>';
                                        setTimeout(() => {
                                            location.reload();
                                        }, 1500);
                                    }
                                },
                                error: function(xhr) {
                                    console.error('Error:', xhr);
                                    statusEl.innerHTML =
                                        '<span class="text-danger"><i class="fa fa-times"></i> Error</span>';
                                    Swal.fire('Gagal!',
                                        'Terjadi kesalahan saat menyimpan urutan.',
                                        'error');
                                }
                            });
                        }
                    });
                });
            }

            // Fungsi rekursif untuk membaca struktur HTML menjadi Array JSON
            function buildOrderData(element) {
                let order = [];
                let items = $(element).children('.menu-item-row');

                items.each(function() {
                    let id = $(this).data('id');
                    let submenu = $(this).next('.submenu');
                    let children = [];

                    if (submenu.length > 0) {
                        children = buildOrderData(submenu);
                    }

                    order.push({
                        id: id,
                        children: children
                    });
                });

                return order;
            }

            // Jalankan inisialisasi Sortable
            initSortable();

        });
    </script>
@endpush

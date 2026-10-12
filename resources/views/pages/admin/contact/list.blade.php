@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Kontak Masuk
                        <span class="cu-unread-badge" id="cuUnreadBadge" style="display:none;">0</span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Kontak Masuk</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">

                <div class="cu-wrap">
                    <div class="cu-toolbar">
                        <div>
                            <h5 class="cu-title">Kontak Masuk</h5>
                            <span class="cu-subtitle" id="cuTotalLabel">Memuat...</span>
                        </div>
                        <div class="cu-toolbar-actions">
                            <!-- Filter Tabs -->
                            <div class="cu-filter-tabs">
                                <button type="button" class="cu-filter-tab active" data-filter="all">Semua</button>
                                <button type="button" class="cu-filter-tab" data-filter="unread">Belum Dibaca</button>
                                <button type="button" class="cu-filter-tab" data-filter="read">Sudah Dibaca</button>
                            </div>

                            <!-- Date Range -->
                            <div class="cu-daterange">
                                <i class="fa fa-calendar"></i>
                                <input type="text" id="dateRange" placeholder="Filter tanggal..." autocomplete="off"
                                    readonly>
                            </div>

                            <!-- ✅ Auto-Refresh -->
                            <button type="button" class="cu-btn cu-btn-ghost cu-btn-auto-refresh" id="btnToggleAutoRefresh"
                                title="Auto-refresh aktif (30 detik)">
                                <i class="fa fa-sync"></i>
                            </button>

                            <!-- ✅ Last Refresh -->
                            <span class="cu-refresh-indicator" id="refreshIndicator">
                                <span class="pulse-dot"></span>
                                <span id="lastRefreshTime">Live</span>
                            </span>

                            <button type="button" class="cu-btn cu-btn-ghost" id="btnMarkAllRead"
                                title="Tandai semua sudah dibaca">
                                <i class="fa fa-check-double"></i>
                            </button>

                            <button type="button" class="cu-btn cu-btn-ghost" id="btnReset" title="Reset filter">
                                <i class="fa fa-redo"></i>
                            </button>

                            @can('kotak-masuk.view')
                                <button type="button" class="cu-btn cu-btn-accent" id="btnExportExcel">
                                    <i class="fa fa-file-excel mr-1"></i> Export
                                </button>
                            @endcan
                        </div>
                    </div>

                    <div class="cu-body">
                        <!-- KOLOM KIRI: LIST PESAN -->
                        <div class="cu-list-pane">
                            <div class="cu-search">
                                <i class="fa fa-search"></i>
                                <input type="text" id="searchInput" placeholder="Search messages...">
                            </div>

                            <div class="cu-list" id="messageList">
                                <div class="cu-loading">
                                    <i class="fa fa-spinner fa-spin"></i>
                                    <p>Memuat pesan...</p>
                                </div>
                            </div>
                        </div>

                        <!-- KOLOM KANAN: DETAIL PESAN -->
                        <div class="cu-detail-pane">
                            <div id="emptyState" class="cu-empty">
                                <i class="fa fa-envelope-open"></i>
                                <h6>Pilih pesan untuk melihat detail</h6>
                                <p>Klik salah satu pesan di daftar untuk membacanya</p>
                            </div>

                            <div id="messageDetail" class="cu-detail" style="display:none;">
                                <div class="cu-detail-header">
                                    <div>
                                        <h5 class="cu-detail-name" id="detailName"></h5>
                                        <div class="cu-detail-meta">
                                            <span id="detailEmail"></span>
                                            <span class="cu-dot">&middot;</span>
                                            <span id="detailDate"></span>
                                        </div>
                                    </div>
                                    <div class="cu-detail-actions">
                                        <!-- ✅ Toggle Read Button -->
                                        <button type="button" class="cu-icon-btn" id="btnToggleRead"
                                            title="Tandai belum dibaca">
                                            <i class="fa fa-envelope"></i>
                                        </button>
                                        <button type="button" class="cu-icon-btn cu-icon-btn-danger" id="btnDeleteMessage"
                                            data-id="" title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="cu-detail-phone" id="detailPhoneWrap" style="display:none;">
                                    <i class="fa fa-phone"></i> <span id="detailPhone"></span>
                                </div>

                                <div class="cu-detail-body" id="detailMessage"></div>

                                <div class="cu-detail-footer" style="text-align: right;">
                                    <a href="#" class="cu-reply-btn" id="btnReplyEmail" target="_blank"
                                        style="float: right;">
                                        <i class="fa fa-envelope mr-2"></i>Balas Melalui Email
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Template Item Pesan -->
    <template id="messageItemTemplate">
        <div class="cu-item" data-id="" data-is-read="false">
            <div class="cu-unread-dot" style="display:none;"></div>
            <div class="cu-avatar"></div>
            <div class="cu-item-body">
                <div class="cu-item-top">
                    <span class="cu-item-name"></span>
                    <span class="cu-item-date"></span>
                </div>
                <p class="cu-item-preview"></p>
            </div>
        </div>
    </template>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .cu-wrap {
            --cu-bg: #ffffff;
            --cu-panel: #ffffff;
            --cu-panel-alt: #f4f6f9;
            --cu-border: #dee2e6;
            --cu-text: #212529;
            --cu-muted: #6c757d;
            --cu-accent: #007bff;
            --cu-accent-soft: rgba(0, 123, 255, 0.08);
            --cu-danger: #dc3545;
            --cu-unread: #007bff;

            background: var(--cu-bg);
            border: 1px solid var(--cu-border);
            border-radius: 4px;
            overflow: hidden;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            color: var(--cu-text);
        }

        .cu-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 12px;
            padding: 20px 22px 16px;
            border-bottom: 1px solid var(--cu-border);
        }

        .cu-title {
            margin: 0;
            font-size: 20px;
            font-weight: 600;
            color: var(--cu-text);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* ✅ Badge Unread Counter */
        .cu-unread-badge {
            background: var(--cu-unread);
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 10px;
            min-width: 22px;
            text-align: center;
            margin-left: 4px;
        }

        .cu-subtitle {
            font-size: 13px;
            color: var(--cu-muted);
        }

        .cu-toolbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* ✅ Filter Tabs */
        .cu-filter-tabs {
            display: flex;
            background: var(--cu-panel-alt);
            border: 1px solid var(--cu-border);
            border-radius: 8px;
            padding: 3px;
        }

        .cu-filter-tab {
            border: none;
            background: transparent;
            color: var(--cu-muted);
            font-size: 12.5px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .cu-filter-tab:hover {
            color: var(--cu-text);
        }

        .cu-filter-tab.active {
            background: #fff;
            color: var(--cu-accent);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            font-weight: 600;
        }

        .cu-daterange {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--cu-panel-alt);
            border: 1px solid var(--cu-border);
            border-radius: 8px;
            padding: 7px 12px;
            color: var(--cu-muted);
            font-size: 13px;
        }

        .cu-daterange i {
            font-size: 12px;
        }

        .cu-daterange input {
            background: transparent;
            border: none;
            outline: none;
            color: var(--cu-text);
            font-size: 13px;
            width: 150px;
        }

        .cu-daterange input::placeholder {
            color: var(--cu-muted);
        }

        .cu-btn {
            border: 1px solid var(--cu-border);
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 13px;
            background: var(--cu-panel-alt);
            color: var(--cu-text);
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .cu-btn-ghost {
            padding: 8px 11px;
            color: var(--cu-muted);
        }

        .cu-btn-ghost:hover {
            background: #e9ecef !important;
            color: #007bff !important;
        }

        .cu-btn-ghost:hover i,
        .cu-btn-auto-refresh:hover i {
            color: #007bff !important;
        }

        .cu-btn-accent {
            background: var(--cu-accent);
            border-color: var(--cu-accent);
            color: #fff;
            font-weight: 600;
        }

        .cu-btn-accent:hover {
            background: #0069d9;
        }

        .cu-body {
            display: flex;
            min-height: 560px;
        }

        .cu-list-pane {
            width: 340px;
            flex-shrink: 0;
            border-right: 1px solid var(--cu-border);
            display: flex;
            flex-direction: column;
        }

        .cu-search {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 16px;
            padding: 8px 12px;
            background: var(--cu-panel-alt);
            border: 1px solid var(--cu-border);
            border-radius: 8px;
            color: var(--cu-muted);
        }

        .cu-search i {
            font-size: 12px;
        }

        .cu-search input {
            background: transparent;
            border: none;
            outline: none;
            color: var(--cu-text);
            font-size: 13px;
            width: 100%;
        }

        .cu-search input::placeholder {
            color: var(--cu-muted);
        }

        .cu-list {
            flex: 1;
            overflow-y: auto;
            max-height: calc(100vh - 340px);
        }

        .cu-loading,
        .cu-list-empty {
            text-align: center;
            padding: 60px 20px;
            color: var(--cu-muted);
        }

        .cu-loading i {
            font-size: 22px;
            margin-bottom: 8px;
            display: block;
        }

        /* ✅ Item dengan indikator unread */
        .cu-item {
            display: flex;
            gap: 10px;
            padding: 12px 16px;
            cursor: pointer;
            border-left: 3px solid transparent;
            transition: background 0.12s ease;
            position: relative;
        }

        .cu-item:hover {
            background: var(--cu-panel-alt);
        }

        .cu-item.active {
            background: var(--cu-accent-soft);
            border-left-color: var(--cu-accent);
        }

        /* ✅ Pesan belum dibaca */
        .cu-item.unread {
            background: #f0f7ff;
        }

        .cu-item.unread:hover {
            background: #e6f0fa;
        }

        .cu-item.unread .cu-item-name {
            font-weight: 700;
            color: #0a2540;
        }

        .cu-item.unread .cu-item-preview {
            color: #334155;
            font-weight: 500;
        }

        /* ✅ Dot indikator unread */
        .cu-unread-dot {
            position: absolute;
            left: 6px;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--cu-unread);
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.15);
        }

        .cu-item.unread {
            padding-left: 22px;
        }

        .cu-avatar {
            flex-shrink: 0;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--cu-accent);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
        }

        .cu-item.unread .cu-avatar {
            background: #0056b3;
        }

        .cu-item-body {
            min-width: 0;
            flex: 1;
        }

        .cu-item-top {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            gap: 8px;
        }

        .cu-item-name {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--cu-text);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cu-item-date {
            font-size: 11px;
            color: var(--cu-muted);
            flex-shrink: 0;
        }

        .cu-item.unread .cu-item-date {
            color: var(--cu-accent);
            font-weight: 600;
        }

        .cu-item-preview {
            margin: 3px 0 0;
            font-size: 12.5px;
            color: var(--cu-muted);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cu-detail-pane {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .cu-empty {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: var(--cu-muted);
            padding: 40px;
        }

        .cu-empty i {
            font-size: 42px;
            margin-bottom: 14px;
            opacity: 0.5;
        }

        .cu-empty h6 {
            color: var(--cu-text);
            margin-bottom: 4px;
        }

        .cu-empty p {
            font-size: 13px;
            margin: 0;
        }

        .cu-detail {
            display: flex;
            flex-direction: column;
            flex: 1;
            padding: 22px 26px;
        }

        .cu-detail-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }

        .cu-detail-actions {
            display: flex;
            gap: 6px;
        }

        .cu-detail-name {
            margin: 0 0 4px;
            font-size: 18px;
            font-weight: 600;
            color: var(--cu-text);
        }

        .cu-detail-meta {
            font-size: 12.5px;
            color: var(--cu-muted);
        }

        .cu-dot {
            margin: 0 6px;
        }

        .cu-icon-btn {
            border: 1px solid var(--cu-border);
            background: var(--cu-panel-alt);
            color: var(--cu-muted);
            width: 34px;
            height: 34px;
            border-radius: 8px;
            cursor: pointer;
            flex-shrink: 0;
            transition: all 0.15s ease;
        }

        .cu-icon-btn:hover {
            background: #e9ecef;
            color: var(--cu-text);
        }

        .cu-icon-btn-danger:hover {
            background: rgba(220, 53, 69, 0.08);
            color: var(--cu-danger);
            border-color: rgba(220, 53, 69, 0.4);
        }

        /* ✅ Tombol toggle read aktif */
        .cu-icon-btn.is-unread {
            background: var(--cu-accent);
            border-color: var(--cu-accent);
            color: #fff;
        }

        .cu-icon-btn.is-unread:hover {
            background: #0069d9;
            color: #fff;
        }

        .cu-detail-phone {
            margin-top: 8px;
            font-size: 12.5px;
            color: var(--cu-muted);
        }

        .cu-detail-body {
            margin-top: 18px;
            font-size: 14px;
            line-height: 1.7;
            color: var(--cu-text);
            white-space: pre-wrap;
            flex: 1;
        }

        .cu-detail-footer {
            margin-top: 20px;
        }

        .cu-reply-btn {
            display: inline-flex;
            align-items: center;
            background: var(--cu-accent);
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            padding: 10px 18px;
            border-radius: 4px;
            text-decoration: none;
            transition: background 0.15s ease;
        }

        .cu-reply-btn:hover {
            background: #0069d9;
            color: #fff;
            text-decoration: none;
        }

        .cu-list::-webkit-scrollbar {
            width: 6px;
        }

        .cu-list::-webkit-scrollbar-track {
            background: transparent;
        }

        .cu-list::-webkit-scrollbar-thumb {
            background: #c5cbd4;
            border-radius: 3px;
        }

        .daterangepicker {
            background: #fff;
            border-color: #dee2e6;
            color: #495057;
        }

        .daterangepicker .calendar-table {
            background: #fff;
            border-color: #dee2e6;
        }

        .daterangepicker td.available {
            color: #495057;
        }

        .daterangepicker td.off,
        .daterangepicker td.off.in-range {
            color: #adb5bd;
            background: transparent;
        }

        .daterangepicker td.active,
        .daterangepicker td.active:hover {
            background: #007bff;
            color: #fff;
        }

        .daterangepicker .drp-buttons {
            border-color: #dee2e6;
        }

        .daterangepicker:after {
            border-bottom-color: #fff;
        }

        .daterangepicker:before {
            border-bottom-color: #dee2e6;
        }

        .daterangepicker .ranges li:hover {
            background: #f4f6f9;
        }

        .daterangepicker .ranges li.active {
            background: #007bff;
            color: #fff;
        }

        /* ✅ Tombol Auto-Refresh */
        .cu-btn-auto-refresh {
            position: relative;
        }

        .cu-btn-auto-refresh.cu-btn-active {
            background: #fef3c7 !important;
            color: #d97706 !important;
            border-color: #fbbf24 !important;
        }

        .cu-btn-auto-refresh .fa-sync {
            animation: spin 2s linear infinite;
        }

        .cu-btn-auto-refresh.cu-btn-active .fa-pause {
            animation: none;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* ✅ Last Refresh Time Indicator */
        .cu-refresh-indicator {
            font-size: 11px;
            color: var(--cu-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .cu-refresh-indicator .pulse-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10b981;
            animation: pulse 2s infinite;
        }

        .cu-refresh-indicator.paused .pulse-dot {
            background: #f59e0b;
            animation: none;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.4;
            }
        }

        /* ✅ Animasi pesan baru */
        .cu-item {
            transition: background 0.3s ease, transform 0.4s ease, opacity 0.4s ease;
        }

        @media (max-width: 768px) {
            .cu-body {
                flex-direction: column;
                min-height: 0;
            }

            .cu-list-pane {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid var(--cu-border);
            }

            .cu-list {
                max-height: 320px;
            }

            .cu-body.cu-show-detail .cu-list-pane {
                display: none;
            }

            .cu-body.cu-show-detail .cu-detail-pane {
                display: flex;
            }

            .cu-filter-tabs {
                width: 100%;
            }

            .cu-filter-tab {
                flex: 1;
            }
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            let selectedMessageId = null;
            let allMessages = [];
            let currentFilter = 'all';

            // ==========================================
            // ✅ AUTO-REFRESH CONFIG
            // ==========================================
            const AUTO_REFRESH_INTERVAL = 30000; // 30 detik
            let autoRefreshTimer = null;
            let isTabActive = true;
            let isLoading = false;

            const URL_MARK_READ = "{{ route('contact.mark-read', ':id') }}";
            const URL_MARK_UNREAD = "{{ route('contact.mark-unread', ':id') }}";
            const URL_DESTROY = "{{ route('contact.destroy', ':id') }}";
            const URL_MARK_ALL = "{{ route('contact.mark-all-read') }}";
            const URL_LIST = "{{ route('contact.list') }}";
            const URL_EXPORT = "{{ route('contact.export') }}";

            function buildUrl(template, id) {
                return template.replace(':id', id);
            }

            // ==========================================
            // ✅ COUNTER UPDATE
            // ==========================================
            function updateAllCounters(filteredMessages) {
                const unreadCount = allMessages.filter(m => !m.IsRead).length;
                updateUnreadBadge(unreadCount);

                const displayedCount = filteredMessages ? filteredMessages.length : 0;
                let label = displayedCount + ' pesan';

                const activeFilters = [];
                if (currentFilter === 'unread') activeFilters.push('Belum Dibaca');
                if (currentFilter === 'read') activeFilters.push('Sudah Dibaca');
                if ($('#searchInput').val().trim()) activeFilters.push('Search');

                if (activeFilters.length > 0) {
                    label += ' <span class="text-muted small">(' + activeFilters.join(', ') + ')</span>';
                }

                $('#cuTotalLabel').html(label);
            }

            function updateUnreadBadge(count) {
                const $badge = $('#cuUnreadBadge');
                if (count > 0) {
                    $badge.text(count > 99 ? '99+' : count).show();
                } else {
                    $badge.hide();
                }
            }

            // ==========================================
            // ✅ DETECT CHANGES (new / removed / changed)
            // ==========================================
            function diffMessages(newMessages, oldMessages) {
                const oldIds = new Set(oldMessages.map(m => m.id));
                const added = newMessages.filter(m => !oldIds.has(m.id));
                const removed = oldMessages.filter(m => !newMessages.some(n => n.id === m.id));
                const changed = newMessages.filter(m => {
                    const oldMsg = oldMessages.find(o => o.id === m.id);
                    return oldMsg && oldMsg.IsRead !== m.IsRead;
                });
                return {
                    added,
                    removed,
                    changed
                };
            }

            // ==========================================
            // ✅ ANIMATE NEW MESSAGE (highlight kuning)
            // ==========================================
            function highlightNewMessage(id) {
                const $item = $(`.cu-item[data-id="${id}"]`);
                if (!$item.length) return;

                $item.css({
                    'background-color': '#fef3c7',
                    'transition': 'background-color 0.5s ease'
                });

                setTimeout(() => {
                    $item.css('background-color', '');
                }, 3000);
            }

            // ==========================================
            // ✅ LOAD MESSAGES (dengan diff detection)
            // ==========================================
            function loadMessages(silent = false) {
                if (isLoading) return;
                isLoading = true;

                let hasDate = $('#dateRange').val().trim() !== '';
                let dateStart = hasDate ? ($('#dateRange').data('daterangepicker')?.startDate?.format('YYYY-MM-DD') || '') : '';
                let dateEnd = hasDate ? ($('#dateRange').data('daterangepicker')?.endDate?.format('YYYY-MM-DD') || '') : '';

                if (!silent) {
                    $('#cuTotalLabel').html('<i class="fa fa-spinner fa-spin mr-1"></i>Memuat...');
                }

                $.ajax({
                    url: URL_LIST,
                    data: {
                        date_start: dateStart,
                        date_end: dateEnd
                    },
                    success: function(response) {
                        const newMessages = response.data || [];
                        const diff = diffMessages(newMessages, allMessages);

                        allMessages = newMessages;

                        // ✅ Notifikasi hanya untuk silent refresh (auto) & ada pesan baru
                        if (silent && diff.added.length > 0) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'info',
                                title: `${diff.added.length} pesan baru masuk!`,
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                        }

                        applyFilters();

                        // Animasi highlight untuk pesan baru
                        if (silent && diff.added.length > 0) {
                            diff.added.forEach(msg => {
                                setTimeout(() => highlightNewMessage(msg.id), 100);
                            });
                        }

                        isLoading = false;
                    },
                    error: function(xhr) {
                        console.error('Gagal load:', xhr);
                        if (!silent) {
                            $('#messageList').html(`
                                <div class="cu-list-empty">
                                    <i class="fa fa-exclamation-triangle"></i>
                                    <p>Gagal memuat pesan.</p>
                                </div>
                            `);
                        }
                        updateAllCounters([]);
                        isLoading = false;
                    }
                });
            }

            // ==========================================
            // ✅ AUTO-REFRESH LIFECYCLE
            // ==========================================
            function startAutoRefresh() {
                stopAutoRefresh();
                if (!isTabActive) return;

                autoRefreshTimer = setInterval(() => {
                    if (isTabActive && !isLoading) {
                        loadMessages(true); // silent
                    }
                }, AUTO_REFRESH_INTERVAL);
            }

            function stopAutoRefresh() {
                if (autoRefreshTimer) {
                    clearInterval(autoRefreshTimer);
                    autoRefreshTimer = null;
                }
            }

            // ✅ Page Visibility API: Pause saat tab tidak aktif
            document.addEventListener('visibilitychange', function() {
                const wasInactive = !isTabActive;
                isTabActive = !document.hidden;

                if (isTabActive) {
                    // Jika sebelumnya tab tidak aktif → langsung refresh + restart timer
                    if (wasInactive) {
                        loadMessages(true);
                    }
                    startAutoRefresh();
                } else {
                    stopAutoRefresh();
                }
            });

            // ==========================================
            // Date Range Picker
            // ==========================================
            $('#dateRange').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Reset',
                    applyLabel: 'Terapkan',
                    fromLabel: 'Dari',
                    toLabel: 'Sampai',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                    monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ],
                    firstDay: 1
                },
                ranges: {
                    'Hari Ini': [moment(), moment()],
                    'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 Hari Terakhir': [moment().subtract(6, 'days'), moment()],
                    '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
                    'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
                    'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                }
            });

            // ✅ Initial load + start auto-refresh
            loadMessages(false);
            startAutoRefresh();

            // ==========================================
            // Reset
            // ==========================================
            $('#btnReset').click(function() {
                $('#dateRange').val('');
                $('#dateRange').data('daterangepicker').setStartDate(moment().subtract(29, 'days'));
                $('#dateRange').data('daterangepicker').setEndDate(moment());
                $('#searchInput').val('');
                currentFilter = 'all';
                $('.cu-filter-tab').removeClass('active');
                $('.cu-filter-tab[data-filter="all"]').addClass('active');
                $('#messageDetail').hide();
                $('#emptyState').show();
                $('.cu-body').removeClass('cu-show-detail');
                selectedMessageId = null;
                loadMessages(false);
            });

            $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));
                loadMessages(false);
            });

            // ==========================================
            // Filter & Search
            // ==========================================
            $(document).on('click', '.cu-filter-tab', function() {
                $('.cu-filter-tab').removeClass('active');
                $(this).addClass('active');
                currentFilter = $(this).data('filter');
                applyFilters();
            });

            $('#searchInput').on('keyup', function() {
                applyFilters();
            });

            function applyFilters() {
                const q = $('#searchInput').val().toLowerCase().trim();
                let filtered = allMessages;

                if (currentFilter === 'unread') filtered = filtered.filter(m => !m.IsRead);
                else if (currentFilter === 'read') filtered = filtered.filter(m => m.IsRead);

                if (q) {
                    filtered = filtered.filter(m =>
                        (m.NamaLengkap || '').toLowerCase().includes(q) ||
                        (m.Email || '').toLowerCase().includes(q) ||
                        (m.Pesan || '').toLowerCase().includes(q)
                    );
                }

                renderMessageList(filtered);
                updateAllCounters(filtered);
            }

            // ==========================================
            // Mark All as Read
            // ==========================================
            $('#btnMarkAllRead').click(function() {
                const unreadCount = allMessages.filter(m => !m.IsRead).length;
                if (unreadCount === 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Sudah semua terbaca',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    return;
                }

                Swal.fire({
                    title: 'Tandai semua sudah dibaca?',
                    text: `${unreadCount} pesan akan ditandai.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Tandai Semua',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#007bff'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: URL_MARK_ALL,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                loadMessages(false);
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', xhr.responseJSON?.message ??
                                    'Terjadi kesalahan.', 'error');
                            }
                        });
                    }
                });
            });

            // ==========================================
            // Export
            // ==========================================
            $('#btnExportExcel').click(function() {
                let hasDate = $('#dateRange').val().trim() !== '';
                let dateStart = hasDate ? ($('#dateRange').data('daterangepicker')?.startDate?.format('YYYY-MM-DD') || '') : '';
                let dateEnd = hasDate ? ($('#dateRange').data('daterangepicker')?.endDate?.format('YYYY-MM-DD') || '') : '';
                let params = [];
                if (dateStart) params.push('date_start=' + dateStart);
                if (dateEnd) params.push('date_end=' + dateEnd);
                const url = params.length ? URL_EXPORT + '?' + params.join('&') : URL_EXPORT;
                window.location.href = url;
            });

            // ==========================================
            // Delete
            // ==========================================
            $(document).on('click', '#btnDeleteMessage', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Pesan?',
                    text: "Data tidak dapat dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#dc3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: buildUrl(URL_DESTROY, id),
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Dihapus!',
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                });
                                loadMessages(false);
                                $('#messageDetail').hide();
                                $('#emptyState').show();
                                $('.cu-body').removeClass('cu-show-detail');
                                selectedMessageId = null;
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', xhr.responseJSON?.message ??
                                    'Terjadi kesalahan.', 'error');
                            }
                        });
                    }
                });
            });

            // ==========================================
            // Toggle Read/Unread
            // ==========================================
            $('#btnToggleRead').click(function() {
                if (!selectedMessageId) return;
                const msg = allMessages.find(m => m.id == selectedMessageId);
                if (!msg) return;

                const isCurrentlyRead = msg.IsRead;
                const url = isCurrentlyRead ?
                    buildUrl(URL_MARK_UNREAD, selectedMessageId) :
                    buildUrl(URL_MARK_READ, selectedMessageId);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        msg.IsRead = !isCurrentlyRead;
                        msg.ReadAt = msg.IsRead ? moment().format('YYYY-MM-DD HH:mm:ss') : null;
                        updateItemUI(selectedMessageId, msg.IsRead);
                        updateToggleReadButton(msg.IsRead);
                        applyFilters();
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal!', xhr.responseJSON?.message ?? 'Terjadi kesalahan.',
                            'error');
                    }
                });
            });

            // ==========================================
            // Render & UI Helpers
            // ==========================================
            function renderMessageList(messages) {
                if (messages.length === 0) {
                    $('#messageList').html(`
                        <div class="cu-list-empty">
                            <i class="fa fa-inbox fa-2x mb-2"></i>
                            <p>Tidak ada pesan</p>
                        </div>
                    `);
                    $('#messageDetail').hide();
                    $('#emptyState').show();
                    $('.cu-body').removeClass('cu-show-detail');
                    selectedMessageId = null;
                    return;
                }

                if (selectedMessageId && !messages.some(m => m.id == selectedMessageId)) {
                    $('#messageDetail').hide();
                    $('#emptyState').show();
                    $('.cu-body').removeClass('cu-show-detail');
                    selectedMessageId = null;
                }

                let html = '';
                messages.forEach((msg) => {
                    const initial = msg.NamaLengkap ? msg.NamaLengkap.charAt(0).toUpperCase() : '?';
                    const preview = msg.Pesan ? msg.Pesan.substring(0, 60) : '';
                    const date = msg.created_at ? moment(msg.created_at).format('DD MMM') : '';
                    const activeClass = (msg.id == selectedMessageId) ? ' active' : '';
                    const unreadClass = !msg.IsRead ? ' unread' : '';

                    html += `
                        <div class="cu-item${activeClass}${unreadClass}" data-id="${msg.id}" data-is-read="${msg.IsRead}">
                            ${!msg.IsRead ? '<div class="cu-unread-dot"></div>' : ''}
                            <div class="cu-avatar">${initial}</div>
                            <div class="cu-item-body">
                                <div class="cu-item-top">
                                    <span class="cu-item-name">${msg.NamaLengkap || '-'}</span>
                                    <span class="cu-item-date">${date}</span>
                                </div>
                                <p class="cu-item-preview">${preview}</p>
                            </div>
                        </div>
                    `;
                });

                $('#messageList').html(html);
            }

            function updateItemUI(id, isRead) {
                const $item = $(`.cu-item[data-id="${id}"]`);
                if (!$item.length) return;
                $item.attr('data-is-read', isRead);
                if (isRead) {
                    $item.removeClass('unread');
                    $item.find('.cu-unread-dot').remove();
                } else {
                    $item.addClass('unread');
                    if ($item.find('.cu-unread-dot').length === 0) {
                        $item.prepend('<div class="cu-unread-dot"></div>');
                    }
                }
            }

            function updateToggleReadButton(isRead) {
                const $btn = $('#btnToggleRead');
                const $icon = $btn.find('i');
                if (isRead) {
                    $icon.removeClass('fa-envelope-open').addClass('fa-envelope');
                    $btn.removeClass('is-unread');
                    $btn.attr('title', 'Tandai sebagai belum dibaca');
                } else {
                    $icon.removeClass('fa-envelope').addClass('fa-envelope-open');
                    $btn.addClass('is-unread');
                    $btn.attr('title', 'Tandai sebagai sudah dibaca');
                }
            }

            // ==========================================
            // Message Click + Auto-mark
            // ==========================================
            $(document).on('click', '.cu-item', function() {
                let id = $(this).data('id');
                let message = allMessages.find(m => m.id == id);
                if (!message) return;

                show_messageDetail(message);
                selectedMessageId = id;
                $('.cu-item').removeClass('active');
                $(this).addClass('active');

                if (!message.IsRead) {
                    $.ajax({
                        url: buildUrl(URL_MARK_READ, id),
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            message.IsRead = true;
                            message.ReadAt = moment().format('YYYY-MM-DD HH:mm:ss');
                            updateItemUI(id, true);
                            updateToggleReadButton(true);
                            applyFilters();
                        }
                    });
                } else {
                    updateToggleReadButton(true);
                }

                if ($(window).width() < 768) {
                    $('.cu-body').addClass('cu-show-detail');
                }
            });

            function show_messageDetail(msg) {
                let date = msg.created_at ? moment(msg.created_at).format('DD MMMM YYYY, HH:mm') : '';
                $('#detailName').text(msg.NamaLengkap || '-');
                $('#detailEmail').text(msg.Email || '-');
                $('#detailDate').text(date);
                $('#detailMessage').text(msg.Pesan || 'Tidak ada pesan');

                if (msg.NomorHandphone) {
                    $('#detailPhone').text(msg.NomorHandphone);
                    $('#detailPhoneWrap').show();
                } else {
                    $('#detailPhoneWrap').hide();
                }

                $('#btnDeleteMessage').data('id', msg.id);
                $('#btnReplyEmail').attr('href', `mailto:${msg.Email}?subject=Re: Contact Us - ${msg.NamaLengkap}`);
                updateToggleReadButton(msg.IsRead);

                $('#emptyState').hide();
                $('#messageDetail').show();
            }

            // ✅ Cleanup saat halaman di-unload
            $(window).on('beforeunload', function() {
                stopAutoRefresh();
            });
        });
    </script>
@endpush

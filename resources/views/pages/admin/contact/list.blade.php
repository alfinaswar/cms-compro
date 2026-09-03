@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Kontak Masuk</h1>
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
                        <div class="cu-daterange">
                            <i class="fa fa-calendar"></i>
                            <input type="text" id="dateRange" placeholder="Filter tanggal..." autocomplete="off" readonly>
                        </div>
                        <button type="button" class="cu-btn cu-btn-ghost" id="btnReset" title="Reset filter">
                            <i class="fa fa-redo"></i>
                        </button>
                        <button type="button" class="cu-btn cu-btn-accent" id="btnExportExcel">
                            <i class="fa fa-file-excel mr-1"></i> Export
                        </button>
                    </div>
                </div>

                <div class="cu-body">
                    <!-- ==================== KOLOM KIRI: LIST PESAN ==================== -->
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

                    <!-- ==================== KOLOM KANAN: DETAIL PESAN ==================== -->
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
                                <button type="button" class="cu-icon-btn cu-icon-btn-danger" id="btnDeleteMessage" data-id="" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>

                            <div class="cu-detail-phone" id="detailPhoneWrap" style="display:none;">
                                <i class="fa fa-phone"></i> <span id="detailPhone"></span>
                            </div>

                            <div class="cu-detail-body" id="detailMessage"></div>

                            <div class="cu-detail-footer" style="text-align: right;">
                                <a href="#" class="cu-reply-btn" id="btnReplyEmail" target="_blank" style="float: right;">
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
    <div class="cu-item" data-id="">
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

    .cu-title { margin: 0; font-size: 20px; font-weight: 600; color: var(--cu-text); }
    .cu-subtitle { font-size: 13px; color: var(--cu-muted); }

    .cu-toolbar-actions { display: flex; align-items: center; gap: 8px; }

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
    .cu-daterange i { font-size: 12px; }
    .cu-daterange input {
        background: transparent;
        border: none;
        outline: none;
        color: var(--cu-text);
        font-size: 13px;
        width: 150px;
    }
    .cu-daterange input::placeholder { color: var(--cu-muted); }

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
    .cu-btn:hover { background: #1c2436; }
    .cu-btn-ghost { padding: 8px 11px; color: var(--cu-muted); }
    .cu-btn-accent {
        background: var(--cu-accent);
        border-color: var(--cu-accent);
        color: #fff;
        font-weight: 600;
    }
    .cu-btn-accent:hover { background: #0069d9; }

    .cu-body {
        display: flex;
        min-height: 560px;
    }

    /* ---- List pane ---- */
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
    .cu-search i { font-size: 12px; }
    .cu-search input {
        background: transparent;
        border: none;
        outline: none;
        color: var(--cu-text);
        font-size: 13px;
        width: 100%;
    }
    .cu-search input::placeholder { color: var(--cu-muted); }

    .cu-list {
        flex: 1;
        overflow-y: auto;
        max-height: calc(100vh - 340px);
    }

    .cu-loading, .cu-list-empty {
        text-align: center;
        padding: 60px 20px;
        color: var(--cu-muted);
    }
    .cu-loading i { font-size: 22px; margin-bottom: 8px; display: block; }

    .cu-item {
        display: flex;
        gap: 10px;
        padding: 12px 16px;
        cursor: pointer;
        border-left: 3px solid transparent;
        transition: background 0.12s ease;
    }
    .cu-item:hover { background: var(--cu-panel-alt); }
    .cu-item.active {
        background: var(--cu-accent-soft);
        border-left-color: var(--cu-accent);
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

    .cu-item-body { min-width: 0; flex: 1; }

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
    .cu-empty i { font-size: 42px; margin-bottom: 14px; opacity: 0.5; }
    .cu-empty h6 { color: var(--cu-text); margin-bottom: 4px; }
    .cu-empty p { font-size: 13px; margin: 0; }

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

    .cu-detail-name { margin: 0 0 4px; font-size: 18px; font-weight: 600; color: var(--cu-text); }

    .cu-detail-meta { font-size: 12.5px; color: var(--cu-muted); }
    .cu-dot { margin: 0 6px; }

    .cu-icon-btn {
        border: 1px solid var(--cu-border);
        background: var(--cu-panel-alt);
        color: var(--cu-muted);
        width: 34px;
        height: 34px;
        border-radius: 8px;
        cursor: pointer;
        flex-shrink: 0;
    }
       .cu-icon-btn-danger:hover { background: rgba(220, 53, 69, 0.08); color: var(--cu-danger); border-color: rgba(220,53,69,0.4); }

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

    .cu-detail-footer { margin-top: 20px; }

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
    .cu-reply-btn:hover { background: #0069d9; color: #fff; text-decoration: none; }
    .cu-reply-btn:hover { background: #3fd9ee; color: #06222a; text-decoration: none; }

    .cu-list::-webkit-scrollbar { width: 6px; }
    .cu-list::-webkit-scrollbar-track { background: transparent; }
    .cu-list::-webkit-scrollbar-thumb { background: #2a3348; border-radius: 3px; }

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

    @media (max-width: 768px) {
        .cu-body { flex-direction: column; min-height: 0; }
        .cu-list-pane { width: 100%; border-right: none; border-bottom: 1px solid var(--cu-border); }
        .cu-list { max-height: 320px; }
        .cu-detail-pane.cu-hide-mobile-list ~ .cu-list-pane,
        .cu-body.cu-show-detail .cu-list-pane { display: none; }
        .cu-body.cu-show-detail .cu-detail-pane { display: flex; }
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

        // Inisialisasi Date Range Picker
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
                'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        });

        // Load messages
        loadMessages();

        // Reset button
        $('#btnReset').click(function() {
            $('#dateRange').val('');
            $('#dateRange').data('daterangepicker').setStartDate(moment().subtract(29, 'days'));
            $('#dateRange').data('daterangepicker').setEndDate(moment());
            loadMessages();
        });

        // Apply date filter automatically once range picked
        $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            loadMessages();
        });

        // Live search (client-side, over already-loaded messages)
        $('#searchInput').on('keyup', function() {
            let q = $(this).val().toLowerCase().trim();
            if (!q) {
                renderMessageList(allMessages);
                return;
            }
            let filtered = allMessages.filter(m =>
                (m.NamaLengkap || '').toLowerCase().includes(q) ||
                (m.Email || '').toLowerCase().includes(q) ||
                (m.Pesan || '').toLowerCase().includes(q)
            );
            renderMessageList(filtered);
        });

        // Export Excel
        $('#btnExportExcel').click(function() {
            let dateStart = $('#dateRange').data('daterangepicker')?.startDate?.format('YYYY-MM-DD') || '';
            let dateEnd = $('#dateRange').data('daterangepicker')?.endDate?.format('YYYY-MM-DD') || '';

            let url = "{{ route('contact.export') }}";
            let params = [];
            if (dateStart) params.push('date_start=' + dateStart);
            if (dateEnd) params.push('date_end=' + dateEnd);
            if (params.length) url += '?' + params.join('&');

            window.location.href = url;
        });

        // Delete message
        $(document).on('click', '#btnDeleteMessage', function() {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Hapus Pesan?',
                text: "Data yang dihapus tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#dc3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url('admin/contact') }}/' + id,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Dihapus!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            loadMessages();
                            $('#messageDetail').hide();
                            $('#emptyState').show();
                            $('.cu-body').removeClass('cu-show-detail');
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal!', xhr.responseJSON?.message ?? 'Terjadi kesalahan.', 'error');
                        }
                    });
                }
            });
        });

        // Function to load messages
        function loadMessages() {
            let dateStart = $('#dateRange').data('daterangepicker')?.startDate?.format('YYYY-MM-DD') || '';
            let dateEnd = $('#dateRange').data('daterangepicker')?.endDate?.format('YYYY-MM-DD') || '';

            $.ajax({
                url: "{{ route('contact.list') }}",
                data: {
                    date_start: dateStart,
                    date_end: dateEnd
                },
                success: function(response) {
                    allMessages = response.data;
                    renderMessageList(allMessages);
                    $('#cuTotalLabel').text(allMessages.length + ' pesan');
                },
                error: function(xhr) {
                    $('#messageList').html(`
                        <div class="cu-list-empty">
                            <i class="fa fa-exclamation-triangle"></i>
                            <p>Gagal memuat pesan.</p>
                        </div>
                    `);
                }
            });
        }

        // Function to render message list
        function renderMessageList(messages) {
            if (messages.length === 0) {
                $('#messageList').html(`
                    <div class="cu-list-empty">
                        <i class="fa fa-inbox fa-2x mb-2"></i>
                        <p>Tidak ada pesan</p>
                    </div>
                `);
                return;
            }

            let html = '';
            let template = $('#messageItemTemplate').html();

            messages.forEach((msg) => {
                let itemHtml = template;
                let initial = msg.NamaLengkap ? msg.NamaLengkap.charAt(0).toUpperCase() : '?';
                let preview = msg.Pesan ? msg.Pesan.substring(0, 60) : '';
                let date = msg.created_at ? moment(msg.created_at).format('DD MMM') : '';
                let activeClass = (msg.id == selectedMessageId) ? ' active' : '';

                itemHtml = itemHtml.replace('data-id=""', `data-id="${msg.id}"`);
                itemHtml = itemHtml.replace('class="cu-item" data-id', `class="cu-item${activeClass}" data-id`);
                itemHtml = itemHtml.replace('cu-avatar"></div>', `cu-avatar">${initial}</div>`);
                itemHtml = itemHtml.replace('cu-item-name"></span>', `cu-item-name">${msg.NamaLengkap || '-'}</span>`);
                itemHtml = itemHtml.replace('cu-item-date"></span>', `cu-item-date">${date}</span>`);
                itemHtml = itemHtml.replace('cu-item-preview"></p>', `cu-item-preview">${preview}</p>`);

                html += itemHtml;
            });

            $('#messageList').html(html);
        }

        // Handle message click
        $(document).on('click', '.cu-item', function() {
            let id = $(this).data('id');
            let message = allMessages.find(m => m.id == id);

            if (message) {
                show_messageDetail(message);
                selectedMessageId = id;

                $('.cu-item').removeClass('active');
                $(this).addClass('active');

                // On mobile, hide list and show detail
                if ($(window).width() < 768) {
                    $('.cu-body').addClass('cu-show-detail');
                }
            }
        });

        // Function to show message detail
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

            $('#emptyState').hide();
            $('#messageDetail').show();
        }

        // Back button (mobile) — tap outside or add a lightweight back affordance
        $(document).on('click', '.cu-detail-pane', function(e) {
            // no-op placeholder; back handled via list click / browser back on small screens
        });
    });
</script>
@endpush

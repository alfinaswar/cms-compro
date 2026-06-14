@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manajemen Kontak Masuk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Contact Us</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary shadow-sm border-0">
                    <div class="card-header bg-white border-bottom d-flex justify-content-end align-items-center">
                        <h3 class="card-title mb-0 mr-auto">
                            <i class="fa fa-envelope text-primary mr-2"></i><strong>Daftar Kontak Masuk</strong>
                        </h3>
                        <button type="button" class="btn btn-success btn-sm px-3" id="btnExportExcel">
                            <i class="fa fa-file-excel mr-1"></i> Export Excel
                        </button>
                    </div>


                    <div class="card-body">
                        {{-- Filter Tanggal --}}
                        <div class="card bg-light border-0 mb-3">
                            <div class="card-body py-3">
                                <form id="formFilter" class="row align-items-end">
                                    <div class="col-md-4 mb-2 mb-md-0">
                                        <label class="mb-1"><strong><i class="fa fa-calendar mr-1"></i> Rentang
                                                Tanggal</strong></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="dateRange" name="date_range"
                                                placeholder="Pilih rentang tanggal..." autocomplete="off" readonly>
                                        </div>
                                        <small class="text-muted">Klik untuk memilih rentang tanggal filter.</small>
                                    </div>
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <label class="mb-1"><strong>Status Filter</strong></label>
                                        <div>
                                            <span id="filterStatus" class="badge badge-secondary px-3 py-2">
                                                <i class="fa fa-info-circle mr-1"></i> Belum ada filter
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 text-md-right">
                                        <button type="button" class="btn btn-primary px-4" id="btnFilter">
                                            <i class="fa fa-filter mr-1"></i> Terapkan Filter
                                        </button>
                                        <button type="button" class="btn btn-secondary px-4" id="btnReset">
                                            <i class="fa fa-redo mr-1"></i> Reset
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <table id="tableContact" class="table table-bordered table-striped" style="width: 100%;">
                            <thead class="bg-light">
                                <tr>
                                    <th style="width: 5%" class="text-center">No</th>
                                    <th style="width: 18%">Nama Lengkap</th>
                                    <th style="width: 18%">Email</th>
                                    <th style="width: 15%">Nomor Handphone</th>
                                    <th style="width: 17%">Pesan</th>
                                    <th style="width: 15%" class="text-center">Dikirim Pada</th>
                                    <th style="width: 12%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <!-- Date Range Picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .daterangepicker {
            font-family: 'Source Sans Pro', sans-serif;
        }

        .daterangepicker td.active,
        .daterangepicker td.active:hover {
            background-color: #007bff;
        }

        .daterangepicker .ranges li.active {
            background-color: #007bff;
        }
    </style>
@endpush

@push('scripts')
    <!-- Date Range Picker -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi Date Range Picker
            let startDate = moment().subtract(29, 'days');
            let endDate = moment();

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
                },
                startDate: startDate,
                endDate: endDate,
                opens: 'left'
            });

            // Event saat pilih tanggal
            $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format(
                    'DD/MM/YYYY'));
                updateFilterStatus(picker.startDate, picker.endDate);
            });

            $('#dateRange').on('cancel.daterangepicker', function() {
                $(this).val('');
                $('#filterStatus').html('<i class="fa fa-info-circle mr-1"></i> Belum ada filter')
                    .removeClass('badge-success').addClass('badge-secondary');
            });

            function updateFilterStatus(start, end) {
                $('#filterStatus')
                    .html('<i class="fa fa-check-circle mr-1"></i> ' + start.format('DD MMM YYYY') + ' s/d ' + end
                        .format('DD MMM YYYY'))
                    .removeClass('badge-secondary').addClass('badge-success');
            }

            // DataTables
            let table = $('#tableContact').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                bDestroy: true,
                ajax: {
                    url: "{{ route('contact.list') }}",
                    data: function(d) {
                        d.date_start = $('#dateRange').data('daterangepicker')?.startDate?.format(
                            'YYYY-MM-DD') || '';
                        d.date_end = $('#dateRange').data('daterangepicker')?.endDate?.format(
                            'YYYY-MM-DD') || '';
                    }
                },
                language: {
                    processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Memuat...</span>',
                    emptyTable: 'Tidak ada data Contact Us',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
                    search: 'Cari:',
                    paginate: {
                        next: '<i class="fa fa-angle-right"></i>',
                        previous: '<i class="fa fa-angle-left"></i>'
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'NamaLengkap',
                        name: 'NamaLengkap'
                    },
                    {
                        data: 'Email',
                        name: 'Email'
                    },
                    {
                        data: 'NomorHandphone',
                        name: 'NomorHandphone'
                    },
                    {
                        data: 'Pesan',
                        name: 'Pesan',
                        render: function(data) {
                            if (!data) return '-';
                            let text = $('<div/>').text(data).html();
                            return text.length > 60 ? text.substring(0, 60) + '...' : text;
                        }
                    },
                    {
                        data: 'created_at_formatted',
                        name: 'created_at_formatted',
                        className: 'text-center'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                order: [
                    [5, 'desc']
                ]
            });

            // Tombol Filter
            $('#btnFilter').click(function() {
                table.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Filter Diterapkan',
                    text: 'Data berhasil difilter sesuai rentang tanggal.',
                    timer: 1500,
                    showConfirmButton: false
                });
            });

            // Tombol Reset
            $('#btnReset').click(function() {
                $('#dateRange').val('');
                $('#dateRange').data('daterangepicker').setStartDate(moment().subtract(29, 'days'));
                $('#dateRange').data('daterangepicker').setEndDate(moment());
                $('#filterStatus').html('<i class="fa fa-info-circle mr-1"></i> Belum ada filter')
                    .removeClass('badge-success').addClass('badge-secondary');
                table.ajax.reload();
            });

            // Tombol Export Excel
            $('#btnExportExcel').click(function() {
                let dateStart = $('#dateRange').data('daterangepicker')?.startDate?.format('YYYY-MM-DD') ||
                    '';
                let dateEnd = $('#dateRange').data('daterangepicker')?.endDate?.format('YYYY-MM-DD') || '';

                let url = "{{ route('contact.export') }}";
                let params = [];
                if (dateStart) params.push('date_start=' + dateStart);
                if (dateEnd) params.push('date_end=' + dateEnd);
                if (params.length) url += '?' + params.join('&');

                window.location.href = url;
            });

            // Delete handler
            $('body').on('click', '.btn-delete', function() {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Hapus Pesan?',
                    text: "Apakah Anda yakin ingin menghapus pesan ini? Data yang dihapus tidak dapat dikembalikan.",
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
                                table.ajax.reload();
                            },
                            error: function(xhr) {
                                Swal.fire('Gagal!', xhr.responseJSON?.message ??
                                    'Terjadi kesalahan.', 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

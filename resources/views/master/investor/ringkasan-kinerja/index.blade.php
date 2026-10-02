@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-chart-column mr-2 text-primary"></i>Kelola Ringkasan Kinerja Keuangan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('jenis-laporan.index') }}">Investor</a></li>
                    <li class="breadcrumb-item active">Ringkasan Kinerja</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">

        {{-- Flash message alert --}}
        @if (Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-1"></i> {{ Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (isset($errors) && $errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle mr-1"></i> <strong>Terjadi Kesalahan:</strong>
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        {{-- ============================================ --}}
        {{-- CARD 1: PENGATURAN PERIODE TAHUN & HIGHLIGHT --}}
        {{-- ============================================ --}}
        <div class="card card-outline card-info">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h3 class="card-title font-weight-bold">
                        <i class="fas fa-sliders-h mr-2"></i> Pengaturan Periode Tampilan &amp; Highlight
                        <span class="badge badge-info ml-2">
                            Periode Aktif: {{ reset($activeYears) }} - {{ end($activeYears) }} ({{ count($activeYears) }} Tahun)
                        </span>
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-outline-success font-weight-bold mr-2" data-toggle="modal" data-target="#modalTambahTahun">
                            <i class="fas fa-calendar-plus mr-1"></i> Tambah Tahun Baru
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.investor.ringkasan-kinerja.update-periode') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group">
                                <label>Mode Penentuan Periode <span class="text-danger">*</span></label>
                                <select name="ModeWindow" class="form-control form-control-sm">
                                    <option value="Kustom" {{ old('ModeWindow', $pengaturan->ModeWindow) == 'Kustom' ? 'selected' : '' }}>Rentang Kustom (Mulai - Selesai)</option>
                                    <option value="Otomatis" {{ old('ModeWindow', $pengaturan->ModeWindow) == 'Otomatis' ? 'selected' : '' }}>Otomatis (N Tahun Terakhir)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <div class="form-group">
                                <label>Jumlah Tahun <span class="text-danger">*</span></label>
                                <input type="number" name="JumlahTahun" class="form-control form-control-sm" min="1" max="20" value="{{ old('JumlahTahun', $pengaturan->JumlahTahun ?? 5) }}" required>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <div class="form-group">
                                <label>Tahun Mulai <span class="text-danger">*</span></label>
                                <input type="number" name="TahunMulai" class="form-control form-control-sm" min="1990" max="2100" value="{{ old('TahunMulai', $pengaturan->TahunMulai ?? 2021) }}" required>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <div class="form-group">
                                <label>Tahun Selesai (Terbaru) <span class="text-danger">*</span></label>
                                <input type="number" name="TahunSelesai" class="form-control form-control-sm text-primary font-weight-bold" min="1990" max="2100" value="{{ old('TahunSelesai', $pengaturan->TahunSelesai ?? 2025) }}" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label>Highlight Pertumbuhan Revenue</label>
                                <input type="text" name="PertumbuhanRevenue" class="form-control form-control-sm" value="{{ old('PertumbuhanRevenue', $pengaturan->PertumbuhanRevenue ?? '+31.5% YoY (2025)') }}" placeholder="+31.5% YoY (2025)">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Highlight Pertumbuhan Laba Bersih (Profit)</label>
                                <input type="text" name="PertumbuhanProfit" class="form-control form-control-sm" value="{{ old('PertumbuhanProfit', $pengaturan->PertumbuhanProfit ?? '+47.7% YoY (2025)') }}" placeholder="+47.7% YoY (2025)">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Subjudul Deskripsi</label>
                                <input type="text" name="Subjudul" class="form-control form-control-sm" value="{{ old('Subjudul', $pengaturan->Subjudul ?? 'Ringkasan kinerja keuangan utama perusahaan selama 5 tahun terakhir (2021 - 2025).') }}">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center flex-wrap pt-2 border-top">
                        <div class="mb-2">
                            <span class="text-xs text-muted mr-1 font-weight-bold">Tahun yang tercatat di database:</span>
                            @foreach ($allYears as $yr)
                                <span class="badge {{ in_array($yr, $activeYears) ? 'badge-primary' : 'badge-secondary' }} px-2 py-1 mr-1">
                                    {{ $yr }} {{ in_array($yr, $activeYears) ? '✓' : '' }}
                                </span>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-sm btn-info font-weight-bold shadow-sm mb-2">
                            <i class="fas fa-save mr-1"></i> Simpan Pengaturan Periode
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ============================================ --}}
        {{-- CARD 2: TABEL RINGKASAN KINERJA KEUANGAN --}}
        {{-- ============================================ --}}
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <div class="d-flex justify-content-between align-items-center flex-wrap px-3 pt-2">
                    <ul class="nav nav-tabs" id="kinerjaTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active font-weight-bold" id="laba-rugi-tab" data-toggle="pill" href="#tab-laba-rugi" role="tab">
                                <i class="fas fa-money-bill-wave mr-1 text-success"></i> Laba Rugi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="posisi-keuangan-tab" data-toggle="pill" href="#tab-posisi-keuangan" role="tab">
                                <i class="fas fa-balance-scale mr-1 text-info"></i> Posisi Keuangan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="rasio-tab" data-toggle="pill" href="#tab-rasio" role="tab">
                                <i class="fas fa-percentage mr-1 text-warning"></i> Rasio Penting
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="saham-dividen-tab" data-toggle="pill" href="#tab-saham-dividen" role="tab">
                                <i class="fas fa-coins mr-1 text-danger"></i> Saham &amp; Dividen
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold text-indigo" id="batch-edit-tab" data-toggle="pill" href="#tab-batch-edit" role="tab">
                                <i class="fas fa-table mr-1"></i> Edit Cepat Semua (Spreadsheet)
                            </a>
                        </li>
                    </ul>

                    <div class="my-2">
                        <button type="button" class="btn btn-sm btn-success font-weight-bold shadow-sm" data-toggle="modal" data-target="#modalTambahPos">
                            <i class="fas fa-plus mr-1"></i> Tambah Pos Keuangan
                        </button>
                        <a href="{{ url('/id/laporan-keuangan#ringkasan-kinerja') }}" target="_blank" class="btn btn-sm btn-outline-primary ml-1">
                            <i class="fas fa-external-link-alt mr-1"></i> Preview Frontend
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="tab-content" id="kinerjaTabContent">

                    {{-- TAB 1: LABA RUGI --}}
                    <div class="tab-pane fade show active" id="tab-laba-rugi" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="bg-light">
                                    <tr class="text-center font-weight-bold">
                                        <th style="width: 5%">No</th>
                                        <th style="width: 28%" class="text-left">Pos Keuangan (Laba Rugi)</th>
                                        @foreach ($activeYears as $yr)
                                            <th class="{{ $loop->last ? 'table-primary text-primary font-weight-bold' : '' }}">{{ $yr }}</th>
                                        @endforeach
                                        <th style="width: 12%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($labaRugi as $row)
                                        <tr class="{{ $row->IsHighlight ? 'table-success' : '' }}">
                                            <td class="text-center font-weight-bold">{{ $row->Urutan }}</td>
                                            <td class="{{ $row->IsBold ? 'font-weight-bold text-dark' : '' }} {{ $row->IsSubPos ? 'pl-4 text-muted' : '' }}">
                                                @if($row->IsSubPos)&bull; @endif
                                                {{ $row->NamaPos }}
                                                @if($row->Catatan)
                                                    <small class="d-block text-muted font-italic">{{ $row->Catatan }}</small>
                                                @endif
                                            </td>
                                            @foreach ($activeYears as $yr)
                                                <td class="text-right {{ $loop->last ? 'font-weight-bold text-primary table-primary' : '' }}">
                                                    {{ $row->nilaiTahun($yr) }}
                                                </td>
                                            @endforeach
                                            <td class="text-center">
                                                <button type="button" class="btn btn-xs btn-warning btn-edit-row"
                                                        data-id="{{ $row->id }}"
                                                        data-kategori="{{ $row->Kategori }}"
                                                        data-namapos="{{ $row->NamaPos }}"
                                                        data-kodepos="{{ $row->KodePos }}"
                                                        data-catatan="{{ $row->Catatan }}"
                                                        data-satuan="{{ $row->Satuan }}"
                                                        data-issubpos="{{ $row->IsSubPos ? 1 : 0 }}"
                                                        data-isbold="{{ $row->IsBold ? 1 : 0 }}"
                                                        data-ishighlight="{{ $row->IsHighlight ? 1 : 0 }}"
                                                        data-urutan="{{ $row->Urutan }}"
                                                        data-nilais='@json($row->nilais->pluck("NilaiTampil", "Tahun"))'
                                                        title="Edit Nilai">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-danger btn-delete-row"
                                                        data-id="{{ $row->id }}"
                                                        data-nama="{{ $row->NamaPos }}"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="{{ count($activeYears) + 3 }}" class="text-center text-muted">Belum ada data Pos Laba Rugi.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- TAB 2: POSISI KEUANGAN --}}
                    <div class="tab-pane fade" id="tab-posisi-keuangan" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="bg-light">
                                    <tr class="text-center font-weight-bold">
                                        <th style="width: 5%">No</th>
                                        <th style="width: 28%" class="text-left">Pos Posisi Keuangan (Neraca)</th>
                                        @foreach ($activeYears as $yr)
                                            <th class="{{ $loop->last ? 'table-primary text-primary font-weight-bold' : '' }}">{{ $yr }}</th>
                                        @endforeach
                                        <th style="width: 12%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($posisiKeuangan as $row)
                                        <tr class="{{ $row->IsHighlight ? 'table-success' : '' }}">
                                            <td class="text-center font-weight-bold">{{ $row->Urutan }}</td>
                                            <td class="{{ $row->IsBold ? 'font-weight-bold text-dark' : '' }} {{ $row->IsSubPos ? 'pl-4 text-muted' : '' }}">
                                                @if($row->IsSubPos)&bull; @endif
                                                {{ $row->NamaPos }}
                                                @if($row->Catatan)
                                                    <small class="d-block text-muted font-italic">{{ $row->Catatan }}</small>
                                                @endif
                                            </td>
                                            @foreach ($activeYears as $yr)
                                                <td class="text-right {{ $loop->last ? 'font-weight-bold text-primary table-primary' : '' }}">
                                                    {{ $row->nilaiTahun($yr) }}
                                                </td>
                                            @endforeach
                                            <td class="text-center">
                                                <button type="button" class="btn btn-xs btn-warning btn-edit-row"
                                                        data-id="{{ $row->id }}"
                                                        data-kategori="{{ $row->Kategori }}"
                                                        data-namapos="{{ $row->NamaPos }}"
                                                        data-kodepos="{{ $row->KodePos }}"
                                                        data-catatan="{{ $row->Catatan }}"
                                                        data-satuan="{{ $row->Satuan }}"
                                                        data-issubpos="{{ $row->IsSubPos ? 1 : 0 }}"
                                                        data-isbold="{{ $row->IsBold ? 1 : 0 }}"
                                                        data-ishighlight="{{ $row->IsHighlight ? 1 : 0 }}"
                                                        data-urutan="{{ $row->Urutan }}"
                                                        data-nilais='@json($row->nilais->pluck("NilaiTampil", "Tahun"))'
                                                        title="Edit Nilai">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-danger btn-delete-row"
                                                        data-id="{{ $row->id }}"
                                                        data-nama="{{ $row->NamaPos }}"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="{{ count($activeYears) + 3 }}" class="text-center text-muted">Belum ada baris Posisi Keuangan.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- TAB 3: RASIO PENTING --}}
                    <div class="tab-pane fade" id="tab-rasio" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="bg-light">
                                    <tr class="text-center font-weight-bold">
                                        <th style="width: 5%">No</th>
                                        <th style="width: 28%" class="text-left">Indikator Rasio Finansial</th>
                                        @foreach ($activeYears as $yr)
                                            <th class="{{ $loop->last ? 'table-primary text-primary font-weight-bold' : '' }}">{{ $yr }}</th>
                                        @endforeach
                                        <th style="width: 12%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($rasioKeuangan as $row)
                                        <tr class="{{ $row->IsHighlight ? 'table-success' : '' }}">
                                            <td class="text-center font-weight-bold">{{ $row->Urutan }}</td>
                                            <td class="{{ $row->IsBold ? 'font-weight-bold text-dark' : '' }} {{ $row->IsSubPos ? 'pl-4 text-muted' : '' }}">
                                                {{ $row->NamaPos }}
                                                @if($row->Catatan)
                                                    <small class="d-block text-muted font-italic">{{ $row->Catatan }}</small>
                                                @endif
                                            </td>
                                            @foreach ($activeYears as $yr)
                                                <td class="text-right {{ $loop->last ? 'font-weight-bold text-primary table-primary' : '' }}">
                                                    {{ $row->nilaiTahun($yr) }}
                                                </td>
                                            @endforeach
                                            <td class="text-center">
                                                <button type="button" class="btn btn-xs btn-warning btn-edit-row"
                                                        data-id="{{ $row->id }}"
                                                        data-kategori="{{ $row->Kategori }}"
                                                        data-namapos="{{ $row->NamaPos }}"
                                                        data-kodepos="{{ $row->KodePos }}"
                                                        data-catatan="{{ $row->Catatan }}"
                                                        data-satuan="{{ $row->Satuan }}"
                                                        data-issubpos="{{ $row->IsSubPos ? 1 : 0 }}"
                                                        data-isbold="{{ $row->IsBold ? 1 : 0 }}"
                                                        data-ishighlight="{{ $row->IsHighlight ? 1 : 0 }}"
                                                        data-urutan="{{ $row->Urutan }}"
                                                        data-nilais='@json($row->nilais->pluck("NilaiTampil", "Tahun"))'
                                                        title="Edit Nilai">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-danger btn-delete-row"
                                                        data-id="{{ $row->id }}"
                                                        data-nama="{{ $row->NamaPos }}"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="{{ count($activeYears) + 3 }}" class="text-center text-muted">Belum ada baris Rasio.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- TAB 4: SAHAM & DIVIDEN --}}
                    <div class="tab-pane fade" id="tab-saham-dividen" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead class="bg-light">
                                    <tr class="text-center font-weight-bold">
                                        <th style="width: 5%">No</th>
                                        <th style="width: 28%" class="text-left">Indikator Saham &amp; Dividen</th>
                                        @foreach ($activeYears as $yr)
                                            <th class="{{ $loop->last ? 'table-primary text-primary font-weight-bold' : '' }}">{{ $yr }}</th>
                                        @endforeach
                                        <th style="width: 12%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($sahamDividen as $row)
                                        <tr class="{{ $row->IsHighlight ? 'table-success' : '' }}">
                                            <td class="text-center font-weight-bold">{{ $row->Urutan }}</td>
                                            <td class="{{ $row->IsBold ? 'font-weight-bold text-dark' : '' }} {{ $row->IsSubPos ? 'pl-4 text-muted' : '' }}">
                                                {{ $row->NamaPos }}
                                                @if($row->Catatan)
                                                    <small class="d-block text-muted font-italic">{{ $row->Catatan }}</small>
                                                @endif
                                            </td>
                                            @foreach ($activeYears as $yr)
                                                <td class="text-right {{ $loop->last ? 'font-weight-bold text-primary table-primary' : '' }}">
                                                    {{ $row->nilaiTahun($yr) }}
                                                </td>
                                            @endforeach
                                            <td class="text-center">
                                                <button type="button" class="btn btn-xs btn-warning btn-edit-row"
                                                        data-id="{{ $row->id }}"
                                                        data-kategori="{{ $row->Kategori }}"
                                                        data-namapos="{{ $row->NamaPos }}"
                                                        data-kodepos="{{ $row->KodePos }}"
                                                        data-catatan="{{ $row->Catatan }}"
                                                        data-satuan="{{ $row->Satuan }}"
                                                        data-issubpos="{{ $row->IsSubPos ? 1 : 0 }}"
                                                        data-isbold="{{ $row->IsBold ? 1 : 0 }}"
                                                        data-ishighlight="{{ $row->IsHighlight ? 1 : 0 }}"
                                                        data-urutan="{{ $row->Urutan }}"
                                                        data-nilais='@json($row->nilais->pluck("NilaiTampil", "Tahun"))'
                                                        title="Edit Nilai">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-danger btn-delete-row"
                                                        data-id="{{ $row->id }}"
                                                        data-nama="{{ $row->NamaPos }}"
                                                        title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="{{ count($activeYears) + 3 }}" class="text-center text-muted">Belum ada baris Saham &amp; Dividen.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- TAB 5: BATCH EDIT SPREADSHEET --}}
                    <div class="tab-pane fade" id="tab-batch-edit" role="tabpanel">
                        <div class="alert alert-info py-2 px-3 text-sm">
                            <i class="fas fa-info-circle mr-1"></i> Mode Spreadsheet memungkinkan Anda mengedit langsung seluruh angka untuk semua periode aktif di bawah ini dan menyimpannya sekaligus dalam sekali klik.
                        </div>

                        <form action="{{ route('admin.investor.ringkasan-kinerja.quick-update-batch') }}" method="POST">
                            @csrf
                            <div class="table-responsive" style="max-height: 550px; overflow-y: auto;">
                                <table class="table table-bordered table-sm table-striped">
                                    <thead class="bg-dark text-white sticky-top">
                                        <tr class="text-center">
                                            <th style="width: 4%">No</th>
                                            <th style="width: 14%">Kategori</th>
                                            <th style="width: 24%">Nama Pos Keuangan</th>
                                            @foreach ($activeYears as $yr)
                                                <th style="min-width: 110px;" class="{{ $loop->last ? 'bg-primary' : '' }}">
                                                    {{ $yr }} {{ $loop->last ? '(Terbaru)' : '' }}
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($allRows as $r)
                                            <tr>
                                                <td class="p-1">
                                                    <input type="number" name="rows[{{ $r->id }}][Urutan]" class="form-control form-control-sm text-center p-1" value="{{ $r->Urutan }}">
                                                </td>
                                                <td class="p-1">
                                                    <span class="badge badge-light border d-block py-1">{{ $r->Kategori }}</span>
                                                </td>
                                                <td class="p-1">
                                                    <input type="text" name="rows[{{ $r->id }}][NamaPos]" class="form-control form-control-sm {{ $r->IsBold ? 'font-weight-bold' : '' }}" value="{{ $r->NamaPos }}">
                                                </td>
                                                @foreach ($activeYears as $yr)
                                                    <td class="p-1 {{ $loop->last ? 'table-primary' : '' }}">
                                                        <input type="text"
                                                               name="rows[{{ $r->id }}][nilais][{{ $yr }}]"
                                                               class="form-control form-control-sm text-right {{ $loop->last ? 'font-weight-bold text-primary' : '' }}"
                                                               value="{{ $r->nilaiTahun($yr) }}">
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary font-weight-bold shadow">
                                    <i class="fas fa-save mr-1"></i> Simpan Semua Perubahan (Batch Update)
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

{{-- ============================================ --}}
{{-- MODAL TAMBAH POS BARU --}}
{{-- ============================================ --}}
<div class="modal fade" id="modalTambahPos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.investor.ringkasan-kinerja.store') }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-plus-circle mr-1"></i> Tambah Pos Keuangan Baru</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Kategori Bagian <span class="text-danger">*</span></label>
                                <select name="Kategori" class="form-control" required>
                                    <option value="Laba Rugi">1. Laporan Laba Rugi Komprehensif</option>
                                    <option value="Posisi Keuangan">2. Laporan Posisi Keuangan</option>
                                    <option value="Rasio">3. Rasio - Rasio Penting</option>
                                    <option value="Saham & Dividen">4. Informasi Saham & Dividen</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Nama Pos Keuangan <span class="text-danger">*</span></label>
                                <input type="text" name="NamaPos" class="form-control" placeholder="Contoh: Pendapatan Usaha" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>No Urutan</label>
                                <input type="number" name="Urutan" class="form-control text-center" value="{{ $allRows->count() + 1 }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Catatan / Sub-keterangan (Opsional)</label>
                                <input type="text" name="Catatan" class="form-control" placeholder="Contoh: Laba yang dapat diatribusikan kepada:">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Satuan (Opsional)</label>
                                <input type="text" name="Satuan" class="form-control" placeholder="Jutaan IDR / % / Rupiah" value="Jutaan IDR">
                            </div>
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkSubPos" name="IsSubPos" value="1">
                                <label class="custom-control-label font-weight-normal" for="checkSubPos">Sub-Pos (Indentasi Menjorok)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkBold" name="IsBold" value="1">
                                <label class="custom-control-label font-weight-normal" for="checkBold">Teks Tebal (Bold Total/Subtotal)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkHighlight" name="IsHighlight" value="1">
                                <label class="custom-control-label font-weight-normal" for="checkHighlight">Highlight Hijau (Sorotan Utama)</label>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6 class="font-weight-bold text-muted mb-2">Nilai Per Periode Tahun:</h6>
                    <div class="row">
                        @foreach ($activeYears as $yr)
                            <div class="col">
                                <label class="text-xs {{ $loop->last ? 'text-primary font-weight-bold' : '' }}">{{ $yr }}</label>
                                <input type="text" name="nilais[{{ $yr }}]" class="form-control form-control-sm text-right {{ $loop->last ? 'font-weight-bold text-primary' : '' }}" placeholder="-">
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Tambah Pos</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- MODAL EDIT POS --}}
{{-- ============================================ --}}
<div class="modal fade" id="modalEditPos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formEditPos" action="" method="POST">
                @csrf
                <div class="modal-header bg-warning">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Pos Keuangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Kategori Bagian <span class="text-danger">*</span></label>
                                <select name="Kategori" id="editKategori" class="form-control" required>
                                    <option value="Laba Rugi">1. Laporan Laba Rugi Komprehensif</option>
                                    <option value="Posisi Keuangan">2. Laporan Posisi Keuangan</option>
                                    <option value="Rasio">3. Rasio - Rasio Penting</option>
                                    <option value="Saham & Dividen">4. Informasi Saham & Dividen</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Nama Pos Keuangan <span class="text-danger">*</span></label>
                                <input type="text" name="NamaPos" id="editNamaPos" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>No Urutan</label>
                                <input type="number" name="Urutan" id="editUrutan" class="form-control text-center">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Catatan / Sub-keterangan (Opsional)</label>
                                <input type="text" name="Catatan" id="editCatatan" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Satuan (Opsional)</label>
                                <input type="text" name="Satuan" id="editSatuan" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row my-2">
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="editIsSubPos" name="IsSubPos" value="1">
                                <label class="custom-control-label font-weight-normal" for="editIsSubPos">Sub-Pos (Indentasi Menjorok)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="editIsBold" name="IsBold" value="1">
                                <label class="custom-control-label font-weight-normal" for="editIsBold">Teks Tebal (Bold)</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="editIsHighlight" name="IsHighlight" value="1">
                                <label class="custom-control-label font-weight-normal" for="editIsHighlight">Highlight Hijau (Sorotan Utama)</label>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h6 class="font-weight-bold text-muted mb-2">Nilai Per Periode Tahun:</h6>
                    <div class="row" id="editNilaisContainer">
                        {{-- Populated dynamically via JavaScript --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning font-weight-bold"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================ --}}
{{-- MODAL TAMBAH TAHUN BARU --}}
{{-- ============================================ --}}
<div class="modal fade" id="modalTambahTahun" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.investor.ringkasan-kinerja.tambah-tahun') }}" method="POST">
                @csrf
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-calendar-plus mr-1"></i> Tambah Tahun Baru ke Sistem</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-light border text-sm mb-3">
                        <i class="fas fa-info-circle text-info mr-1"></i> <strong>Sistem Berkelanjutan:</strong> Menambahkan tahun baru akan secara otomatis menyiapkan slot nilai untuk seluruh 22 pos keuangan tanpa mengubah struktur database.
                    </div>

                    <div class="form-group">
                        <label>Tahun Baru <span class="text-danger">*</span></label>
                        @php
                            $maxExistingYear = !empty($allYears) ? max($allYears) : 2025;
                            $nextYear = $maxExistingYear + 1;
                        @endphp
                        <input type="number" name="Tahun" class="form-control font-weight-bold text-primary" min="2000" max="2100" value="{{ $nextYear }}" required>
                        <small class="text-muted">Tahun terakhir saat ini: <strong>{{ $maxExistingYear }}</strong></small>
                    </div>

                    <div class="custom-control custom-checkbox mt-2">
                        <input type="checkbox" class="custom-control-input" id="checkSetTerbaru" name="SetSebagaiTahunTerbaru" value="1" checked>
                        <label class="custom-control-label" for="checkSetTerbaru">
                            Jadikan tahun terbaru dan sesuaikan periode tampilan (misal {{ $nextYear - ($pengaturan->JumlahTahun ?: 5) + 1 }} - {{ $nextYear }})
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info font-weight-bold"><i class="fas fa-plus mr-1"></i> Tambahkan Tahun</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var activeYears = @json($activeYears);

        // Edit Row Modal
        $('.btn-edit-row').on('click', function() {
            var id = $(this).data('id');
            var kategori = $(this).data('kategori');
            var namaPos = $(this).data('namapos');
            var catatan = $(this).data('catatan') || '';
            var satuan = $(this).data('satuan') || 'Jutaan IDR';
            var isSubPos = $(this).data('issubpos') == 1;
            var isBold = $(this).data('isbold') == 1;
            var isHighlight = $(this).data('ishighlight') == 1;
            var urutan = $(this).data('urutan');
            var nilais = $(this).data('nilais') || {};

            var url = '{{ route('admin.investor.ringkasan-kinerja.update', ':id') }}'.replace(':id', id);
            $('#formEditPos').attr('action', url);

            $('#editKategori').val(kategori);
            $('#editNamaPos').val(namaPos);
            $('#editCatatan').val(catatan);
            $('#editSatuan').val(satuan);
            $('#editIsSubPos').prop('checked', isSubPos);
            $('#editIsBold').prop('checked', isBold);
            $('#editIsHighlight').prop('checked', isHighlight);
            $('#editUrutan').val(urutan);

            // Populate Nilai Inputs
            var container = $('#editNilaisContainer');
            container.empty();

            activeYears.forEach(function(yr, idx) {
                var val = nilais[yr] !== undefined ? nilais[yr] : '-';
                var isLast = (idx === activeYears.length - 1);
                var col = $(`
                    <div class="col">
                        <label class="text-xs ${isLast ? 'text-primary font-weight-bold' : ''}">${yr}</label>
                        <input type="text" name="nilais[${yr}]" class="form-control form-control-sm text-right ${isLast ? 'font-weight-bold text-primary' : ''}" value="${val}">
                    </div>
                `);
                container.append(col);
            });

            $('#modalEditPos').modal('show');
        });

        // Delete Row
        $('.btn-delete-row').on('click', function() {
            var id = $(this).data('id');
            var nama = $(this).data('nama');

            Swal.fire({
                title: 'Hapus Pos Keuangan?',
                html: 'Apakah Anda yakin ingin menghapus baris pos <strong>"' + nama + '"</strong> dari tabel ringkasan kinerja?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.investor.ringkasan-kinerja.destroy', ':id') }}'.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal!', xhr.responseJSON?.message || 'Terjadi kesalahan sistem', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

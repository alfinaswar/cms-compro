@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-chart-line mr-2"></i>Kelola Informasi Finansial</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('jenis-laporan.index') }}">Investor</a></li>
                    <li class="breadcrumb-item active">Informasi Finansial</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">

        <!-- Navigation Tabs inside Admin -->
        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="finansialTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" id="saham-tab" data-toggle="pill" href="#tab-saham" role="tab">
                            <i class="fas fa-coins mr-1"></i> Informasi Saham JTPE
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="struktur-tab" data-toggle="pill" href="#tab-struktur" role="tab">
                            <i class="fas fa-chart-pie mr-1"></i> Struktur Kepemilikan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="skema-tab" data-toggle="pill" href="#tab-skema" role="tab">
                            <i class="fas fa-sitemap mr-1"></i> Bagan Pengendali
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="entitas-tab" data-toggle="pill" href="#tab-entitas" role="tab">
                            <i class="fas fa-building mr-1"></i> Entitas Anak &amp; Asosiasi
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="finansialTabContent">

                    <!-- ============================================ -->
                    <!-- TAB 1: INFORMASI SAHAM JTPE -->
                    <!-- ============================================ -->
                    <div class="tab-pane fade show active" id="tab-saham" role="tabpanel">
                        <form action="{{ route('admin.investor.finansial.update-saham') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Kode Saham <span class="text-danger">*</span></label>
                                        <input type="text" name="KodeSaham" class="form-control" value="{{ old('KodeSaham', $saham->KodeSaham ?? 'JTPE') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Harga Terakhir (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" step="any" name="HargaTerakhir" class="form-control" value="{{ old('HargaTerakhir', $saham->HargaTerakhir ?? 595) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Perubahan (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" step="any" name="Perubahan" class="form-control" value="{{ old('Perubahan', $saham->Perubahan ?? 16) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Persentase Perubahan (%) <span class="text-danger">*</span></label>
                                        <input type="number" step="any" name="PersentasePerubahan" class="form-control" value="{{ old('PersentasePerubahan', $saham->PersentasePerubahan ?? 2.77) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status Pasar <span class="text-danger">*</span></label>
                                        <input type="text" name="StatusPasar" class="form-control" value="{{ old('StatusPasar', $saham->StatusPasar ?? 'Pasar Tutup - 28 Mar 2024') }}" required placeholder="Contoh: Pasar Tutup - 28 Mar 2024">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Pembukaan (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" step="any" name="Pembukaan" class="form-control" value="{{ old('Pembukaan', $saham->Pembukaan ?? 580) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Penutupan Kemarin (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" step="any" name="PenutupanKemarin" class="form-control" value="{{ old('PenutupanKemarin', $saham->PenutupanKemarin ?? 585) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tertinggi Hari Ini (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" step="any" name="TertinggiHariIni" class="form-control" value="{{ old('TertinggiHariIni', $saham->TertinggiHariIni ?? 605) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Terendah Hari Ini (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" step="any" name="TerendahHariIni" class="form-control" value="{{ old('TerendahHariIni', $saham->TerendahHariIni ?? 585) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>52 Mgg Tertinggi (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" step="any" name="Tertinggi52Mgg" class="form-control" value="{{ old('Tertinggi52Mgg', $saham->Tertinggi52Mgg ?? 690) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>52 Mgg Terendah (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" step="any" name="Terendah52Mgg" class="form-control" value="{{ old('Terendah52Mgg', $saham->Terendah52Mgg ?? 490) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Volume Saham (Lembar) <span class="text-danger">*</span></label>
                                        <input type="number" name="VolumeSaham" class="form-control" value="{{ old('VolumeSaham', $saham->VolumeSaham ?? 14831013) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nilai Transaksi <span class="text-danger">*</span></label>
                                        <input type="text" name="NilaiTransaksi" class="form-control" value="{{ old('NilaiTransaksi', $saham->NilaiTransaksi ?? 'Rp 8,82 Miliar') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Kapitalisasi Pasar <span class="text-danger">*</span></label>
                                        <input type="text" name="KapitalisasiPasar" class="form-control" value="{{ old('KapitalisasiPasar', $saham->KapitalisasiPasar ?? 'Rp 4,08 Triliun') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right mt-3">
                                <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                                    <i class="fas fa-save mr-1"></i> Simpan Informasi Saham
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- ============================================ -->
                    <!-- TAB 2: STRUKTUR KEPEMILIKAN SAHAM -->
                    <!-- ============================================ -->
                    <div class="tab-pane fade" id="tab-struktur" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="font-weight-bold text-secondary mb-0">Tabel Komposisi Pemegang Saham</h5>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambahStruktur">
                                <i class="fas fa-plus mr-1"></i> Tambah Baris Kepemilikan
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th>Tipe Pemodal</th>
                                        <th>Kategori Pemegang</th>
                                        <th class="text-right">Jumlah Saham</th>
                                        <th class="text-right">%</th>
                                        <th>Periode</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($strukturList as $idx => $item)
                                        <tr>
                                            <td class="text-center">{{ $idx + 1 }}</td>
                                            <td>
                                                <span class="badge {{ $item->TipePemodal === 'Pemodal Nasional' ? 'badge-primary' : 'badge-info' }}">
                                                    {{ $item->TipePemodal }}
                                                </span>
                                            </td>
                                            <td class="font-weight-bold">{{ $item->KategoriPemegang }}</td>
                                            <td class="text-right">{{ number_format($item->JumlahSaham, 0, ',', '.') }}</td>
                                            <td class="text-right font-weight-bold">{{ number_format($item->Persentase, 2, ',', '.') }}%</td>
                                            <td>{{ $item->PeriodeBulan }} {{ $item->PeriodeTahun }}</td>
                                            <td class="text-center">
                                                <span class="badge {{ $item->Status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $item->Status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-xs btn-warning mr-1 btn-edit-struktur"
                                                        data-id="{{ $item->id }}"
                                                        data-tipe="{{ $item->TipePemodal }}"
                                                        data-kategori="{{ $item->KategoriPemegang }}"
                                                        data-saham="{{ $item->JumlahSaham }}"
                                                        data-persen="{{ $item->Persentase }}"
                                                        data-bulan="{{ $item->PeriodeBulan }}"
                                                        data-tahun="{{ $item->PeriodeTahun }}"
                                                        data-urutan="{{ $item->Urutan }}"
                                                        data-status="{{ $item->Status }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-danger btn-delete-row"
                                                        data-url="{{ route('admin.investor.finansial.destroy-struktur', $item->id) }}"
                                                        data-nama="{{ $item->KategoriPemegang }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-3">Belum ada data struktur kepemilikan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ============================================ -->
                    <!-- TAB 3: BAGAN KEPEMILIKAN SAHAM PENGENDALI -->
                    <!-- ============================================ -->
                    <div class="tab-pane fade" id="tab-skema" role="tabpanel">
                        <form action="{{ route('admin.investor.finansial.update-skema') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Judul Bagan <span class="text-danger">*</span></label>
                                        <input type="text" name="Judul" class="form-control" value="{{ old('Judul', $skema->Judul ?? 'Bagan Struktur Kepemilikan Saham & Pemegang Saham Utama Pengendali') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Keterangan / Catatan Kaki</label>
                                        <textarea name="Keterangan" rows="3" class="form-control">{{ old('Keterangan', $skema->Keterangan) }}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Upload Gambar Bagan (Opsional)</label>
                                                <input type="file" name="GambarBagan" class="form-control-file">
                                                <small class="text-muted">Format: JPG, PNG, WEBP, SVG (Maks. 5MB). Jika dikosongkan, diagram standar akan ditampilkan.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Upload Dokumen PDF Skema (Opsional)</label>
                                                <input type="file" name="FileSkemaPdf" class="form-control-file">
                                                <small class="text-muted">Untuk tombol "Unduh Skema Kepemilikan (PDF)".</small>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary px-4 mt-2">
                                        <i class="fas fa-save mr-1"></i> Simpan Bagan Pengendali
                                    </button>
                                </div>

                                <div class="col-md-4">
                                    <div class="card card-light">
                                        <div class="card-header"><h3 class="card-title text-sm font-weight-bold">Preview Bagan Aktif</h3></div>
                                        <div class="card-body text-center p-3">
                                            @if($skema->PathGambar)
                                                <img src="{{ asset('storage/' . $skema->PathGambar) }}" class="img-fluid rounded border mb-2" alt="Bagan Skema">
                                                <p class="text-xs text-success mb-0"><i class="fas fa-check-circle"></i> Menggunakan gambar kustom dari admin</p>
                                            @else
                                                <div class="p-4 bg-light border rounded text-muted text-xs">
                                                    <i class="fas fa-image fa-3x mb-2 text-secondary"></i>
                                                    <p class="mb-0">Belum ada gambar kustom diunggah. Tampilan diagram interaktif default sedang aktif.</p>
                                                </div>
                                            @endif

                                            @if($skema->PathFilePdf)
                                                <div class="mt-2 text-left">
                                                    <a href="{{ asset('storage/' . $skema->PathFilePdf) }}" target="_blank" class="btn btn-xs btn-outline-danger">
                                                        <i class="fas fa-file-pdf"></i> Lihat PDF Tersimpan
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- ============================================ -->
                    <!-- TAB 4: ENTITAS ANAK & PERUSAHAAN ASOSIASI -->
                    <!-- ============================================ -->
                    <div class="tab-pane fade" id="tab-entitas" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="font-weight-bold text-secondary mb-0">Daftar Entitas Anak &amp; Perusahaan Asosiasi</h5>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambahEntitas">
                                <i class="fas fa-plus mr-1"></i> Tambah Entitas
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th>Nama Entitas</th>
                                        <th>Tipe</th>
                                        <th>Lokasi</th>
                                        <th class="text-right">Kepemilikan (%)</th>
                                        <th>Tahun</th>
                                        <th>Bidang Usaha</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($entitasList as $idx => $anak)
                                        <tr>
                                            <td class="text-center">{{ $idx + 1 }}</td>
                                            <td class="font-weight-bold">{{ $anak->NamaEntitas }}</td>
                                            <td>
                                                <span class="badge {{ $anak->Tipe === 'Entitas Anak' ? 'badge-primary' : 'badge-warning' }}">
                                                    {{ $anak->Tipe }}
                                                </span>
                                            </td>
                                            <td>{{ $anak->Lokasi ?? '-' }}</td>
                                            <td class="text-right font-weight-bold text-primary">{{ number_format($anak->PersentaseKepemilikan, 2, ',', '.') }}%</td>
                                            <td>{{ $anak->TahunBergabung ?? '-' }}</td>
                                            <td class="small">{{ Str::limit($anak->BidangUsaha, 70) }}</td>
                                            <td class="text-center">
                                                <span class="badge {{ $anak->Status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $anak->Status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-xs btn-warning mr-1 btn-edit-entitas"
                                                        data-id="{{ $anak->id }}"
                                                        data-nama="{{ $anak->NamaEntitas }}"
                                                        data-lokasi="{{ $anak->Lokasi }}"
                                                        data-tipe="{{ $anak->Tipe }}"
                                                        data-persen="{{ $anak->PersentaseKepemilikan }}"
                                                        data-tahun="{{ $anak->TahunBergabung }}"
                                                        data-bidang="{{ $anak->BidangUsaha }}"
                                                        data-url="{{ $anak->UrlWebsite }}"
                                                        data-urutan="{{ $anak->Urutan }}"
                                                        data-status="{{ $anak->Status }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-danger btn-delete-row"
                                                        data-url="{{ route('admin.investor.finansial.destroy-entitas', $anak->id) }}"
                                                        data-nama="{{ $anak->NamaEntitas }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted py-3">Belum ada data entitas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

<!-- MODAL TAMBAH STRUKTUR -->
<div class="modal fade" id="modalTambahStruktur" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.investor.finansial.store-struktur') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">Tambah Baris Kepemilikan Saham</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tipe Pemodal <span class="text-danger">*</span></label>
                        <select name="TipePemodal" class="form-control" required>
                            <option value="Pemodal Nasional">Pemodal Nasional</option>
                            <option value="Pemodal Asing">Pemodal Asing</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kategori Pemegang Saham <span class="text-danger">*</span></label>
                        <input type="text" name="KategoriPemegang" class="form-control" required placeholder="Contoh: Perorangan Indonesia / Badan Usaha Asing">
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Jumlah Saham <span class="text-danger">*</span></label>
                                <input type="number" name="JumlahSaham" class="form-control" required value="0">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Persentase (%) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="Persentase" class="form-control" required value="0.00">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Periode Bulan <span class="text-danger">*</span></label>
                                <input type="text" name="PeriodeBulan" class="form-control" value="Maret" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Periode Tahun <span class="text-danger">*</span></label>
                                <input type="text" name="PeriodeTahun" class="form-control" value="2024" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Urutan Tampil</label>
                                <input type="number" name="Urutan" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="Status" class="form-control">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH ENTITAS -->
<div class="modal fade" id="modalTambahEntitas" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.investor.finansial.store-entitas') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">Tambah Entitas Anak / Asosiasi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Nama Entitas <span class="text-danger">*</span></label>
                                <input type="text" name="NamaEntitas" class="form-control" required placeholder="Contoh: PT Jasuindo Informatika Pratama">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipe Entitas <span class="text-danger">*</span></label>
                                <select name="Tipe" class="form-control" required>
                                    <option value="Entitas Anak">Entitas Anak</option>
                                    <option value="Perusahaan Asosiasi">Perusahaan Asosiasi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kepemilikan Saham (%) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="PersentaseKepemilikan" class="form-control" required placeholder="Contoh: 99.98">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tahun Bergabung</label>
                                <input type="text" name="TahunBergabung" class="form-control" placeholder="Contoh: Est. 2012">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Lokasi / Kota</label>
                                <input type="text" name="Lokasi" class="form-control" placeholder="Contoh: Sidoarjo, Jawa Timur">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Bidang Usaha &amp; Fokus Operasional</label>
                        <textarea name="BidangUsaha" rows="3" class="form-control" placeholder="Jelaskan lini bisnis atau solusi yang diproduksi..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>URL Website (Opsional)</label>
                                <input type="url" name="UrlWebsite" class="form-control" placeholder="https://...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="number" name="Urutan" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="Status" class="form-control">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT STRUKTUR -->
<div class="modal fade" id="modalEditStruktur" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formEditStruktur" action="" method="POST">
                @csrf
                <div class="modal-header bg-warning">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Kepemilikan Saham</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tipe Pemodal <span class="text-danger">*</span></label>
                        <select name="TipePemodal" id="editTipePemodal" class="form-control" required>
                            <option value="Pemodal Nasional">Pemodal Nasional</option>
                            <option value="Pemodal Asing">Pemodal Asing</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kategori Pemegang Saham <span class="text-danger">*</span></label>
                        <input type="text" name="KategoriPemegang" id="editKategoriPemegang" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Jumlah Saham <span class="text-danger">*</span></label>
                                <input type="number" name="JumlahSaham" id="editJumlahSaham" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Persentase (%) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="Persentase" id="editPersentase" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Periode Bulan <span class="text-danger">*</span></label>
                                <input type="text" name="PeriodeBulan" id="editPeriodeBulan" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Periode Tahun <span class="text-danger">*</span></label>
                                <input type="text" name="PeriodeTahun" id="editPeriodeTahun" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Urutan Tampil</label>
                                <input type="number" name="Urutan" id="editUrutanStruktur" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="Status" id="editStatusStruktur" class="form-control">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
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

<!-- MODAL EDIT ENTITAS -->
<div class="modal fade" id="modalEditEntitas" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formEditEntitas" action="" method="POST">
                @csrf
                <div class="modal-header bg-warning">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Entitas Anak / Asosiasi</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Nama Entitas <span class="text-danger">*</span></label>
                                <input type="text" name="NamaEntitas" id="editNamaEntitas" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipe Entitas <span class="text-danger">*</span></label>
                                <select name="Tipe" id="editTipeEntitas" class="form-control" required>
                                    <option value="Entitas Anak">Entitas Anak</option>
                                    <option value="Perusahaan Asosiasi">Perusahaan Asosiasi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kepemilikan Saham (%) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="PersentaseKepemilikan" id="editPersentaseKepemilikan" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tahun Bergabung</label>
                                <input type="text" name="TahunBergabung" id="editTahunBergabung" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Lokasi / Kota</label>
                                <input type="text" name="Lokasi" id="editLokasi" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Bidang Usaha &amp; Fokus Operasional</label>
                        <textarea name="BidangUsaha" id="editBidangUsaha" rows="3" class="form-control"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>URL Website (Opsional)</label>
                                <input type="url" name="UrlWebsite" id="editUrlWebsite" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="number" name="Urutan" id="editUrutanEntitas" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="Status" id="editStatusEntitas" class="form-control">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
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

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Edit Struktur
        $('.btn-edit-struktur').on('click', function () {
            const id = $(this).data('id');
            const url = '{{ route('admin.investor.finansial.update-struktur', ':id') }}'.replace(':id', id);
            $('#formEditStruktur').attr('action', url);
            $('#editTipePemodal').val($(this).data('tipe'));
            $('#editKategoriPemegang').val($(this).data('kategori'));
            $('#editJumlahSaham').val($(this).data('saham'));
            $('#editPersentase').val($(this).data('persen'));
            $('#editPeriodeBulan').val($(this).data('bulan'));
            $('#editPeriodeTahun').val($(this).data('tahun'));
            $('#editUrutanStruktur').val($(this).data('urutan'));
            $('#editStatusStruktur').val($(this).data('status'));
            $('#modalEditStruktur').modal('show');
        });

        // Edit Entitas
        $('.btn-edit-entitas').on('click', function () {
            const id = $(this).data('id');
            const url = '{{ route('admin.investor.finansial.update-entitas', ':id') }}'.replace(':id', id);
            $('#formEditEntitas').attr('action', url);
            $('#editNamaEntitas').val($(this).data('nama'));
            $('#editTipeEntitas').val($(this).data('tipe'));
            $('#editPersentaseKepemilikan').val($(this).data('persen'));
            $('#editTahunBergabung').val($(this).data('tahun'));
            $('#editLokasi').val($(this).data('lokasi'));
            $('#editBidangUsaha').val($(this).data('bidang'));
            $('#editUrlWebsite').val($(this).data('url'));
            $('#editUrutanEntitas').val($(this).data('urutan'));
            $('#editStatusEntitas').val($(this).data('status'));
            $('#modalEditEntitas').modal('show');
        });

        // Delete button confirmation
        $('.btn-delete-row').on('click', function () {
            const url = $(this).data('url');
            const nama = $(this).data('nama');

            Swal.fire({
                title: 'Hapus Data?',
                text: `Apakah Anda yakin ingin menghapus data "${nama}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (res) {
                            Swal.fire('Terhapus!', res.message, 'success').then(() => location.reload());
                        },
                        error: function () {
                            Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

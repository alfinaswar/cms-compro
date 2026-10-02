@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Detail Laporan WBS: {{ $laporan->NomorTiket }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.investor.tata-kelola.wbs-index') }}">Laporan WBS</a></li>
                    <li class="breadcrumb-item active">{{ $laporan->NomorTiket }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">
                            <i class="fas fa-file-alt mr-1"></i> Informasi Lengkap Pengaduan
                        </h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 30%" class="bg-light">Nomor Tiket</th>
                                <td class="font-weight-bold text-primary">{{ $laporan->NomorTiket }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Waktu Pengiriman</th>
                                <td>{{ $laporan->created_at->format('d F Y, H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Kategori Pelanggaran</th>
                                <td class="font-weight-bold text-danger">{{ $laporan->KategoriPelanggaran }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Pihak yang Dilaporkan</th>
                                <td>{{ $laporan->Terlapor ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Waktu &amp; Lokasi Kejadian</th>
                                <td>
                                    {{ $laporan->WaktuKejadian ? $laporan->WaktuKejadian->format('d F Y') : '-' }} &bull; {{ $laporan->LokasiKejadian ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Uraian / Kronologi</th>
                                <td class="text-justify leading-relaxed whitespace-pre-line">{{ $laporan->UraianKejadian }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">File Bukti Lampiran</th>
                                <td>
                                    @if($laporan->PathBukti)
                                        <a href="{{ asset('storage/' . $laporan->PathBukti) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-download mr-1"></i> Unduh Lampiran Bukti
                                        </a>
                                    @else
                                        <span class="text-muted italic">Tidak ada lampiran berkas bukti.</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Data Pelapor</th>
                                <td>
                                    <strong>Nama:</strong> {{ $laporan->NamaPelapor ?: 'Anonim (Dirahasiakan)' }}<br>
                                    <strong>Email:</strong> {{ $laporan->EmailPelapor ?: '-' }}<br>
                                    <strong>Telepon:</strong> {{ $laporan->TeleponPelapor ?: '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold"><i class="fas fa-tasks mr-1"></i> Tindak Lanjut &amp; Status</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.investor.tata-kelola.wbs-update-status', $laporan->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Status Penanganan <span class="text-danger">*</span></label>
                                <select name="StatusLaporan" class="form-control font-weight-bold" required>
                                    <option value="Menunggu Review" {{ $laporan->StatusLaporan === 'Menunggu Review' ? 'selected' : '' }}>Menunggu Review</option>
                                    <option value="Sedang Diproses" {{ $laporan->StatusLaporan === 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                                    <option value="Selesai" {{ $laporan->StatusLaporan === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="Ditolak" {{ $laporan->StatusLaporan === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Catatan Investigasi / Tindak Lanjut</label>
                                <textarea name="CatatanTindakLanjut" rows="4" class="form-control" placeholder="Catatan internal tim komite audit...">{{ old('CatatanTindakLanjut', $laporan->CatatanTindakLanjut) }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-warning btn-block font-weight-bold">
                                <i class="fas fa-save mr-1"></i> Perbarui Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

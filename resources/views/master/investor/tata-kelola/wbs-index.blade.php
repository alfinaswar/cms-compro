@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-bullhorn text-danger mr-2"></i>Laporan Whistleblowing System (WBS)</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.investor.tata-kelola.index') }}">Tata Kelola</a></li>
                    <li class="breadcrumb-item active">Laporan WBS</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-danger">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-shield-alt mr-1"></i> Daftar Pengaduan Pelanggaran Masuk
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.investor.tata-kelola.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Tata Kelola
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>No. Tiket</th>
                                <th>Tanggal Lapor</th>
                                <th>Kategori Pelanggaran</th>
                                <th>Pihak Terlapor</th>
                                <th>Pelapor</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporanList as $idx => $lap)
                                @php
                                    $badge = 'badge-warning';
                                    if ($lap->StatusLaporan === 'Sedang Diproses') $badge = 'badge-info';
                                    elseif ($lap->StatusLaporan === 'Selesai') $badge = 'badge-success';
                                    elseif ($lap->StatusLaporan === 'Ditolak') $badge = 'badge-danger';
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $idx + 1 }}</td>
                                    <td class="font-weight-bold text-primary">{{ $lap->NomorTiket }}</td>
                                    <td>{{ $lap->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $lap->KategoriPelanggaran }}</td>
                                    <td>{{ $lap->Terlapor ?? '-' }}</td>
                                    <td>{{ $lap->NamaPelapor ?: 'Anonim' }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $badge }} px-2 py-1">{{ $lap->StatusLaporan }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.investor.tata-kelola.wbs-show', $lap->id) }}" class="btn btn-xs btn-primary font-weight-bold">
                                            <i class="fas fa-eye mr-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">Belum ada pengaduan pelanggaran WBS yang masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

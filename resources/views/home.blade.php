@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <!-- ==================== INFO BOXES (STATISTIK) ==================== -->
    <div class="row">
        <!-- Artikel / Berita -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info shadow-sm">
                <div class="inner">
                    <h3>{{ $countArtikel }}</h3>
                    <h5>Artikel Diterbitkan</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <a href="{{ route('berita.index') }}" class="small-box-footer">
                    Kelola Berita <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Lowongan Kerja -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success shadow-sm">
                <div class="inner">
                    <h3>{{ $countLowongan }}</h3>
                    <h5>Lowongan Aktif</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <a href="{{ route('karir.index') }}" class="small-box-footer">
                    Kelola Lowongan <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Pesan Masuk -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning shadow-sm">
                <div class="inner">
                    <h3>{{ $countPesan }}</h3>
                    <h5>Pesan Contact Us</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <a href="{{ route('contact.list') }}" class="small-box-footer">
                    Lihat Pesan <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Struktur Organisasi -->
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger shadow-sm">
                <div class="inner">
                    <h3>{{ $countAnggota }}</h3>
                    <h5>Anggota Tim</h5>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('struktur-organisasi.index') }}" class="small-box-footer">
                    Kelola Struktur <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- ==================== KOLOM KIRI: AKTIVITAS TERBARU ==================== -->
        <div class="col-lg-8">
            <!-- Artikel Terbaru -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header border-0 bg-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-clock text-primary mr-2"></i>Artikel Terbaru
                    </h3>
                    <div style="margin-left: auto;">
                        <a href="{{ route('berita.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Tulis Baru
                        </a>
                    </div>

                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th style="width: 60px">Gambar</th>
                                    <th>Judul Artikel</th>
                                    <th>Tanggal</th>
                                    <th style="width: 40px"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($artikelTerbaru as $item)
                                <tr>
                                    <td>
                                        @if($item->PathThumbnail)
                                            <img src="{{ Storage::url($item->PathThumbnail) }}" alt="Thumb" class="img-circle img-size-32 mr-2">
                                        @else
                                            <span class="badge badge-secondary">No Img</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ Str::limit($item->Judul, 50) }}
                                    </td>
                                    <td>
                                        {{ $item->TanggalPublikasi ? $item->TanggalPublikasi->format('d M Y') : '-' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('berita.edit', $item->id) }}" class="text-muted hover:text-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Belum ada artikel diterbitkan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pesan Masuk Terbaru -->
            <div class="card shadow-sm border-0">
                <div class="card-header border-0 bg-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-inbox text-warning mr-2"></i>Pesan Masuk Terbaru
                    </h3>
                    <div class="ml-auto">
                        <a href="{{ route('contact.list') }}" class="btn btn-sm btn-warning text-white">
                            Lihat Semua
                        </a>
                    </div>

                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse ($pesanTerbaru as $pesan)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px; font-weight: bold;">
                                    {{ substr($pesan->NamaLengkap ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <span class="font-weight-bold d-block">{{ $pesan->NamaLengkap }}</span>
                                    <small class="text-muted">{{ $pesan->Email }}</small>
                                </div>
                            </div>
                            <small class="text-muted">{{ $pesan->created_at->diffForHumans() }}</small>
                        </li>
                        @empty
                        <li class="list-group-item text-center text-muted">Tidak ada pesan baru.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- ==================== KOLOM KANAN: AKSES CEPAT & INFO ==================== -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white">
                    <h3 class="card-title"><i class="fas fa-bolt text-yellow mr-2"></i>Akses Cepat</h3>
                </div>
                <div class="card-body pt-0">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <a href="{{ route('berita.create') }}" class="btn btn-app bg-primary text-white">
                                <i class="fas fa-pen"></i> Berita
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="{{ route('karir.create') }}" class="btn btn-app bg-success text-white">
                                <i class="fas fa-briefcase"></i> Lowongan
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="{{ route('struktur-organisasi.create') }}" class="btn btn-app bg-danger text-white">
                                <i class="fas fa-sitemap"></i> Struktur
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="{{ route('pengaturan-website.edit') }}" class="btn btn-app bg-info text-white">
                                <i class="fas fa-cog"></i> Setting
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Server Info / System Status -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h3 class="card-title"><i class="fas fa-server text-secondary mr-2"></i>Status Sistem</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>PHP Version</span>
                        <strong>{{ phpversion() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Laravel Version</span>
                        <strong>{{ app()->version() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Environment</span>
                        <strong>{{ config('app.env') }}</strong>
                    </div>
                    <hr>
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-circle text-success mr-1"></i> System Operational
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Custom SmallBox Style */
    .small-box {
        border-radius: 0.25rem;
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        display: block;
        margin-bottom: 20px;
        position: relative;
    }
    .small-box > .inner {
        padding: 10px;
    }
    .small-box > .small-box-footer {
        background: rgba(0,0,0,0.1);
        color: rgba(255,255,255,0.8);
        display: block;
        padding: 3px 0;
        position: relative;
        text-align: center;
        text-decoration: none;
        font-weight: 400;
    }
    .small-box > .small-box-footer:hover {
        background: rgba(0,0,0,0.15);
        color: #fff;
    }
    .small-box h3 {
        font-size: 2.2rem;
        font-weight: bold;
        margin: 0 0 10px 0;
        padding: 0;
        white-space: nowrap;
    }
    .small-box p {
        font-size: 1rem;
    }
    .small-box .icon {
        color: rgba(0,0,0,0.15);
        z-index: 0;
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 70px;
        transition: all .3s linear;
    }

    /* Custom Button App */
    .btn-app {
        border-radius: 3px;
        position: relative;
        display: inline-block;
        width: 100%;
        padding: 15px 10px;
        margin: 0;
        font-size: 14px;
        color: #666;
        border: 1px solid #ddd;
        text-align: center;
        transition: all 0.2s;
    }
    .btn-app > .fa, .btn-app > .fas {
        font-size: 20px;
        display: block;
        margin-bottom: 5px;
    }
    .btn-app:hover {
        background: #f4f4f4;
        color: #444;
        border-color: #aaa;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Image Size */
    .img-size-32 {
        width: 32px;
        height: 32px;
        object-fit: cover;
    }
</style>
@endpush

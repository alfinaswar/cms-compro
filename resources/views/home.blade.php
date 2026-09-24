@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            :root {
                --card-border-radius: 8px;
                --subtle-bg: #f8fafc;
                --text-muted-custom: #64748b;
            }

            /* Custom Header Extension for AdminLTE Page Title */
            .content-header-custom {
                background: #ffffff;
                border-bottom: 1px solid #e2e8f0;
                padding: 18px 24px;
                margin-bottom: 20px;
                border-radius: var(--card-border-radius);
            }

            /* Clean Metric Stat Cards (Modernized AdminLTE Small Box alternative) */
            .metric-card {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: var(--card-border-radius);
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                height: 100%;
                transition: border-color 0.2s ease, box-shadow 0.2s ease;
            }

            .metric-card:hover {
                border-color: #cbd5e1;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            }

            .metric-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 12px;
            }

            .metric-icon-box {
                width: 42px;
                height: 42px;
                border-radius: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 18px;
            }

            .metric-icon-blue {
                background: #eff6ff;
                color: #2563eb;
            }

            .metric-icon-green {
                background: #f0fdf4;
                color: #16a34a;
            }

            .metric-icon-orange {
                background: #fff7ed;
                color: #ea580c;
            }

            .metric-icon-purple {
                background: #faf5ff;
                color: #9333ea;
            }

            .metric-value {
                font-size: 28px;
                font-weight: 700;
                color: #0f172a;
                line-height: 1.2;
            }

            .metric-title {
                font-size: 13px;
                font-weight: 500;
                color: var(--text-muted-custom);
                margin-top: 2px;
            }

            .metric-footer {
                margin-top: 16px;
                padding-top: 12px;
                border-top: 1px solid #f1f5f9;
                display: flex;
                align-items: center;
                justify-content: space-between;
                font-size: 12px;
            }

            .metric-footer a {
                color: #2563eb;
                font-weight: 600;
                text-decoration: none;
            }

            .metric-footer a:hover {
                text-decoration: underline;
            }

            /* Refined AdminLTE Custom Cards */
            .card-modern {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: var(--card-border-radius);
                box-shadow: none;
                margin-bottom: 24px;
            }

            .card-modern .card-header {
                background: transparent;
                border-bottom: 1px solid #f1f5f9;
                padding: 16px 20px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .card-modern .card-title {
                font-size: 15px;
                font-weight: 600;
                color: #0f172a;
                margin: 0;
            }

            /* Activity Log List */
            .activity-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .activity-item {
                display: flex;
                gap: 12px;
                padding: 12px 0;
                border-bottom: 1px solid #f1f5f9;
            }

            .activity-item:last-child {
                border-bottom: none;
            }

            .activity-badge {
                width: 8px;
                height: 8px;
                border-radius: 50%;
                margin-top: 6px;
                flex-shrink: 0;
            }

            .badge-blue {
                background-color: #2563eb;
            }

            .badge-cyan {
                background-color: #0891b2;
            }

            .badge-red {
                background-color: #dc2626;
            }

            /* Action Grid Shortcut Buttons */
            .shortcut-grid {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .shortcut-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 16px;
                background: var(--subtle-bg);
                border: 1px solid #e2e8f0;
                border-radius: 6px;
                text-decoration: none;
                color: #334155;
                transition: background-color 0.2s, border-color 0.2s;
            }

            .shortcut-item:hover {
                background: #ffffff;
                border-color: #cbd5e1;
                color: #2563eb;
                text-decoration: none;
            }

            .shortcut-item i {
                font-size: 20px;
                margin-bottom: 8px;
            }

            .shortcut-title {
                font-size: 13px;
                font-weight: 600;
            }

            .shortcut-desc {
                font-size: 11px;
                color: var(--text-muted-custom);
            }
        </style>
    @endpush

    {{-- Content Header --}}
    <div class="content-header-custom d-flex justify-content-between align-items-center">
        <div>
            <span class="text-uppercase text-muted font-weight-bold" style="font-size: 11px; letter-spacing: 0.5px;">Ringkasan
                Operasional • PT Jasuindo Tiga Perkasa Tbk</span>
            <h1 class="h3 font-weight-bold text-dark mb-0 mt-1">Dashboard Portal</h1>
        </div>
        <div>
            <span class="badge badge-light border px-3 py-2 text-muted" style="font-size: 12px;">
                <i class="far fa-calendar-alt mr-1"></i> {{ date('d M Y') }}
            </span>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            {{-- METRIC CARDS --}}
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
                    <div class="metric-card">
                        <div>
                            <div class="metric-header">
                                <div class="metric-icon-box metric-icon-blue">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                                @if ($countArtikel > 0)
                                    <span class="badge badge-primary font-weight-normal px-2 py-1">{{ $countArtikel }}
                                        Aktif</span>
                                @endif
                            </div>
                            <div class="metric-value">{{ $countArtikel }}</div>
                            <div class="metric-title">Artikel Diterbitkan</div>
                        </div>
                        <div class="metric-footer">
                            <span class="text-muted">1 draf di editor</span>
                            <a href="{{ route('berita.index') }}">Kelola Berita <i class="fas fa-chevron-right ml-1"
                                    style="font-size: 10px;"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
                    <div class="metric-card">
                        <div>
                            <div class="metric-header">
                                <div class="metric-icon-box metric-icon-green">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                            </div>
                            <div class="metric-value">{{ $countLowongan }}</div>
                            <div class="metric-title">Lowongan Aktif</div>
                        </div>
                        <div class="metric-footer">
                            <span class="text-muted">14 pelamar menanti</span>
                            <a href="{{ route('karir.index') }}">Kelola Karir <i class="fas fa-chevron-right ml-1"
                                    style="font-size: 10px;"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
                    <div class="metric-card">
                        <div>
                            <div class="metric-header">
                                <div class="metric-icon-box metric-icon-orange">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                @if ($countPesan > 0)
                                    <span class="badge badge-warning font-weight-normal px-2 py-1">{{ $countPesan }}
                                        Baru</span>
                                @endif
                            </div>
                            <div class="metric-value">{{ $countPesan }}</div>
                            <div class="metric-title">Pesan Contact Us</div>
                        </div>
                        <div class="metric-footer">
                            <span class="text-muted">RFQ & kemitraan</span>
                            <a href="{{ route('contact.list') }}">Lihat Pesan <i class="fas fa-chevron-right ml-1"
                                    style="font-size: 10px;"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
                    <div class="metric-card">
                        <div>
                            <div class="metric-header">
                                <div class="metric-icon-box metric-icon-purple">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="metric-value">{{ $countAnggota }}</div>
                            <div class="metric-title">Anggota Tim & Akun</div>
                        </div>
                        <div class="metric-footer">
                            <span class="text-muted">1 wajib reset sandi</span>
                            <a href="{{ route('struktur-organisasi.index') }}">Kelola Akun <i
                                    class="fas fa-chevron-right ml-1" style="font-size: 10px;"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- MAIN CONTENT AREA --}}
                <div class="col-lg-8">

                    {{-- PESAN MASUK TERBARU --}}
                    <div class="card card-modern">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-inbox text-muted mr-2"></i>Pesan Masuk Terbaru
                            </h3>
                            <a href="{{ route('contact.list') }}" class="btn btn-sm btn-outline-secondary ml-auto"
                                style="margin-left:auto;display:block;">Lihat Semua</a>

                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <tbody>
                                        @forelse ($pesanTerbaru as $pesan)
                                            <tr>
                                                <td style="width: 50px;" class="text-center pl-3">
                                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-secondary font-weight-bold"
                                                        style="width: 36px; height: 36px; font-size: 13px;">
                                                        {{ strtoupper(substr($pesan->NamaLengkap ?? 'A', 0, 2)) }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="font-weight-bold text-dark" style="font-size: 14px;">
                                                        {{ $pesan->NamaLengkap }}</div>
                                                    <div class="text-muted text-truncate"
                                                        style="font-size: 12px; max-width: 380px;">
                                                        {{ Str::limit($pesan->Pesan ?? 'Tidak ada pesan', 70) }}
                                                    </div>
                                                </td>
                                                <td class="text-right text-muted pr-3"
                                                    style="font-size: 12px; width: 120px;">
                                                    {{ $pesan->created_at->diffForHumans() }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-4 text-muted">
                                                    <p class="mb-0">Belum ada pesan baru</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- ARTIKEL TERBARU --}}
                    <div class="card card-modern">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-newspaper text-muted mr-2"></i>Artikel Terbaru
                            </h3>
                            <div style="margin-left: auto;">
                                <a href="{{ route('berita.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-plus mr-1"></i> Tulis Artikel
                                </a>
                            </div>

                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light"
                                        style="font-size: 11px; text-transform: uppercase; color: #64748b;">
                                        <tr>
                                            <th style="width: 60px;" class="border-0">Gambar</th>
                                            <th class="border-0">Judul Artikel</th>
                                            <th style="width: 130px;" class="border-0">Tanggal</th>
                                            <th style="width: 50px;" class="border-0"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($artikelTerbaru as $item)
                                            <tr>
                                                <td class="align-middle">
                                                    @if ($item->PathThumbnail)
                                                        <img src="{{ Storage::url($item->PathThumbnail) }}"
                                                            alt="Thumb" class="rounded"
                                                            style="width: 38px; height: 38px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted"
                                                            style="width: 38px; height: 38px;">
                                                            <i class="fas fa-image" style="font-size: 12px;"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <a href="{{ route('berita.edit', $item->id) }}"
                                                        class="text-dark font-weight-bold" style="font-size: 13px;">
                                                        {{ Str::limit($item->Judul, 55) }}
                                                    </a>
                                                </td>
                                                <td class="align-middle text-muted" style="font-size: 12px;">
                                                    {{ $item->TanggalPublikasi ? $item->TanggalPublikasi->format('d M Y') : '-' }}
                                                </td>
                                                <td class="align-middle text-right pr-3">
                                                    <a href="{{ route('berita.edit', $item->id) }}"
                                                        class="text-muted hover-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-4 text-muted">
                                                    <p class="mb-0">Belum ada artikel yang diterbitkan</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- SIDEBAR AREA --}}
                <div class="col-lg-4">

                    {{-- SHORTCUTS --}}
                    <div class="card card-modern">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-bolt text-muted mr-2"></i>Akses Cepat
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="shortcut-grid">
                                <a href="{{ route('berita.create') }}" class="shortcut-item">
                                    <i class="fas fa-pen-square text-primary"></i>
                                    <span class="shortcut-title">Tulis Berita</span>
                                    <span class="shortcut-desc">Publikasi konten</span>
                                </a>
                                <a href="{{ route('karir.create') }}" class="shortcut-item">
                                    <i class="fas fa-briefcase text-success"></i>
                                    <span class="shortcut-title">Lowongan</span>
                                    <span class="shortcut-desc">Rekrutmen</span>
                                </a>
                                <a href="{{ route('users.index') }}" class="shortcut-item">
                                    <i class="fas fa-users-cog text-info"></i>
                                    <span class="shortcut-title">Manajemen Akun</span>
                                    <span class="shortcut-desc">Hak akses</span>
                                </a>
                                <a href="{{ route('pengaturan-website.edit') }}" class="shortcut-item">
                                    <i class="fas fa-sliders-h text-secondary"></i>
                                    <span class="shortcut-title">Pengaturan</span>
                                    <span class="shortcut-desc">Info website</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- LOG AKTIVITAS --}}
                    <div class="card card-modern">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-history text-muted mr-2"></i>Aktivitas Sistem
                            </h3>
                        </div>
                        <div class="card-body">
                            <ul class="activity-list">
                                @forelse($recentActivity as $activity)
                                    <li class="activity-item">
                                        <span class="activity-badge badge-blue"></span>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong class="text-dark" style="font-size: 13px;">
                                                    {{ optional($activity->causer)->name ?? '-' }}
                                                </strong>
                                                <span class="text-muted" style="font-size: 11px;">
                                                    {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                                                </span>
                                            </div>
                                            <div class="text-muted" style="font-size: 12px;">
                                                {{ $activity->description }}
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="activity-item text-center text-muted py-3">
                                        Tidak ada aktivitas baru
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
@endsection

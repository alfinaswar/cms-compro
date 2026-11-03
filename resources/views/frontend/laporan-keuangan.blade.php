@php
    $currentLocale = app()->getLocale();
@endphp


@extends('frontend.index')

@section('content-frontend')
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
            integrity="sha512-papKuU1u7bVY/vpZPGgoy7HvDxe4sdRQ+sbZoRbZrX7ALy0qF6kXrEvVuL6kXGqz2EmAb+uiFMw5bMjC9l5A0g=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        <style>
            .sticky-sidebar {
                position: sticky;
                top: 160px;
                max-height: calc(100vh - 180px);
                overflow-y: auto;
            }

            .sticky-sidebar::-webkit-scrollbar,
            .custom-sidebar-scroll::-webkit-scrollbar {
                width: 4px;
            }

            .sticky-sidebar::-webkit-scrollbar-track,
            .custom-sidebar-scroll::-webkit-scrollbar-track {
                background: transparent;
            }

            .sticky-sidebar::-webkit-scrollbar-thumb,
            .custom-sidebar-scroll::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 4px;
            }

            .sticky-sidebar::-webkit-scrollbar-thumb:hover,
            .custom-sidebar-scroll::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            .sidebar-link.active {
                background-color: #f0f7ff;
                color: #0099ff;
                font-weight: 600;
                border-left: 3px solid #0099ff;
            }

            .report-card {
                transition: all 0.25s ease;
            }

            .report-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 12px 28px -6px rgba(0, 0, 0, 0.08);
                border-color: #0099ff;
            }

            .book-3d {
                box-shadow: -8px 8px 18px rgba(0, 0, 0, 0.2), inset -2px 0 4px rgba(255, 255, 255, 0.2);
                transition: transform 0.3s ease;
            }

            .book-3d:hover {
                transform: translateY(-4px) rotateY(-5deg);
            }

            /* Custom scrollbar for table */
            .table-scrollbar::-webkit-scrollbar {
                height: 6px;
            }

            .table-scrollbar::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 4px;
            }

            /* Offset scroll agar teks tidak tertutup sticky header */
            section[id],
            div[id].scroll-target,
            div#prospektus,
            div#laporan-tahunan,
            div#laporan-triwulanan,
            div#ringkasan-kinerja {
                scroll-margin-top: 180px !important;
            }
        </style>
    @endpush

    @php
        $activeTab = 'laporan-keuangan';
        $currentLocale = app()->getLocale();
    @endphp

    {{-- ========================================== --}}
    {{-- 1. HERO & SUB-TAB NAVIGATION --}}
    {{-- ========================================== --}}
    @include('frontend.investor.partials.hero-tabs')

    {{-- ========================================== --}}
    {{-- 2. MAIN LAYOUT (SIDEBAR + CONTENT) --}}
    {{-- ========================================== --}}
    <section class="py-10 bg-[#f8fafc] min-h-screen">
        <div class="container mx-auto max-w-[1420px]">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                {{-- ========================================== --}}
                {{-- LEFT SIDEBAR: DAFTAR LAPORAN & SUPPORT --}}
                {{-- ========================================== --}}
                <div class="lg:col-span-3">
                    <div
                        class="sticky top-[160px] space-y-5 max-h-[calc(100vh-180px)] overflow-y-auto custom-sidebar-scroll pr-1">

                        {{-- Navigasi Cepat Daftar Laporan --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5">
                            <div class="flex items-center gap-2.5 pb-3.5 mb-2 border-b border-slate-100">
                                <div
                                    class="w-8 h-8 rounded-lg bg-blue-50 text-[#0099ff] flex items-center justify-center text-sm">
                                    <i class="fa-solid fa-list-ul"></i>
                                </div>
                                <h3 class="font-bold text-slate-800 text-sm tracking-tight">
                                    {{ $currentLocale === 'en' ? 'Report Categories' : 'Daftar Laporan' }}
                                </h3>
                            </div>

                            <nav class="space-y-1.5" id="sidebar-nav">
                                <a href="#prospektus"
                                    class="sidebar-link active group flex items-center justify-between px-3.5 py-2.5 text-xs md:text-sm text-[#45464D] rounded-xl transition-all duration-200 hover:bg-blue-50 hover:text-[#0099ff] hover:translate-x-1.5 aria-[current=true]:bg-blue-50 aria-[current=true]:text-[#0099ff] aria-[current=true]:translate-x-1.5 aria-[current=true]:font-semibold"
                                    aria-current="true">
                                    <span class="flex items-center gap-2.5">
                                        <i
                                            class="fa-regular fa-file-lines w-4 text-center text-slate-400 group-hover:text-[#0099ff] [.active_&]:text-[#0099ff]"></i>
                                        Prospektus
                                    </span>
                                    <i
                                        class="fa-solid fa-chevron-right text-[10px] text-slate-300 group-hover:text-[#0099ff] group-hover:translate-x-0.5 [.active_&]:text-[#0099ff] transition-transform"></i>
                                </a>

                                <a href="#laporan-tahunan"
                                    class="sidebar-link group flex items-center justify-between px-3.5 py-2.5 text-xs md:text-sm text-[#45464D] rounded-xl transition-all duration-200 hover:bg-blue-50 hover:text-[#0099ff] hover:translate-x-1.5 aria-[current=true]:bg-blue-50 aria-[current=true]:text-[#0099ff] aria-[current=true]:translate-x-1.5 aria-[current=true]:font-semibold">
                                    <span class="flex items-center gap-2.5">
                                        <i
                                            class="fa-solid fa-book-bookmark w-4 text-center text-[#45464D] group-hover:text-[#0099ff] [.active_&]:text-[#0099ff]"></i>
                                        {{ $currentLocale === 'en' ? 'Annual Report' : 'Laporan Tahunan' }}
                                    </span>
                                    <i
                                        class="fa-solid fa-chevron-right text-[10px] text-slate-300 group-hover:text-[#0099ff] group-hover:translate-x-0.5 [.active_&]:text-[#0099ff] transition-transform"></i>
                                </a>

                                <a href="#laporan-triwulanan"
                                    class="sidebar-link group flex items-center justify-between px-3.5 py-2.5 text-xs md:text-sm text-[#45464D] rounded-xl transition-all duration-200 hover:bg-blue-50 hover:text-[#0099ff] hover:translate-x-1.5 aria-[current=true]:bg-blue-50 aria-[current=true]:text-[#0099ff] aria-[current=true]:translate-x-1.5 aria-[current=true]:font-semibold">
                                    <span class="flex items-center gap-2.5">
                                        <i
                                            class="fa-regular fa-calendar-check w-4 text-center text-[#45464D] group-hover:text-[#0099ff] [.active_&]:text-[#0099ff]"></i>
                                        {{ $currentLocale === 'en' ? 'Quarterly Report' : 'Laporan Triwulanan' }}
                                    </span>
                                    <i
                                        class="fa-solid fa-chevron-right text-[10px] text-slate-300 group-hover:text-[#0099ff] group-hover:translate-x-0.5 [.active_&]:text-[#0099ff] transition-transform"></i>
                                </a>
                                <a href="#ringkasan-kinerja"
                                    class="sidebar-link group flex items-center justify-between px-3.5 py-2.5 text-xs md:text-sm text-[#45464D] rounded-xl transition-all duration-200 hover:bg-blue-50 hover:text-[#0099ff] hover:translate-x-1.5 aria-[current=true]:bg-blue-50 aria-[current=true]:text-[#0099ff] aria-[current=true]:translate-x-1.5 aria-[current=true]:font-semibold">
                                    <span class="flex items-center gap-2.5">
                                        <i
                                            class="fa-solid fa-chart-column w-4 text-center text-[#45464D] group-hover:text-[#0099ff] [.active_&]:text-[#0099ff]"></i>
                                        {{ $currentLocale === 'en' ? 'Financial Highlight' : 'Ringkasan Keuangan' }}
                                    </span>
                                    <i
                                        class="fa-solid fa-chevron-right text-[10px] text-slate-300 group-hover:text-[#0099ff] group-hover:translate-x-0.5 [.active_&]:text-[#0099ff] transition-transform"></i>
                                </a>
                            </nav>
                        </div>

                        {{-- Support Box: Butuh Bantuan? --}}
                        @if ($kantor)
                            <div
                                class="bg-gradient-to-br from-[#f0f7ff] to-[#f8fbff] rounded-2xl border border-[#d6e8ff] p-5 shadow-sm">
                                <div class="flex items-start gap-3 mb-2.5">
                                    <div
                                        class="w-9 h-9 rounded-xl bg-[#0099ff] text-white flex items-center justify-center flex-shrink-0 shadow-sm shadow-[#0099ff]/30">
                                        <i class="fa-solid fa-building-user text-sm"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-sm">
                                            {{ $currentLocale === 'en' ? 'Investor Relations Office' : 'Kantor Hubungan Investor' }}
                                        </h4>
                                        <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">
                                            {!! nl2br(e($kantor->AlamatLengkap ?? '-')) !!}
                                        </p>
                                    </div>
                                </div>

                                <div
                                    class="mt-3.5 pt-3 border-t border-[#d6e8ff]/80 text-xs text-slate-600 space-y-1.5 font-medium">
                                    @if (!empty($kantor->HubunganInvestorEmail))
                                        <div class="flex items-center gap-2">
                                            <i class="fa-regular fa-envelope text-[#0099ff] w-3.5"></i>
                                            <a href="mailto:{{ $kantor->HubunganInvestorEmail }}"
                                                class="hover:text-[#0099ff] transition-colors">{{ $kantor->HubunganInvestorEmail }}</a>
                                        </div>
                                    @endif
                                    @if (!empty($kantor->Telepon))
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-phone text-[#0099ff] w-3.5"></i>
                                            <span>{{ $kantor->Telepon }}</span>
                                        </div>
                                    @endif
                                </div>

                                <a href="{{ route('frontend.investor.informasi-lainnya', ['locale' => $currentLocale]) }}#hubungi-investor"
                                    class="mt-4 block w-full py-2 bg-white hover:bg-slate-50 text-[#0099ff] border border-[#0099ff]/30 text-center font-semibold text-xs rounded-xl transition-all shadow-sm">
                                    {{ $currentLocale === 'en' ? 'Request Physical Copy' : 'Permintaan Dokumen Fisik' }}
                                    &rarr;
                                </a>
                            </div>
                        @endif


                    </div>
                </div>

                {{-- ========================================== --}}
                {{-- RIGHT MAIN CONTENT --}}
                {{-- ========================================== --}}
                <div class="lg:col-span-9 space-y-10">

                    {{-- ========================================== --}}
                    {{-- SECTION 1: PROSPEKTUS & KETERBUKAAN --}}
                    {{-- ========================================== --}}
                    <div id="prospektus"
                        class="scroll-mt-40 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8">
                        <div class="flex items-start gap-3.5 pb-5 mb-6 border-b border-slate-100">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-50 text-[#0099ff] flex items-center justify-center text-lg flex-shrink-0">
                                <i class="fa-solid fa-file-contract"></i>
                            </div>
                            <div>
                                <h2 class="text-xl md:text-2xl font-bold text-slate-900">
                                    {{ $currentLocale === 'en' ? 'Prospectus & Corporate Disclosure' : 'Prospektus' }}
                                </h2>
                                <p class="text-xs md:text-sm text-slate-500 mt-1">
                                    {{ $currentLocale === 'en' ? 'Official prospectus and material corporate action disclosures filed on the IDX (JTPE).' : 'Dokumen resmi prospektus penawaran umum perdana dan keterbukaan informasi perseroan di BEI (IDX: JTPE).' }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            @forelse ($categories as $kat)
                                <div
                                    class="report-card bg-[#EEF4FF] rounded-2xl p-6 flex flex-col justify-between border border-transparent hover:border-slate-200 transition-all">
                                    <div>
                                        <!-- Top Section: Icon & Content -->
                                        <div class="flex items-start gap-4 mb-4">
                                            <!-- Icon Document -->
                                            <div
                                                class="w-12 h-12 rounded-2xl bg-[#FFDEC9] text-[#3B1E08] flex items-center justify-center text-xl shrink-0">
                                                <i class="fa-regular fa-file-lines"></i>
                                            </div>

                                            <!-- Title & Badge Group -->
                                            <div class="flex-1">
                                                <!-- Badge & Year Info -->
                                                <div class="flex items-center gap-2.5 mb-2 flex-wrap">
                                                    <span
                                                        class="px-3 py-1 rounded-md text-[11px] font-bold bg-[#2B1704] text-[#FFDEC9] tracking-wide uppercase">
                                                        {{ $kat->jenisLaporan->NamaJenis ?? 'DOKUMEN' }}
                                                    </span>
                                                    <span class="text-xs text-slate-500 font-normal">
                                                        {{ \Carbon\Carbon::parse($kat->TahunPeriode)->format('Y') }}
                                                        @if ($kat->Bahasa === 'EN')
                                                            <span
                                                                class="ml-1 px-1.5 py-0.5 rounded bg-slate-200 text-slate-600 text-[10px] font-semibold">EN</span>
                                                        @endif
                                                    </span>
                                                </div>

                                                <!-- Main Title -->
                                                <h3 class="text-lg font-bold text-[#0F172A] leading-snug">
                                                    {{ $kat->Judul }}
                                                </h3>
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <p class="text-sm text-slate-600 leading-relaxed mb-6 pl-0 sm:pl-[64px]">
                                            {{ $kat->Deskripsi }}
                                        </p>
                                    </div>

                                    <!-- Bottom Section: File Info & Download Button -->
                                    <div class="pt-4 border-t border-slate-200/60 flex items-center justify-between">
                                        <!-- File Format & Size -->
                                        {{-- <span class="text-sm text-slate-700 font-semibold flex items-center gap-2">
                                            <i class="fa-regular fa-file-pdf text-base text-slate-600"></i>
                                            PDF ({{ $kat->FileSize }})
                                        </span> --}}

                                        <!-- Download Button -->
                                        <a href="{{ asset('storage/' . $kat->PathFile) }}" target="_blank"
                                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-[#0052CC] bg-white hover:bg-[#0052CC] hover:text-white rounded-xl transition-all shadow-sm border border-blue-200 hover:border-[#0052CC] hover:shadow-md">
                                            <i class="fa-solid fa-download text-sm"></i>
                                            Unduh Berkas
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-12 text-slate-500">
                                    <i class="fa-regular fa-folder-open text-4xl mb-3 text-slate-300"></i>
                                    <p class="text-sm">Belum ada dokumen pada kategori ini.</p>
                                </div>
                            @endforelse


                        </div>
                    </div>

                    {{-- ========================================== --}}
                    {{-- SECTION 2: LAPORAN TAHUNAN (ANNUAL REPORT) --}}
                    {{-- ========================================== --}}
                    <div id="laporan-tahunan"
                        class="scroll-mt-40 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8">

                        {{-- ============ HEADER + DROPDOWN TAHUN ============ --}}
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 mb-6 border-b border-slate-100">
                            <div class="flex items-start gap-3.5">
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-50 text-[#0099ff] flex items-center justify-center text-lg flex-shrink-0">
                                    <i class="fa-solid fa-book-bookmark"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">
                                        {{ $currentLocale === 'en' ? 'Annual Report' : 'Laporan Tahunan' }}
                                    </h2>
                                    <p class="text-xs md:text-sm text-slate-500 mt-1">
                                        {{ $currentLocale === 'en'
                                            ? 'Annual and sustainability reports covering overall corporate operations and finances.'
                                            : 'Laporan tahunan perusahaan mencakup kinerja keuangan dan operasional secara komprehensif.' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Year Dropdown Filter --}}
                            @if ($annualReports->isNotEmpty())
                                @php
                                    $currentYear = now()->year;
                                    // Ambil tahun TERBESAR dari data sebagai default tahun yang ditampilkan
                                    $maxYear = $annualReports->max(
                                        fn($r) => \Carbon\Carbon::parse($r->TahunPeriode)->format('Y'),
                                    );
                                @endphp

                                <div class="flex items-center gap-2">
                                    <label for="annualYearSelect"
                                        class="text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                        {{ $currentLocale === 'en' ? 'Year:' : 'Tahun:' }}
                                    </label>
                                    <div class="relative inline-block">
                                        <select id="annualYearSelect" onchange="filterAnnualReport(this.value)"
                                            class="pl-4 pr-10 py-1.5 text-xs md:text-sm font-semibold text-slate-800 bg-[#EEF4FF] hover:bg-[#e1edff] border border-slate-300 rounded-xl outline-none focus:border-[#0099ff] focus:ring-1 focus:ring-[#0099ff] cursor-pointer appearance-none transition-colors">
                                            @for ($i = 0; $i < 5; $i++)
                                                @php $year = $currentYear - $i; @endphp
                                                {{-- Pilih tahun yang sama dengan $maxYear sebagai default --}}
                                                <option value="{{ $year }}"
                                                    @if ($year == $maxYear) selected @endif>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-500">
                                            <i class="fa-solid fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- ============ DAFTAR CARD LAPORAN TAHUNAN ============ --}}
                        @php
                            $coverPalettes = [
                                [
                                    'gradient' => 'from-[#062438] via-[#094263] to-[#0a567f]',
                                    'accent' => 'border-amber-400',
                                    'tag' => 'text-amber-300',
                                    'divider' => 'bg-amber-400',
                                ],
                                [
                                    'gradient' => 'from-[#0c2f4d] via-[#104870] to-[#146294]',
                                    'accent' => 'border-emerald-400',
                                    'tag' => 'text-emerald-300',
                                    'divider' => 'bg-emerald-400',
                                ],
                                [
                                    'gradient' => 'from-[#1b2a47] via-[#243b61] to-[#2c4975]',
                                    'accent' => 'border-cyan-400',
                                    'tag' => 'text-cyan-300',
                                    'divider' => 'bg-cyan-400',
                                ],
                                [
                                    'gradient' => 'from-[#2d1b47] via-[#422461] to-[#572c75]',
                                    'accent' => 'border-fuchsia-400',
                                    'tag' => 'text-fuchsia-300',
                                    'divider' => 'bg-fuchsia-400',
                                ],
                                [
                                    'gradient' => 'from-[#47201b] via-[#612424] to-[#752c2c]',
                                    'accent' => 'border-rose-400',
                                    'tag' => 'text-rose-300',
                                    'divider' => 'bg-rose-400',
                                ],
                            ];
                        @endphp

                        @forelse($annualReports as $report)
                            @php
                                $tahun = \Carbon\Carbon::parse($report->TahunPeriode)->format('Y');
                                $palette = $coverPalettes[$loop->index % count($coverPalettes)];
                                $bahasaLabel = $report->Bahasa === 'EN' ? 'English' : 'Bahasa Indonesia';

                                // Sembunyikan card HANYA jika tahunnya BUKAN tahun default ($maxYear)
                                $isHidden = $tahun !== $maxYear ? 'hidden' : '';
                            @endphp

                            {{-- Gunakan ID unik dari database, dan tambahkan data-year untuk JS --}}
                            <div id="annual-card-{{ $report->id }}" data-year="{{ $tahun }}"
                                class="annual-report-card {{ $isHidden }} bg-gradient-to-br from-slate-50 to-white border border-slate-200/90 rounded-2xl p-6 md:p-7 shadow-sm transition-all duration-300">

                                <div class="grid grid-cols-1 md:grid-cols-12 gap-7 items-center">

                                    {{-- 3D Book Cover --}}
                                    <div class="md:col-span-4 flex justify-center">
                                        <div
                                            class="book-3d w-44 sm:w-48 h-64 rounded-xl relative overflow-hidden bg-gradient-to-br {{ $palette['gradient'] }} text-white p-5 flex flex-col justify-between border-l-4 {{ $palette['accent'] }}">
                                            <div
                                                class="flex justify-between items-center text-[10px] text-white/70 font-semibold tracking-wider">
                                                <span>ANNUAL REPORT</span>
                                                <span
                                                    class="px-1.5 py-0.5 rounded bg-white/10 text-white font-sans">{{ $tahun }}</span>
                                            </div>
                                            <div class="my-auto text-center">
                                                <div
                                                    class="text-[9px] uppercase tracking-widest {{ $palette['tag'] }} font-semibold mb-1">
                                                    PT JASUINDO TIGA PERKASA TBK
                                                </div>
                                                <div
                                                    class="text-base font-sans font-extrabold tracking-tight text-white leading-tight px-1">
                                                    {{ $report->Judul }}
                                                </div>
                                                <div class="w-8 h-0.5 {{ $palette['divider'] }} mx-auto my-2 rounded">
                                                </div>
                                                <div class="text-[10px] text-white/80 italic">
                                                    {{ $bahasaLabel }} &bull; {{ $report->FileSize }} MB
                                                </div>
                                            </div>
                                            <div
                                                class="flex justify-between items-center text-[10px] text-white/70 pt-2 border-t border-white/10">
                                                <span>IDX: JTPE</span>
                                                <i class="fa-solid fa-barcode text-sm opacity-60"></i>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Details & Highlights --}}
                                    <div class="md:col-span-8 space-y-4">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span
                                                class="px-3 py-0.5 rounded-full text-xs font-semibold bg-[#0051D5] text-white flex items-center gap-1.5">
                                                {{ $report->Status ?? 'Aktif' }}
                                            </span>
                                            <span class="px-3 py-1 text-xs font-semibold text-[#45464D]">
                                                {{ $bahasaLabel }}
                                            </span>
                                            <span class="text-xs text-slate-400 font-medium">
                                                {{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d F Y') }}
                                            </span>
                                        </div>

                                        <div>
                                            <h3 class="text-lg md:text-xl font-bold text-slate-900">
                                                {{ $report->Judul }}
                                            </h3>
                                            <p class="text-xs md:text-sm text-slate-600 mt-3 leading-relaxed">
                                                {{ $report->Deskripsi }}
                                            </p>
                                        </div>

                                        {{-- File Info Pill --}}
                                        <div
                                            class="grid grid-cols-2 sm:grid-cols-3 gap-3 bg-white p-3.5 rounded-xl border border-slate-200/80 shadow-xs">
                                            <div class="text-center sm:text-left">
                                                <span
                                                    class="text-[10px] uppercase font-semibold text-slate-400 block">Format</span>
                                                <span class="text-sm font-extrabold text-slate-900 block">PDF</span>
                                            </div>
                                            <div class="text-center sm:text-left border-x border-slate-100 px-3">
                                                <span
                                                    class="text-[10px] uppercase font-semibold text-slate-400 block">Ukuran</span>
                                                <span
                                                    class="text-sm font-extrabold text-slate-900 block">{{ $report->FileSize }}
                                                    MB</span>
                                            </div>
                                            <div class="text-center sm:text-left">
                                                <span
                                                    class="text-[10px] uppercase font-semibold text-slate-400 block">Periode</span>
                                                <span
                                                    class="text-sm font-extrabold text-slate-900 block">{{ $tahun }}</span>
                                            </div>
                                        </div>

                                        <div class="pt-2 flex flex-wrap items-center gap-3">
                                            <a href="{{ asset('storage/' . $report->PathFile) }}" target="_blank"
                                                download
                                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0099ff] hover:bg-[#0080d6] text-white text-xs md:text-sm font-semibold rounded-xl shadow-sm shadow-[#0099ff]/30 transition-all">
                                                <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i>
                                                Unduh Laporan (PDF)
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        @empty
                            <div class="text-center py-12">
                                <div
                                    class="w-16 h-16 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 text-2xl mb-4">
                                    <i class="fa-regular fa-folder-open"></i>
                                </div>
                                <p class="text-sm text-slate-500">Belum ada laporan tahunan yang tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                    <div id="laporan-triwulanan"
                        class="scroll-mt-40 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8">

                        {{-- ============ HEADER + DROPDOWN TAHUN ============ --}}
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 mb-6 border-b border-slate-100">
                            <div class="flex items-start gap-3.5">
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-50 text-[#0099ff] flex items-center justify-center text-lg flex-shrink-0">
                                    <i class="fa-regular fa-calendar-check"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">
                                        {{ $currentLocale === 'en' ? 'Quarterly Financial Reports' : 'Laporan Keuangan Triwulanan' }}
                                    </h2>
                                    <p class="text-xs md:text-sm text-slate-500 mt-1">
                                        {{ $currentLocale === 'en'
                                            ? 'Periodic quarterly financial statements audited and reviewed.'
                                            : 'Laporan keuangan triwulanan perusahaan yang diaudit dan dipublikasikan.' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Year Dropdown Filter --}}
                            @if ($quarterlyReports->isNotEmpty())
                                @php
                                    $currentYear = now()->year;
                                    $maxYear = $quarterlyReports->max(
                                        fn($r) => (int) \Carbon\Carbon::parse($r->TahunPeriode)->format('Y'),
                                    );
                                    // Default tahun = maxYear kalau dalam range 5 tahun ke belakang, kalau tidak pakai tahun terbaru di range
                                    $minDropdownYear = $currentYear - 4;
                                    $defaultYear = $maxYear >= $minDropdownYear ? $maxYear : $currentYear;
                                @endphp

                                <div class="flex items-center gap-2">
                                    <label for="quarterYearSelect"
                                        class="text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                        {{ $currentLocale === 'en' ? 'Year:' : 'Tahun:' }}
                                    </label>
                                    <div class="relative inline-block">
                                        <select id="quarterYearSelect" onchange="filterQuarterReport(this.value)"
                                            class="pl-4 pr-10 py-1.5 text-xs md:text-sm font-semibold text-slate-800 bg-[#EEF4FF] hover:bg-[#e1edff] border border-slate-300 rounded-xl outline-none focus:border-[#0099ff] focus:ring-1 focus:ring-[#0099ff] cursor-pointer appearance-none transition-colors">
                                            @for ($i = 0; $i < 5; $i++)
                                                @php $year = $currentYear - $i; @endphp
                                                <option value="{{ $year }}"
                                                    @if ($year == $defaultYear) selected @endif>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                        <div
                                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-500">
                                            <i class="fa-solid fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- ============ PREPARE DATA ============ --}}
                        @php
                            $currentYear = now()->year;

                            // Metadata tiap quarter: label romawi, tanggal akhir periode
                            $quarterMeta = [
                                1 => [
                                    'label' => 'I',
                                    'endDate' => '31 Maret',
                                    'badge' => 'Audit',
                                    'badgeColor' => 'bg-emerald-100 text-emerald-800',
                                    'iconBg' => 'bg-blue-600',
                                ],
                                2 => [
                                    'label' => 'II',
                                    'endDate' => '30 Juni',
                                    'badge' => 'Review',
                                    'badgeColor' => 'bg-blue-100 text-blue-800',
                                    'iconBg' => 'bg-blue-600',
                                ],
                                3 => [
                                    'label' => 'III',
                                    'endDate' => '30 September',
                                    'badge' => 'Review',
                                    'badgeColor' => 'bg-blue-100 text-blue-800',
                                    'iconBg' => 'bg-blue-600',
                                ],
                                4 => [
                                    'label' => 'IV',
                                    'endDate' => '31 Desember',
                                    'badge' => 'Audit',
                                    'badgeColor' => 'bg-emerald-100 text-emerald-800',
                                    'iconBg' => 'bg-blue-600',
                                ],
                            ];

                            // Group data berdasarkan "tahun-quarter" (misal: "2026-1" untuk Q1 2026)
                            $grouped = $quarterlyReports->groupBy(function ($r) {
                                $date = \Carbon\Carbon::parse($r->TahunPeriode);
                                $year = $date->format('Y');
                                $quarter = (int) ceil((int) $date->format('n') / 3);
                                return $year . '-' . $quarter;
                            });
                        @endphp

                        {{-- ============ GRID PER TAHUN (5 TAHUN KEBELAKANG) ============ --}}
                        @if ($quarterlyReports->isNotEmpty())
                            @for ($i = 0; $i < 5; $i++)
                                @php
                                    $year = $currentYear - $i;
                                    $isHidden = $year != $defaultYear ? 'hidden' : '';
                                @endphp

                                <div id="quarter-grid-{{ $year }}" data-year="{{ $year }}"
                                    class="quarter-report-grid {{ $isHidden }} grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 transition-all duration-300">

                                    @foreach ($quarterMeta as $qNum => $meta)
                                        @php
                                            $key = $year . '-' . $qNum;
                                            $report = $grouped->has($key) ? $grouped[$key]->first() : null;
                                            $hasFile = $report && $report->PathFile;
                                        @endphp

                                        @if ($hasFile)
                                            {{-- ===== CARD AKTIF (Data tersedia) ===== --}}
                                            <div
                                                class="report-card bg-[#EEF4FF] border border-slate-200 rounded-2xl p-5 flex flex-col justify-between hover:shadow-md transition-shadow">
                                                <div>
                                                    <div class="flex items-center justify-between mb-3">
                                                        <div
                                                            class="w-9 h-9 rounded-xl {{ $meta['iconBg'] }} text-white font-extrabold flex items-center justify-center text-xs shadow-sm">
                                                            Q{{ $qNum }}
                                                        </div>
                                                        <span
                                                            class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $meta['badgeColor'] }}">
                                                            {{ $meta['badge'] }}
                                                        </span>
                                                    </div>
                                                    <h4 class="font-bold text-slate-900 text-sm mb-1">
                                                        Triwulan {{ $meta['label'] }} {{ $year }}
                                                    </h4>
                                                    <p class="text-xs text-slate-500 mb-3">
                                                        Per {{ $meta['endDate'] }} {{ $year }}
                                                    </p>
                                                    @if ($report->Deskripsi)
                                                        <p
                                                            class="text-[11px] text-slate-600 leading-relaxed line-clamp-2 mb-3">
                                                            {{ $report->Deskripsi }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div
                                                        class="pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs text-[#45464D] mb-3">
                                                        <span>PDF &bull; {{ $report->FileSize }} MB</span>
                                                        <span class="text-emerald-600 font-semibold">Tersedia</span>
                                                    </div>
                                                    <a href="{{ asset('storage/' . $report->PathFile) }}" target="_blank"
                                                        download
                                                        class="w-full flex items-center justify-center gap-1.5 py-2 bg-white hover:bg-[#0080d6] text-[#0051D5] hover:text-white text-xs font-semibold rounded-xl shadow-xs transition-all">
                                                        <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i> Unduh PDF
                                                    </a>
                                                </div>
                                            </div>
                                        @else
                                            {{-- ===== CARD DISABLED (Segera Hadir) ===== --}}
                                            <div
                                                class="bg-[#EEF4FF] border border-slate-200/70 rounded-2xl p-5 flex flex-col justify-between opacity-75">
                                                <div>
                                                    <div class="flex items-center justify-between mb-3">
                                                        <div
                                                            class="w-9 h-9 rounded-xl bg-slate-200 text-slate-600 font-extrabold flex items-center justify-center text-xs">
                                                            Q{{ $qNum }}
                                                        </div>
                                                        <span
                                                            class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                                            Segera
                                                        </span>
                                                    </div>
                                                    <h4 class="font-bold text-slate-700 text-sm mb-1">
                                                        Triwulan {{ $meta['label'] }} {{ $year }}
                                                    </h4>
                                                    <p class="text-xs text-slate-400 mb-3">
                                                        Per {{ $meta['endDate'] }} {{ $year }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <div
                                                        class="pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs text-slate-400 mb-3">
                                                        <span>Jadwal Rilis</span>
                                                        <span class="text-amber-600 font-medium">Segera Hadir</span>
                                                    </div>
                                                    <button disabled
                                                        class="w-full flex items-center justify-center gap-1.5 py-2 bg-slate-100 text-slate-400 text-xs font-semibold rounded-xl cursor-not-allowed">
                                                        <i class="fa-regular fa-clock text-xs"></i> Segera Hadir
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endfor
                        @else
                            {{-- ============ EMPTY STATE ============ --}}
                            <div class="text-center py-12">
                                <div
                                    class="w-16 h-16 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 text-2xl mb-4">
                                    <i class="fa-regular fa-folder-open"></i>
                                </div>
                                <p class="text-sm text-slate-500">Belum ada laporan triwulanan yang tersedia.</p>
                            </div>
                        @endif
                    </div>
                    <div id="ringkasan-kinerja"
                        class="scroll-mt-40 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8">
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 mb-6 border-b border-slate-100">
                            <div class="flex items-start gap-3.5">
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-50 text-[#0099ff] flex items-center justify-center text-lg flex-shrink-0">
                                    <i class="fa-solid fa-chart-column"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">
                                        {{ __('Financial Highlight') }}
                                    </h2>
                                    <p class="text-xs md:text-sm text-slate-500 mt-1">
                                        {{ $currentLocale === 'en' ? 'Summary of core financial metrics and key performance indicators of the company.' : 'Ringkasan indikator kinerja dan pos keuangan utama perseroan.' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Action Buttons: Download Excel & Download PDF --}}
                            <div class="flex items-center gap-2.5 self-start sm:self-auto">
                                <button type="button" onclick="downloadFinancialExcel()"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold shadow-xs transition-all">
                                    <i class="fa-solid fa-file-excel text-xs"></i>
                                    Download Excel
                                </button>
                                <button type="button" onclick="downloadFinancialPdf()"
                                    class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-[#0099ff] hover:bg-[#0080d6] text-white rounded-xl text-xs font-semibold shadow-xs transition-all">
                                    <i class="fa-solid fa-file-pdf text-xs"></i>
                                    Download PDF
                                </button>
                            </div>
                        </div>

                        {{-- 1. GRAFIK VIEW (2 BAR CHARTS - DYNAMIC) --}}
                        <div id="financialChartView" class="space-y-6 mb-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Chart 1: Pendapatan Usaha --}}
                                <div class="bg-[#EFF4FF] border border-slate-200/80 rounded-2xl p-5">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h4 class="font-bold text-slate-900 text-sm">
                                                {{ $currentLocale === 'en' ? 'Revenue' : 'Pendapatan Usaha' }}</h4>
                                            <span class="text-[11px] text-slate-500">Miliar IDR</span>
                                        </div>
                                        <span
                                            class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-[#0099ff]">
                                            {{ $pengaturanKinerja->PertumbuhanRevenue ?? '+31.5% YoY (2025)' }}
                                        </span>
                                    </div>

                                    <div class="h-44 flex items-end justify-between gap-3 pt-4 px-2">
                                        @php
                                            $maxRev =
                                                !empty($chartRevenue) && max($chartRevenue) > 0
                                                    ? max($chartRevenue)
                                                    : 1;
                                        @endphp
                                        @foreach ($financialYears as $idx => $yr)
                                            @php
                                                $val = $chartRevenue[$idx] ?? 0;
                                                $heightPct = round(($val / $maxRev) * 100);
                                                $isLast = $loop->last;
                                            @endphp
                                            <div
                                                class="flex-1 flex flex-col items-center gap-1.5 h-full justify-end group">
                                                <span
                                                    class="text-[10px] font-bold {{ $isLast ? 'text-[#0099ff]' : 'text-slate-600 opacity-0 group-hover:opacity-100 transition-opacity' }}">
                                                    {{ number_format($val, 0, ',', '.') }}
                                                </span>
                                                <div class="w-full {{ $isLast ? 'bg-[#0099ff] shadow-sm' : 'bg-[#0099ff]/70 hover:bg-[#0099ff]' }} rounded-t-md transition-all"
                                                    style="height: {{ max($heightPct, 15) }}%;"></div>
                                                <span
                                                    class="text-[11px] {{ $isLast ? 'font-extrabold text-slate-900' : 'font-semibold text-slate-600' }}">{{ $yr }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Chart 2: Laba Bersih --}}
                                <div class="bg-[#EFF4FF] border border-slate-200/80 rounded-2xl p-5">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h4 class="font-bold text-slate-900 text-sm">
                                                {{ $currentLocale === 'en' ? 'Net Profit for the Year' : 'Laba Bersih Tahun Berjalan' }}
                                            </h4>
                                            <span class="text-[11px] text-slate-500">Miliar IDR</span>
                                        </div>
                                        <span
                                            class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                                            {{ $pengaturanKinerja->PertumbuhanProfit ?? '+47.7% YoY (2025)' }}
                                        </span>
                                    </div>

                                    <div class="h-44 flex items-end justify-between gap-3 pt-4 px-2">
                                        @php
                                            $maxProf =
                                                !empty($chartProfit) && max($chartProfit) > 0 ? max($chartProfit) : 1;
                                        @endphp
                                        @foreach ($financialYears as $idx => $yr)
                                            @php
                                                $val = $chartProfit[$idx] ?? 0;
                                                $heightPct = round(($val / $maxProf) * 100);
                                                $isLast = $loop->last;
                                            @endphp
                                            <div
                                                class="flex-1 flex flex-col items-center gap-1.5 h-full justify-end group">
                                                <span
                                                    class="text-[10px] font-bold {{ $isLast ? 'text-emerald-700' : 'text-slate-600 opacity-0 group-hover:opacity-100 transition-opacity' }}">
                                                    {{ number_format($val, 0, ',', '.') }}
                                                </span>
                                                <div class="w-full {{ $isLast ? 'bg-emerald-600 shadow-sm' : 'bg-emerald-500/70 hover:bg-emerald-600' }} rounded-t-md transition-all"
                                                    style="height: {{ max($heightPct, 15) }}%;"></div>
                                                <span
                                                    class="text-[11px] {{ $isLast ? 'font-extrabold text-slate-900' : 'font-semibold text-slate-600' }}">{{ $yr }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. TABEL LENGKAP TAHUNAN (GABUNG DALAM 1 CONTAINER) --}}
                        <div id="financialTableView" class="overflow-hidden rounded-2xl border border-slate-200">
                            <div class="overflow-x-auto table-scrollbar">
                                <table id="financialDataTable"
                                    class="w-full text-left text-xs text-slate-700 divide-y divide-slate-200">
                                    <thead class="bg-slate-100 text-slate-800 font-bold tracking-wider">
                                        <tr>
                                            <th class="py-3 px-4 min-w-[240px]">
                                                {{ $currentLocale === 'en' ? 'Financial Metrics' : 'Pos Keuangan' }}
                                            </th>
                                            @foreach ($financialYears as $yr)
                                                <th
                                                    class="py-3 px-3 text-right {{ $loop->last ? 'font-extrabold text-[#0099ff] bg-blue-50/50' : '' }}">
                                                    {{ $yr }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        {{-- Section 1: Laba Rugi --}}
                                        <tr class="bg-slate-100/80 font-bold text-slate-900">
                                            <td colspan="{{ count($financialYears) + 1 }}"
                                                class="py-2.5 px-4 text-xs tracking-wider uppercase text-blue-900 bg-blue-50/40">
                                                LAPORAN LABA RUGI KOMPREHENSIF (JUTAAN IDR)
                                            </td>
                                        </tr>
                                        @foreach ($labaRugi as $row)
                                            @if ($row->Catatan)
                                                <tr class="text-slate-500 italic bg-slate-50/40">
                                                    <td colspan="{{ count($financialYears) + 1 }}"
                                                        class="py-1.5 px-4 text-[11px]">{{ $row->Catatan }}</td>
                                                </tr>
                                            @endif
                                            <tr
                                                class="hover:bg-slate-50 {{ $row->IsHighlight ? 'bg-emerald-50/30' : '' }} {{ $row->IsBold ? 'font-bold text-slate-900' : '' }}">
                                                <td class="py-2 {{ $row->IsSubPos ? 'px-6' : 'px-4' }}">
                                                    @if ($row->IsSubPos)
                                                        &bull;
                                                    @endif{{ $row->NamaPos }}
                                                </td>
                                                @foreach ($financialYears as $yr)
                                                    <td
                                                        class="py-2 px-3 text-right {{ $loop->last ? 'bg-blue-50/30' : '' }} {{ $row->IsHighlight && $loop->last ? 'font-extrabold text-emerald-700' : ($row->IsBold ? 'font-bold text-slate-900' : '') }}">
                                                        {{ $row->nilaiTahun($yr) }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach

                                        {{-- Section 2: Posisi Keuangan --}}
                                        <tr class="bg-slate-100/80 font-bold text-slate-900">
                                            <td colspan="{{ count($financialYears) + 1 }}"
                                                class="py-2.5 px-4 text-xs tracking-wider uppercase text-blue-900 bg-blue-50/40">
                                                LAPORAN POSISI KEUANGAN (JUTAAN IDR)
                                            </td>
                                        </tr>
                                        @foreach ($posisiKeuangan as $row)
                                            @if ($row->Catatan)
                                                <tr class="text-slate-500 italic bg-slate-50/40">
                                                    <td colspan="{{ count($financialYears) + 1 }}"
                                                        class="py-1.5 px-4 text-[11px]">{{ $row->Catatan }}</td>
                                                </tr>
                                            @endif
                                            <tr
                                                class="hover:bg-slate-50 {{ $row->IsHighlight ? 'bg-emerald-50/30' : '' }} {{ $row->IsBold ? 'font-bold text-slate-900' : '' }}">
                                                <td class="py-2 {{ $row->IsSubPos ? 'px-6' : 'px-4' }}">
                                                    @if ($row->IsSubPos)
                                                        &bull;
                                                    @endif{{ $row->NamaPos }}
                                                </td>
                                                @foreach ($financialYears as $yr)
                                                    <td
                                                        class="py-2 px-3 text-right {{ $loop->last ? 'bg-blue-50/30' : '' }} {{ $row->IsHighlight && $loop->last ? 'font-extrabold text-emerald-700' : ($row->IsBold ? 'font-bold text-slate-900' : '') }}">
                                                        {{ $row->nilaiTahun($yr) }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach

                                        {{-- Section 3: Rasio --}}
                                        <tr class="bg-slate-100/80 font-bold text-slate-900">
                                            <td colspan="{{ count($financialYears) + 1 }}"
                                                class="py-2.5 px-4 text-xs tracking-wider uppercase text-blue-900 bg-blue-50/40">
                                                RASIO - RASIO PENTING
                                            </td>
                                        </tr>
                                        @foreach ($rasioKeuangan as $row)
                                            @if ($row->Catatan)
                                                <tr class="text-slate-500 italic bg-slate-50/40">
                                                    <td colspan="{{ count($financialYears) + 1 }}"
                                                        class="py-1.5 px-4 text-[11px]">{{ $row->Catatan }}</td>
                                                </tr>
                                            @endif
                                            <tr
                                                class="hover:bg-slate-50 {{ $row->IsHighlight ? 'bg-emerald-50/30' : '' }} {{ $row->IsBold ? 'font-bold text-slate-900' : '' }}">
                                                <td class="py-2 {{ $row->IsSubPos ? 'px-6' : 'px-4' }}">
                                                    @if ($row->IsSubPos)
                                                        &bull;
                                                    @endif{{ $row->NamaPos }}
                                                </td>
                                                @foreach ($financialYears as $yr)
                                                    <td
                                                        class="py-2 px-3 text-right {{ $loop->last ? 'bg-blue-50/30' : '' }} {{ $row->IsHighlight && $loop->last ? 'font-extrabold text-emerald-700' : ($row->IsBold ? 'font-bold text-slate-900' : '') }}">
                                                        {{ $row->nilaiTahun($yr) }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach

                                        {{-- Section 4: Saham & Dividen --}}
                                        <tr class="bg-slate-100/80 font-bold text-slate-900">
                                            <td colspan="{{ count($financialYears) + 1 }}"
                                                class="py-2.5 px-4 text-xs tracking-wider uppercase text-blue-900 bg-blue-50/40">
                                                INFORMASI SAHAM &amp; DIVIDEN
                                            </td>
                                        </tr>
                                        @foreach ($sahamDividen as $row)
                                            @if ($row->Catatan)
                                                <tr class="text-slate-500 italic bg-slate-50/40">
                                                    <td colspan="{{ count($financialYears) + 1 }}"
                                                        class="py-1.5 px-4 text-[11px]">{{ $row->Catatan }}</td>
                                                </tr>
                                            @endif
                                            <tr
                                                class="hover:bg-slate-50 {{ $row->IsHighlight ? 'bg-emerald-50/30' : '' }} {{ $row->IsBold ? 'font-bold text-slate-900' : '' }}">
                                                <td class="py-2 {{ $row->IsSubPos ? 'px-6' : 'px-4' }}">
                                                    @if ($row->IsSubPos)
                                                        &bull;
                                                    @endif{{ $row->NamaPos }}
                                                </td>
                                                @foreach ($financialYears as $yr)
                                                    <td
                                                        class="py-2 px-3 text-right {{ $loop->last ? 'bg-blue-50/30' : '' }} {{ $row->IsHighlight && $loop->last ? 'font-extrabold text-emerald-700' : ($row->IsBold ? 'font-bold text-slate-900' : '') }}">
                                                        {{ $row->nilaiTahun($yr) }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div
                class="bg-gradient-to-r from-[#0a557a] via-[#094e70] to-[#073952] rounded-2xl p-6 md:p-8 text-white shadow-md flex flex-col sm:flex-row items-center justify-between ml-[365px] gap-6 mt-12">
                <div class="space-y-1.5 text-center sm:text-left">
                    <h3 class="text-lg md:text-xl font-bold tracking-tight">
                        {{ $currentLocale === 'en' ? 'Need Physical Copy or Investor Assistance?' : 'Membutuhkan Salinan Fisik atau Pertanyaan?' }}
                    </h3>
                    <p class="text-xs md:text-sm text-white/80 max-w-xl">
                        {{ $currentLocale === 'en' ? 'Submit an investor document request or reach out directly to our Investor Relations team.' : 'Silakan ajukan permohonan pengiriman dokumen fisik atau hubungi tim Hubungan Investor kami.' }}
                    </p>
                </div>

                <a href="{{ route('frontend.investor.informasi-lainnya', ['locale' => $currentLocale]) }}#hubungi-investor"
                    class="px-6 py-3 bg-[#0099ff] hover:bg-[#0080d6] text-white font-semibold text-xs md:text-sm rounded-xl shadow-md transition-all whitespace-nowrap flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    {{ $currentLocale === 'en' ? 'Contact Investor Relations' : 'Hubungi Hubungan Investor' }}
                </a>
            </div>
    </section>

    @push('scripts')
        <script>
            // Filter Annual Report by Year
            function filterAnnualReport(year) {
                // Loop semua card laporan tahunan
                document.querySelectorAll('.annual-report-card').forEach(card => {
                    // Jika data-year card sama dengan tahun yang dipilih, tampilkan
                    if (card.dataset.year === year) {
                        card.classList.remove('hidden');
                    } else {
                        // Jika tidak, sembunyikan
                        card.classList.add('hidden');
                    }
                });
            }

            // Filter Quarterly Reports by Year
            function filterQuarterReport(year) {
                document.querySelectorAll('.quarter-report-grid').forEach(grid => {
                    if (grid.dataset.year === year) {
                        grid.classList.remove('hidden');
                    } else {
                        grid.classList.add('hidden');
                    }
                });
            }

            // Export Financial Data to Excel (CSV format with UTF-8 BOM)
            function downloadFinancialExcel() {
                const table = document.getElementById('financialDataTable');
                if (!table) return;

                let csv = [];
                const rows = table.querySelectorAll('tr');

                rows.forEach(row => {
                    let cols = [];
                    row.querySelectorAll('th, td').forEach(cell => {
                        // Bersihkan spasi dan quotes ganda
                        let text = cell.innerText.replace(/(\r\n|\n|\r)/gm, ' ').trim();
                        text = text.replace(/"/g, '""');
                        cols.push('"' + text + '"');
                    });
                    csv.push(cols.join(','));
                });

                const csvContent = '\uFEFF' + csv.join('\r\n');
                const blob = new Blob([csvContent], {
                    type: 'text/csv;charset=utf-8;'
                });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'Financial_Highlight_JTPE.csv';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }

            // Export / Print Financial Highlight to PDF
            function downloadFinancialPdf() {
                const container = document.getElementById('ringkasan-kinerja');
                if (!container) return;

                const printWindow = window.open('', '_blank');
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <link rel="preconnect" href="https://fonts.googleapis.com">
                        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
                        <style>
                            body { font-family: 'Plus Jakarta Sans', sans-serif; padding: 24px; color: #1e293b; }
                            table { width: 100%; border-collapse: collapse; margin-top: 16px; font-size: 11px; }
                            th, td { border: 1px solid #cbd5e1; padding: 6px 10px; }
                            th { background-color: #f1f5f9; text-align: left; }
                            .header-title { font-size: 20px; font-weight: bold; margin-bottom: 4px; }
                            .header-sub { font-size: 12px; color: #64748b; margin-bottom: 20px; }
                            @media print {
                                button { display: none !important; }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="header-title">PT JASUINDO TIGA PERKASA TBK - FINANCIAL HIGHLIGHT</div>
                        <div class="header-sub">Ikhtisar Kinerja Keuangan & Rasio Penting</div>
                        ${container.innerHTML}
                        <script>
                            window.onload = function() {
                                window.print();
                            }
                        <\/script>
                    </body>
                    </html>
                `);
                printWindow.document.close();
            }


            document.addEventListener('DOMContentLoaded', () => {
                const sidebarLinks = document.querySelectorAll('#sidebar-nav .sidebar-link');
                const sections = document.querySelectorAll(
                    'section[id], div[id]'); // Pastikan section target memiliki id (contoh: id="prospektus")

                function setActiveLink(activeLink) {
                    sidebarLinks.forEach(link => {
                        link.classList.remove('active');
                        link.removeAttribute('aria-current');
                    });
                    activeLink.classList.add('active');
                    activeLink.setAttribute('aria-current', 'true');
                }

                // Handele saat link diklik
                sidebarLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        setActiveLink(this);
                    });
                });

                // Handle ScrollSpy (otomatis ubah active link saat halaman di-scroll)
                window.addEventListener('scroll', () => {
                    let currentSectionId = '';

                    sections.forEach(section => {
                        const sectionTop = section.offsetTop - 175;
                        if (window.scrollY >= sectionTop) {
                            currentSectionId = section.getAttribute('id');
                        }
                    });

                    if (currentSectionId) {
                        sidebarLinks.forEach(link => {
                            if (link.getAttribute('href') === `#${currentSectionId}`) {
                                setActiveLink(link);
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection

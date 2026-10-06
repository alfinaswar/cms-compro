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
                top: 90px;
                max-height: calc(100vh - 110px);
                overflow-y: auto;
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
                    <div class="sticky top-28 space-y-5">

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
                        <div
                            class="bg-gradient-to-br from-[#f0f7ff] to-[#f8fbff] rounded-2xl border border-[#d6e8ff] p-5 shadow-sm">
                            <div class="flex items-start gap-3 mb-2.5">
                                <div
                                    class="w-9 h-9 rounded-xl bg-[#0099ff] text-white flex items-center justify-center flex-shrink-0 shadow-sm shadow-[#0099ff]/30">
                                    <i class="fa-solid fa-headset text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 text-sm">
                                        {{ $currentLocale === 'en' ? 'Need Assistance?' : 'Butuh Bantuan?' }}
                                    </h4>
                                    <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">
                                        {{ $currentLocale === 'en' ? 'Contact our Investor Relations team for inquiries.' : 'Hubungi Tim Hubungan Investor kami untuk pertanyaan lebih lanjut.' }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="mt-3.5 pt-3 border-t border-[#d6e8ff]/80 text-xs text-slate-600 space-y-1.5 font-medium">
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-envelope text-[#0099ff] w-3.5"></i>
                                    <a href="mailto:corsec@jasuindo.com"
                                        class="hover:text-[#0099ff] transition-colors">corsec@jasuindo.com</a>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-phone text-[#0099ff] w-3.5"></i>
                                    <span>(031) 891 0619</span>
                                </div>
                            </div>

                            <a href="{{ route('frontend.investor.informasi-lainnya', ['locale' => $currentLocale]) }}#hubungi-investor"
                                class="mt-4 block w-full py-2 bg-white hover:bg-slate-50 text-[#0099ff] border border-[#0099ff]/30 text-center font-semibold text-xs rounded-xl transition-all shadow-sm">
                                {{ $currentLocale === 'en' ? 'Request Physical Copy' : 'Permintaan Dokumen Fisik' }} &rarr;
                            </a>
                        </div>

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
                        class="scroll-mt-28 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8">
                        <div class="flex items-start gap-3.5 pb-5 mb-6 border-b border-slate-100">
                            <div
                                class="w-10 h-10 rounded-xl bg-blue-50 text-[#0099ff] flex items-center justify-center text-lg flex-shrink-0">
                                <i class="fa-solid fa-file-contract"></i>
                            </div>
                            <div>
                                <h2 class="text-xl md:text-2xl font-bold text-slate-900">
                                    {{ $currentLocale === 'en' ? 'Prospectus & Corporate Disclosure' : 'Prospektus & 449' }}
                                </h2>
                                <p class="text-xs md:text-sm text-slate-500 mt-1">
                                    {{ $currentLocale === 'en' ? 'Official prospectus and material corporate action disclosures filed on the IDX (JTPE).' : 'Dokumen resmi prospektus penawaran umum perdana dan keterbukaan informasi perseroan di BEI (IDX: JTPE).' }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Card 1: Prospektus IPO --}}
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
                                                    {{ __('PENAWARAN SAHAM') }}
                                                </span>
                                                <span class="text-xs text-slate-500 font-normal">
                                                    1999 & Addendum
                                                </span>
                                            </div>

                                            <!-- Main Title -->
                                            <h3 class="text-lg font-bold text-[#0F172A] leading-snug">
                                                Prospektus Penawaran Umum Perdana Saham
                                            </h3>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <p class="text-sm text-slate-600 leading-relaxed mb-6 pl-0 sm:pl-[64px]">
                                        Penawaran umum saham biasa perseroan yang dicatatkan pada BEI (IDX: JTPE).
                                    </p>
                                </div>

                                <!-- Bottom Section: File Info & Download Button -->
                                <div class="pt-4 border-t border-slate-200/60 flex items-center justify-between">
                                    <!-- File Format & Size -->
                                    <span class="text-sm text-slate-700 font-semibold flex items-center gap-2">
                                        <i class="fa-regular fa-file-pdf text-base text-slate-600"></i>
                                        PDF (34.2 MB)
                                    </span>

                                    <!-- Download Button -->
                                    <a href="{{ asset('assets/documents/prospektus-jtpe.pdf') }}" target="_blank" download
                                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-[#0052CC] bg-white hover:bg-blue-50 rounded-xl transition-all shadow-sm border border-slate-100">
                                        <i class="fa-solid fa-download text-sm"></i>
                                        Unduh Berkas
                                    </a>
                                </div>
                            </div>

                            {{-- Card 2: Keterbukaan Informasi Aksi Korporasi --}}
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
                                                    {{ __('PENAWARAN SAHAM') }}
                                                </span>
                                                <span class="text-xs text-slate-500 font-normal">
                                                    1999 & Addendum
                                                </span>
                                            </div>

                                            <!-- Main Title -->
                                            <h3 class="text-lg font-bold text-[#0F172A] leading-snug">
                                                Prospektus Penawaran Umum Perdana Saham
                                            </h3>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <p class="text-sm text-slate-600 leading-relaxed mb-6 pl-0 sm:pl-[64px]">
                                        Penawaran umum saham biasa perseroan yang dicatatkan pada BEI (IDX: JTPE).
                                    </p>
                                </div>

                                <!-- Bottom Section: File Info & Download Button -->
                                <div class="pt-4 border-t border-slate-200/60 flex items-center justify-between">
                                    <!-- File Format & Size -->
                                    <span class="text-sm text-slate-700 font-semibold flex items-center gap-2">
                                        <i class="fa-regular fa-file-pdf text-base text-slate-600"></i>
                                        PDF (34.2 MB)
                                    </span>

                                    <!-- Download Button -->
                                    <a href="{{ asset('assets/documents/prospektus-jtpe.pdf') }}" target="_blank" download
                                        class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-[#0052CC] bg-white hover:bg-blue-50 rounded-xl transition-all shadow-sm border border-slate-100">
                                        <i class="fa-solid fa-download text-sm"></i>
                                        Unduh Berkas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ========================================== --}}
                    {{-- SECTION 2: LAPORAN TAHUNAN (ANNUAL REPORT) --}}
                    {{-- ========================================== --}}
                    <div id="laporan-tahunan"
                        class="scroll-mt-28 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8">
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
                                        {{ $currentLocale === 'en' ? 'Annual and sustainability reports covering overall corporate operations and finances.' : 'Laporan tahunan perusahaan mencakup kinerja keuangan dan operasional secara komprehensif.' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Year Dropdown Filter --}}
                            <div class="flex items-center gap-2">
                                <label for="annualYearSelect"
                                    class="text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                    {{ $currentLocale === 'en' ? 'Year:' : 'Tahun:' }}
                                </label>
                                <select id="annualYearSelect" onchange="filterAnnualReport(this.value)"
                                    class="px-3 py-1.5 text-xs md:text-sm font-semibold text-slate-700 bg-[#EEF4FF] border border-slate-300 rounded-xl outline-none focus:border-[#0099ff] focus:ring-1 focus:ring-[#0099ff] cursor-pointer">
                                    <option value="2025" selected>2025</option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                </select>
                            </div>
                        </div>

                        {{-- Featured Annual Report Display --}}
                        <div id="annual-card-2025"
                            class="annual-report-card bg-[#EEF4FF] from-slate-50 to-white border border-slate-200/90 rounded-2xl p-6 md:p-7 shadow-sm">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-7 items-center">
                                {{-- 3D Book Cover --}}
                                <div class="md:col-span-4 flex justify-center">
                                    <div
                                        class="book-3d w-44 sm:w-48 h-64 rounded-xl relative overflow-hidden bg-gradient-to-br from-[#062438] via-[#094263] to-[#0a567f] text-white p-5 flex flex-col justify-between border-l-4 border-amber-400">
                                        <div
                                            class="flex justify-between items-center text-[10px] text-white/70 font-semibold tracking-wider">
                                            <span>ANNUAL REPORT</span>
                                            <span
                                                class="px-1.5 py-0.5 rounded bg-white/10 text-white font-mono">2025</span>
                                        </div>
                                        <div class="my-auto text-center">
                                            <div
                                                class="text-[9px] uppercase tracking-widest text-amber-300 font-semibold mb-1">
                                                PT JASUINDO TIGA PERKASA TBK</div>
                                            <div
                                                class="text-base font-serif font-extrabold tracking-tight text-white leading-tight">
                                                Journey into the Future</div>
                                            <div class="w-8 h-0.5 bg-amber-400 mx-auto my-2 rounded"></div>
                                            <div class="text-[10px] text-white/80 italic">Innovation &bull; Security &bull;
                                                Trust</div>
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
                                            Rilis Resmi Final
                                        </span>
                                        <span class="px-3 py-1 text-xs font-semibold text-[#45464D]">
                                            Bilingual (ID / EN)
                                        </span>

                                    </div>

                                    <div>
                                        <h3 class="text-lg md:text-xl font-bold text-slate-900">
                                            Laporan Tahunan &amp; Laporan Keberlanjutan 2025
                                        </h3>
                                        <p class="text-xs md:text-sm text-slate-600 mt-3 leading-relaxed">
                                            Mencakup ikhtisar kinerja operasional, tata kelola ESG berkelanjutan, serta
                                            laporan keuangan konsolidasian perseroan dan entitas anak yang telah diaudit
                                            oleh Kantor Akuntan Publik independen.
                                        </p>
                                    </div>

                                    <div class="pt-2 flex flex-wrap items-center gap-3">
                                        <a href="{{ asset('assets/documents/annual-report-2025.pdf') }}" target="_blank"
                                            download
                                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-black hover:bg-[#0080d6] text-white text-xs md:text-sm font-semibold rounded-xl shadow-sm shadow-[#0099ff]/30 transition-all">
                                            <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i> Unduh Laporan Tahunan
                                            (PDF)
                                        </a>
                                        <button type="button"
                                            onclick="alert('Laporan Tahunan 2025 lengkap telah tersedia untuk diunduh.')"
                                            class="inline-flex items-center gap-1.5 text-slate-700 text-xs md:text-sm font-semibold rounded-xl transition-all">
                                            <i class="fa-regular fa-eye text-xs text-slate-500"></i> Ringkasan Eksekutif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Featured Annual Report Display 2024 --}}
                        <div id="annual-card-2024"
                            class="annual-report-card hidden bg-gradient-to-br from-slate-50 to-white border border-slate-200/90 rounded-2xl p-6 md:p-7 shadow-sm">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-7 items-center">
                                {{-- 3D Book Cover --}}
                                <div class="md:col-span-4 flex justify-center">
                                    <div
                                        class="book-3d w-44 sm:w-48 h-64 rounded-xl relative overflow-hidden bg-gradient-to-br from-[#0c2f4d] via-[#104870] to-[#146294] text-white p-5 flex flex-col justify-between border-l-4 border-emerald-400">
                                        <div
                                            class="flex justify-between items-center text-[10px] text-white/70 font-semibold tracking-wider">
                                            <span>ANNUAL REPORT</span>
                                            <span
                                                class="px-1.5 py-0.5 rounded bg-white/10 text-white font-mono">2024</span>
                                        </div>
                                        <div class="my-auto text-center">
                                            <div
                                                class="text-[9px] uppercase tracking-widest text-emerald-300 font-semibold mb-1">
                                                PT JASUINDO TIGA PERKASA TBK</div>
                                            <div
                                                class="text-base font-serif font-extrabold tracking-tight text-white leading-tight">
                                                Empowering Digital Trust</div>
                                            <div class="w-8 h-0.5 bg-emerald-400 mx-auto my-2 rounded"></div>
                                            <div class="text-[10px] text-white/80 italic">Global Smart Card Solutions</div>
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
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1.5">
                                            <i class="fa-solid fa-circle-check text-emerald-500"></i> Audit: WTP
                                        </span>
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-[#0099ff] border border-blue-200">
                                            Bilingual (ID / EN)
                                        </span>
                                        <span class="text-xs text-slate-400 font-medium">Rilis: 25 April 2025</span>
                                    </div>

                                    <div>
                                        <h3 class="text-lg md:text-xl font-bold text-slate-900">
                                            Laporan Tahunan &amp; Laporan Keberlanjutan 2024
                                        </h3>
                                        <p class="text-xs md:text-sm text-slate-600 mt-1 leading-relaxed">
                                            Inovasi tanpa batas menuju ekosistem identitas dan pembayaran digital
                                            terintegrasi, serta pencatatan kinerja keuangan yang solid di pasar domestik dan
                                            ekspor.
                                        </p>
                                    </div>

                                    {{-- Stat Highlight Pill Box --}}
                                    <div
                                        class="grid grid-cols-3 gap-3 bg-white p-3.5 rounded-xl border border-slate-200/80 shadow-xs">
                                        <div class="text-center sm:text-left">
                                            <span
                                                class="text-[10px] uppercase font-semibold text-slate-400 block">Pendapatan</span>
                                            <span class="text-sm font-extrabold text-slate-900 block">Rp2,11 T</span>
                                            <span class="text-[10px] text-emerald-600 font-bold">+16.2% YoY</span>
                                        </div>
                                        <div class="text-center sm:text-left border-x border-slate-100 px-3">
                                            <span class="text-[10px] uppercase font-semibold text-slate-400 block">Laba
                                                Bersih</span>
                                            <span class="text-sm font-extrabold text-slate-900 block">Rp237,8 M</span>
                                            <span class="text-[10px] text-emerald-600 font-bold">+9.1% YoY</span>
                                        </div>
                                        <div class="text-center sm:text-left">
                                            <span class="text-[10px] uppercase font-semibold text-slate-400 block">Dividen
                                                Final</span>
                                            <span class="text-sm font-extrabold text-slate-900 block">Rp14,50</span>
                                            <span class="text-[10px] text-slate-500 font-semibold">per saham</span>
                                        </div>
                                    </div>

                                    <div class="pt-2 flex flex-wrap items-center gap-3">
                                        <a href="{{ asset('assets/documents/annual-report-2024.pdf') }}" target="_blank"
                                            download
                                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0099ff] hover:bg-[#0080d6] text-white text-xs md:text-sm font-semibold rounded-xl shadow-sm shadow-[#0099ff]/30 transition-all">
                                            <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i> Unduh Laporan Tahunan
                                            (PDF)
                                        </a>
                                        <button type="button"
                                            onclick="alert('Laporan Tahunan 2024 lengkap telah tersedia untuk diunduh.')"
                                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 text-xs md:text-sm font-semibold rounded-xl transition-all">
                                            <i class="fa-regular fa-eye text-xs text-slate-500"></i> Ringkasan Eksekutif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Featured Annual Report Display 2023 --}}
                        <div id="annual-card-2023"
                            class="annual-report-card hidden bg-gradient-to-br from-slate-50 to-white border border-slate-200/90 rounded-2xl p-6 md:p-7 shadow-sm">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-7 items-center">
                                {{-- 3D Book Cover --}}
                                <div class="md:col-span-4 flex justify-center">
                                    <div
                                        class="book-3d w-44 sm:w-48 h-64 rounded-xl relative overflow-hidden bg-gradient-to-br from-[#1b2a47] via-[#243b61] to-[#2c4975] text-white p-5 flex flex-col justify-between border-l-4 border-cyan-400">
                                        <div
                                            class="flex justify-between items-center text-[10px] text-white/70 font-semibold tracking-wider">
                                            <span>ANNUAL REPORT</span>
                                            <span
                                                class="px-1.5 py-0.5 rounded bg-white/10 text-white font-mono">2023</span>
                                        </div>
                                        <div class="my-auto text-center">
                                            <div
                                                class="text-[9px] uppercase tracking-widest text-cyan-300 font-semibold mb-1">
                                                PT JASUINDO TIGA PERKASA TBK</div>
                                            <div
                                                class="text-base font-serif font-extrabold tracking-tight text-white leading-tight">
                                                Resilience &amp; Growth</div>
                                            <div class="w-8 h-0.5 bg-cyan-400 mx-auto my-2 rounded"></div>
                                            <div class="text-[10px] text-white/80 italic">Delivering Enduring Value</div>
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
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-1.5">
                                            <i class="fa-solid fa-circle-check text-emerald-500"></i> Audit: WTP
                                        </span>
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-[#0099ff] border border-blue-200">
                                            Bilingual (ID / EN)
                                        </span>
                                        <span class="text-xs text-slate-400 font-medium">Rilis: 22 April 2024</span>
                                    </div>

                                    <div>
                                        <h3 class="text-lg md:text-xl font-bold text-slate-900">
                                            Laporan Tahunan 2023
                                        </h3>
                                        <p class="text-xs md:text-sm text-slate-600 mt-1 leading-relaxed">
                                            Pencapaian pertumbuhan pendapatan signifikan yang didorong oleh transformasi
                                            digital dan peningkatan utilitas fasilitas produksi manufaktur modern.
                                        </p>
                                    </div>

                                    {{-- Stat Highlight Pill Box --}}
                                    <div
                                        class="grid grid-cols-3 gap-3 bg-white p-3.5 rounded-xl border border-slate-200/80 shadow-xs">
                                        <div class="text-center sm:text-left">
                                            <span
                                                class="text-[10px] uppercase font-semibold text-slate-400 block">Pendapatan</span>
                                            <span class="text-sm font-extrabold text-slate-900 block">Rp1,82 T</span>
                                            <span class="text-[10px] text-emerald-600 font-bold">+23.0% YoY</span>
                                        </div>
                                        <div class="text-center sm:text-left border-x border-slate-100 px-3">
                                            <span class="text-[10px] uppercase font-semibold text-slate-400 block">Laba
                                                Bersih</span>
                                            <span class="text-sm font-extrabold text-slate-900 block">Rp218,0 M</span>
                                            <span class="text-[10px] text-emerald-600 font-bold">+32.1% YoY</span>
                                        </div>
                                        <div class="text-center sm:text-left">
                                            <span class="text-[10px] uppercase font-semibold text-slate-400 block">Dividen
                                                Final</span>
                                            <span class="text-sm font-extrabold text-slate-900 block">Rp12,00</span>
                                            <span class="text-[10px] text-slate-500 font-semibold">per saham</span>
                                        </div>
                                    </div>

                                    <div class="pt-2 flex flex-wrap items-center gap-3">
                                        <a href="{{ asset('assets/documents/annual-report-2023.pdf') }}" target="_blank"
                                            download
                                            class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#0099ff] hover:bg-[#0080d6] text-white text-xs md:text-sm font-semibold rounded-xl shadow-sm shadow-[#0099ff]/30 transition-all">
                                            <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i> Unduh Laporan Tahunan
                                            (PDF)
                                        </a>
                                        <button type="button"
                                            onclick="alert('Laporan Tahunan 2023 lengkap telah tersedia untuk diunduh.')"
                                            class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 text-xs md:text-sm font-semibold rounded-xl transition-all">
                                            <i class="fa-regular fa-eye text-xs text-slate-500"></i> Ringkasan Eksekutif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ========================================== --}}
                        {{-- SECTION 3: LAPORAN KEUANGAN TRIWULANAN --}}
                        {{-- ========================================== --}}


                        {{-- ========================================== --}}
                        {{-- SECTION 4: RINGKASAN KINERJA KEUANGAN (5 TAHUN) --}}
                        {{-- ========================================== --}}

                        {{-- ========================================== --}}
                        {{-- SECTION 5: BOTTOM BANNER / CTA --}}
                        {{-- ========================================== --}}
                    </div>

                    <div id="laporan-triwulanan"
                        class="scroll-mt-28 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8">
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
                                        {{ $currentLocale === 'en' ? 'Periodic quarterly financial statements audited and reviewed.' : 'Laporan keuangan triwulanan perusahaan yang diaudit dan dipublikasikan.' }}
                                    </p>
                                </div>
                            </div>

                            {{-- Year Dropdown Filter --}}
                            <div class="flex items-center gap-2">
                                <label for="quarterYearSelect"
                                    class="text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                    {{ $currentLocale === 'en' ? 'Year:' : 'Tahun:' }}
                                </label>
                                <select id="quarterYearSelect" onchange="filterQuarterReport(this.value)"
                                    class="px-3 py-1.5 text-xs md:text-sm font-semibold text-slate-700 bg-[#EEF4FF] border border-slate-300 rounded-xl outline-none focus:border-[#0099ff] focus:ring-1 focus:ring-[#0099ff] cursor-pointer">
                                    <option value="2026" selected>2026</option>
                                    <option value="2025">2025</option>
                                    <option value="2024">2024</option>
                                </select>
                            </div>
                        </div>

                        {{-- 4 Quarter Cards Grid: 2026 --}}
                        <div id="quarter-grid-2026"
                            class="quarter-report-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            {{-- Q1 --}}
                            <div
                                class="report-card bg-[#EEF4FF] border border-slate-200 rounded-2xl p-5 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <div
                                            class="w-9 h-9 rounded-xl bg-blue-600 text-white font-extrabold flex items-center justify-center text-xs shadow-sm">
                                            Q1
                                        </div>
                                        <span
                                            class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-white text-[#0051D5]">
                                            Rilis Resmi
                                        </span>
                                    </div>
                                    <h4 class="font-bold text-slate-900 text-sm mb-1">Triwulan I 2026</h4>
                                    <p class="text-xs text-slate-500 mb-3">Per 31 Maret 2026</p>
                                </div>
                                <div>
                                    <div
                                        class="pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs text-[#45464D] mb-3">
                                        <span>Status:</span>
                                        <span class="text-black font-semibold">Unaudited</span>
                                    </div>
                                    <a href="{{ asset('assets/documents/laporan-q1-2026.pdf') }}" target="_blank"
                                        download
                                        class="w-full flex items-center justify-center gap-1.5 py-2 bg-white hover:bg-[#0080d6] text-[#0051D5] hover:text-white text-xs font-semibold rounded-xl shadow-xs transition-all">
                                        <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i> Unduh PDF
                                    </a>
                                </div>
                            </div>

                            {{-- Q2 --}}
                            <div
                                class="report-card bg-[#EEF4FF] border border-slate-200 rounded-2xl p-5 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <div
                                            class="w-9 h-9 rounded-xl bg-blue-600 text-white font-extrabold flex items-center justify-center text-xs shadow-sm">
                                            Q2
                                        </div>
                                        <span
                                            class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-white text-[#0051D5]">
                                            Review
                                        </span>
                                    </div>
                                    <h4 class="font-bold text-slate-900 text-sm mb-1">Triwulan II 2026</h4>
                                    <p class="text-xs text-slate-500 mb-3">Per 30 Juni 2026</p>
                                </div>
                                <div>
                                    <div
                                        class="pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs text-[#45464D] mb-3">
                                        <span>Status:</span>
                                        <span class="text-black font-semibold">Unreviewed</span>
                                    </div>
                                    <a href="{{ asset('assets/documents/laporan-q2-2026.pdf') }}" target="_blank"
                                        download
                                        class="w-full flex items-center justify-center gap-1.5 py-2 bg-white hover:bg-[#0080d6] text-[#0051D5] hover:text-white text-xs font-semibold rounded-xl shadow-xs transition-all">
                                        <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i> Unduh PDF
                                    </a>
                                </div>
                            </div>

                            {{-- Q3 --}}
                            <div
                                class="bg-[#EEF4FF] border border-slate-200/70 rounded-2xl p-5 flex flex-col justify-between opacity-80">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <div
                                            class="w-9 h-9 rounded-xl bg-slate-200 text-slate-600 font-extrabold flex items-center justify-center text-xs">
                                            Q3
                                        </div>
                                        <span
                                            class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                            Okt 2026
                                        </span>
                                    </div>
                                    <h4 class="font-bold text-slate-700 text-sm mb-1">Triwulan III 2026</h4>
                                    <p class="text-xs text-slate-400 mb-3">Per 30 September 2026</p>
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

                            {{-- Q4 / Audit --}}
                            <div
                                class="bg-[#EEF4FF] border border-slate-200/70 rounded-2xl p-5 flex flex-col justify-between opacity-80">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <div
                                            class="w-9 h-9 rounded-xl bg-slate-200 text-slate-600 font-extrabold flex items-center justify-center text-xs">
                                            Q4
                                        </div>
                                        <span
                                            class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">
                                            Mar 2027
                                        </span>
                                    </div>
                                    <h4 class="font-bold text-slate-700 text-sm mb-1">Tahunan Audit 2026</h4>
                                    <p class="text-xs text-slate-400 mb-3">Audit Penuh 2026</p>
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
                        </div>

                        {{-- 4 Quarter Cards Grid: 2025 --}}
                        <div id="quarter-grid-2025"
                            class="quarter-report-grid hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach (['I' => ['tgl' => '31 Maret 2025', 'badge' => 'Audit', 'badgeColor' => 'bg-emerald-100 text-emerald-800', 'size' => '4.1 MB'], 'II' => ['tgl' => '30 Juni 2025', 'badge' => 'Review', 'badgeColor' => 'bg-blue-100 text-blue-800', 'size' => '4.4 MB'], 'III' => ['tgl' => '30 September 2025', 'badge' => 'Review', 'badgeColor' => 'bg-blue-100 text-blue-800', 'size' => '4.6 MB'], 'IV' => ['tgl' => '31 Desember 2025', 'badge' => 'Audit', 'badgeColor' => 'bg-emerald-100 text-emerald-800', 'size' => '5.2 MB']] as $q => $item)
                                <div
                                    class="report-card bg-slate-50/70 border border-slate-200 rounded-2xl p-5 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-3">
                                            <div
                                                class="w-9 h-9 rounded-xl bg-blue-600 text-white font-extrabold flex items-center justify-center text-xs shadow-sm">
                                                Q{{ $loop->iteration }}
                                            </div>
                                            <span
                                                class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $item['badgeColor'] }}">
                                                {{ $item['badge'] }}
                                            </span>
                                        </div>
                                        <h4 class="font-bold text-slate-900 text-sm mb-1">Triwulan {{ $q }}
                                            2025</h4>
                                        <p class="text-xs text-slate-500 mb-3">Per {{ $item['tgl'] }}</p>
                                    </div>
                                    <div>
                                        <div
                                            class="pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs text-slate-400 mb-3">
                                            <span>PDF &bull; {{ $item['size'] }}</span>
                                            <span class="text-emerald-600 font-semibold">Tersedia</span>
                                        </div>
                                        <a href="{{ asset('assets/documents/laporan-q' . $loop->iteration . '-2025.pdf') }}"
                                            target="_blank" download
                                            class="w-full flex items-center justify-center gap-1.5 py-2 bg-white hover:bg-[#0080d6] text-white text-xs font-semibold rounded-xl shadow-xs transition-all">
                                            <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i> Unduh PDF
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- 4 Quarter Cards Grid: 2024 --}}
                        <div id="quarter-grid-2024"
                            class="quarter-report-grid hidden grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach (['I' => ['tgl' => '31 Maret 2024', 'badge' => 'Audit', 'badgeColor' => 'bg-emerald-100 text-emerald-800', 'size' => '3.8 MB'], 'II' => ['tgl' => '30 Juni 2024', 'badge' => 'Review', 'badgeColor' => 'bg-blue-100 text-blue-800', 'size' => '4.2 MB'], 'III' => ['tgl' => '30 September 2024', 'badge' => 'Review', 'badgeColor' => 'bg-blue-100 text-blue-800', 'size' => '4.3 MB'], 'IV' => ['tgl' => '31 Desember 2024', 'badge' => 'Audit', 'badgeColor' => 'bg-emerald-100 text-emerald-800', 'size' => '4.9 MB']] as $q => $item)
                                <div
                                    class="report-card bg-slate-50/70 border border-slate-200 rounded-2xl p-5 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center justify-between mb-3">
                                            <div
                                                class="w-9 h-9 rounded-xl bg-blue-600 text-white font-extrabold flex items-center justify-center text-xs shadow-sm">
                                                Q{{ $loop->iteration }}
                                            </div>
                                            <span
                                                class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $item['badgeColor'] }}">
                                                {{ $item['badge'] }}
                                            </span>
                                        </div>
                                        <h4 class="font-bold text-slate-900 text-sm mb-1">Triwulan {{ $q }}
                                            2024</h4>
                                        <p class="text-xs text-slate-500 mb-3">Per {{ $item['tgl'] }}</p>
                                    </div>
                                    <div>
                                        <div
                                            class="pt-3 border-t border-slate-200/80 flex items-center justify-between text-xs text-slate-400 mb-3">
                                            <span>PDF &bull; {{ $item['size'] }}</span>
                                            <span class="text-emerald-600 font-semibold">Tersedia</span>
                                        </div>
                                        <a href="{{ asset('assets/documents/laporan-q' . $loop->iteration . '-2024.pdf') }}"
                                            target="_blank" download
                                            class="w-full flex items-center justify-center gap-1.5 py-2 bg-white hover:bg-[#0080d6] text-white text-xs font-semibold rounded-xl shadow-xs transition-all">
                                            <i class="fa-solid fa-arrow-down-to-bracket text-xs"></i> Unduh PDF
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div id="ringkasan-kinerja"
                        class="scroll-mt-28 bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 md:p-8">
                        <div
                            class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 mb-6 border-b border-slate-100">
                            <div class="flex items-start gap-3.5">
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-50 text-[#0099ff] flex items-center justify-center text-lg flex-shrink-0">
                                    <i class="fa-solid fa-chart-column"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">
                                        {{ $currentLocale === 'en' ? '5-Year Financial Summary' : 'Ringkasan Kinerja Keuangan' }}
                                    </h2>
                                    <p class="text-xs md:text-sm text-slate-500 mt-1">
                                        {{ $pengaturanKinerja->Subjudul ?? ($currentLocale === 'en' ? 'Summary of core financial metrics of the company over the past 5 years.' : 'Ringkasan kinerja keuangan utama perusahaan selama 5 tahun terakhir (2021 - 2025).') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Toggle Mode: Grafik / Tabel --}}
                            <div
                                class="inline-flex p-1 bg-slate-100 rounded-xl border border-slate-200 self-start sm:self-auto">
                                <button type="button" id="btnViewChart" onclick="switchFinancialView('chart')"
                                    class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all bg-white text-slate-900 shadow-xs">
                                    <i class="fa-solid fa-chart-simple text-xs text-[#0099ff]"></i>
                                    {{ $currentLocale === 'en' ? 'Chart' : 'Grafik' }}
                                </button>
                                <button type="button" id="btnViewTable" onclick="switchFinancialView('table')"
                                    class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold transition-all text-slate-600 hover:text-slate-900">
                                    <i class="fa-solid fa-table text-xs text-slate-400"></i>
                                    {{ $currentLocale === 'en' ? 'Table' : 'Tabel' }}
                                </button>
                            </div>
                        </div>

                        {{-- 1. GRAFIK VIEW (2 BAR CHARTS - DYNAMIC) --}}
                        <div id="financialChartView" class="space-y-6">
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

                        {{-- 2. TABEL LENGKAP TAHUNAN (DYNAMIC RELASIONAL CMS) --}}
                        <div id="financialTableView"
                            class="hidden overflow-hidden rounded-2xl border border-slate-200 mt-2">
                            <div class="overflow-x-auto table-scrollbar">
                                <table class="w-full text-left text-xs text-slate-700 divide-y divide-slate-200">
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
                document.querySelectorAll('.annual-report-card').forEach(card => card.classList.add('hidden'));
                const target = document.getElementById('annual-card-' + year);
                if (target) {
                    target.classList.remove('hidden');
                }
            }

            // Filter Quarterly Reports by Year
            function filterQuarterReport(year) {
                document.querySelectorAll('.quarter-report-grid').forEach(grid => grid.classList.add('hidden'));
                const target = document.getElementById('quarter-grid-' + year);
                if (target) {
                    target.classList.remove('hidden');
                }
            }

            // Toggle between Chart view & Table view
            function switchFinancialView(mode) {
                const chartView = document.getElementById('financialChartView');
                const tableView = document.getElementById('financialTableView');
                const btnChart = document.getElementById('btnViewChart');
                const btnTable = document.getElementById('btnViewTable');

                if (mode === 'chart') {
                    chartView.classList.remove('hidden');
                    tableView.classList.add('hidden');
                    btnChart.classList.add('bg-white', 'text-slate-900', 'shadow-xs');
                    btnChart.classList.remove('text-slate-600');
                    btnTable.classList.remove('bg-white', 'text-slate-900', 'shadow-xs');
                    btnTable.classList.add('text-slate-600');
                } else {
                    chartView.classList.add('hidden');
                    tableView.classList.remove('hidden');
                    btnTable.classList.add('bg-white', 'text-slate-900', 'shadow-xs');
                    btnTable.classList.remove('text-slate-600');
                    btnChart.classList.remove('bg-white', 'text-slate-900', 'shadow-xs');
                    btnChart.classList.add('text-slate-600');
                }
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
                        const sectionTop = section.offsetTop - 150;
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

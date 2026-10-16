@extends('frontend.index')

@push('styles')
    <style>
        .custom-sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .custom-sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .custom-sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
@endpush

@section('content-frontend')
    @include('frontend.investor.partials.hero-tabs')

    <section class="py-12 bg-[#f8f9ff]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- LEFT STICKY SIDEBAR -->
                <div class="lg:col-span-4 xl:col-span-3">
                    <div class="sticky top-[160px] space-y-6 max-h-[calc(100vh-180px)] overflow-y-auto custom-sidebar-scroll pr-1">
                        <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 p-5">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                            <span class="text-[11px] font-bold text-slate-500 tracking-wider uppercase">
                                {{ __('investor.on_this_page') }}
                            </span>
                            <i class="fa-solid fa-bars-staggered text-slate-400 text-xs"></i>
                        </div>

                        <nav class="space-y-1.5" id="investor-sidebar-nav">
                            <a href="#struktur-kepemilikan"
                                class="flex items-start gap-3 p-2.5 rounded-lg bg-blue-50 text-[#0051d5] font-semibold text-xs transition-colors sidebar-nav-link"
                                data-target="struktur-kepemilikan">
                                <span class="text-xs font-bold w-5">01</span>
                                <div>
                                    <p class="text-xs font-bold leading-tight">{{ __('investor.nav_ownership') }}</p>
                                    <p class="text-[11px] font-normal text-slate-500 mt-0.5">
                                        {{ __('investor.nav_ownership_desc') }}</p>
                                </div>
                            </a>

                            <a href="#pemegang-saham-utama"
                                class="flex items-start gap-3 p-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-xs transition-colors sidebar-nav-link"
                                data-target="pemegang-saham-utama">
                                <span class="text-xs font-bold text-slate-400 w-5">02</span>
                                <div>
                                    <p class="text-xs font-semibold leading-tight">{{ __('investor.nav_controlling') }}</p>
                                    <p class="text-[11px] font-normal text-slate-500 mt-0.5">
                                        {{ __('investor.nav_controlling_desc') }}</p>
                                </div>
                            </a>

                            <a href="#entitas-anak"
                                class="flex items-start gap-3 p-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-xs transition-colors sidebar-nav-link"
                                data-target="entitas-anak">
                                <span class="text-xs font-bold text-slate-400 w-5">03</span>
                                <div>
                                    <p class="text-xs font-semibold leading-tight">{{ __('investor.nav_subsidiaries') }}</p>
                                    <p class="text-[11px] font-normal text-slate-500 mt-0.5">
                                        {{ __('investor.nav_subsidiaries_desc') }}</p>
                                </div>
                            </a>
                        </nav>

                        <div
                            class="mt-6 pt-4 border-t border-slate-100 bg-sky-50/60 rounded-lg p-3 text-xs text-sky-900 border border-sky-100">
                            <div class="flex items-center gap-2 font-bold mb-1 text-sky-800">
                                <i class="fa-solid fa-shield-halved text-sky-600"></i>
                                {{ __('investor.bei_ojk_title') }}
                            </div>
                            <p class="text-[11px] text-sky-700 leading-relaxed">
                                {{ __('investor.bei_ojk_desc') }}
                            </p>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT CONTENT AREA -->
                <div class="lg:col-span-8 xl:col-span-9 space-y-12">

                    <!-- SECTION 01: STRUKTUR KEPEMILIKAN -->
                    <section id="struktur-kepemilikan" class="scroll-mt-40">
                        <div class="mb-4">
                            <span
                                class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                {{ __('investor.ownership_badge') }}
                            </span>
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                                {{ __('investor.ownership_title') }}
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div
                                class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase block mb-1">
                                        {{ __('investor.ownership_domestic') }}
                                    </span>
                                    <span class="text-2xl font-bold text-[#0051d5]">{{ $totalNasionalPersen }}%</span>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        {{ number_format($totalNasionalSaham, 0, ',', '.') }}
                                        {{ __('investor.unit_shares') }}</p>
                                </div>
                                <div
                                    class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-[#0051d5]">
                                    <i class="fa-solid fa-flag text-sm"></i>
                                </div>
                            </div>
                            <div
                                class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase block mb-1">
                                        {{ __('investor.ownership_foreign') }}
                                    </span>
                                    <span class="text-2xl font-bold text-indigo-600">{{ $totalAsingPersen }}%</span>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        {{ number_format($totalAsingSaham, 0, ',', '.') }}
                                        {{ __('investor.unit_shares') }}</p>
                                </div>
                                <div
                                    class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                                    <i class="fa-solid fa-globe text-sm"></i>
                                </div>
                            </div>
                            <div
                                class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase block mb-1">
                                        {{ __('investor.ownership_total_paid') }}
                                    </span>
                                    <span class="text-2xl font-bold text-emerald-600">100,00%</span>
                                    <p class="text-xs text-slate-500 mt-0.5">
                                        {{ number_format($totalModalDisetor, 0, ',', '.') }}
                                        {{ __('investor.unit_shares') }}</p>
                                </div>
                                <div
                                    class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                                    <i class="fa-solid fa-check text-sm"></i>
                                </div>
                            </div>
                        </div>

                        <!-- FITUR FILTER STRUKTUR KEPEMILIKAN -->
                        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/80 mb-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Filter:</span>
                                    <div class="inline-flex p-1 bg-slate-100 rounded-xl border border-slate-200 gap-1" id="filter-ownership-btns">
                                        <button type="button" data-filter="all"
                                            class="filter-ownership-btn px-3 py-1 rounded-lg text-xs font-bold transition-all bg-[#0099ff] text-white shadow-2xs">
                                            Semua
                                        </button>
                                        <button type="button" data-filter="nasional"
                                            class="filter-ownership-btn px-3 py-1 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all">
                                            Pemodal Nasional
                                        </button>
                                        <button type="button" data-filter="asing"
                                            class="filter-ownership-btn px-3 py-1 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all">
                                            Pemodal Asing
                                        </button>
                                    </div>
                                </div>
                                <div class="relative w-full sm:w-64">
                                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                    <input type="text" id="search-ownership" placeholder="Cari kategori pemegang saham..."
                                        class="w-full pl-8 pr-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-700 focus:bg-white focus:border-[#0099ff] outline-none transition-all">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                            <div class="overflow-x-auto">
                                <table id="ownership-table" class="w-full text-xs text-left">
                                    <thead
                                        class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                                        <tr>
                                            <th class="py-3.5 px-6">{{ __('investor.th_shareholder') }}</th>
                                            <th class="py-3.5 px-6 text-right">{{ __('investor.th_shares') }}</th>
                                            <th class="py-3.5 px-6 text-right">{{ __('investor.th_ownership') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100">
                                        <tr class="ownership-group-header group-nasional bg-slate-50/50 font-bold text-slate-900">
                                            <td colspan="3" class="py-2.5 px-6 text-xs text-[#0051d5]">
                                                A. {{ __('investor.ownership_domestic') }}
                                            </td>
                                        </tr>
                                        @foreach ($strukturNasional as $item)
                                            <tr class="ownership-row group-nasional hover:bg-slate-50/60 transition-colors" data-group="nasional" data-name="{{ strtolower($item->KategoriPemegang) }}">
                                                <td class="py-3 px-6 pl-10 text-slate-700">{{ $item->KategoriPemegang }}</td>
                                                <td class="py-3 px-6 text-right font-medium text-slate-900">
                                                    {{ number_format($item->JumlahSaham, 0, ',', '.') }}</td>
                                                <td class="py-3 px-6 text-right text-slate-600">
                                                    {{ number_format($item->Persentase, 2, ',', '.') }}%</td>
                                            </tr>
                                        @endforeach
                                        <tr class="ownership-subtotal group-nasional bg-blue-50/40 font-bold text-slate-900">
                                            <td class="py-2.5 px-6 pl-10">{{ __('investor.subtotal_domestic') }}</td>
                                            <td class="py-2.5 px-6 text-right text-[#0051d5]">
                                                {{ number_format($totalNasionalSaham, 0, ',', '.') }}</td>
                                            <td class="py-2.5 px-6 text-right text-[#0051d5]">
                                                {{ number_format($totalNasionalPersen, 2, ',', '.') }}%</td>
                                        </tr>

                                        <tr class="ownership-group-header group-asing bg-slate-50/50 font-bold text-slate-900">
                                            <td colspan="3" class="py-2.5 px-6 text-xs text-indigo-700">
                                                B. {{ __('investor.ownership_foreign') }}
                                            </td>
                                        </tr>
                                        @foreach ($strukturAsing as $item)
                                            <tr class="ownership-row group-asing hover:bg-slate-50/60 transition-colors" data-group="asing" data-name="{{ strtolower($item->KategoriPemegang) }}">
                                                <td class="py-3 px-6 pl-10 text-slate-700">{{ $item->KategoriPemegang }}</td>
                                                <td class="py-3 px-6 text-right font-medium text-slate-900">
                                                    {{ number_format($item->JumlahSaham, 0, ',', '.') }}</td>
                                                <td class="py-3 px-6 text-right text-slate-600">
                                                    {{ number_format($item->Persentase, 2, ',', '.') }}%</td>
                                            </tr>
                                        @endforeach
                                        <tr class="ownership-subtotal group-asing bg-indigo-50/40 font-bold text-slate-900">
                                            <td class="py-2.5 px-6 pl-10">{{ __('investor.subtotal_foreign') }}</td>
                                            <td class="py-2.5 px-6 text-right text-indigo-700">
                                                {{ number_format($totalAsingSaham, 0, ',', '.') }}</td>
                                            <td class="py-2.5 px-6 text-right text-indigo-700">
                                                {{ number_format($totalAsingPersen, 2, ',', '.') }}%</td>
                                        </tr>

                                        <tr class="bg-[#0b1c30] text-white font-bold text-xs">
                                            <td class="py-3.5 px-6 uppercase tracking-wider">
                                                {{ __('investor.ownership_total_paid') }}</td>
                                            <td class="py-3.5 px-6 text-right">
                                                {{ number_format($totalModalDisetor, 0, ',', '.') }}</td>
                                            <td class="py-3.5 px-6 text-right">100,00%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 02: PEMEGANG SAHAM UTAMA -->
                    <section id="pemegang-saham-utama" class="scroll-mt-40">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                            <div>
                                <span
                                    class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                    {{ __('investor.controlling_badge') }}
                                </span>
                                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                                    {{ __('investor.controlling_title') }}
                                </h2>
                            </div>
                            @if ($skema->PathFilePdf)
                                <a href="{{ asset('storage/' . $skema->PathFilePdf) }}" target="_blank"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 text-[#0051d5] font-semibold text-xs rounded-xl border border-slate-200 shadow-sm transition-colors self-start">
                                    <i class="fa-solid fa-file-pdf text-red-500"></i>
                                    {{ __('investor.controlling_download') }}
                                </a>
                            @endif
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
                            @if ($skema->PathGambar)
                                <div class="w-full rounded-xl overflow-hidden mb-4 border border-slate-100">
                                    <a href="{{ asset('storage/' . $skema->PathGambar) }}" class="glightbox block relative group cursor-zoom-in" data-gallery="pemegang-saham" data-title="{{ __('investor.controlling_title') }}">
                                        <img src="{{ asset('storage/' . $skema->PathGambar) }}"
                                            alt="{{ __('investor.controlling_title') }}"
                                            class="w-full h-auto object-contain max-h-[600px] mx-auto group-hover:opacity-95 transition-all">
                                        <div class="absolute bottom-3 right-3 bg-slate-900/75 hover:bg-slate-900 text-white text-xs px-3 py-1.5 rounded-lg flex items-center gap-1.5 shadow-md">
                                            <i class="fa-solid fa-magnifying-glass-plus"></i> Klik untuk Perbesar
                                        </div>
                                    </a>
                                </div>
                            @else
                                <div class="p-6 bg-slate-50/60 rounded-xl border border-slate-100 text-center">
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-w-4xl mx-auto mb-6">
                                        <div class="bg-[#0284c7] text-white p-3 rounded-lg shadow-sm">
                                            <span
                                                class="text-[10px] block opacity-80 uppercase tracking-wider">{{ __('investor.ctrl_controlling_owner') }}</span>
                                            <p class="font-bold text-xs mt-0.5">YONGKY WIJAYA</p>
                                            <span class="text-[11px] opacity-90">58,00%</span>
                                        </div>
                                        <div class="bg-[#0284c7] text-white p-3 rounded-lg shadow-sm">
                                            <span
                                                class="text-[10px] block opacity-80 uppercase tracking-wider">{{ __('investor.ctrl_shareholder') }}</span>
                                            <p class="font-bold text-xs mt-0.5">HJ. LINDA SURYAWATI</p>
                                            <span class="text-[11px] opacity-90">26,00%</span>
                                        </div>
                                        <div class="bg-[#0284c7] text-white p-3 rounded-lg shadow-sm">
                                            <span
                                                class="text-[10px] block opacity-80 uppercase tracking-wider">{{ __('investor.ctrl_shareholder') }}</span>
                                            <p class="font-bold text-xs mt-0.5">JIE LEOPOLD SUDARMO</p>
                                            <span class="text-[11px] opacity-90">16,00%</span>
                                        </div>
                                        <div class="bg-amber-600 text-white p-3 rounded-lg shadow-sm">
                                            <span
                                                class="text-[10px] block opacity-80 uppercase tracking-wider">{{ __('investor.ctrl_foreign_holding') }}</span>
                                            <p class="font-bold text-xs mt-0.5">TOYAH SECURITY CO., LTD</p>
                                            <span class="text-[11px] opacity-90">27,06%</span>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-center justify-center my-2">
                                        <div class="w-0.5 h-6 bg-slate-300"></div>
                                        <span
                                            class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-3 py-1 rounded-full border border-emerald-200">
                                            Yongky Wijaya 58% + Linda 26% + Jie 16% (100%)
                                        </span>
                                        <div class="w-0.5 h-6 bg-slate-300"></div>
                                    </div>

                                    <div class="max-w-md mx-auto bg-[#047857] text-white p-4 rounded-xl shadow-sm mb-4">
                                        <span
                                            class="text-[10px] uppercase tracking-wider opacity-80 block">{{ __('investor.ctrl_ubo') }}</span>
                                        <p class="font-bold text-sm md:text-base mt-0.5">PT JASUINDO MULTI INVESTAMA</p>
                                        <p class="text-xs opacity-90 mt-1">{{ __('investor.ctrl_ubo_desc') }}</p>
                                    </div>

                                    <div class="flex flex-col items-center justify-center my-2">
                                        <div class="w-0.5 h-6 bg-slate-300"></div>
                                        <span
                                            class="text-[11px] font-semibold text-slate-500">{{ __('investor.ctrl_holds') }}
                                            47,10% {{ __('investor.unit_shares') }}</span>
                                        <div class="w-0.5 h-6 bg-slate-300"></div>
                                    </div>

                                    <div
                                        class="max-w-xl mx-auto bg-[#0a557a] text-white p-5 rounded-2xl shadow-md border-2 border-white/20">
                                        <span
                                            class="text-[10px] uppercase tracking-widest text-sky-200 block font-bold">{{ __('investor.ctrl_listed_entity') }}</span>
                                        <h3 class="text-base md:text-xl font-bold mt-1">PT JASUINDO TIGA PERKASA TBK</h3>
                                        <p class="text-xs text-sky-100 mt-1">{{ __('investor.ctrl_stock_code') }}: JTPE
                                        </p>
                                    </div>

                                    <div class="flex flex-col items-center justify-center my-2">
                                        <div class="w-0.5 h-6 bg-slate-300"></div>
                                        <span
                                            class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">{{ __('investor.ctrl_subsidiaries_below') }}</span>
                                        <div class="w-0.5 h-6 bg-slate-300"></div>
                                    </div>

                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-2 max-w-5xl mx-auto">
                                        <div class="bg-[#1e1b4b] text-white p-2.5 rounded-lg text-center">
                                            <p class="text-[10px] font-bold truncate">PT Jasuindo Inf. Pratama</p>
                                            <span class="text-[10px] text-emerald-400 font-semibold">99,98%</span>
                                        </div>
                                        <div class="bg-[#1e1b4b] text-white p-2.5 rounded-lg text-center">
                                            <p class="text-[10px] font-bold truncate">PT Jasuindo Solusi Sec.</p>
                                            <span class="text-[10px] text-emerald-400 font-semibold">99,00%</span>
                                        </div>
                                        <div class="bg-[#1e1b4b] text-white p-2.5 rounded-lg text-center">
                                            <p class="text-[10px] font-bold truncate">PT Solusi Anak Mandiri</p>
                                            <span class="text-[10px] text-emerald-400 font-semibold">99,00%</span>
                                        </div>
                                        <div class="bg-[#1e1b4b] text-white p-2.5 rounded-lg text-center">
                                            <p class="text-[10px] font-bold truncate">PT Solusi Identitas</p>
                                            <span class="text-[10px] text-emerald-400 font-semibold">99,00%</span>
                                        </div>
                                        <div class="bg-[#1e1b4b] text-white p-2.5 rounded-lg text-center">
                                            <p class="text-[10px] font-bold truncate">PT Nusa Adidaya</p>
                                            <span class="text-[10px] text-emerald-400 font-semibold">98,00%</span>
                                        </div>
                                        <div class="bg-[#312e81] text-white p-2.5 rounded-lg text-center">
                                            <p class="text-[10px] font-bold truncate">PT Fauziando Tiga P.</p>
                                            <span class="text-[10px] text-amber-300 font-semibold">45,00%</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if ($skema->Keterangan)
                                <p
                                    class="text-xs text-slate-500 mt-4 italic leading-relaxed border-t border-slate-100 pt-3">
                                    <span class="font-semibold text-slate-700">{{ __('investor.note_label') }}:</span>
                                    {{ $skema->Keterangan }}
                                </p>
                            @endif
                        </div>
                    </section>

                    <!-- SECTION 03: ENTITAS ANAK PERUSAHAAN (TABEL LENGKAP & SORTABLE) -->
                    <section id="entitas-anak" class="scroll-mt-40">
                        <div class="mb-4">
                            <span
                                class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                {{ __('investor.subs_badge') }}
                            </span>
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                                {{ __('investor.subs_title') }}
                            </h2>
                            <p class="text-xs md:text-sm text-slate-500 mt-1">
                                {{ __('investor.subs_desc') }}
                            </p>
                        </div>

                        <!-- FILTER & SEARCH ENTITAS ANAK -->
                        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/80 mb-5">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="relative flex-1">
                                    <i
                                        class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                    <input type="text" id="search-entitas"
                                        placeholder="{{ __('investor.subs_search_placeholder') }}"
                                        class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-[#0099ff] focus:ring-2 focus:ring-blue-100 outline-none transition-all">
                                </div>
                                <div class="flex flex-wrap gap-1.5" id="filter-entitas-tabs">
                                    <button type="button" data-filter="all"
                                        class="filter-entitas-btn px-3 py-1.5 rounded-lg text-xs font-bold bg-[#0099ff] text-white transition-all shadow-2xs">
                                        {{ __('investor.subs_filter_all') }} ({{ $entitasAnak->count() }})
                                    </button>
                                    <button type="button" data-filter="Entitas Anak"
                                        class="filter-entitas-btn px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-all">
                                        {{ __('investor.subs_type_subsidiary') }}
                                        ({{ $entitasAnak->where('Tipe', 'Entitas Anak')->count() }})
                                    </button>
                                    <button type="button" data-filter="Perusahaan Asosiasi"
                                        class="filter-entitas-btn px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-all">
                                        {{ __('investor.subs_type_associate') }}
                                        ({{ $entitasAnak->where('Tipe', 'Perusahaan Asosiasi')->count() }})
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- TABEL ENTITAS ANAK PERUSAHAAN (SORTABLE) -->
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                            <div class="overflow-x-auto">
                                <table id="entitas-table" class="w-full text-xs text-left">
                                    <thead class="bg-slate-100 border-b border-slate-200 text-slate-700 font-bold uppercase tracking-wider text-[11px]">
                                        <tr>
                                            <th class="py-3.5 px-4 text-center w-12">#</th>
                                            <th class="py-3.5 px-4 min-w-[200px]">Nama Entitas</th>
                                            <th class="py-3.5 px-4 min-w-[120px]">Tipe Entitas</th>
                                            <th class="py-3.5 px-4 min-w-[150px]" title="Tahun resmi bergabung atau didirikan dalam kelompok usaha perseroan">
                                                Tahun Bergabung / Pendirian <i class="fa-solid fa-circle-info text-slate-400 text-[10px] ml-1"></i>
                                            </th>
                                            <th class="py-3.5 px-4 min-w-[120px]">Domisili</th>
                                            <th class="py-3.5 px-4 min-w-[220px]">Bidang Usaha</th>
                                            <th class="py-3.5 px-4 text-right min-w-[170px]">
                                                <button type="button" id="btnSortKepemilikan" onclick="toggleSortKepemilikan()"
                                                    class="inline-flex items-center gap-1.5 font-bold uppercase hover:text-[#0099ff] transition-colors focus:outline-none">
                                                    <span>Kepemilikan Saham</span>
                                                    <i id="sortIcon" class="fa-solid fa-sort text-xs text-slate-400"></i>
                                                </button>
                                            </th>
                                            <th class="py-3.5 px-4 text-center w-24">Tautan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="entitas-tbody" class="divide-y divide-slate-100">
                                        @forelse ($entitasAnak as $index => $anak)
                                            <tr class="entitas-table-row hover:bg-slate-50/70 transition-colors"
                                                data-name="{{ strtolower($anak->NamaEntitas) }}"
                                                data-type="{{ $anak->Tipe }}"
                                                data-bidang="{{ strtolower($anak->BidangUsaha) }}"
                                                data-persen="{{ (float)$anak->PersentaseKepemilikan }}">
                                                <td class="py-3.5 px-4 text-center text-slate-400 font-medium row-num">{{ $loop->iteration }}</td>
                                                <td class="py-3.5 px-4">
                                                    <span class="font-bold text-slate-900 block">{{ $anak->NamaEntitas }}</span>
                                                </td>
                                                <td class="py-3.5 px-4">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $anak->Tipe === 'Entitas Anak' ? 'bg-blue-50 text-[#0051d5] border border-blue-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                                        {{ $anak->Tipe === 'Entitas Anak' ? __('investor.subs_type_subsidiary') : __('investor.subs_type_associate') }}
                                                    </span>
                                                </td>
                                                <td class="py-3.5 px-4">
                                                    @if ($anak->TahunBergabung)
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-slate-100 text-slate-700 font-semibold text-[11px]">
                                                            <i class="fa-regular fa-calendar text-[10px] text-slate-400"></i>
                                                            Tahun {{ $anak->TahunBergabung }}
                                                        </span>
                                                    @else
                                                        <span class="text-slate-400">-</span>
                                                    @endif
                                                </td>
                                                <td class="py-3.5 px-4 text-slate-600">
                                                    <span class="inline-flex items-center gap-1">
                                                        <i class="fa-solid fa-location-dot text-slate-400 text-[10px]"></i>
                                                        {{ $anak->Lokasi ?? 'Indonesia' }}
                                                    </span>
                                                </td>
                                                <td class="py-3.5 px-4 text-slate-600 leading-relaxed">
                                                    {{ $anak->BidangUsaha }}
                                                </td>
                                                <td class="py-3.5 px-4 text-right">
                                                    <div class="flex items-center justify-end gap-2.5">
                                                        <span class="font-extrabold text-sm text-slate-900">
                                                            {{ number_format($anak->PersentaseKepemilikan, 2, ',', '.') }}%
                                                        </span>
                                                        <div class="w-16 bg-slate-100 h-2 rounded-full overflow-hidden hidden sm:block">
                                                            <div class="h-full rounded-full {{ $anak->PersentaseKepemilikan >= 50 ? 'bg-[#0099ff]' : 'bg-amber-500' }}"
                                                                style="width: {{ min(100, $anak->PersentaseKepemilikan) }}%"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="py-3.5 px-4 text-center">
                                                    @if ($anak->UrlWebsite)
                                                        <a href="{{ $anak->UrlWebsite }}" target="_blank"
                                                            class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-blue-50 text-[#0051d5] hover:bg-[#0099ff] hover:text-white transition-colors"
                                                            title="Kunjungi Website">
                                                            <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i>
                                                        </a>
                                                    @else
                                                        <span class="text-slate-300">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-8 text-slate-400">
                                                    Belum ada data entitas anak yang terdaftar.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                    <!-- BOTTOM CTA (TANPA TOMBOL HUBUNGI HUBUNGAN INVESTOR SESUAI REVISI UAT) -->
                    <div
                        class="bg-gradient-to-r from-[#0a557a] to-[#094e70] rounded-2xl p-8 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-md">
                        <div>
                            <h3 class="text-xl font-bold mb-1">{{ __('investor.cta_title') }}</h3>
                            <p class="text-xs md:text-sm text-sky-100 max-w-xl">{{ __('investor.cta_desc') }}</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('frontend.contact.index', ['locale' => app()->getLocale()]) }}"
                                class="px-6 py-2.5 rounded-xl bg-white text-[#0a557a] hover:bg-sky-50 font-bold text-xs transition-colors shadow-sm whitespace-nowrap">
                                {{ __('Contact Us') }}
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            let currentSortOrder = 'none'; // 'asc', 'desc', 'none'

            // Sort Entitas Anak by Kepemilikan Saham
            function toggleSortKepemilikan() {
                const tbody = document.getElementById('entitas-tbody');
                if (!tbody) return;

                const rows = Array.from(tbody.querySelectorAll('.entitas-table-row'));
                const icon = document.getElementById('sortIcon');

                if (currentSortOrder === 'none' || currentSortOrder === 'asc') {
                    currentSortOrder = 'desc';
                    icon.className = 'fa-solid fa-sort-down text-xs text-[#0099ff]';
                    rows.sort((a, b) => parseFloat(b.dataset.persen) - parseFloat(a.dataset.persen));
                } else {
                    currentSortOrder = 'asc';
                    icon.className = 'fa-solid fa-sort-up text-xs text-[#0099ff]';
                    rows.sort((a, b) => parseFloat(a.dataset.persen) - parseFloat(b.dataset.persen));
                }

                rows.forEach((row, idx) => {
                    tbody.appendChild(row);
                    const rowNum = row.querySelector('.row-num');
                    if (rowNum) rowNum.textContent = idx + 1;
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                // 1. FILTER & SEARCH STRUKTUR KEPEMILIKAN
                const ownershipFilterBtns = document.querySelectorAll('.filter-ownership-btn');
                const ownershipSearch = document.getElementById('search-ownership');
                const ownershipRows = document.querySelectorAll('.ownership-row');
                const headerNasional = document.querySelector('.ownership-group-header.group-nasional');
                const subtotalNasional = document.querySelector('.ownership-subtotal.group-nasional');
                const headerAsing = document.querySelector('.ownership-group-header.group-asing');
                const subtotalAsing = document.querySelector('.ownership-subtotal.group-asing');

                function filterOwnership() {
                    const query = ownershipSearch ? ownershipSearch.value.toLowerCase().trim() : '';
                    const activeBtn = document.querySelector('.filter-ownership-btn.bg-\\[\\#0099ff\\]');
                    const groupFilter = activeBtn ? activeBtn.getAttribute('data-filter') : 'all';

                    ownershipRows.forEach(row => {
                        const name = row.getAttribute('data-name') || '';
                        const group = row.getAttribute('data-group') || '';
                        const matchesQuery = !query || name.includes(query);
                        const matchesGroup = groupFilter === 'all' || group === groupFilter;

                        row.style.display = (matchesQuery && matchesGroup) ? '' : 'none';
                    });

                    // Hide headers & subtotals if that group is filtered out or if searching
                    if (headerNasional) headerNasional.style.display = (groupFilter === 'asing' || query) ? 'none' : '';
                    if (subtotalNasional) subtotalNasional.style.display = (groupFilter === 'asing' || query) ? 'none' : '';
                    if (headerAsing) headerAsing.style.display = (groupFilter === 'nasional' || query) ? 'none' : '';
                    if (subtotalAsing) subtotalAsing.style.display = (groupFilter === 'nasional' || query) ? 'none' : '';
                }

                ownershipFilterBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        ownershipFilterBtns.forEach(b => {
                            b.classList.remove('bg-[#0099ff]', 'text-white', 'shadow-2xs');
                            b.classList.add('text-slate-600');
                        });
                        this.classList.remove('text-slate-600');
                        this.classList.add('bg-[#0099ff]', 'text-white', 'shadow-2xs');
                        filterOwnership();
                    });
                });

                if (ownershipSearch) {
                    ownershipSearch.addEventListener('input', filterOwnership);
                }

                // 2. FILTER & SEARCH ENTITAS ANAK
                const filterBtns = document.querySelectorAll('.filter-entitas-btn');
                const searchInput = document.getElementById('search-entitas');
                const tableRows = document.querySelectorAll('.entitas-table-row');

                function filterEntitasList() {
                    const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
                    const activeBtn = document.querySelector('.filter-entitas-btn.bg-\\[\\#0099ff\\]');
                    const filterType = activeBtn ? activeBtn.getAttribute('data-filter') : 'all';

                    let visibleIndex = 1;
                    tableRows.forEach(row => {
                        const name = row.getAttribute('data-name') || '';
                        const type = row.getAttribute('data-type') || '';
                        const bidang = row.getAttribute('data-bidang') || '';
                        const matchesQuery = !query || name.includes(query) || bidang.includes(query);
                        const matchesType = filterType === 'all' || type === filterType;

                        if (matchesQuery && matchesType) {
                            row.style.display = '';
                            const numCol = row.querySelector('.row-num');
                            if (numCol) numCol.textContent = visibleIndex++;
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }

                filterBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        filterBtns.forEach(b => {
                            b.classList.remove('bg-[#0099ff]', 'text-white', 'shadow-2xs');
                            b.classList.add('text-slate-600');
                        });
                        this.classList.remove('text-slate-600');
                        this.classList.add('bg-[#0099ff]', 'text-white', 'shadow-2xs');
                        filterEntitasList();
                    });
                });

                if (searchInput) {
                    searchInput.addEventListener('input', filterEntitasList);
                }

                // 3. SCROLLSPY
                const navLinks = document.querySelectorAll('.sidebar-nav-link');
                const sections = document.querySelectorAll('section[id]');
                window.addEventListener('scroll', function() {
                    let current = '';
                    sections.forEach(section => {
                        const sectionTop = section.offsetTop - 175;
                        if (window.scrollY >= sectionTop) current = section.getAttribute('id');
                    });
                    navLinks.forEach(link => {
                        const target = link.getAttribute('data-target');
                        if (target === current) {
                            link.classList.add('bg-blue-50', 'text-[#0051d5]', 'font-semibold');
                            link.classList.remove('text-slate-700');
                        } else {
                            link.classList.remove('bg-blue-50', 'text-[#0051d5]', 'font-semibold');
                            link.classList.add('text-slate-700');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection

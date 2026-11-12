@extends('frontend.index')

@php
    $cLocale = app()->getLocale();
    $siteName = $websiteSettings->NamaPerusahaan ?? 'PT Jasuindo Tiga Perkasa Tbk';
    $govTitle = ($cLocale === 'en' ? 'Good Corporate Governance (GCG)' : 'Tata Kelola Perusahaan (GCG)') . ' - ' . $siteName;
    $govDesc = $cLocale === 'en'
        ? 'Corporate governance framework, board charters, code of conduct, and whistleblowing system of PT Jasuindo Tiga Perkasa Tbk.'
        : 'Struktur tata kelola, piagam dewan, kode etik, dan sistem pelaporan pelanggaran (WBS) PT Jasuindo Tiga Perkasa Tbk.';
@endphp

@section('title', $govTitle)
@section('meta_description', $govDesc)

@section('content-frontend')
    @php
        $locale = app()->getLocale();
        $en = $locale === 'en';

        $tr = function ($model, $field) use ($locale) {
            if (!$model) {
                return null;
            }
            if (method_exists($model, 'translate')) {
                $t = $model->translate($locale);
                if ($t && !empty($t->$field)) {
                    return $t->$field;
                }
            }
            $enField = $field . 'En';
            if ($locale === 'en' && !empty($model->$enField)) {
                return $model->$enField;
            }
            return $model->$field;
        };
    @endphp

    @include('frontend.investor.partials.hero-tabs')
@push('styles')
<style>
    /* Sticky Sidebar */
    .sticky-sidebar {
        position: sticky;
        top: 160px;
        max-height: calc(100vh - 180px);
        overflow-y: auto;
    }

    /* Custom scrollbar untuk sidebar */
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

    /* Offset untuk anchor links agar teks tidak tertutup sticky header */
    section[id], div[id].scroll-target {
        scroll-margin-top: 180px !important;
    }
</style>
@endpush
    <!-- ========================================== -->
    <!-- MAIN CONTENT SECTION -->
    <!-- ========================================== -->
    <section class="py-10 bg-[#f8fafc] min-h-screen">
        <div class="container mx-auto max-w-[1420px] px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <!-- ========================================== -->
                <!-- LEFT STICKY SIDEBAR -->
                <!-- ========================================== -->
                <div class="lg:col-span-3">
                    <div class="sticky top-[160px] space-y-5 max-h-[calc(100vh-180px)] overflow-y-auto custom-sidebar-scroll pr-1">
                        <!-- Sidebar Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-5">
                            <div class="flex items-center gap-2.5 pb-3.5 mb-2 border-b border-slate-100">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#0099ff] flex items-center justify-center text-sm">
                                    <i class="fa-solid fa-list-ul"></i>
                                </div>
                                <h3 class="font-bold text-slate-800 text-sm tracking-tight">
                                    {{ __('investor.on_this_page') }}
                                </h3>
                            </div>

                            <nav class="space-y-1.5" id="sidebar-nav">
                                <a href="#bagan-manajemen"
                                    class="sidebar-link active group flex items-center justify-between px-3.5 py-2.5 text-xs md:text-sm text-[#45464D] rounded-xl transition-all duration-200 hover:bg-blue-50 hover:text-[#0099ff] hover:translate-x-1.5 aria-[current=true]:bg-blue-50 aria-[current=true]:text-[#0099ff] aria-[current=true]:translate-x-1.5 aria-[current=true]:font-semibold"
                                    aria-current="true">
                                    <span class="flex items-center gap-2.5">
                                        <i class="fa-solid fa-sitemap w-4 text-center text-slate-400 group-hover:text-[#0099ff] [.active_&]:text-[#0099ff]"></i>
                                        {{ __('gcg.nav_chart') }}
                                    </span>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 group-hover:text-[#0099ff] group-hover:translate-x-0.5 [.active_&]:text-[#0099ff] transition-transform"></i>
                                </a>

                                <a href="#dokumen-gcg"
                                    class="sidebar-link group flex items-center justify-between px-3.5 py-2.5 text-xs md:text-sm text-[#45464D] rounded-xl transition-all duration-200 hover:bg-blue-50 hover:text-[#0099ff] hover:translate-x-1.5 aria-[current=true]:bg-blue-50 aria-[current=true]:text-[#0099ff] aria-[current=true]:translate-x-1.5 aria-[current=true]:font-semibold">
                                    <span class="flex items-center gap-2.5">
                                        <i class="fa-regular fa-file-lines w-4 text-center text-[#45464D] group-hover:text-[#0099ff] [.active_&]:text-[#0099ff]"></i>
                                        {{ __('gcg.nav_docs') }}
                                    </span>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 group-hover:text-[#0099ff] group-hover:translate-x-0.5 [.active_&]:text-[#0099ff] transition-transform"></i>
                                </a>

                                <a href="#rups"
                                    class="sidebar-link group flex items-center justify-between px-3.5 py-2.5 text-xs md:text-sm text-[#45464D] rounded-xl transition-all duration-200 hover:bg-blue-50 hover:text-[#0099ff] hover:translate-x-1.5 aria-[current=true]:bg-blue-50 aria-[current=true]:text-[#0099ff] aria-[current=true]:translate-x-1.5 aria-[current=true]:font-semibold">
                                    <span class="flex items-center gap-2.5">
                                        <i class="fa-solid fa-users-rectangle w-4 text-center text-[#45464D] group-hover:text-[#0099ff] [.active_&]:text-[#0099ff]"></i>
                                        {{ __('gcg.nav_rups') }}
                                    </span>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 group-hover:text-[#0099ff] group-hover:translate-x-0.5 [.active_&]:text-[#0099ff] transition-transform"></i>
                                </a>

                                <a href="#komite-wbs"
                                    class="sidebar-link group flex items-center justify-between px-3.5 py-2.5 text-xs md:text-sm text-[#45464D] rounded-xl transition-all duration-200 hover:bg-blue-50 hover:text-[#0099ff] hover:translate-x-1.5 aria-[current=true]:bg-blue-50 aria-[current=true]:text-[#0099ff] aria-[current=true]:translate-x-1.5 aria-[current=true]:font-semibold">
                                    <span class="flex items-center gap-2.5">
                                        <i class="fa-solid fa-shield-halved w-4 text-center text-[#45464D] group-hover:text-[#0099ff] [.active_&]:text-[#0099ff]"></i>
                                        {{ __('gcg.nav_audit') }}
                                    </span>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 group-hover:text-[#0099ff] group-hover:translate-x-0.5 [.active_&]:text-[#0099ff] transition-transform"></i>
                                </a>
                            </nav>

                            <!-- Contact Corporate Secretary Box -->
                            @php
                                $emailSekretariat = $kantor?->HubunganInvestorEmail ?: ($kantor?->AlamatEmail ?: $bagan->EmailSekretariat);
                                $teleponSekretariat = $kantor?->NomorTelepon ?: $bagan->TeleponSekretariat;
                            @endphp
                            @if (!empty($emailSekretariat) || !empty($teleponSekretariat))
                                <div class="mt-4 pt-3.5 border-t border-slate-100 bg-slate-50 rounded-xl p-3.5 text-xs text-slate-700">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1.5">
                                        {{ __('gcg.corp_sec_label') }}
                                    </span>
                                    <p class="text-[11px] text-slate-500 mb-2 leading-relaxed">
                                        {{ __('gcg.corp_sec_desc') }}
                                    </p>
                                    <div class="space-y-1.5 text-xs">
                                        @if (!empty($emailSekretariat))
                                            <a href="mailto:{{ $emailSekretariat }}"
                                                class="flex items-center gap-2 text-[#0099ff] font-semibold hover:underline">
                                                <i class="fa-regular fa-envelope text-[11px]"></i> {{ $emailSekretariat }}
                                            </a>
                                        @endif
                                        @if (!empty($teleponSekretariat))
                                            <p class="flex items-center gap-2 text-slate-600">
                                                <i class="fa-solid fa-phone text-[11px] text-slate-400"></i>
                                                {{ $teleponSekretariat }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- RIGHT CONTENT AREA -->
                <!-- ========================================== -->
                <div class="lg:col-span-9 space-y-12">

                    <!-- SECTION 01: BAGAN & MANAJEMEN -->
                    <section id="bagan-manajemen" class="scroll-mt-40">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                            <div>
                                <span
                                    class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                    {{ __('gcg.s1_badge') }}
                                </span>
                                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                                    {{ __('gcg.s1_title') }}
                                </h2>
                                <p class="text-xs md:text-sm text-slate-500 mt-1 max-w-2xl">
                                    {{ $bagan->Keterangan ?? __('gcg.s1_desc_default') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2 self-start">
                                @if ($bagan->TanggalDiperbarui)
                                    <span
                                        class="text-[11px] font-medium text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg whitespace-nowrap">
                                        <i class="fa-regular fa-calendar mr-1"></i> {{ __('gcg.updated_label') }}
                                        {{ $bagan->TanggalDiperbarui->isoFormat('D MMM YYYY') }}
                                    </span>
                                @endif
                                @if ($bagan->PathFilePdf)
                                    <a href="{{ asset('storage/' . $bagan->PathFilePdf) }}" target="_blank"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-slate-50 text-[#0051d5] font-semibold text-xs rounded-lg border border-slate-200 shadow-sm transition-colors whitespace-nowrap">
                                        <i class="fa-solid fa-download text-xs"></i> {{ __('gcg.download_pdf') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80 mb-8">
                            @if ($bagan->PathGambar)
                                <div class="w-full rounded-xl overflow-hidden border border-slate-100">
                                    <img src="{{ asset('storage/' . $bagan->PathGambar) }}" alt="{{ __('gcg.s1_title') }}"
                                        class="w-full h-auto object-contain max-h-[500px] mx-auto">
                                </div>
                            @else
                                <div class="p-6 bg-slate-50/60 rounded-xl border border-slate-100 text-center">
                                    <div class="max-w-xs mx-auto bg-[#0a557a] text-white p-3.5 rounded-xl shadow-sm mb-4">
                                        <span
                                            class="text-[10px] uppercase tracking-widest text-sky-200 block font-bold">{{ __('gcg.diag_top_label') }}</span>
                                        <h4 class="font-bold text-sm">{{ __('gcg.diag_rups') }}</h4>
                                    </div>
                                    <div class="w-0.5 h-6 bg-slate-300 mx-auto"></div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl mx-auto my-2">
                                        <div class="bg-sky-50 border border-sky-200 p-4 rounded-xl text-left">
                                            <div class="flex items-center justify-between mb-1">
                                                <span
                                                    class="text-[10px] font-bold text-sky-700 uppercase">{{ __('gcg.diag_supervision') }}</span>
                                                <span
                                                    class="text-[10px] bg-sky-200 text-sky-900 px-2 py-0.5 rounded font-bold">{{ __('gcg.diag_independent') }}</span>
                                            </div>
                                            <h4 class="font-bold text-slate-900 text-sm">{{ __('gcg.diag_commissioners') }}
                                            </h4>
                                            <p class="text-[11px] text-slate-500 mt-1">
                                                {{ __('gcg.diag_commissioners_desc') }}</p>
                                            <div class="mt-2 pt-2 border-t border-sky-100 text-[11px] text-sky-800">
                                                {{ __('gcg.diag_committees') }}</div>
                                        </div>
                                        <div class="bg-[#0b1c30] text-white p-4 rounded-xl text-left">
                                            <div class="flex items-center justify-between mb-1">
                                                <span
                                                    class="text-[10px] font-bold text-sky-300 uppercase">{{ __('gcg.diag_executive') }}</span>
                                                <span
                                                    class="text-[10px] bg-slate-800 text-slate-200 px-2 py-0.5 rounded font-bold">{{ __('gcg.diag_operational') }}</span>
                                            </div>
                                            <h4 class="font-bold text-white text-sm">{{ __('gcg.diag_directors') }}</h4>
                                            <p class="text-[11px] text-slate-300 mt-1">{{ __('gcg.diag_directors_desc') }}
                                            </p>
                                            <div class="mt-2 pt-2 border-t border-slate-700 text-[11px] text-slate-300">
                                                {{ __('gcg.diag_directors_units') }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                                <div>
                                    <span
                                        class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                        {{ __('gcg.leadership_badge') }}
                                    </span>
                                    <h3 class="text-xl font-bold text-slate-900 mt-1">{{ __('gcg.leadership_title') }}</h3>
                                </div>
                                <div class="flex gap-1.5 bg-slate-100 p-1 rounded-xl self-start">
                                    <button type="button" id="tab-komisaris-btn"
                                        class="px-3.5 py-1.5 rounded-lg text-xs font-bold bg-white text-[#0051d5] shadow-sm transition-all">
                                        {{ __('gcg.tab_commissioners') }} ({{ $komisaris->count() }})
                                    </button>
                                    <button type="button" id="tab-direksi-btn"
                                        class="px-3.5 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all">
                                        {{ __('gcg.tab_directors') }} ({{ $direksi->count() }})
                                    </button>
                                </div>
                            </div>

                            <div id="grid-komisaris" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach ($komisaris as $person)
                                    <div
                                        class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 flex flex-col justify-between hover:shadow-md transition-shadow">
                                        <div>
                                            <div class="flex items-center gap-3 mb-3">
                                                @if ($person->Foto)
                                                    <img src="{{ asset('storage/' . $person->Foto) }}"
                                                        alt="{{ $person->Nama }}"
                                                        class="w-12 h-12 rounded-full object-cover border border-slate-200">
                                                @else
                                                    <div
                                                        class="w-12 h-12 rounded-full bg-blue-100 text-[#0051d5] font-bold flex items-center justify-center text-sm">
                                                        {{ strtoupper(substr($person->Nama, 0, 2)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <h4 class="font-bold text-slate-900 text-sm leading-tight">
                                                        {{ $person->Nama }}</h4>
                                                    <span
                                                        class="text-[11px] font-bold text-[#0051d5] uppercase tracking-wider block mt-0.5">{{ $person->Jabatan }}</span>
                                                </div>
                                            </div>
                                            <!-- REVISI 1: Deskripsi utuh tanpa line-clamp -->
                                            <p class="text-xs text-slate-500 leading-relaxed mb-4">
                                                {{ $person->DeskripsiSingkat }}
                                            </p>
                                        </div>
                                        <button type="button"
                                            class="btn-profil-modal inline-flex items-center gap-1.5 text-xs font-bold text-[#0051d5] hover:underline pt-3 border-t border-slate-100"
                                            data-nama="{{ $person->Nama }}" data-jabatan="{{ $person->Jabatan }}"
                                            data-kategori="{{ __($person->Kategori) }}"
                                            data-foto="{{ $person->Foto ? asset('storage/' . $person->Foto) : '' }}"
                                            data-bio="{{ $person->ProfilLengkap ?? $person->DeskripsiSingkat }}">
                                            {{ __('gcg.read_full_profile') }} <i
                                                class="fa-solid fa-chevron-right text-[10px]"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <div id="grid-direksi" class="grid grid-cols-1 md:grid-cols-3 gap-4 hidden">
                                @foreach ($direksi as $person)
                                    <div
                                        class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 flex flex-col justify-between hover:shadow-md transition-shadow">
                                        <div>
                                            <div class="flex items-center gap-3 mb-3">
                                                @if ($person->Foto)
                                                    <img src="{{ asset('storage/' . $person->Foto) }}"
                                                        alt="{{ $person->Nama }}"
                                                        class="w-12 h-12 rounded-full object-cover border border-slate-200">
                                                @else
                                                    <div
                                                        class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-sm">
                                                        {{ strtoupper(substr($person->Nama, 0, 2)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <h4 class="font-bold text-slate-900 text-sm leading-tight">
                                                        {{ $person->Nama }}</h4>
                                                    <span
                                                        class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider block mt-0.5">{{ $person->Jabatan }}</span>
                                                </div>
                                            </div>
                                            <!-- REVISI 1: Deskripsi utuh tanpa line-clamp -->
                                            <p class="text-xs text-slate-500 leading-relaxed mb-4">
                                                {{ $person->DeskripsiSingkat }}
                                            </p>
                                        </div>
                                        <button type="button"
                                            class="btn-profil-modal inline-flex items-center gap-1.5 text-xs font-bold text-[#0051d5] hover:underline pt-3 border-t border-slate-100"
                                            data-nama="{{ $person->Nama }}" data-jabatan="{{ $person->Jabatan }}"
                                            data-kategori="{{ __($person->Kategori) }}"
                                            data-foto="{{ $person->Foto ? asset('storage/' . $person->Foto) : '' }}"
                                            data-bio="{{ $person->ProfilLengkap ?? $person->DeskripsiSingkat }}">
                                            {{ __('gcg.read_full_profile') }} <i
                                                class="fa-solid fa-chevron-right text-[10px]"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 02: DOKUMEN TATA KELOLA -->
                    <section id="dokumen-gcg" class="scroll-mt-40">
                        <div class="mb-4">
                            <span
                                class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                {{ __('gcg.s2_badge') }}
                            </span>
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                                {{ __('gcg.s2_title') }}
                            </h2>
                            <p class="text-xs md:text-sm text-slate-500 mt-1">{{ __('gcg.s2_desc') }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                            @foreach ($dokumenGcg as $doc)
                                <div
                                    class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex flex-col justify-between hover:border-[#0099ff] hover:shadow-md transition-all">
                                    <div>
                                        <div class="flex items-start justify-between mb-3">
                                            <div
                                                class="w-9 h-9 rounded-lg bg-blue-50 text-[#0051d5] flex items-center justify-center text-sm">
                                                <i class="fa-solid fa-file-shield"></i>
                                            </div>
                                            @if ($doc->FileSize)
                                                <span
                                                    class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded">
                                                    PDF ({{ $doc->FileSize }})
                                                </span>
                                            @endif
                                        </div>
                                        <h4 class="font-bold text-slate-900 text-sm leading-snug mb-1">{{ $doc->Judul }}
                                        </h4>
                                        <!-- REVISI 1: Deskripsi utuh tanpa line-clamp -->
                                        @if ($doc->Deskripsi)
                                            <p class="text-xs text-slate-500 mb-4 leading-relaxed">{{ $doc->Deskripsi }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="pt-3 border-t border-slate-100 flex items-center justify-end">
                                        @if ($doc->PathFile)
                                            <a href="{{ asset('storage/' . $doc->PathFile) }}" target="_blank"
                                                class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0051d5] hover:text-blue-800 transition-colors">
                                                <i class="fa-solid fa-download text-xs"></i> {{ __('gcg.download') }}
                                            </a>
                                        @else
                                            <span
                                                class="text-[11px] text-slate-400 italic">{{ __('gcg.coming_soon') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
                            <h3 class="text-base font-bold text-slate-900 mb-4">
                                {{ __('gcg.s2_ops_title') }}
                            </h3>

                            <div class="space-y-3">
                                @foreach ($kebijakan as $idx => $keb)
                                    <!-- REVISI 2: Dibuat terbuka semua (static), bukan toggle/accordion -->
                                    <div class="border border-slate-200 rounded-xl overflow-hidden bg-slate-50/50">
                                        <div
                                            class="p-4 font-bold text-xs md:text-sm text-slate-800 flex items-center gap-3 border-b border-slate-200 bg-white">
                                            <i class="fa-solid fa-shield-halved text-[#0051d5]"></i>
                                            <span>{{ $keb->Judul }}</span>
                                        </div>
                                        <div class="px-4 py-4 text-xs text-slate-600">
                                            <p class="leading-relaxed mb-3">
                                                {{ $keb->Deskripsi ?? __('gcg.s2_ops_desc_default') }}
                                            </p>
                                            @if ($keb->PathFile)
                                                <a href="{{ asset('storage/' . $keb->PathFile) }}" target="_blank"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-[#0051d5] font-semibold text-xs hover:bg-blue-100 transition-colors">
                                                    <i class="fa-solid fa-file-pdf"></i>
                                                    {{ __('gcg.view_full_guideline') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 03: RUPS & RISALAH -->
                    <section id="rups" class="scroll-mt-40">
                        <div class="mb-4">
                            <span
                                class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                {{ __('gcg.s3_badge') }}
                            </span>
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                                {{ __('gcg.s3_title') }}
                            </h2>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 mb-6 border-b border-slate-100">
                                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    <span>{{ __('gcg.s3_docs_label') }} <span id="rups-year-label">{{ $selectedTahun }}</span></span>
                                </div>

                                {{-- Year Dropdown Filter untuk RUPS --}}
                                <div class="flex items-center gap-2">
                                    <label for="rupsYearSelect"
                                        class="text-xs font-semibold text-slate-500 uppercase tracking-wider whitespace-nowrap">
                                        {{ $en ? 'Year:' : 'Tahun:' }}
                                    </label>
                                    <div class="relative inline-block">
                                        <select id="rupsYearSelect" onchange="filterRups(this.value)"
                                            class="pl-4 pr-10 py-1.5 text-xs md:text-sm font-semibold text-slate-800 bg-[#EEF4FF] hover:bg-[#e1edff] border border-slate-300 rounded-xl outline-none focus:border-[#0099ff] focus:ring-1 focus:ring-[#0099ff] cursor-pointer appearance-none transition-colors">
                                            @foreach ($rupsTahun as $th)
                                                <option value="{{ $th }}" {{ $selectedTahun == $th ? 'selected' : '' }}>
                                                    {{ $th }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-500">
                                            <i class="fa-solid fa-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <!-- Container ini akan di-replace oleh JS saat filter -->
                                <div id="rups-list-container" class="space-y-3">
                                    @forelse($rupsDokumen as $item)
                                        <div
                                            class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-xl border border-slate-200/80 hover:border-[#0099ff] bg-white gap-3 transition-colors">
                                            <div class="flex items-start gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-lg bg-blue-50 text-[#0051d5] flex items-center justify-center flex-shrink-0 text-xs">
                                                    <i class="fa-regular fa-file-pdf"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-slate-900 text-xs md:text-sm leading-tight">
                                                        {{ $item->Judul }}</h4>
                                                    @if ($item->KategoriDokumen)
                                                        <span
                                                            class="text-[11px] text-slate-400">{{ $item->KategoriDokumen }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2 self-end sm:self-center">
                                                @if ($item->PathFile)
                                                    <a href="{{ asset('storage/' . $item->PathFile) }}" target="_blank"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 hover:bg-[#0099ff] text-slate-700 hover:text-white font-semibold text-xs border border-slate-200 transition-colors">
                                                        <i class="fa-solid fa-download text-xs"></i>
                                                        {{ __('gcg.download') }}
                                                    </a>
                                                @else
                                                    <span
                                                        class="text-xs text-slate-400 italic">{{ __('gcg.s3_not_uploaded') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-8 text-center bg-slate-50 rounded-xl text-slate-500 text-xs">
                                            {{ __('gcg.s3_empty') }} {{ $selectedTahun }}.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- SECTION 04: KOMITE AUDIT & WBS -->
                    <section id="komite-wbs" class="scroll-mt-40">
                        <div class="mb-4">
                            <span
                                class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                {{ __('gcg.s4_badge') }}
                            </span>
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                                {{ __('gcg.s4_title') }}
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80">
                                <div
                                    class="w-10 h-10 rounded-lg bg-blue-50 text-[#0051d5] flex items-center justify-center text-base mb-3">
                                    <i class="fa-solid fa-clipboard-check"></i>
                                </div>
                                <h3 class="font-bold text-slate-900 text-sm mb-1">{{ __('gcg.s4_internal_audit') }}</h3>
                                <p class="text-xs text-slate-500 leading-relaxed mb-4">
                                    {{ __('gcg.s4_internal_audit_desc') }}</p>
                                @php $piagamInternal = $komiteAudit->firstWhere('Kategori', 'Satuan Audit Internal'); @endphp
                                @if ($piagamInternal && $piagamInternal->PathFile)
                                    <a href="{{ asset('storage/' . $piagamInternal->PathFile) }}" target="_blank"
                                        class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0051d5] hover:underline">
                                        <i class="fa-solid fa-file-pdf"></i> {{ __('gcg.s4_internal_audit_charter') }}
                                    </a>
                                @endif
                            </div>

                            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80">
                                <div
                                    class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center text-base mb-3">
                                    <i class="fa-solid fa-user-check"></i>
                                </div>
                                <h3 class="font-bold text-slate-900 text-sm mb-1">{{ __('gcg.s4_audit_committee') }}</h3>
                                <p class="text-xs text-slate-500 leading-relaxed mb-4">
                                    {{ __('gcg.s4_audit_committee_desc') }}</p>
                                @php $piagamKomite = $komiteAudit->firstWhere('Kategori', 'Komite Audit'); @endphp
                                @if ($piagamKomite && $piagamKomite->PathFile)
                                    <a href="{{ asset('storage/' . $piagamKomite->PathFile) }}" target="_blank"
                                        class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-700 hover:underline">
                                        <i class="fa-solid fa-file-pdf"></i> {{ __('gcg.s4_audit_committee_charter') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- WBS Card -->
                        <div class="bg-[#032b43] text-white rounded-2xl p-6 md:p-8 shadow-md border border-[#004f7c]/40">
                            <div
                                class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-6 border-b border-cyan-800/40">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div
                                            class="w-7 h-7 rounded-lg bg-cyan-900/60 border border-cyan-500/30 flex items-center justify-center text-cyan-400 text-xs">
                                            <i class="fa-solid fa-lock"></i>
                                        </div>
                                        <span
                                            class="text-[10px] font-bold text-cyan-400 uppercase tracking-wider">{{ __('gcg.wbs_channel') }}</span>
                                    </div>
                                    <h3 class="text-2xl font-bold text-white">{{ __('gcg.wbs_title') }}</h3>
                                </div>
                                <div>
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-[10px] font-bold text-emerald-400 bg-emerald-950/60 border border-emerald-500/40">
                                        {{ __('gcg.wbs_protection') }}
                                    </span>
                                </div>
                            </div>

                            <p class="text-xs text-slate-300 leading-relaxed mb-6">{{ __('gcg.wbs_desc') }}</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs mb-6">
                                <div class="bg-[#063d5e]/50 p-4 rounded-xl border border-cyan-700/30">
                                    <span
                                        class="text-[10px] text-cyan-300/80 font-bold block uppercase tracking-wider mb-1">{{ __('gcg.wbs_physical') }}</span>
                                    <p class="font-bold text-white mt-0.5">{{ __('gcg.wbs_physical_org') }}</p>
                                    <p class="text-[11px] text-slate-300 mt-1">Jl. Raya Betro No. 21, Sedati, Sidoarjo
                                        61253</p>
                                </div>
                                <div class="bg-[#063d5e]/50 p-4 rounded-xl border border-cyan-700/30">
                                    <span
                                        class="text-[10px] text-cyan-300/80 font-bold block uppercase tracking-wider mb-1">{{ __('gcg.wbs_email_label') }}</span>
                                    <p class="text-[11px] text-slate-300 mt-0.5">{{ __('gcg.wbs_email_desc') }}</p>
                                    <a href="mailto:smap@jasuindo.com"
                                        class="font-bold text-cyan-400 hover:underline block mt-1">smap@jasuindo.com</a>
                                </div>
                            </div>

                            <div
                                class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-cyan-800/40">
                                <p class="text-[11px] text-slate-300">{{ __('gcg.wbs_footer_note') }}</p>
                                <button type="button" id="btn-open-wbs"
                                    class="w-full sm:w-auto py-2.5 px-6 bg-cyan-400 hover:bg-cyan-300 text-slate-950 font-bold text-xs rounded-full transition-colors shadow-sm text-center">
                                    {{ __('gcg.wbs_submit_btn') }}
                                </button>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </section>

    <!-- MODAL 1: PROFIL LENGKAP -->
    <div id="modal-profil"
        class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div
            class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 transform transition-all relative">
            <button type="button" id="close-profil-modal"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="flex items-center gap-4 pb-4 border-b border-slate-100 mb-4">
                <div id="modal-profil-foto-box"
                    class="w-16 h-16 rounded-full bg-blue-100 text-[#0051d5] font-bold flex items-center justify-center text-lg flex-shrink-0">
                    <span id="modal-profil-initial"></span>
                </div>
                <div>
                    <span id="modal-profil-kategori"
                        class="text-[10px] font-bold uppercase tracking-wider text-[#0051d5] bg-blue-50 px-2 py-0.5 rounded border border-blue-100"></span>
                    <h3 id="modal-profil-nama" class="text-lg font-bold text-slate-900 mt-1"></h3>
                    <p id="modal-profil-jabatan" class="text-xs text-slate-500 font-medium"></p>
                </div>
            </div>
            <div class="text-xs text-slate-700 leading-relaxed max-h-72 overflow-y-auto pr-2" id="modal-profil-bio"></div>
            <div class="mt-6 pt-4 border-t border-slate-100 text-right">
                <button type="button" id="close-profil-modal-btn"
                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold text-xs transition-colors">
                    {{ __('gcg.close') }}
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL 2: FORM WBS -->
    <div id="modal-wbs"
        class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div
            class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto relative">
            <button type="button" id="close-wbs-modal"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="mb-4 pb-3 border-b border-slate-100">
                <span
                    class="text-[10px] font-bold uppercase tracking-wider text-rose-600 bg-rose-50 px-2 py-0.5 rounded border border-rose-100">
                    {{ __('gcg.wbs_form_badge') }}
                </span>
                <h3 class="text-xl font-bold text-slate-900 mt-1">{{ __('gcg.wbs_form_title') }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ __('gcg.wbs_form_desc') }}</p>
            </div>
            <form id="form-wbs" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 mb-1">{{ __('gcg.wbs_cat_label') }} *</label>
                    <select name="KategoriPelanggaran" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                        <option value="">{{ __('gcg.wbs_cat_placeholder') }}</option>
                        <option value="Korupsi / Suap / Pemerasan">{{ __('gcg.wbs_cat_1') }}</option>
                        <option value="Kecurangan Finansial / Penggelapan Aset">{{ __('gcg.wbs_cat_2') }}</option>
                        <option value="Benturan Kepentingan (Conflict of Interest)">{{ __('gcg.wbs_cat_3') }}</option>
                        <option value="Pelanggaran Kerahasiaan Data / Dokumen Sekuriti">{{ __('gcg.wbs_cat_4') }}
                        </option>
                        <option value="Pelecehan / Diskriminasi di Lingkungan Kerja">{{ __('gcg.wbs_cat_5') }}</option>
                        <option value="Lainnya">{{ __('gcg.wbs_cat_6') }}</option>
                    </select>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">{{ __('gcg.wbs_reported_label') }}</label>
                        <input type="text" name="Terlapor" placeholder="{{ __('gcg.wbs_reported_ph') }}"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">{{ __('gcg.wbs_time_label') }}</label>
                        <input type="date" name="WaktuKejadian"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                    </div>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">{{ __('gcg.wbs_location_label') }}</label>
                    <input type="text" name="LokasiKejadian" placeholder="{{ __('gcg.wbs_location_ph') }}"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">{{ __('gcg.wbs_narrative_label') }} *</label>
                    <textarea name="UraianKejadian" rows="4" required placeholder="{{ __('gcg.wbs_narrative_ph') }}"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]"></textarea>
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">{{ __('gcg.wbs_attachment_label') }}</label>
                    <input type="file" name="BuktiFile" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx"
                        class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#0051d5] hover:file:bg-blue-100">
                    <p class="text-[10px] text-slate-400 mt-1">{{ __('gcg.wbs_attachment_note') }}</p>
                </div>
                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <span
                        class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-2">{{ __('gcg.wbs_reporter_label') }}</span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <input type="text" name="NamaPelapor" placeholder="{{ __('gcg.wbs_reporter_name_ph') }}"
                            class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs outline-none">
                        <input type="email" name="EmailPelapor" placeholder="{{ __('gcg.wbs_reporter_email_ph') }}"
                            class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs outline-none">
                    </div>
                </div>
                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" id="cancel-wbs-btn"
                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" id="submit-wbs-btn"
                        class="px-5 py-2 bg-sky-600 hover:bg-sky-500 text-white font-bold rounded-xl text-xs shadow-sm">
                        {{ __('gcg.wbs_submit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Toggle Komisaris / Direksi tabs
                const btnKomisaris = document.getElementById('tab-komisaris-btn');
                const btnDireksi = document.getElementById('tab-direksi-btn');
                const gridKomisaris = document.getElementById('grid-komisaris');
                const gridDireksi = document.getElementById('grid-direksi');

                if (btnKomisaris && btnDireksi) {
                    btnKomisaris.addEventListener('click', function() {
                        btnKomisaris.classList.add('bg-white', 'text-[#0051d5]', 'shadow-sm');
                        btnKomisaris.classList.remove('text-slate-600');
                        btnDireksi.classList.remove('bg-white', 'text-[#0051d5]', 'shadow-sm');
                        btnDireksi.classList.add('text-slate-600');
                        gridKomisaris.classList.remove('hidden');
                        gridDireksi.classList.add('hidden');
                    });

                    btnDireksi.addEventListener('click', function() {
                        btnDireksi.classList.add('bg-white', 'text-[#0051d5]', 'shadow-sm');
                        btnDireksi.classList.remove('text-slate-600');
                        btnKomisaris.classList.remove('bg-white', 'text-[#0051d5]', 'shadow-sm');
                        btnKomisaris.classList.add('text-slate-600');
                        gridDireksi.classList.remove('hidden');
                        gridKomisaris.classList.add('hidden');
                    });
                }

                // REVISI 2: Logic accordion dihapus karena sudah dibuat static/terbuka semua

                // Modal Profil
                const modalProfil = document.getElementById('modal-profil');
                const closeProfilBtns = [document.getElementById('close-profil-modal'), document.getElementById(
                    'close-profil-modal-btn')];
                document.querySelectorAll('.btn-profil-modal').forEach(btn => {
                    btn.addEventListener('click', function() {
                        document.getElementById('modal-profil-nama').innerText = this.getAttribute(
                            'data-nama');
                        document.getElementById('modal-profil-jabatan').innerText = this.getAttribute(
                            'data-jabatan');
                        document.getElementById('modal-profil-kategori').innerText = this.getAttribute(
                            'data-kategori');
                        document.getElementById('modal-profil-bio').innerHTML = this.getAttribute(
                            'data-bio').replace(/\n/g, '<br><br>');

                        const fotoBox = document.getElementById('modal-profil-foto-box');
                        const foto = this.getAttribute('data-foto');
                        const nama = this.getAttribute('data-nama');
                        if (foto) {
                            fotoBox.innerHTML =
                                `<img src="${foto}" class="w-full h-full rounded-full object-cover">`;
                        } else {
                            fotoBox.innerHTML = `<span>${nama.substring(0, 2).toUpperCase()}</span>`;
                        }
                        modalProfil.classList.remove('hidden');
                    });
                });
                closeProfilBtns.forEach(b => {
                    if (b) b.addEventListener('click', () => modalProfil.classList.add('hidden'));
                });

                // Modal WBS
                const modalWbs = document.getElementById('modal-wbs');
                const btnOpenWbs = document.getElementById('btn-open-wbs');
                const closeWbsBtns = [document.getElementById('close-wbs-modal'), document.getElementById(
                    'cancel-wbs-btn')];
                if (btnOpenWbs) btnOpenWbs.addEventListener('click', () => modalWbs.classList.remove('hidden'));
                closeWbsBtns.forEach(b => {
                    if (b) b.addEventListener('click', () => modalWbs.classList.add('hidden'));
                });

                // Submit WBS via Ajax
                const formWbs = document.getElementById('form-wbs');
                if (formWbs) {
                    formWbs.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const formData = new FormData(this);
                        const submitBtn = document.getElementById('submit-wbs-btn');
                        submitBtn.disabled = true;
                        submitBtn.innerText = '{{ __('gcg.wbs_sending') }}';

                        fetch("{{ \App\Services\LocalizedUrlService::route('frontend.investor.wbs.store') }}", {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                alert(data.message);
                                formWbs.reset();
                                modalWbs.classList.add('hidden');
                                submitBtn.disabled = false;
                                submitBtn.innerText = '{{ __('gcg.wbs_submit') }}';
                            })
                            .catch(err => {
                                alert('{{ __('gcg.wbs_error') }}');
                                submitBtn.disabled = false;
                                submitBtn.innerText = '{{ __('gcg.wbs_submit') }}';
                            });
                    });
                }

                // Smooth Filter RUPS dengan dropdown tanpa reload
                window.filterRups = function(tahun) {
                    const label = document.getElementById('rups-year-label');
                    if (label) label.innerText = tahun;

                    // 1. Tampilkan loading di container list
                    const container = document.getElementById('rups-list-container');
                    const originalContent = container ? container.innerHTML : '';
                    if (container) {
                        container.innerHTML = `
                            <div class="p-8 text-center bg-slate-50 rounded-xl">
                                <i class="fa-solid fa-circle-notch fa-spin text-2xl text-[#0099ff] mb-2"></i>
                                <p class="text-xs text-slate-500">${@json(__('Loading year data'))} ${tahun}...</p>
                            </div>`;
                    }

                    // 2. Fetch halaman saat ini dengan parameter tahun baru
                    const url = new URL(window.location.href);
                    url.searchParams.set('tahun_rups', tahun);
                    url.hash = '';

                    fetch(url.toString())
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newContainer = doc.getElementById('rups-list-container');

                            if (newContainer && container) {
                                container.innerHTML = newContainer.innerHTML;
                                window.history.pushState({}, '', url.toString() + '#rups');
                            } else if (container) {
                                container.innerHTML = originalContent;
                            }
                        })
                        .catch(() => {
                            if (container) container.innerHTML = originalContent;
                            alert(@json(__('Failed to load data. Please try again.')));
                        });
                };

                // SCROLLSPY & ACTIVE LINK
                const sidebarLinks = document.querySelectorAll('#sidebar-nav .sidebar-link');
                const sections = document.querySelectorAll('section[id], div[id]');

                function setActiveLink(activeLink) {
                    sidebarLinks.forEach(link => {
                        link.classList.remove('active');
                        link.removeAttribute('aria-current');
                    });
                    activeLink.classList.add('active');
                    activeLink.setAttribute('aria-current', 'true');
                }

                sidebarLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        setActiveLink(this);
                    });
                });

                window.addEventListener('scroll', function() {
                    let currentSectionId = '';
                    sections.forEach(section => {
                        const sectionTop = section.offsetTop - 195;
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

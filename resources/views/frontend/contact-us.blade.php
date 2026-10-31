@extends('frontend.index')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Custom Select2 Styling for Contact Form */
        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            background-color: #f8fafc !important; /* bg-slate-50 */
            border: 1px solid #e2e8f0 !important; /* border-slate-200 */
            border-radius: 0.75rem !important; /* rounded-xl */
            height: 52px !important;
            display: flex !important;
            align-items: center !important;
            padding-left: 2.75rem !important; /* space for icon */
            padding-right: 2.25rem !important;
            transition: all 0.2s ease !important;
        }

        .select2-container--default .select2-selection--single:focus,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #0284c7 !important;
            background-color: #ffffff !important;
            box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.1) !important;
            outline: none !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #334155 !important; /* text-slate-700 */
            font-size: 0.875rem !important; /* text-sm */
            line-height: normal !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #94a3b8 !important; /* text-slate-400 */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 50px !important;
            right: 12px !important;
            top: 0 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            position: absolute !important;
            right: 34px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            font-size: 1.15rem !important;
            color: #94a3b8 !important;
            cursor: pointer !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear:hover {
            color: #ef4444 !important;
        }

        .select2-dropdown {
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
            overflow: hidden !important;
            background-color: #ffffff !important;
            z-index: 9999 !important;
            margin-top: 4px !important;
        }

        .select2-search--dropdown {
            padding: 10px 12px !important;
            background-color: #f8fafc !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }

        .select2-search--dropdown .select2-search__field {
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.5rem !important;
            padding: 8px 12px !important;
            font-size: 0.875rem !important;
            outline: none !important;
            background-color: #ffffff !important;
            width: 100% !important;
        }

        .select2-search--dropdown .select2-search__field:focus {
            border-color: #0284c7 !important;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.1) !important;
        }

        .select2-results__group {
            font-size: 0.725rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            color: #0F2854 !important;
            background-color: #f1f5f9 !important;
            padding: 8px 14px !important;
            border-top: 1px solid #e2e8f0 !important;
        }

        .select2-results__group:first-child {
            border-top: none !important;
        }

        .select2-results__option {
            padding: 9px 16px !important;
            font-size: 0.875rem !important;
            color: #334155 !important;
            transition: all 0.15s ease !important;
        }

        .select2-results__option--highlighted[aria-selected] {
            background-color: #0F2854 !important;
            color: #ffffff !important;
        }

        .select2-results__option[aria-selected="true"] {
            background-color: #e2e8f0 !important;
            color: #0F2854 !important;
            font-weight: 600 !important;
        }

        .select2-results__option[aria-selected="true"].select2-results__option--highlighted {
            background-color: #0F2854 !important;
            color: #ffffff !important;
        }
    </style>
@endpush

@section('content-frontend')

    @php
        $locale = app()->getLocale();
        $en = $locale === 'en';
    @endphp

    <style>
        .contact-item {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .contact-item:hover {
            transform: translateX(4px);
        }

        .contact-item:hover .contact-icon-wrapper {
            background-color: #0284c7;
            transform: scale(1.1);
        }

        .contact-item:hover .contact-icon-wrapper i {
            color: white;
        }

        .social-icon {
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            transform: translateY(-3px);
        }

        .form-input {
            transition: all 0.3s ease;
        }

        .form-input:focus {
            box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.1);
        }

        .btn-loading .btn-text {
            display: none;
        }

        .btn-loading .btn-loader {
            display: inline-flex !important;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom .input-icon {
            transition: color 0.3s ease;
        }

        .input-group-custom input:focus~.input-icon,
        .input-group-custom textarea:focus~.input-icon,
        .input-group-custom select:focus~.input-icon {
            color: #0284c7;
        }

        .office-tab {
            transition: all 0.25s ease;
        }

        .office-tab.active {
            background-color: #0284c7;
            color: white;
            border-color: #0284c7;
        }

        .office-tab:not(.active):hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .map-iframe {
            transition: opacity 0.3s ease;
        }

        .map-embed iframe {
            width: 100% !important;
            height: 100% !important;
            min-height: 500px;
            border: 0 !important;
            display: block;
        }
    </style>

    <!-- HERO SECTION -->
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="https://images.unsplash.com/photo-1423666639041-f56000c27a9a?q=80&w=2070&auto=format&fit=crop"
                alt="Contact Background" class="w-full h-full object-cover">
        </div>
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>
        <div
            class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <span
                    class="inline-block py-1.5 px-4 rounded-full bg-brand-500/20 text-brand-100 text-sm font-semibold tracking-wide mb-6 border border-brand-500/30 backdrop-blur-sm">
                    <i class="fa-solid fa-envelope-open-text mr-2"></i> {{ __('Get In Touch') }}
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                    {{ __('Contact Us') }}
                </h1>
                <p class="text-xl text-slate-300 max-w-2xl mx-auto">
                    {{ __('We are ready to help you. Our team will respond within 1x24 working hours.') }}
                </p>

                <nav class="mt-8 flex items-center justify-center space-x-2 text-sm text-slate-300">
                    <a href="{{ route('frontend.main') }}" class="hover:text-white transition-colors">
                        <i class="fa-solid fa-house mr-1"></i> {{ __('Home') }}
                    </a>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                    <span class="text-white font-semibold">{{ __('Contact Us') }}</span>
                </nav>
            </div>
        </div>
    </section>

    <!-- QUICK CONTACT CARDS (pakai data kantor utama) -->
    @if ($kantorUtama)
        <section class="relative -mt-12 z-20">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Call --}}
                    <div
                        class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 hover:shadow-2xl transition-all group">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 w-14 h-14 bg-brand-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-brand-600 transition-colors">
                                <i
                                    class="fa-solid fa-headphones-simple text-brand-600 text-xl group-hover:text-white transition-colors"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">
                                    {{ __('Call Us') }}</p>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $kantorUtama->NomorTelepon ?? '+62318910919') }}"
                                    class="text-lg font-bold text-slate-900 hover:text-brand-600 transition-colors block truncate">
                                    {{ $kantorUtama->NomorTelepon ?? '+62 31 8910919' }}
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Email --}}
                    <div
                        class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 hover:shadow-2xl transition-all group">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-green-600 transition-colors">
                                <i
                                    class="fa-solid fa-envelope text-green-600 text-xl group-hover:text-white transition-colors"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">
                                    {{ __('Email Us') }}</p>
                                <a href="mailto:{{ $kantorUtama->AlamatEmail ?? 'info@jasuindo.co.id' }}"
                                    class="text-lg font-bold text-slate-900 hover:text-green-600 transition-colors block truncate">
                                    {{ $kantorUtama->AlamatEmail ?? 'info@jasuindo.co.id' }}
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- WhatsApp --}}
                    <div
                        class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 hover:shadow-2xl transition-all group">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-emerald-600 transition-colors">
                                <i
                                    class="fa-brands fa-whatsapp text-emerald-600 text-xl group-hover:text-white transition-colors"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">WhatsApp</p>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $kantorUtama->NomorWhatsApp ?? '6281234567890') }}"
                                    target="_blank"
                                    class="text-lg font-bold text-slate-900 hover:text-emerald-600 transition-colors block truncate">
                                    {{ $kantorUtama->NomorWhatsApp ?? '+62 812-3456-7890' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- MAIN CONTENT -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12">

                <!-- LEFT: CONTACT INFORMATION -->
                <div class="lg:col-span-2">
                    <div
                        class="bg-gradient-to-br from-brand-900 via-brand-800 to-brand-950 rounded-3xl p-8 text-white sticky top-24 shadow-2xl relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 w-64 h-64 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -mr-32 -mt-32">
                        </div>
                        <div
                            class="absolute bottom-0 left-0 w-64 h-64 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 -ml-32 -mb-32">
                        </div>

                        <div class="relative z-10">
                            <div class="mb-6">
                                <span
                                    class="inline-block py-1 px-3 rounded-full bg-brand-500/20 text-brand-100 text-xs font-semibold tracking-wide mb-4 border border-brand-500/30">
                                    {{ __('WORK WITH US') }}
                                </span>
                                <h2 class="text-3xl font-extrabold mb-4">{{ __('Contact Information') }}</h2>
                                <p class="text-slate-300 leading-relaxed text-sm">
                                    {{ __('Thank you for your interest in Jasuindo. We are excited to hear from you and discuss how we can help your organization\'s digital transformation.') }}
                                </p>
                            </div>

                            {{-- Office Tabs --}}
                            @if ($kantor->count() > 1)
                                <div class="mb-6">
                                    <p
                                        class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-3 flex items-center">
                                        <i class="fa-solid fa-building mr-2"></i>
                                        {{ $en ? 'Select Office' : 'Pilih Kantor' }}
                                    </p>
                                    <div class="flex flex-wrap gap-2" id="officeTabs">
                                        @foreach ($kantor as $index => $k)
                                            <button type="button"
                                                class="office-tab px-3.5 py-2 rounded-lg text-xs font-semibold border border-white/20 transition-all flex items-center gap-2 {{ $index === 0 ? 'active' : 'text-slate-200' }}"
                                                data-office-index="{{ $index }}" data-nama="{{ $k->NamaKantor }}"
                                                data-tipe="{{ $k->TipeKantor }}" data-alamat="{{ $k->AlamatLengkap }}"
                                                data-kota="{{ $k->Kota }}" data-provinsi="{{ $k->Provinsi }}"
                                                data-kodepos="{{ $k->KodePos }}" data-maps="{{ $k->TautanGoogleMaps }}"
                                                data-embed="{{ $k->EmbedGoogleMaps }}" data-telp="{{ $k->NomorTelepon }}"
                                                data-telp-clean="{{ preg_replace('/[^0-9+]/', '', $k->NomorTelepon ?? '') }}"
                                                data-wa="{{ $k->NomorWhatsApp }}"
                                                data-wa-clean="{{ preg_replace('/[^0-9]/', '', $k->NomorWhatsApp ?? '') }}"
                                                data-email="{{ $k->AlamatEmail }}" {{-- TAMBAHAN DATA BARU DI SINI --}}
                                                data-ir-nama="{{ $k->HubunganInvestorNama }}"
                                                data-ir-jabatan="{{ $k->HubunganInvestorJabatan }}"
                                                data-ir-email="{{ $k->HubunganInvestorEmail }}"
                                                data-ekspor-nama="{{ $k->PasarEksporNama }}"
                                                data-ekspor-jabatan="{{ $k->PasarEksporJabatan }}"
                                                data-ekspor-email="{{ $k->PasarEksporEmail }}">

                                                <i class="fa-solid fa-location-dot text-[10px]"></i>
                                                {{ $k->NamaKantor }}
                                                @if ($k->TipeKantor === 'Pusat')
                                                    <span
                                                        class="text-[9px] px-1.5 py-0.5 bg-brand-500/30 rounded-full">{{ $en ? 'HQ' : 'Pusat' }}</span>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="space-y-5" id="officeDetails">
                                @if ($kantor->count() > 0)
                                    @php $active = $kantor->first(); @endphp

                                    {{-- Phone --}}
                                    <div class="contact-item flex items-start group cursor-pointer">
                                        <div
                                            class="contact-icon-wrapper flex-shrink-0 w-12 h-12 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center mr-4 transition-all">
                                            <i
                                                class="fa-solid fa-headphones-simple text-brand-400 text-lg transition-colors"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">
                                                {{ __('Call Us For Query') }}</p>
                                            <a id="detailTelp"
                                                href="tel:{{ preg_replace('/[^0-9+]/', '', $active->NomorTelepon ?? '+62318910919') }}"
                                                class="text-white font-semibold hover:text-brand-400 transition-colors block">
                                                {{ $active->NomorTelepon ?? '+62 31 8910919 (Hunting)' }}
                                            </a>
                                        </div>
                                    </div>

                                    {{-- WhatsApp --}}
                                    <div class="contact-item flex items-start group cursor-pointer">
                                        <div
                                            class="contact-icon-wrapper flex-shrink-0 w-12 h-12 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center mr-4 transition-all">
                                            <i
                                                class="fa-brands fa-whatsapp text-emerald-400 text-lg transition-colors"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">
                                                WhatsApp</p>
                                            <a id="detailWa"
                                                href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $active->NomorWhatsApp ?? '6281234567890') }}"
                                                target="_blank"
                                                class="text-white font-semibold hover:text-emerald-400 transition-colors block">
                                                {{ $active->NomorWhatsApp ?? '+62 812-3456-7890' }}
                                            </a>
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="contact-item flex items-start group cursor-pointer">
                                        <div
                                            class="contact-icon-wrapper flex-shrink-0 w-12 h-12 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center mr-4 transition-all">
                                            <i class="fa-solid fa-envelope text-brand-400 text-lg transition-colors"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">
                                                {{ __('Email Us Anytime') }}</p>
                                            <a id="detailEmail"
                                                href="mailto:{{ $active->AlamatEmail ?? 'info@jasuindo.co.id' }}"
                                                class="text-white font-semibold hover:text-brand-400 transition-colors block break-all">
                                                {{ $active->AlamatEmail ?? 'info@jasuindo.co.id' }}
                                            </a>
                                        </div>
                                    </div>

                                    {{-- Address --}}
                                    <div class="contact-item flex items-start group cursor-pointer">
                                        <div
                                            class="contact-icon-wrapper flex-shrink-0 w-12 h-12 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center mr-4 transition-all">
                                            <i
                                                class="fa-solid fa-location-dot text-brand-400 text-lg transition-colors"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">
                                                <span
                                                    id="detailTipe">{{ $active->TipeKantor === 'Pusat' ? ($en ? 'Head Office' : 'Kantor Pusat') : ($en ? 'Branch Office' : 'Kantor Cabang') }}</span>
                                            </p>
                                            <a id="detailMaps" href="{{ $active->TautanGoogleMaps ?? '#' }}"
                                                target="_blank"
                                                class="text-white font-semibold hover:text-brand-400 transition-colors block leading-relaxed">
                                                <span id="detailAlamat">
                                                    {{ $active->AlamatLengkap ?? 'Jalan Raya Betro No. 21' }}
                                                    @if ($active->Kota || $active->Provinsi)
                                                        ,
                                                        {{ $active->Kota }}{{ $active->Provinsi ? ', ' . $active->Provinsi : '' }}
                                                    @endif
                                                    {{ $active->KodePos ? $active->KodePos . ',' : '' }} Indonesia
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mt-6 pt-6 border-t border-white/10 space-y-6">

                                        {{-- Hubungan Investor --}}
                                        <div id="ir-container"
                                            class="{{ !$active->HubunganInvestorNama ? 'hidden' : '' }}">
                                            <p
                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                                                <i class="fa-solid fa-briefcase text-brand-400"></i>
                                                {{ $en ? 'Investor Relations' : 'Hubungan Investor' }}
                                            </p>
                                            <div class="bg-white/5 rounded-lg p-3 border border-white/10">
                                                <p class="text-sm font-bold text-white" id="ir-nama">
                                                    {{ $active->HubunganInvestorNama }}</p>
                                                <p class="text-xs text-brand-300 mb-2" id="ir-jabatan">
                                                    {{ $active->HubunganInvestorJabatan }}</p>
                                                <a href="mailto:" id="ir-email"
                                                    class="text-xs text-slate-300 hover:text-white flex items-center gap-2 transition-colors">
                                                    <i class="fa-regular fa-envelope"></i>
                                                    <span>{{ $active->HubunganInvestorEmail }}</span>
                                                </a>
                                            </div>
                                        </div>

                                        {{-- Pasar Ekspor --}}
                                        <div id="ekspor-container"
                                            class="{{ !$active->PasarEksporNama ? 'hidden' : '' }}">
                                            <p
                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3 flex items-center gap-2">
                                                <i class="fa-solid fa-globe text-emerald-400"></i>
                                                {{ $en ? 'Export Market Contact' : 'Kontak Pasar Ekspor' }}
                                            </p>
                                            <div class="bg-white/5 rounded-lg p-3 border border-white/10">
                                                <p class="text-sm font-bold text-white" id="ekspor-nama">
                                                    {{ $active->PasarEksporNama }}</p>
                                                <p class="text-xs text-emerald-300 mb-2" id="ekspor-jabatan">
                                                    {{ $active->PasarEksporJabatan }}</p>
                                                <a href="mailto:" id="ekspor-email"
                                                    class="text-xs text-slate-300 hover:text-white flex items-center gap-2 transition-colors">
                                                    <i class="fa-regular fa-envelope"></i>
                                                    <span>{{ $active->PasarEksporEmail }}</span>
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                @endif
                            </div>

                            <div class="my-8 border-t border-white/10"></div>

                            {{-- Social Media --}}
                            <div>
                                <p
                                    class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-4 flex items-center">
                                    <i class="fa-solid fa-share-nodes mr-2"></i> {{ __('Follow Us') }}
                                </p>
                                <div class="flex flex-wrap gap-3">
                                    @if (!empty($websiteSettings->SosialFacebook))
                                        <a href="{{ $websiteSettings->SosialFacebook }}" target="_blank" rel="noopener"
                                            class="social-icon w-10 h-10 bg-white/10 hover:bg-blue-600 rounded-lg flex items-center justify-center transition-all"
                                            aria-label="Facebook">
                                            <i class="fa-brands fa-facebook-f text-white"></i>
                                        </a>
                                    @endif
                                    @if (!empty($websiteSettings->SosialInstagram))
                                        <a href="{{ $websiteSettings->SosialInstagram }}" target="_blank" rel="noopener"
                                            class="social-icon w-10 h-10 bg-white/10 hover:bg-pink-600 rounded-lg flex items-center justify-center transition-all"
                                            aria-label="Instagram">
                                            <i class="fa-brands fa-instagram text-white"></i>
                                        </a>
                                    @endif
                                    @if (!empty($websiteSettings->SosialTwitter))
                                        <a href="{{ $websiteSettings->SosialTwitter }}" target="_blank" rel="noopener"
                                            class="social-icon w-10 h-10 bg-white/10 hover:bg-sky-500 rounded-lg flex items-center justify-center transition-all"
                                            aria-label="Twitter">
                                            <i class="fa-brands fa-twitter text-white"></i>
                                        </a>
                                    @endif
                                    @if (!empty($websiteSettings->SosialLinkedIn))
                                        <a href="{{ $websiteSettings->SosialLinkedIn }}" target="_blank" rel="noopener"
                                            class="social-icon w-10 h-10 bg-white/10 hover:bg-blue-700 rounded-lg flex items-center justify-center transition-all"
                                            aria-label="LinkedIn">
                                            <i class="fa-brands fa-linkedin-in text-white"></i>
                                        </a>
                                    @endif
                                    @if (!empty($websiteSettings->SosialYoutube))
                                        <a href="{{ $websiteSettings->SosialYoutube }}" target="_blank" rel="noopener"
                                            class="social-icon w-10 h-10 bg-white/10 hover:bg-red-600 rounded-lg flex items-center justify-center transition-all"
                                            aria-label="YouTube">
                                            <i class="fa-brands fa-youtube text-white"></i>
                                        </a>
                                    @endif
                                    @if (!empty($websiteSettings->SosialTiktok))
                                        <a href="{{ $websiteSettings->SosialTiktok }}" target="_blank" rel="noopener"
                                            class="social-icon w-10 h-10 bg-white/10 hover:bg-black rounded-lg flex items-center justify-center transition-all"
                                            aria-label="TikTok">
                                            <i class="fa-brands fa-tiktok text-white"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: CONTACT FORM -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8 md:p-10">
                        <div class="mb-8">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fa-regular fa-paper-plane text-brand-600 text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900">
                                        {{ __('Send Us a Message') }}</h2>
                                    <p class="text-slate-500 text-sm mt-1">
                                        {{ __('Fill in the form below and we will contact you shortly') }}</p>
                                </div>
                            </div>
                        </div>

                        <form id="contactForm" action="{{ route('frontend.contact.store') }}" method="POST">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div class="input-group-custom">
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">{{ __('Full Name') }}
                                        <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="text" name="NamaLengkap" id="namaLengkap" required
                                            placeholder="John Doe"
                                            class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">
                                        <div
                                            class="input-icon absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-user text-slate-400"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group-custom">
                                    <label
                                        class="block text-sm font-semibold text-slate-700 mb-2">{{ __('Email Address') }}
                                        <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="email" name="Email" id="email" required
                                            placeholder="john@example.com"
                                            class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">
                                        <div
                                            class="input-icon absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-envelope text-slate-400"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group-custom mb-5">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">{{ __('Subject') }} <span
                                        class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="Subjek" id="subject" required
                                        class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all appearance-none">
                                        <option value="" disabled selected>{{ __('Select Subject') }}</option>
                                        @if (isset($subject) && count($subject) > 0)
                                            @foreach ($subject as $row)
                                                <option value="{{ $row->id }}">
                                                    @if ($en && !empty($row->NamaTranslate))
                                                        {{ $row->NamaTranslate }}
                                                    @else
                                                        {{ $row->Nama }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div
                                        class="input-icon absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-list text-slate-400"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div class="input-group-custom">
                                    <label
                                        class="block text-sm font-semibold text-slate-700 mb-2">{{ __('Phone Number') }}
                                        <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="tel" name="NomorHandphone" id="nomorHandphone" required
                                            placeholder="08xxxxxxxxxx"
                                            class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">
                                        <div
                                            class="input-icon absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-phone text-slate-400"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group-custom">
                                    <label
                                        class="block text-sm font-semibold text-slate-700 mb-2">{{ __('Company Name') }}
                                        <span
                                            class="text-slate-400 text-xs font-normal">{{ __('(Optional)') }}</span></label>
                                    <div class="relative">
                                        <input type="text" name="CompanyName" id="companyName"
                                            placeholder="PT Example Tbk"
                                            class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">
                                        <div
                                            class="input-icon absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-building text-slate-400"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                                <div class="input-group-custom">
                                    <label
                                        class="block text-sm font-semibold text-slate-700 mb-2">{{ __('Company Location') }}
                                        <span
                                            class="text-slate-400 text-xs font-normal">{{ __('(Optional)') }}</span></label>
                                    <div class="relative">
                                        <input type="text" name="LokasiPerusahaan" id="lokasiPerusahaan"
                                            placeholder="Jakarta, Indonesia"
                                            class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">
                                        <div
                                            class="input-icon absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fa-solid fa-location-dot text-slate-400"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group-custom">
                                    <label
                                        class="block text-sm font-semibold text-slate-700 mb-2">{{ __('Product/Service Needed') }}
                                        <span
                                            class="text-slate-400 text-xs font-normal">{{ __('(Optional)') }}</span></label>
                                    <div class="relative">
                                        <select name="ProdukYangDibutuhkan" id="produkYangDibutuhkan"
                                            class="w-full text-slate-700" style="width: 100%;">
                                            <option value=""></option>
                                            @if (isset($masterProdukList) && count($masterProdukList) > 0)
                                                @foreach ($masterProdukList as $top)
                                                    @php
                                                        $topTitle = $en && !empty($top->NamaTranslate) ? $top->NamaTranslate : $top->Nama;
                                                    @endphp
                                                    @if ($top->activeChildren->count() > 0)
                                                        <optgroup label="{{ $topTitle }}">
                                                            @foreach ($top->activeChildren as $sub)
                                                                @php
                                                                    $subTitle = $en && !empty($sub->NamaTranslate) ? $sub->NamaTranslate : $sub->Nama;
                                                                @endphp
                                                                @if ($sub->activeChildren->count() > 0)
                                                                    @foreach ($sub->activeChildren as $subSub)
                                                                        @php
                                                                            $subSubTitle = $en && !empty($subSub->NamaTranslate) ? $subSub->NamaTranslate : $subSub->Nama;
                                                                            $fullVal = $topTitle . ' - ' . $subTitle . ' - ' . $subSubTitle;
                                                                        @endphp
                                                                        <option value="{{ $fullVal }}">
                                                                            {{ $subTitle }} — {{ $subSubTitle }}
                                                                        </option>
                                                                    @endforeach
                                                                @else
                                                                    @php
                                                                        $fullVal = $topTitle . ' - ' . $subTitle;
                                                                    @endphp
                                                                    <option value="{{ $fullVal }}">
                                                                        {{ $subTitle }}
                                                                    </option>
                                                                @endif
                                                            @endforeach
                                                        </optgroup>
                                                    @else
                                                        <option value="{{ $topTitle }}">{{ $topTitle }}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <optgroup label="{{ $en ? 'Other' : 'Lainnya' }}">
                                                <option value="Other / Lainnya">{{ __('Other / Custom') }}</option>
                                            </optgroup>
                                        </select>
                                        <div
                                            class="input-icon absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                            <i class="fa-solid fa-tag text-slate-400"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group-custom mb-6">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">{{ __('Your Message') }}
                                    <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <textarea name="Pesan" id="pesan" rows="5" required
                                        placeholder="{{ __('Write your message or question here...') }}"
                                        class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all resize-none"></textarea>
                                    <div class="input-icon absolute top-4 left-0 pl-4 pointer-events-none">
                                        <i class="fa-regular fa-comment-dots text-slate-400"></i>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <button type="submit" id="btnSubmit"
                                    class="w-full inline-flex items-center justify-center px-8 py-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span class="btn-text inline-flex items-center">
                                        <i class="fa-regular fa-paper-plane mr-2"></i> {{ __('Send Message') }}
                                    </span>
                                    <span class="btn-loader hidden items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        {{ __('Sending...') }}
                                    </span>
                                </button>
                            </div>

                            <p class="form-messages mb-0 mt-3"></p>
                        </form>
                    </div>

                    <div class="mt-6 bg-blue-50 border-l-4 border-brand-500 rounded-r-xl p-5">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-circle-info text-brand-500 text-xl"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <h4 class="text-sm font-bold text-slate-900 mb-1">{{ __('Important Information') }}</h4>
                                <p class="text-sm text-slate-600 leading-relaxed">
                                    {{ __('By submitting this form, you agree to our Privacy Policy. Our team will respond within 1x24 working hours.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- GOOGLE MAPS + BRANCHES SECTION -->
    <section class="py-12 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="text-brand-600 font-bold tracking-wider uppercase text-sm">{{ __('Find Us') }}</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2 mb-4">
                    {{ __('Our Office Locations') }}
                </h2>
                <p class="text-slate-600">
                    {{ $en
                        ? 'Visit any of our offices across Indonesia or see our locations on the map.'
                        : 'Kunjungi salah satu kantor kami di seluruh Indonesia atau lihat lokasi kami di peta.' }}
                </p>
            </div>

            {{-- Main Map (kantor utama) --}}
            @if ($kantorUtama)
                <div class="rounded-3xl overflow-hidden shadow-2xl border border-slate-200 relative mb-8">
                    @if ($kantorUtama->EmbedGoogleMaps)
                        <div class="w-full h-[500px] map-embed relative" id="mainMapContainer">
                            {!! $kantorUtama->EmbedGoogleMaps !!}
                        </div>
                    @else
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6884.752860529671!2d112.73386551003723!3d-7.4182974915552915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e5a826db497d%3A0x9f2f2fe8700ab414!2sPT.%20Jasuindo%20Informatika%20Pratama!5e1!3m2!1sid!2sid!4v1781381089029!5m2!1sid!2sid"
                            width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade" class="w-full">
                        </iframe>
                    @endif

                    <div
                        class="absolute bottom-6 left-6 right-6 md:left-6 md:right-auto md:max-w-sm bg-white rounded-2xl shadow-2xl p-6 z-10 border border-slate-100">
                        <div class="flex items-start">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fa-solid fa-location-dot text-brand-600 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-900 mb-1">{{ $kantorUtama->NamaKantor }}</h3>
                                <p class="text-sm text-slate-600 leading-relaxed mb-3">
                                    {{ $kantorUtama->AlamatLengkap }}
                                    @if ($kantorUtama->Kota || $kantorUtama->Provinsi)
                                        ,
                                        {{ $kantorUtama->Kota }}{{ $kantorUtama->Provinsi ? ', ' . $kantorUtama->Provinsi : '' }}
                                    @endif
                                    {{ $kantorUtama->KodePos ? $kantorUtama->KodePos . ',' : '' }} Indonesia
                                </p>
                                @if ($kantorUtama->TautanGoogleMaps)
                                    <a href="{{ $kantorUtama->TautanGoogleMaps }}" target="_blank"
                                        class="inline-flex items-center text-sm font-semibold text-brand-600 hover:text-brand-700 transition-colors">
                                        {{ __('Get Directions') }}
                                        <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Grid Kantor Cabang --}}
            @if ($kantorCabang->count() > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-extrabold text-slate-900 mb-1">
                        {{ $en ? 'Other Branch Offices' : 'Kantor Cabang Lainnya' }}
                    </h3>
                    <p class="text-sm text-slate-500">
                        {{ $en ? 'Click any office to view it on the map above.' : 'Klik kantor mana pun untuk menampilkannya di peta di atas.' }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($kantorCabang as $cabang)
                        <div class="branch-card bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-xl hover:border-brand-300 transition-all cursor-pointer group"
                            data-nama="{{ $cabang->NamaKantor }}" data-alamat="{{ $cabang->AlamatLengkap }}"
                            data-kota="{{ $cabang->Kota }}" data-provinsi="{{ $cabang->Provinsi }}"
                            data-kodepos="{{ $cabang->KodePos }}" data-maps="{{ $cabang->TautanGoogleMaps }}"
                            data-embed="{{ $cabang->EmbedGoogleMaps }}">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex-shrink-0 w-11 h-11 bg-brand-50 group-hover:bg-brand-600 rounded-xl flex items-center justify-center transition-colors">
                                    <i
                                        class="fa-solid fa-building text-brand-600 group-hover:text-white transition-colors"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4
                                        class="font-extrabold text-slate-900 mb-1 group-hover:text-brand-600 transition-colors">
                                        {{ $cabang->NamaKantor }}
                                    </h4>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 mb-3">
                                        {{ $cabang->AlamatLengkap }}
                                        @if ($cabang->Kota || $cabang->Provinsi)
                                            , {{ $cabang->Kota }}{{ $cabang->Provinsi ? ', ' . $cabang->Provinsi : '' }}
                                        @endif
                                        {{ $cabang->KodePos }}
                                    </p>
                                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-600">
                                        @if ($cabang->NomorTelepon)
                                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $cabang->NomorTelepon) }}"
                                                class="flex items-center gap-1.5 hover:text-brand-600">
                                                <i class="fa-solid fa-phone text-[10px]"></i> {{ $cabang->NomorTelepon }}
                                            </a>
                                        @endif
                                        @if ($cabang->NomorWhatsApp)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $cabang->NomorWhatsApp) }}"
                                                target="_blank" class="flex items-center gap-1.5 hover:text-emerald-600">
                                                <i class="fa-brands fa-whatsapp text-[10px]"></i> WA
                                            </a>
                                        @endif
                                        @if ($cabang->AlamatEmail)
                                            <a href="mailto:{{ $cabang->AlamatEmail }}"
                                                class="flex items-center gap-1.5 hover:text-brand-600 truncate max-w-[140px]">
                                                <i class="fa-solid fa-envelope text-[10px]"></i>
                                                <span class="truncate">{{ $cabang->AlamatEmail }}</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-shrink-0 self-center">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-slate-100 group-hover:bg-brand-50 flex items-center justify-center transition-colors">
                                        <i
                                            class="fa-solid fa-map-location-dot text-slate-500 group-hover:text-brand-600 text-sm"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            if ($('#produkYangDibutuhkan').length) {
                $('#produkYangDibutuhkan').select2({
                    placeholder: "{{ $en ? 'Select Product or Solution' : 'Pilih Produk atau Layanan' }}",
                    allowClear: true,
                    width: '100%'
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // ===== OFFICE TAB SWITCHER =====
            const officeTabs = document.querySelectorAll('#officeTabs .office-tab');
            const detailTelp = document.getElementById('detailTelp');
            const detailWa = document.getElementById('detailWa');
            const detailEmail = document.getElementById('detailEmail');
            const detailMaps = document.getElementById('detailMaps');
            const detailAlamat = document.getElementById('detailAlamat');
            const detailTipe = document.getElementById('detailTipe');

            const en = {{ $en ? 'true' : 'false' }};

            officeTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Update active state
                    officeTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    // Update detail
                    const tipe = this.dataset.tipe;
                    const alamat = this.dataset.alamat || '';
                    const kota = this.dataset.kota || '';
                    const provinsi = this.dataset.provinsi || '';
                    const kodepos = this.dataset.kodepos || '';

                    let alamatText = alamat;
                    if (kota || provinsi) alamatText += ', ' + kota + (provinsi ? ', ' + provinsi :
                        '');
                    if (kodepos) alamatText += ' ' + kodepos;
                    alamatText += ', Indonesia';

                    if (detailTelp) {
                        detailTelp.href = 'tel:' + (this.dataset.telpClean || this.dataset.telp);
                        detailTelp.textContent = this.dataset.telp || '-';
                    }
                    if (detailWa) {
                        detailWa.href = 'https://wa.me/' + (this.dataset.waClean || this.dataset
                            .wa);
                        detailWa.textContent = this.dataset.wa || '-';
                    }
                    if (detailEmail) {
                        detailEmail.href = 'mailto:' + this.dataset.email;
                        detailEmail.textContent = this.dataset.email || '-';
                    }
                    if (detailMaps && this.dataset.maps) {
                        detailMaps.href = this.dataset.maps;
                    }
                    if (detailAlamat) {
                        detailAlamat.textContent = alamatText;
                    }
                    if (detailTipe) {
                        detailTipe.textContent = tipe === 'Pusat' ?
                            (en ? 'Head Office' : 'Kantor Pusat') :
                            (en ? 'Branch Office' : 'Kantor Cabang');
                    }

                    // Scroll to map section if embed available
                    const mainMap = document.getElementById('mainMapContainer');
                    if (mainMap && this.dataset.embed) {
                        mainMap.innerHTML = this.dataset.embed;
                    }
                });
            });

            // ===== BRANCH CARD CLICK → UPDATE MAIN MAP =====
            document.querySelectorAll('.branch-card').forEach(card => {
                card.addEventListener('click', function() {
                    const mainMap = document.getElementById('mainMapContainer');
                    if (mainMap && this.dataset.embed) {
                        mainMap.innerHTML = this.dataset.embed;
                        mainMap.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    } else if (this.dataset.maps) {
                        window.open(this.dataset.maps, '_blank');
                    }
                });
            });

            // ===== CONTACT FORM SUBMIT =====
            const contactForm = document.getElementById('contactForm');
            const btnSubmit = document.getElementById('btnSubmit');

            if (!contactForm) return;

            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const form = this;
                const formData = new FormData(form);

                btnSubmit.disabled = true;
                btnSubmit.classList.add('btn-loading');

                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

                fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                ?.content || '',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw {
                                    status: response.status,
                                    data: data
                                };
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        btnSubmit.disabled = false;
                        btnSubmit.classList.remove('btn-loading');
                        form.reset();
                        if (typeof $ !== 'undefined' && $('#produkYangDibutuhkan').length) {
                            $('#produkYangDibutuhkan').val(null).trigger('change');
                        }

                        Swal.fire({
                            icon: 'success',
                            title: "{{ __('Message Sent!') }}",
                            text: "{{ __('Thank you for contacting us. Our team will contact you shortly.') }}",
                            confirmButtonColor: '#0284c7',
                            confirmButtonText: "{{ __('OK') }}",
                            timer: 4000,
                            timerProgressBar: true
                        });
                    })
                    .catch(error => {
                        btnSubmit.disabled = false;
                        btnSubmit.classList.remove('btn-loading');

                        if (error.status === 422 && error.data.errors) {
                            const errors = error.data.errors;
                            let errorMessages = '';
                            Object.keys(errors).forEach(key => {
                                errorMessages += errors[key][0] + '<br>';
                                const input = form.querySelector('[name="' + key + '"]');
                                if (input) {
                                    input.classList.add('is-invalid');
                                    input.style.borderColor = '#ef4444';
                                    const errorDiv = document.createElement('div');
                                    errorDiv.className =
                                        'invalid-feedback text-red-500 text-sm mt-1';
                                    errorDiv.textContent = errors[key][0];
                                    input.parentElement.appendChild(errorDiv);
                                    input.addEventListener('input', function() {
                                        this.classList.remove('is-invalid');
                                        this.style.borderColor = '';
                                        const fb = this.parentElement.querySelector(
                                            '.invalid-feedback');
                                        if (fb) fb.remove();
                                    }, {
                                        once: true
                                    });
                                }
                            });
                            Swal.fire({
                                icon: 'error',
                                title: "{{ __('Validation Failed') }}",
                                html: errorMessages,
                                confirmButtonColor: '#ef4444',
                                confirmButtonText: "{{ __('Fix Data') }}"
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: "{{ __('Oops...') }}",
                                text: "{{ __('An error occurred while sending the message. Please try again.') }}",
                                confirmButtonColor: '#ef4444',
                                confirmButtonText: "{{ __('OK') }}"
                            });
                        }
                    });
            });
        });
    </script>
@endpush

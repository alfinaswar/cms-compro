@extends('frontend.index')

@section('content-frontend')

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
    .btn-loading .btn-text,
    .btn-loading .btn-icon {
        display: none;
    }
    .btn-loading .btn-loader {
        display: inline-flex !important;
    }
    .map-container {
        position: relative;
        overflow: hidden;
    }
    .map-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 100px;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.8), transparent);
        z-index: 1;
        pointer-events: none;
    }
    .input-group-custom {
        position: relative;
    }
    .input-group-custom .input-icon {
        transition: color 0.3s ease;
    }
    .input-group-custom input:focus~.input-icon,
    .input-group-custom textarea:focus~.input-icon {
        color: #0284c7;
    }
</style>

<!-- HERO SECTION -->
<section class="relative pt-32 pb-20 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-900 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <img src="https://images.unsplash.com/photo-1423666639041-f56000c27a9a?q=80&w=2070&auto=format&fit=crop"
            alt="Contact Background" class="w-full h-full object-cover">
    </div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <span class="inline-block py-1.5 px-4 rounded-full bg-brand-500/20 text-brand-100 text-sm font-semibold tracking-wide mb-6 border border-brand-500/30 backdrop-blur-sm">
                <i class="fa-solid fa-envelope-open-text mr-2"></i> {{ __('Get In Touch') }}
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                {{ __('Contact Us') }}
            </h1>
            <p class="text-xl text-slate-300 max-w-2xl mx-auto">
                {{ __('We are ready to help you. Our team will respond within 1x24 working hours.') }}
            </p>

            <nav class="mt-8 flex items-center justify-center space-x-2 text-sm text-slate-300">
                <a href="{{ url('/') }}" class="hover:text-white transition-colors">
                    <i class="fa-solid fa-house mr-1"></i> {{ __('Home') }}
                </a>
                <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                <span class="text-white font-semibold">{{ __('Contact Us') }}</span>
            </nav>
        </div>
    </div>
</section>

<!-- QUICK CONTACT CARDS -->
<section class="relative -mt-12 z-20">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 hover:shadow-2xl transition-all group">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-14 h-14 bg-brand-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-brand-600 transition-colors">
                        <i class="fa-solid fa-headphones-simple text-brand-600 text-xl group-hover:text-white transition-colors"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">{{ __('Call Us') }}</p>
                        <a href="tel:{{ isset($websiteSettings) && $websiteSettings->NomorTelepon ? preg_replace('/[^0-9+]/', '', $websiteSettings->NomorTelepon) : '+62318910919' }}"
                            class="text-lg font-bold text-slate-900 hover:text-brand-600 transition-colors block truncate">
                            {{ $websiteSettings->NomorTelepon ?? '+62 31 8910919' }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 hover:shadow-2xl transition-all group">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-green-600 transition-colors">
                        <i class="fa-solid fa-envelope text-green-600 text-xl group-hover:text-white transition-colors"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">{{ __('Email Us') }}</p>
                        <a href="mailto:{{ $websiteSettings->AlamatEmail ?? 'info@jasuindo.co.id' }}"
                            class="text-lg font-bold text-slate-900 hover:text-green-600 transition-colors block truncate">
                            {{ $websiteSettings->AlamatEmail ?? 'info@jasuindo.co.id' }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 hover:shadow-2xl transition-all group">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mr-4 group-hover:bg-emerald-600 transition-colors">
                        <i class="fa-brands fa-whatsapp text-emerald-600 text-xl group-hover:text-white transition-colors"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">WhatsApp</p>
                        <a href="https://wa.me/{{ isset($websiteSettings) && $websiteSettings->NomorWhatsApp ? preg_replace('/[^0-9]/', '', $websiteSettings->NomorWhatsApp) : '6281234567890' }}"
                            target="_blank"
                            class="text-lg font-bold text-slate-900 hover:text-emerald-600 transition-colors block truncate">
                            {{ $websiteSettings->NomorWhatsApp ?? '+62 812-3456-7890' }}
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- MAIN CONTENT -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 lg:gap-12">

            <!-- LEFT: CONTACT INFORMATION -->
            <div class="lg:col-span-2">
                <div class="bg-gradient-to-br from-brand-900 via-brand-800 to-brand-950 rounded-3xl p-8 text-white sticky top-24 shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-64 h-64 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 -ml-32 -mb-32"></div>

                    <div class="relative z-10">
                        <div class="mb-8">
                            <span class="inline-block py-1 px-3 rounded-full bg-brand-500/20 text-brand-100 text-xs font-semibold tracking-wide mb-4 border border-brand-500/30">
                                {{ __('WORK WITH US') }}
                            </span>
                            <h2 class="text-3xl font-extrabold mb-4">{{ __('Contact Information') }}</h2>
                            <p class="text-slate-300 leading-relaxed">
                                {{ $websiteSettings->DeskripsiSingkat ?? __('Thank you for your interest in Jasuindo. We are excited to hear from you and discuss how we can help your organization\'s digital transformation.') }}
                            </p>
                        </div>

                        <div class="space-y-5">
                            <div class="contact-item flex items-start group cursor-pointer">
                                <div class="contact-icon-wrapper flex-shrink-0 w-12 h-12 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center mr-4 transition-all">
                                    <i class="fa-solid fa-headphones-simple text-brand-400 text-lg transition-colors"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">{{ __('Call Us For Query') }}</p>
                                    <a href="tel:{{ isset($websiteSettings) && $websiteSettings->NomorTelepon ? preg_replace('/[^0-9+]/', '', $websiteSettings->NomorTelepon) : '+62318910919' }}"
                                        class="text-white font-semibold hover:text-brand-400 transition-colors block">
                                        {{ $websiteSettings->NomorTelepon ?? '+62 31 8910919 (Hunting)' }}
                                    </a>
                                </div>
                            </div>

                            <div class="contact-item flex items-start group cursor-pointer">
                                <div class="contact-icon-wrapper flex-shrink-0 w-12 h-12 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center mr-4 transition-all">
                                    <i class="fa-brands fa-whatsapp text-emerald-400 text-lg transition-colors"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">WhatsApp</p>
                                    <a href="https://wa.me/{{ isset($websiteSettings) && $websiteSettings->NomorWhatsApp ? preg_replace('/[^0-9]/', '', $websiteSettings->NomorWhatsApp) : '6281234567890' }}"
                                        target="_blank"
                                        class="text-white font-semibold hover:text-emerald-400 transition-colors block">
                                        {{ $websiteSettings->NomorWhatsApp ?? '+62 812-3456-7890' }}
                                    </a>
                                </div>
                            </div>

                            <div class="contact-item flex items-start group cursor-pointer">
                                <div class="contact-icon-wrapper flex-shrink-0 w-12 h-12 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center mr-4 transition-all">
                                    <i class="fa-solid fa-envelope text-brand-400 text-lg transition-colors"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">{{ __('Email Us Anytime') }}</p>
                                    <a href="mailto:{{ $websiteSettings->AlamatEmail ?? 'info@jasuindo.co.id' }}"
                                        class="text-white font-semibold hover:text-brand-400 transition-colors block break-all">
                                        {{ $websiteSettings->AlamatEmail ?? 'info@jasuindo.co.id' }}
                                    </a>
                                </div>
                            </div>

                            <div class="contact-item flex items-start group cursor-pointer">
                                <div class="contact-icon-wrapper flex-shrink-0 w-12 h-12 bg-white/10 backdrop-blur-sm rounded-xl flex items-center justify-center mr-4 transition-all">
                                    <i class="fa-solid fa-location-dot text-brand-400 text-lg transition-colors"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-1">{{ __('Office Location') }}</p>
                                    <a href="{{ $websiteSettings->TautanGoogleMaps ?? '#' }}" target="_blank"
                                        class="text-white font-semibold hover:text-brand-400 transition-colors block leading-relaxed">
                                        @if (isset($websiteSettings) && $websiteSettings->AlamatKantor)
                                            {{ $websiteSettings->AlamatKantor }}
                                            @if ($websiteSettings->Kota || $websiteSettings->Provinsi)
                                                , {{ $websiteSettings->Kota }}{{ $websiteSettings->Provinsi ? ', ' . $websiteSettings->Provinsi : '' }}
                                            @endif
                                            @if ($websiteSettings->Negara)
                                                , {{ $websiteSettings->Negara }}
                                            @endif
                                            @if ($websiteSettings->KodePos)
                                                {{ $websiteSettings->KodePos }}
                                            @endif
                                        @else
                                            Jalan Raya Betro No. 21, Sedati, Sidoarjo 61253, Indonesia
                                        @endif
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="my-8 border-t border-white/10"></div>

                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-wider font-semibold mb-4 flex items-center">
                                <i class="fa-solid fa-share-nodes mr-2"></i>
                                {{ __('Follow Us') }}
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
                                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900">{{ __('Send Us a Message') }}</h2>
                                <p class="text-slate-500 text-sm mt-1">{{ __('Fill in the form below and we will contact you shortly') }}</p>
                            </div>
                        </div>
                    </div>

                    <form id="contactForm" action="{{ route('frontend.contact.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div class="input-group-custom">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    {{ __('Full Name') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="NamaLengkap" id="namaLengkap" required
                                        placeholder="John Doe"
                                        class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">
                                    <div class="input-icon absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-user text-slate-400"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group-custom">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    {{ __('Email Address') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="email" name="Email" id="email" required
                                        placeholder="john@example.com"
                                        class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">
                                    <div class="input-icon absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-envelope text-slate-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div class="input-group-custom">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    {{ __('Phone Number') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="tel" name="NomorHandphone" id="nomorHandphone" required
                                        placeholder="08xxxxxxxxxx"
                                        class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">
                                    <div class="input-icon absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-phone text-slate-400"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group-custom">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    {{ __('Company Name') }} <span class="text-slate-400 text-xs font-normal">{{ __('(Optional)') }}</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="CompanyName" id="companyName"
                                        placeholder="PT Example Tbk"
                                        class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">
                                    <div class="input-icon absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-building text-slate-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div class="input-group-custom">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    {{ __('Company Location') }} <span class="text-slate-400 text-xs font-normal">{{ __('(Optional)') }}</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="LokasiPerusahaan" id="lokasiPerusahaan"
                                        placeholder="Jakarta, Indonesia"
                                        class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">
                                    <div class="input-icon absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-location-dot text-slate-400"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="input-group-custom">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">
                                    {{ __('Product/Service Needed') }} <span class="text-slate-400 text-xs font-normal">{{ __('(Optional)') }}</span>
                                </label>
                                <div class="relative">
                                    <input type="text" name="ProdukYangDibutuhkan" id="produkYangDibutuhkan"
                                        placeholder="Digital Identity Solution"
                                        class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">
                                    <div class="input-icon absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fa-solid fa-tag text-slate-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="input-group-custom mb-6">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                {{ __('Your Message') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <textarea name="Pesan" id="pesan" rows="5" required
                                    placeholder="{{ __('Write your message or question here...') }}"
                                    class="form-input w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all resize-none"></textarea>
                                <div class="input-icon absolute top-4 left-0 pl-4 pointer-events-none">
                                    <i class="fa-regular fa-comment-dots text-slate-400"></i>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit" id="btnSubmit"
                                class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="btn-text inline-flex items-center">
                                    <i class="fa-regular fa-paper-plane mr-2"></i>
                                    {{ __('Send Message') }}
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
                            <a href="{{ url('/') }}"
                                class="inline-flex items-center justify-center px-8 py-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all">
                                <i class="fa-solid fa-arrow-left mr-2"></i>
                                {{ __('Back') }}
                            </a>
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

<!-- GOOGLE MAPS SECTION -->
<section class="py-12 bg-slate-50">
    <div class="container mx-auto px-6">

        <div class="text-center max-w-3xl mx-auto mb-10">
            <span class="text-brand-600 font-bold tracking-wider uppercase text-sm">{{ __('Find Us') }}</span>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2 mb-4">{{ __('Our Office Location') }}</h2>
            <p class="text-slate-600">{{ __('Visit our office or see our location on the map') }}</p>
        </div>

        <div class="map-container rounded-3xl overflow-hidden shadow-2xl border border-slate-200 relative">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6884.752860529671!2d112.73386551003723!3d-7.4182974915552915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e5a826db497d%3A0x9f2f2fe8700ab414!2sPT.%20Jasuindo%20Informatika%20Pratama!5e1!3m2!1sid!2sid!4v1781381089029!5m2!1sid!2sid"
                width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade" class="w-full">
            </iframe>

            <div class="absolute bottom-6 left-6 right-6 md:left-6 md:right-auto md:max-w-sm bg-white rounded-2xl shadow-2xl p-6 z-10 border border-slate-100">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mr-4">
                        <i class="fa-solid fa-location-dot text-brand-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-slate-900 mb-1">PT Jasuindo Informatika Pratama</h3>
                        <p class="text-sm text-slate-600 leading-relaxed mb-3">
                            Jalan Raya Betro No. 21, Sedati, Sidoarjo 61253, Jawa Timur, Indonesia
                        </p>
                        <a href="https://maps.google.com/?q=PT+Jasuindo+Informatika+Pratama" target="_blank"
                            class="inline-flex items-center text-sm font-semibold text-brand-600 hover:text-brand-700 transition-colors">
                            {{ __('Get Directions') }}
                            <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@push('frontend-js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw { status: response.status, data: data };
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    btnSubmit.disabled = false;
                    btnSubmit.classList.remove('btn-loading');
                    form.reset();

                    Swal.fire({
                        icon: 'success',
                        title: "{{ __('Message Sent!') }}",
                        text: "{{ __('Thank you for contacting us. Our team will contact you shortly.') }}",
                        confirmButtonColor: '#0284c7',
                        confirmButtonText: "{{ __('OK') }}",
                        timer: 4000,
                        timerProgressBar: true,
                        showClass: { popup: 'animate__animated animate__fadeInDown' },
                        hideClass: { popup: 'animate__animated animate__fadeOutUp' }
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
                                errorDiv.className = 'invalid-feedback text-red-500 text-sm mt-1';
                                errorDiv.textContent = errors[key][0];
                                input.parentElement.appendChild(errorDiv);

                                input.addEventListener('input', function() {
                                    this.classList.remove('is-invalid');
                                    this.style.borderColor = '';
                                    const feedback = this.parentElement.querySelector('.invalid-feedback');
                                    if (feedback) feedback.remove();
                                }, { once: true });
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

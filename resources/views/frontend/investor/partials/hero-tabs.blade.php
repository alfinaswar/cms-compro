@php
    $currentLocale = app()->getLocale();
@endphp

<!-- ========================================== -->
<!-- HERO SECTION -->
<!-- ========================================== -->
<section class="relative pt-32 pb-20 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-900 overflow-hidden">
    <!-- Background Image with Opacity -->
    <div class="absolute inset-0 opacity-10">
        <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?q=80&w=2070&auto=format&fit=crop"
            alt="Investor Background" class="w-full h-full object-cover">
    </div>

    <!-- Decorative Glowing Blobs -->
    <div
        class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
    </div>
    <div
        class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
    </div>

    <div class="container mx-auto px-8 md:px-12 lg:px-24 relative z-10">
        <div class="max-w-6xl mx-auto text-center">

            <!-- Top Badge -->
            <span
                class="inline-block py-1.5 px-6 rounded-full bg-brand-500/20 text-brand-100 text-sm font-semibold tracking-wide mb-6 border border-brand-500/30 backdrop-blur-sm">
                <i class="fa-solid fa-chart-line mr-2"></i> {{ __('investor.badge_label') }}
            </span>

            <!-- Main Heading -->
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                {{ __('investor.hero_title') }} <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-cyan-300">Jasuindo</span>
            </h1>

            <!-- Description -->
            <p class="text-xl text-slate-300 max-w-4xl mx-auto">
                {{ __('investor.hero_desc') }}
            </p>

            <!-- Breadcrumb (Moved to Bottom) -->
            <nav class="mt-8 flex items-center justify-center space-x-2 text-sm text-slate-300">
                <a href="{{ url('/' . $currentLocale) }}" class="hover:text-white transition-colors">
                    <i class="fa-solid fa-house mr-1"></i> {{ __('Home') }}
                </a>
                <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                <span class="text-white font-semibold">{{ __('investor.breadcrumb') }}</span>
            </nav>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- 4 TABS NAVIGATION BAR (STICKY) -->
<!-- ========================================== -->
<div class="bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-sm sticky top-20 z-40">
    <div class="flex items-center justify-center container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center overflow-x-auto py-3 no-scrollbar space-x-2">
            <a href="{{ route('frontend.laporan-keuangan', ['locale' => $currentLocale]) }}"
                class="px-5 py-2 rounded-full text-xs md:text-sm font-semibold whitespace-nowrap transition-all duration-200 {{ ($activeTab ?? '') === 'laporan-keuangan' ? 'bg-[#0099ff] text-white shadow-sm' : 'text-[#45464d] hover:bg-slate-100 hover:text-slate-900' }}">
                {{ __('investor.tab_financial_report') }}
            </a>
            <a href="{{ route('frontend.investor.informasi-finansial', ['locale' => $currentLocale]) }}"
                class="px-5 py-2 rounded-full text-xs md:text-sm font-semibold whitespace-nowrap transition-all duration-200 {{ ($activeTab ?? '') === 'informasi-finansial' ? 'bg-[#0099ff] text-white shadow-sm' : 'text-[#45464d] hover:bg-slate-100 hover:text-slate-900' }}">
                {{ __('investor.tab_financial_info') }}
            </a>
            <a href="{{ route('frontend.investor.tata-kelola', ['locale' => $currentLocale]) }}"
                class="px-5 py-2 rounded-full text-xs md:text-sm font-semibold whitespace-nowrap transition-all duration-200 {{ ($activeTab ?? '') === 'tata-kelola' ? 'bg-[#0099ff] text-white shadow-sm' : 'text-[#45464d] hover:bg-slate-100 hover:text-slate-900' }}">
                {{ __('investor.tab_governance') }}
            </a>
            <a href="{{ route('frontend.investor.informasi-lainnya', ['locale' => $currentLocale]) }}"
                class="px-5 py-2 rounded-full text-xs md:text-sm font-semibold whitespace-nowrap transition-all duration-200 {{ ($activeTab ?? '') === 'informasi-lainnya' ? 'bg-[#0099ff] text-white shadow-sm' : 'text-[#45464d] hover:bg-slate-100 hover:text-slate-900' }}">
                {{ __('investor.tab_other_info') }}
            </a>
        </div>
    </div>
</div>

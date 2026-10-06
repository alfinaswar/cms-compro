@php
    $currentLocale = app()->getLocale();
@endphp

<!-- ========================================== -->
<!-- HERO / BREADCRUMB SECTION -->
<!-- ========================================== -->
<section class="relative pt-32 pb-14 bg-gradient-to-b from-[#0a557a] to-[#094e70] text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center max-w-4xl">
        <!-- Breadcrumbs -->
        <nav class="flex justify-center items-center space-x-2 text-xs md:text-sm text-white/80 mb-4 font-medium">
            <a href="{{ url('/' . $currentLocale) }}" class="hover:text-white transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-house text-xs"></i> Home
            </a>
            <span class="text-white/50">&gt;</span>
            <span class="text-white font-semibold">Laporan Investor</span>
        </nav>

        <!-- Heading -->
        <h1 class="text-3xl md:text-5xl font-bold tracking-tight mb-3 font-serif" style="font-family: 'Noto Serif', serif, system-ui;">
            Laporan Keuangan &amp; Publikasi
        </h1>
        <p class="text-sm md:text-base text-white/90 max-w-2xl mx-auto leading-relaxed">
            Transparansi kinerja dan informasi keuangan perusahaan secara berkala
        </p>
    </div>
</section>

<!-- ========================================= -->
<!-- 4 TABS NAVIGATION BAR (STICKY OR HEADER) -->
<!-- ========================================== -->
<div class="bg-white border-b border-[#e5eeff] shadow-sm sticky top-20 z-40">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center overflow-x-auto py-3 no-scrollbar space-x-2">
            <!-- Tab 1: Laporan Keuangan -->
            <a href="{{ route('frontend.laporan-keuangan', ['locale' => $currentLocale]) }}"
               class="px-5 py-2 rounded-full text-xs md:text-sm font-semibold whitespace-nowrap transition-all duration-200 {{ ($activeTab ?? '') === 'laporan-keuangan' ? 'bg-[#0099ff] text-white shadow-sm' : 'text-[#45464d] hover:bg-slate-100 hover:text-slate-900' }}">
                Laporan Keuangan
            </a>

            <!-- Tab 2: Informasi Finansial -->
            <a href="{{ route('frontend.investor.informasi-finansial', ['locale' => $currentLocale]) }}"
               class="px-5 py-2 rounded-full text-xs md:text-sm font-semibold whitespace-nowrap transition-all duration-200 {{ ($activeTab ?? '') === 'informasi-finansial' ? 'bg-[#0099ff] text-white shadow-sm' : 'text-[#45464d] hover:bg-slate-100 hover:text-slate-900' }}">
                Informasi Finansial
            </a>

            <!-- Tab 3: Tata Kelola Perusahaan -->
            <a href="{{ route('frontend.investor.tata-kelola', ['locale' => $currentLocale]) }}"
               class="px-5 py-2 rounded-full text-xs md:text-sm font-semibold whitespace-nowrap transition-all duration-200 {{ ($activeTab ?? '') === 'tata-kelola' ? 'bg-[#0099ff] text-white shadow-sm' : 'text-[#45464d] hover:bg-slate-100 hover:text-slate-900' }}">
                Tata Kelola Perusahaan
            </a>

            <!-- Tab 4: Informasi Lainnya -->
            <a href="{{ route('frontend.investor.informasi-lainnya', ['locale' => $currentLocale]) }}"
               class="px-5 py-2 rounded-full text-xs md:text-sm font-semibold whitespace-nowrap transition-all duration-200 {{ ($activeTab ?? '') === 'informasi-lainnya' ? 'bg-[#0099ff] text-white shadow-sm' : 'text-[#45464d] hover:bg-slate-100 hover:text-slate-900' }}">
                Informasi Lainnya
            </a>
        </div>
    </div>
</div>

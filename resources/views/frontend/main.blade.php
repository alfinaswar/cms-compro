@extends('frontend.index')
@section('content-frontend')
@php
    use App\Models\HeroSlider;
    $heroSliders = HeroSlider::where('Status', 'Aktif')->orderBy('Urutan', 'asc')->get();
    $heroCount = $heroSliders->count();
@endphp

@push('styles')
<style>
    #hero-slider {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        overflow: hidden;
        background-color: #f4f5f5; /* Fallback color */
    }
    #hero-slider .hero-slide {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        transition: opacity 700ms ease-in-out;
    }
    #hero-slider .hero-slide.opacity-100 {
        z-index: 10 !important;
        opacity: 1 !important;
        pointer-events: auto !important;
    }
    #hero-slider .hero-slide.opacity-0 {
        z-index: 0 !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }
    #hero-slider .hero-bg-media {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 1;
    }
    /* Worm Dot Animation */
    #hero-slider .hero-dot {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>
@endpush

<section id="home" class="relative min-h-screen flex items-center overflow-hidden">

    @if($heroCount > 0)
        <div class="relative w-full h-full">
            <div id="hero-slider" class="relative w-full h-full">
                @foreach($heroSliders as $slider)
                    <div class="hero-slide w-full min-h-screen absolute inset-0 transition-opacity duration-700
                    @if($loop->first) opacity-100 @else opacity-0 @endif
                    flex items-center justify-center"
                    >
                        {{-- Tampilkan background --}}
                        <div class="absolute inset-0 z-0">
                            @if($slider->TipeMedia == 'video' && !empty($slider->Video))
                                <video autoplay loop muted playsinline class="hero-bg-media">
                                    <source src="{{ asset('storage/' . $slider->Video) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @elseif($slider->TipeMedia == 'image' && !empty($slider->GambarLatar))
                                <img src="{{ asset('storage/' . $slider->GambarLatar) }}" alt="{{ $slider->TeksPenuh ?? 'Hero Slider' }}" class="hero-bg-media">
                            @else
                                <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop" alt="Technology Background" class="hero-bg-media">
                            @endif
                        </div>

                        {{-- Bentuk custom jika di-set --}}
                        @if(!empty($slider->GambarBentuk))
                            <div class="absolute top-0 right-0 w-96 h-96 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse pointer-events-none z-10"
                                style="background: url('{{ asset('storage/' . $slider->GambarBentuk) }}') center/cover no-repeat;">
                            </div>
                        @else
                            <div class="absolute top-0 right-0 w-96 h-96 bg-slate-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse pointer-events-none z-10"></div>
                        @endif
                        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse pointer-events-none z-10" style="animation-delay: 2s;"></div>

                        <div class="container mx-auto px-6 relative z-20 flex items-center min-h-screen">
                            <div class="max-w-3xl animate-fade-in-up mx-auto w-full text-center">
                                @if(!empty($slider->SubJudul))
                                    <span class="inline-block py-1.5 px-4 rounded-full bg-slate-500/20 text-slate-100 text-sm font-semibold tracking-wide mb-6 border border-slate-500/30 backdrop-blur-sm">
                                        <i class="fa-solid fa-star mr-2 text-yellow-400"></i>
                                        {{ $slider->SubJudul }}
                                    </span>
                                @endif
                                <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
                                    {{ $slider->JudulUtama }}
                                    @if(!empty($slider->Highlight))
                                        <br>
                                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-cyan-300">
                                            {{ $slider->Highlight }}
                                        </span>
                                    @endif
                                    @if(!empty($slider->TeksPenuh)) <span> {{ $slider->TeksPenuh }} </span> @endif
                                </h1>
                                @if(!empty($slider->Deskripsi))
                                    <p class="text-lg md:text-xl text-slate-300 mb-8 leading-relaxed max-w-2xl mx-auto">
                                        {{ $slider->Deskripsi }}
                                    </p>
                                @endif
                                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                    @if(!empty($slider->TeksCTA) && !empty($slider->LinkCTA))
                                        <a href="{{ $slider->LinkCTA }}"
                                            class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-white transition-all duration-200 bg-slate-600 rounded-xl hover:bg-slate-500 hover:shadow-lg hover:shadow-slate-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-600 focus:ring-offset-slate-900">
                                            {!! $slider->TeksCTA !!}
                                            @if(Str::contains(strtolower($slider->TeksCTA), 'solusi')) <i class="fa-solid fa-arrow-right ml-2"></i> @endif
                                        </a>
                                    @endif
                                    @if(!empty($slider->TeksCTA2) && !empty($slider->LinkCTA2))
                                        <a href="{{ $slider->LinkCTA2 }}"
                                            class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-white transition-all duration-200 bg-transparent border-2 border-slate-600 rounded-xl hover:bg-white/10 hover:border-white focus:outline-none">
                                            {!! $slider->TeksCTA2 !!}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Scroll Down Indicator (Hanya tampil jika 1 slide) --}}
                        @if($heroCount === 1)
                            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce text-slate-400 z-20">
                                <i class="fa-solid fa-chevron-down text-2xl"></i>
                            </div>
                        @endif
                    </div>
                @endforeach

                {{-- ========================================== --}}
                {{-- NAVIGASI (Hanya muncul jika slide > 1)     --}}
                {{-- ========================================== --}}
                @if($heroCount > 1)
                    {{-- Tombol Panah Kiri --}}
                    <button id="heroPrev" class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white flex items-center justify-center transition-all hover:scale-110 focus:outline-none">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>

                    {{-- Tombol Panah Kanan --}}
                    <button id="heroNext" class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-30 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white flex items-center justify-center transition-all hover:scale-110 focus:outline-none">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>

                    {{-- Worm Page Indicator --}}
                    <div class="absolute z-30 bottom-16 left-1/2 transform -translate-x-1/2 flex gap-2 items-center">
                        @foreach($heroSliders as $slider)
                            <button class="hero-dot h-2 rounded-full bg-white/50 hover:bg-white/80 focus:outline-none
                                @if($loop->first) w-10 bg-slate-600 @else w-2 @endif"
                                aria-label="Slider Dot {{ $loop->iteration }}" data-index="{{ $loop->index }}">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>


    @else
        <div class="w-full min-h-screen flex items-center justify-center bg-slate-100">
            <p class="text-slate-600 text-lg">Data banner tidak ditemukan.</p>
        </div>
    @endif
</section>

    <!-- ========================================== -->
    <!-- 2. KEY FIGURES SECTION -->
    <!-- ========================================== -->
    <section id="about" class="relative py-20 bg-white -mt-16 z-20">
        <div class="container mx-auto px-6">
            <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8 md:p-12">
                @php
                    $figureCount = $KeyFigures->count();
                    // Limit to minimum 2 columns for very few items, max 5 on desktop
                    $colBase = $figureCount <= 2 ? $figureCount : ($figureCount >= 5 ? 5 : $figureCount);
                @endphp
                <div class="grid grid-cols-{{$figureCount < 2 ? 2 : $figureCount}} md:grid-cols-{{$colBase}} gap-8 md:gap-12 text-center divide-x-0 md:divide-x divide-slate-100">
                    @foreach($KeyFigures as $figure)
                        <div class="p-4 group cursor-default">
                            <div class="w-16 h-16 mx-auto bg-brand-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-brand-600 transition-colors duration-300">
                                @if(!empty($figure->Icon))
                                    <img src="{{ asset('storage/'.$figure->Icon) }}" alt="Icon" class="w-10 h-10 object-contain" />
                                @else
                                    <i class="fa-solid fa-circle-question text-2xl text-brand-600 group-hover:text-white transition-colors"></i>
                                @endif
                            </div>
                            <h3 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-2">
                                {{ $figure->Konten ?? '-' }}
                            </h3>
                            <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">
                                {{ $figure->Keterangan ?? '-' }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 3. SOLUTIONS SECTION -->
    <!-- ========================================== -->
    <section id="solusi" class="py-24 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-brand-600 font-bold tracking-wider uppercase text-sm">What We're Offering</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2 mb-4">Jasuindo Solutions</h2>
                <p class="text-slate-600 text-lg">
                    Solusi teknologi end-to-end yang dirancang untuk memenuhi kebutuhan spesifik bisnis Anda, merampingkan operasional, dan mendorong pertumbuhan.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach($Solution as $solusi)
                    <div class="solution-card group bg-white rounded-2xl overflow-hidden border border-slate-100">
                        <div class="relative h-48 overflow-hidden">
                            @if(!empty($solusi->Thumbnail))
                                <img src="{{ asset('storage/'.$solusi->Thumbnail) }}"
                                    alt="{{ $solusi->Judul ?? 'Thumbnail' }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="flex items-center justify-center w-full h-full bg-slate-100">
                                    <i class="fa-solid fa-image text-4xl text-slate-400"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-brand-600 transition-colors">
                                {{ $solusi->Judul ?? '-' }}
                            </h3>
                            <p class="text-slate-600 text-sm leading-relaxed mb-4">
                                {{ $solusi->DeskripsiSingkat ?? '-' }}
                            </p>
                            <a href="{{ url('solusi/'.$solusi->Slug) }}"
                                class="inline-flex items-center text-sm font-bold text-brand-600 hover:text-brand-800 transition-colors">
                                Baca Selengkapnya
                                <i class="fa-solid fa-arrow-right-long ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 4. CERTIFICATION & LOGOS SECTION (Marquee) -->
    <!-- ========================================== -->
    {{-- <section id="sertifikasi" class="py-20 bg-white border-t border-slate-100 overflow-hidden">
        <div class="container mx-auto px-6 mb-12 text-center">
            <span class="text-brand-600 font-bold tracking-wider uppercase text-sm">Trust & Compliance</span>
            <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Sertifikasi & Penghargaan</h2>
        </div>

        <div class="relative w-full">
            <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-white to-transparent z-10"></div>
            <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-white to-transparent z-10"></div>

            <div class="flex overflow-hidden">
                <div class="flex animate-marquee whitespace-nowrap">
                    <!-- Logo Set 1 -->
                    <div class="flex items-center space-x-16 mx-8">
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-certificate text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">ISO 27001</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-shield-halved text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">ISO 9001:2015</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-building-shield text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">PCI-DSS</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-award text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">BSI Certified</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-trophy text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">Top IT Solution</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-globe text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">Kominfo RI</span>
                        </div>
                    </div>
                    <!-- Logo Set 2 (Duplicate for seamless loop) -->
                    <div class="flex items-center space-x-16 mx-8">
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-certificate text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">ISO 27001</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-shield-halved text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">ISO 9001:2015</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-building-shield text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">PCI-DSS</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-award text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">BSI Certified</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-trophy text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">Top IT Solution</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-globe text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">Kominfo RI</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    {{-- SECTION PENGHARGAAN & SERTIFIKASI --}}
<section id="sertifikasi" class="py-24 bg-white">
    <div class="container mx-auto px-6">

        {{-- HEADER SECTION --}}
        <div class="max-w-3xl mb-16">
            <div class="flex items-center gap-3 mb-4">
                <span class="h-px w-8 bg-brand-600"></span>
                <span class="text-xs font-semibold text-brand-600 uppercase tracking-widest">Penghargaan & Sertifikasi</span>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-900 tracking-tight mb-4">
                Standar Kualitas Global
            </h2>
            <p class="text-slate-500 leading-relaxed text-lg">
                Komitmen kami terhadap keunggulan secara konsisten diakui oleh lembaga sertifikasi internasional dan publikasi bisnis global terkemuka.
            </p>
        </div>

        {{-- PARTNER ROW (Trust Bar) --}}
       {{-- PARTNER ROW (Trust Bar) --}}
@php
    $partners = $logo->where('Tipe', 'Partner')->where('Status', 'Aktif')->sortBy('Urutan');
@endphp

@if ($partners->count() > 0)
    <div class="mb-20">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-8 text-center">
            Dipercaya oleh
        </p>
        <div class="flex flex-wrap justify-center gap-x-10 gap-y-8">
            @foreach ($partners as $partner)
                <a href="{{ $partner->UrlWebsite ?? '#' }}"
                   target="_blank"
                   class="group flex flex-col items-center justify-center text-center opacity-70 hover:opacity-100 transition-all duration-300 w-36">

                    @if ($partner->PathLogo)
                        <img src="{{ asset('storage/' . $partner->PathLogo) }}"
                             alt="{{ $partner->NamaPartner }}"
                             class="h-14 w-auto object-contain mb-3 transition-all duration-300 group-hover:scale-105">
                    @else
                        <div class="h-14 w-14 flex items-center justify-center text-slate-400 font-bold text-xl mb-3 group-hover:text-brand-600 transition-colors rounded-lg bg-slate-50">
                            {{ substr($partner->NamaPartner, 0, 2) }}
                        </div>
                    @endif

                    <span class="text-sm font-medium text-slate-700 group-hover:text-brand-600 transition-colors leading-tight">
                        {{ $partner->NamaPartner }}
                    </span>

                    @if ($partner->details->first()?->SubJudul)
                        <span class="text-[10px] text-slate-400 mt-1 uppercase tracking-wide leading-tight">
                            {{ $partner->details->first()->SubJudul }}
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
@endif

        {{-- AWARDS / CERTIFICATIONS GRID --}}
        @php
            $sertifikats = $logo->where('Tipe', 'Sertifikasi')->where('Status', 'Aktif')->sortBy('Urutan');
        @endphp

        @if ($sertifikats->count() > 0)
            <div>
                <div class="flex items-center gap-3 mb-8">
                    <span class="h-px w-8 bg-slate-300"></span>
                    <h3 class="text-xl font-semibold text-slate-900">Penghargaan & Akreditasi</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($sertifikats as $sertifikat)
                        @php
                            $detail = $sertifikat->details->first();
                        @endphp

                        <div class="group relative bg-white border border-slate-100 rounded-2xl p-6 hover:border-brand-200 hover:shadow-xl hover:shadow-brand-900/5 transition-all duration-300 flex flex-col h-full">

                            {{-- Year / Badge --}}
                            @if ($detail && $detail->SubJudul)
                                <div class="inline-flex items-center px-2.5 py-1 rounded-full bg-slate-50 text-slate-600 text-xs font-semibold tracking-wide mb-4 w-fit group-hover:bg-brand-50 group-hover:text-brand-700 transition-colors">
                                    {{ $detail->SubJudul }}
                                </div>
                            @endif

                            {{-- Title --}}
                            <h4 class="text-lg font-bold text-slate-900 mb-3 leading-snug">
                                {{ $detail ? $detail->Judul : $sertifikat->NamaPartner }}
                            </h4>

                            {{-- Description --}}
                            @if ($detail && $detail->Deskripsi)
                                <p class="text-sm text-slate-500 leading-relaxed mb-6 flex-grow">
                                    {{ Str::limit($detail->Deskripsi, 120) }}
                                </p>
                            @else
                                <div class="flex-grow"></div>
                            @endif

                            {{-- Footer / Logo --}}
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                @if ($detail && $detail->PathLogo)
                                    <div class="flex items-center gap-3">
                                        <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Certified By</span>
                                        <img src="{{ asset('storage/' . $detail->PathLogo) }}"
                                             alt="Certification Logo"
                                             class="h-6 object-contain opacity-60 group-hover:opacity-100 transition-opacity">
                                    </div>
                                @else
                                    <span class="text-xs font-medium text-brand-600 flex items-center gap-1 group-hover:gap-2 transition-all">
                                        Pelajari lebih lanjut
                                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                    </span>
                                @endif
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>
    <!-- ========================================== -->
    <!-- 5. WHY CHOOSE US SECTION -->
    <!-- ========================================== -->
    <section id="why-us" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <span class="inline-block py-1.5 px-4 rounded-full bg-brand-100/70 text-brand-900 text-sm font-semibold tracking-wide mb-4 border border-brand-600/20">
                    <i class="fa-solid fa-star mr-2"></i>Mengapa Memilih Kami?
                </span>
                <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-6 leading-tight">Why Choose Us</h2>
                <p class="text-lg text-slate-600 mb-0">
                    Keunggulan kami sebagai partner transformasi digital Anda.
                </p>
            </div>
            @php
                // Tentukan jumlah kolom responsive grid
                $count = count($Why);
                // Default 1 kolom
                $gridCols = 'grid-cols-1';
                $mdGridCols = '';
                $lgGridCols = '';
                if($count == 2) {
                    $mdGridCols = 'md:grid-cols-2';
                } elseif ($count == 3) {
                    $mdGridCols = 'md:grid-cols-2';
                    $lgGridCols = 'lg:grid-cols-3';
                } elseif ($count == 4) {
                    $mdGridCols = 'md:grid-cols-2';
                    $lgGridCols = 'lg:grid-cols-4';
                } elseif ($count == 5) {
                    $mdGridCols = 'md:grid-cols-2';
                    $lgGridCols = 'lg:grid-cols-5';
                } elseif ($count == 6) {
                    $mdGridCols = 'md:grid-cols-3';
                    $lgGridCols = 'lg:grid-cols-6';
                } elseif ($count > 6) {
                    $mdGridCols = 'md:grid-cols-3';
                    $lgGridCols = 'lg:grid-cols-4';
                    // You can customize for more than 6 items as needed
                }
                $gridClass = trim("grid $gridCols $mdGridCols $lgGridCols gap-8");
            @endphp
            <div class="{{ $gridClass }}">
                @foreach($Why as $item)
                    <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-xl transition-all duration-300">
                        @if(!empty($item->Icon))
                            <div class="text-brand-600 mb-4 text-4xl">
                                <i class="{{ $item->Icon }}"></i>
                            </div>
                        @endif
                        <h3 class="font-bold text-lg mb-2">{{ $item->Judul }}</h3>
                        <p class="text-slate-600 mb-0">
                            {{ $item->Deskripsi }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 6. CTA / CONTACT SECTION -->
    <!-- ========================================== -->
    <section id="kontak"
        class="py-20 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-950 relative overflow-hidden">
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>
        <div
            class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <span
                    class="inline-block py-1.5 px-4 rounded-full bg-brand-500/20 text-brand-100 text-sm font-semibold tracking-wide mb-6 border border-brand-500/30">
                    <i class="fa-solid fa-handshake mr-2"></i> Mari Berkolaborasi
                </span>
                <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6 leading-tight">
                    Siap Memulai Transformasi Digital <br class="hidden md:block">Bersama Kami?
                </h2>
                <p class="text-lg text-slate-300 mb-10 max-w-2xl mx-auto">
                    Tim ahli kami siap membantu Anda merancang solusi teknologi yang tepat untuk kebutuhan bisnis Anda.
                    Hubungi kami untuk konsultasi gratis.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="mailto:{{ $websiteSettings->AlamatEamail ?? 'info@jasuindo.co.id' }}"
                        class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-white transition-all duration-200 bg-brand-600 rounded-xl hover:bg-brand-500 hover:shadow-lg hover:shadow-brand-500/30">
                        <i class="fa-solid fa-envelope mr-2"></i> Email Kami
                    </a>
                    <a href="tel:{{ $websiteSettings->NomorTelepon ?? '+62318910919' }}"
                        class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-white transition-all duration-200 bg-transparent border-2 border-white/30 rounded-xl hover:bg-white/10 hover:border-white">
                        <i class="fa-solid fa-phone mr-2"></i> {{ $websiteSettings->TelpPerusahaan ?? '+62 31 8910919' }}
                    </a>

                </div>
            </div>
        </div>
    </section>
@endsection
   @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sliderContainer = document.getElementById('hero-slider');
                const slides = sliderContainer.querySelectorAll('.hero-slide');
                const dots = sliderContainer.querySelectorAll('.hero-dot');
                const btnPrev = document.getElementById('heroPrev');
                const btnNext = document.getElementById('heroNext');
                const totalSlides = slides.length;

                // Hentikan script jika hanya ada 1 slide
                if (totalSlides <= 1) return;

                let current = 0;
                let interval = null;
                const AUTOPLAY_DELAY = 7000; // Ganti slide setiap 7 detik

                function showSlide(idx) {
                    // Update Slides
                    slides.forEach((slide, i) => {
                        if (i === idx) {
                            slide.classList.remove('opacity-0', 'z-0', 'pointer-events-none');
                            slide.classList.add('opacity-100', 'z-10');
                        } else {
                            slide.classList.remove('opacity-100', 'z-10');
                            slide.classList.add('opacity-0', 'z-0', 'pointer-events-none');
                        }
                    });

                    // Update Worm Dots
                    dots.forEach((dot, i) => {
                        if (i === idx) {
                            dot.classList.remove('w-2', 'bg-white/50');
                            dot.classList.add('w-10', 'bg-slate-600');
                        } else {
                            dot.classList.remove('w-10', 'bg-slate-600');
                            dot.classList.add('w-2', 'bg-white/50');
                        }
                    });
                    current = idx;
                }

                function nextSlide() {
                    current = (current + 1) % totalSlides;
                    showSlide(current);
                }

                function prevSlide() {
                    current = (current - 1 + totalSlides) % totalSlides;
                    showSlide(current);
                }

                function startAutoplay() {
                    stopAutoplay();
                    interval = setInterval(nextSlide, AUTOPLAY_DELAY);
                }

                function stopAutoplay() {
                    if (interval) {
                        clearInterval(interval);
                        interval = null;
                    }
                }

                // Event Listeners untuk Navigasi
                if (btnNext) {
                    btnNext.addEventListener('click', () => {
                        nextSlide();
                        startAutoplay(); // Reset timer
                    });
                }

                if (btnPrev) {
                    btnPrev.addEventListener('click', () => {
                        prevSlide();
                        startAutoplay(); // Reset timer
                    });
                }

                dots.forEach((dot) => {
                    dot.addEventListener('click', function() {
                        const idx = parseInt(this.getAttribute('data-index'));
                        showSlide(idx);
                        startAutoplay(); // Reset timer
                    });
                });

                // Pause autoplay saat mouse hover di area slider (UX Friendly)
                sliderContainer.addEventListener('mouseenter', stopAutoplay);
                sliderContainer.addEventListener('mouseleave', startAutoplay);

                // Mulai autoplay saat halaman dimuat
                startAutoplay();
            });
        </script>
        @endpush

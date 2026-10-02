@extends('frontend.index')

@section('content-frontend')
    @php
        use App\Models\HeroSlider;
        use Illuminate\Support\Facades\Storage;

        $heroSliders = HeroSlider::where('Status', '1')->orderBy('Urutan', 'asc')->get();
        $heroCount = $heroSliders->count();
        $locale = app()->getLocale();

        // Berita untuk section news (featured + list)
        $homeNews = \App\Models\Berita::where('Status', 'Diterbitkan')->latest('TanggalPublikasi')->take(3)->get();

        // Gabungan logo partner + sertifikasi untuk carousel
        $allLogos = $logo->where('Status', 'Aktif')->sortBy('Urutan');

        // Data statis: Security Tiers (multi-bahasa inline)
        $tiers = [
            [
                'tier' => 'TIER 01',
                'icon' => 'fa-regular fa-eye',
                'title' => $locale === 'en' ? 'Overt Security Features' : 'Fitur Keamanan Kasat Mata',
                'desc' =>
                    $locale === 'en'
                        ? 'Visual security elements verifiable without special tools.'
                        : 'Elemen keamanan visual yang dapat diverifikasi tanpa alat khusus.',
                'features' => [
                    [
                        't' => 'Diffractive OVD Hologram',
                        'd' =>
                            $locale === 'en' ? '2D/3D kinetic images & microtext.' : 'Citra kinetik 2D/3D & microtext.',
                    ],
                    [
                        't' => 'Visual Effect Ink / OVI',
                        'd' =>
                            $locale === 'en'
                                ? 'Two-tone color shift when tilted.'
                                : 'Perubahan warna dua nada saat dimiringkan.',
                    ],
                ],
            ],
            [
                'tier' => 'TIER 02',
                'icon' => 'fa-solid fa-sliders',
                'title' => $locale === 'en' ? 'Covert Security Features' : 'Fitur Keamanan Tersembunyi',
                'desc' =>
                    $locale === 'en'
                        ? 'Hidden features requiring simple detection tools.'
                        : 'Fitur tersembunyi yang membutuhkan alat deteksi sederhana.',
                'features' => [
                    [
                        't' => 'Fluorescent Ink / UV',
                        'd' =>
                            $locale === 'en'
                                ? 'Glows under UV & IR wavelengths.'
                                : 'Menyala di bawah panjang gelombang UV & IR.',
                    ],
                    [
                        't' => 'High-Security Microtext',
                        'd' =>
                            $locale === 'en'
                                ? 'Extremely small repeating text lines.'
                                : 'Baris teks berulang yang sangat kecil.',
                    ],
                ],
            ],
            [
                'tier' => 'TIER 03',
                'icon' => 'fa-solid fa-qrcode',
                'title' => $locale === 'en' ? 'Tracking & Traceability System' : 'Sistem Pelacakan & Rekam Jejak',
                'desc' =>
                    $locale === 'en'
                        ? 'Machine-readable numbering for authentication & integration.'
                        : 'Penomoran machine-readable untuk autentikasi & integrasi.',
                'features' => [
                    [
                        't' => 'Serialization & QR Cryptoglyph',
                        'd' =>
                            $locale === 'en'
                                ? 'Unique code per document, tamper-proof.'
                                : 'Kode unik per dokumen, anti-pemalsuan.',
                    ],
                    [
                        't' => 'RFID & NFC Auto Sync',
                        'd' =>
                            $locale === 'en' ? 'Real-time chip data verification.' : 'Verifikasi data chip real-time.',
                    ],
                ],
            ],
            [
                'tier' => 'TIER 04',
                'icon' => 'fa-solid fa-fingerprint',
                'title' => $locale === 'en' ? 'Special & Forensic Security' : 'Fitur Keamanan Khusus & Forensik',
                'desc' =>
                    $locale === 'en'
                        ? 'Laboratory-level features for legal enforcement.'
                        : 'Fitur tingkat laboratorium untuk penegakan hukum.',
                'features' => [
                    [
                        't' => 'Simulant Chemical Taggant',
                        'd' =>
                            $locale === 'en'
                                ? 'Micro-chemistry unique to each institution.'
                                : 'Mikro-kimia unik per institusi.',
                    ],
                    [
                        't' => 'Kripto / SAM Enclaves',
                        'd' =>
                            $locale === 'en'
                                ? 'Cryptographic keys in secure hardware.'
                                : 'Kunci kriptografi dalam hardware aman.',
                    ],
                ],
            ],
        ];

        // Data statis: Kapabilitas
        $capabilities = [
            [
                'icon' => 'fa-solid fa-shuffle',
                'title' => $locale === 'en' ? 'Unique & Agile Approach' : 'Pendekatan Unik & Agil',
                'desc' =>
                    $locale === 'en'
                        ? 'Unlike conventional competitors, our manufacturing structure is designed to respond to specific customization needs of corporate and government clients.'
                        : 'Tidak seperti kompetitor konvensional, struktur manufaktur kami dirancang untuk responsif terhadap kebutuhan kustomisasi spesifik pelanggan korporat dan kementerian.',
                'foot' =>
                    $locale === 'en'
                        ? 'Agile & Customer-Centric Production Scheduling'
                        : 'Agile & Customer-Centric Production Scheduling',
                'footIcon' => 'fa-solid fa-bolt',
                'footColor' => 'text-brand-600',
            ],
            [
                'icon' => 'fa-solid fa-gears',
                'title' =>
                    $locale === 'en'
                        ? 'World-Class R&D with Global Partners'
                        : 'R&D Berkelas Dunia Bersama Mitra Global',
                'desc' =>
                    $locale === 'en'
                        ? 'Collaborating with Toppan (largest security printing company in the world), our consortium accesses the latest technology transfer for continuous innovation.'
                        : 'Bekerja sama dengan Toppan (perusahaan percetakan sekuriti terbesar di dunia), konsorsium kami mendapatkan akses transfer teknologi terkini untuk inovasi berkelanjutan.',
                'foot' =>
                    $locale === 'en'
                        ? 'Global Alliances: TOPPAN Printing & Innovia Biometrik'
                        : 'Global Alliances: TOPPAN Printing & Innovia Biometrik',
                'footIcon' => 'fa-solid fa-globe',
                'footColor' => 'text-brand-600',
            ],
            [
                'icon' => 'fa-solid fa-earth-asia',
                'title' =>
                    $locale === 'en' ? 'National-Level Export Track Record' : 'Rekam Jejak Ekspor Tingkat Nasional',
                'desc' =>
                    $locale === 'en'
                        ? 'Jasuindo is a trusted security printing company and one of the few in Indonesia exporting passports and identity cards to more than 15 jurisdictions worldwide.'
                        : 'Jasuindo adalah entitas security printing terpercaya dan satu-satunya di Indonesia yang dipercaya mengekspor paspor dan komponen kartu identitas ke lebih dari 15 yurisdiksi di seluruh dunia.',
                'foot' =>
                    $locale === 'en'
                        ? '15+ Sovereign Governments Worldwide Client Base'
                        : '15+ Sovereign Governments Worldwide Client Base',
                'footIcon' => 'fa-solid fa-plane-departure',
                'footColor' => 'text-brand-600',
            ],
            [
                'icon' => 'fa-solid fa-award',
                'title' =>
                    $locale === 'en'
                        ? 'Highest Accreditation & Clean Governance'
                        : 'Akreditasi Tertinggi & Tata Kelola Bersih',
                'desc' =>
                    $locale === 'en'
                        ? 'Accredited by Forbes Asia "Best Under a Billion", operational certification BOTAISUPAI, Bank Indonesia accreditation, and PCI-DSS Level 1 security standard.'
                        : 'Sembilan kali penghargaan Forbes Asia "Best Under a Billion", akreditasi operasional BOTAISUPAI, akreditasi Bank Indonesia, serta standar keamanan PCI-DSS Level 1.',
                'foot' =>
                    $locale === 'en'
                        ? '9x Forbes Asia & Indonesia Best Under a Billion Honoree'
                        : '9x Forbes Asia & Indonesia Best Under a Billion Honoree',
                'footIcon' => 'fa-solid fa-trophy',
                'footColor' => 'text-amber-500',
            ],
        ];
    @endphp

    @push('styles')
        <style>
            #hero-slider {
                position: relative;
                min-height: 92vh;
                display: flex;
                align-items: center;
                overflow: hidden;
                background-color: #082f49;
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

            #hero-slider .hero-dot {
                transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .line-clamp-3 {
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
        </style>
    @endpush

    <!-- ========================================== -->
    <!-- 1. HERO SLIDER -->
    <!-- ========================================== -->
    <section id="home" class="relative overflow-hidden">
        @if ($heroCount > 0)
            <div id="hero-slider" class="relative w-full">
                @foreach ($heroSliders as $slider)
                    @php
                        $hSubJudul =
                            $locale === 'en' && !empty($slider->SubJudulEn) ? $slider->SubJudulEn : $slider->SubJudul;
                        $hJudul =
                            $locale === 'en' && !empty($slider->JudulUtamaEn)
                                ? $slider->JudulUtamaEn
                                : $slider->JudulUtama;
                        $hHighlight =
                            $locale === 'en' && !empty($slider->HighlightEn)
                                ? $slider->HighlightEn
                                : $slider->Highlight;
                        $hDeskripsi =
                            $locale === 'en' && !empty($slider->DeskripsiEn)
                                ? $slider->DeskripsiEn
                                : $slider->Deskripsi;
                        $hTeksCTA =
                            $locale === 'en' && !empty($slider->TeksCTAEn) ? $slider->TeksCTAEn : $slider->TeksCTA;
                        $hTeksCTA2 =
                            $locale === 'en' && !empty($slider->TeksCTA2En) ? $slider->TeksCTA2En : $slider->TeksCTA2;
                    @endphp

                    <div
                        class="hero-slide w-full absolute inset-0 transition-opacity duration-700 @if ($loop->first) opacity-100 @else opacity-0 @endif flex items-center justify-center">

                        {{-- Background media --}}
                        <div class="absolute inset-0 z-0">
                            @if ($slider->TipeMedia == 'video' && !empty($slider->Video))
                                <video autoplay loop muted playsinline class="hero-bg-media">
                                    <source src="{{ asset('storage/' . $slider->Video) }}" type="video/mp4">
                                </video>
                            @elseif($slider->TipeMedia == 'image' && !empty($slider->GambarLatar))
                                <img src="{{ asset('storage/' . $slider->GambarLatar) }}" alt="{{ $hJudul }}"
                                    class="hero-bg-media">
                            @else
                                <img src="https://images.unsplash.com/photo-1565945932315-ec82aa1b4b4d?q=80&w=2070&auto=format&fit=crop"
                                    alt="Manufacturing" class="hero-bg-media">
                            @endif
                            {{-- Overlay navy agar teks terbaca --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-b from-brand-950/85 via-brand-900/70 to-brand-950/90">
                            </div>
                        </div>

                        {{-- Konten --}}
                        <div class="container mx-auto px-6 relative z-20 py-32">
                            <div class="max-w-3xl mx-auto text-center animate-fade-in-up">
                                <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
                                    {{ $hJudul }}
                                    @if (!empty($hHighlight))
                                        <br><span class="text-brand-400">{{ $hHighlight }}</span>
                                    @endif
                                </h1>
                                @if (!empty($hDeskripsi))
                                    <p class="text-base md:text-lg text-slate-300 mb-8 leading-relaxed max-w-2xl mx-auto">
                                        {{ $hDeskripsi }}
                                    </p>
                                @endif
                                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                    @if (!empty($hTeksCTA) && !empty($slider->LinkCTA))
                                        <a href="{{ $slider->LinkCTA }}"
                                            class="inline-flex justify-center items-center px-7 py-3.5 text-sm font-bold text-white bg-brand-600 hover:bg-brand-500 rounded-lg transition-all shadow-lg shadow-brand-600/30">
                                            {!! $hTeksCTA !!} <i class="fa-solid fa-arrow-right ml-2"></i>
                                        </a>
                                    @endif
                                    @if (!empty($hTeksCTA2) && !empty($slider->LinkCTA2))
                                        <a href="{{ $slider->LinkCTA2 }}"
                                            class="inline-flex justify-center items-center px-7 py-3.5 text-sm font-bold text-white border-2 border-white/60 hover:bg-white/10 rounded-lg transition-all">
                                            {!! $hTeksCTA2 !!}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($heroCount > 1)
                    <button id="heroPrev"
                        class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white flex items-center justify-center transition-all">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                    <button id="heroNext"
                        class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 z-30 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white flex items-center justify-center transition-all">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                    <div class="absolute z-30 bottom-8 left-1/2 -translate-x-1/2 flex gap-2 items-center">
                        @foreach ($heroSliders as $slider)
                            <button
                                class="hero-dot h-2 rounded-full bg-white/50 hover:bg-white/80 focus:outline-none @if ($loop->first) w-8 bg-white @else w-2 @endif"
                                aria-label="Slider Dot {{ $loop->iteration }}" data-index="{{ $loop->index }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <div class="w-full min-h-[70vh] flex items-center justify-center bg-brand-950">
                <p class="text-slate-400 text-lg">{{ __('No News Yet') }}</p>
            </div>
        @endif
    </section>

    <!-- ========================================== -->
    <!-- 2. KEY FIGURES (Overlapping Card) -->
    <!-- ========================================== -->
    <section id="about" class="relative z-20 -mt-14 pb-4">
        <div class="container mx-auto px-6">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-100 px-6 py-8 md:py-10">
                @php $figureCount = max($KeyFigures->count(), 1); @endphp
                <div
                    class="grid grid-cols-2 md:grid-cols-{{ min($figureCount, 5) }} gap-8 text-center divide-x-0 md:divide-x divide-slate-100">
                    @foreach ($KeyFigures as $figure)
                        @php
                            $fKonten =
                                $locale === 'en' && !empty($figure->KontenEn) ? $figure->KontenEn : $figure->Konten;
                            $fKeterangan =
                                $locale === 'en' && !empty($figure->KeteranganEn)
                                    ? $figure->KeteranganEn
                                    : $figure->Keterangan;
                        @endphp
                        <div class="flex flex-col items-center">
                            <div class="w-10 h-10 rounded-lg bg-brand-50 flex items-center justify-center mb-3">
                                @if (!empty($figure->Icon))
                                    <img src="{{ asset('storage/' . $figure->Icon) }}" alt="Icon"
                                        class="w-5 h-5 object-contain">
                                @else
                                    <i class="fa-solid fa-chart-simple text-brand-600"></i>
                                @endif
                            </div>
                            <h3 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-1">{{ $fKonten ?? '-' }}</h3>
                            <p class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider leading-snug">
                                {{ $fKeterangan ?? '-' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 3. KEUNGGULAN (Why Choose Us) -->
    <!-- ========================================== -->
    <section id="why-us" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">{{ __('Why Choose Us?') }}</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-3 mb-4">
                    {{ __('Security Without Compromise') }}</h2>
                <p class="text-slate-600 leading-relaxed">
                    {{ __('In an industry that demands absolute accuracy, precision, and integrity, every detail matters. Jasuindo integrates modern security technology, precise printing, and intelligent quality control to safeguard the sovereignty of identity and public trust.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($Why as $item)
                    @php
                        $trans = $item->translate($locale);
                        $wJudul = $trans->Judul ?: $item->Judul;
                        $wDeskripsi = $trans->Deskripsi ?: $item->Deskripsi;
                        $showImg = false;
                        if (!empty($item->Icon) && !\Illuminate\Support\Str::startsWith($item->Icon, 'fa-')) {
                            $showImg = Storage::disk('public')->exists($item->Icon);
                        }
                    @endphp
                    <div
                        class="bg-slate-50 border border-slate-200 rounded-xl p-6 text-left hover:border-brand-300 hover:bg-white hover:shadow-lg transition-all duration-300">
                        <div class="w-11 h-11 rounded-lg bg-brand-100 text-brand-600 flex items-center justify-center mb-4">
                            @if (!empty($item->Icon) && \Illuminate\Support\Str::startsWith($item->Icon, 'fa-'))
                                <i class="{{ $item->Icon }} text-lg"></i>
                            @elseif($showImg)
                                <img src="{{ asset('storage/' . $item->Icon) }}" alt="{{ $wJudul }}"
                                    class="w-6 h-6 object-contain">
                            @else
                                <i class="fa-solid fa-shield-halved text-lg"></i>
                            @endif
                        </div>
                        <h3 class="font-bold text-slate-900 mb-2">{{ $wJudul }}</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">{{ $wDeskripsi }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 4. EMPAT PILAR LAYANAN (Solutions) -->
    <!-- ========================================== -->
    <section id="solusi" class="py-20 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-end mb-12">
                <div>
                    <span
                        class="text-xs font-bold text-brand-600 uppercase tracking-widest">{{ __('Our Services') }}</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-3 leading-tight">
                        {{ __('Four Pillars of Integrated Security & Identity Manufacturing') }}
                    </h2>
                </div>
                <p class="text-slate-600 leading-relaxed">
                    {{ __('End-to-end solutions with international standards: from security micro-chips, anti-counterfeit passport manufacturing, to commercial printing of massive assets for your business.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($Solution as $solusi)
                    @php
                        $trans = $solusi->translate($locale);
                        $sJudul = $trans->Judul ?: $solusi->Judul;
                        $sDeskripsi = $trans->DeskripsiSingkat ?: $solusi->DeskripsiSingkat;
                        $poin = !empty($solusi->PoinUtama) ? array_filter(explode("\n", $solusi->PoinUtama)) : [];
                    @endphp
                    <div
                        class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col">
                        <div class="h-52 overflow-hidden">
                            @if (!empty($solusi->Thumbnail))
                                <img src="{{ asset('storage/' . $solusi->Thumbnail) }}" alt="{{ $sJudul }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-slate-200 flex items-center justify-center"><i
                                        class="fa-solid fa-image text-4xl text-slate-400"></i></div>
                            @endif
                        </div>
                        <div class="p-7 flex flex-col flex-grow">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="text-xl font-bold text-slate-900">{{ $sJudul }}</h3>
                                <div
                                    class="w-9 h-9 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center flex-shrink-0 ml-3">
                                    <i class="fa-solid fa-arrow-right text-sm"></i>
                                </div>
                            </div>
                            <p class="text-sm text-slate-600 leading-relaxed mb-4">{{ $sDeskripsi }}</p>

                            @if (count($poin) > 0)
                                <ul class="space-y-2 mb-5">
                                    @foreach ($poin as $p)
                                        <li class="flex items-start text-sm text-slate-700">
                                            <i
                                                class="fa-solid fa-circle-check text-brand-500 mr-2 mt-0.5"></i>{{ trim($p) }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <a href="{{ route('halaman-solusi.show', $solusi->Slug) }}"
                                class="mt-auto inline-flex items-center text-sm font-bold text-brand-600 hover:text-brand-700">
                                {{ __('Explore') }} {{ $sJudul }} <i
                                    class="fa-solid fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </a>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 5. SECURITY TIERS (Dark Section) -->
    <!-- ========================================== -->
    <section class="py-24 bg-brand-950 relative overflow-hidden">
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span
                    class="text-xs font-bold text-white uppercase tracking-widest">{{ __('Multi-Layer Security Architecture') }}</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-white mt-3 mb-4">
                    {{ __('Precision Security in Every Detail') }}</h2>
                <p class="text-white leading-relaxed">
                    {{ __('Document forgery requires more than just visual quality. We deploy layered security technology that can be adjusted to the threat profile and your needs.') }}
                </p>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($tiers as $t)
                    <div
                        class="bg-brand-900/60 border border-brand-800 rounded-xl p-6 hover:border-brand-600 transition-colors">
                        <div class="flex items-center justify-between mb-4">
                            <span
                                class="text-[10px] font-bold tracking-widest text-white bg-brand-800/70 px-2.5 py-1 rounded">{{ $t['tier'] }}</span>
                            <i class="{{ $t['icon'] }} text-white"></i>
                        </div>
                        <h3 class="font-bold text-white mb-2 leading-snug">{{ $t['title'] }}</h3>
                        <p class="text-xs text-white leading-relaxed mb-4">{{ $t['desc'] }}</p>
                        <div class="space-y-2">
                            @foreach ($t['features'] as $f)
                                <div class="bg-brand-950/70 rounded-lg p-3">
                                    <p class="text-xs font-semibold text-white mb-0.5">{{ $f['t'] }}</p>
                                    <p class="text-[11px] text-white leading-snug">{{ $f['d'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="text-center mt-12">
                <a href="{{ route('frontend.about-us') }}"
                    class="inline-flex items-center px-7 py-3.5 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-lg transition-all shadow-lg shadow-brand-600/30">
                    {{ __('Learn Our Track Record') }} <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 6. KAPABILITAS -->
    <!-- ========================================== -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mb-12">
                <span
                    class="text-xs font-bold text-brand-600 uppercase tracking-widest">{{ __('Jasuindo Advantages & Capabilities') }}</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-3 leading-tight">
                    {{ __('More Than Just Printing. We Safeguard What You Entrust.') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach ($capabilities as $c)
                    <div
                        class="bg-white border border-slate-200 rounded-xl p-7 hover:shadow-lg hover:border-brand-300 transition-all duration-300">
                        <div class="w-11 h-11 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center mb-4">
                            <i class="{{ $c['icon'] }} text-lg"></i>
                        </div>
                        <h3 class="font-bold text-lg text-slate-900 mb-2">{{ $c['title'] }}</h3>
                        <p class="text-sm text-slate-600 leading-relaxed mb-4">{{ $c['desc'] }}</p>
                        <div class="pt-4 border-t border-slate-100 flex items-center gap-2">
                            <i class="{{ $c['footIcon'] }} {{ $c['footColor'] }} text-sm"></i>
                            <span class="text-xs font-semibold {{ $c['footColor'] }}">{{ $c['foot'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 7. LOGO CAROUSEL (Marquee) -->
    <!-- ========================================== -->
    <section id="sertifikasi" class="py-14 border-y border-slate-100 bg-white overflow-hidden">
        <div class="container mx-auto px-6 mb-8">
            <p class="text-center text-[11px] font-semibold text-slate-400 uppercase tracking-widest">
                {{ __('Recognized & Certified by Domestic and International Credential Standards') }}
            </p>
        </div>

        <div class="relative w-full">
            <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-white to-transparent z-10"></div>
            <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-white to-transparent z-10"></div>

            <div class="flex overflow-hidden justify-center">
                <div class="flex flex-wrap justify-center">
                    @foreach ($allLogos as $l)
                        <div
                            class="flex items-center justify-center h-20 opacity-80 hover:opacity-100 transition-opacity my-6 mx-10">
                            @if ($l->PathLogo)
                                <img src="{{ asset('storage/' . $l->PathLogo) }}" alt="{{ $l->NamaPartner }}"
                                    class="h-14 w-auto object-contain">
                            @else
                                <span class="font-bold text-xl text-slate-500">{{ $l->NamaPartner }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    <!-- ========================================== -->
    <!-- 8. NEWS & REGULATORY INSIGHTS -->
    <!-- ========================================== -->
    @if ($homeNews->count() > 0)
        <section class="py-20 bg-slate-100">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

                    {{-- Featured Article (Left) --}}
                    @php
                        $featured = $homeNews->first();
                        $fTrans = $featured->translate($locale);
                    @endphp
                    <div class="lg:col-span-2">
                        <div class="bg-brand-950 rounded-2xl p-8 h-full flex flex-col relative overflow-hidden">
                            <div
                                class="absolute top-0 right-0 w-40 h-40 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20">
                            </div>
                            <div class="relative z-10 flex flex-col h-full">
                                <div class="flex items-center justify-between mb-6">
                                    <span
                                        class="text-[10px] font-bold text-white bg-brand-800/70 px-2.5 py-1 rounded uppercase tracking-widest">
                                        <i class="fa-solid fa-bolt mr-1"></i> {{ __('Latest Article') }}
                                    </span>

                                    <span
                                        class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($featured->TanggalPublikasi)->isoFormat('D MMM Y') }}</span>
                                </div>
                                <span
                                    class="text-[10px] font-semibold text-brand-400 uppercase tracking-widest mb-3">{{ $featured->Kategori }}</span>
                                <h3 class="text-2xl font-extrabold text-white leading-snug mb-4">
                                    {{ $fTrans->Judul ?: $featured->Judul }}</h3>
                                <p class="text-sm text-slate-400 leading-relaxed mb-6 line-clamp-3">
                                    {{ $fTrans->Ringkasan ?: $featured->Ringkasan }}</p>
                                <div class="flex items-center gap-2 text-xs text-slate-400 mb-6">
                                    <i class="fa-regular fa-user"></i> {{ $featured->Penulis ?? 'Admin' }}
                                    <span class="mx-1">•</span>
                                    <i class="fa-regular fa-clock"></i> 5 min read
                                </div>
                                <div class="mt-auto space-y-3">
                                    <a href="{{ route('frontend.detail', ['slug' => $featured->Slug]) }}"
                                        class="flex items-center justify-center w-full px-6 py-3 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-lg transition-colors">
                                        {{ __('Read Full Article') }} <i class="fa-solid fa-arrow-right ml-2"></i>
                                    </a>
                                    <a href="{{ route('frontend.news') }}"
                                        class="flex items-center justify-center w-full px-6 py-3 border border-brand-700 text-white hover:bg-brand-900 text-sm font-bold rounded-lg transition-colors">
                                        {{ __('Browse All Topics') }} <i class="fa-solid fa-arrow-right ml-2"></i>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- News List (Right) --}}
                    <div class="lg:col-span-3">
                        <div class="flex items-end justify-between mb-6">
                            <div>
                                <span
                                    class="text-xs font-bold text-brand-600 uppercase tracking-widest">{{ __('Latest Updates') }}</span>
                                <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mt-2">
                                    {{ __('News & Regulatory Insights') }}</h2>
                            </div>
                            <a href="{{ route('frontend.news') }}"
                                class="text-sm font-bold text-brand-600 hover:text-brand-700 whitespace-nowrap">
                                {{ __('View All News') }} <i class="fa-solid fa-arrow-right ml-1"></i>
                            </a>
                        </div>

                        <div class="space-y-5">
                            @foreach ($homeNews->slice(1, 2) as $n)
                                @php $nTrans = $n->translate($locale); @endphp
                                <div
                                    class="bg-white rounded-xl border border-slate-200 p-5 flex gap-5 hover:shadow-lg hover:border-brand-300 transition-all">
                                    <a href="{{ route('frontend.detail', ['slug' => $n->Slug]) }}" class="flex-shrink-0">
                                        <img src="{{ $n->PathThumbnail ? asset('storage/' . $n->PathThumbnail) : asset('img/no-image.png') }}"
                                            alt="{{ $nTrans->Judul ?: $n->Judul }}"
                                            class="w-28 h-24 object-cover rounded-lg">
                                    </a>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-3 text-[11px] mb-1.5">
                                            <span
                                                class="font-bold text-brand-600 uppercase tracking-wider">{{ $n->Kategori }}</span>
                                            <span class="text-slate-400"><i
                                                    class="fa-regular fa-calendar mr-1"></i>{{ \Carbon\Carbon::parse($n->TanggalPublikasi)->isoFormat('D MMM Y') }}</span>
                                        </div>
                                        <h4
                                            class="font-bold text-slate-900 leading-snug mb-1.5 line-clamp-2 hover:text-brand-600 transition-colors">
                                            <a
                                                href="{{ route('frontend.detail', ['slug' => $n->Slug]) }}">{{ $nTrans->Judul ?: $n->Judul }}</a>
                                        </h4>
                                        <p class="text-xs text-slate-500 leading-relaxed line-clamp-2 mb-2">
                                            {{ $nTrans->Ringkasan ?: $n->Ringkasan }}</p>
                                        <a href="{{ route('frontend.detail', ['slug' => $n->Slug]) }}"
                                            class="text-xs font-bold text-brand-600 hover:text-brand-700">
                                            {{ __('Read More') }} <i class="fa-solid fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- ========================================== -->
    <!-- 9. RFQ / CONTACT CARD -->
    <!-- ========================================== -->
    <section id="kontak" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div
                class="bg-brand-950 rounded-3xl p-8 md:p-12 grid grid-cols-1 lg:grid-cols-2 gap-10 relative overflow-hidden">
                <div
                    class="absolute bottom-0 left-0 w-72 h-72 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
                </div>

                {{-- Left: Info --}}
                <div class="relative z-10">
                    <span
                        class="inline-block text-[10px] font-bold text-white bg-brand-800/70 px-2.5 py-1 rounded uppercase tracking-widest mb-5">
                        <i class="fa-solid fa-file-signature mr-1"></i> {{ __('Government & Procurement (RFQ)') }}
                    </span>

                    <h2 class="text-3xl md:text-4xl font-extrabold text-white leading-tight mb-4">
                        {{ __('Interested in Our Solutions?') }}</h2>
                    <p class="text-slate-400 text-sm leading-relaxed mb-8">
                        {{ __('Do you have custom specifications or require enterprise-scale bidding? Fill out the Request for Quotation (RFQ) form and our team will provide the best technical consultation and field proposal for your institution.') }}
                    </p>

                    <div class="space-y-5 mb-8">
                        <div class="flex items-start gap-4">
                            <div
                                class="w-9 h-9 rounded-lg bg-brand-800/70 text-white flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-comments"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white mb-0.5">
                                    {{ __('Product Consultation & Customization') }}</p>
                                <p class="text-xs text-slate-400">Discuss technical specifications, multi-layer security
                                    features, and materials.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-9 h-9 rounded-lg bg-brand-800/70 text-white flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white mb-0.5">
                                    {{ __('Competitive & Transparent Quotation') }}</p>
                                <p class="text-xs text-slate-400">Clear pricing structure and volume-based procurement
                                    terms.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div
                                class="w-9 h-9 rounded-lg bg-brand-800/70 text-white flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-white mb-0.5">
                                    {{ __('Official Physical Sample Delivery') }}</p>
                                <p class="text-xs text-slate-400">We send specimen samples of security documents for your
                                    evaluation.</p>
                            </div>
                        </div>
                    </div>


                    <div class="pt-6 border-t border-brand-800 flex items-center gap-3">
                        <i class="fa-solid fa-headset text-brand-400"></i>
                        <p class="text-xs text-slate-400">{{ __('Prefer direct communication?') }} <a
                                href="tel:{{ $websiteSettings->NomorTelepon ?? '+62318910919' }}"
                                class="text-white font-bold hover:text-brand-300">{{ __('Hotline') }}:
                                {{ $websiteSettings->TelpPerusahaan ?? '(021) 526-1020' }}</a></p>
                    </div>
                </div>

                {{-- Right: Form --}}
                <div class="relative z-10">
                    <div class="bg-white rounded-2xl p-7 shadow-2xl">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-lg font-extrabold text-slate-900">{{ __('Quotation Form') }}</h3>
                            <span class="text-[10px] font-bold text-green-700 bg-green-100 px-2.5 py-1 rounded-full"><i
                                    class="fa-solid fa-bolt mr-1"></i>{{ __('Fast Response < 24 Hours') }}</span>
                        </div>

                        <form action="{{ route('frontend.contact.store') }}" method="POST" id="rfqForm">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1">{{ __('Full Name') }}
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" name="NamaLengkap" required
                                        placeholder="{{ __('Your full name') }}"
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-slate-700 mb-1">{{ __('Company / Institution') }}
                                        <span class="text-red-500">*</span></label>
                                    <input type="text" name="CompanyName" required
                                        placeholder="e.g. Bank Mandiri, BCA, PT Printek"
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label
                                    class="block text-xs font-semibold text-slate-700 mb-1">{{ __('Product / Solution Need') }}
                                    <span class="text-red-500">*</span></label>
                                <select name="ProdukYangDibutuhkan" required
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none">
                                    <option value="">-- {{ __('Select Product or Solution') }} --</option>
                                    @foreach ($Solution as $s)
                                        <option value="{{ $s->translate($locale)->Judul ?: $s->Judul }}">
                                            {{ $s->translate($locale)->Judul ?: $s->Judul }}</option>
                                    @endforeach
                                    <option value="Lainnya">{{ __('Other / Custom') }}</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-slate-700 mb-1">{{ __('Official Email') }}
                                        <span class="text-red-500">*</span></label>
                                    <input type="email" name="Email" required placeholder="nama@instansi.go.id"
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none">
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-semibold text-slate-700 mb-1">{{ __('Phone / WhatsApp') }}
                                        <span class="text-red-500">*</span></label>
                                    <input type="tel" name="NomorHandphone" required placeholder="0812-xxxx-xxxx"
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none">
                                </div>
                            </div>

                            <div class="mb-5">
                                <label
                                    class="block text-xs font-semibold text-slate-700 mb-1">{{ __('Message / Requirement Notes') }}</label>
                                <textarea name="Pesan" rows="4"
                                    placeholder="{{ __('Describe your product needs, estimated volume, or customization requirements...') }}"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none resize-none"></textarea>
                            </div>

                            <button type="submit"
                                class="w-full flex items-center justify-center px-6 py-3.5 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-lg transition-all shadow-lg shadow-brand-600/30">
                                {{ __('Send Quotation Request (RFQ)') }} <i class="fa-solid fa-arrow-right ml-2"></i>
                            </button>
                            <p class="text-[10px] text-slate-400 text-center mt-3 leading-relaxed">
                                {{ __('Your data will be processed confidentially and used only for the quotation process.') }}
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sliderContainer = document.getElementById('hero-slider');
            if (!sliderContainer) return;

            const slides = sliderContainer.querySelectorAll('.hero-slide');
            const dots = sliderContainer.querySelectorAll('.hero-dot');
            const btnPrev = document.getElementById('heroPrev');
            const btnNext = document.getElementById('heroNext');
            const totalSlides = slides.length;

            if (totalSlides <= 1) return;

            let current = 0;
            let interval = null;
            const AUTOPLAY_DELAY = 7000;

            function showSlide(idx) {
                slides.forEach((slide, i) => {
                    if (i === idx) {
                        slide.classList.remove('opacity-0', 'z-0', 'pointer-events-none');
                        slide.classList.add('opacity-100', 'z-10');
                    } else {
                        slide.classList.remove('opacity-100', 'z-10');
                        slide.classList.add('opacity-0', 'z-0', 'pointer-events-none');
                    }
                });
                dots.forEach((dot, i) => {
                    if (i === idx) {
                        dot.classList.remove('w-2', 'bg-white/50');
                        dot.classList.add('w-8', 'bg-white');
                    } else {
                        dot.classList.remove('w-8', 'bg-white');
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

            if (btnNext) btnNext.addEventListener('click', () => {
                nextSlide();
                startAutoplay();
            });
            if (btnPrev) btnPrev.addEventListener('click', () => {
                prevSlide();
                startAutoplay();
            });
            dots.forEach((dot) => {
                dot.addEventListener('click', function() {
                    showSlide(parseInt(this.getAttribute('data-index')));
                    startAutoplay();
                });
            });

            sliderContainer.addEventListener('mouseenter', stopAutoplay);
            sliderContainer.addEventListener('mouseleave', startAutoplay);
            startAutoplay();
        });
    </script>
@endpush

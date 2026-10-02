@extends('frontend.index')

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

        $split = function (?string $text) {
            if ($text === null || $text === '') {
                return ['', ''];
            }
            $plain = $text;
            if (str_contains($plain, '|||')) {
                [$a, $b] = array_pad(explode('|||', $plain, 2), 2, '');
                return [trim($a), trim($b)];
            }
            // Fallback: baris pertama = judul, sisanya = deskripsi
            $lines = preg_split("/\r\n|\n|\r/", strip_tags($plain));
            $first = trim($lines[0] ?? '');
            $rest = trim(implode("\n", array_slice($lines, 1)));
            return [$first, $rest];
        };

        $isFaIcon = function (?string $val) {
            if (!$val) {
                return false;
            }
            return str_starts_with($val, 'fa-') || str_starts_with($val, 'fa ') || str_contains($val, ' fa-');
        };

        $tabs = [
            ['label' => $en ? 'Company Profile' : 'Profil Perusahaan', 'href' => '#profil'],
            ['label' => $en ? 'Core Values' : 'Nilai Inti Perusahaan', 'href' => '#nilai'],
            ['label' => $en ? 'Social Responsibility (CSR)' : 'Tanggung Jawab Sosial (CSR)', 'href' => '#csr'],
            ['label' => $en ? 'Certifications & Awards' : 'Sertifikasi & Penghargaan', 'href' => '#sertifikasi'],
        ];

        $valueIcons = [
            'fa-solid fa-gem',
            'fa-solid fa-shield-halved',
            'fa-solid fa-sliders',
            'fa-solid fa-handshake',
            'fa-solid fa-star',
        ];

        $heroDetails = optional($Hero)->getDetail ?? collect();
        $timelineDetails = optional($Riwayat)->getDetail ?? collect();
        $valueDetails = optional($Value)->getDetail ?? collect();
        $csrDetails = optional($TanggungJawab)->getDetail ?? collect();
        $awardDetails = optional($Award)->getDetail ?? collect();
        $isoDetails = optional($Iso)->getDetail ?? collect();
        $ctaDetails = optional($Cta)->getDetail ?? collect();
        $awardsFirst = $awardDetails->take(6);
        $awardsRest = $awardDetails->slice(6)->values();

        $mediaMeta = $mediaMeta ?? [];
        $videoBadge = $mediaMeta['video_badge'] ?? ($en ? 'Official Company Profile Video 2024' : 'Video Profil Perusahaan Resmi 2024');
        $videoTagline = $mediaMeta['video_tagline'] ?? 'IDENTITAS • PEMBAYARAN • PROTEKSI MEREK';
        $videoUrl = $mediaMeta['video_url'] ?? null;
        $pdfUrl = $mediaMeta['pdf_url'] ?? '#';
        $quoteSubtitle = $mediaMeta['quote_subtitle'] ?? ($en ? 'Executive Governance Leadership' : 'Kepemimpinan & Tata Kelola Eksekutif');
        $quoteAuthor = $mediaMeta['quote_author'] ?? ($en ? 'Board of Directors' : 'Dewan Direksi');
        $quoteCompany = $mediaMeta['quote_company'] ?? 'PT Jasuindo Tiga Perkasa Tbk';
    @endphp

    @push('styles')
        <style>
            .mono-label {
                font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
                letter-spacing: .18em;
            }

            .timeline-item {
                position: relative;
                padding-left: 1.75rem;
                padding-bottom: 2rem;
                border-left: 2px solid #dbeafe;
            }

            .timeline-item:last-child {
                padding-bottom: 0;
                border-left-color: transparent;
            }

            .timeline-item::before {
                content: '';
                position: absolute;
                left: -7px;
                top: .35rem;
                width: 12px;
                height: 12px;
                border-radius: 9999px;
                background: #2563eb;
                box-shadow: 0 0 0 4px #dbeafe;
            }

            .tab-pill {
                transition: all .2s ease;
            }
        </style>
    @endpush

    <!-- 1. HERO + STATS -->
    <section class="relative pt-28 pb-16 bg-[#eef2fb] overflow-hidden">
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <nav
                    class="inline-flex items-center gap-2 bg-white border border-slate-200 rounded-full px-4 py-1.5 text-xs text-slate-500 mb-8 shadow-sm">
                    <a href="{{ route('frontend.main') }}" class="hover:text-blue-600 transition-colors"><i
                            class="fa-solid fa-house mr-1"></i>{{ __('Home') }}</a>
                    <span class="text-slate-300">/</span>
                    <span class="font-semibold text-slate-700">{{ $en ? 'About Us' : 'Tentang Kami' }}</span>
                </nav>

                <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 leading-tight mb-6">
                    {{ $tr($Hero, 'Judul') ?? ($en ? 'Safeguarding Trust, Advancing' : 'Menjaga Kepercayaan, Mengembangkan') }}<br>
                    <span class="text-blue-600">{{ $tr($Hero, 'SubJudul') ?? ($en ? 'Digital Identity & Security Document Credentials' : 'Kredensial Identitas & Dokumen Sekuritas Digital') }}</span>
                </h1>
                @if ($tr($Hero, 'Deskripsi'))
                    <div class="text-slate-600 leading-relaxed max-w-2xl mx-auto mb-12">{!! $tr($Hero, 'Deskripsi') !!}</div>
                @else
                    <p class="text-slate-600 leading-relaxed max-w-2xl mx-auto mb-12">
                        {{ $en ? 'Pioneer manufacturer of official state security documents, EMV banking chip infrastructure, cryptographic brand authentication, and integrated smart card solutions across Southeast Asia since 1990.' : 'Pelopor manufaktur dokumen sekuritas resmi negara, infrastruktur chip perbankan EMV, autentikasi merek kriptografis, dan solusi smart card terintegrasi di kawasan Asia Tenggara sejak 1990.' }}
                    </p>
                @endif

                @if ($heroDetails->count())
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-left">
                        @foreach ($heroDetails as $stat)
                            @php [$statLabel, $statDesc] = $split($tr($stat, 'Deskripsi')); @endphp
                            <div
                                class="bg-white border border-slate-200 rounded-lg px-5 py-4 shadow-sm hover:shadow-md hover:border-blue-200 transition-all">
                                <p class="mono-label text-[10px] font-bold text-blue-600 uppercase mb-2">
                                    {{ $statLabel ?: ($tr($stat, 'Judul') ?? '') }}
                                </p>
                                <p class="text-xl font-extrabold text-slate-900 mb-1">{{ $tr($stat, 'Judul') }}</p>
                                @if ($statDesc)
                                    <p class="text-[11px] text-slate-500 leading-snug">{{ $statDesc }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- 2. TAB NAVIGATION -->
    <div class="bg-[#eef2fb] pb-10">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap justify-center gap-2">
                @foreach ($tabs as $i => $tab)
                    <a href="{{ $tab['href'] }}" data-tab-link
                        class="tab-pill px-4 py-2 rounded-full text-xs font-semibold border {{ $i === 0 ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-600 border-slate-200 hover:border-blue-300 hover:text-blue-600' }}">
                        {{ $tab['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 3. COMPANY PROFILE -->
    <section id="profil" class="py-20 bg-white scroll-mt-24">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">
                <div class="space-y-6">
                    <div class="rounded-xl overflow-hidden border border-slate-200 shadow-lg group">
                        <div class="relative aspect-video bg-slate-900 overflow-hidden">
                            @php
                                $thumb = !empty($Media?->Gambar)
                                    ? asset('storage/' . $Media->Gambar)
                                    : 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop';
                            @endphp
                            <img src="{{ $thumb }}"
                                alt="{{ $en ? 'Company Profile Video' : 'Video Profil Perusahaan' }}"
                                class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-700">
                            <span
                                class="absolute top-4 left-4 mono-label text-[9px] font-bold text-white bg-slate-900/70 backdrop-blur-sm px-2.5 py-1 rounded uppercase tracking-widest">
                                <i class="fa-solid fa-circle-play mr-1"></i>
                                {{ $videoBadge }}
                            </span>
                            @if ($videoUrl)
                                <a href="{{ $videoUrl }}" target="_blank" rel="noopener"
                                    class="absolute inset-0 m-auto w-16 h-16 rounded-full bg-blue-600 hover:bg-blue-500 text-white flex items-center justify-center shadow-xl transition-colors"
                                    aria-label="Play">
                                    <i class="fa-solid fa-play ml-1"></i>
                                </a>
                            @else
                                <button
                                    class="absolute inset-0 m-auto w-16 h-16 rounded-full bg-blue-600 hover:bg-blue-500 text-white flex items-center justify-center shadow-xl transition-colors"
                                    aria-label="Play">
                                    <i class="fa-solid fa-play ml-1"></i>
                                </button>
                            @endif
                            <div
                                class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-slate-900/90 to-transparent p-4">
                                <p class="text-white font-bold text-sm">
                                    {{ $tr($Media, 'Judul') ?? ($en ? 'Driving Business Performance' : 'Memacu Kinerja Bisnis') }}
                                </p>
                                <p class="mono-label text-[9px] text-slate-300 uppercase tracking-widest">{{ $videoTagline }}</p>
                            </div>
                        </div>
                        <div class="bg-white px-5 py-3 flex items-center justify-between gap-3">
                            <span class="flex items-center gap-2 text-sm text-slate-600 font-medium">
                                <i class="fa-regular fa-file-pdf text-blue-600"></i>
                                {{ $en ? 'Download Company Profile' : 'Download Profil Perusahaan' }}
                            </span>
                            <a href="{{ $pdfUrl ?: '#' }}"
                                @if ($pdfUrl && $pdfUrl !== '#') target="_blank" rel="noopener" @endif
                                class="inline-flex items-center px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold rounded-lg transition-colors">
                                <i class="fa-solid fa-download mr-2"></i> {{ $en ? 'Download Profile' : 'Unduh Profil' }}
                            </a>
                        </div>
                    </div>

                    <div class="bg-[#eef2fb] rounded-xl p-7 border border-slate-200">
                        <div class="flex items-center gap-3 mb-4">
                            <i class="fa-solid fa-quote-left text-2xl text-blue-600"></i>
                            <div>
                                <h3 class="font-extrabold text-slate-900">
                                    {{ $tr($Media, 'SubJudul') ?? ($en ? 'Message from the Board of Directors' : 'Pesan Dewan Direksi') }}
                                </h3>
                                <p class="mono-label text-[9px] text-slate-500 uppercase tracking-widest">
                                    {{ $quoteSubtitle }}
                                </p>
                            </div>
                        </div>
                        @if ($tr($Media, 'Deskripsi'))
                            <div class="text-sm text-slate-600 leading-relaxed italic mb-5">{!! $tr($Media, 'Deskripsi') !!}</div>
                        @endif
                        <p class="text-sm font-bold text-slate-900">{{ $quoteAuthor }}</p>
                        <p class="text-xs text-slate-500">{{ $quoteCompany }}</p>
                    </div>
                </div>

                <div>
                    <p class="mono-label text-[10px] font-bold text-blue-600 uppercase mb-3">
                        {{ $tr($Riwayat, 'SubJudul') ?? ($en ? 'Precision & Track Record' : 'Presisi dan Rekam Jejak') }}
                    </p>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-4">
                        {{ $tr($Riwayat, 'Judul') ?? ($en ? 'Company Brief History' : 'Sejarah Singkat Perusahaan') }}
                    </h2>
                    @if ($tr($Riwayat, 'Deskripsi'))
                        <div class="text-sm text-slate-600 leading-relaxed mb-8">{!! $tr($Riwayat, 'Deskripsi') !!}</div>
                    @endif

                    @if ($timelineDetails->count())
                        <div class="mt-2">
                            @foreach ($timelineDetails as $item)
                                @php [$tTitle, $tDesc] = $split($tr($item, 'Deskripsi')); @endphp
                                <div class="timeline-item">
                                    <p class="text-sm font-extrabold text-blue-600 mb-1">
                                        {{ $tr($item, 'Judul') }}
                                        @if ($tTitle)
                                            <span class="text-slate-900 font-bold ml-1">{{ $tTitle }}</span>
                                        @endif
                                    </p>
                                    @if ($tDesc)
                                        <div class="text-xs text-slate-500 leading-relaxed">{!! $tDesc !!}</div>
                                    @elseif ($tr($item, 'Deskripsi') && !$tTitle)
                                        <div class="text-xs text-slate-500 leading-relaxed">{!! $tr($item, 'Deskripsi') !!}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- 4. CORE VALUES -->
    <section id="nilai" class="py-20 bg-[#eef2fb] scroll-mt-24">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <p class="mono-label text-[10px] font-bold text-blue-600 uppercase mb-3">
                    {{ $tr($Value, 'SubJudul') ?? ($en ? 'Working Guidance Matrix' : 'Matriks Panduan Kerja') }}
                </p>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">
                    {{ $tr($Value, 'Judul') ?? ($en ? 'Company Core Values' : 'Nilai–Nilai Utama Perusahaan') }}
                </h2>
                @if ($tr($Value, 'Deskripsi'))
                    <div class="text-slate-600 leading-relaxed">{!! $tr($Value, 'Deskripsi') !!}</div>
                @endif
            </div>

            @if ($valueDetails->count())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach ($valueDetails as $i => $detail)
                        <div
                            class="bg-white rounded-xl border border-slate-200 p-7 shadow-sm hover:shadow-lg hover:border-blue-200 transition-all">
                            <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center mb-5">
                                @if ($isFaIcon($detail->Gambar))
                                    <i class="{{ $detail->Gambar }} text-xl text-blue-600"></i>
                                @elseif (!empty($detail->Gambar))
                                    <img src="{{ asset('storage/' . $detail->Gambar) }}" alt=""
                                        class="w-6 h-6 object-contain">
                                @else
                                    <i class="{{ $valueIcons[$i % count($valueIcons)] }} text-xl text-blue-600"></i>
                                @endif
                            </div>
                            <h3 class="text-lg font-extrabold text-slate-900 mb-3">{{ $tr($detail, 'Judul') }}</h3>
                            <div class="text-sm text-slate-600 leading-relaxed">{!! $tr($detail, 'Deskripsi') !!}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- 5. CSR -->
    <section id="csr" class="py-20 bg-white scroll-mt-24">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div class="max-w-2xl">
                    <p class="mono-label text-[10px] font-bold text-blue-600 uppercase mb-3">
                        {{ $tr($TanggungJawab, 'SubJudul') ?? ($en ? 'Sustainable Impact' : 'Dampak Berkelanjutan') }}
                    </p>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">
                        {{ $tr($TanggungJawab, 'Judul') ?? ($en ? 'Corporate Social Responsibility' : 'Tanggung Jawab Sosial Perusahaan') }}
                    </h2>
                    @if ($tr($TanggungJawab, 'Deskripsi'))
                        <div class="text-slate-600 leading-relaxed">{!! $tr($TanggungJawab, 'Deskripsi') !!}</div>
                    @endif
                </div>
                <a href="{{ route('frontend.news') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold rounded-full transition-colors whitespace-nowrap shadow-md">
                    {{ $en ? 'View More CSR' : 'Lihat CSR Lainnya' }} <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>

            @if ($csrDetails->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($csrDetails as $detail)
                        <div
                            class="bg-white rounded-xl border border-slate-200 overflow-hidden flex flex-col sm:flex-row shadow-sm hover:shadow-lg hover:border-blue-200 transition-all group">
                            <div class="sm:w-44 h-40 sm:h-auto flex-shrink-0 overflow-hidden">
                                @if (!empty($detail->Gambar) && !$isFaIcon($detail->Gambar))
                                    <img src="{{ asset('storage/' . $detail->Gambar) }}" alt="{{ $tr($detail, 'Judul') }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                        <i class="fa-solid fa-image text-3xl text-slate-300"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6 flex flex-col">
                                <h3 class="font-extrabold text-slate-900 mb-2">{{ $tr($detail, 'Judul') }}</h3>
                                <div class="text-xs text-slate-500 leading-relaxed flex-grow">{!! $tr($detail, 'Deskripsi') !!}</div>
                                <a href="{{ route('frontend.news') }}"
                                    class="mono-label inline-flex items-center text-[10px] font-bold text-blue-600 uppercase tracking-widest mt-4 hover:text-blue-700">
                                    {{ __('Read More') }} <i class="fa-solid fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- 6. AWARDS & CERTIFICATIONS -->
    <section id="sertifikasi" class="py-20 bg-[#eef2fb] scroll-mt-24">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span
                    class="inline-block mono-label text-[10px] font-bold text-blue-600 bg-blue-50 border border-blue-100 px-4 py-1.5 rounded-full uppercase mb-4">
                    <i class="fa-solid fa-shield-halved mr-1"></i>
                    {{ $tr($Award, 'SubJudul') ?? ($en ? 'Integrated Global Authority & Compliance' : 'Otoritas & Kepatuhan Global Terintegrasi') }}
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">
                    {{ $tr($Award, 'Judul') ?? ($en ? 'High-Security Standard Awards & Certifications' : 'Penghargaan & Sertifikasi Berstandar Keamanan Tinggi') }}
                </h2>
                @if ($tr($Award, 'Deskripsi'))
                    <div class="text-slate-600 leading-relaxed">{!! $tr($Award, 'Deskripsi') !!}</div>
                @endif
            </div>

            @if ($awardsFirst->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
                    @foreach ($awardsFirst as $cert)
                        <div
                            class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-lg hover:border-blue-200 transition-all flex flex-col">
                            <div class="flex items-start justify-between gap-3 mb-4">
                                @if (!empty($cert->Gambar) && !$isFaIcon($cert->Gambar))
                                    <img src="{{ asset('storage/' . $cert->Gambar) }}" alt="{{ $tr($cert, 'Judul') }}"
                                        class="h-8 object-contain">
                                @else
                                    <span
                                        class="text-lg font-extrabold text-slate-900">{{ Str::limit($tr($cert, 'Judul'), 12) }}</span>
                                @endif
                            </div>
                            <h3 class="text-sm font-extrabold text-slate-900 mb-2">{{ $tr($cert, 'Judul') }}</h3>
                            <div class="text-xs text-slate-500 leading-relaxed flex-grow">{!! Str::limit(strip_tags($tr($cert, 'Deskripsi')), 160) !!}</div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($isoDetails->count() || $tr($Iso, 'Judul'))
                <div class="bg-slate-900 rounded-xl p-6 md:p-8 mb-8 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-start gap-4 mb-6">
                            <div class="w-10 h-10 rounded-lg bg-slate-800 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-certificate text-blue-400"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-extrabold">
                                    {{ $tr($Iso, 'Judul') ?? ($en ? 'ISO Certification Suite (Complete ISO Range)' : 'ISO Certification Suite (Rangkaian ISO Lengkap)') }}
                                </h3>
                                <p class="mono-label text-[9px] text-slate-400 uppercase tracking-widest mt-1">
                                    {{ $tr($Iso, 'SubJudul') ?? ($en ? 'Accredited by INTERGRAF, TÜV NORD, Assurance Quality Certification, and QFS' : 'Terakreditasi oleh INTERGRAF, TÜV NORD, Assurance Quality Certification, dan QFS') }}
                                </p>
                            </div>
                        </div>

                        @if ($isoDetails->count())
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                                @foreach ($isoDetails as $iso)
                                    <div
                                        class="bg-slate-800/60 border border-slate-700 rounded-lg p-4 hover:border-blue-500/50 transition-colors">
                                        <p class="flex items-center gap-2 text-xs font-bold text-white mb-1">
                                            <i class="fa-solid fa-circle-check text-blue-400"></i> {{ $tr($iso, 'Judul') }}
                                        </p>
                                        <div class="text-[11px] text-slate-400 leading-snug pl-6">{!! $tr($iso, 'Deskripsi') !!}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if ($tr($Iso, 'Deskripsi'))
                            <div class="mt-6 pt-4 border-t border-slate-800 flex flex-col md:flex-row justify-between gap-2">
                                <span class="mono-label text-[9px] text-slate-500 uppercase">{!! strip_tags($tr($Iso, 'Deskripsi')) !!}</span>
                                <span
                                    class="mono-label text-[9px] font-bold text-blue-400 uppercase">{{ $en ? 'Full Integrated Compliance' : 'Kepatuhan Terintegrasi Penuh' }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if ($awardsRest->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach ($awardsRest as $cert)
                        <div
                            class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm hover:shadow-lg hover:border-blue-200 transition-all flex flex-col">
                            <div class="flex items-start justify-between gap-3 mb-4">
                                @if (!empty($cert->Gambar) && !$isFaIcon($cert->Gambar))
                                    <img src="{{ asset('storage/' . $cert->Gambar) }}" alt="{{ $tr($cert, 'Judul') }}"
                                        class="h-8 object-contain">
                                @else
                                    <span
                                        class="text-lg font-extrabold text-slate-900">{{ Str::limit($tr($cert, 'Judul'), 12) }}</span>
                                @endif
                            </div>
                            <h3 class="text-sm font-extrabold text-slate-900 mb-2">{{ $tr($cert, 'Judul') }}</h3>
                            <div class="text-xs text-slate-500 leading-relaxed flex-grow">{!! Str::limit(strip_tags($tr($cert, 'Deskripsi')), 160) !!}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- 7. CTA -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="bg-slate-900 rounded-2xl p-8 md:p-14 relative overflow-hidden">
                <i
                    class="fa-solid fa-shield-halved absolute -right-6 top-1/2 -translate-y-1/2 text-[220px] text-white/5 rotate-12"></i>
                <div class="relative z-10 max-w-3xl">
                    <span
                        class="inline-block mono-label text-[9px] font-bold text-blue-300 bg-blue-500/10 border border-blue-500/30 px-3 py-1.5 rounded uppercase tracking-widest mb-5">
                        <i class="fa-solid fa-landmark mr-1"></i>
                        {{ $tr($Cta, 'SubJudul') ?? ($en ? 'Sovereign Government & Enterprise Service Desk' : 'Meja Layanan Pemerintah Berdaulat & Enterprise') }}
                    </span>
                    <h2 class="text-2xl md:text-4xl font-extrabold text-white leading-tight mb-4">
                        {{ $tr($Cta, 'Judul') ?? ($en ? 'Strategic Partner for Leading Credential & Security Document Provision in Southeast Asia' : 'Mitra Strategis Penyedia Kredensial & Dokumen Sekuritas Terdepan di Asia Tenggara') }}
                    </h2>
                    @if ($tr($Cta, 'Deskripsi'))
                        <div class="text-slate-400 text-sm leading-relaxed mb-8 max-w-2xl">{!! $tr($Cta, 'Deskripsi') !!}</div>
                    @endif
                    <div class="flex flex-col sm:flex-row gap-4">
                        @forelse ($ctaDetails as $i => $btn)
                            <a href="{{ $tr($btn, 'Deskripsi') ?: route('frontend.contact.index') }}"
                                class="inline-flex items-center justify-center px-7 py-3.5 {{ $i === 0 ? 'bg-blue-600 hover:bg-blue-500 text-white shadow-lg shadow-blue-600/30' : 'border border-slate-600 text-slate-200 hover:bg-white/5' }} text-sm font-bold rounded-lg transition-colors">
                                @if ($i > 0)
                                    <i class="fa-regular fa-file-lines mr-2"></i>
                                @endif
                                {{ $tr($btn, 'Judul') }}
                                @if ($i === 0)
                                    <i class="fa-solid fa-arrow-right ml-2"></i>
                                @endif
                            </a>
                        @empty
                            <a href="{{ route('frontend.contact.index') }}"
                                class="inline-flex items-center justify-center px-7 py-3.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold rounded-lg transition-colors shadow-lg shadow-blue-600/30">
                                {{ $en ? 'Start Consultation' : 'Mulai Konsultasi' }} <i
                                    class="fa-solid fa-arrow-right ml-2"></i>
                            </a>
                            <a href="#sertifikasi"
                                class="inline-flex items-center justify-center px-7 py-3.5 border border-slate-600 text-slate-200 hover:bg-white/5 text-sm font-bold rounded-lg transition-colors">
                                <i class="fa-regular fa-file-lines mr-2"></i>
                                {{ $en ? 'Review Compliance & Certification Documents' : 'Tinjau Dokumen Kepatuhan & Sertifikasi' }}
                            </a>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('[data-tab-link]').forEach(function(link) {
            link.addEventListener('click', function() {
                document.querySelectorAll('[data-tab-link]').forEach(function(b) {
                    b.classList.remove('bg-slate-900', 'text-white', 'border-slate-900');
                    b.classList.add('bg-white', 'text-slate-600', 'border-slate-200');
                });
                this.classList.add('bg-slate-900', 'text-white', 'border-slate-900');
                this.classList.remove('bg-white', 'text-slate-600', 'border-slate-200');
            });
        });
    </script>
@endpush

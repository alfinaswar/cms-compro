@extends('frontend.index')

@section('content-frontend')

    @php
        $locale = app()->getLocale();

        // Helper terjemahan defensif: pakai translate() jika ada, fallback kolom *En, lalu kolom utama
        $tr = function ($model, $field) use ($locale) {
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

        // URL breadcrumb "Solusi" (aman jika route index tidak ada)
        try {
            $solusiIndexUrl = route('halaman-solusi.index');
        } catch (\Exception $e) {
            $solusiIndexUrl = url($locale . '/#solusi');
        }

        $details = $halamanSolusi->details ?? collect();
    @endphp

    @push('styles')
        <style>
            /* Tipografi konten WYSIWYG (Konten utama) */
            .solusi-content {
                font-size: 1.0625rem;
                line-height: 1.85;
                color: #475569;
            }

            .solusi-content h2,
            .solusi-content h3,
            .solusi-content h4 {
                color: #0f172a;
                font-weight: 700;
                margin: 2rem 0 .75rem;
                line-height: 1.3;
            }

            .solusi-content h2 {
                font-size: 1.75rem;
            }

            .solusi-content h3 {
                font-size: 1.375rem;
            }

            .solusi-content h4 {
                font-size: 1.125rem;
            }

            .solusi-content p {
                margin-bottom: 1.25rem;
            }

            .solusi-content ul,
            .solusi-content ol {
                margin: 1rem 0 1.25rem 1.5rem;
            }

            .solusi-content ul {
                list-style: disc;
            }

            .solusi-content ol {
                list-style: decimal;
            }

            .solusi-content li {
                margin-bottom: .5rem;
                line-height: 1.7;
            }

            .solusi-content strong {
                color: #0f172a;
                font-weight: 600;
            }

            .solusi-content a {
                color: #0284c7;
                text-decoration: underline;
            }

            .solusi-content a:hover {
                color: #0369a1;
            }

            .solusi-content img {
                border-radius: .75rem;
                margin: 1.75rem 0;
                width: 100%;
                height: auto;
                display: block;
            }

            .solusi-content blockquote {
                border-left: 4px solid #0284c7;
                padding: 1rem 1.5rem;
                background: #f0f9ff;
                border-radius: 0 .5rem .5rem 0;
                margin: 1.5rem 0;
                font-style: italic;
                color: #0c4a6e;
            }

            .solusi-content table {
                width: 100%;
                border-collapse: collapse;
                margin: 1.5rem 0;
                font-size: 0.95rem;
            }

            .solusi-content table th,
            .solusi-content table td {
                padding: 0.75rem 1rem;
                border: 1px solid #e2e8f0;
            }

            .solusi-content table th {
                background: #f8fafc;
                font-weight: 700;
                color: #0f172a;
            }

            /* Tipografi keterangan pada kartu detail */
            .detail-text {
                font-size: .9375rem;
                line-height: 1.75;
                color: #475569;
            }

            .detail-text p {
                margin-bottom: .625rem;
            }

            .detail-text ul {
                list-style: disc;
                margin-left: 1.25rem;
                margin-bottom: .75rem;
            }

            .detail-text ol {
                list-style: decimal;
                margin-left: 1.25rem;
                margin-bottom: .75rem;
            }

            .detail-text li {
                margin-bottom: .35rem;
            }

            .detail-text strong {
                color: #0f172a;
                font-weight: 600;
            }

            .detail-text a {
                color: #0284c7;
            }
        </style>
    @endpush

    <!-- ========================================== -->
    <!-- HERO / BREADCRUMB -->
    <!-- ========================================== -->
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="https://images.unsplash.com/photo-1423666639041-f56000c27a9a?q=80&amp;w=2070&amp;auto=format&amp;fit=crop"
                alt="Solution Background" class="w-full h-full object-cover">
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
                    <i class="fa-solid fa-cube mr-2"></i> {{ __('Our Solution') }}
                </span>

                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                    {{ $tr($halamanSolusi, 'Judul') }}
                </h1>

                @if (!empty($halamanSolusi->SubJudul) || !empty($halamanSolusi->Ringkasan))
                    <p class="text-xl text-slate-300 max-w-2xl mx-auto">
                        {{ $locale === 'en' && !empty($halamanSolusi->RingkasanEn) ? $halamanSolusi->RingkasanEn : ($halamanSolusi->Ringkasan ?: $halamanSolusi->SubJudul) }}
                    </p>
                @endif

                <!-- Breadcrumb -->
                <nav class="mt-8 flex items-center justify-center space-x-2 text-sm text-slate-300">
                    <a href="{{ route('frontend.main') }}" class="hover:text-white transition-colors">
                        <i class="fa-solid fa-house mr-1"></i> {{ __('Home') }}
                    </a>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                    <a href="{{ $solusiIndexUrl }}" class="hover:text-white transition-colors">{{ __('Solutions') }}</a>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                    <span
                        class="text-white font-semibold truncate max-w-[200px]">{{ Str::limit($tr($halamanSolusi, 'Judul'), 30) }}</span>
                </nav>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- FEATURED IMAGE (Jika ada) -->
    <!-- ========================================== -->
    @if (!empty($halamanSolusi->Gambar))
        <section class="py-12 bg-white">
            <div class="container mx-auto px-6">
                <div class="max-w-5xl mx-auto">
                    <img src="{{ asset('storage/' . $halamanSolusi->Gambar) }}" alt="{{ $tr($halamanSolusi, 'Judul') }}"
                        class="w-full h-auto rounded-2xl shadow-xl">
                </div>
            </div>
        </section>
    @endif

    <!-- ========================================== -->
    <!-- KONTEN UTAMA (WYSIWYG) -->
    <!-- ========================================== -->
    @if (!empty($tr($halamanSolusi, 'Konten')))
        <section class="py-16 {{ !empty($halamanSolusi->Gambar) ? 'bg-slate-50' : 'bg-white' }}">
            <div class="container mx-auto px-6">
                <div class="max-w-3xl mx-auto">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="h-px w-8 bg-brand-600"></span>
                        <span
                            class="text-xs font-bold text-brand-600 uppercase tracking-widest">{{ __('Overview') }}</span>
                    </div>
                    <div class="solusi-content">
                        {!! $tr($halamanSolusi, 'Konten') !!}
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- ========================================== -->
    <!-- GRID DETAIL LAYANAN / FITUR -->
    <!-- ========================================== -->
    @if ($details->count() > 0)
        <section class="py-16 {{ !empty($tr($halamanSolusi, 'Konten')) ? 'bg-white' : 'bg-slate-50' }}">
            <div class="container mx-auto px-6">
                <!-- Section Header -->
                <div class="max-w-3xl mb-12">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="h-px w-8 bg-brand-600"></span>
                        <span
                            class="text-xs font-bold text-brand-600 uppercase tracking-widest">{{ __('Features & Capabilities') }}</span>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">
                        {{ __('What You Get with This Solution') }}
                    </h2>
                </div>

                <!-- Grid Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach ($details as $index => $detail)
                        @php
                            $detailJudul = $tr($detail, 'Judul');
                            $detailKeterangan = $tr($detail, 'Keterangan');
                            $number = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                        @endphp

                        <article
                            class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-xl hover:border-brand-300 transition-all duration-300 group flex flex-col">
                            <!-- Image / Icon Placeholder -->
                            <div
                                class="relative aspect-[16/10] overflow-hidden bg-gradient-to-br from-slate-100 to-slate-50">
                                @if ($detail->Gambar)
                                    <img src="{{ asset('storage/' . $detail->Gambar) }}" alt="{{ $detailJudul }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent">
                                    </div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <div
                                            class="w-20 h-20 rounded-2xl bg-brand-100 flex items-center justify-center group-hover:bg-brand-600 transition-colors">
                                            <i
                                                class="fa-solid fa-cube text-3xl text-brand-600 group-hover:text-white transition-colors"></i>
                                        </div>
                                    </div>
                                @endif

                                <!-- Number Badge -->
                                <div class="absolute top-4 left-4">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-white/90 backdrop-blur-sm flex items-center justify-center shadow-md">
                                        <span class="text-sm font-extrabold text-brand-600">{{ $number }}</span>
                                    </div>
                                </div>

                                @if ($detail->Gambar)
                                    <div class="absolute bottom-4 left-4 right-4">
                                        <h3 class="text-lg md:text-xl font-bold text-white leading-snug drop-shadow-lg">
                                            {{ $detailJudul }}
                                        </h3>
                                    </div>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="p-7 flex flex-col flex-grow">
                                @if (!$detail->Gambar)
                                    <h3
                                        class="text-xl font-bold text-slate-900 mb-3 group-hover:text-brand-600 transition-colors">
                                        {{ $detailJudul }}
                                    </h3>
                                @endif

                                <div class="detail-text flex-grow">
                                    {!! $detailKeterangan !!}
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- ========================================== -->
    <!-- FAQ SECTION (WITH SCHEMA.ORG JSON-LD) -->
    <!-- ========================================== -->
    @php
        $faqs = [
            [
                'q' =>
                    $locale === 'en'
                        ? 'What does this solution encompass and who is it designed for?'
                        : 'Apa saja yang dicakup dalam solusi ini dan untuk siapa solusi ini dirancang?',
                'a' =>
                    $locale === 'en'
                        ? 'This solution provides comprehensive, end-to-end digital credentials and high-security document infrastructure tailored for governments, financial institutions, and global corporations demanding uncompromising authenticity, compliance, and reliability.'
                        : 'Solusi ini mencakup infrastruktur teknologi sekuritas terpadu, mulai dari manufaktur kredensial fisik berkeamanan tinggi hingga transformasi identitas digital dan pembayaran yang dirancang khusus untuk instansi pemerintah, perbankan, dan sektor industri enterprise.',
            ],
            [
                'q' =>
                    $locale === 'en'
                        ? 'Does this solution adhere to international security certifications?'
                        : 'Apakah solusi ini mematuhi standar sertifikasi keamanan internasional?',
                'a' =>
                    $locale === 'en'
                        ? 'Yes, all of our processes and facilities are certified under ISO 9001, ISO 27001 (Information Security Management), INTERGRAF High Security Printing certification, and EMV compliance for banking and identity credentials.'
                        : 'Ya. Seluruh fasilitas produksi dan operasional kami telah tersertifikasi standar internasional bergengsi, termasuk ISO 9001, ISO 27001 (Sistem Manajemen Keamanan Informasi), sertifikasi sekuritas global INTERGRAF, serta standar EMV untuk kartu pembayaran dan identitas cerdas.',
            ],
            [
                'q' =>
                    $locale === 'en'
                        ? 'Can this solution integrate with our existing core enterprise systems?'
                        : 'Dapatkah solusi ini diintegrasikan dengan infrastruktur sistem yang sudah ada?',
                'a' =>
                    $locale === 'en'
                        ? 'Yes. We provide modern RESTful APIs, SDKs, and customized middleware to facilitate seamless interoperability with your core enterprise architectures, database systems, and identity validation platforms.'
                        : 'Tentu. Kami menyediakan arsitektur integrasi berbasis API yang aman, SDK modular, serta dukungan kustomisasi middleware yang memudahkan integrasi langsung dengan core banking, ERP korporat, atau database kependudukan nasional.',
            ],
            [
                'q' =>
                    $locale === 'en'
                        ? 'What service level agreements (SLA) and technical support are offered?'
                        : 'Bagaimana komitmen SLA dan dukungan teknis purna jual yang disediakan?',
                'a' =>
                    $locale === 'en'
                        ? 'We offer comprehensive SLA tiers including 24/7 dedicated enterprise technical support, scheduled system maintenance, preventative monitoring, and on-site expert consultation.'
                        : 'Kami berkomitmen menyediakan SLA komprehensif, tim teknis berdedikasi 24/7, pemeliharaan berkala, serta pendampingan langsung dari tenaga ahli profesional guna memastikan kelancaran operasional jangka panjang.',
            ],
        ];
    @endphp

    <section class="py-20 bg-slate-50 border-t border-slate-200/80" id="faq-section">
        <div class="container mx-auto px-6">
            <div class="max-w-3xl mx-auto">
                <div class="text-center mb-12">
                    <span
                        class="inline-flex items-center gap-1.5 py-1.5 px-4 rounded-full bg-brand-50 text-brand-700 text-xs font-bold uppercase tracking-wider mb-4 border border-brand-200">
                        <i class="fa-solid fa-circle-question text-brand-600"></i> FAQ &amp; Knowledge Base
                    </span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        {{ $locale === 'en' ? 'Frequently Asked Questions' : 'Pertanyaan yang Sering Diajukan' }}
                    </h2>
                    <p class="text-slate-500 text-sm md:text-base mt-2.5">
                        {{ $locale === 'en' ? 'Everything you need to know about this solution, security certifications, and implementation.' : 'Informasi mendalam seputar implementasi solusi, spesifikasi teknis, dan sertifikasi keamanan kami.' }}
                    </p>
                </div>

                <div class="space-y-4" id="faqAccordion">
                    @foreach ($faqs as $idx => $item)
                        <div
                            class="faq-item bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden transition-all duration-200 hover:border-brand-300">
                            <button type="button"
                                onclick="toggleFaq('faq-content-{{ $idx }}', 'faq-icon-{{ $idx }}')"
                                class="w-full px-6 py-5 text-left font-bold text-slate-900 flex items-center justify-between gap-4 hover:bg-slate-50/80 transition-colors">
                                <span class="text-base font-bold text-slate-900 leading-snug">{{ $item['q'] }}</span>
                                <div
                                    class="w-8 h-8 rounded-full bg-brand-50 flex items-center justify-center flex-shrink-0 text-brand-600">
                                    <i id="faq-icon-{{ $idx }}"
                                        class="fa-solid {{ $idx === 0 ? 'fa-chevron-up' : 'fa-chevron-down' }} text-xs transition-transform duration-200"></i>
                                </div>
                            </button>
                            <div id="faq-content-{{ $idx }}"
                                class="px-6 pb-6 pt-1 text-slate-600 text-sm leading-relaxed border-t border-slate-100 {{ $idx === 0 ? '' : 'hidden' }}">
                                <p>{{ $item['a'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- Schema.org FAQPage JSON-LD -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            @foreach($faqs as $index => $faq)
            {
                "@type": "Question",
                "name": {!! json_encode($faq['q']) !!},
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": {!! json_encode($faq['a']) !!}
                }
            }@if(!$loop->last),@endif
            @endforeach
        ]
    }
    </script>

    <!-- ========================================== -->
    <!-- CTA SECTION -->
    <!-- ========================================== -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div
                class="bg-gradient-to-br from-brand-900 via-brand-800 to-brand-950 rounded-3xl p-8 md:p-14 text-center relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
                </div>

                <div class="relative z-10 max-w-2xl mx-auto">
                    <span
                        class="inline-block py-1.5 px-4 rounded-full bg-brand-500/20 text-white text-xs font-bold tracking-widest uppercase mb-5 border border-brand-500/30 backdrop-blur-sm">
                        <i class="fa-solid fa-handshake mr-2"></i> {{ __("Let's Collaborate") }}
                    </span>

                    <h2 class="text-2xl md:text-4xl font-extrabold text-white mb-4 leading-tight">
                        {{ __('Interested in This Solution?') }}
                    </h2>
                    <p class="text-slate-300 text-base leading-relaxed mb-8">
                        {{ __('Contact our team to discuss your needs, request a demo, or get a customized quotation for your institution.') }}
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('frontend.contact.index') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-brand-600 hover:bg-brand-500 text-white text-sm font-bold rounded-lg transition-all shadow-lg shadow-brand-600/30">
                            <i class="fa-solid fa-paper-plane mr-2"></i> {{ __('Request Quotation') }}
                        </a>
                        <a href="{{ $solusiIndexUrl }}"
                            class="inline-flex items-center justify-center px-8 py-4 border-2 border-white/30 text-white hover:bg-white/10 text-sm font-bold rounded-lg transition-all">
                            <i class="fa-solid fa-arrow-left mr-2"></i> {{ __('Back to Solutions') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            function toggleFaq(contentId, iconId) {
                const content = document.getElementById(contentId);
                const icon = document.getElementById(iconId);
                if (content.classList.contains('hidden')) {
                    content.classList.remove('hidden');
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                } else {
                    content.classList.add('hidden');
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            }
        </script>
    @endpush

@endsection

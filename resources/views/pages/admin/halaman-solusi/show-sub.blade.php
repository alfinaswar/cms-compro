@extends('frontend.index')

@section('content-frontend')

    @php
        $locale = app()->getLocale();

        $itemsBy = function ($section) use ($subpage) {
            return $subpage->items->where('Section', $section)->values();
        };

        $sec1Items = $itemsBy('section1');
        $sec2Items = $itemsBy('section2');
        $sec3Items = $itemsBy('section3');
        $faqItems  = $itemsBy('faq');

        // Judul detail pemilik subhalaman (untuk breadcrumb) sesuai bahasa aktif
        $detailTitle = ($subpage->detail?->translate($locale)->Judul)
            ?: ($subpage->detail?->Judul)
            ?: $subpage->t('Judul');

        $solusiIndexUrl = url($locale . '/#solusi');
    @endphp

    @push('styles')
        <style>
            .solusi-content {
                font-size: 1.0625rem;
                line-height: 1.85;
                color: #475569;
            }
            .solusi-content h2, .solusi-content h3, .solusi-content h4 { color: #0f172a; font-weight: 700; margin: 2rem 0 .75rem; line-height: 1.3; }
            .solusi-content p { margin-bottom: 1.25rem; }
            .solusi-content ul { list-style: disc; margin: 1rem 0 1.25rem 1.5rem; }
            .solusi-content img { border-radius: .75rem; margin: 1.75rem 0; width: 100%; height: auto; display: block; }
            .solusi-content strong { color: #0f172a; font-weight: 600; }
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

                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-5 leading-tight">
                    {{ $subpage->t('Judul') }}
                </h1>

                @if (filled($subpage->t('SubJudul')))
                    <p class="text-xl font-semibold text-brand-100/90 max-w-2xl mx-auto">
                        {{ $subpage->t('SubJudul') }}
                    </p>
                @endif

                @if (filled($subpage->t('Deskripsi')))
                    <p class="text-slate-300 max-w-3xl mx-auto mt-4">
                        {{ $subpage->t('Deskripsi') }}
                    </p>
                @endif

                <!-- Breadcrumb -->
                <nav class="mt-8 flex flex-wrap items-center justify-center gap-2 text-sm text-slate-300">
                    <a href="{{ route('frontend.main') }}" class="hover:text-white transition-colors">
                        <i class="fa-solid fa-house mr-1"></i> {{ __('Home') }}
                    </a>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                    <a href="{{ route('halaman-solusi.show', ['locale' => $locale, 'id' => $halamanSolusi->Slug]) }}"
                        class="hover:text-white transition-colors">{{ __('Solutions') }}</a>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                    <a href="{{ route('halaman-solusi.show', ['locale' => $locale, 'id' => $halamanSolusi->Slug]) }}"
                        class="hover:text-white transition-colors truncate max-w-[200px]">{{ Str::limit($halamanSolusi->t('Judul'), 30) }}</a>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                    <span class="text-white font-semibold truncate max-w-[200px]">{{ Str::limit($subpage->t('Judul'), 30) }}</span>
                </nav>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- KONTEN UTAMA (WYSIWYG, opsional) -->
    <!-- ========================================== -->
    @if (filled($subpage->t('Konten')))
        <section class="py-16 bg-white">
            <div class="container mx-auto px-6">
                <div class="max-w-3xl mx-auto">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="h-px w-8 bg-brand-600"></span>
                        <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">{{ __('Overview') }}</span>
                    </div>
                    <div class="solusi-content">
                        {!! $subpage->t('Konten') !!}
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- ========================================== -->
    <!-- SECTION 1 — KOMPONEN -->
    <!-- ========================================== -->
    @if (filled($subpage->t('Sec1Judul')) || $sec1Items->count() > 0)
        <section
            class="py-16 {{ filled($subpage->t('Konten')) ? 'bg-slate-50' : 'bg-white' }} {{ filled($subpage->t('Sec2Judul')) || $sec2Items->count() ? '' : 'border-t border-slate-100' }}">
            <div class="container mx-auto px-6">

                <!-- Header section -->
                <div class="max-w-3xl mb-12">
                    @if (filled($subpage->t('Sec1SubJudul')))
                        <div class="flex items-center gap-3 mb-4">
                            <span class="h-px w-8 bg-brand-600"></span>
                            <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">{{ $subpage->t('Sec1SubJudul') }}</span>
                        </div>
                    @endif
                    @if (filled($subpage->t('Sec1Judul')))
                        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">{{ $subpage->t('Sec1Judul') }}</h2>
                    @endif
                    @if (filled($subpage->t('Sec1Deskripsi')))
                        <p class="mt-4 text-slate-500 leading-relaxed">{{ $subpage->t('Sec1Deskripsi') }}</p>
                    @endif
                </div>

                {{-- Komponen tipe "besar" (3 kolom) --}}
                @php($besarItems = $sec1Items->where('Tipe', 'besar'))
                @php($horizontalItems = $sec1Items->where('Tipe', '!=', 'besar'))
                @if ($besarItems->count())
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        @foreach ($besarItems as $item)
                            <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                                <div class="relative aspect-[16/10] overflow-hidden bg-gradient-to-br from-slate-100 to-slate-50">
                                    @if ($item->Gambar)
                                        <img src="{{ asset('storage/' . $item->Gambar) }}" alt="{{ $item->t('Judul') }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fa-solid fa-cube text-4xl text-brand-200"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-6">
                                    @if (filled($item->t('SubJudul')))
                                        <span class="text-xs font-bold text-brand-600 uppercase tracking-wider">{{ $item->t('SubJudul') }}</span>
                                    @endif
                                    @if (filled($item->t('Judul')))
                                        <h3 class="mt-1.5 text-lg font-bold text-slate-900 mb-4">{{ $item->t('Judul') }}</h3>
                                    @endif
                                    @php($itemPoints = $item->t('Items') ?: [])
                                    @if (count($itemPoints))
                                        <ul class="space-y-2">
                                            @foreach ($itemPoints as $point)
                                                <li class="flex items-start gap-2.5 text-sm text-slate-600 leading-relaxed">
                                                    <i class="fa-solid fa-circle text-[6px] text-brand-500 mt-1.5 flex-shrink-0"></i>
                                                    <span>{{ $point }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif

                {{-- Komponen tipe "horizontal" (2 kolom, gambar di kiri) --}}
                @if ($horizontalItems->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($horizontalItems as $item)
                            <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300 group flex flex-col sm:flex-row">
                                <div class="sm:w-2/5 relative aspect-[16/10] sm:aspect-auto overflow-hidden bg-gradient-to-br from-slate-100 to-slate-50 flex-shrink-0">
                                    @if ($item->Gambar)
                                        <img src="{{ asset('storage/' . $item->Gambar) }}" alt="{{ $item->t('Judul') }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fa-solid fa-cube text-4xl text-brand-200"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-6 flex-1">
                                    @if (filled($item->t('SubJudul')))
                                        <span class="text-xs font-bold text-brand-600 uppercase tracking-wider">{{ $item->t('SubJudul') }}</span>
                                    @endif
                                    @if (filled($item->t('Judul')))
                                        <h3 class="mt-1.5 text-lg font-bold text-slate-900 mb-4">{{ $item->t('Judul') }}</h3>
                                    @endif
                                    @php($itemPoints = $item->t('Items') ?: [])
                                    @if (count($itemPoints))
                                        <ul class="space-y-2">
                                            @foreach ($itemPoints as $point)
                                                <li class="flex items-start gap-2.5 text-sm text-slate-600 leading-relaxed">
                                                    <i class="fa-solid fa-circle text-[6px] text-brand-500 mt-1.5 flex-shrink-0"></i>
                                                    <span>{{ $point }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>
    @endif

    <!-- ========================================== -->
    <!-- SECTION 2 — SOLUSI -->
    <!-- ========================================== -->
    @if (filled($subpage->t('Sec2Judul')) || $sec2Items->count() > 0)
        <section class="py-16 bg-slate-50 border-t border-slate-100">
            <div class="container mx-auto px-6">

                <div class="max-w-3xl mb-12">
                    @if (filled($subpage->t('Sec2SubJudul')))
                        <div class="flex items-center gap-3 mb-4">
                            <span class="h-px w-8 bg-brand-600"></span>
                            <span class="text-xs font-bold text-brand-600 uppercase tracking-widest">{{ $subpage->t('Sec2SubJudul') }}</span>
                        </div>
                    @endif
                    @if (filled($subpage->t('Sec2Judul')))
                        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 leading-tight">{{ $subpage->t('Sec2Judul') }}</h2>
                    @endif
                    @if (filled($subpage->t('Sec2Deskripsi')))
                        <p class="mt-4 text-slate-500 leading-relaxed">{{ $subpage->t('Sec2Deskripsi') }}</p>
                    @endif
                </div>

                @if ($sec2Items->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($sec2Items as $item)
                            <article class="bg-white rounded-2xl border border-slate-200 p-7 hover:shadow-lg hover:border-brand-300 transition-all duration-300">
                                <div class="flex items-start gap-5">
                                    <div class="w-14 h-14 rounded-xl bg-brand-50 flex items-center justify-center flex-shrink-0 overflow-hidden">
                                        @if ($item->Icon)
                                            <img src="{{ asset('storage/' . $item->Icon) }}" alt="{{ $item->t('Judul') }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <i class="fa-solid fa-shield-halved text-xl text-brand-600"></i>
                                        @endif
                                    </div>
                                    <div>
                                        @if (filled($item->t('Judul')))
                                            <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $item->t('Judul') }}</h3>
                                        @endif
                                        @if (filled($item->t('Deskripsi')))
                                            <p class="text-sm text-slate-600 leading-relaxed">{{ $item->t('Deskripsi') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>
    @endif

    <!-- ========================================== -->
    <!-- SECTION 3 — KEAMANAN (gelap) -->
    <!-- ========================================== -->
    @if (filled($subpage->t('Sec3Judul')) || $sec3Items->count() > 0)
        <section class="py-20 bg-gradient-to-br from-slate-900 via-brand-950 to-slate-900 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>

            <div class="container mx-auto px-6 relative z-10">

                <div class="max-w-3xl mb-12">
                    @if (filled($subpage->t('Sec3SubJudul')))
                        <span
                            class="inline-block py-1.5 px-4 rounded-full bg-brand-500/20 text-brand-100 text-xs font-bold uppercase tracking-widest mb-4 border border-brand-500/30">
                            {{ $subpage->t('Sec3SubJudul') }}
                        </span>
                    @endif
                    @if (filled($subpage->t('Sec3Judul')))
                        <h2 class="text-3xl md:text-4xl font-extrabold text-white leading-tight">{{ $subpage->t('Sec3Judul') }}</h2>
                    @endif
                    @if (filled($subpage->t('Sec3Deskripsi')))
                        <p class="mt-4 text-slate-300 leading-relaxed">{{ $subpage->t('Sec3Deskripsi') }}</p>
                    @endif
                </div>

                @if ($sec3Items->count())
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach ($sec3Items as $item)
                            <article class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-7 hover:bg-white/10 transition-all duration-300">
                                <div class="w-12 h-12 rounded-xl bg-brand-500/20 flex items-center justify-center mb-5 overflow-hidden">
                                    @if ($item->Icon)
                                        <img src="{{ asset('storage/' . $item->Icon) }}" alt="{{ $item->t('Judul') }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-solid fa-lock text-brand-300"></i>
                                    @endif
                                </div>
                                @if (filled($item->t('Judul')))
                                    <h3 class="text-lg font-bold text-white mb-3">{{ $item->t('Judul') }}</h3>
                                @endif
                                @if (filled($item->t('Deskripsi')))
                                    <p class="text-sm text-slate-300 leading-relaxed">{{ $item->t('Deskripsi') }}</p>
                                @endif
                            </article>
                        @endforeach
                    </div>
                @endif

            </div>
        </section>
    @endif

    <!-- ========================================== -->
    <!-- FAQ -->
    <!-- ========================================== -->
    @if (filled($subpage->t('FaqJudul')) || $faqItems->count() > 0)
        <section class="py-20 bg-slate-50 border-t border-slate-200/80" id="faq-section">
            <div class="container mx-auto px-6">
                <div class="max-w-3xl mx-auto">
                    <div class="text-center mb-12">
                        <span
                            class="inline-flex items-center gap-1.5 py-1.5 px-4 rounded-full bg-brand-50 text-brand-700 text-xs font-bold uppercase tracking-wider mb-4 border border-brand-200">
                            <i class="fa-solid fa-circle-question text-brand-600"></i> FAQ &amp; Knowledge Base
                        </span>
                        @if (filled($subpage->t('FaqJudul')))
                            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">{{ $subpage->t('FaqJudul') }}</h2>
                        @endif
                        @if (filled($subpage->t('FaqDeskripsi')))
                            <p class="text-slate-500 text-sm md:text-base mt-2.5">{{ $subpage->t('FaqDeskripsi') }}</p>
                        @endif
                    </div>

                    @if ($faqItems->count())
                        <div class="space-y-4" id="faqAccordion">
                            @foreach ($faqItems as $idx => $item)
                                <div class="faq-item bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden transition-all duration-200 hover:border-brand-300">
                                    <button type="button"
                                        onclick="toggleFaq('faq-content-{{ $idx }}', 'faq-icon-{{ $idx }}')"
                                        class="w-full px-6 py-5 text-left flex items-center justify-between gap-4 hover:bg-slate-50/80 transition-colors">
                                        <span class="text-base font-bold text-slate-900 leading-snug">{{ $item->t('Judul') }}</span>
                                        <div class="w-8 h-8 rounded-full bg-brand-50 flex items-center justify-center flex-shrink-0 text-brand-600">
                                            <i id="faq-icon-{{ $idx }}"
                                                class="fa-solid {{ $idx === 0 ? 'fa-chevron-up' : 'fa-chevron-down' }} text-xs transition-transform duration-200"></i>
                                        </div>
                                    </button>
                                    <div id="faq-content-{{ $idx }}"
                                        class="px-6 pb-6 pt-1 text-slate-600 text-sm leading-relaxed border-t border-slate-100 {{ $idx === 0 ? '' : 'hidden' }}">
                                        <p>{{ $item->t('Deskripsi') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- ========================================== -->
    <!-- CTA SECTION -->
    <!-- ========================================== -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="bg-gradient-to-br from-brand-900 via-brand-800 to-brand-950 rounded-3xl p-8 md:p-14 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>

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
                        <a href="{{ route('halaman-solusi.show', ['locale' => $locale, 'id' => $halamanSolusi->Slug]) }}"
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

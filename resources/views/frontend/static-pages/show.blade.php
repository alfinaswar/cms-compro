@extends('frontend.index')

@section('content-frontend')
    @php
        // Helper untuk static page
        $displayJudul = $translation->Judul ?: $page->Label;
        $displayKonten = $translation->Konten ?: '';
        $displayDesc = $translation->SEODescription ?: Str::limit(strip_tags($displayKonten), 120);

        // Estimasi waktu baca (asumsi 200 kata per menit)
        $wordCount = str_word_count(strip_tags($displayKonten));
        $readingTime = max(1, ceil($wordCount / 200));

        // Breadcrumb sederhana: Home > Judul
        $breadcrumbs = [['title' => __('Home'), 'url' => url('/')], ['title' => $displayJudul, 'url' => null]];
        $shareUrl = url()->current();
    @endphp

    <!-- Hero Section -->
    <section
        class="relative pt-24 pb-10 md:pt-32 md:pb-20 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?q=80&w=2070&auto=format&fit=crop"
                alt="{{ __('Page Background') }}" class="w-full h-full object-cover">
        </div>
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>
        <div
            class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>

        <div class="container mx-auto px-3 sm:px-8 md:px-12 relative z-10 flex justify-center">
            <div class="w-full text-center">
                <span
                    class="inline-block py-1.5 px-4 rounded-full bg-brand-500/20 text-brand-100 text-sm font-semibold tracking-wide mb-6 border border-brand-500/30 backdrop-blur-sm">
                    <i class="{{ $page->Icon ?: 'fa-solid fa-file-lines' }} mr-2"></i>
                    {{ $page->Label ?: __('Information Page') }}
                </span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight">
                    {{ $displayJudul }}
                </h1>
                @if ($displayDesc)
                    <p class="text-base sm:text-lg md:text-xl text-slate-300 max-w-2xl mx-auto">
                        {{ $displayDesc }}
                    </p>
                @endif

                <!-- Meta Info -->
                <div class="mt-5 flex items-center justify-center gap-4 text-xs sm:text-sm text-slate-300 flex-wrap">
                    <span class="flex items-center gap-2">
                        <i class="fa-regular fa-calendar"></i>
                        {{ __('Updated') }}: {{ $page->updated_at ? $page->updated_at->isoFormat('D MMMM Y') : '-' }}
                    </span>
                    <span class="flex items-center gap-2">
                        <i class="fa-regular fa-clock"></i>
                        {{ $readingTime }} {{ __('min read') }}
                    </span>
                </div>

                <!-- Breadcrumb -->
                <nav class="mt-7 flex items-center justify-center space-x-2 text-xs sm:text-sm text-slate-300 flex-wrap">
                    @foreach ($breadcrumbs as $index => $crumb)
                        @if ($index < count($breadcrumbs) - 1)
                            <a href="{{ $crumb['url'] }}" class="hover:text-white transition-colors">
                                {{ $crumb['title'] }}
                            </a>
                            <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                        @else
                            <span class="text-white font-semibold">{{ $crumb['title'] }}</span>
                        @endif
                    @endforeach
                </nav>
            </div>
        </div>
    </section>

    <!-- Main Content, full width (col-md-12 equivalent) -->
    <section class="py-6 md:py-12 bg-slate-50">
        <div class="container mx-auto px-3 sm:px-8 md:px-16">
            <div class="w-full"> <!-- full width, remove max-w-2xl and mx-auto -->

                <article class="bg-white rounded-xl overflow-hidden shadow-md border border-slate-200 p-0">

                    <!-- Featured Image: Optional, can remove for privacy policy or keep if needed -->
                    {{-- No featured image for privacy policy, but if needed, uncomment below --}}
                    {{--
                    @if ($thumbnailUrl)
                        <div class="aspect-video overflow-hidden flex justify-center">
                            <img src="{{ $thumbnailUrl }}" alt="{{ $displayJudul }}"
                                class="w-full h-full object-cover mx-auto block">
                        </div>
                    @endif
                    --}}

                    <!-- Content -->
                    <div class="py-8 px-2 sm:px-8 md:px-16"> <!-- text-center removed, px widened -->
                        <!-- Title -->
                        <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-4 leading-tight text-center">
                            {{ $displayJudul }}
                        </h2>

                        <!-- Rich Text Content -->
                        <div class="prose prose-slate max-w-none mb-8 mx-auto">
                            {!! $displayKonten !!}
                        </div>
                        <!-- Share Buttons -->
                        <div class="flex justify-center gap-3 mt-8">
                            {{-- WhatsApp --}}
                            <a href="https://wa.me/?text={{ urlencode($displayJudul . ' ' . $shareUrl) }}" target="_blank"
                                rel="noopener"
                                class="inline-flex items-center px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-full shadow transition-colors"
                                title="Share to WhatsApp">
                                <i class="fa-brands fa-whatsapp mr-2"></i> WhatsApp
                            </a>
                            {{-- Facebook --}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}"
                                target="_blank" rel="noopener"
                                class="inline-flex items-center px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-full shadow transition-colors"
                                title="Share to Facebook">
                                <i class="fa-brands fa-facebook-f mr-2"></i> Facebook
                            </a>
                            {{-- Twitter/X --}}
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($shareUrl) }}&text={{ urlencode($displayJudul) }}"
                                target="_blank" rel="noopener"
                                class="inline-flex items-center px-3 py-2 bg-sky-500 hover:bg-sky-700 text-white text-sm font-semibold rounded-full shadow transition-colors"
                                title="Share to Twitter">
                                <i class="fa-brands fa-x-twitter mr-2"></i> Twitter
                            </a>
                            {{-- Telegram --}}
                            <a href="https://t.me/share/url?url={{ urlencode($shareUrl) }}&text={{ urlencode($displayJudul) }}"
                                target="_blank" rel="noopener"
                                class="inline-flex items-center px-3 py-2 bg-cyan-500 hover:bg-cyan-700 text-white text-sm font-semibold rounded-full shadow transition-colors"
                                title="Share via Telegram">
                                <i class="fa-brands fa-telegram mr-2"></i> Telegram
                            </a>
                            {{-- Copy Link --}}
                            <button onclick="navigator.clipboard.writeText('{{ $shareUrl }}');" type="button"
                                class="inline-flex items-center px-3 py-2 bg-slate-400 hover:bg-slate-600 text-white text-sm font-semibold rounded-full shadow transition-colors"
                                title="Copy Link">
                                <i class="fa-regular fa-link mr-2"></i> {{ __('Copy Link') }}
                            </button>
                        </div>
                    </div>
                </article>

            </div>
        </div>
    </section>
@endsection

@extends('frontend.index')

@section('title', ($locale === 'id' ? 'Peta Situs' : 'Sitemap') . ' - ' . config('app.name'))
@section('meta_description',
    $locale === 'id'
    ? 'Peta situs lengkap untuk navigasi mudah di website kami.'
    : 'Complete
    sitemap for easy navigation on our website.')

    @push('styles')
        <style>
            /* ========== HERO STYLES ========== */
            .sitemap-hero {
                position: relative;
                background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 50%, #3b82f6 100%);
                overflow: hidden;
            }

            .sitemap-hero::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image:
                    radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.3) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(147, 51, 234, 0.2) 0%, transparent 50%);
                pointer-events: none;
            }

            .stat-card {
                position: relative;
                overflow: hidden;
                transition: all 0.3s ease;
            }

            .stat-card:hover {
                transform: translateY(-4px);
                background: rgba(255, 255, 255, 0.15);
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in-up {
                animation: fadeInUp 0.6s ease-out forwards;
            }

            .delay-100 {
                animation-delay: 0.1s;
            }

            .delay-200 {
                animation-delay: 0.2s;
            }

            .delay-300 {
                animation-delay: 0.3s;
            }

            .delay-400 {
                animation-delay: 0.4s;
            }

            /* ========== LIST STYLES ========== */
            .sitemap-list a {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.75rem 1rem;
                border-radius: 0.5rem;
                color: #334155;
                transition: all 0.2s ease;
                text-decoration: none;
            }

            .sitemap-list a:hover {
                background: #f1f5f9;
                color: #2563eb;
                padding-left: 1.25rem;
            }

            .sitemap-list a i {
                width: 1.25rem;
                text-align: center;
                color: #94a3b8;
                transition: color 0.2s ease;
            }

            .sitemap-list a:hover i {
                color: #2563eb;
            }

            .sitemap-section {
                margin-bottom: 2.5rem;
            }

            .sitemap-section-title {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                font-size: 1.125rem;
                font-weight: 700;
                color: #1e293b;
                margin-bottom: 1rem;
                padding-bottom: 0.75rem;
                border-bottom: 2px solid #e2e8f0;
            }

            .sitemap-section-title i {
                color: #2563eb;
            }

            .sitemap-section-title .count {
                margin-left: auto;
                font-size: 0.875rem;
                font-weight: 600;
                color: #64748b;
                background: #f1f5f9;
                padding: 0.25rem 0.75rem;
                border-radius: 9999px;
            }

            .sitemap-meta {
                font-size: 0.75rem;
                color: #94a3b8;
                margin-left: auto;
                white-space: nowrap;
            }
        </style>
    @endpush

@section('content-frontend')
    <!-- ========== HERO SECTION (Profesional) ========== -->
    <section class="relative pt-32 pb-16 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="https://images.unsplash.com/photo-1557804506-669a67965ba0?q=80&w=2070&auto=format&fit=crop"
                alt="Sitemap Background" class="w-full h-full object-cover">
        </div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <span
                    class="inline-block py-1.5 px-4 rounded-full bg-brand-500/20 text-brand-100 text-sm font-semibold tracking-wide mb-6 border border-brand-500/30 backdrop-blur-sm">
                    <i class="fa-solid fa-sitemap mr-2"></i>
                    {{ $locale === 'id' ? 'NAVIGASI' : 'NAVIGATION' }}
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                    {{ $locale === 'id' ? 'Peta Situs' : 'Sitemap' }}
                </h1>
                <p class="text-xl text-slate-300 max-w-2xl mx-auto">
                    {{ $locale === 'id'
                        ? 'Temukan semua halaman dan konten website kami dengan mudah.'
                        : 'Find all pages and content on our website easily.' }}
                </p>

                <!-- Breadcrumb -->
                <nav class="mt-8 flex items-center justify-center space-x-2 text-sm text-slate-300">
                    <a href="{{ url('/') }}" class="hover:text-white transition-colors">
                        <i class="fa-solid fa-house mr-1"></i>
                        {{ $locale === 'id' ? 'Beranda' : 'Home' }}
                    </a>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                    <span class="text-white font-semibold">
                        {{ $locale === 'id' ? 'Peta Situs' : 'Sitemap' }}
                    </span>
                </nav>
            </div>
        </div>
    </section>

    <!-- ========== MAIN CONTENT (List Sederhana) ========== -->
    <section class="py-12 md:py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="max-w-4xl mx-auto">

                <!-- 1. Halaman Utama -->
                <div class="sitemap-section">
                    <h2 class="sitemap-section-title">
                        <i class="fa-solid fa-house"></i>
                        {{ $locale === 'id' ? 'Halaman Utama' : 'Main Pages' }}
                        <span class="count">{{ count($mainPages) }}</span>
                    </h2>
                    <div class="sitemap-list">
                        @foreach ($mainPages as $page)
                            <a href="{{ $page['url'] }}">
                                <i class="fa-solid {{ $page['icon'] }}"></i>
                                <span>{{ $page['title'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- 2. Berita -->
                <div class="sitemap-section">
                    <h2 class="sitemap-section-title">
                        <i class="fa-solid fa-newspaper"></i>
                        {{ $locale === 'id' ? 'Berita & Artikel' : 'News & Articles' }}
                        <span class="count">{{ $berita->count() }}</span>
                    </h2>
                    @if ($berita->count() > 0)
                        <div class="sitemap-list">
                            @foreach ($berita as $item)
                                <a href="{{ $item['url'] }}">
                                    <i class="fa-regular fa-file-lines"></i>
                                    <span class="flex-1">{{ $item['title'] }}</span>
                                    @if ($item['date'])
                                        <span class="sitemap-meta">{{ $item['date'] }}</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-500 text-sm pl-4">
                            {{ $locale === 'id' ? 'Belum ada berita.' : 'No news yet.' }}
                        </p>
                    @endif
                </div>

                <!-- 3. Lowongan Kerja -->
                <div class="sitemap-section">
                    <h2 class="sitemap-section-title">
                        <i class="fa-solid fa-briefcase"></i>
                        {{ $locale === 'id' ? 'Lowongan Kerja' : 'Career Opportunities' }}
                        <span class="count">{{ $lowongan->count() }}</span>
                    </h2>
                    @if ($lowongan->count() > 0)
                        <div class="sitemap-list">
                            @foreach ($lowongan as $item)
                                {{-- @dd($item); --}}
                                <a href="{{ $item['url'] }}">
                                    <i class="fa-regular fa-file-lines"></i>
                                    <span class="flex-1">{{ $item['title'] }}</span>
                                    @if ($item['location'])
                                        <span class="sitemap-meta">
                                            <i class="fa-solid fa-location-dot mr-1"></i>{{ $item['location'] }}
                                        </span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-500 text-sm pl-4">
                            {{ $locale === 'id' ? 'Belum ada lowongan.' : 'No job openings yet.' }}
                        </p>
                    @endif
                </div>

                <!-- 4. Halaman Informasi -->
                <div class="sitemap-section">
                    <h2 class="sitemap-section-title">
                        <i class="fa-solid fa-file-lines"></i>
                        {{ $locale === 'id' ? 'Halaman Informasi' : 'Information Pages' }}
                        <span class="count">{{ $staticPages->count() }}</span>
                    </h2>
                    @if ($staticPages->count() > 0)
                        <div class="sitemap-list">
                            @foreach ($staticPages as $page)
                                <a href="{{ $page['url'] }}">
                                    <i class="fa-solid {{ $page['icon'] }}"></i>
                                    <span>{{ $page['title'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-500 text-sm pl-4">
                            {{ $locale === 'id' ? 'Belum ada halaman.' : 'No pages yet.' }}
                        </p>
                    @endif
                </div>

                <!-- 5. Custom Pages (jika ada) -->
                @if ($customPages->count() > 0)
                    <div class="sitemap-section">
                        <h2 class="sitemap-section-title">
                            <i class="fa-solid fa-folder-open"></i>
                            {{ $locale === 'id' ? 'Halaman Lainnya' : 'Other Pages' }}
                            <span class="count">{{ $customPages->count() }}</span>
                        </h2>
                        <div class="sitemap-list">
                            @foreach ($customPages as $page)
                                <a href="{{ $page['url'] }}">
                                    <i class="fa-regular fa-file"></i>
                                    <span>{{ $page['title'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- XML Sitemap Link -->
                <div class="mt-12 pt-8 border-t border-slate-200 text-center">
                    <p class="text-sm text-slate-600 mb-3">
                        {{ $locale === 'id' ? 'Untuk mesin pencari:' : 'For search engines:' }}
                    </p>
                    <a href="{{ url('sitemap.xml') }}"
                        class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold"
                        target="_blank">
                        <i class="fa-solid fa-code"></i>
                        sitemap.xml
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    </a>
                </div>

            </div>
        </div>
    </section>
@endsection

@extends('frontend.index')

@section('content-frontend')
    @php
        // Helper untuk halaman custom
        $trans = $page->translate($locale);
        $displayJudul = $trans->Judul ?: $page->Judul;
        $displayKonten = $trans->Konten ?: $page->Konten;
        $displayDesc = $trans->DeskripsiSingkat ?: $page->DeskripsiSingkat;
        $thumbnailUrl = $page->Thumbnail ? asset('storage/' . $page->Thumbnail) : asset('img/no-image.png');

        // Build Breadcrumbs secara dinamis berdasarkan hirarki
        $breadcrumbs = [];
        $breadcrumbs[] = ['title' => __('Home'), 'url' => url('/')];

        $tempCrumbs = [];
        $currentPage = $page;
        while ($currentPage) {
            $crumbTrans = $currentPage->translate($locale);
            $tempCrumbs[] = [
                'title' => $crumbTrans->Judul ?: $currentPage->Judul,
                'url' => $currentPage->Slug ? url('page/' . $currentPage->Slug) : '#',
            ];
            $currentPage = $currentPage->parent;
        }
        $breadcrumbs = array_merge($breadcrumbs, array_reverse($tempCrumbs));
    @endphp

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="https://images.unsplash.com/photo-1423666639041-f56000c27a9a?q=80&w=2070&auto=format&fit=crop"
                alt="{{ __('Page Background') }}" class="w-full h-full object-cover">
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
                    <i class="fa-solid fa-file-lines mr-2"></i> {{ __('Custom Page') }}
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                    {{ $displayJudul }}
                </h1>
                @if ($displayDesc)
                    <p class="text-xl text-slate-300 max-w-2xl mx-auto">
                        {{ Str::limit($displayDesc, 120) }}
                    </p>
                @endif

                <!-- Dynamic Breadcrumb -->
                <nav class="mt-8 flex items-center justify-center space-x-2 text-sm text-slate-300 flex-wrap">
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

    <!-- Main Content -->
    <section class="py-12 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <article class="bg-white rounded-xl overflow-hidden shadow-sm border border-slate-200">

                        <!-- Featured Image -->
                        @if ($page->Thumbnail)
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ $thumbnailUrl }}" alt="{{ $displayJudul }}" class="w-full h-full object-cover">
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="p-6 md:p-8">
                            <!-- Title -->
                            <h2 class="text-3xl font-bold text-slate-900 mb-6 leading-tight">
                                {{ $displayJudul }}
                            </h2>

                            <!-- Rich Text Content -->
                            <div class="prose prose-slate max-w-none mb-8">
                                {!! $displayKonten !!}
                            </div>

                            <!-- Share Buttons -->
                            <div class="border-t border-slate-200 pt-6 mt-8">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    <div>
                                        <span
                                            class="text-sm font-semibold text-slate-700 mr-2">{{ __('Share this page') }}:</span>
                                    </div>
                                    <div class="inline-flex gap-2">
                                        @php
                                            $shareUrl = urlencode(request()->url());
                                            $shareTitle = urlencode($displayJudul);
                                        @endphp
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                                            target="_blank" rel="noopener"
                                            class="w-9 h-9 bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-600 rounded-lg flex items-center justify-center transition-colors">
                                            <i class="fa-brands fa-facebook-f"></i>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}"
                                            target="_blank" rel="noopener"
                                            class="w-9 h-9 bg-slate-100 hover:bg-sky-500 hover:text-white text-slate-600 rounded-lg flex items-center justify-center transition-colors">
                                            <i class="fa-brands fa-twitter"></i>
                                        </a>
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}"
                                            target="_blank" rel="noopener"
                                            class="w-9 h-9 bg-slate-100 hover:bg-blue-700 hover:text-white text-slate-600 rounded-lg flex items-center justify-center transition-colors">
                                            <i class="fa-brands fa-linkedin-in"></i>
                                        </a>
                                        <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}"
                                            target="_blank" rel="noopener"
                                            class="w-9 h-9 bg-slate-100 hover:bg-green-600 hover:text-white text-slate-600 rounded-lg flex items-center justify-center transition-colors">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </a>
                                        <button onclick="copyLink()" id="copyLinkBtn"
                                            class="w-9 h-9 bg-slate-100 hover:bg-brand-600 hover:text-white text-slate-600 rounded-lg flex items-center justify-center transition-colors"
                                            title="Copy Link">
                                            <i class="fa-solid fa-link"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <!-- Sub-Pages (Children) Navigation -->
                    @if ($page->children->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-2xl font-bold text-slate-900 mb-6">
                                <i class="fa-solid fa-folder-tree mr-2 text-brand-600"></i>{{ __('Sub-pages') }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($page->children as $child)
                                    @php
                                        $childTrans = $child->translate($locale);
                                        $childJudul = $childTrans->Judul ?: $child->Judul;
                                    @endphp
                                    <a href="{{ url('page/' . $child->Slug) }}"
                                        class="bg-white rounded-xl p-5 border border-slate-200 hover:border-brand-500 hover:shadow-md transition-all group flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 bg-brand-50 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-brand-100 transition-colors">
                                            <i class="fa-solid fa-file-lines text-brand-600 text-xl"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4
                                                class="text-base font-semibold text-slate-900 group-hover:text-brand-600 line-clamp-2">
                                                {{ $childJudul }}
                                            </h4>
                                        </div>
                                        <i
                                            class="fa-solid fa-arrow-right text-slate-400 group-hover:text-brand-600 group-hover:translate-x-1 transition-all"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>

                <!-- Sidebar -->
                <aside class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">

                        <!-- Search Widget -->
                        <div class="bg-white rounded-xl p-6 border border-slate-200">
                            <h3 class="text-lg font-bold text-slate-900 mb-4">{{ __('Search') }}</h3>
                            <form action="{{ url('news') }}" method="GET" class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="{{ __('Search...') }}"
                                    class="w-full px-4 py-2.5 pr-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none">
                                <button type="submit"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-brand-600">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Page Hierarchy Widget (Siblings/Children) -->
                        @if ($page->parent || $page->children->count() > 0)
                            <div class="bg-white rounded-xl p-6 border border-slate-200">
                                <h3 class="text-lg font-bold text-slate-900 mb-4">{{ __('Navigasi Halaman') }}</h3>
                                <ul class="space-y-2">
                                    @if ($page->parent)
                                        @php $parentTrans = $page->parent->translate($locale); @endphp
                                        <li>
                                            <a href="{{ url('page/' . $page->parent->Slug) }}"
                                                class="flex items-center py-2 px-3 rounded-lg hover:bg-slate-50 transition-colors group text-slate-600 hover:text-brand-600">
                                                <i class="fa-solid fa-arrow-up mr-2 text-xs"></i>
                                                <span
                                                    class="font-medium">{{ $parentTrans->Judul ?: $page->parent->Judul }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @foreach ($page->children as $child)
                                        @php $childTrans = $child->translate($locale); @endphp
                                        <li>
                                            <a href="{{ url('page/' . $child->Slug) }}"
                                                class="flex items-center py-2 px-3 rounded-lg hover:bg-slate-50 transition-colors group {{ request()->is('page/' . $child->Slug) ? 'bg-brand-50 text-brand-600 font-semibold' : 'text-slate-600 hover:text-brand-600' }}">
                                                <i class="fa-solid fa-chevron-right mr-2 text-xs"></i>
                                                <span>{{ $childTrans->Judul ?: $child->Judul }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Recent News Widget (Cross-linking) -->
                        @if ($recentNews->count() > 0)
                            <div class="bg-white rounded-xl p-6 border border-slate-200">
                                <h3 class="text-lg font-bold text-slate-900 mb-4">{{ __('Recent News') }}</h3>
                                <div class="space-y-4">
                                    @foreach ($recentNews as $recent)
                                        @php
                                            $recentTrans = $recent->translate($locale);
                                            $recentJudul = $recentTrans->Judul ?: $recent->Judul;
                                            $recentThumb = $recent->PathThumbnail
                                                ? asset('storage/' . $recent->PathThumbnail)
                                                : asset('img/no-image.png');
                                        @endphp
                                        <div class="flex gap-3">
                                            <a href="{{ url('news/' . $recent->Slug) }}" class="flex-shrink-0">
                                                <img src="{{ $recentThumb }}" alt="{{ $recentJudul }}"
                                                    class="w-20 h-20 object-cover rounded-lg">
                                            </a>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs text-slate-500 mb-1">
                                                    <i class="fa-regular fa-calendar mr-1"></i>
                                                    {{ $recent->TanggalPublikasi ? \Carbon\Carbon::parse($recent->TanggalPublikasi)->isoFormat('D MMM, Y') : '-' }}
                                                </p>
                                                <h4
                                                    class="text-sm font-semibold text-slate-900 hover:text-brand-600 line-clamp-2">
                                                    <a href="{{ url('news/' . $recent->Slug) }}">
                                                        {{ Str::limit($recentJudul, 40) }}
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- CTA Widget -->
                        <div class="bg-gradient-to-br from-brand-600 to-brand-700 rounded-xl p-6 text-white text-center">
                            <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-phone text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold mb-2">{{ __('Need Help?') }}</h3>
                            <p class="text-brand-100 text-sm mb-4">{{ __('Contact us for more information') }}</p>
                            <a href="tel:+62318910919" class="block text-xl font-bold mb-4 hover:text-brand-200">
                                +62 31 8910919
                            </a>
                            <a href="{{ url('contact') }}"
                                class="inline-flex items-center px-6 py-2.5 bg-white text-brand-700 font-semibold rounded-lg hover:bg-brand-50 transition-colors">
                                {{ __('Contact Us') }}
                                <i class="fa-solid fa-arrow-right ml-2"></i>
                            </a>
                        </div>

                    </div>
                </aside>
            </div>
        </div>
    </section>

    <!-- Copy Link Script -->
    <script>
        function copyLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                const btn = document.getElementById('copyLinkBtn');
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                btn.classList.add('bg-green-600', 'text-white');
                btn.classList.remove('bg-slate-100', 'text-slate-600');

                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.classList.remove('bg-green-600', 'text-white');
                    btn.classList.add('bg-slate-100', 'text-slate-600');
                }, 2000);
            });
        }
    </script>
@endsection

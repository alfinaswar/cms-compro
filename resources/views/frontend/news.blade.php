@extends('frontend.index')

@section('content-frontend')

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="https://images.unsplash.com/photo-1423666639041-f56000c27a9a?q=80&w=2070&auto=format&fit=crop"
                alt="{{ __('News Background') }}" class="w-full h-full object-cover">
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
                    <i class="fa-solid fa-newspaper mr-2"></i> {{ __('FOR THIS NEWS') }}
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                    {{ __('Latest News') }} <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-cyan-300"></span>
                </h1>
                <p class="text-xl text-slate-300 max-w-2xl mx-auto">
                    {{ __('Get the latest information, updates and company insights here.') }}
                </p>

                <!-- Breadcrumb -->
                <nav class="mt-8 flex items-center justify-center space-x-2 text-sm text-slate-300">
                    <a href="{{ url('/') }}" class="hover:text-white transition-colors">
                        <i class="fa-solid fa-house mr-1"></i> {{ __('Home') }}
                    </a>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                    <span class="text-white font-semibold">{{ __('News') }}</span>
                </nav>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Main Content: News List -->
                <div class="lg:col-span-2">

                    @forelse($news as $item)
                        <article
                            class="bg-white rounded-xl overflow-hidden shadow-sm border border-slate-200 mb-6 hover:shadow-md transition-shadow">
                            <!-- Image -->
                            <a href="{{ url('news/' . $item->Slug) }}" class="block overflow-hidden">
                                <img src="{{ asset('storage/' . $item->PathThumbnail) }}" alt="{{ $item->Judul }}"
                                    class="w-full h-64 object-cover hover:scale-105 transition-transform duration-300">
                            </a>

                            <!-- Content -->
                            <div class="p-6">
                                <!-- Meta -->
                                <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 mb-3">
                                    <span>
                                        <i class="fa-regular fa-user mr-1"></i>
                                        {{ $item->Penulis }}
                                    </span>
                                    <span>
                                        <i class="fa-regular fa-calendar mr-1"></i>
                                        {{ \Carbon\Carbon::parse($item->TanggalPublikasi)->isoFormat('D MMM, Y') }}
                                    </span>
                                    <span class="px-2 py-1 bg-brand-50 text-brand-700 text-xs font-semibold rounded">
                                        {{ $item->Kategori }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <h2 class="text-2xl font-bold text-slate-900 mb-3 hover:text-brand-600 transition-colors">
                                    <a href="{{ url('news/' . $item->Slug) }}">
                                        {{ $item->Judul }}
                                    </a>
                                </h2>

                                <!-- Excerpt -->
                                <p class="text-slate-600 mb-4 leading-relaxed">
                                    {{ $item->Ringkasan }}
                                </p>

                                <!-- Read More -->
                                <a href="{{ url('news/' . $item->Slug) }}"
                                    class="inline-flex items-center text-brand-600 hover:text-brand-700 font-semibold">
                                    {{ __('Read More') }}
                                    <i class="fa-solid fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </article>
                    @empty
                        <!-- Empty State -->
                        <div class="text-center py-16 bg-white rounded-xl border border-slate-200">
                            <i class="fa-regular fa-newspaper text-5xl text-slate-400 mb-4"></i>
                            <h3 class="text-xl font-bold text-slate-900 mb-2">{{ __('No News Yet') }}</h3>
                            <p class="text-slate-600">{{ __('Currently there is no news available.') }}</p>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    @if ($news->hasPages())
                        <div class="mt-8 flex justify-center">
                            <nav class="inline-flex items-center space-x-1">
                                {{-- Previous --}}
                                @if ($news->onFirstPage())
                                    <span
                                        class="px-3 py-2 border border-slate-300 rounded-lg text-slate-400 cursor-not-allowed">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </span>
                                @else
                                    <a href="{{ $news->previousPageUrl() }}"
                                        class="px-3 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </a>
                                @endif

                                {{-- Page Numbers --}}
                                @foreach ($news->getUrlRange(1, $news->lastPage()) as $page => $url)
                                    @if ($page == $news->currentPage())
                                        <span class="px-4 py-2 bg-brand-600 text-white font-semibold rounded-lg">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="px-4 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Next --}}
                                @if ($news->hasMorePages())
                                    <a href="{{ $news->nextPageUrl() }}"
                                        class="px-3 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span
                                        class="px-3 py-2 border border-slate-300 rounded-lg text-slate-400 cursor-not-allowed">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </span>
                                @endif
                            </nav>
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
                                    placeholder="{{ __('Search news...') }}"
                                    class="w-full px-4 py-2.5 pr-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none">
                                <button type="submit"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-brand-600">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Categories Widget -->
                        <div class="bg-white rounded-xl p-6 border border-slate-200">
                            <h3 class="text-lg font-bold text-slate-900 mb-4">{{ __('Categories') }}</h3>
                            <ul class="space-y-2">
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ url('news?kategori=' . $category) }}"
                                            class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-slate-50 transition-colors group">
                                            <span
                                                class="text-slate-700 group-hover:text-brand-600">{{ $category }}</span>
                                            <i
                                                class="fa-solid fa-chevron-right text-xs text-slate-400 group-hover:text-brand-600"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Recent Posts Widget -->
                        <div class="bg-white rounded-xl p-6 border border-slate-200">
                            <h3 class="text-lg font-bold text-slate-900 mb-4">{{ __('Recent Posts') }}</h3>
                            <div class="space-y-4">
                                @foreach ($recentNews as $recent)
                                    <div class="flex gap-3">
                                        <a href="{{ url('news/' . $recent->Slug) }}" class="flex-shrink-0">
                                            <img src="{{ asset('storage/' . $recent->PathThumbnail) }}"
                                                alt="{{ $recent->Judul }}" class="w-20 h-20 object-cover rounded-lg">
                                        </a>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs text-slate-500 mb-1">
                                                <i class="fa-regular fa-calendar mr-1"></i>
                                                {{ \Carbon\Carbon::parse($recent->TanggalPublikasi)->isoFormat('D MMM, Y') }}
                                            </p>
                                            <h4
                                                class="text-sm font-semibold text-slate-900 hover:text-brand-600 line-clamp-2">
                                                <a href="{{ url('news/' . $recent->Slug) }}">
                                                    {{ $recent->Judul }}
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tags Widget -->
                        <div class="bg-white rounded-xl p-6 border border-slate-200">
                            <h3 class="text-lg font-bold text-slate-900 mb-4">{{ __('Popular Tags') }}</h3>
                            <div class="flex flex-wrap gap-2">
                                @php
                                    $allTags = [];
                                    foreach ($recentNews as $r) {
                                        if ($r->Tags) {
                                            $tags = explode(',', $r->Tags);
                                            foreach ($tags as $tag) {
                                                $allTags[] = trim($tag);
                                            }
                                        }
                                    }
                                    $allTags = array_unique($allTags);
                                @endphp

                                @forelse($allTags as $tag)
                                    <a href="{{ url('news?tag=' . $tag) }}"
                                        class="px-3 py-1.5 bg-slate-100 hover:bg-brand-600 text-slate-700 hover:text-white text-sm rounded-lg transition-colors">
                                        {{ $tag }}
                                    </a>
                                @empty
                                    <span class="text-sm text-slate-500">{{ __('No tags available') }}</span>
                                @endforelse
                            </div>
                        </div>

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

@endsection

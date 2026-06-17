@extends('frontend.index')

@section('content-frontend')

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="https://images.unsplash.com/photo-1423666639041-f56000c27a9a?q=80&w=2070&auto=format&fit=crop"
                alt="News Background" class="w-full h-full object-cover">
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
                    <i class="fa-solid fa-newspaper mr-2"></i>
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                    {{ Str::limit($news->Judul, 60) }}
                </h1>
                <p class="text-xl text-slate-300 max-w-2xl mx-auto">
                    Dapatkan informasi terkini, update terbaru dan insight perusahaan kami di sini.
                </p>

                <!-- Breadcrumb -->
                <nav class="mt-8 flex items-center justify-center space-x-2 text-sm text-slate-300">
                    <a href="{{ url('/') }}" class="hover:text-white transition-colors">
                        <i class="fa-solid fa-house mr-1"></i> Home
                    </a>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                    <a href="{{ url('news') }}" class="hover:text-white transition-colors">Berita</a>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                    <span class="text-white font-semibold">{{ Str::limit($news->Judul, 30) }}</span>
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
                        @if ($news->PathThumbnail)
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ asset('storage/' . $news->PathThumbnail) }}" alt="{{ $news->Judul }}"
                                    class="w-full h-full object-cover">
                            </div>
                        @endif

                        <!-- Content -->
                        <div class="p-6 md:p-8">

                            <!-- Meta -->
                            <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500 mb-4">
                                <span>
                                    <i class="fa-regular fa-user mr-1"></i>
                                    {{ $news->Penulis ?? 'Admin' }}
                                </span>
                                <span>
                                    <i class="fa-regular fa-calendar mr-1"></i>
                                    {{ \Carbon\Carbon::parse($news->TanggalPublikasi)->format('d M, Y') }}
                                </span>
                                <a href="{{ url('news?kategori=' . $news->Kategori) }}"
                                    class="px-2 py-1 bg-brand-50 text-brand-700 text-xs font-semibold rounded hover:bg-brand-100 transition-colors">
                                    {{ $news->Kategori }}
                                </a>
                            </div>

                            <!-- Title -->
                            <h2 class="text-3xl font-bold text-slate-900 mb-6 leading-tight">
                                {{ $news->Judul }}
                            </h2>

                            <!-- Content -->
                            <div class="prose prose-slate max-w-none mb-8">
                                {!! $news->Konten !!}
                            </div>

                            <!-- Tags & Share -->
                            @if ($news->Tags)
                                @php
                                    $tags = array_map('trim', explode(',', $news->Tags));
                                @endphp
                                <div class="border-t border-slate-200 pt-6 mt-8">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                                        <!-- Tags -->
                                        <div>
                                            <span class="text-sm font-semibold text-slate-700 mr-2">Tags:</span>
                                            <div class="inline-flex flex-wrap gap-2 mt-2">
                                                @foreach ($tags as $tag)
                                                    <a href="{{ url('news?tag=' . $tag) }}"
                                                        class="px-3 py-1 bg-slate-100 hover:bg-brand-600 text-slate-700 hover:text-white text-sm rounded transition-colors">
                                                        {{ $tag }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>

                                        <!-- Share -->
                                        <div>
                                            <span class="text-sm font-semibold text-slate-700 mr-2">Share:</span>
                                            <div class="inline-flex gap-2 mt-2">
                                                @php
                                                    $shareUrl = urlencode(request()->url());
                                                    $shareTitle = urlencode($news->Judul);
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
                                                    class="w-9 h-9 bg-slate-100 hover:bg-brand-600 hover:text-white text-slate-600 rounded-lg flex items-center justify-center transition-colors">
                                                    <i class="fa-solid fa-link"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </article>

                    <!-- Prev/Next Navigation -->
                    @if ($prevPost || $nextPost)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                            @if ($prevPost)
                                <a href="{{ url('news/' . $prevPost->Slug) }}"
                                    class="bg-white rounded-xl p-5 border border-slate-200 hover:border-brand-500 hover:shadow-md transition-all group">
                                    <div class="flex items-center">
                                        <i
                                            class="fa-solid fa-arrow-left text-brand-600 mr-3 group-hover:-translate-x-1 transition-transform"></i>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs text-slate-500 mb-1">Previous Post</p>
                                            <h4
                                                class="text-sm font-semibold text-slate-900 line-clamp-2 group-hover:text-brand-600">
                                                {{ Str::limit($prevPost->Judul, 40) }}
                                            </h4>
                                        </div>
                                    </div>
                                </a>
                            @else
                                <div></div>
                            @endif

                            @if ($nextPost)
                                <a href="{{ url('news/' . $nextPost->Slug) }}"
                                    class="bg-white rounded-xl p-5 border border-slate-200 hover:border-brand-500 hover:shadow-md transition-all group">
                                    <div class="flex items-center text-right md:flex-row-reverse">
                                        <i
                                            class="fa-solid fa-arrow-right text-brand-600 ml-3 group-hover:translate-x-1 transition-transform"></i>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs text-slate-500 mb-1">Next Post</p>
                                            <h4
                                                class="text-sm font-semibold text-slate-900 line-clamp-2 group-hover:text-brand-600">
                                                {{ Str::limit($nextPost->Judul, 40) }}
                                            </h4>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        </div>
                    @endif

                    <!-- Author Box -->
                    <div class="bg-white rounded-xl p-6 border border-slate-200 mt-6">
                        <div class="flex items-start gap-4">
                            <img src="{{ asset('assets/img/blog/blog-author.png') }}" alt="Author"
                                class="w-16 h-16 rounded-full object-cover flex-shrink-0"
                                onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($news->Penulis ?? 'Admin') }}&background=0284c7&color=fff'">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-slate-900 mb-2">{{ $news->Penulis ?? 'Admin' }}</h3>
                                <p class="text-sm text-slate-600 mb-3">
                                    Penulis artikel ini telah berpengalaman di bidang IT dan teknologi.
                                    Ikuti tulisan-tulisannya untuk insight terbaru seputar dunia digital.
                                </p>
                                <div class="flex gap-2">
                                    <a href="#"
                                        class="w-8 h-8 bg-slate-100 hover:bg-blue-600 hover:text-white text-slate-600 rounded flex items-center justify-center transition-colors">
                                        <i class="fa-brands fa-facebook-f text-sm"></i>
                                    </a>
                                    <a href="#"
                                        class="w-8 h-8 bg-slate-100 hover:bg-sky-500 hover:text-white text-slate-600 rounded flex items-center justify-center transition-colors">
                                        <i class="fa-brands fa-twitter text-sm"></i>
                                    </a>
                                    <a href="#"
                                        class="w-8 h-8 bg-slate-100 hover:bg-pink-600 hover:text-white text-slate-600 rounded flex items-center justify-center transition-colors">
                                        <i class="fa-brands fa-instagram text-sm"></i>
                                    </a>
                                    <a href="#"
                                        class="w-8 h-8 bg-slate-100 hover:bg-blue-700 hover:text-white text-slate-600 rounded flex items-center justify-center transition-colors">
                                        <i class="fa-brands fa-linkedin-in text-sm"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Posts -->
                    @if ($relatedPosts->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-2xl font-bold text-slate-900 mb-6">Related Posts</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach ($relatedPosts as $related)
                                    <article
                                        class="bg-white rounded-xl overflow-hidden border border-slate-200 hover:shadow-md transition-shadow">
                                        <a href="{{ url('news/' . $related->Slug) }}" class="block overflow-hidden">
                                            <img src="{{ asset('storage/' . $related->PathThumbnail) }}"
                                                alt="{{ $related->Judul }}"
                                                class="w-full h-40 object-cover hover:scale-105 transition-transform duration-300">
                                        </a>
                                        <div class="p-4">
                                            <p class="text-xs text-slate-500 mb-2">
                                                <i class="fa-regular fa-calendar mr-1"></i>
                                                {{ \Carbon\Carbon::parse($related->TanggalPublikasi)->format('d M, Y') }}
                                            </p>
                                            <h4 class="text-sm font-bold text-slate-900 hover:text-brand-600 line-clamp-2">
                                                <a href="{{ url('news/' . $related->Slug) }}">
                                                    {{ Str::limit($related->Judul, 50) }}
                                                </a>
                                            </h4>
                                        </div>
                                    </article>
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
                            <h3 class="text-lg font-bold text-slate-900 mb-4">Search</h3>
                            <form action="{{ url('news') }}" method="GET" class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari berita..."
                                    class="w-full px-4 py-2.5 pr-10 border border-slate-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none">
                                <button type="submit"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-brand-600">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Categories Widget -->
                        <div class="bg-white rounded-xl p-6 border border-slate-200">
                            <h3 class="text-lg font-bold text-slate-900 mb-4">Categories</h3>
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
                            <h3 class="text-lg font-bold text-slate-900 mb-4">Recent Posts</h3>
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
                                                {{ \Carbon\Carbon::parse($recent->TanggalPublikasi)->format('d M, Y') }}
                                            </p>
                                            <h4
                                                class="text-sm font-semibold text-slate-900 hover:text-brand-600 line-clamp-2">
                                                <a href="{{ url('news/' . $recent->Slug) }}">
                                                    {{ Str::limit($recent->Judul, 40) }}
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tags Widget -->
                        <div class="bg-white rounded-xl p-6 border border-slate-200">
                            <h3 class="text-lg font-bold text-slate-900 mb-4">Popular Tags</h3>
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
                                    <span class="text-sm text-slate-500">No tags available</span>
                                @endforelse
                            </div>
                        </div>

                        <!-- CTA Widget -->
                        <div class="bg-gradient-to-br from-brand-600 to-brand-700 rounded-xl p-6 text-white text-center">
                            <div class="w-14 h-14 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-phone text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold mb-2">Need Help?</h3>
                            <p class="text-brand-100 text-sm mb-4">Hubungi kami untuk informasi lebih lanjut</p>
                            <a href="tel:+62318910919" class="block text-xl font-bold mb-4 hover:text-brand-200">
                                +62 31 8910919
                            </a>
                            <a href="{{ url('contact') }}"
                                class="inline-flex items-center px-6 py-2.5 bg-white text-brand-700 font-semibold rounded-lg hover:bg-brand-50 transition-colors">
                                Contact Us
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

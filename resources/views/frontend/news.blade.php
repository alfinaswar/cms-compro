@extends('frontend.index')

@section('content-frontend')
    <div class="breadcumb-wrapper " data-bg-src="assets/img/bg/breadcumb-bg.jpg">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">News</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>News</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="th-blog-wrapper space-top space-extra-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    {{-- LOOPING UTAMA UNTUK MENAMPILKAN BERITA --}}
                    @forelse($news as $item)
                        <div class="th-blog blog-single has-post-thumbnail">
                            <div class="blog-img">
                                <a href="{{ url('news/' . $item->Slug) }}">
                                    {{-- PENTING: Sesuaikan path asset jika gambar disimpan di folder public biasa --}}
                                    <img src="{{ asset('storage/' . $item->PathThumbnail) }}" alt="{{ $item->Judul }}">
                                </a>
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <a class="author" href="#"><i class="fa-light fa-user"></i>by
                                        {{ $item->Penulis }}</a>
                                    <a href="#"><i
                                            class="fa-regular fa-calendar"></i>{{ \Carbon\Carbon::parse($item->TanggalPublikasi)->format('d M, Y') }}</a>
                                    <a href="#"><i class="fa-light fa-folder"></i> {{ $item->Kategori }}</a>
                                </div>
                                <h2 class="blog-title">
                                    <a href="{{ url('news/' . $item->Slug) }}">{{ $item->Judul }}</a>
                                </h2>
                                <p class="blog-text">{{ $item->Ringkasan }}</p>

                                <a href="{{ url('news/' . $item->Slug) }}" class="th-btn style4 th-icon">Lebih Lengkap <i
                                        class="fa-light fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted">Belum ada berita yang tersedia.</p>
                        </div>
                    @endforelse

                    {{-- PAGINATION DINAMIS (Mempertahankan style HTML asli template) --}}
                    @if ($news->hasPages())
                        <div class="th-pagination mt-60 ">
                            <ul>
                                {{-- Previous Page Link --}}
                                @if ($news->onFirstPage())
                                    <li><a class="disabled"><i class="fa-sharp fa-light fa-arrow-left"></i></a></li>
                                @else
                                    <li><a href="{{ $news->previousPageUrl() }}"><i
                                                class="fa-sharp fa-light fa-arrow-left"></i></a></li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach ($news->getUrlRange(1, $news->lastPage()) as $page => $url)
                                    @if ($page == $news->currentPage())
                                        <li><a class="active" href="#">{{ $page }}</a></li>
                                    @else
                                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if ($news->hasMorePages())
                                    <li><a class="next-page" href="{{ $news->nextPageUrl() }}"><i
                                                class="fa-sharp fa-light fa-arrow-right"></i></a></li>
                                @else
                                    <li><a class="next-page disabled"><i class="fa-sharp fa-light fa-arrow-right"></i></a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">
                        {{-- WIDGET SEARCH --}}
                        <div class="widget widget_search">
                            <form class="search-form" action="{{ url('news') }}" method="GET">
                                <input type="text" name="search" placeholder="Search" value="{{ request('search') }}">
                                <button type="submit"><i class="far fa-search"></i></button>
                            </form>
                        </div>

                        {{-- WIDGET CATEGORIES DINAMIS --}}
                        <div class="widget widget_categories">
                            <h3 class="widget_title">Categories</h3>
                            <ul>
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ url('news?kategori=' . $category) }}">{{ $category }}</a>
                                        <span><i class="fa-regular fa-arrow-up-right"></i></span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- WIDGET RECENT POSTS DINAMIS --}}
                        <div class="widget">
                            <h3 class="widget_title">Recent Posts</h3>
                            <div class="recent-post-wrap">
                                @foreach ($recentNews as $recent)
                                    <div class="recent-post">
                                        <div class="media-img">
                                            <a href="{{ url('news/' . $recent->Slug) }}">
                                                <img src="{{ asset('storage/' . $recent->PathThumbnail) }}"
                                                    alt="{{ $recent->Judul }}">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <div class="recent-post-meta">
                                                <a href="#"><i
                                                        class="fa-solid fa-calendar-days"></i>{{ \Carbon\Carbon::parse($recent->TanggalPublikasi)->format('d M, Y') }}</a>
                                            </div>
                                            <h4 class="post-title"><a class="text-inherit"
                                                    href="{{ url('news/' . $recent->Slug) }}">{{ $recent->Judul }}</a>
                                            </h4>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- WIDGET TAGS DINAMIS --}}
                        <div class="widget widget_tag_cloud">
                            <h3 class="widget_title">Popular Tags</h3>
                            <div class="tagcloud">
                                @php
                                    // Mengambil tags dari recent news dan memecahnya jika dipisahkan koma
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
                                    <a href="{{ url('news?tag=' . $tag) }}">{{ $tag }}</a>
                                @empty
                                    <a href="#">Technology</a>
                                    <a href="#">Consulting</a>
                                @endforelse
                            </div>
                        </div>

                        <div class="widget widget_banner" data-bg-src="assets/img/bg/widget_banner.jpg">
                            <div class="widget-banner position-relative text-center">
                                <span class="icon"><i class="fa-solid fa-phone"></i></span>
                                <span class="text">Need Help? Call Here</span>
                                <a class="phone" href="tel:+25669872564">+256 6987 2564</a>
                                <a href="contact.html" class="th-btn style6">Get A Quote <i
                                        class="fa-light fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>
@endsection

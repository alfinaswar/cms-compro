@extends('frontend.index')

@section('content-frontend')
    {{-- BREADCRUMB --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $news->Judul }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('news') }}">News</a></li>
                    <li>{{ Str::limit($news->Judul, 40) }}</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- BLOG DETAILS --}}
    <section class="th-blog-wrapper blog-details space-top space-extra-bottom">
        <div class="container">
            <div class="row">
                {{-- MAIN CONTENT --}}
                <div class="col-xxl-8 col-lg-7">
                    <div class="th-blog blog-single">
                        {{-- FEATURED IMAGE --}}
                        @if ($news->PathThumbnail)
                            <div class="blog-img">
                                <img src="{{ asset('storage/' . $news->PathThumbnail) }}" alt="{{ $news->Judul }}">
                            </div>
                        @endif

                        <div class="blog-content">
                            {{-- META INFO --}}
                            <div class="blog-meta">
                                <a class="author" href="#">
                                    <i class="fa-light fa-user"></i>by {{ $news->Penulis ?? 'Admin' }}
                                </a>
                                <a href="#">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ \Carbon\Carbon::parse($news->TanggalPublikasi)->format('d M, Y') }}
                                </a>
                                <a href="{{ url('news?kategori=' . $news->Kategori) }}">
                                    <i class="fa-light fa-folder"></i> {{ $news->Kategori }}
                                </a>
                            </div>

                            {{-- JUDUL --}}
                            <h2 class="blog-title">{{ $news->Judul }}</h2>

                            {{-- KONTEN (HTML dari editor WYSIWYG) --}}
                            <div class="blog-text-wrapper">
                                {!! $news->Konten !!}
                            </div>

                            {{-- TAGS --}}
                            @if ($news->Tags)
                                @php
                                    $tags = array_map('trim', explode(',', $news->Tags));
                                @endphp
                                <div class="share-links clearfix mt-40">
                                    <div class="row justify-content-between">
                                        <div class="col-md-auto">
                                            <span class="share-links-title">Tags:</span>
                                            <div class="tagcloud">
                                                @foreach ($tags as $tag)
                                                    <a href="{{ url('news?tag=' . $tag) }}">{{ $tag }}</a>
                                                @endforeach
                                            </div>
                                        </div>

                                        {{-- SHARE LINKS --}}
                                        <div class="col-md-auto text-xl-end">
                                            <div class="share-links_wrapp">
                                                <span class="share-links-title">Share:</span>
                                                <div class="social-links">
                                                    @php
                                                        $shareUrl = urlencode(request()->url());
                                                        $shareTitle = urlencode($news->Judul);
                                                    @endphp
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                                                        target="_blank" rel="noopener" title="Share to Facebook">
                                                        <i class="fab fa-facebook-f"></i>
                                                    </a>
                                                    <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}"
                                                        target="_blank" rel="noopener" title="Share to Twitter">
                                                        <i class="fab fa-twitter"></i>
                                                    </a>
                                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}"
                                                        target="_blank" rel="noopener" title="Share to LinkedIn">
                                                        <i class="fab fa-linkedin-in"></i>
                                                    </a>
                                                    <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}"
                                                        target="_blank" rel="noopener" title="Share to WhatsApp">
                                                        <i class="fab fa-whatsapp"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" onclick="copyLink()" title="Copy Link"
                                                        id="copyLinkBtn">
                                                        <i class="fa-light fa-link"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- PREV / NEXT POST NAVIGATION --}}
                    @if ($prevPost || $nextPost)
                        <div class="row nav-links mt-40">
                            @if ($prevPost)
                                <div class="col-6">
                                    <a href="{{ url('news/' . $prevPost->Slug) }}" class="blog-btn">
                                        <i class="fa-light fa-arrow-left"></i>
                                        <span class="btn-text">
                                            <small>Previous Post</small>
                                            <h6 class="title">{{ Str::limit($prevPost->Judul, 40) }}</h6>
                                        </span>
                                    </a>
                                </div>
                            @else
                                <div class="col-6"></div>
                            @endif

                            @if ($nextPost)
                                <div class="col-6 text-end">
                                    <a href="{{ url('news/' . $nextPost->Slug) }}" class="blog-btn text-end">
                                        <span class="btn-text">
                                            <small>Next Post</small>
                                            <h6 class="title">{{ Str::limit($nextPost->Judul, 40) }}</h6>
                                        </span>
                                        <i class="fa-light fa-arrow-right"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- AUTHOR BOX (Opsional) --}}
                    <div class="blog-author mt-40">
                        <div class="blog-auhtor-wrap">
                            <div class="blog-author-img">
                                <img src="{{ asset('assets/img/blog/blog-author.png') }}" alt="Author"
                                    onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($news->Penulis ?? 'Admin') }}&background=ff6b00&color=fff'">
                            </div>
                            <div class="media-body">
                                <h3 class="blog-author-title">{{ $news->Penulis ?? 'Admin' }}</h3>
                                <p class="blog-author-text">
                                    Penulis artikel ini telah berpengalaman di bidang IT dan teknologi.
                                    Ikuti tulisan-tulisannya untuk insight terbaru seputar dunia digital.
                                </p>
                                <div class="social-links">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RELATED POSTS --}}
                    @if ($relatedPosts->count() > 0)
                        <h3 class="mt-5 mb-4">Related Posts</h3>
                        <div class="row gy-4">
                            @foreach ($relatedPosts as $related)
                                <div class="col-md-4">
                                    <div class="blog-grid">
                                        <div class="blog-img">
                                            <a href="{{ url('news/' . $related->Slug) }}">
                                                <img src="{{ asset('storage/' . $related->PathThumbnail) }}"
                                                    alt="{{ $related->Judul }}">
                                            </a>
                                        </div>
                                        <div class="blog-content">
                                            <div class="blog-meta">
                                                <a href="#">
                                                    <i class="fa-regular fa-calendar"></i>
                                                    {{ \Carbon\Carbon::parse($related->TanggalPublikasi)->format('d M, Y') }}
                                                </a>
                                            </div>
                                            <h3 class="blog-title">
                                                <a href="{{ url('news/' . $related->Slug) }}">
                                                    {{ Str::limit($related->Judul, 50) }}
                                                </a>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- SIDEBAR (sama seperti news index) --}}
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">
                        {{-- SEARCH --}}
                        <div class="widget widget_search">
                            <form class="search-form" action="{{ url('news') }}" method="GET">
                                <input type="text" name="search" placeholder="Search"
                                    value="{{ request('search') }}">
                                <button type="submit"><i class="far fa-search"></i></button>
                            </form>
                        </div>

                        {{-- CATEGORIES --}}
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

                        {{-- RECENT POSTS --}}
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
                                                <a href="#">
                                                    <i class="fa-solid fa-calendar-days"></i>
                                                    {{ \Carbon\Carbon::parse($recent->TanggalPublikasi)->format('d M, Y') }}
                                                </a>
                                            </div>
                                            <h4 class="post-title">
                                                <a class="text-inherit" href="{{ url('news/' . $recent->Slug) }}">
                                                    {{ Str::limit($recent->Judul, 40) }}
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- TAGS --}}
                        <div class="widget widget_tag_cloud">
                            <h3 class="widget_title">Popular Tags</h3>
                            <div class="tagcloud">
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
                                    <a href="{{ url('news?tag=' . $tag) }}">{{ $tag }}</a>
                                @empty
                                    <a href="#">Technology</a>
                                    <a href="#">Consulting</a>
                                @endforelse
                            </div>
                        </div>

                        {{-- BANNER --}}
                        <div class="widget widget_banner" data-bg-src="{{ asset('assets/img/bg/widget_banner.jpg') }}">
                            <div class="widget-banner position-relative text-center">
                                <span class="icon"><i class="fa-solid fa-phone"></i></span>
                                <span class="text">Need Help? Call Here</span>
                                <a class="phone" href="tel:+25669872564">+256 6987 2564</a>
                                <a href="{{ url('contact') }}" class="th-btn style6">
                                    Get A Quote <i class="fa-light fa-arrow-right-long"></i>
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </section>

    {{-- SCRIPT COPY LINK --}}
    <script>
        function copyLink() {
            const url = window.location.href;
            navigator.clipboard.writeText(url).then(() => {
                const btn = document.getElementById('copyLinkBtn');
                const originalHTML = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-check"></i>';
                btn.style.color = '#28a745';

                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.style.color = '';
                }, 2000);
            });
        }
    </script>
@endsection

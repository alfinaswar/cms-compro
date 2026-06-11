@extends('frontend.index')

@section('content-frontend')
    {{-- BREADCRUMB --}}
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Career Page</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Career</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- CAREER AREA --}}
    <div class="space">
        <div class="container">
            {{-- FILTER & SORT BAR --}}
            <div class="th-sort-bar mb-4">
                <div class="row gy-4 justify-content-between align-items-center">
                    <div class="col-lg">
                        <p class="woocommerce-result-count mb-0">
                            <strong>{{ $totalJobs }}</strong> jobs recommended for you
                        </p>
                    </div>
                    <div class="col-lg-auto">
                        <form method="GET" action="{{ url('career') }}" class="d-sm-flex align-items-center">
                            {{-- Filter Kota --}}
                            <div class="woocommerce-ordering me-sm-3 mb-10 mb-sm-0">
                                <select name="kota" class="orderby" onchange="this.form.submit()">
                                    <option value="">All Cities</option>
                                    @foreach ($kotas as $kota)
                                        <option value="{{ $kota }}"
                                            {{ request('kota') == $kota ? 'selected' : '' }}>
                                            {{ $kota }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Sort By --}}
                            <div class="woocommerce-ordering">
                                <select name="sort" class="orderby" onchange="this.form.submit()">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Sort by
                                        Latest</option>
                                    <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>Sort by
                                        Deadline</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Sort by
                                        Oldest</option>
                                </select>
                            </div>

                            {{-- Preserve other query params --}}
                            @if (request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            {{-- SEARCH BAR (Bonus) --}}
            <form method="GET" action="{{ url('career') }}" class="mb-4">
                <div class="input-group" style="max-width: 500px;">
                    <input type="text" name="search" class="form-control" placeholder="Search position, description..."
                        value="{{ request('search') }}">
                    @if (request('kota'))
                        <input type="hidden" name="kota" value="{{ request('kota') }}">
                    @endif
                    @if (request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    <button class="btn btn-primary" type="submit">
                        <i class="fa-solid fa-search"></i> Search
                    </button>
                    @if (request()->hasAny(['search', 'kota']))
                        <a href="{{ url('career') }}" class="btn btn-outline-secondary">
                            <i class="fa-solid fa-xmark"></i> Reset
                        </a>
                    @endif
                </div>
            </form>

            {{-- LIST LOWONGAN --}}
            <div class="row gy-30">
                @forelse($lowongans as $lowongan)
                    <div class="col-lg-6 col-xxl-4">
                        <div class="job-post white-bg">
                            <div class="job-content smoke-bg">
                                <div class="job-post_date d-flex align-items-center justify-content-between">
                                    <span class="date">
                                        <i class="fa-regular fa-calendar me-1"></i>
                                        {{ $lowongan->BatasWaktuFormatted }}
                                    </span>
                                    <div class="icon">
                                        @if ($lowongan->masih_berlaku)
                                            <span class="badge bg-success">Open</span>
                                        @else
                                            <span class="badge bg-secondary">Closed</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="job-post_author d-sm-flex align-items-center text-center text-sm-start">
                                    <div class="job-author">
                                        {{-- Logo default, bisa diganti jika ada kolom logo --}}
                                        <img src="{{ asset('assets/img/career/career-logo.jpg') }}"
                                            alt="{{ $lowongan->Posisi }}"
                                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($lowongan->Posisi) }}&background=ff6b00&color=fff'">
                                    </div>
                                    <div class="author-info">
                                        <span class="company-name">Jasuindo</span>
                                        <span class="job-title">{{ $lowongan->Posisi }}</span>
                                        <span class="location">
                                            <i class="fa-light fa-location-dot"></i> {{ $lowongan->Kota }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Preview Deskripsi (dipotong) --}}
                                <div class="job-description mt-2">
                                    <p class="mb-0 text-muted small">
                                        {{ Str::limit(strip_tags($lowongan->Deskripsi), 100) }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="job-wrapper d-sm-flex align-items-center justify-content-between text-center text-sm-start">
                                <span class="price">
                                    <i class="fa-regular fa-clock me-2"></i>
                                    Deadline: {{ \Carbon\Carbon::parse($lowongan->BatasWaktu)->diffForHumans() }}
                                </span>
                                <a
                                    href="{{ route('frontend.career.detail', ['id' => $lowongan->id, 'slug' => $lowongan->slug]) }}">
                                    <span class="th-btn style3">Apply Now</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fa-regular fa-folder-open fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No jobs available at the moment</h4>
                        <p class="text-muted">Please check back later or try different filters.</p>
                        <a href="{{ url('career') }}" class="th-btn style3 mt-3">Reset Filters</a>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            @if ($lowongans->hasPages())
                <div class="th-pagination mt-60 text-center mb-0">
                    <ul>
                        {{-- Previous --}}
                        @if ($lowongans->onFirstPage())
                            <li><a class="disabled"><i class="fa-sharp fa-light fa-arrow-left"></i></a></li>
                        @else
                            <li><a href="{{ $lowongans->previousPageUrl() }}">
                                    <i class="fa-sharp fa-light fa-arrow-left"></i>
                                </a></li>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($lowongans->getUrlRange(1, $lowongans->lastPage()) as $page => $url)
                            @if ($page == $lowongans->currentPage())
                                <li><a class="active" href="#">{{ $page }}</a></li>
                            @else
                                <li><a href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($lowongans->hasMorePages())
                            <li><a class="next-page" href="{{ $lowongans->nextPageUrl() }}">
                                    <i class="fa-sharp fa-light fa-arrow-right"></i>
                                </a></li>
                        @else
                            <li><a class="next-page disabled">
                                    <i class="fa-sharp fa-light fa-arrow-right"></i>
                                </a></li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection

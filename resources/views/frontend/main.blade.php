@extends('frontend.index')
@section('content-frontend')
    <div class="th-hero-wrapper hero-1" id="hero">
        <div class="swiper th-slider hero-slider-1" id="heroSlide1"
            data-slider-options='{"effect":"fade","menu": ["", "", ""],"heroSlide1": {"swiper-container": {"pagination": {"el": ".swiper-pagination", "clickable": true }}}}'>
            <div class="swiper-wrapper">
                @foreach ($heroSliders as $slider)
                    <div class="swiper-slide">
                        <div class="hero-inner">
                            <div class="th-hero-bg"
                                data-bg-src="{{ $slider->GambarLatar ? asset('storage/' . $slider->GambarLatar) : asset('assets-landing-page/img/hero/hero_bg_1_2.jpg') }}">
                            </div>
                            {{-- <div class="hero-1-shape d-none d-lg-block" data-ani="slideinleft" data-ani-delay="0.4s">
                                <img src="{{ $slider->GambarBentuk ? asset('storage/' . $slider->GambarBentuk) : asset('assets-landing-page/img/shape/hero-1-shape.png') }}"
                                    alt="hero-shape">
                            </div> --}}
                            <div class="container">
                                <div class="row">
                                    <div class="col-xl-9 col-lg-8">
                                        <div class="hero-style1">
                                            <span class="sub-title style1" data-ani="slideinup" data-ani-delay="0.2s">
                                                {{ $slider->SubJudul ?? 'The Fastest Growing' }}
                                            </span>
                                            <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.4s">
                                                {{ $slider->JudulUtama ?? 'Identity & Payment Company In Asia' }}
                                            </h1>
                                            @if (!empty($slider->Deskripsi))
                                                <p>{{ $slider->Deskripsi }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="th-swiper-custom">
                <button data-slider-prev="#heroSlide1" class="slider-arrow slider-prev"><img
                        src="{{ asset('assets-landing-page/img/icon/right-arrow.svg') }}" alt=""></button>
                <div class="slider-pagination"></div>
                <button data-slider-next="#heroSlide1" class="slider-arrow slider-next"><img
                        src="{{ asset('assets-landing-page/img/icon/left-arrow.svg') }}" alt=""></button>
            </div>
        </div>
    </div>
    <section class="category-area bg-top-center space"
        data-bg-src="{{ asset('') }}assets-landing-page/img/bg/category_bg_1.png">
        <div class="container th-container">
            <div class="title-area mb-60 text-center">
                <span class="sub-title text-anime-style-2">Key Figures</span>
                <h2 class="sec-title text-anime-style-3">Key Figures</h2>
            </div>
            <div class="swiper th-slider categorySlider" id="categorySlider1"
                data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"spaceBetween":45,"slidesPerView":"5"}}}'>
                <div class="swiper-wrapper">
                    @foreach ($keyFigures as $figure)
                        <div class="swiper-slide">
                            <div class="category-card single text-center py-4">
                                <div class="box-img global-img mb-3">
                                    @if ($figure->Icon)
                                        <img src="{{ asset('storage/' . $figure->Icon) }}"
                                            alt="Icon {{ $figure->Keterangan }}"
                                            style="height:60px;max-width:80px;object-fit:contain;">
                                    @else
                                        <img src="{{ asset('assets-landing-page/img/category/default.jpg') }}"
                                            alt="Default Icon" style="height:60px;max-width:80px;object-fit:contain;">
                                    @endif
                                </div>
                                <h3 class="box-title mb-1" style="font-size:2.2rem;font-weight:bold;">
                                    {{ $figure->Konten }}
                                </h3>
                                <p class="sec-text" style="font-size:1.08rem;">
                                    {{ $figure->Keterangan }}
                                </p>
                            </div>
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </section>


    <section class="position-relative bg-top-center overflow-hidden space" id="service-sec"
        data-bg-src="{{ asset('') }}assets-landing-page/img/bg/service_bg_1.jpg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="title-area service-title-box text-center">
                        <span class="sub-title mb-15  text-anime-style-2">What We’re Offering</span>
                        <h2 class="sec-title  text-anime-style-2">Jasuindo Solutions</h2>
                        {{-- <p class="sec-text mb-50 wow fadeInUp" data-wow-delay=".4s">IT solutions refer to a broad
                            range of services and technologies designed to address <br> specific business needs,
                            streamline operations, and drive growth.</p> --}}
                    </div>
                </div>
            </div>
            <div class="slider-area slider-drag-wrap">
                <div class="swiper th-slider has-shadow"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1300":{"slidesPerView":"4"}}}'>
                    <div class="swiper-wrapper">

                        @foreach ($halamanSolusi as $solusi)
                            <div class="swiper-slide">
                                <div class="service-box service-style-1 gsap-cursor">
                                    <div class="service-img">
                                        <a href="{{ $solusi->link ?? '#' }}">
                                            <img src="{{ asset('storage/' . $solusi->Thumbnail) ?? asset('assets-landing-page/img/service/service_img_1.jpg') }}"
                                                alt="{{ $solusi->Judul ?? 'Service Image' }}">

                                        </a>
                                    </div>
                                    <div class="service-content">
                                        <h3 class="box-title">
                                            <a href="{{ $solusi->link ?? '#' }}">{{ $solusi->Judul ?? 'Solusi' }}</a>
                                        </h3>
                                        <p class="service-box_text">{{ $solusi->deskripsi ?? '' }}</p>
                                        <a class="th-btn style4" href="{{ $solusi->link ?? '#' }}">
                                            Read More <i class="fa-light fa-arrow-right-long"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="brand-area overflow-hidden space-bottom">
        <div class="container th-container">
            <div class="swiper th-slider brandSlider1" id="brandSlider1"
                data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"3"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"5"},"1400":{"slidesPerView":"6"}}}'>
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="brand-box">
                            <a href="">
                                <img class="original" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
                                    alt="Brand Logo">
                                <img class="gray" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
                                    alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-box">
                            <a href="">
                                <img class="original" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_2.svg"
                                    alt="Brand Logo">
                                <img class="gray" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_2.svg"
                                    alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-box">
                            <a href="">
                                <img class="original"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_3.svg"
                                    alt="Brand Logo">
                                <img class="gray" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_3.svg"
                                    alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-box">
                            <a href="">
                                <img class="original"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_4.svg"
                                    alt="Brand Logo">
                                <img class="gray" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_4.svg"
                                    alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-box">
                            <a href="">
                                <img class="original"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_5.svg"
                                    alt="Brand Logo">
                                <img class="gray" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_5.svg"
                                    alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-box">
                            <a href="">
                                <img class="original"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_6.svg"
                                    alt="Brand Logo">
                                <img class="gray" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_6.svg"
                                    alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-box">
                            <a href="">
                                <img class="original"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_7.svg"
                                    alt="Brand Logo">
                                <img class="gray" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_7.svg"
                                    alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-box">
                            <a href="">
                                <img class="original"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
                                    alt="Brand Logo">
                                <img class="gray" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
                                    alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-box">
                            <a href="">
                                <img class="original"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_4.svg"
                                    alt="Brand Logo">
                                <img class="gray" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_4.svg"
                                    alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-box">
                            <a href="">
                                <img class="original"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_3.svg"
                                    alt="Brand Logo">
                                <img class="gray" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_3.svg"
                                    alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-box">
                            <a href="">
                                <img class="original"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_2.svg"
                                    alt="Brand Logo">
                                <img class="gray" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_2.svg"
                                    alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-box">
                            <a href="">
                                <img class="original"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
                                    alt="Brand Logo">
                                <img class="gray" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
                                    alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-box">
                            <a href="">
                                <img class="original"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
                                    alt="Brand Logo">
                                <img class="gray" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
                                    alt="Brand Logo">
                            </a>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-box">
                            <a href="">
                                <img class="original"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
                                    alt="Brand Logo">
                                <img class="gray" src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
                                    alt="Brand Logo">
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--==============================
                                                                                                                                    Blog Area
                                                                                                                                    ==============================-->
    <section class="overflow-hidden space bg-smoke overflow-hidden" id="blog-sec">
        <div class="container">
            <div class="mb-30 text-center text-md-start">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-7">
                        <div class="title-area mb-md-0">
                            <span class="sub-title text-anime-style-2">Blog and Article</span>
                            <h2 class="sec-title text-anime-style-3">News & Articles From Atek</h2>
                        </div>
                    </div>
                    <div class="col-md-auto wow fadeInUp">
                        <a href="blog.html" class="th-btn style4 th-icon">See More Articles <i
                                class="fa-light fa-arrow-right-long"></i></a>
                    </div>
                </div>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider has-shadow" id="blogSlider1"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">

                            <div class="blog-box th-ani">
                                <div class="blog-img global-img">
                                    <img src="{{ asset('') }}assets-landing-page/img/blog/blog_1_1.jpg"
                                        alt="blog image">
                                </div>
                                <div class="blog-box_content">
                                    <div class="blog-meta">
                                        <a class="author" href="blog.html">July 05, 2025</a>
                                        <a href="blog.html">6 min read</a>
                                    </div>
                                    <h3 class="box-title"><a href="blog-details.html">Top 10 IT Solutions Every
                                            Business Needs in 2025</a></h3>
                                    <a href="blog-details.html" class="th-btn style4 th-icon">Read More <i
                                            class="fa-light fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">

                            <div class="blog-box th-ani">
                                <div class="blog-img global-img">
                                    <img src="{{ asset('') }}assets-landing-page/img/blog/blog_1_2.jpg"
                                        alt="blog image">
                                </div>
                                <div class="blog-box_content">
                                    <div class="blog-meta">
                                        <a class="author" href="blog.html">August 15, 2025</a>
                                        <a href="blog.html">7 min read</a>
                                    </div>
                                    <h3 class="box-title"><a href="blog-details.html">Exploring the Benefits of
                                            End-to-End IT Solution Services</a></h3>
                                    <a href="blog-details.html" class="th-btn style4 th-icon">Read More <i
                                            class="fa-light fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">

                            <div class="blog-box th-ani">
                                <div class="blog-img global-img">
                                    <img src="{{ asset('') }}assets-landing-page/img/blog/blog_1_3.jpg"
                                        alt="blog image">
                                </div>
                                <div class="blog-box_content">
                                    <div class="blog-meta">
                                        <a class="author" href="blog.html">Sep 15, 2025</a>
                                        <a href="blog.html">8 min read</a>
                                    </div>
                                    <h3 class="box-title"><a href="blog-details.html">The Impact of AI and Machine
                                            Learning on IT Solutions</a></h3>
                                    <a href="blog-details.html" class="th-btn style4 th-icon">Read More <i
                                            class="fa-light fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">

                            <div class="blog-box th-ani">
                                <div class="blog-img global-img">
                                    <img src="{{ asset('') }}assets-landing-page/img/blog/blog_1_1.jpg"
                                        alt="blog image">
                                </div>
                                <div class="blog-box_content">
                                    <div class="blog-meta">
                                        <a class="author" href="blog.html">July 09 2025</a>
                                        <a href="blog.html">9 min read</a>
                                    </div>
                                    <h3 class="box-title"><a href="blog-details.html">Top 10 IT Solutions Every
                                            Business Needs in 2025</a></h3>
                                    <a href="blog-details.html" class="th-btn style4 th-icon">Read More <i
                                            class="fa-light fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">

                            <div class="blog-box th-ani">
                                <div class="blog-img global-img">
                                    <img src="{{ asset('') }}assets-landing-page/img/blog/blog_1_2.jpg"
                                        alt="blog image">
                                </div>
                                <div class="blog-box_content">
                                    <div class="blog-meta">
                                        <a class="author" href="blog.html">Janu 10 2025</a>
                                        <a href="blog.html">10 min read</a>
                                    </div>
                                    <h3 class="box-title"><a href="blog-details.html">Exploring the Benefits of
                                            End-to-End IT Solution Services</a></h3>
                                    <a href="blog-details.html" class="th-btn style4 th-icon">Read More <i
                                            class="fa-light fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">

                            <div class="blog-box th-ani">
                                <div class="blog-img global-img">
                                    <img src="{{ asset('') }}assets-landing-page/img/blog/blog_1_3.jpg"
                                        alt="blog image">
                                </div>
                                <div class="blog-box_content">
                                    <div class="blog-meta">
                                        <a class="author" href="blog.html">Nov 12 2025</a>
                                        <a href="blog.html">11 min read</a>
                                    </div>
                                    <h3 class="box-title"><a href="blog-details.html">The Impact of AI and Machine
                                            Learning on IT Solutions</a></h3>
                                    <a href="blog-details.html" class="th-btn style4 th-icon">Read More <i
                                            class="fa-light fa-arrow-right-long"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="shape-mockup shape1 d-none d-xxl-block" data-bottom="5%" data-left="3%">
            <img src="{{ asset('') }}assets-landing-page/img/shape/blog-1-shape.png" alt="shape">
        </div>
        <div class="shape-mockup shape2 d-none d-xl-block" data-top="28%" data-right="5%">
            <img src="{{ asset('') }}assets-landing-page/img/shape/ab-1-shape-1.png" alt="shape">
        </div>
    </section>
@endsection

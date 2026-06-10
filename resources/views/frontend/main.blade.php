@extends('frontend.index')
@section('content-frontend')
    <div class="th-hero-wrapper hero-1" id="hero">
        <div class="swiper th-slider hero-slider-1" id="heroSlide1"
            data-slider-options='{"effect":"fade","menu": ["", "", ""],"heroSlide1": {"swiper-container": {"pagination": {"el": ".swiper-pagination", "clickable": true }}}}'>
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="hero-inner">
                        <div class="th-hero-bg" data-bg-src="{{ asset('') }}assets-landing-page/img/hero/hero_bg_1_1.jpg">
                        </div>
                        <div class="hero-1-shape d-none d-lg-block" data-ani="slideinleft" data-ani-delay="0.4s">
                            <img src="{{ asset('') }}assets-landing-page/img/shape/hero-1-shape.png" alt="hero-shape">
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-9 col-lg-8">
                                    <div class="hero-style1">
                                        <span class="sub-title style1" data-ani="slideinup" data-ani-delay="0.2s">Dynamic
                                            IT, Dynamic Results.</span>
                                        <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.4s">
                                            Precision IT Solutions, Tailored for You </h1>
                                        <p class="hero-text text-white" data-ani="slideinup" data-ani-delay="0.6s">
                                            Welcome to Atek where we specialize in delivering tailored technology and IT
                                            solutions.</p>
                                        <div class="btn-group" data-ani="slideinup" data-ani-delay="0.8s">
                                            <a href="contact.html" class="th-btn style7 th-icon">
                                                Discover More <i class="fa-light fa-arrow-right-long"></i>
                                            </a>
                                            <a href="service.html" class="th-btn style2 th-icon">
                                                Our Services <i class="fa-light fa-arrow-right-long"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="hero-inner">
                        <div class="th-hero-bg"
                            data-bg-src="{{ asset('') }}assets-landing-page/img/hero/hero_bg_1_2.jpg">
                        </div>
                        <div class="hero-1-shape d-none d-lg-block" data-ani="slideinleft" data-ani-delay="0.4s">
                            <img src="{{ asset('') }}assets-landing-page/img/shape/hero-1-shape.png" alt="hero-shape">
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-9 col-lg-8">
                                    <div class="hero-style1">
                                        <span class="sub-title style1" data-ani="slideinup" data-ani-delay="0.2s">Dynamic
                                            IT, Dynamic Results.</span>
                                        <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.4s">
                                            Smart IT Consulting for Modern Businesses </h1>
                                        <p class="hero-text text-white" data-ani="slideinup" data-ani-delay="0.6s">
                                            Welcome to Atek where we specialize in delivering tailored technology and IT
                                            solutions.</p>
                                        <div class="btn-group" data-ani="slideinup" data-ani-delay="0.8s">
                                            <a href="contact.html" class="th-btn style7 th-icon">
                                                Discover More <i class="fa-light fa-arrow-right-long"></i>
                                            </a>
                                            <a href="service.html" class="th-btn style2 th-icon">
                                                Our Services <i class="fa-light fa-arrow-right-long"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="hero-inner">
                        <div class="th-hero-bg"
                            data-bg-src="{{ asset('') }}assets-landing-page/img/hero/hero_bg_1_3.jpg">
                        </div>
                        <div class="hero-1-shape d-none d-lg-block" data-ani="slideinleft" data-ani-delay="0.4s">
                            <img src="{{ asset('') }}assets-landing-page/img/shape/hero-1-shape.png" alt="hero-shape">
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-9 col-lg-8">
                                    <div class="hero-style1">
                                        <span class="sub-title style1" data-ani="slideinup" data-ani-delay="0.2s">Dynamic
                                            IT, Dynamic Results.</span>
                                        <h1 class="hero-title" data-ani="slideinup" data-ani-delay="0.4s">
                                            Your Trusted Partner in Tech & Strategy </h1>
                                        <p class="hero-text text-white" data-ani="slideinup" data-ani-delay="0.6s">
                                            Welcome to Atek where we specialize in delivering tailored technology and IT
                                            solutions.</p>
                                        <div class="btn-group" data-ani="slideinup" data-ani-delay="0.8s">
                                            <a href="contact.html" class="th-btn style7 th-icon">
                                                Discover More <i class="fa-light fa-arrow-right-long"></i>
                                            </a>
                                            <a href="service.html" class="th-btn style2 th-icon">
                                                Our Services <i class="fa-light fa-arrow-right-long"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="th-swiper-custom">
                <button data-slider-prev="#heroSlide1" class="slider-arrow slider-prev"><img
                        src="{{ asset('') }}assets-landing-page/img/icon/right-arrow.svg" alt=""></button>
                <div class="slider-pagination"></div>
                <button data-slider-next="#heroSlide1" class="slider-arrow slider-next"><img
                        src="{{ asset('') }}assets-landing-page/img/icon/left-arrow.svg" alt=""></button>
            </div>

        </div>
    </div>

    <section class="">
        <div class="feature-list-wrap">
            <!--==============================
    feature Area
    ==============================-->
            <div class="feature-area overflow-hidden " id="feature-area">
                <div class="row gx-0 justify-content-center">
                    <div class="col-xl-4 col-lg-6">
                        <div class="feature-item d-flex align-items-start">
                            <div class="feature-item_icon">
                                <img src="{{ asset('') }}assets-landing-page/img/icon/feature_1_1.svg" alt="icon">
                            </div>
                            <div class="media-body">
                                <h3 class="box-title text-anime-style-2">Highly Expert Team</h3>
                                <p class="feature-item_text wow fadeInUp">We provide the most responsive and functional
                                    IT design</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div class="feature-item d-flex align-items-start">
                            <div class="feature-item_icon">
                                <img src="{{ asset('') }}assets-landing-page/img/icon/feature_1_2.svg" alt="icon">
                            </div>
                            <div class="media-body">
                                <h3 class="box-title text-anime-style-2">24/7 Customer Service</h3>
                                <p class="feature-item_text">We provide the most responsive and functional IT design
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6">
                        <div class="feature-item d-flex align-items-start">
                            <div class="feature-item_icon">
                                <img src="{{ asset('') }}assets-landing-page/img/icon/feature_1_3.svg"
                                    alt="icon">
                            </div>
                            <div class="media-body">
                                <h3 class="box-title text-anime-style-2">Competitive Pricing</h3>
                                <p class="feature-item_text">We provide the most responsive and functional IT design
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!--==============================
    Category Area
    ==============================-->
    <section class="category-area bg-top-center space"
        data-bg-src="{{ asset('') }}assets-landing-page/img/bg/category_bg_1.png">
        <div class="container th-container">
            <div class="title-area mb-60 text-center">
                <span class="sub-title text-anime-style-2">Our Features</span>
                <h2 class="sec-title text-anime-style-3">Reliable IT for Unstoppable Growth</h2>
            </div>
            <div class="swiper th-slider categorySlider" id="categorySlider1"
                data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"spaceBetween":45,"slidesPerView":"5"}}}'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="{{ asset('') }}assets-landing-page/img/category/category_1_1.jpg"
                                    alt="Image">
                            </div>
                            <h3 class="box-title"><a href="service.html">Enhanced Cybersecurity</a></h3>
                            <p class="sec-text">Advanced security measures like firewalls, encryption,</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="{{ asset('') }}assets-landing-page/img/category/category_1_2.jpg"
                                    alt="Image">
                            </div>
                            <h3 class="box-title"><a href="service.html">Cloud Integration</a></h3>
                            <p class="sec-text">Access to scalable cloud-based services for storage</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="{{ asset('') }}assets-landing-page/img/category/category_1_3.jpg"
                                    alt="Image">
                            </div>
                            <h3 class="box-title"><a href="service.html">Customized Services</a></h3>
                            <p class="sec-text">Tailored IT solutions designed to meet specific business needs.</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="{{ asset('') }}assets-landing-page/img/category/category_1_4.jpg"
                                    alt="Image">
                            </div>
                            <h3 class="box-title"><a href="service.html">24/7 IT Support</a></h3>
                            <p class="sec-text">Around-the-clock monitoring and troubleshooting.</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="{{ asset('') }}assets-landing-page/img/category/category_1_5.jpg"
                                    alt="Image">
                            </div>
                            <h3 class="box-title"><a href="service.html">End-to-End Solution</a></h3>
                            <p class="sec-text">Covers all aspects of IT, from consu-lting and planning</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="{{ asset('') }}assets-landing-page/img/category/category_1_1.jpg"
                                    alt="Image">
                            </div>
                            <h3 class="box-title"><a href="service.html">Airbirds</a></h3>
                            <p class="sec-text">Advanced security measures like firewalls, encryption,</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="{{ asset('') }}assets-landing-page/img/category/category_1_2.jpg"
                                    alt="Image">
                            </div>
                            <h3 class="box-title"><a href="service.html">Enhanced Cybersecurity</a></h3>
                            <p class="sec-text">Access to scalable cloud-based services for storage</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="{{ asset('') }}assets-landing-page/img/category/category_1_3.jpg"
                                    alt="Image">
                            </div>
                            <h3 class="box-title"><a href="service.html">Hiking</a></h3>
                            <p class="sec-text">Tailored IT solutions designed to meet specific business needs.</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="{{ asset('') }}assets-landing-page/img/category/category_1_4.jpg"
                                    alt="Image">
                            </div>
                            <h3 class="box-title"><a href="service.html">Cloud Integration</a></h3>
                            <p class="sec-text">Around-the-clock monitoring and troubleshooting.</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="{{ asset('') }}assets-landing-page/img/category/category_1_5.jpg"
                                    alt="Image">
                            </div>
                            <h3 class="box-title"><a href="service.html">Cruises</a></h3>
                            <p class="sec-text">Covers all aspects of IT, from consu-lting and planning</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="{{ asset('') }}assets-landing-page/img/category/category_1_1.jpg"
                                    alt="Image">
                            </div>
                            <h3 class="box-title"><a href="service.html">Customized Services</a></h3>
                            <p class="sec-text">Advanced security measures like firewalls, encryption,</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="{{ asset('') }}assets-landing-page/img/category/category_1_2.jpg"
                                    alt="Image">
                            </div>
                            <h3 class="box-title"><a href="service.html">Walking</a></h3>
                            <p class="sec-text">Access to scalable cloud-based services for storage</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="{{ asset('') }}assets-landing-page/img/category/category_1_3.jpg"
                                    alt="Image">
                            </div>
                            <h3 class="box-title"><a href="service.html">24/7 IT Support</a></h3>
                            <p class="sec-text">Tailored IT solutions designed to meet specific business needs.</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="{{ asset('') }}assets-landing-page/img/category/category_1_4.jpg"
                                    alt="Image">
                            </div>
                            <h3 class="box-title"><a href="service.html">Walking</a></h3>
                            <p class="sec-text">Around-the-clock monitoring and troubleshooting.</p>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="category-card single">
                            <div class="box-img global-img">
                                <img src="{{ asset('') }}assets-landing-page/img/category/category_1_5.jpg"
                                    alt="Image">
                            </div>
                            <h3 class="box-title"><a href="service.html">Customized Services</a></h3>
                            <p class="sec-text">Covers all aspects of IT, from consu-lting and planning</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section><!--==============================
    About Area
    ==============================-->
    <div class="about-area position-relative overflow-hidden " id="about-sec">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="img-box1">
                        <div class="img1">
                            <img src="{{ asset('') }}assets-landing-page/img/normal/about_1_1.jpg" alt="About">
                        </div>
                        <div class="img2">
                            <img src="{{ asset('') }}assets-landing-page/img/normal/about_1_2.jpg" alt="About">
                        </div>
                        <div class="img3">
                            <img src="{{ asset('') }}assets-landing-page/img/normal/about_1_3.jpg" alt="About">
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="ps-xl-4 ms-xxl-4">
                        <div class="title-area about1-title-box mb-20 pe-xxl-5 me-xxl-5">
                            <span class="sub-title style1 text-anime-style-2">About Us Our Company</span>
                            <h2 class="sec-title mb-20 heading text-anime-style-3">Solutions That Evolve with Your
                                Business</h2>

                            <p class="sec-text mb-30 wow fadeInUp" data-wow-delay=".1s">IT solutions refer to a broad
                                range of services and technologies designed to address specific business needs,
                                streamline operations, and drive growth. These solutions encompass hardware.</p>
                        </div>
                        <div class="about-item-wrap">
                            <div class="about-item wow fadeInUp" data-wow-delay=".2s">
                                <div class="about-item_img"><img
                                        src="{{ asset('') }}assets-landing-page/img/icon/map3.svg" alt="">
                                </div>
                                <div class="about-item_centent">
                                    <h5 class="box-title">Manage Tech Services</h5>
                                    <p class="about-item_text">There are many variations of passages of available but
                                        the
                                        majority.</p>
                                </div>
                            </div>
                            <div class="about-item wow fadeInUp" data-wow-delay=".3s">
                                <div class="about-item_img"><img
                                        src="{{ asset('') }}assets-landing-page/img/icon/guide.svg" alt="">
                                </div>
                                <div class="about-item_centent">
                                    <h5 class="box-title">Internal Networking</h5>
                                    <p class="about-item_text">There are many variations of passages of available but
                                        the
                                        majority.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-35 wow fadeInUp">
                            <a href="about.html" class="th-btn th-icon">Learn More <i
                                    class="fa-light fa-arrow-right-long"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="shape-mockup shape1 d-none d-xl-block" data-top="12%" data-right="-16%">
                <img src="{{ asset('') }}assets-landing-page/img/shape/ab-1-shape-1.png" alt="shape">
            </div>
            <div class="shape-mockup shape3 d-none d-xl-block" data-bottom="2%" data-left="-20%">
                <img src="{{ asset('') }}assets-landing-page/img/shape/ab-1-shape-2.png" alt="shape">
            </div>

            <div class="shape-mockup about-shape movingX d-none d-xxl-block" data-bottom="20%" data-right="-11%">
                <img src="{{ asset('') }}assets-landing-page/img/normal/about-right-img.jpg" alt="shape">
            </div>
        </div>

    </div>
    <!--==============================
    destination Area
    ==============================-->
    <div class="case-area position-relative overflow-hidden space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="title-area case-title-box text-center text-xl-start">
                        <span class="sub-title mb-15  text-anime-style-2">Case Studies</span>
                        <h2 class="sec-title  text-anime-style-3">Transforming Ideas into Innovations</h2>
                    </div>
                </div>
                <div class="col-xl-7">
                    <div class="nav nav-tabs case-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link th-btn active" id="nav-step1-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-step1" type="button">Development</button>
                        <button class="nav-link th-btn" id="nav-step2-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-step2" type="button">Woo Commerce</button>
                        <button class="nav-link th-btn" id="nav-step3-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-step3" type="button">CRM Solutions</button>
                        <button class="nav-link th-btn" id="nav-step4-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-step4" type="button">Web Design</button>
                        <button class="nav-link th-btn" id="nav-step5-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-step5" type="button">IT Support</button>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-step1" role="tabpanel">
                    <div class="slider-area case-slider slider-drag-wrap">
                        <div class="swiper th-slider case-slider" id="aboutSlider1"
                            data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}},"effect":"coverflow","coverflowEffect":{"rotate":"0","stretch":"95","depth":"212","modifier":"1"},"centeredSlides":"true"}'>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_1.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Web & Mobile Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Development</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_2.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Ui/Ux Design</a>
                                                    </h4>
                                                    <span class="case-subtitle">Ui/Ux Design</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_3.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Backend Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Python</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_4.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Python Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">JavaScript</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_5.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Apps Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Java</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_1.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Ui/Ux Design</a>
                                                    </h4>
                                                    <span class="case-subtitle">Php</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_2.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">JavaScript</a>
                                                    </h4>
                                                    <span class="case-subtitle">Html</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_3.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Php Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Androied</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_4.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Java Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">IOS</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_5.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Software Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Software Development</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-step2" role="tabpanel">
                    <div class="slider-area case-slider slider-drag-wrap">
                        <div class="swiper th-slider case-slider" id="aboutSlider2"
                            data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}},"effect":"coverflow","coverflowEffect":{"rotate":"0","stretch":"95","depth":"212","modifier":"1"},"centeredSlides":"true"}'>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_1.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Web & Mobile Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Development</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_2.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Ui/Ux Design</a>
                                                    </h4>
                                                    <span class="case-subtitle">Ui/Ux Design</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_3.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Backend Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Python</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_4.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Python Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">JavaScript</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_5.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Apps Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Java</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_1.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Ui/Ux Design</a>
                                                    </h4>
                                                    <span class="case-subtitle">Php</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_2.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">JavaScript</a>
                                                    </h4>
                                                    <span class="case-subtitle">Html</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_3.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Php Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Androied</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_4.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Java Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">IOS</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_5.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Software Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Software Development</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-step3" role="tabpanel">
                    <div class="slider-area case-slider slider-drag-wrap">
                        <div class="swiper th-slider case-slider" id="aboutSlider3"
                            data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}},"effect":"coverflow","coverflowEffect":{"rotate":"0","stretch":"95","depth":"212","modifier":"1"},"centeredSlides":"true"}'>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_1.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Web & Mobile Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Development</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_2.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Ui/Ux Design</a>
                                                    </h4>
                                                    <span class="case-subtitle">Ui/Ux Design</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_3.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Backend Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Python</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_4.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Python Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">JavaScript</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_5.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Apps Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Java</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_1.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Ui/Ux Design</a>
                                                    </h4>
                                                    <span class="case-subtitle">Php</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_2.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">JavaScript</a>
                                                    </h4>
                                                    <span class="case-subtitle">Html</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_3.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Php Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Androied</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_4.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Java Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">IOS</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_5.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Software Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Software Development</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-step4" role="tabpanel">
                    <div class="slider-area case-slider slider-drag-wrap">
                        <div class="swiper th-slider case-slider" id="aboutSlider4"
                            data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}},"effect":"coverflow","coverflowEffect":{"rotate":"0","stretch":"95","depth":"212","modifier":"1"},"centeredSlides":"true"}'>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_1.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Web & Mobile Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Development</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_2.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Ui/Ux Design</a>
                                                    </h4>
                                                    <span class="case-subtitle">Ui/Ux Design</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_3.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Backend Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Python</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_4.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Python Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">JavaScript</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_5.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Apps Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Java</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_1.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Ui/Ux Design</a>
                                                    </h4>
                                                    <span class="case-subtitle">Php</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_2.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">JavaScript</a>
                                                    </h4>
                                                    <span class="case-subtitle">Html</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_3.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Php Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Androied</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_4.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Java Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">IOS</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_5.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Software Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Software Development</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-step5" role="tabpanel">
                    <div class="slider-area case-slider slider-drag-wrap">
                        <div class="swiper th-slider case-slider" id="aboutSlider5"
                            data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}},"effect":"coverflow","coverflowEffect":{"rotate":"0","stretch":"95","depth":"212","modifier":"1"},"centeredSlides":"true"}'>
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_1.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Web & Mobile Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Development</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_2.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Ui/Ux Design</a>
                                                    </h4>
                                                    <span class="case-subtitle">Ui/Ux Design</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_3.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Backend Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Python</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_4.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Python Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">JavaScript</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_5.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Apps Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Java</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_1.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Ui/Ux Design</a>
                                                    </h4>
                                                    <span class="case-subtitle">Php</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_2.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">JavaScript</a>
                                                    </h4>
                                                    <span class="case-subtitle">Html</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_3.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Php Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Androied</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_4.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Java Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">IOS</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="case-box">
                                        <div class="case-img">
                                            <img src="{{ asset('') }}assets-landing-page/img/case/case_1_5.jpg"
                                                alt="case image">
                                            <div class="case-content">
                                                <div class="media-left">
                                                    <h4 class="box-title">
                                                        <a href="case-study-details.html">Software Development</a>
                                                    </h4>
                                                    <span class="case-subtitle">Software Development</span>
                                                </div>
                                            </div>
                                            <div class="case-action">
                                                <a href="case-study-details.html" class="case-btn"><i
                                                        class="fa-light fa-arrow-right-long"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--==============================
    Servce Area
    ==============================-->
    <section class="position-relative bg-top-center overflow-hidden space" id="service-sec"
        data-bg-src="{{ asset('') }}assets-landing-page/img/bg/service_bg_1.jpg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="title-area service-title-box text-center">
                        <span class="sub-title mb-15  text-anime-style-2">What We’re Offering</span>
                        <h2 class="sec-title  text-anime-style-2">Dealing in all professional IT services</h2>
                        <p class="sec-text mb-50 wow fadeInUp" data-wow-delay=".4s">IT solutions refer to a broad
                            range of services and technologies designed to address <br> specific business needs,
                            streamline operations, and drive growth.</p>
                    </div>
                </div>
            </div>
            <div class="slider-area slider-drag-wrap">
                <div class="swiper th-slider has-shadow"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1300":{"slidesPerView":"4"}}}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="service-box service-style-1 gsap-cursor">
                                <div class="service-img">
                                    <a href="service-details.html">
                                        <img src="{{ asset('') }}assets-landing-page/img/service/service_img_1.jpg"
                                            alt="">
                                    </a>
                                </div>
                                <div class="service-content">
                                    <h3 class="box-title">
                                        <a href="service-details.html">IT Strategy & Planning</a>
                                    </h3>
                                    <p class="service-box_text">Assessing current IT infrastructure and aligning it
                                        with business goals. Developing a roadmap.</p>
                                    <a class="th-btn style4" href="service-details.html">
                                        Read More <i class="fa-light fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="service-box service-style-1 gsap-cursor">
                                <div class="service-img">
                                    <a href="service-details.html">
                                        <img src="{{ asset('') }}assets-landing-page/img/service/service_img_2.jpg"
                                            alt="">
                                    </a>
                                </div>
                                <div class="service-content">
                                    <h3 class="box-title">
                                        <a href="service-details.html">Web Development</a>
                                    </h3>
                                    <p class="service-box_text">Assessing current IT infrastructure and aligning it
                                        with business goals. Developing a roadmap.</p>
                                    <a class="th-btn style4" href="service-details.html">
                                        Read More <i class="fa-light fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="service-box service-style-1 gsap-cursor">
                                <div class="service-img">
                                    <a href="service-details.html">
                                        <img src="{{ asset('') }}assets-landing-page/img/service/service_img_3.jpg"
                                            alt="">
                                    </a>
                                </div>
                                <div class="service-content">
                                    <h3 class="box-title">
                                        <a href="service-details.html">Cloud Consulting</a>
                                    </h3>
                                    <p class="service-box_text">Assessing current IT infrastructure and aligning it
                                        with business goals. Developing a roadmap.</p>
                                    <a class="th-btn style4" href="service-details.html">
                                        Read More <i class="fa-light fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="service-box service-style-1 gsap-cursor">
                                <div class="service-img">
                                    <a href="service-details.html">
                                        <img src="{{ asset('') }}assets-landing-page/img/service/service_img_4.jpg"
                                            alt="">
                                    </a>
                                </div>
                                <div class="service-content">
                                    <h3 class="box-title">
                                        <a href="service-details.html">Machine Learning</a>
                                    </h3>
                                    <p class="service-box_text">Assessing current IT infrastructure and aligning it
                                        with business goals. Developing a roadmap.</p>
                                    <a class="th-btn style4" href="service-details.html">
                                        Read More <i class="fa-light fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="service-box service-style-1 gsap-cursor">
                                <div class="service-img">
                                    <a href="service-details.html">
                                        <img src="{{ asset('') }}assets-landing-page/img/service/service_img_2.jpg"
                                            alt="">
                                    </a>
                                </div>
                                <div class="service-content">
                                    <h3 class="box-title">
                                        <a href="service-details.html">House Renovation</a>
                                    </h3>
                                    <p class="service-box_text">Assessing current IT infrastructure and aligning it
                                        with business goals. Developing a roadmap.</p>
                                    <a class="th-btn style4" href="service-details.html">
                                        Read More <i class="fa-light fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="service-box service-style-1 gsap-cursor">
                                <div class="service-img">
                                    <a href="service-details.html">
                                        <img src="{{ asset('') }}assets-landing-page/img/service/service_img_1.jpg"
                                            alt="">
                                    </a>
                                </div>
                                <div class="service-content">
                                    <h3 class="box-title">
                                        <a href="service-details.html">Material Supply</a>
                                    </h3>
                                    <p class="service-box_text">Assessing current IT infrastructure and aligning it
                                        with business goals. Developing a roadmap.</p>
                                    <a class="th-btn style4" href="service-details.html">
                                        Read More <i class="fa-light fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="service-box service-style-1 gsap-cursor">
                                <div class="service-img">
                                    <a href="service-details.html">
                                        <img src="{{ asset('') }}assets-landing-page/img/service/service_img_4.jpg"
                                            alt="">
                                    </a>
                                </div>
                                <div class="service-content">
                                    <h3 class="box-title">
                                        <a href="service-details.html">General Contracting</a>
                                    </h3>
                                    <p class="service-box_text">Assessing current IT infrastructure and aligning it
                                        with business goals. Developing a roadmap.</p>
                                    <a class="th-btn style4" href="service-details.html">
                                        Read More <i class="fa-light fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="service-box service-style-1 gsap-cursor">
                                <div class="service-img">
                                    <a href="service-details.html">
                                        <img src="{{ asset('') }}assets-landing-page/img/service/service_img_2.jpg"
                                            alt="">
                                    </a>
                                </div>
                                <div class="service-content">
                                    <h3 class="box-title">
                                        <a href="service-details.html">Architecture Design</a>
                                    </h3>
                                    <p class="service-box_text">Assessing current IT infrastructure and aligning it
                                        with business goals. Developing a roadmap.</p>
                                    <a class="th-btn style4" href="service-details.html">
                                        Read More <i class="fa-light fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="service-box service-style-1 gsap-cursor">
                                <div class="service-img">
                                    <a href="service-details.html">
                                        <img src="{{ asset('') }}assets-landing-page/img/service/service_img_1.jpg"
                                            alt="">
                                    </a>
                                </div>
                                <div class="service-content">
                                    <h3 class="box-title">
                                        <a href="service-details.html">House Renovation</a>
                                    </h3>
                                    <p class="service-box_text">Assessing current IT infrastructure and aligning it
                                        with business goals. Developing a roadmap.</p>
                                    <a class="th-btn style4" href="service-details.html">
                                        Read More <i class="fa-light fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section><!--==============================
    Gallery Area
    ==============================-->
    <div class="gallery-area overflow-hidden">
        <div class="container th-container">
            <div class="title-area text-center">
                <span class="sub-title mb-15 text-anime-style-2">Our Gallery</span>
                <h2 class="sec-title text-anime-style-3">Our Recent Project Gallery</h2>
            </div>
            <div class="row gy-10 gx-10 justify-content-center align-items-center">
                <div class="col-md-6 col-lg-2">
                    <div class="gallery-card">
                        <div class="box-img global-img">
                            <a href="{{ asset('') }}assets-landing-page/img/gallery/gallery_1_1.jpg"
                                class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div>
                                <img src="{{ asset('') }}assets-landing-page/img/gallery/gallery_1_1.jpg"
                                    alt="gallery image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="gallery-card">
                        <div class="box-img global-img">
                            <a href="{{ asset('') }}assets-landing-page/img/gallery/gallery_1_2.jpg"
                                class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div>
                                <img src="{{ asset('') }}assets-landing-page/img/gallery/gallery_1_2.jpg"
                                    alt="gallery image">
                            </a>
                        </div>
                    </div>
                    <div class="gallery-card">
                        <div class="box-img global-img">
                            <a href="{{ asset('') }}assets-landing-page/img/gallery/gallery_1_3.jpg"
                                class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div>
                                <img src="{{ asset('') }}assets-landing-page/img/gallery/gallery_1_3.jpg"
                                    alt="gallery image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="gallery-card">
                        <div class="box-img global-img">
                            <a href="{{ asset('') }}assets-landing-page/img/gallery/gallery_1_4.jpg"
                                class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div>
                                <img src="{{ asset('') }}assets-landing-page/img/gallery/gallery_1_4.jpg"
                                    alt="gallery image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="gallery-card">
                        <div class="box-img global-img">
                            <a href="{{ asset('') }}assets-landing-page/img/gallery/gallery_1_5.jpg"
                                class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div>
                                <img src="{{ asset('') }}assets-landing-page/img/gallery/gallery_1_5.jpg"
                                    alt="gallery image">
                            </a>
                        </div>
                    </div>
                    <div class="gallery-card">
                        <div class="box-img global-img">
                            <a href="{{ asset('') }}assets-landing-page/img/gallery/gallery_1_6.jpg"
                                class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div>
                                <img src="{{ asset('') }}assets-landing-page/img/gallery/gallery_1_6.jpg"
                                    alt="gallery image">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="gallery-card">
                        <div class="box-img global-img">
                            <a href="{{ asset('') }}assets-landing-page/img/gallery/gallery_1_7.jpg"
                                class="popup-image">
                                <div class="icon-btn"><i class="fal fa-magnifying-glass-plus"></i></div>
                                <img src="{{ asset('') }}assets-landing-page/img/gallery/gallery_1_7.jpg"
                                    alt="gallery image">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="shape-mockup th-line-shape d-none d-xl-block" data-top="-18%" data-left="0">
                <span>
                    <svg width="3200" height="860" viewBox="0 0 3200 860" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path class="line-1"
                            d="M2138 14.0506C2095.27 -17.4415 2002.06 10.9842 1886.26 120.726C1741.5 257.904 1351.09 392.927 1300.98 262.785C1236.52 95.3792 1538.14 78.636 1447.87 346.052C1357.6 613.468 810.026 408.273 376.356 511.519C46.7827 589.983 -27.4648 825.017 -14.6451 859"
                            stroke="currentColor" stroke-width="4" />
                    </svg>
                </span>
            </div>
            <div class="shape-mockup movingX d-none d-xl-block" data-top="11%" data-left="-3%">
                <img class="gmovingX" src="{{ asset('') }}assets-landing-page/img/shape/g-shape-1.png"
                    alt="shape">
            </div>
            <div class="shape-mockup jump d-none d-xl-block" data-bottom="0" data-right="-3%">
                <img class="gmovingX" src="{{ asset('') }}assets-landing-page/img/shape/ab-1-shape-2.png"
                    alt="shape">
            </div>
        </div>
    </div><!--==============================
    Counter Area
    ==============================-->
    <div class="counter-area space space-extra3-bottom overflow-hidden">
        <div class="container">
            <div class="counter-wrap1">
                <div class="row">

                    <div class="col-md-6 col-xl-3 counter-card-wrap">
                        <div class="counter-card">
                            <div class="counter-shape"><span></span></div>
                            <div class="media-body">
                                <h3 class="box-number"><span class="counter-number">12</span></h3>
                                <h6 class="counter-title">Years Experience</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3 counter-card-wrap">
                        <div class="counter-card">
                            <div class="counter-shape"><span></span></div>
                            <div class="media-body">
                                <h3 class="box-number"><span class="counter-number">97</span>%</h3>
                                <h6 class="counter-title">Retention Rate</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3 counter-card-wrap">
                        <div class="counter-card">
                            <div class="counter-shape"><span></span></div>
                            <div class="media-body">
                                <h3 class="box-number"><span class="counter-number">8</span>k</h3>
                                <h6 class="counter-title">Project Completed</h6>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3 counter-card-wrap">
                        <div class="counter-card">
                            <div class="counter-shape"><span></span></div>
                            <div class="media-body">
                                <h3 class="box-number"><span class="counter-number">19</span>k</h3>
                                <h6 class="counter-title">Happy Clients</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shape-mockup jump d-none d-xl-block" data-bottom="0%" data-left="-12%">
                    <img src="{{ asset('') }}assets-landing-page/img/shape/shape_5.png" alt="shape">
                </div>
            </div>
        </div>
    </div><!--==============================
    Team Area
    ==============================-->
    <section class="bg-smoke space overflow-hidden"
        data-bg-src="{{ asset('') }}assets-landing-page/img/bg/team_bg_1.png">
        <div class="container z-index-common">
            <div class="title-area text-center">
                <span class="sub-title text-anime-style-2">Our Team Memners</span>
                <h2 class="sec-title text-anime-style-3">Meet Our Expert Members</h2>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider teamSlider1 has-shadow" id="teamSlider1"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"4"}}}'>
                    <div class="swiper-wrapper">
                        <!-- Single Item -->
                        <div class="swiper-slide">
                            <div class="th-team team-box">
                                <div class="team-img">
                                    <img src="{{ asset('') }}assets-landing-page/img/team/team_1_1.jpg"
                                        alt="Team">
                                </div>
                                <div class="team-content">
                                    <div class="media-body">
                                        <h3 class="box-title"><a href="team-guider-details.html">Jacob Jones</a>
                                        </h3>
                                        <span class="team-desig">UI/UX Designer</span>
                                        <div class="th-social">
                                            <a target="_blank" href="https://facebook.com/"><i
                                                    class="fab fa-facebook-f"></i></a>
                                            <a target="_blank" href="https://twitter.com/"><i
                                                    class="fab fa-twitter"></i></a>
                                            <a target="_blank" href="https://linkedin.com/"><i
                                                    class="fab fa-linkedin-in"></i></a>
                                            <a target="_blank" href="https://youtube.com/"><i
                                                    class="fa-brands fa-youtube"></i></a>
                                            <a target="_blank" href="https://instagram.com/"><i
                                                    class="fab fa-instagram"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="swiper-slide">
                            <div class="th-team team-box">
                                <div class="team-img">
                                    <img src="{{ asset('') }}assets-landing-page/img/team/team_1_2.jpg"
                                        alt="Team">
                                </div>
                                <div class="team-content">
                                    <div class="media-body">
                                        <h3 class="box-title"><a href="team-guider-details.html">Jane Cooper</a>
                                        </h3>
                                        <span class="team-desig">Front-End Developer</span>
                                        <div class="th-social">
                                            <a target="_blank" href="https://facebook.com/"><i
                                                    class="fab fa-facebook-f"></i></a>
                                            <a target="_blank" href="https://twitter.com/"><i
                                                    class="fab fa-twitter"></i></a>
                                            <a target="_blank" href="https://linkedin.com/"><i
                                                    class="fab fa-linkedin-in"></i></a>
                                            <a target="_blank" href="https://youtube.com/"><i
                                                    class="fa-brands fa-youtube"></i></a>
                                            <a target="_blank" href="https://instagram.com/"><i
                                                    class="fab fa-instagram"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="swiper-slide">
                            <div class="th-team team-box">
                                <div class="team-img">
                                    <img src="{{ asset('') }}assets-landing-page/img/team/team_1_3.jpg"
                                        alt="Team">
                                </div>
                                <div class="team-content">
                                    <div class="media-body">
                                        <h3 class="box-title"><a href="team-guider-details.html">Guy Hawkins</a>
                                        </h3>
                                        <span class="team-desig">Backend Engineer</span>
                                        <div class="th-social">
                                            <a target="_blank" href="https://facebook.com/"><i
                                                    class="fab fa-facebook-f"></i></a>
                                            <a target="_blank" href="https://twitter.com/"><i
                                                    class="fab fa-twitter"></i></a>
                                            <a target="_blank" href="https://linkedin.com/"><i
                                                    class="fab fa-linkedin-in"></i></a>
                                            <a target="_blank" href="https://youtube.com/"><i
                                                    class="fa-brands fa-youtube"></i></a>
                                            <a target="_blank" href="https://instagram.com/"><i
                                                    class="fab fa-instagram"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="swiper-slide">
                            <div class="th-team team-box">
                                <div class="team-img">
                                    <img src="{{ asset('') }}assets-landing-page/img/team/team_1_4.jpg"
                                        alt="Team">
                                </div>
                                <div class="team-content">
                                    <div class="media-body">
                                        <h3 class="box-title"><a href="team-guider-details.html">Jenny Wilson</a>
                                        </h3>
                                        <span class="team-desig">Python Developer</span>
                                        <div class="th-social">
                                            <a target="_blank" href="https://facebook.com/"><i
                                                    class="fab fa-facebook-f"></i></a>
                                            <a target="_blank" href="https://twitter.com/"><i
                                                    class="fab fa-twitter"></i></a>
                                            <a target="_blank" href="https://linkedin.com/"><i
                                                    class="fab fa-linkedin-in"></i></a>
                                            <a target="_blank" href="https://youtube.com/"><i
                                                    class="fa-brands fa-youtube"></i></a>
                                            <a target="_blank" href="https://instagram.com/"><i
                                                    class="fab fa-instagram"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="swiper-slide">
                            <div class="th-team team-box">
                                <div class="team-img">
                                    <img src="{{ asset('') }}assets-landing-page/img/team/team_1_1.jpg"
                                        alt="Team">
                                </div>
                                <div class="team-content">
                                    <div class="media-body">
                                        <h3 class="box-title"><a href="team-guider-details.html">Jacob Jones</a>
                                        </h3>
                                        <span class="team-desig">PHP Developer</span>
                                        <div class="th-social">
                                            <a target="_blank" href="https://facebook.com/"><i
                                                    class="fab fa-facebook-f"></i></a>
                                            <a target="_blank" href="https://twitter.com/"><i
                                                    class="fab fa-twitter"></i></a>
                                            <a target="_blank" href="https://linkedin.com/"><i
                                                    class="fab fa-linkedin-in"></i></a>
                                            <a target="_blank" href="https://youtube.com/"><i
                                                    class="fa-brands fa-youtube"></i></a>
                                            <a target="_blank" href="https://instagram.com/"><i
                                                    class="fab fa-instagram"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="swiper-slide">
                            <div class="th-team team-box">
                                <div class="team-img">
                                    <img src="{{ asset('') }}assets-landing-page/img/team/team_1_2.jpg"
                                        alt="Team">
                                </div>
                                <div class="team-content">
                                    <div class="media-body">
                                        <h3 class="box-title"><a href="team-guider-details.html">Jane Cooper</a>
                                        </h3>
                                        <span class="team-desig">Django Developer</span>
                                        <div class="th-social">
                                            <a target="_blank" href="https://facebook.com/"><i
                                                    class="fab fa-facebook-f"></i></a>
                                            <a target="_blank" href="https://twitter.com/"><i
                                                    class="fab fa-twitter"></i></a>
                                            <a target="_blank" href="https://linkedin.com/"><i
                                                    class="fab fa-linkedin-in"></i></a>
                                            <a target="_blank" href="https://youtube.com/"><i
                                                    class="fa-brands fa-youtube"></i></a>
                                            <a target="_blank" href="https://instagram.com/"><i
                                                    class="fab fa-instagram"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="swiper-slide">
                            <div class="th-team team-box">
                                <div class="team-img">
                                    <img src="{{ asset('') }}assets-landing-page/img/team/team_1_3.jpg"
                                        alt="Team">
                                </div>
                                <div class="team-content">
                                    <div class="media-body">
                                        <h3 class="box-title"><a href="team-guider-details.html">Guy Hawkins</a>
                                        </h3>
                                        <span class="team-desig">JavaScrip Developer</span>
                                        <div class="th-social">
                                            <a target="_blank" href="https://facebook.com/"><i
                                                    class="fab fa-facebook-f"></i></a>
                                            <a target="_blank" href="https://twitter.com/"><i
                                                    class="fab fa-twitter"></i></a>
                                            <a target="_blank" href="https://linkedin.com/"><i
                                                    class="fab fa-linkedin-in"></i></a>
                                            <a target="_blank" href="https://youtube.com/"><i
                                                    class="fa-brands fa-youtube"></i></a>
                                            <a target="_blank" href="https://instagram.com/"><i
                                                    class="fab fa-instagram"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="swiper-slide">
                            <div class="th-team team-box">
                                <div class="team-img">
                                    <img src="{{ asset('') }}assets-landing-page/img/team/team_1_4.jpg"
                                        alt="Team">
                                </div>
                                <div class="team-content">
                                    <div class="media-body">
                                        <h3 class="box-title"><a href="team-guider-details.html">Jenny Wilson</a>
                                        </h3>
                                        <span class="team-desig">App Developer</span>
                                        <div class="th-social">
                                            <a target="_blank" href="https://facebook.com/"><i
                                                    class="fab fa-facebook-f"></i></a>
                                            <a target="_blank" href="https://twitter.com/"><i
                                                    class="fab fa-twitter"></i></a>
                                            <a target="_blank" href="https://linkedin.com/"><i
                                                    class="fab fa-linkedin-in"></i></a>
                                            <a target="_blank" href="https://youtube.com/"><i
                                                    class="fa-brands fa-youtube"></i></a>
                                            <a target="_blank" href="https://instagram.com/"><i
                                                    class="fab fa-instagram"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="slider-pagination"></div>
                </div>
            </div>
        </div>
    </section><!--==============================
    Testimonial Area
    ==============================-->
    <section class="testi-area overflow-hidden space" id="testi-sec">
        <div class="container-fluid p-0">
            <div class="title-area mb-20 text-center">
                <span class="sub-title text-anime-style-2">Testimonial</span>
                <h2 class="sec-title text-anime-style-3">What Client Say About us</h2>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider testiSlider1 has-shadow" id="testiSlider1"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"767":{"slidesPerView":"1","centeredSlides":"true"},"992":{"slidesPerView":"2","centeredSlides":"true"},"1200":{"slidesPerView":"2.5","centeredSlides":"true"},"1400":{"spaceBetween":5,"slidesPerView":"2.5","centeredSlides":"true"}}}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater">
                                            <img src="{{ asset('') }}assets-landing-page/img/testimonial/testi_1_1.jpg"
                                                alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Maria Doe</h3>
                                            <span class="testi-card_desig">UI/UX Designer</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">“IT consulting services are designed to help businesses
                                    optimize their technology strategies, streamline operations, and align IT solutions
                                    with their goal. Here are some key service offered under IT consulting Assisting
                                    with cloud migration.”</p>
                                <div class="testi-card-quote">
                                    <img src="{{ asset('') }}assets-landing-page/img/icon/testi-quote.svg"
                                        alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater">
                                            <img src="{{ asset('') }}assets-landing-page/img/testimonial/testi_1_2.jpg"
                                                alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Andrew Simon</h3>
                                            <span class="testi-card_desig">Front-End Developer</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">“IT consulting services are designed to help businesses
                                    optimize their technology strategies, streamline operations, and align IT solutions
                                    with their goal. Here are some key service offered under IT consulting Assisting
                                    with cloud migration.”</p>
                                <div class="testi-card-quote">
                                    <img src="{{ asset('') }}assets-landing-page/img/icon/testi-quote.svg"
                                        alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater">
                                            <img src="{{ asset('') }}assets-landing-page/img/testimonial/testi_1_3.jpg"
                                                alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Alex Jordan</h3>
                                            <span class="testi-card_desig">Backend Engineer</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">“IT consulting services are designed to help businesses
                                    optimize their technology strategies, streamline operations, and align IT solutions
                                    with their goal. Here are some key service offered under IT consulting Assisting
                                    with cloud migration.”</p>
                                <div class="testi-card-quote">
                                    <img src="{{ asset('') }}assets-landing-page/img/icon/testi-quote.svg"
                                        alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater">
                                            <img src="{{ asset('') }}assets-landing-page/img/testimonial/testi_1_2.jpg"
                                                alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Maria Doe</h3>
                                            <span class="testi-card_desig">Python Developer</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">“IT consulting services are designed to help businesses
                                    optimize their technology strategies, streamline operations, and align IT solutions
                                    with their goal. Here are some key service offered under IT consulting Assisting
                                    with cloud migration.”</p>
                                <div class="testi-card-quote">
                                    <img src="{{ asset('') }}assets-landing-page/img/icon/testi-quote.svg"
                                        alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater">
                                            <img src="{{ asset('') }}assets-landing-page/img/testimonial/testi_1_1.jpg"
                                                alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Angelina Rose</h3>
                                            <span class="testi-card_desig">PHP Developer</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">“IT consulting services are designed to help businesses
                                    optimize their technology strategies, streamline operations, and align IT solutions
                                    with their goal. Here are some key service offered under IT consulting Assisting
                                    with cloud migration.”</p>
                                <div class="testi-card-quote">
                                    <img src="{{ asset('') }}assets-landing-page/img/icon/testi-quote.svg"
                                        alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater">
                                            <img src="{{ asset('') }}assets-landing-page/img/testimonial/testi_1_3.jpg"
                                                alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Maria Doe</h3>
                                            <span class="testi-card_desig">Django Developer</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">“IT consulting services are designed to help businesses
                                    optimize their technology strategies, streamline operations, and align IT solutions
                                    with their goal. Here are some key service offered under IT consulting Assisting
                                    with cloud migration.”</p>
                                <div class="testi-card-quote">
                                    <img src="{{ asset('') }}assets-landing-page/img/icon/testi-quote.svg"
                                        alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater">
                                            <img src="{{ asset('') }}assets-landing-page/img/testimonial/testi_1_2.jpg"
                                                alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Andrew Simon</h3>
                                            <span class="testi-card_desig">JavaScrip Developer</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">“IT consulting services are designed to help businesses
                                    optimize their technology strategies, streamline operations, and align IT solutions
                                    with their goal. Here are some key service offered under IT consulting Assisting
                                    with cloud migration.”</p>
                                <div class="testi-card-quote">
                                    <img src="{{ asset('') }}assets-landing-page/img/icon/testi-quote.svg"
                                        alt="img">
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-card">
                                <div class="testi-card_wrapper">
                                    <div class="testi-card_profile">
                                        <div class="testi-card_avater">
                                            <img src="{{ asset('') }}assets-landing-page/img/testimonial/testi_1_1.jpg"
                                                alt="testimonial">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="box-title">Alex Jordan</h3>
                                            <span class="testi-card_desig">App Developer</span>
                                        </div>
                                    </div>
                                    <div class="testi-card_review">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                </div>

                                <p class="testi-card_text">“IT consulting services are designed to help businesses
                                    optimize their technology strategies, streamline operations, and align IT solutions
                                    with their goal. Here are some key service offered under IT consulting Assisting
                                    with cloud migration.”</p>
                                <div class="testi-card-quote">
                                    <img src="{{ asset('') }}assets-landing-page/img/icon/testi-quote.svg"
                                        alt="img">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="slider-pagination"></div>
                </div>
            </div>
        </div>
        <div class="shape-mockup th-line-shape d-none d-xl-block" data-bottom="-2%" data-right="0%">
            <span>
                <svg width="1920" height="775" viewBox="0 0 1920 775" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path class="line-1"
                        d="M1922 761.516C1883.55 789.861 1799.69 764.276 1695.5 665.5C1565.26 542.03 1214 420.5 1168.91 537.637C1110.92 688.314 1382.3 703.384 1301.08 462.69C1219.86 221.996 727.193 406.687 337.011 313.758C40.4869 243.135 -26.3152 31.5872 -14.781 1"
                        stroke="#F2F5FA" stroke-width="4" />
                </svg>
            </span>
        </div>
        <div class="shape-mockup movingX d-none d-xl-block" data-top="15%" data-left="5%">
            <img src="{{ asset('') }}assets-landing-page/img/shape/shape_7.png" alt="shape">
        </div>
    </section><!--==============================
    Brand Area
    ==============================-->
    <div class="brand-area overflow-hidden space-bottom">
        <div class="container th-container">
            <div class="swiper th-slider brandSlider1" id="brandSlider1"
                data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"3"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"5"},"1400":{"slidesPerView":"6"}}}'>
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="brand-box">
                            <a href="">
                                <img class="original"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
                                    alt="Brand Logo">
                                <img class="gray"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
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
                                <img class="gray"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_2.svg"
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
                                <img class="gray"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_3.svg"
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
                                <img class="gray"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_4.svg"
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
                                <img class="gray"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_5.svg"
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
                                <img class="gray"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_6.svg"
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
                                <img class="gray"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_7.svg"
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
                                <img class="gray"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
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
                                <img class="gray"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_4.svg"
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
                                <img class="gray"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_3.svg"
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
                                <img class="gray"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_2.svg"
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
                                <img class="gray"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
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
                                <img class="gray"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
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
                                <img class="gray"
                                    src="{{ asset('') }}assets-landing-page/img/brand/brand_1_1.svg"
                                    alt="Brand Logo">
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div><!--==============================
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

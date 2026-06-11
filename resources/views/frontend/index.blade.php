<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $websiteSettings->NamaPerusahaan }}</title>
    <meta name="author" content="Atek">
    <meta name="description" content="{{ $websiteSettings->TentangPerusahaan }}">
    <meta name="keywords" content="Atek - It Business and Consulting Service Html Template">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="57x57"
        href="{{ asset('') }}assets-landing-page/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60"
        href="{{ asset('') }}assets-landing-page/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72"
        href="{{ asset('') }}assets-landing-page/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76"
        href="{{ asset('') }}assets-landing-page/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114"
        href="{{ asset('') }}assets-landing-page/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120"
        href="{{ asset('') }}assets-landing-page/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144"
        href="{{ asset('') }}assets-landing-page/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152"
        href="{{ asset('') }}assets-landing-page/img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('') }}assets-landing-page/img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset('') }}assets-landing-page/img/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('') }}assets-landing-page/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96"
        href="{{ asset('') }}assets-landing-page/img/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('') }}assets-landing-page/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('') }}assets-landing-page/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage"
        content="{{ asset('') }}assets-landing-page/img/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('') }}assets-landing-page/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets-landing-page/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets-landing-page/css/magnific-popup.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets-landing-page/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('') }}assets-landing-page/css/style.css">
    @stack('fontend-css')

</head>

<body>
    <div class="slider-drag-cursor d-flex align-items-center justify-content-between">
        <span class="drag-icon-left"><img src="{{ asset('') }}assets-landing-page/img/icon/drag-arrow-left.svg"
                alt=""></span>
        DRAG
        <span class="drag-icon-right">
            <img src="{{ asset('') }}assets-landing-page/img/icon/drag-arrow-right.svg" alt="">
        </span>
    </div>
    <div class="sidemenu-wrapper sidemenu-info ">
        <div class="sidemenu-content">
            <button class="closeButton sideMenuCls">
                <i class="far fa-times"></i>
            </button>
            <div class="widget  ">
                <div class="th-widget-about">
                    <div class="about-logo">
                        <a href="index.html"><img src="{{ asset('') }}assets-landing-page/img/logo2.svg"
                                alt="Atek"></a>
                    </div>
                    <p class="about-text">Quick access to essential system features, including the dashboard for an
                        overview of operations, network settings for managing connectivity, system logs for tracking
                        activities.</p>
                    <div class="th-social">
                        <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                        <a href="https://www.whatsapp.com/"><i class="fab fa-whatsapp"></i></a>
                        <a href="https://instagram.com/"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="widget  ">
                <h3 class="widget_title">Recent Posts</h3>
                <div class="recent-post-wrap">
                    <div class="recent-post d-flex align-items-center">
                        <div class="media-img">
                            <a href="blog-details.html"><img
                                    src="{{ asset('') }}assets-landing-page/img/blog/recent-post-1-1.jpg"
                                    alt="Blog Image"></a>
                        </div>
                        <div class="media-body">
                            <div class="recent-post-meta">
                                <a href="blog.html"><i class="far fa-calendar"></i>24 Jun , 2025</a>
                            </div>
                            <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Where Vision
                                    Meets Concrete
                                    Reality</a></h4>
                        </div>
                    </div>
                    <div class="recent-post d-flex align-items-center">
                        <div class="media-img">
                            <a href="blog-details.html"><img
                                    src="{{ asset('') }}assets-landing-page/img/blog/recent-post-1-2.jpg"
                                    alt="Blog Image"></a>
                        </div>
                        <div class="media-body">
                            <div class="recent-post-meta">
                                <a href="blog.html"><i class="far fa-calendar"></i>22 Jun , 2025</a>
                            </div>
                            <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Raising the Bar
                                    in
                                    Construction.</a></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget  ">
                <h3 class="widget_title">Get In Touch</h3>
                <div class="th-widget-contact">
                    <div class="info-box_text">
                        <div class="icon">
                            <img src="{{ asset('') }}assets-landing-page/img/icon/phone.svg" alt="img">
                        </div>
                        <div class="details">
                            <p><a href="tel:+01234567890" class="info-box_link">+01 234 567 890</a></p>
                            <p><a href="tel:+09876543210" class="info-box_link">+09 876 543 210</a></p>
                        </div>
                    </div>
                    <div class="info-box_text">
                        <div class="icon">
                            <img src="{{ asset('') }}assets-landing-page/img/icon/envelope.svg" alt="img">
                        </div>
                        <div class="details">
                            <p><a href="mailto:mailinfo00@atek.com" class="info-box_link">mailinfo00@atek.com</a></p>
                            <p><a href="mailto:support24@atek.com" class="info-box_link">support24@atek.com</a></p>
                        </div>
                    </div>
                    <div class="info-box_text">
                        <div class="icon"><img
                                src="{{ asset('') }}assets-landing-page/img/icon/location-dot.svg"
                                alt="img"></div>
                        <div class="details">
                            <p>789 Inner Lane, Holy park, California, USA</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="popup-search-box">
        <button class="searchClose"><i class="fal fa-times"></i></button>
        <form action="#">
            <input type="text" placeholder="What are you looking for?">
            <button type="submit"><i class="fal fa-search"></i></button>
        </form>
    </div><!--==============================
    Mobile Menu
  ============================== -->
    <div class="th-menu-wrapper onepage-nav">
        <div class="th-menu-area text-center">
            <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo">
                <a href="index.html"><img src="{{ asset('') }}assets-landing-page/img/logo2.svg"
                        alt="Atek"></a>
            </div>
            <div class="th-mobile-menu">
                <ul>
                    <li class="menu-item-has-children mega-menu-wrap">
                        <a class="active" href="index.html">Home</a>

                        <ul class="sub-menu">
                            <li><a href="index.html">Home Consulting</a></li>
                            <li><a href="home-cloud.html">Home Cloud</a></li>
                            <li><a href="home-ai-machine.html">Home Ai-Machine</a></li>
                            <li><a href="home-startup.html">Home Startup</a></li>
                            <li><a href="home-cybersecurity.html">Home Cybersecurity</a></li>
                            <li><a href="home-sass.html">SaaS Business Product</a></li>
                            <li><a href="home-tech-support.html">Tech Support Services</a></li>
                            <li><a href="home-software-development.html">Home Software-Development</a></li>
                            <li><a href="home-app-development.html">Web & App Development</a></li>
                            <li><a href="home-it-solutions.html">Home It Solutions</a></li>
                            <li><a href="home-digital-transformation.html">Home Digital Transformation</a></li>
                            <li><a href="home-data-analytics.html">Home Data Analytics & Big</a></li>
                            <li><a href="home-blockchain-fintech.html">Home Blockchain & Fintech</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#">About Us</a>
                        <ul class="sub-menu">
                            <li><a href="about.html">About Us</a></li>
                            <li><a href="about2.html">About Us 2</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#">Pages</a>
                        <ul class="sub-menu">
                            <li class="menu-item-has-children">
                                <a href="#">Shop</a>
                                <ul class="sub-menu">
                                    <li><a href="shop.html">Shop</a></li>
                                    <li><a href="shop-details.html">Shop Details</a></li>
                                    <li><a href="cart.html">Cart Page</a></li>
                                    <li><a href="checkout.html">Checkout</a></li>
                                    <li><a href="wishlist.html">Wishlist</a></li>
                                </ul>
                            </li>
                            <li><a href="gallery.html">Gallery</a></li>
                            <li><a href="case-study.html">Case Study</a></li>
                            <li><a href="case-study-details.html">Case Study Details</a></li>
                            <li><a href="career.html">Career</a></li>
                            <li><a href="career-details.html">Career Details</a></li>
                            <li><a href="team-guide.html">Team</a></li>
                            <li><a href="team-guider-details.html">Team Details</a></li>
                            <li><a href="faq.html">Faq Page</a></li>
                            <li><a href="price.html">Price Package</a></li>
                            <li><a href="error.html">Error Page</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#">Our Services</a>
                        <ul class="sub-menu">
                            <li><a href="service.html">Services</a></li>
                            <li><a href="service-details.html">Service Details</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#">Projects</a>
                        <ul class="sub-menu">
                            <li><a href="project-grid.html">Project Grid</a></li>
                            <li><a href="project-details.html">Project Details</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="{{ route('frontend.news') }}">News</a>

                    </li>
                    <li class="menu-item-has-children">
                        <a href="{{ route('frontend.career') }}">Career</a>
                    </li>

                    <li class="menu-item-has-children">
                        <a href="contact.html">Contact us</a>
                        <ul class="sub-menu">
                            <li><a href="contact.html">Contact Us</a></li>
                            <li><a href="contact-2.html">Contact Us Two</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div><!--==============================
 Header Area
==============================-->
    <header class="th-header header-layout1">
        <div class="header-top">
            <div class="container th-container">
                <div class="row justify-content-center justify-content-xl-between align-items-center">
                    <div class="col-auto d-none d-md-block">
                        <div class="header-links">
                            <ul>
                                <li class="d-none d-xl-inline-block"><i
                                        class="fa-sharp fa-regular  fa-location-dot"></i>
                                    <span>{{ $websiteSettings->AlamatKantor ?? 'Alamat Belum Diatur' }}</span>
                                </li>
                                <li class="d-none d-xl-inline-block">
                                    {{-- <i class="fa-regular fa-clock"></i>
                                    <span>Sun to Friday: 8.00 am - 7.00 pm</span> --}}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="header-right style2">
                            <div class="currency-menu">
                                <i class="fa-light fa-circle-dollar"></i>
                                <select class="form-select nice-select">
                                    <option selected="">USD </option>
                                    <option>CNY</option>
                                    <option>EUR</option>
                                    <option>AUD</option>
                                </select>
                            </div>
                            <div class="header-links">
                                <ul>
                                    <li class="d-none d-md-inline-block"><a href="faq.html">FAQ</a></li>
                                    <li class="d-none d-md-inline-block"><a href="contact.html">Support</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrapper">
            <div class="menu-area">
                <div class="container th-container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="header-logo">
                                <a href="{{ url('/') }}">
                                    <img src="{{ asset('storage/' . $websiteSettings->PathLogo) }}"
                                        alt="{{ $websiteSettings->TentangPerusahaan }}"
                                        style="width: 180px; max-width: 100%;">
                                </a>

                            </div>
                        </div>
                        <div class="col-auto me-xxl-auto">
                            <nav class="main-menu d-none d-xl-inline-block">
                                <ul>
                                    <li class="menu-item-has-children mega-menu-wrap">
                                        <a class="active" href="index.html">Home</a>

                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">About Us</a>
                                        <ul class="sub-menu">
                                            <li><a href="about.html">About Us 1</a></li>
                                            <li><a href="about2.html">About Us 2</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Pages</a>
                                        <ul class="sub-menu">
                                            <li class="menu-item-has-children">
                                                <a href="#">Shop</a>
                                                <ul class="sub-menu">
                                                    <li><a href="shop.html">Shop</a></li>
                                                    <li><a href="shop-details.html">Shop Details</a></li>
                                                    <li><a href="cart.html">Cart Page</a></li>
                                                    <li><a href="checkout.html">Checkout</a></li>
                                                    <li><a href="wishlist.html">Wishlist</a></li>
                                                </ul>
                                            </li>
                                            <li><a href="gallery.html">Gallery</a></li>
                                            <li><a href="case-study.html">Case Study</a></li>
                                            <li><a href="case-study-details.html">Case Study Details</a></li>
                                            <li><a href="career.html">Career</a></li>
                                            <li><a href="career-details.html">Career Details</a></li>
                                            <li><a href="team-guide.html">Team</a></li>
                                            <li><a href="team-guider-details.html">Team Details</a></li>
                                            <li><a href="faq.html">Faq Page</a></li>
                                            <li><a href="price.html">Price Package</a></li>
                                            <li><a href="error.html">Error Page</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Our Services</a>
                                        <ul class="sub-menu">
                                            <li><a href="service.html">Services</a></li>
                                            <li><a href="service-details.html">Service Details</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">Projects</a>
                                        <ul class="sub-menu">
                                            <li><a href="project-grid.html">Project Grid</a></li>
                                            <li><a href="project-details.html">Project Details</a></li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="{{ route('frontend.news') }}">News</a>

                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="{{ route('frontend.career') }}">Carreer</a>
                                    </li>

                                    <li class="menu-item-has-children">
                                        <a href="contact.html">Contact us</a>
                                        <ul class="sub-menu">
                                            <li><a href="contact.html">Contact Us</a></li>
                                            <li><a href="contact-2.html">Contact Us Two</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                            <button type="button" class="th-menu-toggle d-block d-xl-none"><i
                                    class="far fa-bars"></i></button>
                        </div>
                        <div class="col-auto d-none d-xl-block">
                            <div class="header-button">
                                <button type="button" class="icon-btn searchBoxToggler">
                                    <img src="{{ asset('') }}assets-landing-page/img/icon/search.svg"
                                        alt="icon">
                                </button>
                                <a href="contact.html" class="th-btn th-icon">Get In Touch <i
                                        class="fa-light fa-arrow-right-long"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="logo-bg" data-mask-src="{{ asset('') }}assets-landing-page/img/logo_bg_mask.png">
                </div>
            </div>
        </div>
    </header>
    @yield('content-frontend')
    <footer class="footer-wrapper footer-layout1 black-bg space-top">
        <div class="widget-area">
            <div class="container">
                <div class="newsletter-area">
                    <div class="newsletter-top">
                        <div class="row gy-4 align-items-center">
                            <div class="col-lg-5">
                                <h2 class="newsletter-title text-white text-capitalize mb-0">get updated the latest
                                    newsletter</h2>
                            </div>
                            <div class="col-lg-7">
                                <form class="newsletter-form">
                                    <input class="form-control " type="email" placeholder="Enter Email"
                                        required="">
                                    <button type="submit" class="th-btn style3">Subscribe Now <img
                                            src="{{ asset('') }}assets-landing-page/img/icon/plane.svg"
                                            alt=""></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between">
                    <div class="col-md-6 col-xl-3">
                        <div class="widget footer-widget">
                            <div class="th-widget-about">
                                <div class="about-logo">
                                    <a href="index.html"><img
                                            src="{{ asset('') }}assets-landing-page/img/logo3.svg"
                                            alt="Atek"></a>
                                </div>
                                <p class="about-text">Rapidiously myocardinate cross-platform intellectual capital
                                    model. Appropriately create interactive infrastructures</p>
                                <div class="th-social">
                                    <a href="https://www.facebook.com/"><i class="fab fa-facebook-f"></i></a>
                                    <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                                    <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                                    <a href="https://www.whatsapp.com/"><i class="fab fa-whatsapp"></i></a>
                                    <a href="https://instagram.com/"><i class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">Useful Link</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">

                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="about.html">About us</a></li>
                                    <li><a href="service.html">Our Service</a></li>
                                    <li><a href="contact.html">Terms of Service</a></li>
                                    <li><a href="service.html">News & Media</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <h3 class="widget_title">Get In Touch</h3>
                            <div class="th-widget-contact">
                                <div class="info-box_text">
                                    <div class="icon">
                                        <img src="{{ asset('') }}assets-landing-page/img/icon/phone.svg"
                                            alt="img">
                                    </div>
                                    <div class="details">
                                        <p><a href="tel:+01234567890" class="info-box_link">+01 234 567 890</a></p>
                                        <p><a href="tel:+09876543210" class="info-box_link">+09 876 543 210</a></p>
                                    </div>
                                </div>
                                <div class="info-box_text">
                                    <div class="icon">
                                        <img src="{{ asset('') }}assets-landing-page/img/icon/envelope.svg"
                                            alt="img">
                                    </div>
                                    <div class="details">
                                        <p><a href="mailto:mailinfo00@atek.com"
                                                class="info-box_link">mailinfo00@atek.com</a></p>
                                        <p><a href="mailto:support24@atek.com"
                                                class="info-box_link">support24@atek.com</a></p>
                                    </div>
                                </div>
                                <div class="info-box_text">
                                    <div class="icon"><img
                                            src="{{ asset('') }}assets-landing-page/img/icon/location-dot.svg"
                                            alt="img"></div>
                                    <div class="details">
                                        <p><a href="https://maps.app.goo.gl/QyH2fFoJ9fii93mt7" target="_blank">789
                                                Inner Lane, Holy park, California, USA</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-auto">
                        <div class="widget footer-widget">
                            <h3 class="widget_title">Instagram Post</h3>
                            <div class="sidebar-gallery">
                                <div class="gallery-thumb">
                                    <img src="{{ asset('') }}assets-landing-page/img/widget/gallery_1_1.jpg"
                                        alt="Gallery Image">
                                    <a target="_blank" href="https://www.instagram.com/" class="gallery-btn"><i
                                            class="fab fa-instagram"></i></a>
                                </div>
                                <div class="gallery-thumb">
                                    <img src="{{ asset('') }}assets-landing-page/img/widget/gallery_1_2.jpg"
                                        alt="Gallery Image">
                                    <a target="_blank" href="https://www.instagram.com/" class="gallery-btn"><i
                                            class="fab fa-instagram"></i></a>
                                </div>
                                <div class="gallery-thumb">
                                    <img src="{{ asset('') }}assets-landing-page/img/widget/gallery_1_3.jpg"
                                        alt="Gallery Image">
                                    <a target="_blank" href="https://www.instagram.com/" class="gallery-btn"><i
                                            class="fab fa-instagram"></i></a>
                                </div>
                                <div class="gallery-thumb">
                                    <img src="{{ asset('') }}assets-landing-page/img/widget/gallery_1_4.jpg"
                                        alt="Gallery Image">
                                    <a target="_blank" href="https://www.instagram.com/" class="gallery-btn"><i
                                            class="fab fa-instagram"></i></a>
                                </div>
                                <div class="gallery-thumb">
                                    <img src="{{ asset('') }}assets-landing-page/img/widget/gallery_1_5.jpg"
                                        alt="Gallery Image">
                                    <a target="_blank" href="https://www.instagram.com/" class="gallery-btn"><i
                                            class="fab fa-instagram"></i></a>
                                </div>
                                <div class="gallery-thumb">
                                    <img src="{{ asset('') }}assets-landing-page/img/widget/gallery_1_6.jpg"
                                        alt="Gallery Image">
                                    <a target="_blank" href="https://www.instagram.com/" class="gallery-btn"><i
                                            class="fab fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-wrap">
            <div class="container">
                <div class="row justify-content-lg-between align-items-center">
                    <div class="col-lg-6">
                        <p class="copyright-text">Copyright © 2025 <a href="index.html">Atek</a>. All Rights
                            Reserved.</p>
                    </div>
                    <div class="col-lg-6 text-center text-lg-end">
                        <div class="footer-links">
                            <ul>
                                <li><a href="about.html">Terms & Conditions</a></li>
                                <li><a href="about.html">Careers</a></li>
                                <li><a href="about.html">Privacy Policy</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </footer>

    <!--********************************
   Code End  Here
 ******************************** -->

    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
            </path>
        </svg>
    </div>
    <!--==============================
    All Js File
============================== -->
    <!-- Jquery -->
    <script src="{{ asset('') }}assets-landing-page/js/vendor/jquery-3.7.1.min.js"></script>
    <!-- Swiper Js -->
    <script src="{{ asset('') }}assets-landing-page/js/swiper-bundle.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('') }}assets-landing-page/js/bootstrap.min.js"></script>
    <!-- Magnific Popup -->
    <script src="{{ asset('') }}assets-landing-page/js/jquery.magnific-popup.min.js"></script>
    <!-- Counter Up -->
    <script src="{{ asset('') }}assets-landing-page/js/jquery.counterup.min.js"></script>
    <!-- circle-progress -->
    <script src="{{ asset('') }}assets-landing-page/js/circle-progress.js"></script>
    <!-- Range Slider -->
    <script src="{{ asset('') }}assets-landing-page/js/jquery-ui.min.js"></script>
    <!-- imagesloaded -->
    <script src="{{ asset('') }}assets-landing-page/js/imagesloaded.pkgd.min.js"></script>
    <!-- isotope -->
    <script src="{{ asset('') }}assets-landing-page/js/isotope.pkgd.min.js"></script>

    <!-- nice select -->
    <script src="{{ asset('') }}assets-landing-page/js/nice-select.min.js"></script>
    <!-- wow -->
    <script src="{{ asset('') }}assets-landing-page/js/wow.min.js"></script>
    <!-- gsap -->
    <script src="{{ asset('') }}assets-landing-page/js/gsap.min.js"></script>
    <script src="{{ asset('') }}assets-landing-page/js/ScrollTrigger.min.js"></script>
    <script src="{{ asset('') }}assets-landing-page/js/SplitText.js"></script>
    <!-- Scroll Trigger -->
    <script src="{{ asset('') }}assets-landing-page/js/ScrollTrigger.min.js"></script>
    <!-- Lenis Smooth Scroll -->
    <script src="{{ asset('') }}assets-landing-page/js/lenis.min.js"></script>



    <!-- Main Js File -->
    <script src="{{ asset('') }}assets-landing-page/js/main.js"></script>
    @stack('frontend-js')
</body>

</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jasuindo - Transformasi Digital Identitas & Pembayaran Nasional</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
    <style>
        /* Navbar scroll effect */
        .navbar-scrolled {
            background-color: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        /* Navbar transparent on hero */
        .navbar-transparent {
            background-color: transparent;
            box-shadow: none;
        }

        .navbar-transparent .nav-link { color: white; }
        .navbar-transparent .logo-text { color: white; }
        .navbar-transparent .nav-icon { color: white; }
        .navbar-transparent .mobile-btn { color: white; }

        /* Solution card hover */
        .solution-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .solution-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Smooth scroll offset for fixed navbar */
        section[id] {
            scroll-margin-top: 80px;
        }
    </style>
</head>

<body class="font-sans text-slate-600 antialiased bg-white">
    @php
        $menus = \App\Models\Menu::menuHeader()->with('children')->get();
    @endphp

    <!-- ========================================== -->
    <!-- NAVIGATION MENU -->
    <!-- ========================================== -->
    <nav id="main-navbar" class="navbar-transparent fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-2">
                        @if (!empty($websiteSettings) && !empty($websiteSettings->PathLogo))
                            <img src="{{ asset('storage/' . $websiteSettings->PathLogo) }}"
                                alt="{{ $websiteSettings->NamaPerusahaan ?? __('Logo') }}" width="180" height="64"
                                style="object-fit: contain;">
                        @else
                            <svg width="64" height="64" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 20L12 12L19 20L26 12L33 20" stroke="#0284c7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5 28L12 20L19 28" stroke="#0ea5e9" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @endif
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-6">
                    @foreach ($menus as $menu)
                        @php
                            $hasChildren = $menu->children->count() > 0;
                            $isActive = request()->is(ltrim(parse_url($menu->Link, PHP_URL_PATH) ?? '', '/'));
                        @endphp

                        @if ($hasChildren)
                            <div class="relative group">
                                <a href="{{ $menu->Link !== '#' ? $menu->Link : 'javascript:void(0)' }}"
                                    target="{{ $menu->Target ?? '_self' }}"
                                    class="nav-link flex items-center space-x-1 {{ $isActive ? 'text-brand-400' : 'text-white hover:text-brand-500' }} font-medium transition-colors duration-200 py-2">
                                    @if ($menu->Icon) <i class="{{ $menu->Icon }}"></i> @endif
                                    <span>{{ $menu->NamaMenu }}</span>
                                    <i class="fa-solid fa-chevron-down text-xs ml-1 transition-transform duration-200 group-hover:rotate-180"></i>
                                </a>

                                <div class="absolute top-full left-1/2 -translate-x-1/2 pt-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                    <div class="bg-white rounded-xl shadow-2xl border border-slate-100 py-3 min-w-[240px] overflow-hidden">
                                        <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-4 h-4 bg-white border-l border-t border-slate-100 transform rotate-45"></div>
                                        @foreach ($menu->children as $child)
                                            @php
                                                $isChildActive = request()->is(ltrim(parse_url($child->Link, PHP_URL_PATH) ?? '', '/'));
                                            @endphp
                                            <a href="{{ $child->Link }}" target="{{ $child->Target ?? '_self' }}"
                                                class="flex items-center px-5 py-3 text-sm text-slate-700 hover:bg-brand-50 hover:text-brand-600 transition-colors duration-200 {{ $isChildActive ? 'bg-brand-50 text-brand-600 font-semibold' : '' }}">
                                                @if ($child->Icon)
                                                    <i class="{{ $child->Icon }} w-5 mr-3 text-brand-500"></i>
                                                @else
                                                    <i class="fa-solid fa-angle-right w-5 mr-3 text-brand-500"></i>
                                                @endif
                                                <span>{{ $child->NamaMenu }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ $menu->Link }}" target="{{ $menu->Target ?? '_self' }}"
                                class="nav-link {{ $isActive ? 'text-brand-400' : 'text-white hover:text-brand-500' }} font-medium transition-colors duration-200 py-2">
                                @if ($menu->Icon) <i class="{{ $menu->Icon }} mr-1"></i> @endif
                                {{ $menu->NamaMenu }}
                            </a>
                        @endif
                    @endforeach
                </div>

                <!-- Right Side Actions -->
                <div class="hidden lg:flex items-center space-x-4">
                    <button class="nav-icon text-white hover:text-brand-500 transition-colors duration-200 p-2">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>

                    <div class="relative group">
                        <button class="nav-icon flex items-center space-x-1 hover:text-brand-500 transition-colors duration-200 py-2 text-white">
                            @if (app()->getLocale() == 'id')
                                <img src="https://flagcdn.com/w20/id.png" alt="Indonesia" class="w-5 h-auto rounded-sm">
                                <span class="font-medium text-sm">ID</span>
                            @else
                                <img src="https://flagcdn.com/w20/gb.png" alt="English" class="w-5 h-auto rounded-sm">
                                <span class="font-medium text-sm">EN</span>
                            @endif
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </button>

                        <div class="absolute top-full right-0 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div class="bg-white rounded-xl shadow-xl border border-slate-100 py-2 min-w-[160px] overflow-hidden">
                                <a href="?lang=id" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-brand-50 hover:text-brand-600 transition-colors {{ app()->getLocale() == 'id' ? 'bg-brand-50 text-brand-600 font-semibold' : '' }}">
                                    <img src="https://flagcdn.com/w20/id.png" class="w-5 h-auto rounded-sm mr-2">
                                    {{ __('Bahasa Indonesia') }}
                                </a>
                                <a href="?lang=en" class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-brand-50 hover:text-brand-600 transition-colors {{ app()->getLocale() == 'en' ? 'bg-brand-50 text-brand-600 font-semibold' : '' }}">
                                    <img src="https://flagcdn.com/w20/gb.png" class="w-5 h-auto rounded-sm mr-2">
                                    {{ __('English') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="#kontak" class="bg-brand-600 hover:bg-brand-700 text-white px-6 py-2.5 rounded-full font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                        {{ __('Contact Us') }}
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden flex items-center space-x-2">
                    <button class="mobile-btn text-white hover:text-brand-500 transition-colors duration-200 p-2">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>
                    <button id="mobile-menu-btn" class="mobile-btn text-white hover:text-brand-500 focus:outline-none p-2">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div id="mobile-menu" class="lg:hidden hidden bg-white border-t border-gray-100 shadow-lg max-h-[calc(100vh-5rem)] overflow-y-auto">
            <div class="container mx-auto px-4 py-4 space-y-1">
                @foreach ($menus as $menu)
                    @php
                        $hasChildren = $menu->children->count() > 0;
                        $isActive = request()->is(ltrim(parse_url($menu->Link, PHP_URL_PATH) ?? '', '/'));
                    @endphp

                    @if ($hasChildren)
                        <div class="mobile-dropdown">
                            <button class="mobile-dropdown-btn w-full flex items-center justify-between px-4 py-3 text-slate-700 hover:bg-brand-50 hover:text-brand-600 rounded-lg font-medium transition-colors {{ $isActive ? 'bg-brand-50 text-brand-600' : '' }}">
                                <span class="flex items-center">
                                    @if ($menu->Icon) <i class="{{ $menu->Icon }} mr-2"></i> @endif
                                    {{ $menu->NamaMenu }}
                                </span>
                                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
                            </button>
                            <div class="mobile-dropdown-content hidden pl-6 space-y-1 mt-1 border-l-2 border-brand-100 ml-4">
                                @foreach ($menu->children as $child)
                                    @php
                                        $isChildActive = request()->is(ltrim(parse_url($child->Link, PHP_URL_PATH) ?? '', '/'));
                                    @endphp
                                    <a href="{{ $child->Link }}" target="{{ $child->Target ?? '_self' }}"
                                        class="mobile-link flex items-center px-4 py-2.5 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-600 rounded-lg transition-colors {{ $isChildActive ? 'bg-brand-50 text-brand-600 font-semibold' : '' }}">
                                        @if ($child->Icon) <i class="{{ $child->Icon }} mr-2 text-brand-500"></i> @else <i class="fa-solid fa-angle-right mr-2 text-brand-500"></i> @endif
                                        {{ $child->NamaMenu }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a href="{{ $menu->Link }}" target="{{ $menu->Target ?? '_self' }}"
                            class="mobile-link flex items-center px-4 py-3 text-slate-700 hover:bg-brand-50 hover:text-brand-600 rounded-lg font-medium transition-colors {{ $isActive ? 'bg-brand-50 text-brand-600' : '' }}">
                            @if ($menu->Icon) <i class="{{ $menu->Icon }} mr-2"></i> @endif
                            {{ $menu->NamaMenu }}
                        </a>
                    @endif
                @endforeach

                <div class="border-t border-gray-200 pt-4 mt-4 space-y-2">
                    <button class="w-full flex items-center justify-center space-x-2 px-4 py-3 text-slate-700 hover:bg-brand-50 rounded-lg transition-colors">
                        <img src="https://flagcdn.com/w20/id.png" alt="Indonesia" class="w-5 h-auto rounded-sm">
                        <span class="font-medium">{{ __('Bahasa Indonesia') }}</span>
                    </button>
                    <a href="#kontak" class="block w-full text-center bg-brand-600 hover:bg-brand-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        {{ __('Contact Us') }}
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ========================================== -->
    <!-- CONTENT SECTION -->
    <!-- ========================================== -->
    @yield('content-frontend')

    <!-- ========================================== -->
    <!-- FOOTER -->
    <!-- ========================================== -->
    <footer class="bg-brand-950 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12">

                <!-- Logo & Description -->
                <div class="lg:col-span-3">
                    <div class="mb-4">
                        @if (!empty($websiteSettings) && !empty($websiteSettings->PathLogo))
                            <img src="{{ asset('storage/' . $websiteSettings->PathLogo) }}"
                                alt="{{ $websiteSettings->NamaPerusahaan ?? __('Logo') }}"
                                class="h-10 w-auto object-contain" style="filter: brightness(0) invert(1);">
                        @else
                            <div class="flex items-center space-x-2">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 20L12 12L19 20L26 12L33 20" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M5 28L12 20L19 28" stroke="#0ea5e9" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="text-2xl font-bold">JASUINDO</span>
                            </div>
                        @endif
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        {{ $websiteSettings->DeskripsiSingkat ?? __('The Fastest Growing Identity & Payment Company in Asia') }}
                    </p>
                    <div class="flex space-x-3">
                        @if (!empty($websiteSettings->SosialFacebook))
                            <a href="{{ $websiteSettings->SosialFacebook }}" target="_blank" class="w-8 h-8 bg-brand-900 hover:bg-brand-800 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-facebook-f text-sm"></i>
                            </a>
                        @endif
                        @if (!empty($websiteSettings->SosialInstagram))
                            <a href="{{ $websiteSettings->SosialInstagram }}" target="_blank" class="w-8 h-8 bg-brand-900 hover:bg-brand-800 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-instagram text-sm"></i>
                            </a>
                        @endif
                        @if (!empty($websiteSettings->SosialLinkedIn))
                            <a href="{{ $websiteSettings->SosialLinkedIn }}" target="_blank" class="w-8 h-8 bg-brand-900 hover:bg-brand-800 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-linkedin-in text-sm"></i>
                            </a>
                        @endif
                        @if (!empty($websiteSettings->SosialYoutube))
                            <a href="{{ $websiteSettings->SosialYoutube }}" target="_blank" class="w-8 h-8 bg-brand-900 hover:bg-brand-800 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-youtube text-sm"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Company Links -->
                <div class="lg:col-span-2">
                    <h3 class="text-base font-bold mb-4">{{ __('Company') }}</h3>
                    <ul class="space-y-2.5">
                        <li><a href="{{ url('about') }}" class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('About Us') }}</a></li>
                        <li><a href="{{ url('career') }}" class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('Career') }}</a></li>
                        <li><a href="{{ url('news') }}" class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('News') }}</a></li>
                        <li><a href="{{ url('contact') }}" class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('Contact Us') }}</a></li>
                    </ul>
                </div>

                <!-- Solutions Links -->
                <div class="lg:col-span-2">
                    <h3 class="text-base font-bold mb-4">{{ __('Solutions') }}</h3>
                    <ul class="space-y-2.5">
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('Identity') }}</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('Payment') }}</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('Brand Protection') }}</a></li>
                        <li><a href="#" class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('Commercial Printing') }}</a></li>
                    </ul>
                </div>

                <!-- Head Office -->
                <div class="lg:col-span-5">
                    <h3 class="text-base font-bold mb-4">{{ __('Head Office') }}</h3>
                    <div class="space-y-3 text-slate-400 text-sm">
                        <div>
                            <p class="mb-1">Jalan Raya Betro Nomor 21,<br>Sedati, Sidoarjo, Surabaya 61253 Indonesia</p>
                            <p class="text-slate-500">{{ __('Phone') }} +62 31 8910919 (Hunting)</p>
                        </div>
                        <div class="pt-2 border-t border-slate-800">
                            <p class="mb-1">Jalan Raya Lingkar Timur Km 1,<br>Desa Banjarsari, Buduran, Sidoarjo<br>Surabaya 61252 Indonesia</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-slate-800 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-slate-500 text-xs">
                        © {{ date('Y') }} PT Jasuindo Tiga Perkasa Tbk. {{ __('All rights reserved') }}
                    </p>
                    <div class="flex space-x-6 text-xs">
                        <a href="#" class="text-slate-500 hover:text-white transition-colors">{{ __('Terms & Conditions') }}</a>
                        <a href="#" class="text-slate-500 hover:text-white transition-colors">{{ __('Privacy Policy') }}</a>
                        <a href="#" class="text-slate-500 hover:text-white transition-colors">{{ __('Cookies') }}</a>
                        <a href="#" class="text-slate-500 hover:text-white transition-colors">{{ __('Sitemap') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- ========================================== -->
    <!-- SCRIPTS -->
    <!-- ========================================== -->
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const mobileLinks = document.querySelectorAll('.mobile-link');

        mobileMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileMenu.classList.toggle('hidden');
            const icon = mobileMenuBtn.querySelector('i');
            if (mobileMenu.classList.contains('hidden')) {
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            } else {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
            }
        });

        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                const icon = mobileMenuBtn.querySelector('i');
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            });
        });

        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                const icon = mobileMenuBtn.querySelector('i');
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            }
        });

        // Navbar scroll effect
        const navbar = document.getElementById('main-navbar');
        const heroSection = document.getElementById('home');

        function handleScroll() {
            const scrollY = window.scrollY;
            const threshold = heroSection ? heroSection.offsetHeight : 100;

            if (scrollY > threshold) {
                navbar.classList.remove('navbar-transparent');
                navbar.classList.add('navbar-scrolled');
                document.querySelectorAll('.mobile-btn').forEach(btn => {
                    btn.classList.remove('text-white');
                    btn.classList.add('text-slate-700');
                });
            } else {
                navbar.classList.add('navbar-transparent');
                navbar.classList.remove('navbar-scrolled');
                document.querySelectorAll('.mobile-btn').forEach(btn => {
                    btn.classList.add('text-white');
                    btn.classList.remove('text-slate-700');
                });
            }
        }

        window.addEventListener('scroll', handleScroll);
        handleScroll();
    </script>

    <!-- Custom Config for Brand Colors -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#f0f9ff', 100: '#e0f2fe', 400: '#38bdf8', 500: '#0ea5e9',
                            600: '#0284c7', 700: '#0369a1', 800: '#075985', 900: '#0c4a6e', 950: '#082f49',
                        }
                    },
                    animation: {
                        'marquee': 'marquee 30s linear infinite',
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                    },
                    keyframes: {
                        marquee: { '0%': { transform: 'translateX(0%)' }, '100%': { transform: 'translateX(-50%)' } },
                        fadeInUp: { '0%': { opacity: '0', transform: 'translateY(20px)' }, '100%': { opacity: '1', transform: 'translateY(0)' } }
                    }
                }
            }
        }
    </script>
</body>
</html>

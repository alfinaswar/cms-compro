<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

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

    <!-- Custom Config for Brand Colors -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                            950: '#082f49',
                        }
                    },
                    animation: {
                        'marquee': 'marquee 30s linear infinite',
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                    },
                    keyframes: {
                        marquee: {
                            '0%': {
                                transform: 'translateX(0%)'
                            },
                            '100%': {
                                transform: 'translateX(-50%)'
                            },
                        },
                        fadeInUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        }
                    }
                }
            }
        }
    </script>

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

        .navbar-transparent .nav-link {
            color: white;
        }

        .navbar-transparent .logo-text {
            color: white;
        }

        .navbar-transparent .nav-icon {
            color: white;
        }

        .navbar-transparent .mobile-btn {
            color: white;
        }

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
                                alt="{{ $websiteSettings->NamaPerusahaan ?? 'Logo' }}" width="180" height="64"
                                style="object-fit: contain;">
                        @else
                            <svg width="64" height="64" viewBox="0 0 40 40" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 20L12 12L19 20L26 12L33 20" stroke="#0284c7" stroke-width="3"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5 28L12 20L19 28" stroke="#0ea5e9" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round" />
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
                            <!-- Menu with Dropdown -->
                            <div class="relative group">
                                <a href="{{ $menu->Link !== '#' ? $menu->Link : 'javascript:void(0)' }}"
                                    target="{{ $menu->Target ?? '_self' }}"
                                    class="nav-link flex items-center space-x-1 {{ $isActive ? 'text-brand-400' : 'text-white hover:text-brand-500' }} font-medium transition-colors duration-200 py-2">
                                    @if ($menu->Icon)
                                        <i class="{{ $menu->Icon }}"></i>
                                    @endif
                                    <span>{{ $menu->NamaMenu }}</span>
                                    <i
                                        class="fa-solid fa-chevron-down text-xs ml-1 transition-transform duration-200 group-hover:rotate-180"></i>
                                </a>

                                <!-- Dropdown Panel -->
                                <div
                                    class="absolute top-full left-1/2 -translate-x-1/2 pt-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                    <div
                                        class="bg-white rounded-xl shadow-2xl border border-slate-100 py-3 min-w-[240px] overflow-hidden">
                                        <!-- Arrow pointer -->
                                        <div
                                            class="absolute -top-2 left-1/2 -translate-x-1/2 w-4 h-4 bg-white border-l border-t border-slate-100 transform rotate-45">
                                        </div>

                                        @foreach ($menu->children as $child)
                                            @php
                                                $isChildActive = request()->is(
                                                    ltrim(parse_url($child->Link, PHP_URL_PATH) ?? '', '/'),
                                                );
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
                            <!-- Simple Menu Link -->
                            <a href="{{ $menu->Link }}" target="{{ $menu->Target ?? '_self' }}"
                                class="nav-link {{ $isActive ? 'text-brand-400' : 'text-white hover:text-brand-500' }} font-medium transition-colors duration-200 py-2">
                                @if ($menu->Icon)
                                    <i class="{{ $menu->Icon }} mr-1"></i>
                                @endif
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
                    <button
                        class="nav-icon flex items-center space-x-1 text-white hover:text-brand-500 transition-colors duration-200">
                        <img src="https://flagcdn.com/w20/id.png" alt="Indonesia" class="w-5 h-auto rounded-sm">
                        <span class="font-medium text-sm">ID</span>
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>
                    <a href="#kontak"
                        class="bg-brand-600 hover:bg-brand-700 text-white px-6 py-2.5 rounded-full font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                        Contact Us
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden flex items-center space-x-2">
                    <button class="mobile-btn text-white hover:text-brand-500 transition-colors duration-200 p-2">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>
                    <button id="mobile-menu-btn"
                        class="mobile-btn text-white hover:text-brand-500 focus:outline-none p-2">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div id="mobile-menu"
            class="lg:hidden hidden bg-white border-t border-gray-100 shadow-lg max-h-[calc(100vh-5rem)] overflow-y-auto">
            <div class="container mx-auto px-4 py-4 space-y-1">
                @foreach ($menus as $menu)
                    @php
                        $hasChildren = $menu->children->count() > 0;
                        $isActive = request()->is(ltrim(parse_url($menu->Link, PHP_URL_PATH) ?? '', '/'));
                    @endphp

                    @if ($hasChildren)
                        <!-- Mobile Menu with Accordion -->
                        <div class="mobile-dropdown">
                            <button
                                class="mobile-dropdown-btn w-full flex items-center justify-between px-4 py-3 text-slate-700 hover:bg-brand-50 hover:text-brand-600 rounded-lg font-medium transition-colors {{ $isActive ? 'bg-brand-50 text-brand-600' : '' }}">
                                <span class="flex items-center">
                                    @if ($menu->Icon)
                                        <i class="{{ $menu->Icon }} mr-2"></i>
                                    @endif
                                    {{ $menu->NamaMenu }}
                                </span>
                                <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
                            </button>
                            <div
                                class="mobile-dropdown-content hidden pl-6 space-y-1 mt-1 border-l-2 border-brand-100 ml-4">
                                @foreach ($menu->children as $child)
                                    @php
                                        $isChildActive = request()->is(
                                            ltrim(parse_url($child->Link, PHP_URL_PATH) ?? '', '/'),
                                        );
                                    @endphp
                                    <a href="{{ $child->Link }}" target="{{ $child->Target ?? '_self' }}"
                                        class="mobile-link flex items-center px-4 py-2.5 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-600 rounded-lg transition-colors {{ $isChildActive ? 'bg-brand-50 text-brand-600 font-semibold' : '' }}">
                                        @if ($child->Icon)
                                            <i class="{{ $child->Icon }} mr-2 text-brand-500"></i>
                                        @else
                                            <i class="fa-solid fa-angle-right mr-2 text-brand-500"></i>
                                        @endif
                                        {{ $child->NamaMenu }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- Simple Mobile Link -->
                        <a href="{{ $menu->Link }}" target="{{ $menu->Target ?? '_self' }}"
                            class="mobile-link flex items-center px-4 py-3 text-slate-700 hover:bg-brand-50 hover:text-brand-600 rounded-lg font-medium transition-colors {{ $isActive ? 'bg-brand-50 text-brand-600' : '' }}">
                            @if ($menu->Icon)
                                <i class="{{ $menu->Icon }} mr-2"></i>
                            @endif
                            {{ $menu->NamaMenu }}
                        </a>
                    @endif
                @endforeach

                <div class="border-t border-gray-200 pt-4 mt-4 space-y-2">
                    <button
                        class="w-full flex items-center justify-center space-x-2 px-4 py-3 text-slate-700 hover:bg-brand-50 rounded-lg transition-colors">
                        <img src="https://flagcdn.com/w20/id.png" alt="Indonesia" class="w-5 h-auto rounded-sm">
                        <span class="font-medium">Bahasa Indonesia</span>
                    </button>
                    <a href="#kontak"
                        class="block w-full text-center bg-brand-600 hover:bg-brand-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Custom Styles for Navbar -->
    <style>
        /* Navbar transparent state */
        .navbar-transparent {
            background-color: transparent;
        }

        .navbar-transparent .logo-text {
            color: white !important;
        }

        .navbar-transparent .nav-link {
            color: white;
        }

        .navbar-transparent .mobile-btn {
            color: white;
        }

        /* Navbar scrolled state */
        .navbar-scrolled {
            background-color: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .navbar-scrolled .logo-text {
            color: #082f49 !important;
        }

        .navbar-scrolled .nav-link {
            color: #334155;
        }

        .navbar-scrolled .nav-link:hover {
            color: #0ea5e9;
        }

        .navbar-scrolled .mobile-btn {
            color: #334155;
        }

        .navbar-scrolled .nav-icon {
            color: #334155;
        }

        .navbar-scrolled .nav-icon:hover {
            color: #0ea5e9;
        }

        /* Dropdown hover effect */
        .group:hover .group-hover\:rotate-180 {
            transform: rotate(180deg);
        }
    </style>

    <!-- Scripts -->
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

        // Mobile Dropdown Accordion
        document.querySelectorAll('.mobile-dropdown-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const content = btn.nextElementSibling;
                const icon = btn.querySelector('.fa-chevron-down');

                // Toggle current
                content.classList.toggle('hidden');
                icon.style.transform = content.classList.contains('hidden') ? 'rotate(0deg)' :
                    'rotate(180deg)';

                // Close other dropdowns (optional - accordion behavior)
                document.querySelectorAll('.mobile-dropdown-btn').forEach(otherBtn => {
                    if (otherBtn !== btn) {
                        const otherContent = otherBtn.nextElementSibling;
                        const otherIcon = otherBtn.querySelector('.fa-chevron-down');
                        if (!otherContent.classList.contains('hidden')) {
                            otherContent.classList.add('hidden');
                            otherIcon.style.transform = 'rotate(0deg)';
                        }
                    }
                });
            });
        });

        // Close mobile menu when clicking a link
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                const icon = mobileMenuBtn.querySelector('i');
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            });
        });

        // Close mobile menu when clicking outside
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

            if (scrollY > 100) {
                navbar.classList.remove('navbar-transparent');
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.add('navbar-transparent');
                navbar.classList.remove('navbar-scrolled');
            }
        }

        window.addEventListener('scroll', handleScroll);
        handleScroll();
    </script>

    <!-- ========================================== -->
    <!-- 1. HERO SECTION -->
    <!-- ========================================== -->
    @yield('content-frontend')

    <!-- ========================================== -->
    <!-- FOOTER -->
    <!-- ========================================== -->
    <footer class="bg-brand-950 text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12">

                <!-- Surabaya Office -->
                <div class="lg:col-span-3">
                    <h3 class="text-lg font-bold mb-4 text-white">Surabaya Office</h3>
                    <div class="space-y-3 text-slate-300 text-sm leading-relaxed">
                        <p>Jalan Raya Betro No. 21,<br>Sedati - Sidoarjo 61253<br>Indonesia</p>
                        <p class="pt-2"><i class="fa-solid fa-phone text-brand-500 mr-2"></i>+62 31 8910919
                            (Hunting)</p>
                        <div class="border-t border-slate-700 pt-3 mt-3">
                            <p>Jalan Raya Lingkar Timur Km 1,<br>Desa Banjarsari, Buduran,<br>Sidoarjo 61252 - Indonesia
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Jakarta Office -->
                <div class="lg:col-span-3">
                    <h3 class="text-lg font-bold mb-4 text-white">Jakarta Office</h3>
                    <div class="space-y-3 text-slate-300 text-sm leading-relaxed">
                        <p>Office 8 Building, Floor 31st<br>Unit B-E, SCBD Lot. 28<br>Jalan Jenderal Sudirman Kav.
                            52-53<br>(Jalan Senopati Raya 8B)<br>Jakarta Selatan 12190<br>Indonesia</p>
                        <p class="pt-2"><i class="fa-solid fa-phone text-brand-500 mr-2"></i>+62 21 293 33101
                            (Hunting)</p>
                    </div>
                </div>

                <!-- Company Links -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-bold mb-4 text-white">Company</h3>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="text-slate-300 hover:text-white transition-colors duration-200 text-sm">Contact
                                Us</a></li>
                        <li><a href="#"
                                class="text-slate-300 hover:text-white transition-colors duration-200 text-sm">Careers</a>
                        </li>
                        <li><a href="#"
                                class="text-slate-300 hover:text-white transition-colors duration-200 text-sm">News</a>
                        </li>
                        <li><a href="#"
                                class="text-slate-300 hover:text-white transition-colors duration-200 text-sm">Investor
                                Relations</a></li>
                    </ul>
                </div>

                <!-- Solutions Links -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-bold mb-4 text-white">Solutions</h3>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="text-slate-300 hover:text-white transition-colors duration-200 text-sm">Identity</a>
                        </li>
                        <li><a href="#"
                                class="text-slate-300 hover:text-white transition-colors duration-200 text-sm">Payment</a>
                        </li>
                        <li><a href="#"
                                class="text-slate-300 hover:text-white transition-colors duration-200 text-sm">Brand
                                Protection</a></li>
                        <li><a href="#"
                                class="text-slate-300 hover:text-white transition-colors duration-200 text-sm">Commercial
                                Printing</a></li>
                    </ul>
                </div>

                <!-- Support Links -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-bold mb-4 text-white">Support</h3>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="text-slate-300 hover:text-white transition-colors duration-200 text-sm">Terms &
                                Conditions</a></li>
                        <li><a href="#"
                                class="text-slate-300 hover:text-white transition-colors duration-200 text-sm">Privacy
                                Policy</a></li>
                        <li><a href="#"
                                class="text-slate-300 hover:text-white transition-colors duration-200 text-sm">Cookies</a>
                        </li>
                        <li><a href="#"
                                class="text-slate-300 hover:text-white transition-colors duration-200 text-sm">Sitemap</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-slate-700 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    @if (!empty($websiteSettings) && !empty($websiteSettings->PathLogo))
                        <img src="{{ asset('storage/' . $websiteSettings->PathLogo) }}"
                            alt="{{ $websiteSettings->NamaPerusahaan ?? 'Logo' }}" width="180" height="64"
                            style="object-fit: contain;">
                    @else
                        <svg width="64" height="64" viewBox="0 0 40 40" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 20L12 12L19 20L26 12L33 20" stroke="#0284c7" stroke-width="3"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5 28L12 20L19 28" stroke="#0ea5e9" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    @endif

                    <p class="text-slate-300 text-sm font-medium text-center">The Fastest Growing Identity & Payment
                        Company in Asia</p>

                    <p class="text-slate-400 text-xs">Copyright © 2026 PT Jasuindo Tiga Perkasa Tbk. All rights
                        reserved</p>
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

        // Close mobile menu when clicking a link
        mobileLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                const icon = mobileMenuBtn.querySelector('i');
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                const icon = mobileMenuBtn.querySelector('i');
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            }
        });

        // Navbar scroll effect - change from transparent to white
        const navbar = document.getElementById('main-navbar');
        const heroSection = document.getElementById('home');

        function handleScroll() {
            const scrollY = window.scrollY;
            const heroHeight = heroSection.offsetHeight;

            if (scrollY > 100) {
                navbar.classList.remove('navbar-transparent');
                navbar.classList.add('navbar-scrolled');

                // Change mobile menu button color
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
        handleScroll(); // Run on load
    </script>

</body>

</html>

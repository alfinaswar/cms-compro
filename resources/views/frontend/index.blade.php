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
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    lineHeight: {
                        tight: '1.4em',
                        snug: '1.4em',
                        none: '1.4em',
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
                            }
                        },
                        fadeInUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Set min 16px for body text and 1.4 line-height for desktop */
        @media (min-width: 1024px) {
            body {
                font-size: 16px;
                line-height: 1.4em;
            }
        }

        /* Optional: On mobile, you can allow slightly smaller size if you want, but not below 15px */
        @media (max-width: 1023.98px) {
            body {
                font-size: 15px;
                line-height: 1.4em;
            }
        }
    </style>

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

        /* Default colors */
        .nav-link {
            color: #0f172a;
            transition: color 0.2s;
        }

        .nav-icon {
            color: #0f172a;
            transition: color 0.2s;
        }

        .mobile-btn {
            color: #0f172a;
            transition: color 0.2s;
        }

        .logo-text {
            color: #0f172a;
            transition: color 0.2s;
        }

        /* When navbar is transparent (on hero): make white */
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

        /* Logo switching: gelap (terang/putih) saat transparent, terang (gelap/warna) saat scrolled */
        .logo-light {
            display: none;
        }

        .logo-dark {
            display: block;
        }

        .navbar-scrolled .logo-light {
            display: block;
        }

        .navbar-scrolled .logo-dark {
            display: none;
        }

        /* Fallback SVG juga ikut aturan yang sama */
        .navbar-transparent .logo-svg-dark {
            display: block;
        }

        .navbar-transparent .logo-svg-light {
            display: none;
        }

        .navbar-scrolled .logo-svg-dark {
            display: none;
        }

        .navbar-scrolled .logo-svg-light {
            display: block;
        }

        /* Smooth scroll offset for fixed navbar */
        section[id] {
            scroll-margin-top: 80px;
        }

        /* Global Typography Rule: Desktop body font-size minimal 16px, line-height 1.4em */
        html,
        body,
        input,
        button,
        select,
        textarea,
        optgroup,
        kbd,
        code,
        pre {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            line-height: 1.4em;
        }

        @media (min-width: 1024px) {
            body {
                font-size: 16px;
                line-height: 1.4em;
            }
        }

        /* Headline & Sub-headline Line-Height: 1.4em */
        h1, h2, h3, h4, h5, h6,
        .h1, .h2, .h3, .h4, .h5, .h6,
        .headline, .hero-headline,
        .sec-title, .box-title, .title,
        .sub-title, .subheadline, .sub-headline, .sec-subtitle, .box-subtitle, .subtitle,
        [class*="subjudul"], [class*="SubJudul"] {
            line-height: 1.4em !important;
        }

        @import "tailwindcss";

        @theme {
            --font-sans: "Plus Jakarta Sans", sans-serif;
            --font-mono: "Plus Jakarta Sans", sans-serif;
            --font-serif: "Plus Jakarta Sans", sans-serif;
            --leading-none: 1.4em;
            --leading-tight: 1.4em;
            --leading-snug: 1.4em;
        }
    </style>
    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
</head>

<body class="font-sans text-slate-600 antialiased bg-white">
    @php
        $currentLocale = app()->getLocale();

        // Eager load translations untuk menu
        $menus = \App\Models\Menu::menuHeader()
            ->with(['translations', 'children.translations'])
            ->get();

        // Helper: normalisasi path URL (buang domain, query, fragment, trailing slash)
        $navNormalizePath = function ($url) {
            if (empty($url) || $url === '#') return null;
            $u = strtolower(trim((string) parse_url((string) $url, PHP_URL_PATH), '/'));
            return $u; // '' berarti homepage
        };

        // Path saat ini tanpa prefix locale (mis. 'id/solution/payment' => 'solution/payment')
        $navCurrentPathRaw = trim(request()->path(), '/');
        $navSegments = explode('/', $navCurrentPathRaw);
        $navLocalePrefix = app()->getLocale();
        if (($navSegments[0] ?? '') === $navLocalePrefix || in_array($navSegments[0] ?? '', ['id', 'en'], true)) {
            array_shift($navSegments);
        }
        $navCurrentPath = strtolower(implode('/', $navSegments));

        // Helper: cocokkan URL menu dengan halaman saat ini (exact match saja).
        // Parent dropdown (Url '#') TIDAK AKAN pernah aktif — hanya child-nya yang bisa aktif.
        $navIsActive = function ($url) use ($navNormalizePath, $navCurrentPath) {
            $p = $navNormalizePath($url);
            if ($p === null) return false;
            if ($p === '') {
                return $navCurrentPath === ''; // homepage
            }
            return $p === $navCurrentPath;
        };

        // Helper: normalize Url Simpanan Admin (buang domain sendiri agar tetap ter-match)
        $navStoredPath = function ($url) use ($navNormalizePath) {
            if (empty($url) || $url === '#') return null;
            $u = strtolower(trim((string) $url));
            // Jika URL absolut mengarah ke domain sendiri, pakai path-nya saja
            $host = strtolower((string) request()->getHost());
            if (preg_match('#^https?://([^/]+)(.*)$#i', $u, $m)) {
                if ($host && strtolower($m[1]) === $host) {
                    return $navNormalizePath($u);
                }
                return 'EXTERNAL:' . $u; // external link, tidak pernah active by path
            }
            return ltrim($u, '/');
        };

        // Deteksi halaman "Solusi" via route halaman-solusi.show (child Solution dari DB admin)
        $navOnSolutionPage = request()->routeIs('halaman-solusi.show');
        $navSolutionSlug = $navOnSolutionPage ? (string) (request()->route('id') ?? request()->route('slug') ?? '') : '';
    @endphp

    <!-- ========================================== -->
    <!-- NAVIGATION MENU -->
    <!-- ========================================== -->
    <nav id="main-navbar" class="navbar-transparent fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('frontend.main') }}" class="flex items-center space-x-2">
                        @if (!empty($websiteSettings) && !empty($websiteSettings->PathLogo))
                            {{-- Logo GELAP (putih/terang) — tampil saat navbar transparent (sebelum scroll) --}}
                            @php
                                $logoGelap = !empty($websiteSettings->PathLogoGelap)
                                    ? asset('storage/' . $websiteSettings->PathLogoGelap)
                                    : asset('storage/' . $websiteSettings->PathLogo);
                            @endphp
                            <img src="{{ $logoGelap }}" alt="{{ $websiteSettings->NamaPerusahaan ?? __('Logo') }}"
                                width="180" height="64" style="object-fit: contain;" class="logo-dark">

                            {{-- Logo TERANG (gelap/warna asli) — tampil saat navbar scrolled (setelah scroll) --}}
                            <img src="{{ asset('storage/' . $websiteSettings->PathLogo) }}"
                                alt="{{ $websiteSettings->NamaPerusahaan ?? __('Logo') }}" width="180" height="64"
                                style="object-fit: contain;" class="logo-light">
                        @else
                            {{-- Fallback SVG jika tidak ada logo di DB --}}
                            <svg class="logo-svg-dark" width="64" height="64" viewBox="0 0 40 40" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 20L12 12L19 20L26 12L33 20" stroke="white" stroke-width="3"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M5 28L12 20L19 28" stroke="#e0f2fe" stroke-width="3" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <svg class="logo-svg-light" width="64" height="64" viewBox="0 0 40 40" fill="none"
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
                <div class="hidden lg:flex items-center space-x-6" id="desktop-menu">
                    @foreach ($menus as $menu)
                        @php
                            // 1. Terjemahan Nama Menu
                            $translation = $menu->translations->firstWhere('Locale', $currentLocale);
                            $menuName = $translation ? $translation->NamaMenu : $menu->NamaMenu;
                            $hasChildren = $menu->children->count() > 0;

                            // 2. URL
                            if ($menu->JenisLink === 'route' && !empty($menu->RouteName)) {
                                try {
                                    $menuUrl = route($menu->RouteName);
                                } catch (\Exception $e) {
                                    $menuUrl = route('frontend.main');
                                }
                            } elseif (!empty($menu->Url) && $menu->Url !== '#') {
                                $menuUrl = url($currentLocale . '/' . trim($menu->Url, '/'));
                            } else {
                                $menuUrl = '#';
                            }

                            // 3. Cek Active State (termasuk jika salah satu child-nya aktif)
                            $currentPath = trim(request()->path(), '/');
                            $pathWithoutLocale = implode('/', array_slice(explode('/', $currentPath), 1));
                            $pathWithSlash = $pathWithoutLocale . '/';

                            // Helper: cocokkan path URL menu dengan path halaman saat ini
                            // (mendukung trailing slash dari CustomUrlGenerator & prefix locale)
                            $matchUrl = function ($url) use ($pathWithoutLocale, $pathWithSlash) {
                                if (empty($url) || $url === '#') return false;
                                if (preg_match('#^(https?:)?//#i', $url)) {
                                    $url = preg_replace('#^https?://[^/]+#i', '', $url);
                                }
                                $u = strtolower(trim(parse_url($url, PHP_URL_PATH) ?? '', '/'));
                                $cur1 = strtolower($pathWithoutLocale);
                                $cur2 = strtolower($pathWithSlash);
                                if ($u === '' || $u === '/') {
                                    return $cur1 === '' || $cur1 === 'id' || $cur1 === 'en';
                                }
                                return $u === $cur1 || $u === $cur2 || str_starts_with($cur1, $u . '/');
                            };

                            if ($menu->JenisLink === 'route' && !empty($menu->RouteName)) {
                                $isActive =
                                    request()->routeIs($menu->RouteName) || request()->routeIs($menu->RouteName . '.*');
                            } else {
                                // Exact match saja — parent dengan Url '#' tidak akan pernah aktif
                                $isActive = $navIsActive($menu->Url);
                            }

                            // Helper cek aktif untuk child (memperbaiki false positive & self-domain URL admin)
                            $childActiveCheck = function ($child) use (
                                $navIsActive,
                                $navStoredPath,
                                $navOnSolutionPage,
                                $navSolutionSlug,
                            ) {
                                if ($child->JenisLink === 'route' && !empty($child->RouteName)) {
                                    return request()->routeIs($child->RouteName);
                                }
                                if ($navIsActive($child->Url)) {
                                    return true;
                                }
                                // Halaman Solusi (/solusi/{slug}/): cocokkan child berdasarkan slug di Url
                                if ($navOnSolutionPage && $navSolutionSlug !== '') {
                                    $stored = $navStoredPath($child->Url);
                                    if ($stored !== null && str_contains($stored, '/' . trim($navSolutionSlug, '/'))) {
                                        return true;
                                    }
                                }
                                return false;
                            };

                            // Jika menu punya children, periksa apakah ada child yang aktif
                            if ($hasChildren && !$isActive) {
                                foreach ($menu->children as $childCheck) {
                                    if ($childActiveCheck($childCheck)) {
                                        $isActive = true;
                                        break;
                                    }
                                }
                            }

                            // 4. Underline aktif hanya saat navbar sudah sticky/scrolled (putih saat transparent)
                            $activeUnderlineClass = $isActive ? 'nav-active-item after:w-full' : 'after:w-0';
                        @endphp

                        @if ($hasChildren)
                            <!-- Dropdown Parent Item -->
                            <div
                                class="relative py-2 group after:absolute after:bottom-0 after:left-0 after:h-[2px] after:bg-brand-600 after:transition-all after:duration-300 hover:after:w-full {{ $isActive ? 'after:w-full' : 'after:w-0' }}">
                                <a href="{{ $menuUrl !== '#' ? $menuUrl : 'javascript:void(0)' }}"
                                    class="nav-link flex items-center space-x-1 menu-link font-medium transition-colors duration-200 {{ $isActive ? 'text-brand-600 font-semibold' : 'text-black hover:text-brand-500' }}">
                                    @if ($menu->Icon)
                                        <i class="{{ $menu->Icon }}"></i>
                                    @endif
                                    <span>{{ $menuName }}</span>
                                    <i
                                        class="fa-solid fa-chevron-down text-xs ml-1 transition-transform duration-200 group-hover:rotate-180"></i>
                                </a>

                                <!-- Dropdown Panel -->
                                <div
                                    class="absolute top-full left-1/2 -translate-x-1/2 pt-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                    <div
                                        class="bg-white rounded-xl shadow-2xl border border-slate-100 py-3 min-w-[240px] overflow-hidden relative">
                                        <div
                                            class="absolute -top-2 left-1/2 -translate-x-1/2 w-4 h-4 bg-white border-l border-t border-slate-100 transform rotate-45">
                                        </div>

                                        @foreach ($menu->children as $child)
                                            @php
                                                $childTranslation = $child->translations->firstWhere(
                                                    'Locale',
                                                    $currentLocale,
                                                );
                                                $childName = $childTranslation
                                                    ? $childTranslation->NamaMenu
                                                    : $child->NamaMenu;

                                                // Generate the child URL properly
                                                if ($child->JenisLink === 'route' && !empty($child->RouteName)) {
                                                    try {
                                                        $childUrl = route($child->RouteName);
                                                        // Prefix locale segment if not already present
                                                        $parsed = parse_url($childUrl);
                                                    } catch (\Exception $e) {
                                                        $childUrl = route('frontend.main');
                                                    }
                                                } elseif (!empty($child->Url) && $child->Url !== '#') {
                                                    if (preg_match('/^https?:\/\//', $child->Url)) {
                                                        $childUrl = $child->Url;
                                                    } else {
                                                        $childUrl = url($currentLocale . '/' . ltrim($child->Url, '/'));
                                                    }
                                                } else {
                                                    $childUrl = '#';
                                                }

                                                if ($childActiveCheck($child)) {
                                                    $isChildActive = true;
                                                } else {
                                                    $isChildActive = false;
                                                }
                                            @endphp
                                            <a href="{{ $childUrl }}" target="{{ $child->Target ?? '_self' }}"
                                                class="flex items-center px-5 py-3 text-sm transition-colors duration-200 {{ $isChildActive ? 'bg-brand-50 text-brand-600 font-semibold' : 'text-slate-700 hover:bg-brand-50 hover:text-brand-600' }}">
                                                @if ($child->Icon)
                                                    <i class="{{ $child->Icon }} w-5 mr-3 text-brand-500"></i>
                                                @else
                                                    <i class="fa-solid fa-angle-right w-5 mr-3 text-brand-500"></i>
                                                @endif
                                                <span>{{ $childName }}</span>
                                            </a>
                                        @endforeach



                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Single Menu Item -->
                            <div
                                class="relative py-2 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:bg-white after:transition-all after:duration-300 hover:after:w-full {{ $isActive ? 'after:w-full' : 'after:w-0' }}">
                                <a href="{{ $menuUrl }}" target="{{ $menu->Target ?? '_self' }}"
                                    class="nav-link menu-link font-medium transition-colors duration-200 {{ $isActive ? 'text-brand-600 font-semibold' : 'text-black hover:text-brand-500' }}">
                                    @if ($menu->Icon)
                                        <i class="{{ $menu->Icon }} mr-1"></i>
                                    @endif
                                    {{ $menuName }}
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Right Side Actions -->
                <div class="hidden lg:flex items-center space-x-4">
                    <button onclick="openSearchModal()"
                        class="nav-icon hover:text-brand-500 transition-colors duration-200 p-2" aria-label="Search">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>

                    @php
                        $currentLocale = app()->getLocale();
                        $segments = request()->segments();

                        // Bangun URL untuk Bahasa Indonesia
                        $idSegments = $segments;
                        if (in_array($idSegments[0] ?? '', ['id', 'en'])) {
                            $idSegments[0] = 'id';
                        } else {
                            array_unshift($idSegments, 'id');
                        }
                        $urlId = url(implode('/', $idSegments));

                        // Bangun URL untuk Bahasa Inggris
                        $enSegments = $segments;
                        if (in_array($enSegments[0] ?? '', ['id', 'en'])) {
                            $enSegments[0] = 'en';
                        } else {
                            array_unshift($enSegments, 'en');
                        }
                        $urlEn = url(implode('/', $enSegments));
                    @endphp

                    <!-- Language Switcher Desktop -->
                    <!-- Language Switcher Desktop -->
                    <div class="relative group">
                        <button
                            class="nav-icon flex items-center space-x-1 hover:text-brand-500 transition-colors duration-200 py-2">
                            @if ($currentLocale == 'id')
                                <img src="https://flagcdn.com/w20/id.png" class="w-5 h-auto rounded-sm">
                                <span class="font-medium text-sm">ID</span>
                            @else
                                <img src="https://flagcdn.com/w20/gb.png" class="w-5 h-auto rounded-sm">
                                <span class="font-medium text-sm">EN</span>
                            @endif
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </button>

                        <div
                            class="absolute top-full right-0 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div
                                class="bg-white rounded-xl shadow-xl border border-slate-100 py-2 min-w-[160px] overflow-hidden">
                                <a href="{{ $urlId }}"
                                    class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-brand-50 hover:text-brand-600 {{ $currentLocale == 'id' ? 'bg-brand-50 text-brand-600 font-semibold' : '' }}">
                                    <img src="https://flagcdn.com/w20/id.png" class="w-5 h-auto rounded-sm mr-2">
                                    {{ __('Bahasa Indonesia') }}
                                </a>
                                <a href="{{ $urlEn }}"
                                    class="flex items-center px-4 py-2.5 text-sm text-slate-700 hover:bg-brand-50 hover:text-brand-600 {{ $currentLocale == 'en' ? 'bg-brand-50 text-brand-600 font-semibold' : '' }}">
                                    <img src="https://flagcdn.com/w20/gb.png" class="w-5 h-auto rounded-sm mr-2">
                                    {{ __('English') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('frontend.contact.index') }}"
                        class="bg-brand-600 hover:bg-brand-700 text-white px-6 py-2.5 rounded-full font-medium transition-all duration-200 shadow-md hover:shadow-lg">
                        {{ __('Contact Us') }}
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden flex items-center space-x-2">
                    <button onclick="openSearchModal()"
                        class="mobile-btn hover:text-brand-500 transition-colors duration-200 p-2"
                        aria-label="Search">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>
                    <button id="mobile-menu-btn" class="mobile-btn hover:text-brand-500 focus:outline-none p-2">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu Panel -->
            <div id="mobile-menu"
                class="lg:hidden hidden bg-white border-t border-gray-100 shadow-lg max-h-[calc(100vh-5rem)] overflow-y-auto">
                <div class="container mx-auto px-4 py-4 space-y-1">
                    @foreach ($menus as $menu)
                        @php
                            $hasChildren = $menu->children->count() > 0;
                            $translation = $menu->translations->firstWhere('Locale', $currentLocale);
                            $menuName = $translation ? $translation->NamaMenu : $menu->NamaMenu;

                            if ($menu->JenisLink === 'route' && !empty($menu->RouteName)) {
                                try {
                                    $menuUrl = route($menu->RouteName);
                                } catch (\Exception $e) {
                                    $menuUrl = route('frontend.main');
                                }
                            } elseif (!empty($menu->Url) && $menu->Url !== '#') {
                                $menuUrl = url($currentLocale . '/' . trim($menu->Url, '/'));
                            } else {
                                $menuUrl = '#';
                            }

                            if ($menu->JenisLink === 'route' && !empty($menu->RouteName)) {
                                $isActive =
                                    request()->routeIs($menu->RouteName) || request()->routeIs($menu->RouteName . '.*');
                            } else {
                                // Exact match saja — parent dropdown (Url '#') tidak pernah aktif
                                $isActive = $navIsActive($menu->Url);
                            }

                            // Child aktif check yang sama dengan desktop menu
                            if ($hasChildren && !$isActive) {
                                foreach ($menu->children as $childCheck) {
                                    if ($childActiveCheck($childCheck)) {
                                        $isActive = true;
                                        break;
                                    }
                                }
                            }
                        @endphp

                        @if ($hasChildren)
                            <div class="mobile-dropdown">
                                <button
                                    class="mobile-dropdown-btn w-full flex items-center justify-between px-4 py-3 hover:bg-brand-50 hover:text-brand-600 rounded-lg font-medium transition-colors {{ $isActive ? 'bg-brand-50 text-brand-600 font-semibold' : 'text-slate-700' }}">
                                    <span class="flex items-center">
                                        @if ($menu->Icon)
                                            <i class="{{ $menu->Icon }} mr-2"></i>
                                        @endif
                                        {{ $menuName }}
                                    </span>
                                    <i class="fa-solid fa-chevron-down text-xs transition-transform duration-300"></i>
                                </button>
                                <div
                                    class="mobile-dropdown-content hidden pl-6 space-y-1 mt-1 border-l-2 border-brand-100 ml-4">
                                    @foreach ($menu->children as $child)
                                        @php
                                            $childTranslation = $child->translations->firstWhere(
                                                'Locale',
                                                $currentLocale,
                                            );
                                            $childName = $childTranslation
                                                ? $childTranslation->NamaMenu
                                                : $child->NamaMenu;

                                            if ($child->JenisLink === 'route' && !empty($child->RouteName)) {
                                                try {
                                                    $childUrl = route($child->RouteName);
                                                } catch (\Exception $e) {
                                                    $childUrl = route('frontend.main');
                                                }
                                            } elseif (!empty($child->Url) && $child->Url !== '#') {
                                                $childUrl = url($currentLocale . '/' . trim($child->Url, '/'));
                                            } else {
                                                $childUrl = '#';
                                            }

                                            if ($childActiveCheck($child)) {
                                                $isChildActive = true;
                                            } else {
                                                $isChildActive = false;
                                            }
                                        @endphp
                                        <a href="{{ $childUrl }}" target="{{ $child->Target ?? '_self' }}"
                                            class="mobile-link flex items-center px-4 py-2.5 text-sm rounded-lg transition-colors {{ $isChildActive ? 'bg-brand-50 text-brand-600 font-semibold' : 'text-slate-600 hover:bg-brand-50 hover:text-brand-600' }}">
                                            @if ($child->Icon)
                                                <i class="{{ $child->Icon }} mr-2 text-brand-500"></i>
                                            @else
                                                <i class="fa-solid fa-angle-right mr-2 text-brand-500"></i>
                                            @endif
                                            {{ $childName }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $menuUrl }}" target="{{ $menu->Target ?? '_self' }}"
                                class="mobile-link flex items-center px-4 py-3 rounded-lg font-medium transition-colors {{ $isActive ? 'bg-brand-50 text-brand-600 font-semibold' : 'text-slate-700 hover:bg-brand-50 hover:text-brand-600' }}">
                                @if ($menu->Icon)
                                    <i class="{{ $menu->Icon }} mr-2"></i>
                                @endif
                                {{ $menuName }}
                            </a>
                        @endif
                    @endforeach

                    <!-- Language Switcher & Contact (Mobile) -->
                    <div class="border-t border-gray-200 pt-4 mt-4 space-y-2">
                        <a href="{{ $urlId }}"
                            class="w-full flex items-center justify-center space-x-2 px-4 py-3 text-slate-700 hover:bg-brand-50 rounded-lg transition-colors {{ $currentLocale == 'id' ? 'bg-brand-50 text-brand-600 font-semibold' : '' }}">
                            <img src="https://flagcdn.com/w20/id.png" alt="Indonesia" class="w-5 h-auto rounded-sm">
                            <span class="font-medium">{{ __('Bahasa Indonesia') }}</span>
                        </a>

                        <a href="{{ $urlEn }}"
                            class="w-full flex items-center justify-center space-x-2 px-4 py-3 text-slate-700 hover:bg-brand-50 rounded-lg transition-colors {{ $currentLocale == 'en' ? 'bg-brand-50 text-brand-600 font-semibold' : '' }}">
                            <img src="https://flagcdn.com/w20/gb.png" alt="English" class="w-5 h-auto rounded-sm">
                            <span class="font-medium">{{ __('English') }}</span>
                        </a>

                        <a href="{{ route('frontend.contact.index') }}"
                            class="block w-full text-center bg-brand-600 hover:bg-brand-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            {{ __('Contact Us') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('main-navbar');
            const menuLinks = document.querySelectorAll('#desktop-menu .menu-link');

            function setLinkColor(scrolled) {
                menuLinks.forEach(function(link) {
                    // Jangan timpa warna teks jika menu sedang aktif
                    if (link.classList.contains('text-brand-600') || link.classList.contains(
                            'text-brand-400')) return;

                    if (scrolled) {
                        link.classList.remove('text-white');
                        link.classList.add('text-black');
                    } else {
                        link.classList.remove('text-white');
                        link.classList.add('text-black');
                    }
                });
            }

            function handleScroll() {
                setLinkColor(window.scrollY > 20);
            }

            setLinkColor(window.scrollY > 20);
            window.addEventListener('scroll', handleScroll);
        });
    </script>

    <!-- ========================================== -->
    <!-- CONTENT SECTION -->
    <!-- ========================================== -->
    @yield('content-frontend')

    <!-- ========================================== -->
    <!-- FOOTER -->
    <!-- ========================================== -->
    <footer class="bg-[#0F2854] text-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-12">

                <!-- Logo & Description -->
                <div class="lg:col-span-3">
                    <div class="mb-4">
                        @php
                            $footerLogo = !empty($websiteSettings?->PathLogoGelap)
                                ? asset('storage/' . $websiteSettings->PathLogoGelap)
                                : (!empty($websiteSettings?->PathLogo) ? asset('storage/' . $websiteSettings->PathLogo) : null);
                        @endphp
                        @if ($footerLogo)
                            <a href="{{ route('frontend.main', ['locale' => $currentLocale]) }}" class="inline-block">
                                <img src="{{ $footerLogo }}"
                                    alt="{{ $websiteSettings->NamaPerusahaan ?? __('Logo') }}"
                                    class="h-10 w-auto object-contain">
                            </a>
                        @else
                            <a href="{{ route('frontend.main', ['locale' => $currentLocale]) }}" class="flex items-center space-x-2">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 20L12 12L19 20L26 12L33 20" stroke="white" stroke-width="3"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M5 28L12 20L19 28" stroke="#0ea5e9" stroke-width="3"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="text-2xl font-bold">{{ $websiteSettings->NamaSingkat ?? $websiteSettings->NamaPerusahaan ?? 'JASUINDO' }}</span>
                            </a>
                        @endif
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">
                        {{ $websiteSettings->DeskripsiSingkat ?? __('Perusahaan percetakan keamanan terkemuka di Indonesia untuk dokumen sekuriti & solusi identitas.') }}
                    </p>
                    <div class="flex flex-wrap gap-3">
                        @if (!empty($websiteSettings?->SosialFacebook))
                            <a href="{{ $websiteSettings->SosialFacebook }}" target="_blank" rel="noopener noreferrer"
                                aria-label="Facebook"
                                class="w-8 h-8 bg-brand-900 hover:bg-brand-800 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-facebook-f text-sm"></i>
                            </a>
                        @endif
                        @if (!empty($websiteSettings?->SosialInstagram))
                            <a href="{{ $websiteSettings->SosialInstagram }}" target="_blank" rel="noopener noreferrer"
                                aria-label="Instagram"
                                class="w-8 h-8 bg-brand-900 hover:bg-brand-800 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-instagram text-sm"></i>
                            </a>
                        @endif
                        @if (!empty($websiteSettings?->SosialLinkedIn))
                            <a href="{{ $websiteSettings->SosialLinkedIn }}" target="_blank" rel="noopener noreferrer"
                                aria-label="LinkedIn"
                                class="w-8 h-8 bg-brand-900 hover:bg-brand-800 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-linkedin-in text-sm"></i>
                            </a>
                        @endif
                        @if (!empty($websiteSettings?->SosialYoutube))
                            <a href="{{ $websiteSettings->SosialYoutube }}" target="_blank" rel="noopener noreferrer"
                                aria-label="YouTube"
                                class="w-8 h-8 bg-brand-900 hover:bg-brand-800 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-youtube text-sm"></i>
                            </a>
                        @endif
                        @if (!empty($websiteSettings?->SosialTwitter))
                            <a href="{{ $websiteSettings->SosialTwitter }}" target="_blank" rel="noopener noreferrer"
                                aria-label="Twitter / X"
                                class="w-8 h-8 bg-brand-900 hover:bg-brand-800 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-x-twitter text-sm"></i>
                            </a>
                        @endif
                        @if (!empty($websiteSettings?->SosialTiktok))
                            <a href="{{ $websiteSettings->SosialTiktok }}" target="_blank" rel="noopener noreferrer"
                                aria-label="TikTok"
                                class="w-8 h-8 bg-brand-900 hover:bg-brand-800 rounded-lg flex items-center justify-center transition-colors">
                                <i class="fa-brands fa-tiktok text-sm"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Company Links -->
                <div class="lg:col-span-2">
                    <h3 class="text-base font-bold mb-4">{{ __('Company') }}</h3>
                    @php
                        $footerMenus = \App\Models\Menu::where('StatusAktif', true)
                            ->where('TampilkanDiFooter', true)
                            ->with('translations')
                            ->orderBy('Urutan', 'asc')
                            ->get();
                    @endphp
                    <ul class="space-y-2.5">
                        @if ($footerMenus->isNotEmpty())
                            @foreach ($footerMenus as $footerMenu)
                                @php
                                    $fmTranslation = $footerMenu->translations->firstWhere('Locale', $currentLocale);
                                    $fmName = $fmTranslation && !empty($fmTranslation->NamaMenu) ? $fmTranslation->NamaMenu : $footerMenu->NamaMenu;
                                @endphp
                                <li>
                                    <a href="{{ $footerMenu->link }}" target="{{ $footerMenu->Target ?? '_self' }}"
                                        class="text-slate-400 hover:text-white transition-colors text-sm">
                                        {{ $fmName }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <li><a href="{{ route('frontend.about-us', ['locale' => $currentLocale]) }}"
                                    class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('About Us') }}</a>
                            </li>
                            <li><a href="{{ route('frontend.career', ['locale' => $currentLocale]) }}"
                                    class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('Career') }}</a>
                            </li>
                            <li><a href="{{ route('frontend.news', ['locale' => $currentLocale]) }}"
                                    class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('News') }}</a>
                            </li>
                            <li><a href="{{ route('frontend.contact.index', ['locale' => $currentLocale]) }}"
                                    class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('Contact Us') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>

                <!-- Solutions Links -->
                <div class="lg:col-span-2">
                    <h3 class="text-base font-bold mb-4">{{ __('Solutions') }}</h3>
                    @php
                        $footerSolusi = !empty($halamanSolusi) && $halamanSolusi->isNotEmpty()
                            ? $halamanSolusi->filter(fn($item) => $item->IsPublished ?? true)
                            : \App\Models\HalamanSolusi::with('translations')->where(function($q) {
                                $q->where('IsPublished', true)->orWhereNull('IsPublished');
                            })->get();
                    @endphp
                    <ul class="space-y-2.5">
                        @forelse ($footerSolusi as $solusiItem)
                            @php
                                $sTrans = $solusiItem->translations ? $solusiItem->translations->firstWhere('Locale', $currentLocale) : null;
                                $sJudul = $sTrans && !empty($sTrans->Judul) ? $sTrans->Judul : $solusiItem->Judul;
                                $sSlug = !empty($solusiItem->Slug) ? $solusiItem->Slug : $solusiItem->id;
                            @endphp
                            <li>
                                <a href="{{ route('halaman-solusi.show', ['locale' => $currentLocale, 'id' => $sSlug]) }}"
                                    class="text-slate-400 hover:text-white transition-colors text-sm">
                                    {{ $sJudul }}
                                </a>
                            </li>
                        @empty
                            <li><a href="#"
                                    class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('Identity') }}</a>
                            </li>
                            <li><a href="#"
                                    class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('Payment') }}</a>
                            </li>
                            <li><a href="#"
                                    class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('Brand Protection') }}</a>
                            </li>
                            <li><a href="#"
                                    class="text-slate-400 hover:text-white transition-colors text-sm">{{ __('Commercial Printing') }}</a>
                            </li>
                        @endforelse
                    </ul>
                </div>

                <!-- Head Office -->
                <div class="lg:col-span-5">
                    <h3 class="text-base font-bold mb-4">{{ __('Head Office') }}</h3>
                    <div class="space-y-3 text-slate-400 text-sm">
                        @if (!empty($websiteSettings) && (!empty($websiteSettings->AlamatKantor) || !empty($websiteSettings->NomorTelepon)))
                            <div>
                                @if (!empty($websiteSettings->AlamatKantor))
                                    <p class="mb-1 leading-relaxed whitespace-pre-line">{!! nl2br(e($websiteSettings->AlamatKantor)) !!}</p>
                                @endif
                                @if (!empty($websiteSettings->NomorTelepon))
                                    <p class="text-slate-400">
                                        <span class="text-slate-500">{{ __('Phone') }}</span> 
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $websiteSettings->NomorTelepon) }}" class="hover:text-white transition-colors">
                                            {{ $websiteSettings->NomorTelepon }}
                                        </a>
                                    </p>
                                @endif
                                @if (!empty($websiteSettings->NomorWhatsApp))
                                    <p class="text-slate-400">
                                        <span class="text-slate-500">WhatsApp:</span> 
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $websiteSettings->NomorWhatsApp) }}" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">
                                            {{ $websiteSettings->NomorWhatsApp }}
                                        </a>
                                    </p>
                                @endif
                                @if (!empty($websiteSettings->AlamatEmail))
                                    <p class="text-slate-400">
                                        <span class="text-slate-500">Email:</span> 
                                        <a href="mailto:{{ $websiteSettings->AlamatEmail }}" class="hover:text-white transition-colors">
                                            {{ $websiteSettings->AlamatEmail }}
                                        </a>
                                    </p>
                                @endif
                            </div>
                        @else
                            <div>
                                <p class="mb-1">Jalan Raya Betro Nomor 21,<br>Sedati, Sidoarjo, Surabaya 61253 Indonesia
                                </p>
                                <p class="text-slate-500">{{ __('Phone') }} +62 31 8910919 (Hunting)</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-slate-800 mt-12 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-slate-500 text-xs">
                        @if (!empty($websiteSettings?->TeksCopyright))
                            {{ $websiteSettings->TeksCopyright }}
                        @else
                            © {{ date('Y') }} {{ $websiteSettings->NamaPerusahaan ?? 'PT Jasuindo Tiga Perkasa Tbk' }}. {{ __('All rights reserved') }}
                        @endif
                    </p>
                    <div class="flex flex-wrap justify-center gap-x-6 gap-y-2 text-xs">
                        @php
                            $termsUrl = !empty($websiteSettings?->TautanSyaratKetentuan)
                                ? $websiteSettings->TautanSyaratKetentuan
                                : route('static-pages.show', ['locale' => $currentLocale, 'slug' => 'syarat-ketentuan']);
                            $privacyUrl = !empty($websiteSettings?->TautanKebijakanPrivasi)
                                ? $websiteSettings->TautanKebijakanPrivasi
                                : route('static-pages.show', ['locale' => $currentLocale, 'slug' => 'kebijakan-privasi']);
                            $faqUrl = route('static-pages.show', ['locale' => $currentLocale, 'slug' => 'faq']);
                        @endphp
                        <a href="{{ $termsUrl }}"
                            class="text-slate-500 hover:text-white transition-colors">{{ __('Terms & Conditions') }}</a>
                        <a href="{{ $privacyUrl }}"
                            class="text-slate-500 hover:text-white transition-colors">{{ __('Privacy Policy') }}</a>
                        <a href="{{ $faqUrl }}"
                            class="text-slate-500 hover:text-white transition-colors">{{ __('Cookies') }}</a>
                        <a href="{{ route('frontend.sitemap', ['locale' => $currentLocale]) }}"
                            class="text-slate-500 hover:text-white transition-colors">
                            {{ __('Sitemap') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </footer>

    <!-- ========================================== -->
    <!-- SEARCH MODAL (dengan Live Suggestions) -->
    <!-- ========================================== -->
    <div id="searchModal" class="fixed inset-0 z-[100] hidden items-start justify-center pt-20 md:pt-32 px-4"
        style="background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(8px);">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 bg-slate-50">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-magnifying-glass text-brand-600"></i>
                    <h3 class="text-base font-bold text-slate-900">{{ __('Search Articles') }}</h3>
                </div>
                <button onclick="closeSearchModal()"
                    class="w-9 h-9 rounded-lg hover:bg-slate-200 text-slate-500 flex items-center justify-center transition-colors"
                    aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            {{-- Form --}}
            <form id="searchModalForm" action="{{ route('frontend.news') }}" method="GET" class="p-6">
                <div class="relative">
                    <i
                        class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" id="searchModalInput" name="search" autocomplete="off"
                        placeholder="{{ __('Search news, articles, topics...') }}"
                        class="w-full pl-12 pr-12 py-4 bg-slate-50 border border-slate-200 rounded-xl text-base focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">

                    {{-- Loading Spinner --}}
                    <div id="searchLoader" class="absolute right-4 top-1/2 -translate-y-1/2 hidden">
                        <svg class="animate-spin h-5 w-5 text-brand-600" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>

                    {{-- Clear Button --}}
                    <button type="button" id="searchClearBtn" onclick="clearSearch()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 hidden w-7 h-7 rounded-full bg-slate-200 hover:bg-slate-300 text-slate-600 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>

                    <button type="submit"
                        class="hidden absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold rounded-lg transition-colors">
                        {{ __('Search') }}
                    </button>
                </div>

                {{-- Live Results Container --}}
                <div id="searchResults" class="mt-3 hidden max-h-80 overflow-y-auto">
                    <div class="border border-slate-200 rounded-xl overflow-hidden divide-y divide-slate-100"
                        id="searchResultsList">
                        {{-- Hasil akan diisi oleh JS --}}
                    </div>
                </div>

                {{-- Empty State --}}
                <div id="searchEmpty" class="mt-4 hidden text-center py-6">
                    <i class="fa-regular fa-folder-open text-3xl text-slate-300 mb-2"></i>
                    <p class="text-sm text-slate-500">{{ __('No articles found') }}</p>
                    <p class="text-xs text-slate-400 mt-1">{{ __('Try different keywords') }}</p>
                </div>

                {{-- Quick Keywords --}}
                <div id="searchKeywords" class="mt-5">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">
                        {{ __('Popular Searches') }}
                    </p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($popularKeywords as $kw)
                            <button type="button" onclick="fillSearch('{{ addslashes($kw) }}')"
                                class="px-3 py-1.5 bg-slate-100 hover:bg-brand-50 hover:text-brand-700 text-slate-700 text-xs font-medium rounded-lg transition-colors">
                                {{ $kw }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Hint --}}
                <p class="mt-4 text-xs text-slate-400 flex items-center gap-2">
                    <i class="fa-solid fa-keyboard"></i>
                    {{ __('Press') }} <kbd
                        class="px-1.5 py-0.5 bg-slate-100 border border-slate-200 rounded text-[10px] font-sans">ESC</kbd>
                    {{ __('to close') }}
                    <span class="mx-1">•</span>
                    <kbd
                        class="px-1.5 py-0.5 bg-slate-100 border border-slate-200 rounded text-[10px] font-sans">Enter</kbd>
                    {{ __('for full search') }}
                </p>
            </form>
        </div>
    </div>

    <style>
        .search-highlight {
            background-color: #fef3c7;
            color: #92400e;
            font-weight: 600;
            padding: 0 2px;
            border-radius: 2px;
        }

        .search-result-item:hover {
            background-color: #f0f9ff;
        }
    </style>
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
            } else {
                navbar.classList.add('navbar-transparent');
                navbar.classList.remove('navbar-scrolled');
            }
        }

        window.addEventListener('scroll', handleScroll);
        handleScroll();
    </script>
    <script>
        // ===== SEARCH MODAL =====
        const searchModal = document.getElementById('searchModal');
        const searchModalInput = document.getElementById('searchModalInput');

        function openSearchModal() {
            searchModal.classList.remove('hidden');
            searchModal.classList.add('flex');
            setTimeout(() => searchModalInput.focus(), 100);
            document.body.style.overflow = 'hidden'; // prevent scroll
        }

        function closeSearchModal() {
            searchModal.classList.add('hidden');
            searchModal.classList.remove('flex');
            document.body.style.overflow = ''; // restore scroll
        }

        function fillSearch(keyword) {
            searchModalInput.value = keyword;
            searchModalInput.focus();
        }

        // Close on backdrop click
        searchModal.addEventListener('click', function(e) {
            if (e.target === searchModal) closeSearchModal();
        });

        // Close on ESC, open on Ctrl+K or Cmd+K
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeSearchModal();
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                openSearchModal();
            }
        });
    </script>
    <script>
        // ===== SEARCH MODAL with Live Suggestions =====
        const searchModal = document.getElementById('searchModal');
        const searchModalInput = document.getElementById('searchModalInput');
        const searchResults = document.getElementById('searchResults');
        const searchResultsList = document.getElementById('searchResultsList');
        const searchEmpty = document.getElementById('searchEmpty');
        const searchLoader = document.getElementById('searchLoader');
        const searchClearBtn = document.getElementById('searchClearBtn');
        const searchKeywords = document.getElementById('searchKeywords');

        let searchDebounceTimer = null;
        let currentAbortController = null;

        function openSearchModal() {
            searchModal.classList.remove('hidden');
            searchModal.classList.add('flex');
            setTimeout(() => searchModalInput.focus(), 100);
            document.body.style.overflow = 'hidden';
        }

        function closeSearchModal() {
            searchModal.classList.add('hidden');
            searchModal.classList.remove('flex');
            document.body.style.overflow = '';
            clearSearch();
        }

        function fillSearch(keyword) {
            searchModalInput.value = keyword;
            searchModalInput.focus();
            searchModalInput.dispatchEvent(new Event('input')); // trigger search
        }

        function clearSearch() {
            searchModalInput.value = '';
            searchResults.classList.add('hidden');
            searchEmpty.classList.add('hidden');
            searchKeywords.classList.remove('hidden');
            searchClearBtn.classList.add('hidden');
            if (currentAbortController) {
                currentAbortController.abort();
                currentAbortController = null;
            }
        }

        // Highlight keyword dalam teks
        function highlightText(text, query) {
            if (!query) return text;
            const regex = new RegExp(`(${query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
            return text.replace(regex, '<mark class="search-highlight">$1</mark>');
        }

        // Fetch artikel dari API
        async function fetchSearchResults(query) {
            if (query.length < 2) {
                searchResults.classList.add('hidden');
                searchEmpty.classList.add('hidden');
                searchKeywords.classList.remove('hidden');
                return;
            }

            // Batalkan request sebelumnya
            if (currentAbortController) {
                currentAbortController.abort();
            }
            currentAbortController = new AbortController();

            // Tampilkan loading
            searchLoader.classList.remove('hidden');
            searchKeywords.classList.add('hidden');

            try {
                const response = await fetch(
                    `{{ route('frontend.api.search-articles') }}?q=${encodeURIComponent(query)}`, {
                        signal: currentAbortController.signal
                    });

                if (!response.ok) throw new Error('Network response error');

                const data = await response.json();

                // Sembunyikan loader
                searchLoader.classList.add('hidden');

                if (data.results.length === 0) {
                    searchResults.classList.add('hidden');
                    searchEmpty.classList.remove('hidden');
                } else {
                    searchEmpty.classList.add('hidden');
                    searchResults.classList.remove('hidden');

                    // Render hasil
                    searchResultsList.innerHTML = data.results.map(article => `
                    <a href="${article.url}" class="search-result-item flex gap-3 p-3 hover:bg-brand-50 transition-colors">
                        <div class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden bg-slate-100">
                            ${article.thumbnail
                                ? `<img src="${article.thumbnail}" alt="${article.judul}" class="w-full h-full object-cover">`
                                : `<div class="w-full h-full flex items-center justify-center"><i class="fa-regular fa-newspaper text-slate-400"></i></div>`
                            }
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[10px] font-bold text-brand-600 bg-brand-50 px-1.5 py-0.5 rounded uppercase">${article.kategori}</span>
                                <span class="text-[10px] text-slate-400">${article.tanggal}</span>
                            </div>
                            <h4 class="text-sm font-semibold text-slate-900 line-clamp-2 leading-snug">
                                ${highlightText(article.judul, query)}
                            </h4>
                            ${article.ringkasan ? `
                                                                            <p class="text-xs text-slate-500 line-clamp-1 mt-0.5">
                                                                                ${highlightText(article.ringkasan, query)}
                                                                            </p>
                                                                        ` : ''}
                        </div>
                        <div class="flex-shrink-0 self-center">
                            <i class="fa-solid fa-arrow-right text-slate-400 text-xs"></i>
                        </div>
                    </a>
                `).join('');
                }
            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error('Search error:', error);
                    searchLoader.classList.add('hidden');
                }
            }
        }

        // Event listener input dengan debounce
        searchModalInput.addEventListener('input', function(e) {
            const value = e.target.value.trim();

            // Show/hide clear button
            if (value.length > 0) {
                searchClearBtn.classList.remove('hidden');
            } else {
                searchClearBtn.classList.add('hidden');
            }

            // Debounce 300ms
            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(() => {
                fetchSearchResults(value);
            }, 300);
        });

        // Close on backdrop click
        searchModal.addEventListener('click', function(e) {
            if (e.target === searchModal) closeSearchModal();
        });

        // Close on ESC, open on Ctrl+K / Cmd+K
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeSearchModal();
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                openSearchModal();
            }
        });
    </script>
    <!-- GLightbox JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof GLightbox !== 'undefined') {
                window.lightbox = GLightbox({
                    selector: '.glightbox',
                    touchNavigation: true,
                    loop: true,
                    zoomable: true
                });
            }
        });
    </script>
    @stack('scripts')
    @include('frontend.cookie-consent')
</body>

</html>

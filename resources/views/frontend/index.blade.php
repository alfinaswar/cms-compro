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

    <!-- ========================================== -->
    <!-- NAVIGATION MENU -->
    <!-- ========================================== -->
    <nav id="main-navbar" class="navbar-transparent fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="#" class="flex items-center space-x-2">
                        <svg class="w-10 h-10" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 20L12 12L19 20L26 12L33 20" stroke="#0284c7" stroke-width="3"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5 28L12 20L19 28" stroke="#0ea5e9" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <span
                            class="logo-text text-2xl font-bold text-brand-950 tracking-tight transition-colors duration-300">JASUINDO</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="#home"
                        class="nav-link text-white hover:text-brand-500 font-medium transition-colors duration-200">Home</a>
                    <a href="#about"
                        class="nav-link text-white hover:text-brand-500 font-medium transition-colors duration-200">About
                        Us</a>
                    <a href="#solusi"
                        class="nav-link text-white hover:text-brand-500 font-medium transition-colors duration-200">Solutions</a>
                    <a href="#sertifikasi"
                        class="nav-link text-white hover:text-brand-500 font-medium transition-colors duration-200">Certification</a>
                    <a href="#kontak"
                        class="nav-link text-white hover:text-brand-500 font-medium transition-colors duration-200">Contact</a>
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
        <div id="mobile-menu" class="lg:hidden hidden bg-white border-t border-gray-100 shadow-lg">
            <div class="container mx-auto px-4 py-4 space-y-2">
                <a href="#home"
                    class="mobile-link block px-4 py-3 text-slate-700 hover:bg-brand-50 hover:text-brand-600 rounded-lg font-medium transition-colors">Home</a>
                <a href="#about"
                    class="mobile-link block px-4 py-3 text-slate-700 hover:bg-brand-50 hover:text-brand-600 rounded-lg font-medium transition-colors">About
                    Us</a>
                <a href="#solusi"
                    class="mobile-link block px-4 py-3 text-slate-700 hover:bg-brand-50 hover:text-brand-600 rounded-lg font-medium transition-colors">Solutions</a>
                <a href="#sertifikasi"
                    class="mobile-link block px-4 py-3 text-slate-700 hover:bg-brand-50 hover:text-brand-600 rounded-lg font-medium transition-colors">Certification</a>
                <a href="#kontak"
                    class="mobile-link block px-4 py-3 text-slate-700 hover:bg-brand-50 hover:text-brand-600 rounded-lg font-medium transition-colors">Contact</a>

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

    <!-- ========================================== -->
    <!-- 1. HERO SECTION -->
    <!-- ========================================== -->
    <section id="home" class="relative min-h-screen flex items-center bg-brand-900 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1451187580459-43490279c0fa?q=80&w=2072&auto=format&fit=crop"
                alt="Technology Background" class="w-full h-full object-cover opacity-20">
            <div class="absolute inset-0 bg-gradient-to-r from-brand-900 via-brand-900/95 to-brand-900/80"></div>
        </div>

        <div
            class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse">
        </div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"
            style="animation-delay: 2s;"></div>

        <div class="container mx-auto px-6 relative z-10 pt-20">
            <div class="max-w-3xl animate-fade-in-up">
                <span
                    class="inline-block py-1.5 px-4 rounded-full bg-brand-500/20 text-brand-100 text-sm font-semibold tracking-wide mb-6 border border-brand-500/30 backdrop-blur-sm">
                    <i class="fa-solid fa-star mr-2 text-yellow-400"></i> Mitra Teknologi Terpercaya Sejak 1990
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
                    Transformasi Digital <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-cyan-300">Identitas &
                        Pembayaran</span> Nasional
                </h1>
                <p class="text-lg md:text-xl text-slate-300 mb-8 leading-relaxed max-w-2xl">
                    Kami menyediakan infrastruktur teknologi yang aman, handal, dan terintegrasi untuk mendukung
                    ekosistem digital pemerintah dan perbankan di seluruh Asia.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#solusi"
                        class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-white transition-all duration-200 bg-brand-600 rounded-xl hover:bg-brand-500 hover:shadow-lg hover:shadow-brand-500/30 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-600 focus:ring-offset-brand-900">
                        Jelajahi Solusi
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                    <a href="#kontak"
                        class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-white transition-all duration-200 bg-transparent border-2 border-slate-600 rounded-xl hover:bg-white/10 hover:border-white focus:outline-none">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>

        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce text-slate-400">
            <i class="fa-solid fa-chevron-down text-2xl"></i>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 2. KEY FIGURES SECTION -->
    <!-- ========================================== -->
    <section id="about" class="relative py-20 bg-white -mt-16 z-20">
        <div class="container mx-auto px-6">
            <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-8 md:p-12">
                <div
                    class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12 text-center divide-x-0 md:divide-x divide-slate-100">

                    <div class="p-4 group cursor-default">
                        <div
                            class="w-16 h-16 mx-auto bg-brand-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-brand-600 transition-colors duration-300">
                            <i
                                class="fa-solid fa-calendar-check text-2xl text-brand-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-2">1990</h3>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Tahun Berdiri</p>
                    </div>

                    <div class="p-4 group cursor-default">
                        <div
                            class="w-16 h-16 mx-auto bg-brand-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-brand-600 transition-colors duration-300">
                            <i
                                class="fa-solid fa-users text-2xl text-brand-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-2">800+</h3>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Karyawan Profesional
                        </p>
                    </div>

                    <div class="p-4 group cursor-default">
                        <div
                            class="w-16 h-16 mx-auto bg-brand-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-brand-600 transition-colors duration-300">
                            <i
                                class="fa-solid fa-building-columns text-2xl text-brand-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-2">100+</h3>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Institusi Pemerintah
                        </p>
                    </div>

                    <div class="p-4 group cursor-default">
                        <div
                            class="w-16 h-16 mx-auto bg-brand-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-brand-600 transition-colors duration-300">
                            <i
                                class="fa-solid fa-vault text-2xl text-brand-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-2">80+</h3>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Mitra Perbankan</p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 3. SOLUTIONS SECTION -->
    <!-- ========================================== -->
    <section id="solusi" class="py-24 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-brand-600 font-bold tracking-wider uppercase text-sm">What We're Offering</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2 mb-4">Jasuindo Solutions</h2>
                <p class="text-slate-600 text-lg">Solusi teknologi end-to-end yang dirancang untuk memenuhi kebutuhan
                    spesifik bisnis Anda, merampingkan operasional, dan mendorong pertumbuhan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                <div class="solution-card group bg-white rounded-2xl overflow-hidden border border-slate-100">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1555949963-aa79dcee981c?q=80&w=2070&auto=format&fit=crop"
                            alt="Digital Identity"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-brand-600 transition-colors">
                            Manajemen Identitas Digital</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-4">Solusi biometrik dan verifikasi
                            identitas terintegrasi yang akurat, cepat, dan memenuhi standar keamanan tertinggi.</p>
                        <a href="#"
                            class="inline-flex items-center text-sm font-bold text-brand-600 hover:text-brand-800 transition-colors">
                            Baca Selengkapnya <i
                                class="fa-solid fa-arrow-right-long ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>

                <div class="solution-card group bg-white rounded-2xl overflow-hidden border border-slate-100">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?q=80&w=2070&auto=format&fit=crop"
                            alt="Payment Gateway"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-brand-600 transition-colors">
                            Payment & Switching</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-4">Infrastruktur pembayaran multichannel
                            yang handal dengan tingkat ketersediaan (uptime) 99.9% untuk transaksi tanpa hambatan.</p>
                        <a href="#"
                            class="inline-flex items-center text-sm font-bold text-brand-600 hover:text-brand-800 transition-colors">
                            Baca Selengkapnya <i
                                class="fa-solid fa-arrow-right-long ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>

                <div class="solution-card group bg-white rounded-2xl overflow-hidden border border-slate-100">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?q=80&w=2034&auto=format&fit=crop"
                            alt="Data Center"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-brand-600 transition-colors">
                            Data Center & Cloud</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-4">Layanan hosting dan cloud privat
                            berstandar Tier-III dengan keamanan fisik dan siber berlapis untuk data kritis Anda.</p>
                        <a href="#"
                            class="inline-flex items-center text-sm font-bold text-brand-600 hover:text-brand-800 transition-colors">
                            Baca Selengkapnya <i
                                class="fa-solid fa-arrow-right-long ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>

                <div class="solution-card group bg-white rounded-2xl overflow-hidden border border-slate-100">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?q=80&w=2070&auto=format&fit=crop"
                            alt="Cybersecurity"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-brand-600 transition-colors">
                            Cybersecurity Intelligence</h3>
                        <p class="text-slate-600 text-sm leading-relaxed mb-4">Pemantauan ancaman siber secara
                            real-time dan respons insiden proaktif untuk melindungi aset digital organisasi.</p>
                        <a href="#"
                            class="inline-flex items-center text-sm font-bold text-brand-600 hover:text-brand-800 transition-colors">
                            Baca Selengkapnya <i
                                class="fa-solid fa-arrow-right-long ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 4. CERTIFICATION & LOGOS SECTION (Marquee) -->
    <!-- ========================================== -->
    <section id="sertifikasi" class="py-20 bg-white border-t border-slate-100 overflow-hidden">
        <div class="container mx-auto px-6 mb-12 text-center">
            <span class="text-brand-600 font-bold tracking-wider uppercase text-sm">Trust & Compliance</span>
            <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Sertifikasi & Penghargaan</h2>
        </div>

        <div class="relative w-full">
            <div class="absolute left-0 top-0 bottom-0 w-24 bg-gradient-to-r from-white to-transparent z-10"></div>
            <div class="absolute right-0 top-0 bottom-0 w-24 bg-gradient-to-l from-white to-transparent z-10"></div>

            <div class="flex overflow-hidden">
                <div class="flex animate-marquee whitespace-nowrap">
                    <!-- Logo Set 1 -->
                    <div class="flex items-center space-x-16 mx-8">
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-certificate text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">ISO 27001</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-shield-halved text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">ISO 9001:2015</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-building-shield text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">PCI-DSS</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-award text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">BSI Certified</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-trophy text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">Top IT Solution</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-globe text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">Kominfo RI</span>
                        </div>
                    </div>
                    <!-- Logo Set 2 (Duplicate for seamless loop) -->
                    <div class="flex items-center space-x-16 mx-8">
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-certificate text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">ISO 27001</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-shield-halved text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">ISO 9001:2015</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-building-shield text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">PCI-DSS</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-award text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">BSI Certified</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-trophy text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">Top IT Solution</span>
                        </div>
                        <div
                            class="flex flex-col items-center justify-center w-32 h-24 grayscale hover:grayscale-0 transition-all duration-300 opacity-50 hover:opacity-100 cursor-pointer">
                            <i class="fa-solid fa-globe text-4xl text-slate-800 mb-2"></i>
                            <span class="text-xs font-bold text-slate-600">Kominfo RI</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- 5. CTA / CONTACT SECTION -->
    <!-- ========================================== -->
    <section id="kontak"
        class="py-20 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-950 relative overflow-hidden">
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>
        <div
            class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <span
                    class="inline-block py-1.5 px-4 rounded-full bg-brand-500/20 text-brand-100 text-sm font-semibold tracking-wide mb-6 border border-brand-500/30">
                    <i class="fa-solid fa-handshake mr-2"></i> Mari Berkolaborasi
                </span>
                <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6 leading-tight">
                    Siap Memulai Transformasi Digital <br class="hidden md:block">Bersama Kami?
                </h2>
                <p class="text-lg text-slate-300 mb-10 max-w-2xl mx-auto">
                    Tim ahli kami siap membantu Anda merancang solusi teknologi yang tepat untuk kebutuhan bisnis Anda.
                    Hubungi kami untuk konsultasi gratis.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="mailto:info@jasuindo.co.id"
                        class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-white transition-all duration-200 bg-brand-600 rounded-xl hover:bg-brand-500 hover:shadow-lg hover:shadow-brand-500/30">
                        <i class="fa-solid fa-envelope mr-2"></i> Email Kami
                    </a>
                    <a href="tel:+62318910919"
                        class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-white transition-all duration-200 bg-transparent border-2 border-white/30 rounded-xl hover:bg-white/10 hover:border-white">
                        <i class="fa-solid fa-phone mr-2"></i> +62 31 8910919
                    </a>
                </div>
            </div>
        </div>
    </section>

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
                    <div class="flex items-center space-x-3">
                        <svg class="w-8 h-8" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 20L12 12L19 20L26 12L33 20" stroke="white" stroke-width="3"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M5 28L12 20L19 28" stroke="#0ea5e9" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <span class="text-xl font-bold text-white">JASUINDO</span>
                    </div>

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

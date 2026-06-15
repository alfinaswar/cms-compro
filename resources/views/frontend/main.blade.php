@extends('frontend.index')
@section('content-frontend')
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

@endsection

@extends('frontend.index')
@section('content-frontend')
    <!-- HERO SECTION -->
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop"
                alt="Background" class="w-full h-full object-cover">
        </div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6">About Jasuindo</h1>
                <p class="text-xl text-slate-300">Mitra Terpercaya untuk Transformasi Digital Identitas & Pembayaran di Asia
                </p>
            </div>
        </div>
    </section>

    <!-- COMPANY BRIEF HISTORY -->
    <section id="history" class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="text-brand-600 font-bold tracking-wider uppercase text-sm">Our Journey</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2 mb-6">Company's Brief History</h2>
                    <div class="space-y-4 text-slate-600 leading-relaxed">
                        <p>
                            <strong class="text-slate-900">PT Jasuindo Tiga Perkasa Tbk</strong> didirikan pada tahun
                            <strong>1990</strong> sebagai respons terhadap kebutuhan Indonesia akan sistem identifikasi dan
                            pembayaran yang modern dan terpercaya.
                        </p>
                        <p>
                            Selama lebih dari <strong>3 dekade</strong>, kami telah berkembang dari perusahaan pencetakan
                            dokumen keamanan menjadi pemimpin industri dalam penyediaan solusi teknologi identitas digital
                            dan pembayaran terintegrasi.
                        </p>
                        <p>
                            Kini, dengan lebih dari <strong>800 profesional</strong> yang berdedikasi, Jasuindo melayani
                            lebih dari <strong>100 institusi pemerintah</strong> dan <strong>80+ bank</strong> di seluruh
                            Indonesia dan Asia, menjadi salah satu perusahaan identitas dan pembayaran dengan pertumbuhan
                            tercepat di kawasan ini.
                        </p>
                    </div>

                    <div class="mt-8 grid grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-brand-600">1990</div>
                            <div class="text-sm text-slate-500">Tahun Berdiri</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-brand-600">30+</div>
                            <div class="text-sm text-slate-500">Tahun Pengalaman</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-brand-600">Tbk</div>
                            <div class="text-sm text-slate-500">Perusahaan Publik</div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="absolute -inset-4 bg-brand-200 rounded-3xl transform rotate-3"></div>
                    <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069&auto=format&fit=crop"
                        alt="Office" class="relative rounded-2xl shadow-2xl w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- OUR VALUES -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-brand-600 font-bold tracking-wider uppercase text-sm">What Drives Us</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2 mb-4">Our Values</h2>
                <p class="text-slate-600 text-lg">Nilai-nilai inti yang menjadi fondasi setiap langkah kami dalam melayani
                    pelanggan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <!-- Customer Centricity -->
                <div class="value-card bg-white rounded-2xl p-8 shadow-lg border border-slate-100">
                    <div class="w-16 h-16 bg-brand-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fa-solid fa-users text-3xl text-brand-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Customer Centricity</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Kami menempatkan kebutuhan pelanggan di pusat setiap keputusan bisnis. Tim kami berkomitmen untuk
                        memahami tantangan unik Anda dan memberikan solusi yang benar-benar sesuai.
                    </p>
                </div>

                <!-- Reliability -->
                <div class="value-card bg-white rounded-2xl p-8 shadow-lg border border-slate-100">
                    <div class="w-16 h-16 bg-brand-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fa-solid fa-shield-halved text-3xl text-brand-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Reliability</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Dengan uptime 99.9% dan standar keamanan internasional, kami menjamin layanan yang konsisten dan
                        dapat diandalkan untuk mendukung operasional bisnis Anda 24/7.
                    </p>
                </div>

                <!-- Flexibility -->
                <div class="value-card bg-white rounded-2xl p-8 shadow-lg border border-slate-100">
                    <div class="w-16 h-16 bg-brand-100 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fa-solid fa-sliders text-3xl text-brand-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Flexibility</h3>
                    <p class="text-slate-600 leading-relaxed">
                        Kami memahami bahwa setiap organisasi unik. Itulah mengapa kami menawarkan solusi yang dapat
                        disesuaikan dan diskalakan sesuai dengan pertumbuhan dan kebutuhan spesifik Anda.
                    </p>
                </div>
            </div>

            <!-- Differentiator Text -->
            <div class="bg-gradient-to-br from-brand-900 to-brand-800 rounded-3xl p-8 md:p-12 text-white">
                <div class="max-w-4xl mx-auto">
                    <div class="flex items-start space-x-4 mb-6">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-quote-left text-4xl text-brand-400"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl md:text-3xl font-bold mb-6">Mengapa Memilih Jasuindo?</h3>
                            <div class="space-y-4 text-slate-200 text-lg leading-relaxed">
                                <p>
                                    Bekerja dengan Jasuindo berarti memiliki akses ke <strong>full range of products and
                                        solutions</strong> yang dapat disesuaikan dengan kebutuhan organisasi Anda.
                                </p>
                                <p>
                                    Yang membedakan Jasuindo dari perusahaan lain di industri ini adalah <strong>agility
                                        kami dalam menyesuaikan solusi secara spesifik untuk setiap pelanggan</strong>. Kami
                                    tidak hanya menyediakan produk standar, tetapi merancang solusi yang benar-benar
                                    tailored untuk kebutuhan unik Anda.
                                </p>
                                <p>
                                    Kombinasi dinamis dari <strong>quality, reliability, flexibility</strong> dan
                                    <strong>go-getting spirit</strong> inilah yang menjadikan Jasuindo mitra terpercaya bagi
                                    ratusan institusi pemerintah dan perbankan di Asia.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CORPORATE SOCIAL RESPONSIBILITY -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="order-2 lg:order-1">
                    <div class="grid grid-cols-2 gap-4">
                        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=2070&auto=format&fit=crop"
                            alt="CSR Activity 1" class="rounded-2xl shadow-lg w-full h-64 object-cover">
                        <img src="https://images.unsplash.com/photo-1593113598332-cd288d649433?q=80&w=2070&auto=format&fit=crop"
                            alt="CSR Activity 2" class="rounded-2xl shadow-lg w-full h-64 object-cover mt-8">
                    </div>
                </div>

                <div class="order-1 lg:order-2">
                    <span class="text-brand-600 font-bold tracking-wider uppercase text-sm">Giving Back</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2 mb-6">Corporate Social Responsibility
                    </h2>
                    <div class="space-y-4 text-slate-600 leading-relaxed">
                        <p>
                            Sebagai perusahaan yang tumbuh bersama masyarakat Indonesia, Jasuindo berkomitmen untuk
                            memberikan dampak positif yang berkelanjutan bagi lingkungan dan komunitas di sekitar kami.
                        </p>
                        <p>
                            Program CSR kami berfokus pada tiga pilar utama:
                        </p>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-graduation-cap text-brand-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 mb-1">Pendidikan & Pengembangan SDM</h4>
                                <p class="text-slate-600 text-sm">Beasiswa untuk mahasiswa berprestasi dan program pelatihan
                                    teknologi untuk masyarakat</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-leaf text-brand-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 mb-1">Pelestarian Lingkungan</h4>
                                <p class="text-slate-600 text-sm">Program penanaman pohon, pengelolaan limbah, dan
                                    penggunaan energi terbarukan</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-hand-holding-heart text-brand-600 text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 mb-1">Pemberdayaan Masyarakat</h4>
                                <p class="text-slate-600 text-sm">Bantuan sosial, program kesehatan, dan pengembangan UMKM
                                    lokal</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 p-6 bg-brand-50 rounded-2xl border-l-4 border-brand-600">
                        <p class="text-slate-700 italic">
                            "Kami percaya bahwa kesuksesan bisnis harus sejalan dengan kontribusi positif bagi masyarakat
                            dan lingkungan."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- AWARDS & CERTIFICATIONS -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="text-brand-600 font-bold tracking-wider uppercase text-sm">Recognition</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2 mb-4">Awards & Certifications</h2>
                <p class="text-slate-600 text-lg">
                    Pengakuan atas komitmen kami dalam memberikan layanan berkualitas tinggi dan memenuhi standar
                    internasional
                </p>
            </div>

            <div class="mb-12 bg-white rounded-2xl p-8 shadow-lg">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <i class="fa-solid fa-trophy text-4xl text-yellow-500"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-2">Prestasi dan Pengakuan</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Sepanjang perjalanan kami, Jasuindo telah menerima berbagai penghargaan dan sertifikasi yang
                            mencerminkan dedikasi kami terhadap keunggulan operasional, inovasi teknologi, dan kepatuhan
                            terhadap standar internasional. Pengakuan ini menjadi bukti nyata komitmen kami untuk terus
                            memberikan yang terbaik bagi pelanggan dan stakeholder.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Awards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Award 1 -->
                <div class="award-card bg-white rounded-2xl overflow-hidden shadow-md border border-slate-100">
                    <div class="h-48 bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center">
                        <i class="fa-solid fa-certificate text-6xl text-brand-600"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-3">
                            <span
                                class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">2024</span>
                            <span
                                class="px-3 py-1 bg-brand-100 text-brand-700 text-xs font-bold rounded-full">International</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">ISO 27001:2022</h4>
                        <p class="text-slate-600 text-sm mb-3">Information Security Management System</p>
                        <p class="text-xs text-slate-500">Sertifikasi internasional untuk sistem manajemen keamanan
                            informasi</p>
                    </div>
                </div>

                <!-- Award 2 -->
                <div class="award-card bg-white rounded-2xl overflow-hidden shadow-md border border-slate-100">
                    <div class="h-48 bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center">
                        <i class="fa-solid fa-shield-halved text-6xl text-brand-600"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-3">
                            <span
                                class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">2024</span>
                            <span
                                class="px-3 py-1 bg-brand-100 text-brand-700 text-xs font-bold rounded-full">Quality</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">ISO 9001:2015</h4>
                        <p class="text-slate-600 text-sm mb-3">Quality Management System</p>
                        <p class="text-xs text-slate-500">Standar internasional untuk sistem manajemen mutu</p>
                    </div>
                </div>

                <!-- Award 3 -->
                <div class="award-card bg-white rounded-2xl overflow-hidden shadow-md border border-slate-100">
                    <div class="h-48 bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center">
                        <i class="fa-solid fa-credit-card text-6xl text-brand-600"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-3">
                            <span
                                class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">2024</span>
                            <span
                                class="px-3 py-1 bg-brand-100 text-brand-700 text-xs font-bold rounded-full">Security</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">PCI-DSS Level 1</h4>
                        <p class="text-slate-600 text-sm mb-3">Payment Card Industry Data Security Standard</p>
                        <p class="text-xs text-slate-500">Sertifikasi tertinggi untuk keamanan data transaksi kartu
                            pembayaran</p>
                    </div>
                </div>

                <!-- Award 4 -->
                <div class="award-card bg-white rounded-2xl overflow-hidden shadow-md border border-slate-100">
                    <div class="h-48 bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center">
                        <i class="fa-solid fa-award text-6xl text-brand-600"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-3">
                            <span
                                class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">2023</span>
                            <span
                                class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold rounded-full">Award</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">Best IT Solution Provider</h4>
                        <p class="text-slate-600 text-sm mb-3">Indonesia Technology Excellence Awards</p>
                        <p class="text-xs text-slate-500">Penghargaan untuk penyedia solusi teknologi terbaik di Indonesia
                        </p>
                    </div>
                </div>

                <!-- Award 5 -->
                <div class="award-card bg-white rounded-2xl overflow-hidden shadow-md border border-slate-100">
                    <div class="h-48 bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center">
                        <i class="fa-solid fa-building-shield text-6xl text-brand-600"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-3">
                            <span
                                class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">2023</span>
                            <span
                                class="px-3 py-1 bg-brand-100 text-brand-700 text-xs font-bold rounded-full">Compliance</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">BSI Certified</h4>
                        <p class="text-slate-600 text-sm mb-3">British Standards Institution</p>
                        <p class="text-xs text-slate-500">Sertifikasi dari lembaga standar internasional terkemuka</p>
                    </div>
                </div>

                <!-- Award 6 -->
                <div class="award-card bg-white rounded-2xl overflow-hidden shadow-md border border-slate-100">
                    <div class="h-48 bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center">
                        <i class="fa-solid fa-globe text-6xl text-brand-600"></i>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-2 mb-3">
                            <span
                                class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">2024</span>
                            <span
                                class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">Government</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 mb-2">Tersertifikasi Kominfo</h4>
                        <p class="text-slate-600 text-sm mb-3">Kementerian Komunikasi dan Informatika RI</p>
                        <p class="text-xs text-slate-500">Sertifikasi penyelenggara sistem elektronik dari pemerintah
                            Indonesia</p>
                    </div>
                </div>

            </div>

            <!-- Additional Note -->
            <div class="mt-12 text-center">
                <p class="text-slate-500 text-sm">
                    <i class="fa-solid fa-info-circle mr-2"></i>
                    Dan berbagai penghargaan lainnya yang terus kami raih sebagai bentuk komitmen terhadap excellence
                </p>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="py-20 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-950 relative overflow-hidden">
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>
        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6">Siap Berkolaborasi?</h2>
                <p class="text-lg text-slate-300 mb-10 max-w-2xl mx-auto">
                    Mari diskusikan bagaimana Jasuindo dapat membantu transformasi digital organisasi Anda dengan solusi
                    yang tailored dan terpercaya.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="index.html#kontak"
                        class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-white transition-all bg-brand-600 rounded-xl hover:bg-brand-500 hover:shadow-lg">
                        Hubungi Kami Sekarang
                        <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                    <a href="#history"
                        class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-white transition-all bg-transparent border-2 border-white/30 rounded-xl hover:bg-white/10">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

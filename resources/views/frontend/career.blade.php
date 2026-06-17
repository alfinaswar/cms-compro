@extends('frontend.index')

@section('content-frontend')

    <style>
        /* Job Card Hover Effect */
        .job-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .job-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .job-card:hover .job-card-arrow {
            transform: translateX(4px);
        }

        /* Custom Select Styling */
        .custom-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }

        /* Badge Animation */
        .badge-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .7;
            }
        }

        /* Pagination */
        .page-link {
            transition: all 0.2s ease;
        }

        .page-link:hover:not(.active):not(.disabled) {
            background-color: #f0f9ff;
            color: #0284c7;
            transform: translateY(-2px);
        }

        .page-link.active {
            background: linear-gradient(135deg, #0284c7, #0ea5e9);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(2, 132, 199, 0.3);
        }

        .page-link.disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }
    </style>

    <!-- ========================================== -->
    <!-- HERO / BREADCRUMB SECTION -->
    <!-- ========================================== -->
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=2070&auto=format&fit=crop"
                alt="Team Background" class="w-full h-full object-cover">
        </div>
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>
        <div
            class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <span
                    class="inline-block py-1.5 px-4 rounded-full bg-brand-500/20 text-brand-100 text-sm font-semibold tracking-wide mb-6 border border-brand-500/30 backdrop-blur-sm">
                    <i class="fa-solid fa-briefcase mr-2"></i> Join Our Team
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                    Bangun Karir Bersama <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-cyan-300">Jasuindo</span>
                </h1>
                <p class="text-xl text-slate-300 max-w-2xl mx-auto">
                    Bergabunglah dengan 800+ profesional terbaik dan jadilah bagian dari transformasi digital Indonesia
                </p>

                <!-- Breadcrumb -->
                <nav class="mt-8 flex items-center justify-center space-x-2 text-sm text-slate-300">
                    <a href="{{ url('/') }}" class="hover:text-white transition-colors">
                        <i class="fa-solid fa-house mr-1"></i> Home
                    </a>
                    <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                    <span class="text-white font-semibold">Career</span>
                </nav>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- STATS BAR -->
    <!-- ========================================== -->
    <section class="relative -mt-10 z-20">
        <div class="container mx-auto px-6">
            <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 md:p-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-brand-50 rounded-xl mb-3">
                            <i class="fa-solid fa-briefcase text-brand-600 text-xl"></i>
                        </div>
                        <div class="text-3xl font-extrabold text-slate-900">{{ $totalJobs }}</div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Open Positions</div>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-green-50 rounded-xl mb-3">
                            <i class="fa-solid fa-map-location-dot text-green-600 text-xl"></i>
                        </div>
                        <div class="text-3xl font-extrabold text-slate-900">{{ count($kotas) }}</div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Cities</div>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-purple-50 rounded-xl mb-3">
                            <i class="fa-solid fa-users text-purple-600 text-xl"></i>
                        </div>
                        <div class="text-3xl font-extrabold text-slate-900">800+</div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Employees</div>
                    </div>
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-yellow-50 rounded-xl mb-3">
                            <i class="fa-solid fa-award text-yellow-600 text-xl"></i>
                        </div>
                        <div class="text-3xl font-extrabold text-slate-900">30+</div>
                        <div class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Years</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- FILTER & SEARCH SECTION -->
    <!-- ========================================== -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-6">
            <div class="bg-slate-50 rounded-2xl p-6 md:p-8 border border-slate-100">
                <div class="flex flex-col lg:flex-row gap-4 items-stretch lg:items-center">

                    <!-- Search Input -->
                    <form method="GET" action="{{ url('career') }}" class="flex-1 flex flex-col sm:flex-row gap-3">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari posisi, deskripsi, atau keyword..."
                                class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all">
                        </div>

                        <!-- Hidden fields to preserve other filters -->
                        @if (request('kota'))
                            <input type="hidden" name="kota" value="{{ request('kota') }}">
                        @endif
                        @if (request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        <!-- City Filter -->
                        <div class="relative sm:w-56">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-location-dot text-slate-400"></i>
                            </div>
                            <select name="kota" onchange="this.form.submit()"
                                class="custom-select w-full pl-11 pr-10 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all cursor-pointer">
                                <option value="">All Cities</option>
                                @foreach ($kotas as $kota)
                                    <option value="{{ $kota }}" {{ request('kota') == $kota ? 'selected' : '' }}>
                                        {{ $kota }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort Filter -->
                        <div class="relative sm:w-56">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-arrow-down-wide-short text-slate-400"></i>
                            </div>
                            <select name="sort" onchange="this.form.submit()"
                                class="custom-select w-full pl-11 pr-10 py-3 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none transition-all cursor-pointer">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest Jobs
                                </option>
                                <option value="deadline" {{ request('sort') == 'deadline' ? 'selected' : '' }}>Deadline
                                    Soon</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First
                                </option>
                            </select>
                        </div>
                    </form>

                    <!-- Reset Button -->
                    @if (request()->hasAny(['search', 'kota', 'sort']))
                        <a href="{{ url('career') }}"
                            class="inline-flex items-center justify-center px-5 py-3 bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 rounded-xl font-medium transition-all whitespace-nowrap">
                            <i class="fa-solid fa-rotate-left mr-2"></i>
                            Reset
                        </a>
                    @endif
                </div>

                <!-- Active Filters Display -->
                @if (request()->hasAny(['search', 'kota']))
                    <div class="mt-4 flex flex-wrap items-center gap-2 text-sm">
                        <span class="text-slate-500">Active filters:</span>
                        @if (request('search'))
                            <span
                                class="inline-flex items-center px-3 py-1 bg-brand-100 text-brand-700 rounded-full font-medium">
                                <i class="fa-solid fa-magnifying-glass mr-1.5 text-xs"></i>
                                "{{ request('search') }}"
                                <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}"
                                    class="ml-2 hover:text-brand-900">
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                </a>
                            </span>
                        @endif
                        @if (request('kota'))
                            <span
                                class="inline-flex items-center px-3 py-1 bg-brand-100 text-brand-700 rounded-full font-medium">
                                <i class="fa-solid fa-location-dot mr-1.5 text-xs"></i>
                                {{ request('kota') }}
                                <a href="{{ request()->fullUrlWithQuery(['kota' => null]) }}"
                                    class="ml-2 hover:text-brand-900">
                                    <i class="fa-solid fa-xmark text-xs"></i>
                                </a>
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Result Count -->
            <div class="mt-6 flex items-center justify-between">
                <p class="text-slate-600">
                    Menampilkan <strong class="text-slate-900">{{ $lowongans->total() }}</strong> lowongan
                    @if (request('search') || request('kota'))
                        ditemukan
                    @else
                        tersedia untuk Anda
                    @endif
                </p>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- JOB LISTINGS -->
    <!-- ========================================== -->
    <section class="pb-20 bg-white">
        <div class="container mx-auto px-6">

            @forelse($lowongans as $lowongan)
                <div class="job-card bg-white border border-slate-200 rounded-2xl p-6 md:p-8 mb-4 hover:border-brand-300">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-6">

                        <!-- Logo & Info -->
                        <div class="flex items-start lg:items-center gap-4 flex-1">
                            <!-- Company Logo -->
                            <div class="flex-shrink-0">
                                <div
                                    class="w-16 h-16 bg-gradient-to-br from-brand-500 to-brand-700 rounded-2xl flex items-center justify-center shadow-lg">
                                    <img src="{{ asset('assets/img/career/career-logo.jpg') }}"
                                        alt="{{ $lowongan->Posisi }}"
                                        class="w-12 h-12 object-contain rounded-lg bg-white p-1"
                                        onerror="this.outerHTML='<i class=\'fa-solid fa-building text-white text-2xl\'></i>'">
                                </div>
                            </div>

                            <!-- Job Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 mb-2">
                                    <span class="text-sm font-semibold text-brand-600">Jasuindo</span>
                                    @if ($lowongan->masih_berlaku)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 badge-pulse"></span>
                                            OPEN
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 bg-slate-100 text-slate-600 text-xs font-bold rounded-full">
                                            CLOSED
                                        </span>
                                    @endif
                                </div>

                                <h3 class="text-xl md:text-2xl font-bold text-slate-900 mb-2 group-hover:text-brand-600">
                                    {{ $lowongan->Posisi }}
                                </h3>

                                <div class="flex flex-wrap items-center gap-4 text-sm text-slate-500">
                                    <span class="inline-flex items-center">
                                        <i class="fa-solid fa-location-dot mr-1.5 text-brand-500"></i>
                                        {{ $lowongan->Kota }}
                                    </span>
                                    <span class="inline-flex items-center">
                                        <i class="fa-regular fa-clock mr-1.5 text-brand-500"></i>
                                        Full-time
                                    </span>
                                    <span class="inline-flex items-center">
                                        <i class="fa-regular fa-calendar mr-1.5 text-brand-500"></i>
                                        Posted {{ $lowongan->BatasWaktuFormatted }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Deadline & CTA -->
                        <div
                            class="flex flex-col sm:flex-row lg:flex-col lg:items-end gap-4 lg:border-l lg:border-slate-200 lg:pl-6">
                            <!-- Deadline Info -->
                            <div class="text-left lg:text-right">
                                <div class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">Deadline
                                </div>
                                <div class="text-sm font-bold text-slate-900">
                                    @php
                                        $daysLeft = \Carbon\Carbon::now()->diffInDays(
                                            \Carbon\Carbon::parse($lowongan->BatasWaktu),
                                            false,
                                        );
                                    @endphp
                                    @if ($lowongan->masih_berlaku)
                                        @if ($daysLeft <= 7)
                                            <span class="text-red-600">
                                                <i class="fa-solid fa-fire text-orange-500 mr-1"></i>
                                                {{ $daysLeft }} hari lagi
                                            </span>
                                        @elseif ($daysLeft <= 30)
                                            <span class="text-yellow-600">
                                                <i class="fa-regular fa-clock mr-1"></i>
                                                {{ $daysLeft }} hari lagi
                                            </span>
                                        @else
                                            <span class="text-green-600">
                                                <i class="fa-regular fa-calendar-check mr-1"></i>
                                                {{ $daysLeft }} hari lagi
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-slate-400">Expired</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Apply Button -->
                            <a href="{{ route('frontend.career.detail', ['id' => $lowongan->id, 'slug' => $lowongan->slug]) }}"
                                class="inline-flex items-center justify-center px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-xl transition-all shadow-md hover:shadow-lg {{ !$lowongan->masih_berlaku ? 'opacity-50 cursor-not-allowed pointer-events-none' : '' }}">
                                Apply Now
                                <i class="fa-solid fa-arrow-right ml-2 job-card-arrow transition-transform"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Description Preview -->
                    @if ($lowongan->Deskripsi)
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <p class="text-slate-600 text-sm leading-relaxed">
                                {{ Str::limit(strip_tags($lowongan->Deskripsi), 180) }}
                            </p>
                        </div>
                    @endif
                </div>
            @empty
                <!-- Empty State -->
                <div class="text-center py-20 bg-slate-50 rounded-2xl border border-slate-100">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-brand-100 rounded-full mb-6">
                        <i class="fa-regular fa-folder-open text-4xl text-brand-600"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">Belum Ada Lowongan</h3>
                    <p class="text-slate-600 mb-6 max-w-md mx-auto">
                        Saat ini belum ada posisi yang tersedia. Silakan cek kembali nanti atau coba filter yang berbeda.
                    </p>
                    <a href="{{ url('career') }}"
                        class="inline-flex items-center px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-xl transition-all shadow-md">
                        <i class="fa-solid fa-rotate-left mr-2"></i>
                        Reset Filter
                    </a>
                </div>
            @endforelse

            <!-- ========================================== -->
            <!-- PAGINATION -->
            <!-- ========================================== -->
            @if ($lowongans->hasPages())
                <div class="mt-12 flex justify-center">
                    <nav class="inline-flex items-center space-x-1">
                        {{-- Previous --}}
                        @if ($lowongans->onFirstPage())
                            <span
                                class="page-link disabled inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white border border-slate-200 text-slate-400">
                                <i class="fa-solid fa-chevron-left text-sm"></i>
                            </span>
                        @else
                            <a href="{{ $lowongans->previousPageUrl() }}"
                                class="page-link inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white border border-slate-200 text-slate-700 hover:border-brand-500">
                                <i class="fa-solid fa-chevron-left text-sm"></i>
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($lowongans->getUrlRange(1, $lowongans->lastPage()) as $page => $url)
                            @if ($page == $lowongans->currentPage())
                                <span
                                    class="page-link active inline-flex items-center justify-center w-10 h-10 rounded-lg font-semibold">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="page-link inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white border border-slate-200 text-slate-700 font-medium hover:border-brand-500">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($lowongans->hasMorePages())
                            <a href="{{ $lowongans->nextPageUrl() }}"
                                class="page-link inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white border border-slate-200 text-slate-700 hover:border-brand-500">
                                <i class="fa-solid fa-chevron-right text-sm"></i>
                            </a>
                        @else
                            <span
                                class="page-link disabled inline-flex items-center justify-center w-10 h-10 rounded-lg bg-white border border-slate-200 text-slate-400">
                                <i class="fa-solid fa-chevron-right text-sm"></i>
                            </span>
                        @endif
                    </nav>
                </div>
            @endif
        </div>
    </section>

    <!-- ========================================== -->
    <!-- WHY JOIN US SECTION -->
    <!-- ========================================== -->
    <section class="py-20 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-950 relative overflow-hidden">
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>
        <div
            class="absolute bottom-0 left-0 w-96 h-96 bg-cyan-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span
                    class="inline-block py-1.5 px-4 rounded-full bg-brand-500/20 text-brand-100 text-sm font-semibold tracking-wide mb-4 border border-brand-500/30">
                    Why Join Us
                </span>
                <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-4">
                    Mengapa Bergabung dengan Jasuindo?
                </h2>
                <p class="text-lg text-slate-300">
                    Kami menawarkan lebih dari sekadar pekerjaan - kami menawarkan karir yang berkembang
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Benefit 1 -->
                <div
                    class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all">
                    <div class="w-14 h-14 bg-brand-500/20 rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-rocket text-2xl text-brand-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Career Growth</h3>
                    <p class="text-slate-300 text-sm">Jenjang karir yang jelas dengan program pengembangan berkelanjutan
                    </p>
                </div>

                <!-- Benefit 2 -->
                <div
                    class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all">
                    <div class="w-14 h-14 bg-brand-500/20 rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-graduation-cap text-2xl text-brand-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Learning & Development</h3>
                    <p class="text-slate-300 text-sm">Akses ke pelatihan dan sertifikasi internasional</p>
                </div>

                <!-- Benefit 3 -->
                <div
                    class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all">
                    <div class="w-14 h-14 bg-brand-500/20 rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-heart-pulse text-2xl text-brand-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Health & Wellness</h3>
                    <p class="text-slate-300 text-sm">Asuransi kesehatan komprehensif untuk Anda dan keluarga</p>
                </div>

                <!-- Benefit 4 -->
                <div
                    class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all">
                    <div class="w-14 h-14 bg-brand-500/20 rounded-xl flex items-center justify-center mb-4">
                        <i class="fa-solid fa-users text-2xl text-brand-400"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Great Culture</h3>
                    <p class="text-slate-300 text-sm">Lingkungan kerja kolaboratif, inovatif, dan suportif</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- CTA SECTION -->
    <!-- ========================================== -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div
                class="bg-gradient-to-r from-brand-600 to-brand-700 rounded-3xl p-8 md:p-12 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full -ml-32 -mb-32"></div>

                <div class="relative z-10 max-w-2xl mx-auto">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">
                        Tidak Menemukan Posisi yang Cocok?
                    </h2>
                    <p class="text-lg text-brand-100 mb-8">
                        Kirim CV Anda dan kami akan menghubungi ketika ada posisi yang sesuai dengan kualifikasi Anda
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="mailto:hrd@jasuindo.co.id"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white text-brand-700 font-bold rounded-xl hover:bg-brand-50 transition-all shadow-lg">
                            <i class="fa-solid fa-envelope mr-2"></i>
                            Send Your CV
                        </a>
                        <a href="{{ url('/') }}#kontak"
                            class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-xl hover:bg-white/10 transition-all">
                            <i class="fa-solid fa-phone mr-2"></i>
                            Contact HR
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

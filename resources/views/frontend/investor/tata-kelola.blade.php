@extends('frontend.index')

@section('content-frontend')
    @include('frontend.investor.partials.hero-tabs')

    <!-- ========================================== -->
    <!-- MAIN CONTENT SECTION -->
    <!-- ========================================== -->
    <section class="py-12 bg-[#f8f9ff]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

                <!-- ========================================== -->
                <!-- LEFT STICKY SIDEBAR -->
                <!-- ========================================== -->
                <div class="lg:col-span-4 xl:col-span-3 space-y-6">
                    <!-- Sticky Navigation Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 p-5 sticky top-36">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                            <span class="text-[11px] font-bold text-slate-500 tracking-wider uppercase">
                                Pada Halaman Ini
                            </span>
                            <i class="fa-solid fa-bars-staggered text-slate-400 text-xs"></i>
                        </div>

                        <nav class="space-y-1.5" id="tata-kelola-nav">
                            <a href="#bagan-manajemen"
                                class="flex items-start gap-3 p-2.5 rounded-lg bg-blue-50 text-[#0051d5] font-semibold text-xs transition-colors sidebar-nav-link"
                                data-target="bagan-manajemen">
                                <span class="text-xs font-bold w-5">01</span>
                                <div>
                                    <p class="text-xs font-bold leading-tight">Bagan &amp; Manajemen</p>
                                    <p class="text-[11px] font-normal text-slate-500 mt-0.5">Hierarki korporasi &amp; dewan
                                    </p>
                                </div>
                            </a>

                            <a href="#dokumen-gcg"
                                class="flex items-start gap-3 p-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-xs transition-colors sidebar-nav-link"
                                data-target="dokumen-gcg">
                                <span class="text-xs font-bold text-slate-400 w-5">02</span>
                                <div>
                                    <p class="text-xs font-semibold leading-tight">Piagam, Kebijakan &amp; Regulasi</p>
                                    <p class="text-[11px] font-normal text-slate-500 mt-0.5">Pedoman GCG &amp; operasional
                                    </p>
                                </div>
                            </a>

                            <a href="#rups"
                                class="flex items-start gap-3 p-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-xs transition-colors sidebar-nav-link"
                                data-target="rups">
                                <span class="text-xs font-bold text-slate-400 w-5">03</span>
                                <div>
                                    <p class="text-xs font-semibold leading-tight">RUPS &amp; Risalah</p>
                                    <p class="text-[11px] font-normal text-slate-500 mt-0.5">Keterbukaan rapat tahunan</p>
                                </div>
                            </a>

                            <a href="#komite-wbs"
                                class="flex items-start gap-3 p-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-xs transition-colors sidebar-nav-link"
                                data-target="komite-wbs">
                                <span class="text-xs font-bold text-slate-400 w-5">04</span>
                                <div>
                                    <p class="text-xs font-semibold leading-tight">Komite Audit &amp; WBS</p>
                                    <p class="text-[11px] font-normal text-slate-500 mt-0.5">Pengawasan &amp; pengaduan</p>
                                </div>
                            </a>
                        </nav>

                        <!-- Contact Corporate Secretary Box -->
                        <div
                            class="mt-6 pt-4 border-t border-slate-100 bg-slate-50 rounded-xl p-3.5 text-xs text-slate-700">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">
                                Sekretariat Perusahaan
                            </span>
                            <p class="text-[11px] text-slate-500 mb-2 leading-relaxed">
                                Hubungi Corporate Secretary untuk informasi GCG dan relasi investor:
                            </p>
                            <div class="space-y-1.5 text-xs">
                                <a href="mailto:{{ $bagan->EmailSekretariat }}"
                                    class="flex items-center gap-2 text-[#0051d5] font-semibold hover:underline">
                                    <i class="fa-regular fa-envelope text-[11px]"></i> {{ $bagan->EmailSekretariat }}
                                </a>
                                <p class="flex items-center gap-2 text-slate-600">
                                    <i class="fa-solid fa-phone text-[11px] text-slate-400"></i>
                                    {{ $bagan->TeleponSekretariat }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- RIGHT CONTENT AREA -->
                <!-- ========================================== -->
                <div class="lg:col-span-8 xl:col-span-9 space-y-12">

                    <!-- ------------------------------------------ -->
                    <!-- SECTION 01: BAGAN & MANAJEMEN PERSEROAN -->
                    <!-- ------------------------------------------ -->
                    <section id="bagan-manajemen" class="scroll-mt-32">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                            <div>
                                <span
                                    class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                    Hierarki Korporasi
                                </span>
                                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                                    Bagan Struktur Organisasi
                                </h2>
                                <p class="text-xs md:text-sm text-slate-500 mt-1 max-w-2xl">
                                    {{ $bagan->Keterangan ?? 'Memastikan efektivitas pembagian tugas yang terarah, akuntabilitas yang jelas, serta pemisahan independen antara fungsi pengawasan dan fungsi eksekutif.' }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2 self-start">
                                @if ($bagan->TanggalDiperbarui)
                                    <span
                                        class="text-[11px] font-medium text-slate-500 bg-slate-100 px-3 py-1.5 rounded-lg whitespace-nowrap">
                                        <i class="fa-regular fa-calendar mr-1"></i> Diperbarui:
                                        {{ $bagan->TanggalDiperbarui->format('d M Y') }}
                                    </span>
                                @endif
                                @if ($bagan->PathFilePdf)
                                    <a href="{{ asset('storage/' . $bagan->PathFilePdf) }}" target="_blank"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white hover:bg-slate-50 text-[#0051d5] font-semibold text-xs rounded-lg border border-slate-200 shadow-sm transition-colors whitespace-nowrap">
                                        <i class="fa-solid fa-download text-xs"></i> Unduh PDF
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Bagan Container -->
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80 mb-8">
                            @if ($bagan->PathGambar)
                                <div class="w-full rounded-xl overflow-hidden border border-slate-100">
                                    <img src="{{ asset('storage/' . $bagan->PathGambar) }}" alt="Bagan Struktur Organisasi"
                                        class="w-full h-auto object-contain max-h-[500px] mx-auto">
                                </div>
                            @else
                                <!-- Default Aesthetic Structure Diagram -->
                                <div class="p-6 bg-slate-50/60 rounded-xl border border-slate-100 text-center">
                                    <!-- Top: RUPS -->
                                    <div class="max-w-xs mx-auto bg-[#0a557a] text-white p-3.5 rounded-xl shadow-sm mb-4">
                                        <span
                                            class="text-[10px] uppercase tracking-widest text-sky-200 block font-bold">Kekuasaan
                                            Tertinggi</span>
                                        <h4 class="font-bold text-sm">RAPAT UMUM PEMEGANG SAHAM (RUPS)</h4>
                                    </div>
                                    <div class="w-0.5 h-6 bg-slate-300 mx-auto"></div>

                                    <!-- Dual Pillars: Dewan Komisaris & Direksi -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl mx-auto my-2">
                                        <!-- Pengawasan -->
                                        <div class="bg-sky-50 border border-sky-200 p-4 rounded-xl text-left">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="text-[10px] font-bold text-sky-700 uppercase">Fungsi
                                                    Pengawasan</span>
                                                <span
                                                    class="text-[10px] bg-sky-200 text-sky-900 px-2 py-0.5 rounded font-bold">Independen</span>
                                            </div>
                                            <h4 class="font-bold text-slate-900 text-sm">DEWAN KOMISARIS</h4>
                                            <p class="text-[11px] text-slate-500 mt-1">Komisaris Utama &amp; Komisaris
                                                Independen</p>
                                            <div class="mt-2 pt-2 border-t border-sky-100 text-[11px] text-sky-800">
                                                &bull; Komite Audit &bull; Nominasi &amp; Remunerasi
                                            </div>
                                        </div>

                                        <!-- Eksekutif -->
                                        <div class="bg-[#0b1c30] text-white p-4 rounded-xl text-left">
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="text-[10px] font-bold text-sky-300 uppercase">Fungsi
                                                    Eksekutif</span>
                                                <span
                                                    class="text-[10px] bg-slate-800 text-slate-200 px-2 py-0.5 rounded font-bold">Operasional</span>
                                            </div>
                                            <h4 class="font-bold text-white text-sm">DIREKSI PERSEROAN</h4>
                                            <p class="text-[11px] text-slate-300 mt-1">Direktur Utama &amp; Jajaran Direktur
                                            </p>
                                            <div class="mt-2 pt-2 border-t border-slate-700 text-[11px] text-slate-300">
                                                &bull; Satuan Audit Internal &bull; Sekretaris Perusahaan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- -------------------------------------- -->
                        <!-- SUB-SECTION: MANAJEMEN PERSEROAN -->
                        <!-- -------------------------------------- -->
                        <div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                                <div>
                                    <span
                                        class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                        Struktur Kepemimpinan
                                    </span>
                                    <h3 class="text-xl font-bold text-slate-900 mt-1">
                                        Manajemen Perseroan
                                    </h3>
                                </div>

                                <!-- Tabs Toggle: Dewan Komisaris vs Direksi -->
                                <div class="flex gap-1.5 bg-slate-100 p-1 rounded-xl self-start">
                                    <button type="button" id="tab-komisaris-btn"
                                        class="px-3.5 py-1.5 rounded-lg text-xs font-bold bg-white text-[#0051d5] shadow-sm transition-all">
                                        Dewan Komisaris ({{ $komisaris->count() }})
                                    </button>
                                    <button type="button" id="tab-direksi-btn"
                                        class="px-3.5 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:text-slate-900 transition-all">
                                        Direksi Perseroan ({{ $direksi->count() }})
                                    </button>
                                </div>
                            </div>

                            <!-- Dewan Komisaris Grid -->
                            <div id="grid-komisaris" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @foreach ($komisaris as $person)
                                    <div
                                        class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 flex flex-col justify-between hover:shadow-md transition-shadow">
                                        <div>
                                            <div class="flex items-center gap-3 mb-3">
                                                @if ($person->Foto)
                                                    <img src="{{ asset('storage/' . $person->Foto) }}"
                                                        alt="{{ $person->Nama }}"
                                                        class="w-12 h-12 rounded-full object-cover border border-slate-200">
                                                @else
                                                    <div
                                                        class="w-12 h-12 rounded-full bg-blue-100 text-[#0051d5] font-bold flex items-center justify-center text-sm">
                                                        {{ strtoupper(substr($person->Nama, 0, 2)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <h4 class="font-bold text-slate-900 text-sm leading-tight">
                                                        {{ $person->Nama }}</h4>
                                                    <span
                                                        class="text-[11px] font-bold text-[#0051d5] uppercase tracking-wider block mt-0.5">
                                                        {{ $person->Jabatan }}
                                                    </span>
                                                </div>
                                            </div>
                                            <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed mb-4">
                                                {{ $person->DeskripsiSingkat }}
                                            </p>
                                        </div>
                                        <button type="button"
                                            class="btn-profil-modal inline-flex items-center gap-1.5 text-xs font-bold text-[#0051d5] hover:underline pt-3 border-t border-slate-100"
                                            data-nama="{{ $person->Nama }}" data-jabatan="{{ $person->Jabatan }}"
                                            data-kategori="{{ $person->Kategori }}"
                                            data-foto="{{ $person->Foto ? asset('storage/' . $person->Foto) : '' }}"
                                            data-bio="{{ $person->ProfilLengkap ?? $person->DeskripsiSingkat }}">
                                            Baca Profil Lengkap <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Direksi Perseroan Grid (Hidden by default, shown on tab click) -->
                            <div id="grid-direksi" class="grid grid-cols-1 md:grid-cols-3 gap-4 hidden">
                                @foreach ($direksi as $person)
                                    <div
                                        class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 flex flex-col justify-between hover:shadow-md transition-shadow">
                                        <div>
                                            <div class="flex items-center gap-3 mb-3">
                                                @if ($person->Foto)
                                                    <img src="{{ asset('storage/' . $person->Foto) }}"
                                                        alt="{{ $person->Nama }}"
                                                        class="w-12 h-12 rounded-full object-cover border border-slate-200">
                                                @else
                                                    <div
                                                        class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center text-sm">
                                                        {{ strtoupper(substr($person->Nama, 0, 2)) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <h4 class="font-bold text-slate-900 text-sm leading-tight">
                                                        {{ $person->Nama }}</h4>
                                                    <span
                                                        class="text-[11px] font-bold text-emerald-700 uppercase tracking-wider block mt-0.5">
                                                        {{ $person->Jabatan }}
                                                    </span>
                                                </div>
                                            </div>
                                            <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed mb-4">
                                                {{ $person->DeskripsiSingkat }}
                                            </p>
                                        </div>
                                        <button type="button"
                                            class="btn-profil-modal inline-flex items-center gap-1.5 text-xs font-bold text-[#0051d5] hover:underline pt-3 border-t border-slate-100"
                                            data-nama="{{ $person->Nama }}" data-jabatan="{{ $person->Jabatan }}"
                                            data-kategori="{{ $person->Kategori }}"
                                            data-foto="{{ $person->Foto ? asset('storage/' . $person->Foto) : '' }}"
                                            data-bio="{{ $person->ProfilLengkap ?? $person->DeskripsiSingkat }}">
                                            Baca Profil Lengkap <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <!-- ------------------------------------------ -->
                    <!-- SECTION 02: DOKUMEN TATA KELOLA & REGULASI -->
                    <!-- ------------------------------------------ -->
                    <section id="dokumen-gcg" class="scroll-mt-32">
                        <div class="mb-4">
                            <span
                                class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                Regulasi &amp; Piagam Tata Kelola
                            </span>
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                                Dokumen Tata Kelola Perusahaan
                            </h2>
                            <p class="text-xs md:text-sm text-slate-500 mt-1">
                                Mendorong pola hubungan, sistem, dan mekanisme kerja korporat yang transparan, akuntabel,
                                dan sesuai undang-undang pasar modal serta standar OJK.
                            </p>
                        </div>

                        <!-- Dokumen GCG Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                            @foreach ($dokumenGcg as $doc)
                                <div
                                    class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex flex-col justify-between hover:border-[#0099ff] hover:shadow-md transition-all">
                                    <div>
                                        <div class="flex items-start justify-between mb-3">
                                            <div
                                                class="w-9 h-9 rounded-lg bg-blue-50 text-[#0051d5] flex items-center justify-center text-sm">
                                                <i class="fa-solid fa-file-shield"></i>
                                            </div>
                                            @if ($doc->FileSize)
                                                <span
                                                    class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded">
                                                    PDF ({{ $doc->FileSize }})
                                                </span>
                                            @endif
                                        </div>
                                        <h4 class="font-bold text-slate-900 text-sm leading-snug mb-1">
                                            {{ $doc->Judul }}
                                        </h4>
                                        @if ($doc->Deskripsi)
                                            <p class="text-xs text-slate-500 mb-4 line-clamp-2">
                                                {{ $doc->Deskripsi }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="pt-3 border-t border-slate-100 flex items-center justify-end">
                                        @if ($doc->PathFile)
                                            <a href="{{ asset('storage/' . $doc->PathFile) }}" target="_blank"
                                                class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0051d5] hover:text-blue-800 transition-colors">
                                                <i class="fa-solid fa-download text-xs"></i> Unduh
                                            </a>
                                        @else
                                            <span class="text-[11px] text-slate-400 italic">Segera Hadir</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Kebijakan Operasional Accordion Cards -->
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
                            <h3 class="text-base font-bold text-slate-900 mb-4">
                                Kebijakan Operasional, Risiko &amp; Mitra Usaha
                            </h3>

                            <div class="space-y-3">
                                @foreach ($kebijakan as $idx => $keb)
                                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                                        <button type="button"
                                            class="accordion-btn w-full p-4 text-left font-bold text-xs md:text-sm text-slate-800 flex items-center justify-between hover:bg-slate-50 transition-colors">
                                            <div class="flex items-center gap-3">
                                                <i class="fa-solid fa-shield-halved text-[#0051d5]"></i>
                                                <span>{{ $keb->Judul }}</span>
                                            </div>
                                            <i
                                                class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform duration-200 accordion-icon"></i>
                                        </button>
                                        <div
                                            class="accordion-content px-4 pb-4 text-xs text-slate-600 border-t border-slate-100 pt-3 hidden">
                                            <p class="leading-relaxed mb-3">
                                                {{ $keb->Deskripsi ?? 'Pedoman dan standar tata kelola operasional perseroan diterapkan secara ketat guna memitigasi risiko finansial maupun reputasional.' }}
                                            </p>
                                            @if ($keb->PathFile)
                                                <a href="{{ asset('storage/' . $keb->PathFile) }}" target="_blank"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-50 text-[#0051d5] font-semibold text-xs hover:bg-blue-100 transition-colors">
                                                    <i class="fa-solid fa-file-pdf"></i> Lihat Pedoman Lengkap (PDF)
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>

                    <!-- ------------------------------------------ -->
                    <!-- SECTION 03: RUPS & RISALAH -->
                    <!-- ------------------------------------------ -->
                    <section id="rups" class="scroll-mt-32">
                        <div class="mb-4">
                            <span
                                class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                Keterbukaan RUPS
                            </span>
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                                Rapat Umum Pemegang Saham (RUPS)
                            </h2>
                        </div>

                        <!-- Year Tabs Navigation -->
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
                            <div
                                class="flex items-center gap-2 overflow-x-auto pb-3 border-b border-slate-100 mb-6 no-scrollbar">
                                <span
                                    class="text-xs font-bold text-slate-400 mr-2 uppercase tracking-wider whitespace-nowrap">
                                    PILIH TAHUN BUKU:
                                </span>
                                @foreach ($rupsTahun as $th)
                                    <a href="?tahun_rups={{ $th }}#rups"
                                        class="px-4 py-1.5 rounded-lg text-xs font-bold whitespace-nowrap transition-colors {{ $selectedTahun == $th ? 'bg-[#0099ff] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                        {{ $th }}
                                    </a>
                                @endforeach
                            </div>

                            <!-- Documents List for Selected Year -->
                            <div class="space-y-3">
                                <div
                                    class="flex items-center justify-between text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                                    <span>Berkas Dokumen RUPS Tahun {{ $selectedTahun }}</span>
                                    <span
                                        class="bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-full border border-emerald-200 text-[10px]">
                                        Terjadwal / Selesai
                                    </span>
                                </div>

                                @forelse($rupsDokumen as $item)
                                    <div
                                        class="flex flex-col sm:flex-row sm:items-center justify-between p-4 rounded-xl border border-slate-200/80 hover:border-[#0099ff] bg-white gap-3 transition-colors">
                                        <div class="flex items-start gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-blue-50 text-[#0051d5] flex items-center justify-center flex-shrink-0 text-xs">
                                                <i class="fa-regular fa-file-pdf"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-900 text-xs md:text-sm leading-tight">
                                                    {{ $item->Judul }}
                                                </h4>
                                                @if ($item->KategoriDokumen)
                                                    <span
                                                        class="text-[11px] text-slate-400">{{ $item->KategoriDokumen }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 self-end sm:self-center">
                                            @if ($item->PathFile)
                                                <a href="{{ asset('storage/' . $item->PathFile) }}" target="_blank"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 hover:bg-[#0099ff] text-slate-700 hover:text-white font-semibold text-xs border border-slate-200 transition-colors">
                                                    <i class="fa-solid fa-download text-xs"></i> Unduh
                                                </a>
                                            @else
                                                <span class="text-xs text-slate-400 italic">Dokumen belum diunggah</span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-8 text-center bg-slate-50 rounded-xl text-slate-500 text-xs">
                                        Belum ada arsip RUPS untuk tahun {{ $selectedTahun }}.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </section>

                    <!-- ------------------------------------------ -->
                    <!-- SECTION 04: KOMITE AUDIT & WBS -->
                    <!-- ------------------------------------------ -->
                    <section id="komite-wbs" class="scroll-mt-32">
                        <div class="mb-4">
                            <span
                                class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                Pengawasan Independen
                            </span>
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                                Komite Audit &amp; Whistleblowing System
                            </h2>
                        </div>

                        <!-- Audit Cards Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80">
                                <div
                                    class="w-10 h-10 rounded-lg bg-blue-50 text-[#0051d5] flex items-center justify-center text-base mb-3">
                                    <i class="fa-solid fa-clipboard-check"></i>
                                </div>
                                <h3 class="font-bold text-slate-900 text-sm mb-1">Satuan Audit Internal</h3>
                                <p class="text-xs text-slate-500 leading-relaxed mb-4">
                                    Berkedudukan untuk membantu Direksi mengevaluasi efektivitas manajemen risiko,
                                    pengendalian internal, serta integritas proses tata kelola perseroan.
                                </p>
                                @php
                                    $piagamInternal = $komiteAudit->firstWhere('Kategori', 'Satuan Audit Internal');
                                @endphp
                                @if ($piagamInternal && $piagamInternal->PathFile)
                                    <a href="{{ asset('storage/' . $piagamInternal->PathFile) }}" target="_blank"
                                        class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0051d5] hover:underline">
                                        <i class="fa-solid fa-file-pdf"></i> Piagam Satuan Audit Internal (PDF)
                                    </a>
                                @endif
                            </div>

                            <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80">
                                <div
                                    class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-700 flex items-center justify-center text-base mb-3">
                                    <i class="fa-solid fa-user-check"></i>
                                </div>
                                <h3 class="font-bold text-slate-900 text-sm mb-1">Komite Audit</h3>
                                <p class="text-xs text-slate-500 leading-relaxed mb-4">
                                    Membantu dan meningkatkan peran Komisaris dalam mengawasi laporan keuangan, efektivitas
                                    audit, dan kepatuhan terhadap regulasi pasar modal.
                                </p>
                                @php
                                    $piagamKomite = $komiteAudit->firstWhere('Kategori', 'Komite Audit');
                                @endphp
                                @if ($piagamKomite && $piagamKomite->PathFile)
                                    <a href="{{ asset('storage/' . $piagamKomite->PathFile) }}" target="_blank"
                                        class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-700 hover:underline">
                                        <i class="fa-solid fa-file-pdf"></i> Piagam Komite Audit (PDF)
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Whistleblowing System (WBS) Card -->
                        <div class="bg-[#032b43] text-white rounded-2xl p-6 md:p-8 shadow-md border border-[#004f7c]/40">
                            <!-- Header Section -->
                            <div
                                class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-6 border-b border-cyan-800/40">
                                <div>
                                    <div class="flex items-center gap-2 mb-2">
                                        <div
                                            class="w-7 h-7 rounded-lg bg-cyan-900/60 border border-cyan-500/30 flex items-center justify-center text-cyan-400 text-xs">
                                            <i class="fa-solid fa-lock"></i>
                                        </div>
                                        <span class="text-[10px] font-bold text-cyan-400 uppercase tracking-wider">
                                            SALURAN PELAPORAN AMAN &amp; RAHASIA
                                        </span>
                                    </div>
                                    <h3 class="text-2xl font-bold text-white">
                                        Whistleblowing System (WBS)
                                    </h3>
                                </div>
                                <div>
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-[10px] font-bold text-emerald-400 bg-emerald-950/60 border border-emerald-500/40">
                                        Perlindungan Pelapor
                                    </span>
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <p class="text-xs text-slate-300 leading-relaxed mb-6">
                                Penyampaian dugaan pelanggaran akuntansi, audit, kecurangan, gratifikasi atau kode etik.
                                Perseroan menjamin kerahasiaan identitas dan perlindungan penuh dari intimidasi bagi
                                pelapor.
                            </p>

                            <!-- Information Box Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs mb-6">
                                <div class="bg-[#063d5e]/50 p-4 rounded-xl border border-cyan-700/30">
                                    <span
                                        class="text-[10px] text-cyan-300/80 font-bold block uppercase tracking-wider mb-1">SURAT
                                        FISIK TERTUTUP:</span>
                                    <p class="font-bold text-white mt-0.5">Komite Audit PT Jasuindo Tiga Perkasa Tbk</p>
                                    <p class="text-[11px] text-slate-300 mt-1">Jl. Raya Betro No. 21, Sedati, Sidoarjo
                                        61253</p>
                                </div>
                                <div class="bg-[#063d5e]/50 p-4 rounded-xl border border-cyan-700/30">
                                    <span
                                        class="text-[10px] text-cyan-300/80 font-bold block uppercase tracking-wider mb-1">EMAIL
                                        RESMI FKAP:</span>
                                    <p class="text-[11px] text-slate-300 mt-0.5">Fungsi Kepatuhan Anti Penyuapan</p>
                                    <a href="mailto:smap@jasuindo.com"
                                        class="font-bold text-cyan-400 hover:underline block mt-1">
                                        smap@jasuindo.com
                                    </a>
                                </div>
                            </div>

                            <!-- Footer Section -->
                            <div
                                class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-cyan-800/40">
                                <p class="text-[11px] text-slate-300">
                                    Semua laporan diproses secara objektif dan rahasia.
                                </p>
                                <button type="button" id="btn-open-wbs"
                                    class="w-full sm:w-auto py-2.5 px-6 bg-cyan-400 hover:bg-cyan-300 text-slate-950 font-bold text-xs rounded-full transition-colors shadow-sm text-center">
                                    Kirim Laporan Pelanggaran (WBS)
                                </button>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- MODAL 1: PROFIL LENGKAP MANAJEMEN POPUP -->
    <!-- ========================================== -->
    <div id="modal-profil"
        class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div
            class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 transform transition-all relative">
            <button type="button" id="close-profil-modal"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="flex items-center gap-4 pb-4 border-b border-slate-100 mb-4">
                <div id="modal-profil-foto-box"
                    class="w-16 h-16 rounded-full bg-blue-100 text-[#0051d5] font-bold flex items-center justify-center text-lg flex-shrink-0">
                    <span id="modal-profil-initial"></span>
                </div>
                <div>
                    <span id="modal-profil-kategori"
                        class="text-[10px] font-bold uppercase tracking-wider text-[#0051d5] bg-blue-50 px-2 py-0.5 rounded border border-blue-100"></span>
                    <h3 id="modal-profil-nama" class="text-lg font-bold text-slate-900 mt-1"></h3>
                    <p id="modal-profil-jabatan" class="text-xs text-slate-500 font-medium"></p>
                </div>
            </div>

            <div class="text-xs text-slate-700 leading-relaxed max-h-72 overflow-y-auto pr-2" id="modal-profil-bio">
                <!-- Full bio populated via JS -->
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 text-right">
                <button type="button" id="close-profil-modal-btn"
                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold text-xs transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- MODAL 2: FORM LAPORAN WHISTLEBLOWING SYSTEM (WBS) -->
    <!-- ========================================== -->
    <div id="modal-wbs"
        class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div
            class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto relative">
            <button type="button" id="close-wbs-modal"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="mb-4 pb-3 border-b border-slate-100">
                <span
                    class="text-[10px] font-bold uppercase tracking-wider text-rose-600 bg-rose-50 px-2 py-0.5 rounded border border-rose-100">
                    Formulir Pengaduan Rahasia
                </span>
                <h3 class="text-xl font-bold text-slate-900 mt-1">
                    Laporan Whistleblowing System (WBS)
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Kerahasiaan data pelapor dilindungi sepenuhnya oleh Perseroan.
                </p>
            </div>

            <form id="form-wbs" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kategori Pelanggaran *</label>
                    <select name="KategoriPelanggaran" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                        <option value="">Pilih Kategori Pelanggaran...</option>
                        <option value="Korupsi / Suap / Pemerasan">Korupsi / Suap / Pemerasan</option>
                        <option value="Kecurangan Finansial / Penggelapan Aset">Kecurangan Finansial / Penggelapan Aset
                        </option>
                        <option value="Benturan Kepentingan (Conflict of Interest)">Benturan Kepentingan (Conflict of
                            Interest)</option>
                        <option value="Pelanggaran Kerahasiaan Data / Dokumen Sekuriti">Pelanggaran Kerahasiaan Data /
                            Dokumen Sekuriti</option>
                        <option value="Pelecehan / Diskriminasi di Lingkungan Kerja">Pelecehan / Diskriminasi di Lingkungan
                            Kerja</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Pihak yang Dilaporkan (Terlapor)</label>
                        <input type="text" name="Terlapor" placeholder="Nama / Jabatan / Divisi..."
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Perkiraan Waktu Kejadian</label>
                        <input type="date" name="WaktuKejadian"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Lokasi Kejadian</label>
                    <input type="text" name="LokasiKejadian"
                        placeholder="Contoh: Pabrik Sedati / Kantor Cabang / dsb."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Uraian / Kronologi Kejadian *</label>
                    <textarea name="UraianKejadian" rows="4" required
                        placeholder="Jelaskan secara rinci apa yang terjadi, siapa saja yang terlibat, dan kronologinya..."
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Lampiran Dokumen Bukti (Opsional)</label>
                    <input type="file" name="BuktiFile"
                        class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#0051d5] hover:file:bg-blue-100">
                    <p class="text-[10px] text-slate-400 mt-1">Format: PDF, JPG, PNG, DOCX, ZIP (Maks. 10MB)</p>
                </div>

                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-2">
                        Identitas Pelapor (Boleh Dikosongkan jika ingin Anonim)
                    </span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <input type="text" name="NamaPelapor" placeholder="Nama Lengkap (Opsional)"
                            class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs outline-none">
                        <input type="email" name="EmailPelapor" placeholder="Email untuk korespondensi (Opsional)"
                            class="w-full px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-xs outline-none">
                    </div>
                </div>

                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" id="cancel-wbs-btn"
                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs">
                        Batal
                    </button>
                    <button type="submit" id="submit-wbs-btn"
                        class="px-5 py-2 bg-sky-600 hover:bg-sky-500 text-white font-bold rounded-xl text-xs shadow-sm">
                        Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Toggle Komisaris / Direksi tabs
                const btnKomisaris = document.getElementById('tab-komisaris-btn');
                const btnDireksi = document.getElementById('tab-direksi-btn');
                const gridKomisaris = document.getElementById('grid-komisaris');
                const gridDireksi = document.getElementById('grid-direksi');

                if (btnKomisaris && btnDireksi) {
                    btnKomisaris.addEventListener('click', function() {
                        btnKomisaris.classList.add('bg-white', 'text-[#0051d5]', 'shadow-sm');
                        btnKomisaris.classList.remove('text-slate-600');
                        btnDireksi.classList.remove('bg-white', 'text-[#0051d5]', 'shadow-sm');
                        btnDireksi.classList.add('text-slate-600');
                        gridKomisaris.classList.remove('hidden');
                        gridDireksi.classList.add('hidden');
                    });

                    btnDireksi.addEventListener('click', function() {
                        btnDireksi.classList.add('bg-white', 'text-[#0051d5]', 'shadow-sm');
                        btnDireksi.classList.remove('text-slate-600');
                        btnKomisaris.classList.remove('bg-white', 'text-[#0051d5]', 'shadow-sm');
                        btnKomisaris.classList.add('text-slate-600');
                        gridDireksi.classList.remove('hidden');
                        gridKomisaris.classList.add('hidden');
                    });
                }

                // Accordion functionality
                document.querySelectorAll('.accordion-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const content = this.nextElementSibling;
                        const icon = this.querySelector('.accordion-icon');
                        if (content.classList.contains('hidden')) {
                            content.classList.remove('hidden');
                            icon.classList.add('rotate-180');
                        } else {
                            content.classList.add('hidden');
                            icon.classList.remove('rotate-180');
                        }
                    });
                });

                // Modal Profil Lengkap
                const modalProfil = document.getElementById('modal-profil');
                const closeProfilBtns = [document.getElementById('close-profil-modal'), document.getElementById(
                    'close-profil-modal-btn')];
                document.querySelectorAll('.btn-profil-modal').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const nama = this.getAttribute('data-nama');
                        const jabatan = this.getAttribute('data-jabatan');
                        const kategori = this.getAttribute('data-kategori');
                        const bio = this.getAttribute('data-bio');
                        const foto = this.getAttribute('data-foto');

                        document.getElementById('modal-profil-nama').innerText = nama;
                        document.getElementById('modal-profil-jabatan').innerText = jabatan;
                        document.getElementById('modal-profil-kategori').innerText = kategori;
                        document.getElementById('modal-profil-bio').innerHTML = bio.replace(/\n/g,
                            '<br><br>');

                        const fotoBox = document.getElementById('modal-profil-foto-box');
                        if (foto) {
                            fotoBox.innerHTML =
                                `<img src="${foto}" class="w-full h-full rounded-full object-cover">`;
                        } else {
                            fotoBox.innerHTML = `<span>${nama.substring(0, 2).toUpperCase()}</span>`;
                        }

                        modalProfil.classList.remove('hidden');
                    });
                });

                closeProfilBtns.forEach(b => {
                    if (b) b.addEventListener('click', () => modalProfil.classList.add('hidden'));
                });

                // Modal WBS
                const modalWbs = document.getElementById('modal-wbs');
                const btnOpenWbs = document.getElementById('btn-open-wbs');
                const closeWbsBtns = [document.getElementById('close-wbs-modal'), document.getElementById(
                    'cancel-wbs-btn')];

                if (btnOpenWbs) {
                    btnOpenWbs.addEventListener('click', () => modalWbs.classList.remove('hidden'));
                }
                closeWbsBtns.forEach(b => {
                    if (b) b.addEventListener('click', () => modalWbs.classList.add('hidden'));
                });

                // Submit WBS via Ajax
                const formWbs = document.getElementById('form-wbs');
                if (formWbs) {
                    formWbs.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const formData = new FormData(this);
                        const submitBtn = document.getElementById('submit-wbs-btn');
                        submitBtn.disabled = true;
                        submitBtn.innerText = 'Mengirim...';

                        fetch("{{ route('frontend.investor.wbs.store', ['locale' => app()->getLocale()]) }}", {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                alert(data.message);
                                formWbs.reset();
                                modalWbs.classList.add('hidden');
                                submitBtn.disabled = false;
                                submitBtn.innerText = 'Kirim Laporan';
                            })
                            .catch(err => {
                                alert('Terjadi kesalahan saat mengirim laporan. Silakan coba kembali.');
                                submitBtn.disabled = false;
                                submitBtn.innerText = 'Kirim Laporan';
                            });
                    });
                }
            });
        </script>
    @endpush
@endsection

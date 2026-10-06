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

                    <nav class="space-y-1.5" id="investor-sidebar-nav">
                        <a href="#informasi-saham"
                           class="flex items-start gap-3 p-2.5 rounded-lg bg-blue-50 text-[#0051d5] font-semibold text-xs transition-colors sidebar-nav-link"
                           data-target="informasi-saham">
                            <span class="text-xs font-bold w-5">01</span>
                            <div>
                                <p class="text-xs font-bold leading-tight">Informasi Saham JTPE</p>
                                <p class="text-[11px] font-normal text-slate-500 mt-0.5">Pasar modal &amp; performa harian</p>
                            </div>
                        </a>

                        <a href="#struktur-kepemilikan"
                           class="flex items-start gap-3 p-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-xs transition-colors sidebar-nav-link"
                           data-target="struktur-kepemilikan">
                            <span class="text-xs font-bold text-slate-400 w-5">02</span>
                            <div>
                                <p class="text-xs font-semibold leading-tight">Struktur Kepemilikan</p>
                                <p class="text-[11px] font-normal text-slate-500 mt-0.5">Distribusi pemodal domestik &amp; asing</p>
                            </div>
                        </a>

                        <a href="#pemegang-saham-utama"
                           class="flex items-start gap-3 p-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-xs transition-colors sidebar-nav-link"
                           data-target="pemegang-saham-utama">
                            <span class="text-xs font-bold text-slate-400 w-5">03</span>
                            <div>
                                <p class="text-xs font-semibold leading-tight">Pemegang Saham Pengendali</p>
                                <p class="text-[11px] font-normal text-slate-500 mt-0.5">Skema piramida &amp; ultimate owner</p>
                            </div>
                        </a>

                        <a href="#entitas-anak"
                           class="flex items-start gap-3 p-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-xs transition-colors sidebar-nav-link"
                           data-target="entitas-anak">
                            <span class="text-xs font-bold text-slate-400 w-5">04</span>
                            <div>
                                <p class="text-xs font-semibold leading-tight">Entitas Anak &amp; Asosiasi</p>
                                <p class="text-[11px] font-normal text-slate-500 mt-0.5">Portofolio bisnis terintegrasi</p>
                            </div>
                        </a>
                    </nav>

                    <!-- Info Box -->
                    <div class="mt-6 pt-4 border-t border-slate-100 bg-sky-50/60 rounded-lg p-3 text-xs text-sky-900 border border-sky-100">
                        <div class="flex items-center gap-2 font-bold mb-1 text-sky-800">
                            <i class="fa-solid fa-shield-halved text-sky-600"></i>
                            Keterbukaan BEI &amp; OJK
                        </div>
                        <p class="text-[11px] text-sky-700 leading-relaxed">
                            Data harga saham dan kepemilikan diperbarui secara periodik mengacu pada pencatatan resmi PT Bursa Efek Indonesia (IDXNet) dan Biro Administrasi Efek.
                        </p>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- RIGHT CONTENT AREA -->
            <!-- ========================================== -->
            <div class="lg:col-span-8 xl:col-span-9 space-y-12">

                <!-- ------------------------------------------ -->
                <!-- SECTION 01: INFORMASI SAHAM JTPE -->
                <!-- ------------------------------------------ -->
                <section id="informasi-saham" class="scroll-mt-32">
                    <div class="mb-4">
                        <span class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                            Pasar Modal &amp; Performa Saham
                        </span>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                            Informasi Saham JTPE
                        </h2>
                    </div>

                    <!-- Main Stock Card -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

                            <!-- Left: Stock Price & Chart -->
                            <div class="lg:col-span-7 space-y-6">
                                <div class="flex flex-wrap items-baseline gap-3">
                                    <span class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">
                                        Rp {{ number_format($saham->HargaTerakhir, 0, ',', '.') }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $saham->Perubahan >= 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-rose-50 text-rose-700 border border-rose-200' }}">
                                        <i class="fa-solid {{ $saham->Perubahan >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
                                        {{ $saham->Perubahan >= 0 ? '+' : '' }}{{ number_format($saham->Perubahan, 0, ',', '.') }} ({{ $saham->Perubahan >= 0 ? '+' : '' }}{{ $saham->PersentasePerubahan }}%)
                                    </span>
                                    <span class="text-xs text-slate-400 font-medium">
                                        {{ $saham->StatusPasar }}
                                    </span>
                                </div>

                                <!-- Chart Simulation Component -->
                                <div class="bg-slate-50/70 p-4 rounded-xl border border-slate-100">
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="text-xs font-semibold text-slate-700">Pergerakan 5 Hari Terakhir (JTPE)</span>
                                        <div class="flex gap-1">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#0099ff] text-white">5H</span>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-medium text-slate-500 hover:bg-slate-200 cursor-pointer">1B</span>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-medium text-slate-500 hover:bg-slate-200 cursor-pointer">1T</span>
                                        </div>
                                    </div>

                                    <!-- Clean Vector SVG Chart -->
                                    <div class="h-44 w-full relative">
                                        <svg class="w-full h-full overflow-visible" viewBox="0 0 500 150" preserveAspectRatio="none">
                                            <defs>
                                                <linearGradient id="chartGradient" x1="0" y1="0" x2="0" y2="1">
                                                    <stop offset="0%" stop-color="#0099ff" stop-opacity="0.25"/>
                                                    <stop offset="100%" stop-color="#0099ff" stop-opacity="0.0"/>
                                                </linearGradient>
                                            </defs>
                                            <!-- Grid lines -->
                                            <line x1="0" y1="30" x2="500" y2="30" stroke="#e2e8f0" stroke-dasharray="3,3" />
                                            <line x1="0" y1="75" x2="500" y2="75" stroke="#e2e8f0" stroke-dasharray="3,3" />
                                            <line x1="0" y1="120" x2="500" y2="120" stroke="#e2e8f0" stroke-dasharray="3,3" />

                                            <!-- Area Fill -->
                                            <polygon fill="url(#chartGradient)" points="0,110 120,95 240,75 360,75 500,35 500,150 0,150" />

                                            <!-- Main Path Line -->
                                            <polyline fill="none" stroke="#0099ff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"
                                                      points="0,110 120,95 240,75 360,75 500,35" />

                                            <!-- Data point dots -->
                                            <circle cx="0" cy="110" r="4" fill="#0099ff" class="hover:r-6 transition-all"/>
                                            <circle cx="120" cy="95" r="4" fill="#0099ff"/>
                                            <circle cx="240" cy="75" r="4" fill="#0099ff"/>
                                            <circle cx="360" cy="75" r="4" fill="#0099ff"/>
                                            <circle cx="500" cy="35" r="5" fill="#0284c7" stroke="#ffffff" stroke-width="2"/>
                                        </svg>
                                    </div>
                                    <div class="flex justify-between text-[11px] text-slate-400 mt-2 px-1">
                                        <span>22 Mar (575)</span>
                                        <span>25 Mar (580)</span>
                                        <span>26 Mar (585)</span>
                                        <span>27 Mar (585)</span>
                                        <span class="font-bold text-[#0099ff]">28 Mar (595)</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Daily Statistics Table -->
                            <div class="lg:col-span-5 bg-slate-50/60 rounded-xl p-5 border border-slate-100">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-600 mb-4 pb-2 border-b border-slate-200">
                                    Statistik Perdagangan Harian
                                </h3>

                                <div class="grid grid-cols-2 gap-y-3.5 gap-x-4 text-xs">
                                    <div>
                                        <span class="text-slate-400 block text-[11px]">Pembukaan</span>
                                        <span class="font-bold text-slate-800">Rp {{ number_format($saham->Pembukaan, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[11px]">Penutupan Kemarin</span>
                                        <span class="font-bold text-slate-800">Rp {{ number_format($saham->PenutupanKemarin, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[11px]">Tertinggi Hari Ini</span>
                                        <span class="font-bold text-emerald-600">Rp {{ number_format($saham->TertinggiHariIni, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[11px]">Terendah Hari Ini</span>
                                        <span class="font-bold text-rose-600">Rp {{ number_format($saham->TerendahHariIni, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[11px]">52 Mgg Tertinggi</span>
                                        <span class="font-semibold text-slate-700">Rp {{ number_format($saham->Tertinggi52Mgg, 0, ',', '.') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block text-[11px]">52 Mgg Terendah</span>
                                        <span class="font-semibold text-slate-700">Rp {{ number_format($saham->Terendah52Mgg, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="col-span-2 pt-2 border-t border-slate-200">
                                        <div class="flex justify-between items-center py-1">
                                            <span class="text-slate-500">Volume Saham</span>
                                            <span class="font-bold text-slate-900">{{ number_format($saham->VolumeSaham, 0, ',', '.') }} Lembar</span>
                                        </div>
                                        <div class="flex justify-between items-center py-1">
                                            <span class="text-slate-500">Nilai Transaksi</span>
                                            <span class="font-bold text-slate-900">{{ $saham->NilaiTransaksi }}</span>
                                        </div>
                                        <div class="flex justify-between items-center py-1">
                                            <span class="text-slate-500">Kapitalisasi Pasar</span>
                                            <span class="font-bold text-[#0051d5]">{{ $saham->KapitalisasiPasar }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </section>

                <!-- ------------------------------------------ -->
                <!-- SECTION 02: STRUKTUR KEPEMILIKAN SAHAM -->
                <!-- ------------------------------------------ -->
                <section id="struktur-kepemilikan" class="scroll-mt-32">
                    <div class="mb-4">
                        <span class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                            Distribusi Dukungan Berdasarkan Tipe Modal
                        </span>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                            Struktur Kepemilikan Emiten atau Perusahaan Publik
                        </h2>
                    </div>

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <!-- Card 1 -->
                        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase block mb-1">
                                    PEMODAL NASIONAL (DOMESTIK)
                                </span>
                                <span class="text-2xl font-bold text-[#0051d5]">{{ $totalNasionalPersen }}%</span>
                                <p class="text-xs text-slate-500 mt-0.5">{{ number_format($totalNasionalSaham, 0, ',', '.') }} Saham</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-[#0051d5]">
                                <i class="fa-solid fa-flag text-sm"></i>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase block mb-1">
                                    PEMODAL ASING (FOREIGN)
                                </span>
                                <span class="text-2xl font-bold text-indigo-600">{{ $totalAsingPersen }}%</span>
                                <p class="text-xs text-slate-500 mt-0.5">{{ number_format($totalAsingSaham, 0, ',', '.') }} Saham</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                                <i class="fa-solid fa-globe text-sm"></i>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-bold tracking-wider text-slate-400 uppercase block mb-1">
                                    TOTAL MODAL DISETOR
                                </span>
                                <span class="text-2xl font-bold text-emerald-600">100,00%</span>
                                <p class="text-xs text-slate-500 mt-0.5">{{ number_format($totalModalDisetor, 0, ',', '.') }} Saham</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <i class="fa-solid fa-check text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Breakdown Table -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs text-left">
                                <thead class="bg-slate-50 border-b border-slate-200 text-slate-600 font-bold uppercase tracking-wider text-[11px]">
                                    <tr>
                                        <th class="py-3.5 px-6">Pemegang Saham</th>
                                        <th class="py-3.5 px-6 text-right">Jumlah Saham</th>
                                        <th class="py-3.5 px-6 text-right">% Kepemilikan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <!-- A. Pemodal Nasional -->
                                    <tr class="bg-slate-50/50 font-bold text-slate-900">
                                        <td colspan="3" class="py-2.5 px-6 text-xs text-[#0051d5]">
                                            A. PEMODAL NASIONAL
                                        </td>
                                    </tr>
                                    @foreach($strukturNasional as $item)
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-3 px-6 pl-10 text-slate-700">{{ $item->KategoriPemegang }}</td>
                                            <td class="py-3 px-6 text-right font-medium text-slate-900">{{ number_format($item->JumlahSaham, 0, ',', '.') }}</td>
                                            <td class="py-3 px-6 text-right text-slate-600">{{ number_format($item->Persentase, 2, ',', '.') }}%</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-blue-50/40 font-bold text-slate-900">
                                        <td class="py-2.5 px-6 pl-10">Subtotal Pemodal Nasional</td>
                                        <td class="py-2.5 px-6 text-right text-[#0051d5]">{{ number_format($totalNasionalSaham, 0, ',', '.') }}</td>
                                        <td class="py-2.5 px-6 text-right text-[#0051d5]">{{ number_format($totalNasionalPersen, 2, ',', '.') }}%</td>
                                    </tr>

                                    <!-- B. Pemodal Asing -->
                                    <tr class="bg-slate-50/50 font-bold text-slate-900">
                                        <td colspan="3" class="py-2.5 px-6 text-xs text-indigo-700">
                                            B. PEMODAL ASING
                                        </td>
                                    </tr>
                                    @foreach($strukturAsing as $item)
                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                            <td class="py-3 px-6 pl-10 text-slate-700">{{ $item->KategoriPemegang }}</td>
                                            <td class="py-3 px-6 text-right font-medium text-slate-900">{{ number_format($item->JumlahSaham, 0, ',', '.') }}</td>
                                            <td class="py-3 px-6 text-right text-slate-600">{{ number_format($item->Persentase, 2, ',', '.') }}%</td>
                                        </tr>
                                    @endforeach
                                    <tr class="bg-indigo-50/40 font-bold text-slate-900">
                                        <td class="py-2.5 px-6 pl-10">Subtotal Pemodal Asing</td>
                                        <td class="py-2.5 px-6 text-right text-indigo-700">{{ number_format($totalAsingSaham, 0, ',', '.') }}</td>
                                        <td class="py-2.5 px-6 text-right text-indigo-700">{{ number_format($totalAsingPersen, 2, ',', '.') }}%</td>
                                    </tr>

                                    <!-- Total -->
                                    <tr class="bg-[#0b1c30] text-white font-bold text-xs">
                                        <td class="py-3.5 px-6 uppercase tracking-wider">TOTAL MODAL DISETOR</td>
                                        <td class="py-3.5 px-6 text-right">{{ number_format($totalModalDisetor, 0, ',', '.') }}</td>
                                        <td class="py-3.5 px-6 text-right">100,00%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- ------------------------------------------ -->
                <!-- SECTION 03: PEMEGANG SAHAM UTAMA & PENGENDALI -->
                <!-- ------------------------------------------ -->
                <section id="pemegang-saham-utama" class="scroll-mt-32">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                        <div>
                            <span class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                Struktur Kepemilikan Piramida &amp; Entitas Pengendali
                            </span>
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                                Pemegang Saham Utama dan Pengendali Perusahaan
                            </h2>
                        </div>
                        @if($skema->PathFilePdf)
                            <a href="{{ asset('storage/' . $skema->PathFilePdf) }}" target="_blank"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-slate-50 text-[#0051d5] font-semibold text-xs rounded-xl border border-slate-200 shadow-sm transition-colors self-start">
                                <i class="fa-solid fa-file-pdf text-red-500"></i> Unduh Skema Kepemilikan (PDF)
                            </a>
                        @endif
                    </div>

                    <!-- Diagram Container -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
                        @if($skema->PathGambar)
                            <!-- Custom Uploaded Diagram from Admin -->
                            <div class="w-full rounded-xl overflow-hidden mb-4 border border-slate-100">
                                <img src="{{ asset('storage/' . $skema->PathGambar) }}"
                                     alt="Bagan Struktur Kepemilikan Saham &amp; Pemegang Saham Utama Pengendali"
                                     class="w-full h-auto object-contain max-h-[600px] mx-auto">
                            </div>
                        @else
                            <!-- Default High-Fidelity SVG/HTML Diagram matching Figma -->
                            <div class="p-6 bg-slate-50/60 rounded-xl border border-slate-100 text-center">
                                <!-- Top: Shareholder Boxes -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 max-w-4xl mx-auto mb-6">
                                    <div class="bg-[#0284c7] text-white p-3 rounded-lg shadow-sm">
                                        <span class="text-[10px] block opacity-80 uppercase tracking-wider">Pemilik Pengendali</span>
                                        <p class="font-bold text-xs mt-0.5">YONGKY WIJAYA</p>
                                        <span class="text-[11px] opacity-90">58,00%</span>
                                    </div>
                                    <div class="bg-[#0284c7] text-white p-3 rounded-lg shadow-sm">
                                        <span class="text-[10px] block opacity-80 uppercase tracking-wider">Pemegang Saham</span>
                                        <p class="font-bold text-xs mt-0.5">HJ. LINDA SURYAWATI</p>
                                        <span class="text-[11px] opacity-90">26,00%</span>
                                    </div>
                                    <div class="bg-[#0284c7] text-white p-3 rounded-lg shadow-sm">
                                        <span class="text-[10px] block opacity-80 uppercase tracking-wider">Pemegang Saham</span>
                                        <p class="font-bold text-xs mt-0.5">JIE LEOPOLD SUDARMO</p>
                                        <span class="text-[11px] opacity-90">16,00%</span>
                                    </div>
                                    <div class="bg-amber-600 text-white p-3 rounded-lg shadow-sm">
                                        <span class="text-[10px] block opacity-80 uppercase tracking-wider">Holding Luar Negeri</span>
                                        <p class="font-bold text-xs mt-0.5">TOYAH SECURITY CO., LTD</p>
                                        <span class="text-[11px] opacity-90">27,06%</span>
                                    </div>
                                </div>

                                <!-- Connecting Line -->
                                <div class="flex flex-col items-center justify-center my-2">
                                    <div class="w-0.5 h-6 bg-slate-300"></div>
                                    <span class="bg-emerald-50 text-emerald-800 text-[10px] font-bold px-3 py-1 rounded-full border border-emerald-200">
                                        Yongky Wijaya 58% + Linda 26% + Jie 16% (100%)
                                    </span>
                                    <div class="w-0.5 h-6 bg-slate-300"></div>
                                </div>

                                <!-- Middle: Holding / Pengendali Akhir -->
                                <div class="max-w-md mx-auto bg-[#047857] text-white p-4 rounded-xl shadow-sm mb-4">
                                    <span class="text-[10px] uppercase tracking-wider opacity-80 block">Entitas Pengendali Akhir (UBO)</span>
                                    <p class="font-bold text-sm md:text-base mt-0.5">PT JASUINDO MULTI INVESTAMA</p>
                                    <p class="text-xs opacity-90 mt-1">Pengendali Saham Mayoritas Langsung</p>
                                </div>

                                <!-- Connecting Line to Listed Entity -->
                                <div class="flex flex-col items-center justify-center my-2">
                                    <div class="w-0.5 h-6 bg-slate-300"></div>
                                    <span class="text-[11px] font-semibold text-slate-500">Memegang 47,10% Saham</span>
                                    <div class="w-0.5 h-6 bg-slate-300"></div>
                                </div>

                                <!-- Listed Company Box -->
                                <div class="max-w-xl mx-auto bg-[#0a557a] text-white p-5 rounded-2xl shadow-md border-2 border-white/20">
                                    <span class="text-[10px] uppercase tracking-widest text-sky-200 block font-bold">EMITEN TERBUKA - BURSA EFEK INDONESIA</span>
                                    <h3 class="text-base md:text-xl font-bold mt-1">PT JASUINDO TIGA PERKASA TBK</h3>
                                    <p class="text-xs text-sky-100 mt-1">Kode Saham: JTPE</p>
                                </div>

                                <!-- Line to Subsidiaries -->
                                <div class="flex flex-col items-center justify-center my-2">
                                    <div class="w-0.5 h-6 bg-slate-300"></div>
                                    <span class="text-[10px] font-semibold text-slate-400 uppercase tracking-wider">Entitas Anak &amp; Perusahaan Terkendali</span>
                                    <div class="w-0.5 h-6 bg-slate-300"></div>
                                </div>

                                <!-- Bottom: Subsidaries Grid -->
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-2 max-w-5xl mx-auto">
                                    <div class="bg-[#1e1b4b] text-white p-2.5 rounded-lg text-center">
                                        <p class="text-[10px] font-bold truncate">PT Jasuindo Inf. Pratama</p>
                                        <span class="text-[10px] text-emerald-400 font-semibold">99,98%</span>
                                    </div>
                                    <div class="bg-[#1e1b4b] text-white p-2.5 rounded-lg text-center">
                                        <p class="text-[10px] font-bold truncate">PT Jasuindo Solusi Sec.</p>
                                        <span class="text-[10px] text-emerald-400 font-semibold">99,00%</span>
                                    </div>
                                    <div class="bg-[#1e1b4b] text-white p-2.5 rounded-lg text-center">
                                        <p class="text-[10px] font-bold truncate">PT Solusi Anak Mandiri</p>
                                        <span class="text-[10px] text-emerald-400 font-semibold">99,00%</span>
                                    </div>
                                    <div class="bg-[#1e1b4b] text-white p-2.5 rounded-lg text-center">
                                        <p class="text-[10px] font-bold truncate">PT Solusi Identitas</p>
                                        <span class="text-[10px] text-emerald-400 font-semibold">99,00%</span>
                                    </div>
                                    <div class="bg-[#1e1b4b] text-white p-2.5 rounded-lg text-center">
                                        <p class="text-[10px] font-bold truncate">PT Nusa Adidaya</p>
                                        <span class="text-[10px] text-emerald-400 font-semibold">98,00%</span>
                                    </div>
                                    <div class="bg-[#312e81] text-white p-2.5 rounded-lg text-center">
                                        <p class="text-[10px] font-bold truncate">PT Fauziando Tiga P.</p>
                                        <span class="text-[10px] text-amber-300 font-semibold">45,00%</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($skema->Keterangan)
                            <p class="text-xs text-slate-500 mt-4 italic leading-relaxed border-t border-slate-100 pt-3">
                                <span class="font-semibold text-slate-700">Catatan:</span> {{ $skema->Keterangan }}
                            </p>
                        @endif
                    </div>
                </section>

                <!-- ------------------------------------------ -->
                <!-- SECTION 04: ENTITAS ANAK & ASOSIASI -->
                <!-- ------------------------------------------ -->
                <section id="entitas-anak" class="scroll-mt-32">
                    <div class="mb-4">
                        <span class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                            Daftar Portofolio &amp; Bisnis Terintegrasi
                        </span>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                            Entitas Anak &amp; Perusahaan Asosiasi
                        </h2>
                        <p class="text-xs md:text-sm text-slate-500 mt-1">
                            Portofolio investasi strategis dan perusahaan terafiliasi grup PT Jasuindo Tiga Perkasa Tbk.
                        </p>
                    </div>

                    <!-- Search & Filter Controls -->
                    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 mb-6">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <!-- Search -->
                            <div class="relative flex-1">
                                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                <input type="text" id="search-entitas" placeholder="Cari entitas anak, bidang bisnis, atau lokasi..."
                                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-[#0099ff] focus:ring-2 focus:ring-blue-100 outline-none transition-all">
                            </div>

                            <!-- Filter Pills -->
                            <div class="flex flex-wrap gap-1.5" id="filter-entitas-tabs">
                                <button type="button" data-filter="all"
                                        class="filter-entitas-btn px-3 py-1.5 rounded-lg text-xs font-bold bg-[#0099ff] text-white transition-all">
                                    Semua ({{ $entitasAnak->count() }})
                                </button>
                                <button type="button" data-filter="Entitas Anak"
                                        class="filter-entitas-btn px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-all">
                                    Entitas Anak ({{ $entitasAnak->where('Tipe', 'Entitas Anak')->count() }})
                                </button>
                                <button type="button" data-filter="Perusahaan Asosiasi"
                                        class="filter-entitas-btn px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-100 transition-all">
                                    Perusahaan Asosiasi ({{ $entitasAnak->where('Tipe', 'Perusahaan Asosiasi')->count() }})
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Cards / List of Subsidiaries -->
                    <div class="space-y-3" id="entitas-list-container">
                        @foreach($entitasAnak as $anak)
                            <div class="entitas-item bg-white rounded-xl p-5 shadow-sm border border-slate-200/80 hover:border-[#0099ff] hover:shadow-md transition-all duration-200"
                                 data-name="{{ strtolower($anak->NamaEntitas) }}"
                                 data-type="{{ $anak->Tipe }}"
                                 data-bidang="{{ strtolower($anak->BidangUsaha) }}">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                                    <!-- Left: Name & Location -->
                                    <div class="md:col-span-5">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $anak->Tipe === 'Entitas Anak' ? 'bg-blue-50 text-[#0051d5] border border-blue-100' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                                {{ $anak->Tipe }}
                                            </span>
                                            @if($anak->TahunBergabung)
                                                <span class="text-[11px] text-slate-400 font-medium">{{ $anak->TahunBergabung }}</span>
                                            @endif
                                        </div>
                                        <h3 class="font-bold text-slate-900 text-sm md:text-base leading-snug">
                                            {{ $anak->NamaEntitas }}
                                        </h3>
                                        <p class="text-xs text-slate-500 flex items-center gap-1.5 mt-0.5">
                                            <i class="fa-solid fa-location-dot text-slate-400 text-[10px]"></i>
                                            {{ $anak->Lokasi ?? 'Indonesia' }}
                                        </p>
                                    </div>

                                    <!-- Middle: Ownership Percentage -->
                                    <div class="md:col-span-3">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                            Kepemilikan Saham
                                        </span>
                                        <div class="flex items-center gap-2">
                                            <span class="font-extrabold text-sm md:text-base text-slate-900">
                                                {{ number_format($anak->PersentaseKepemilikan, 2, ',', '.') }}%
                                            </span>
                                            <div class="flex-1 bg-slate-100 h-2 rounded-full overflow-hidden">
                                                <div class="h-full rounded-full {{ $anak->PersentaseKepemilikan >= 50 ? 'bg-[#0099ff]' : 'bg-amber-500' }}"
                                                     style="width: {{ min(100, $anak->PersentaseKepemilikan) }}%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right: Business Focus & Website -->
                                    <div class="md:col-span-4 text-xs text-slate-600">
                                        <p class="line-clamp-2 leading-relaxed">
                                            {{ $anak->BidangUsaha }}
                                        </p>
                                        @if($anak->UrlWebsite)
                                            <a href="{{ $anak->UrlWebsite }}" target="_blank"
                                               class="inline-flex items-center gap-1 text-[#0051d5] hover:underline font-semibold mt-1 text-[11px]">
                                                Kunjungi Website <i class="fa-solid fa-arrow-up-right-from-square text-[9px]"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- ------------------------------------------ -->
                <!-- BOTTOM CTA CALLOUT -->
                <!-- ------------------------------------------ -->
                <div class="bg-gradient-to-r from-[#0a557a] to-[#094e70] rounded-2xl p-8 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-md">
                    <div>
                        <h3 class="text-xl font-bold mb-1">
                            Butuh Klarifikasi Terkait Data Finansial?
                        </h3>
                        <p class="text-xs md:text-sm text-sky-100 max-w-xl">
                            Sekretariat Perusahaan dan tim Hubungan Investor senantiasa siap membantu analis, bursa, dan investor publik.
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('frontend.investor.informasi-lainnya', ['locale' => app()->getLocale()]) }}#hubungi-investor"
                           class="px-5 py-2.5 rounded-xl bg-white text-[#0a557a] hover:bg-sky-50 font-bold text-xs transition-colors shadow-sm whitespace-nowrap">
                            Hubungi Hubungan Investor
                        </a>
                        <a href="{{ route('frontend.contact.index', ['locale' => app()->getLocale()]) }}"
                           class="px-5 py-2.5 rounded-xl bg-sky-900/60 hover:bg-sky-900 text-white font-semibold text-xs border border-white/20 transition-colors whitespace-nowrap">
                            Kontak Kami
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Entitas filter
        const filterBtns = document.querySelectorAll('.filter-entitas-btn');
        const searchInput = document.getElementById('search-entitas');
        const items = document.querySelectorAll('.entitas-item');

        function filterList() {
            const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const activeBtn = document.querySelector('.filter-entitas-btn.bg-\\[\\#0099ff\\]');
            const filterType = activeBtn ? activeBtn.getAttribute('data-filter') : 'all';

            items.forEach(item => {
                const name = item.getAttribute('data-name') || '';
                const type = item.getAttribute('data-type') || '';
                const bidang = item.getAttribute('data-bidang') || '';

                const matchesQuery = !query || name.includes(query) || bidang.includes(query);
                const matchesType = filterType === 'all' || type === filterType;

                if (matchesQuery && matchesType) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                filterBtns.forEach(b => {
                    b.classList.remove('bg-[#0099ff]', 'text-white');
                    b.classList.add('text-slate-600');
                });
                this.classList.remove('text-slate-600');
                this.classList.add('bg-[#0099ff]', 'text-white');
                filterList();
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', filterList);
        }

        // Sidebar active link scroll spy
        const navLinks = document.querySelectorAll('.sidebar-nav-link');
        const sections = document.querySelectorAll('section[id]');

        window.addEventListener('scroll', function () {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 160;
                if (window.scrollY >= sectionTop) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                const target = link.getAttribute('data-target');
                if (target === current) {
                    link.classList.add('bg-blue-50', 'text-[#0051d5]', 'font-semibold');
                    link.classList.remove('text-slate-700');
                } else {
                    link.classList.remove('bg-blue-50', 'text-[#0051d5]', 'font-semibold');
                    link.classList.add('text-slate-700');
                }
            });
        });
    });
</script>
@endpush

@endsection

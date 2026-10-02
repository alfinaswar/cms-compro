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

                    <nav class="space-y-1.5" id="informasi-lainnya-nav">
                        <a href="#lembaga-penunjang"
                           class="flex items-start gap-3 p-2.5 rounded-lg bg-blue-50 text-[#0051d5] font-semibold text-xs transition-colors sidebar-nav-link"
                           data-target="lembaga-penunjang">
                            <span class="text-xs font-bold w-5">01</span>
                            <div>
                                <p class="text-xs font-bold leading-tight">Lembaga Penunjang Pasar Modal</p>
                                <p class="text-[11px] font-normal text-slate-500 mt-0.5">Kantor Akuntan Publik &amp; BAE</p>
                            </div>
                        </a>

                        <a href="#keterbukaan-informasi"
                           class="flex items-start gap-3 p-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-xs transition-colors sidebar-nav-link"
                           data-target="keterbukaan-informasi">
                            <span class="text-xs font-bold text-slate-400 w-5">02</span>
                            <div>
                                <p class="text-xs font-semibold leading-tight">Keterbukaan Informasi &amp; Pengumuman</p>
                                <p class="text-[11px] font-normal text-slate-500 mt-0.5">Fakta material, buyback &amp; dividen</p>
                            </div>
                        </a>

                        <a href="#hubungi-investor"
                           class="flex items-start gap-3 p-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-xs transition-colors sidebar-nav-link"
                           data-target="hubungi-investor">
                            <span class="text-xs font-bold text-slate-400 w-5">03</span>
                            <div>
                                <p class="text-xs font-semibold leading-tight">Hubungi Hubungan Investor</p>
                                <p class="text-[11px] font-normal text-slate-500 mt-0.5">Hotline &amp; permohonan dokumen</p>
                            </div>
                        </a>
                    </nav>

                    <!-- Transparansi Wajib Card -->
                    <div class="mt-6 pt-4 border-t border-slate-100 bg-sky-50/60 rounded-xl p-3.5 text-xs text-sky-950 border border-sky-100">
                        <div class="flex items-center gap-2 font-bold mb-1 text-sky-800">
                            <i class="fa-solid fa-file-circle-check text-sky-600"></i>
                            Transparansi Wajib
                        </div>
                        <p class="text-[11px] text-sky-700 leading-relaxed">
                            Keterbukaan informasi disampaikan secara serentak ke <strong>PT Bursa Efek Indonesia (IDXNet)</strong> dan <strong>Otoritas Jasa Keuangan (SPE-OJK)</strong>.
                        </p>
                    </div>

                    <!-- Komitmen Investor Card -->
                    <div class="bg-[#0b1c30] text-white rounded-xl p-4 shadow-sm">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                            KOMITMEN INVESTOR
                        </span>
                        <div class="flex items-baseline gap-2 mb-1">
                            <span class="text-3xl font-extrabold text-white">100%</span>
                            <span class="text-xs font-medium text-emerald-400">Kepatuhan Pelaporan</span>
                        </div>
                        <p class="text-[11px] text-slate-300 leading-relaxed">
                            Jasuindo menerapkan tata kelola pelaporan keuangan yang tepat waktu sesuai standar IFRS dan Standar Akuntansi Keuangan (SAK).
                        </p>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- RIGHT CONTENT AREA -->
            <!-- ========================================== -->
            <div class="lg:col-span-8 xl:col-span-9 space-y-12">

                <!-- ------------------------------------------ -->
                <!-- SECTION 01: LEMBAGA PENUNJANG PASAR MODAL -->
                <!-- ------------------------------------------ -->
                <section id="lembaga-penunjang" class="scroll-mt-32">
                    <div class="mb-4">
                        <span class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                            Profesi Independen
                        </span>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2 font-serif" style="font-family: 'Noto Serif', serif, system-ui;">
                            Lembaga Penunjang Pasar Modal
                        </h2>
                        <p class="text-xs md:text-sm text-slate-500 mt-1 max-w-2xl">
                            Institusi dan profesi penunjang pasar modal yang ditunjuk secara resmi oleh Perseroan untuk menjaga independensi, akuntabilitas, serta kepatuhan tata kelola publik.
                        </p>
                    </div>

                    <!-- Cards of Lembaga Penunjang -->
                    <div class="space-y-4">
                        @foreach($lembagaList as $lembaga)
                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80 hover:border-[#0099ff] transition-all">
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-4">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0051d5] flex items-center justify-center flex-shrink-0 text-base">
                                            <i class="fa-solid {{ $lembaga->Kategori === 'Biro Administrasi Efek (BAE)' ? 'fa-building-columns' : 'fa-calculator' }}"></i>
                                        </div>
                                        <div>
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-[#0051d5] block mb-0.5">
                                                {{ $lembaga->Kategori }}
                                            </span>
                                            <h3 class="font-bold text-slate-900 text-base md:text-lg leading-snug">
                                                {{ $lembaga->NamaInstitusi }}
                                            </h3>
                                            @if($lembaga->Afiliasi)
                                                <p class="text-xs text-slate-500 mt-0.5">{{ $lembaga->Afiliasi }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    @if($lembaga->Website)
                                        <a href="{{ $lembaga->Website }}" target="_blank"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200 transition-colors self-start whitespace-nowrap">
                                            <span>{{ parse_url($lembaga->Website, PHP_URL_HOST) ?? $lembaga->Website }}</span>
                                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                        </a>
                                    @endif
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-slate-100 text-xs text-slate-600">
                                    @if($lembaga->KantorPusat)
                                        <div class="bg-slate-50/70 p-3.5 rounded-xl border border-slate-100">
                                            <span class="font-bold text-slate-800 block mb-1">
                                                {{ $lembaga->Kategori === 'Biro Administrasi Efek (BAE)' ? 'Alamat Operasional:' : 'Kantor Pusat:' }}
                                            </span>
                                            <p class="whitespace-pre-line leading-relaxed text-slate-600 text-[11px]">
                                                {{ $lembaga->KantorPusat }}
                                            </p>
                                        </div>
                                    @endif

                                    @if($lembaga->Cabang)
                                        <div class="bg-slate-50/70 p-3.5 rounded-xl border border-slate-100">
                                            <span class="font-bold text-slate-800 block mb-1">Cabang Surabaya:</span>
                                            <p class="whitespace-pre-line leading-relaxed text-slate-600 text-[11px]">
                                                {{ $lembaga->Cabang }}
                                            </p>
                                        </div>
                                    @elseif($lembaga->Layanan)
                                        <div class="bg-slate-50/70 p-3.5 rounded-xl border border-slate-100">
                                            <span class="font-bold text-slate-800 block mb-1">Ruang Lingkup Layanan:</span>
                                            <p class="text-[11px] text-slate-600 leading-relaxed">
                                                {{ $lembaga->Layanan }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- ------------------------------------------ -->
                <!-- SECTION 02: KETERBUKAAN INFORMASI -->
                <!-- ------------------------------------------ -->
                <section id="keterbukaan-informasi" class="scroll-mt-32">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                        <div>
                            <span class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                Arsip Regulasi
                            </span>
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2 font-serif" style="font-family: 'Noto Serif', serif, system-ui;">
                                Keterbukaan Informasi &amp; Pengumuman Material
                            </h2>
                            <p class="text-xs md:text-sm text-slate-500 mt-1">
                                Arsip lengkap pengumuman resmi keterbukaan informasi fakta material, dividen interim, aksi korporasi, serta buletin berkala Perseroan.
                            </p>
                        </div>
                        <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-xl self-start whitespace-nowrap">
                            <i class="fa-solid fa-box-archive mr-1.5 text-slate-400"></i> {{ $keterbukaanList->total() }} Dokumen Tersisip
                        </span>
                    </div>

                    <!-- Search and Filters Form -->
                    <form method="GET" action="{{ route('frontend.investor.informasi-lainnya', ['locale' => app()->getLocale()]) }}#keterbukaan-informasi"
                          class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 mb-6">
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                            <div class="sm:col-span-6 relative">
                                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                <input type="text" name="q" value="{{ request('q') }}"
                                       placeholder="Cari keterbukaan informasi, dividen, buyback, dsb..."
                                       class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-[#0099ff] outline-none">
                            </div>

                            <div class="sm:col-span-3">
                                <select name="tahun" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 outline-none">
                                    <option value="all">Semua Tahun</option>
                                    @foreach($tahunList as $th)
                                        <option value="{{ $th }}" {{ request('tahun') == $th ? 'selected' : '' }}>Tahun {{ $th }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="sm:col-span-3 flex gap-2">
                                <select name="kategori" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 outline-none">
                                    <option value="all">Semua Kategori</option>
                                    @foreach($kategoriList as $kat)
                                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="px-4 py-2 bg-[#0099ff] hover:bg-blue-600 text-white rounded-xl text-xs font-bold transition-colors">
                                    Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Document Cards List -->
                    <div class="space-y-3 mb-6">
                        @forelse($keterbukaanList as $item)
                            @php
                                $badgeColor = 'bg-blue-50 text-[#0051d5] border-blue-200';
                                if ($item->Kategori === 'Buyback Saham') $badgeColor = 'bg-indigo-50 text-indigo-700 border-indigo-200';
                                elseif ($item->Kategori === 'Dividen') $badgeColor = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                elseif ($item->Kategori === 'Aksi Korporasi') $badgeColor = 'bg-purple-50 text-purple-700 border-purple-200';
                                elseif ($item->Kategori === 'Buletin Investor') $badgeColor = 'bg-sky-50 text-sky-700 border-sky-200';
                            @endphp

                            <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 hover:border-[#0099ff] hover:shadow-md transition-all">
                                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                    <div class="flex items-start gap-3.5">
                                        <div class="w-9 h-9 rounded-lg bg-blue-50 text-[#0051d5] flex items-center justify-center flex-shrink-0 text-xs">
                                            <i class="fa-regular fa-file-pdf"></i>
                                        </div>
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded border {{ $badgeColor }}">
                                                    {{ $item->Kategori }}
                                                </span>
                                                <span class="text-[11px] text-slate-400 font-medium">
                                                    {{ $item->TanggalPublikasi ? $item->TanggalPublikasi->format('d F Y') : '-' }}
                                                </span>
                                                @if($item->FileSize)
                                                    <span class="text-[10px] text-slate-400">&bull; PDF ({{ $item->FileSize }})</span>
                                                @endif
                                            </div>
                                            <h3 class="font-bold text-slate-900 text-sm md:text-base leading-snug">
                                                {{ $item->Judul }}
                                            </h3>
                                            @if($item->Deskripsi)
                                                <p class="text-xs text-slate-500 mt-1 leading-relaxed line-clamp-2">
                                                    {{ $item->Deskripsi }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    @if($item->PathFile)
                                        <a href="{{ asset('storage/' . $item->PathFile) }}" target="_blank"
                                           class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-[#0099ff] text-slate-700 hover:text-white font-semibold text-xs border border-slate-200 transition-colors self-end sm:self-center whitespace-nowrap shadow-sm">
                                            <i class="fa-solid fa-download text-xs"></i> Unduh PDF
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center bg-white rounded-2xl border border-slate-200 text-slate-500 text-xs">
                                Tidak ada dokumen keterbukaan informasi yang sesuai dengan filter pencarian.
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($keterbukaanList->hasPages())
                        <div class="flex justify-center mt-6">
                            {{ $keterbukaanList->links() }}
                        </div>
                    @endif
                </section>

                <!-- ------------------------------------------ -->
                <!-- SECTION 03: HUBUNGI HUBUNGAN INVESTOR -->
                <!-- ------------------------------------------ -->
                <section id="hubungi-investor" class="scroll-mt-32">
                    <div class="mb-4">
                        <span class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                            Akses Korporasi
                        </span>
                        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2 font-serif" style="font-family: 'Noto Serif', serif, system-ui;">
                            Hubungi Hubungan Investor Jasuindo
                        </h2>
                        <p class="text-xs md:text-sm text-slate-500 mt-1">
                            Tim Sekretariat Perusahaan dan Hubungan Investor senantiasa siap melayani pertanyaan seputar tata kelola, hak suara saham, serta jadwal acara keterbukaan publik.
                        </p>
                    </div>

                    <!-- Contact Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-[#0051d5] flex items-center justify-center text-base mb-3">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                Surat Elektronik Resmi
                            </span>
                            <a href="mailto:corsec@jasuindo.com" class="text-sm md:text-base font-bold text-[#0051d5] hover:underline block mb-2">
                                corsec@jasuindo.com
                            </a>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Gunakan email ini untuk korespondensi resmi analis pasar modal, pendaftaran RUPS, dan klarifikasi keterbukaan berita.
                            </p>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
                            <div class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-base mb-3">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                Hotline Langsung Sidoarjo &amp; Jakarta
                            </span>
                            <span class="text-sm md:text-base font-bold text-slate-900 block mb-2">
                                +62 31 891 0619
                            </span>
                            <p class="text-xs text-slate-500 leading-relaxed">
                                Layanan aktif pada hari kerja bursa: Senin – Jumat pukul 08.30 – 17.00 WIB (kecuali hari libur nasional).
                            </p>
                        </div>
                    </div>

                    <!-- Request Physical Report CTA Banner -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <h4 class="font-bold text-slate-900 text-sm">
                                Membutuhkan salinan fisik Laporan Tahunan atau Prospektus?
                            </h4>
                            <p class="text-xs text-slate-500 mt-0.5">
                                Kami mengirimkan dokumen cetak resmi secara berkala kepada analis dan pemegang saham yang terverifikasi.
                            </p>
                        </div>
                        <button type="button" id="btn-open-permintaan"
                                class="px-5 py-2.5 rounded-xl bg-[#0b1c30] hover:bg-slate-800 text-white font-bold text-xs transition-colors shadow-sm whitespace-nowrap self-stretch sm:self-auto text-center">
                            <i class="fa-solid fa-paper-plane mr-1.5"></i> Kirim Permintaan Dokumen
                        </button>
                    </div>
                </section>

            </div>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- MODAL: PERMINTAAN SALINAN FISIK DOKUMEN -->
<!-- ========================================== -->
<div id="modal-permintaan" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto relative">
        <button type="button" id="close-permintaan-modal" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-lg">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="mb-4 pb-3 border-b border-slate-100">
            <span class="text-[10px] font-bold uppercase tracking-wider text-[#0051d5] bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                Layanan Cetak Investor
            </span>
            <h3 class="text-xl font-bold text-slate-900 mt-1">
                Permintaan Salinan Fisik Dokumen
            </h3>
            <p class="text-xs text-slate-500 mt-0.5">
                Silakan isi alamat lengkap pengiriman untuk pengiriman berkas cetak resmi.
            </p>
        </div>

        <form id="form-permintaan-dokumen" class="space-y-3.5 text-xs">
            @csrf
            <div>
                <label class="block font-bold text-slate-700 mb-1">Nama Lengkap *</label>
                <input type="text" name="Nama" required placeholder="Nama Anda atau perwakilan institusi..."
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Email *</label>
                    <input type="email" name="Email" required placeholder="nama@email.com"
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nomor Telepon / WA *</label>
                    <input type="text" name="Telepon" required placeholder="+62 812..."
                           class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Institusi / Perusahaan (Opsional)</label>
                <input type="text" name="Institusi" placeholder="Sekuritas, universitas, atau kantor..."
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Jenis Dokumen yang Diminta *</label>
                <select name="JenisDokumen" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                    <option value="Laporan Tahunan (Annual Report) Terbaru">Laporan Tahunan (Annual Report) Terbaru</option>
                    <option value="Laporan Keberlanjutan (Sustainability Report)">Laporan Keberlanjutan (Sustainability Report)</option>
                    <option value="Prospektus Ringkas Korporasi">Prospektus Ringkas Korporasi</option>
                    <option value="Profil Perusahaan (Company Profile Book)">Profil Perusahaan (Company Profile Book)</option>
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Alamat Lengkap Pengiriman *</label>
                <textarea name="AlamatPengiriman" rows="3" required placeholder="Nama jalan, gedung/lantai, nomor, RT/RW, kota, provinsi, dan kode pos..."
                          class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-700 mb-1">Catatan Tambahan</label>
                <input type="text" name="Catatan" placeholder="Kebutuhan khusus atau tujuan permintaan berkas..."
                       class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
            </div>

            <div class="pt-2 flex justify-end gap-2">
                <button type="button" id="cancel-permintaan-btn" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs">
                    Batal
                </button>
                <button type="submit" id="submit-permintaan-btn" class="px-5 py-2 bg-[#0099ff] hover:bg-blue-600 text-white font-bold rounded-xl text-xs shadow-sm">
                    Kirim Permintaan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Permintaan Dokumen
        const modal = document.getElementById('modal-permintaan');
        const btnOpen = document.getElementById('btn-open-permintaan');
        const closeBtns = [document.getElementById('close-permintaan-modal'), document.getElementById('cancel-permintaan-btn')];

        if (btnOpen) {
            btnOpen.addEventListener('click', () => modal.classList.remove('hidden'));
        }
        closeBtns.forEach(b => {
            if (b) b.addEventListener('click', () => modal.classList.add('hidden'));
        });

        // Submit Permintaan Form via Ajax
        const form = document.getElementById('form-permintaan-dokumen');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const submitBtn = document.getElementById('submit-permintaan-btn');
                submitBtn.disabled = true;
                submitBtn.innerText = 'Mengirim...';

                fetch("{{ route('frontend.investor.permintaan-dokumen.store', ['locale' => app()->getLocale()]) }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message);
                    form.reset();
                    modal.classList.add('hidden');
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Kirim Permintaan';
                })
                .catch(err => {
                    alert('Terjadi kendala saat mengirimkan permohonan dokumen. Silakan hubungi langsung via corsec@jasuindo.com.');
                    submitBtn.disabled = false;
                    submitBtn.innerText = 'Kirim Permintaan';
                });
            });
        }
    });
</script>
@endpush

@endsection

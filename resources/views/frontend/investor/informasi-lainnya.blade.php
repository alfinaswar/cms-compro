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
                <!-- LEFT SIDEBAR -->
                <!-- ========================================== -->
                <div class="lg:col-span-4 xl:col-span-3 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200/80 p-5 sticky top-36">
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                            <span class="text-[11px] font-bold text-slate-500 tracking-wider uppercase">
                                {{ __('investor.on_this_page') }}
                            </span>
                            <i class="fa-solid fa-bars-staggered text-slate-400 text-xs"></i>
                        </div>

                        <nav class="space-y-1.5" id="informasi-lainnya-nav">
                            <a href="#lembaga-penunjang"
                                class="flex items-start gap-3 p-2.5 rounded-lg bg-blue-50 text-[#0051d5] font-semibold text-xs transition-colors sidebar-nav-link"
                                data-target="lembaga-penunjang">
                                <span class="text-xs font-bold w-5">01</span>
                                <div>
                                    <p class="text-xs font-bold leading-tight">{{ __('investor.other_nav_capital_market') }}
                                    </p>
                                    <p class="text-[11px] font-normal text-slate-500 mt-0.5">
                                        {{ __('investor.other_nav_capital_market_desc') }}</p>
                                </div>
                            </a>

                            <a href="#keterbukaan-informasi"
                                class="flex items-start gap-3 p-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-xs transition-colors sidebar-nav-link"
                                data-target="keterbukaan-informasi">
                                <span class="text-xs font-bold text-slate-400 w-5">02</span>
                                <div>
                                    <p class="text-xs font-semibold leading-tight">{{ __('investor.other_nav_disclosure') }}
                                    </p>
                                    <p class="text-[11px] font-normal text-slate-500 mt-0.5">
                                        {{ __('investor.other_nav_disclosure_desc') }}</p>
                                </div>
                            </a>

                            <a href="#hubungi-investor"
                                class="flex items-start gap-3 p-2.5 rounded-lg text-slate-700 hover:bg-slate-50 text-xs transition-colors sidebar-nav-link"
                                data-target="hubungi-investor">
                                <span class="text-xs font-bold text-slate-400 w-5">03</span>
                                <div>
                                    <p class="text-xs font-semibold leading-tight">{{ __('investor.other_nav_ir') }}</p>
                                    <p class="text-[11px] font-normal text-slate-500 mt-0.5">
                                        {{ __('investor.other_nav_ir_desc') }}</p>
                                </div>
                            </a>
                        </nav>

                        <div
                            class="mt-6 pt-4 border-t border-slate-100 bg-sky-50/60 rounded-xl p-3.5 text-xs text-sky-950 border border-sky-100">
                            <div class="flex items-center gap-2 font-bold mb-1 text-sky-800">
                                <i class="fa-solid fa-file-circle-check text-sky-600"></i>
                                {{ __('investor.mandatory_title') }}
                            </div>
                            <p class="text-[11px] text-sky-700 leading-relaxed">
                                {!! __('investor.mandatory_desc') !!}
                            </p>
                        </div>

                        <div class="bg-[#0b1c30] text-white rounded-xl p-4 shadow-sm">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                {{ __('investor.commitment_label') }}
                            </span>
                            <div class="flex items-baseline gap-2 mb-1">
                                <span class="text-3xl font-extrabold text-white">100%</span>
                                <span
                                    class="text-xs font-medium text-emerald-400">{{ __('investor.commitment_stat') }}</span>
                            </div>
                            <p class="text-[11px] text-slate-300 leading-relaxed">
                                {{ __('investor.commitment_desc') }}
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
                            <span
                                class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                {{ __('investor.other_s1_badge') }}
                            </span>
                            <!-- FONT DIUBAH: Menghapus font-serif dan inline style agar seragam dengan Plus Jakarta Sans -->
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                                {{ __('investor.other_s1_title') }}
                            </h2>
                            <p class="text-xs md:text-sm text-slate-500 mt-1 max-w-2xl">
                                {{ __('investor.other_s1_desc') }}
                            </p>
                        </div>

                        <div class="space-y-4">
                            @foreach ($lembagaList as $lembaga)
                                <div
                                    class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80 hover:border-[#0099ff] transition-all">
                                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-4">
                                        <div class="flex items-start gap-3.5">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-blue-50 text-[#0051d5] flex items-center justify-center flex-shrink-0 text-base">
                                                <i
                                                    class="fa-solid {{ $lembaga->Kategori === 'Biro Administrasi Efek (BAE)' ? 'fa-building-columns' : 'fa-calculator' }}"></i>
                                            </div>
                                            <div>
                                                <span
                                                    class="text-[10px] font-bold uppercase tracking-wider text-[#0051d5] block mb-0.5">
                                                    {{ $lembaga->Kategori === 'Biro Administrasi Efek (BAE)' ? __('investor.other_cat_bae') : __('investor.other_cat_auditor') }}
                                                </span>
                                                <h3 class="font-bold text-slate-900 text-base md:text-lg leading-snug">
                                                    {{ $lembaga->NamaInstitusi }}</h3>
                                                @if ($lembaga->Afiliasi)
                                                    <p class="text-xs text-slate-500 mt-0.5">{{ $lembaga->Afiliasi }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        @if ($lembaga->Website)
                                            <a href="{{ $lembaga->Website }}" target="_blank"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-slate-50 hover:bg-slate-100 text-slate-700 text-xs font-semibold border border-slate-200 transition-colors self-start whitespace-nowrap">
                                                <span>{{ parse_url($lembaga->Website, PHP_URL_HOST) ?? $lembaga->Website }}</span>
                                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                            </a>
                                        @endif
                                    </div>

                                    <div
                                        class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-slate-100 text-xs text-slate-600">
                                        @if ($lembaga->KantorPusat)
                                            <div class="bg-slate-50/70 p-3.5 rounded-xl border border-slate-100">
                                                <span class="font-bold text-slate-800 block mb-1">
                                                    {{ $lembaga->Kategori === 'Biro Administrasi Efek (BAE)' ? __('investor.other_address_operational') : __('investor.other_address_hq') }}
                                                </span>
                                                <p class="whitespace-pre-line leading-relaxed text-slate-600 text-[11px]">
                                                    {{ $lembaga->KantorPusat }}</p>
                                            </div>
                                        @endif

                                        @if ($lembaga->Cabang)
                                            <div class="bg-slate-50/70 p-3.5 rounded-xl border border-slate-100">
                                                <span
                                                    class="font-bold text-slate-800 block mb-1">{{ __('investor.other_address_branch') }}:</span>
                                                <p class="whitespace-pre-line leading-relaxed text-slate-600 text-[11px]">
                                                    {{ $lembaga->Cabang }}</p>
                                            </div>
                                        @elseif($lembaga->Layanan)
                                            <div class="bg-slate-50/70 p-3.5 rounded-xl border border-slate-100">
                                                <span
                                                    class="font-bold text-slate-800 block mb-1">{{ __('investor.other_scope_label') }}:</span>
                                                <p class="text-[11px] text-slate-600 leading-relaxed">
                                                    {{ $lembaga->Layanan }}</p>
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
                                <span
                                    class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                    {{ __('investor.other_s2_badge') }}
                                </span>
                                <!-- FONT DIUBAH: Menghapus font-serif dan inline style -->
                                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                                    {{ __('investor.other_s2_title') }}
                                </h2>
                                <p class="text-xs md:text-sm text-slate-500 mt-1">{{ __('investor.other_s2_desc') }}</p>
                            </div>
                            <span
                                class="text-xs font-semibold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-xl self-start whitespace-nowrap">
                                <i class="fa-solid fa-box-archive mr-1.5 text-slate-400"></i>
                                {{ $keterbukaanList->total() }} {{ __('investor.other_s2_doc_count') }}
                            </span>
                        </div>

                        <form method="GET"
                            action="{{ route('frontend.investor.informasi-lainnya', ['locale' => app()->getLocale()]) }}#keterbukaan-informasi"
                            class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 mb-6">
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                                <div class="sm:col-span-6 relative">
                                    <i
                                        class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                    <input type="text" name="q" value="{{ request('q') }}"
                                        placeholder="{{ __('investor.other_s2_search_placeholder') }}"
                                        class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-[#0099ff] outline-none">
                                </div>

                                <div class="sm:col-span-3">
                                    <select name="tahun"
                                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 outline-none">
                                        <option value="all">{{ __('investor.other_s2_all_years') }}</option>
                                        @foreach ($tahunList as $th)
                                            <option value="{{ $th }}"
                                                {{ request('tahun') == $th ? 'selected' : '' }}>
                                                {{ __('investor.other_s2_year_prefix') }} {{ $th }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="sm:col-span-3 flex gap-2">
                                    <select name="kategori"
                                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-700 outline-none">
                                        <option value="all">{{ __('investor.other_s2_all_categories') }}</option>
                                        @foreach ($kategoriList as $kat)
                                            <option value="{{ $kat }}"
                                                {{ request('kategori') == $kat ? 'selected' : '' }}>{{ __($kat) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit"
                                        class="px-4 py-2 bg-[#0099ff] hover:bg-blue-600 text-white rounded-xl text-xs font-bold transition-colors">
                                        {{ __('Filter') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="space-y-3 mb-6">
                            @forelse($keterbukaanList as $item)
                                @php
                                    $badgeColor = 'bg-blue-50 text-[#0051d5] border-blue-200';
                                    if ($item->Kategori === 'Buyback Saham') {
                                        $badgeColor = 'bg-indigo-50 text-indigo-700 border-indigo-200';
                                    } elseif ($item->Kategori === 'Dividen') {
                                        $badgeColor = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                    } elseif ($item->Kategori === 'Aksi Korporasi') {
                                        $badgeColor = 'bg-purple-50 text-purple-700 border-purple-200';
                                    } elseif ($item->Kategori === 'Buletin Investor') {
                                        $badgeColor = 'bg-sky-50 text-sky-700 border-sky-200';
                                    }
                                @endphp

                                <div
                                    class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 hover:border-[#0099ff] hover:shadow-md transition-all">
                                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                        <div class="flex items-start gap-3.5">
                                            <div
                                                class="w-9 h-9 rounded-lg bg-blue-50 text-[#0051d5] flex items-center justify-center flex-shrink-0 text-xs">
                                                <i class="fa-regular fa-file-pdf"></i>
                                            </div>
                                            <div>
                                                <div class="flex flex-wrap items-center gap-2 mb-1.5">
                                                    <span
                                                        class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded border {{ $badgeColor }}">
                                                        {{ __($item->Kategori) }}
                                                    </span>
                                                    <span class="text-[11px] text-slate-400 font-medium">
                                                        {{ $item->TanggalPublikasi ? $item->TanggalPublikasi->isoFormat('D MMMM YYYY') : '-' }}
                                                    </span>
                                                    @if ($item->FileSize)
                                                        <span class="text-[10px] text-slate-400">&bull; PDF
                                                            ({{ $item->FileSize }})
                                                        </span>
                                                    @endif
                                                </div>
                                                <h3 class="font-bold text-slate-900 text-sm md:text-base leading-snug">
                                                    {{ $item->Judul }}</h3>
                                                @if ($item->Deskripsi)
                                                    <p class="text-xs text-slate-500 mt-1 leading-relaxed line-clamp-2">
                                                        {{ $item->Deskripsi }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        @if ($item->PathFile)
                                            <a href="{{ asset('storage/' . $item->PathFile) }}" target="_blank"
                                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-50 hover:bg-[#0099ff] text-slate-700 hover:text-white font-semibold text-xs border border-slate-200 transition-colors self-end sm:self-center whitespace-nowrap shadow-sm">
                                                <i class="fa-solid fa-download text-xs"></i>
                                                {{ __('investor.other_s2_download') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="p-8 text-center bg-white rounded-2xl border border-slate-200 text-slate-500 text-xs">
                                    {{ __('investor.other_s2_empty') }}
                                </div>
                            @endforelse
                        </div>

                        @if ($keterbukaanList->hasPages())
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
                            <span
                                class="text-[10px] font-bold tracking-wider uppercase text-[#0051d5] bg-blue-50 px-2.5 py-1 rounded-full border border-blue-100">
                                {{ __('investor.other_s3_badge') }}
                            </span>
                            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mt-2">
                                {{ __('investor.other_s3_title') }}
                            </h2>
                            <p class="text-xs md:text-sm text-slate-500 mt-1">{{ __('investor.other_s3_desc') }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-50 text-[#0051d5] flex items-center justify-center text-base mb-3">
                                    <i class="fa-regular fa-envelope"></i>
                                </div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                    {{ __('investor.other_s3_email_label') }}
                                </span>
                                <a href="mailto:{{ $kantor->HubunganInvestorEmail ?? 'corporate@jasuindo.com' }}"
                                    class="text-sm md:text-base font-bold text-[#0051d5] hover:underline block mb-2">
                                    {{ $kantor?->Email ?? 'corporate@jasuindo.com' }}
                                </a>
                                <p class="text-xs text-slate-500 leading-relaxed">{{ __('investor.other_s3_email_desc') }}
                                </p>
                            </div>

                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80">
                                <div
                                    class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-base mb-3">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                    {{ __('investor.other_s3_phone_label') }}
                                </span>
                                <span class="text-sm md:text-base font-bold text-slate-900 block mb-2">
                                    {{ $kantor?->NomorTelepon ?? '+62 31 891 0619' }}
                                </span>
                                <p class="text-xs text-slate-500 leading-relaxed">{{ __('investor.other_s3_phone_desc') }}
                                </p>
                            </div>
                        </div>

                        <div
                            class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200/80 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">{{ __('investor.other_s3_physical_title') }}
                                </h4>
                                <p class="text-xs text-slate-500 mt-0.5">{{ __('investor.other_s3_physical_desc') }}</p>
                                @if ($kantor->AlamatLengkap)
                                    <div class="mt-2 text-xs text-slate-700">
                                        <i class="fa-solid fa-location-dot mr-1 text-[13px] text-[#0051d5]"></i>
                                        {{ $kantor->AlamatLengkap }}
                                    </div>
                                @endif
                            </div>
                            <button type="button" id="btn-open-permintaan"
                                class="px-5 py-2.5 rounded-xl bg-[#0b1c30] hover:bg-slate-800 text-white font-bold text-xs transition-colors shadow-sm whitespace-nowrap self-stretch sm:self-auto text-center">
                                <i class="fa-solid fa-paper-plane mr-1.5"></i> {{ __('investor.other_s3_physical_btn') }}
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
    <div id="modal-permintaan"
        class="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div
            class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 max-h-[90vh] overflow-y-auto relative">
            <button type="button" id="close-permintaan-modal"
                class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="mb-4 pb-3 border-b border-slate-100">
                <span
                    class="text-[10px] font-bold uppercase tracking-wider text-[#0051d5] bg-blue-50 px-2 py-0.5 rounded border border-blue-100">
                    {{ __('investor.modal_service_label') }}
                </span>
                <h3 class="text-xl font-bold text-slate-900 mt-1">{{ __('investor.modal_title') }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ __('investor.modal_desc') }}</p>
            </div>

            <form id="form-permintaan-dokumen" class="space-y-3.5 text-xs">
                @csrf
                <div>
                    <label class="block font-bold text-slate-700 mb-1">{{ __('investor.modal_name') }} *</label>
                    <input type="text" name="Nama" required placeholder="{{ __('investor.modal_name_ph') }}"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">{{ __('investor.modal_email') }} *</label>
                        <input type="email" name="Email" required placeholder="nama@email.com"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">{{ __('investor.modal_phone') }} *</label>
                        <input type="text" name="Telepon" required placeholder="+62 812..."
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">{{ __('investor.modal_institution') }}</label>
                    <input type="text" name="Institusi" placeholder="{{ __('investor.modal_institution_ph') }}"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">{{ __('investor.modal_doc_type') }} *</label>
                    <select name="JenisDokumen" required
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                        <option value="Laporan Tahunan (Annual Report) Terbaru">{{ __('investor.modal_doc_type_ar') }}
                        </option>
                        <option value="Laporan Keberlanjutan (Sustainability Report)">
                            {{ __('investor.modal_doc_type_sr') }}</option>
                        <option value="Prospektus Ringkas Korporasi">{{ __('investor.modal_doc_type_prospectus') }}
                        </option>
                        <option value="Profil Perusahaan (Company Profile Book)">
                            {{ __('investor.modal_doc_type_profile') }}</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">{{ __('investor.modal_address') }} *</label>
                    <textarea name="AlamatPengiriman" rows="3" required placeholder="{{ __('investor.modal_address_ph') }}"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">{{ __('investor.modal_notes') }}</label>
                    <input type="text" name="Catatan" placeholder="{{ __('investor.modal_notes_ph') }}"
                        class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs outline-none focus:bg-white focus:border-[#0099ff]">
                </div>

                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" id="cancel-permintaan-btn"
                        class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-xs">
                        {{ __('Cancel') }}
                    </button>
                    <button type="submit" id="submit-permintaan-btn"
                        class="px-5 py-2 bg-[#0099ff] hover:bg-blue-600 text-white font-bold rounded-xl text-xs shadow-sm">
                        {{ __('investor.modal_submit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Modal Logic
                const modal = document.getElementById('modal-permintaan');
                const btnOpen = document.getElementById('btn-open-permintaan');
                const closeBtns = [document.getElementById('close-permintaan-modal'), document.getElementById(
                    'cancel-permintaan-btn')];

                if (btnOpen) {
                    btnOpen.addEventListener('click', () => modal.classList.remove('hidden'));
                }
                closeBtns.forEach(b => {
                    if (b) b.addEventListener('click', () => modal.classList.add('hidden'));
                });

                // Form Submit Logic
                const form = document.getElementById('form-permintaan-dokumen');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const formData = new FormData(this);
                        const submitBtn = document.getElementById('submit-permintaan-btn');

                        submitBtn.disabled = true;
                        submitBtn.innerText = '{{ __('investor.modal_sending') }}';

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
                                submitBtn.innerText = '{{ __('investor.modal_submit') }}';
                            })
                            .catch(err => {
                                alert('{{ __('investor.modal_error') }}');
                                submitBtn.disabled = false;
                                submitBtn.innerText = '{{ __('investor.modal_submit') }}';
                            });
                    });
                }
            });
        </script>
    @endpush
@endsection

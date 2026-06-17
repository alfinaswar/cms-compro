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
                    <span
                        class="text-brand-600 font-bold tracking-wider uppercase text-sm">{{ $Riwayat->SubJudul ?? null }}</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2 mb-6">{{ $Riwayat->Judul }}</h2>
                    <div class="space-y-4 text-slate-600 leading-relaxed">
                        {!! $Riwayat->Deskripsi !!}
                    </div>

                    {{-- <div class="mt-8 grid grid-cols-3 gap-6">
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
                    </div> --}}
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
                <span class="text-brand-600 font-bold tracking-wider uppercase text-sm">{{ $Value->SubJudul }}</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2 mb-4">{{ $Value->Judul }}</h2>
                <p class="text-slate-600 text-lg">{!! $Value->Deskripsi !!}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                @forelse ($Value->getDetail as $detail)
                    <div class="value-card bg-white rounded-2xl p-8 shadow-lg border border-slate-100">
                        <div class="w-16 h-16 bg-brand-100 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fa-solid fa-users text-3xl text-brand-600"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">{{ $detail->Judul }}</h3>
                        <p class="text-slate-600 leading-relaxed">
                            {!! $detail->Deskripsi !!}

                        </p>
                    </div>

                @empty
                @endforelse


            </div>
            {{-- <div class="bg-gradient-to-br from-brand-900 to-brand-800 rounded-3xl p-8 md:p-12 text-white">
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
            </div> --}}
        </div>
    </section>

    <!-- CORPORATE SOCIAL RESPONSIBILITY -->
    <section id="solusi" class="py-24 bg-white">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span
                    class="text-brand-600 font-bold tracking-wider uppercase text-sm">{{ $TanggungJawab->SubJudul }}</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2 mb-4">{{ $TanggungJawab->Judul }}</h2>
                <p class="text-slate-600 text-lg">{!! $TanggungJawab->Deskripsi !!}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                @forelse ($TanggungJawab->getDetail as $detail)
                    <div class="solution-card group bg-white rounded-2xl overflow-hidden border border-slate-100">
                        <div class="relative h-48 overflow-hidden">
                            @if (!empty($detail->Gambar))
                                <img src="{{ asset('storage/' . $detail->Gambar) }}" alt="{{ $detail->Judul }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <img src="https://via.placeholder.com/400x192?text=No+Image" alt="No Image"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-brand-600 transition-colors">
                                {{ $detail->Judul }}
                            </h3>
                            <p class="text-slate-600 text-sm leading-relaxed mb-4">
                                {!! $detail->Deskripsi !!}
                            </p>

                        </div>
                    </div>
                @empty
                @endforelse


            </div>
        </div>
    </section>

    <!-- AWARDS & CERTIFICATIONS -->
    <section class="py-20 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="text-brand-600 font-bold tracking-wider uppercase text-sm">{{ $Award->SubJudul }}</span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mt-2 mb-4">{{ $Award->Judul }}</h2>
                <p class="text-slate-600 text-lg">
                    {!! $Award->Deskripsi !!}
                </p>
            </div>

            <!-- Awards & Certifications (List Style) -->
            <div class="divide-y divide-slate-200 bg-white rounded-xl shadow border border-slate-100 overflow-hidden">

                @forelse ($Award->getDetail as $awardDetail)
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 px-8 py-7">
                        <div class="flex-shrink-0 w-32 flex items-center justify-center">
                            @if (!empty($awardDetail->Gambar))
                                <img src="{{ asset('storage/' . $awardDetail->Gambar) }}" alt="{{ $awardDetail->Judul }}"
                                    class="w-28 h-auto object-contain grayscale opacity-80" />
                            @else
                                <img src="https://via.placeholder.com/120x64?text=No+Image" alt="No Image"
                                    class="w-28 h-auto object-contain grayscale opacity-80" />
                            @endif
                        </div>
                        <div>
                            <div class="font-semibold text-slate-700 mb-1">{{ $awardDetail->Judul }}</div>
                            <div class="text-slate-600 text-sm leading-relaxed">
                                {!! $awardDetail->Deskripsi !!}
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

            </div>


        </div>

        <!-- Additional Note -->
        <div class="mt-12 text-center">
            <p class="text-slate-500 text-sm">
                <i class="fa-solid fa-info-circle mr-2"></i>
                Dan berbagai penghargaan lainnya yang terus kami raih sebagai bentuk komitmen terhadap
                excellence
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

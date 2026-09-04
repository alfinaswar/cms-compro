@extends('frontend.index')

@section('content-frontend')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-papKuU1u7bVY/vpZPGgoy7HvDxe4sdRQ+sbZoRbZrX7ALy0qF6kXrEvVuL6kXGqz2EmAb+uiFMw5bMjC9l5A0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    .sticky-sidebar {
        position: sticky;
        top: 100px;
        max-height: calc(100vh - 120px);
        overflow-y: auto;
    }
    .nav-item-active {
        background-color: #0ea5e9;
        color: white !important;
    }
    .report-card {
        transition: all 0.3s ease;
    }
    .report-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        border-color: #0ea5e9;
    }
    /* Smooth scroll offset */
    section[id] {
        scroll-margin-top: 100px;
    }
</style>
@endpush

<!-- ========================================== -->
<!-- HERO / BREADCRUMB SECTION -->
<!-- ========================================== -->
<section class="relative pt-32 pb-12 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-900">
    <div class="container mx-auto px-6 flex justify-center">
        <div class="max-w-4xl text-center">
            <nav class="flex justify-center items-center space-x-2 text-sm text-slate-300 mb-4">
                <a href="{{ url('/') }}" class="hover:text-white transition-colors">
                    <i class="fa-solid fa-house mr-1"></i> Home
                </a>
                <i class="fa-solid fa-chevron-right text-xs text-slate-500"></i>
                <span class="text-white font-semibold">Laporan Keuangan</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">Laporan Keuangan & Publikasi</h1>
            <p class="text-slate-300">Transparansi kinerja dan informasi keuangan perusahaan secara berkala</p>
        </div>
    </div>
</section>

<!-- ========================================== -->
<!-- MAIN CONTENT -->
<!-- ========================================== -->
<section class="py-12 bg-slate-50">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            <!-- ========================================== -->
            <!-- LEFT SIDEBAR (Sticky Navigation) -->
            <!-- ========================================== -->
            <div class="lg:col-span-3">
                <div class="sticky-sidebar bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="font-bold text-slate-900 mb-4 pb-3 border-b border-slate-200 flex items-center">
                        <i class="fa-solid fa-list-ul mr-2 text-brand-600"></i>
                        Kategori Laporan
                    </h3>

                    <nav class="space-y-1">
                        @foreach($categories as $category)
                            <a href="#{{ Str::slug($category->NamaJenis) }}"
                               class="nav-item flex items-center gap-2 px-3 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-brand-600 rounded-lg transition-colors">
                                <span class="inline-flex items-center justify-center w-6 h-6 bg-{{ $category->WarnaBadge ?? 'brand' }}-100 rounded mr-2">
                                    <i class="{{ $category->IconKategori ? $category->IconKategori : 'fa-regular fa-file' }} text-{{ $category->WarnaBadge ?? 'brand' }}-600"></i>
                                </span>
                                {{ $category->NamaJenis }}
                            </a>
                        @endforeach
                    </nav>



                    @if($availableYears->count() > 0)
                        <div class="mt-6 pt-6 border-t border-slate-200">
                            <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">
                                Filter Tahun
                            </h4>
                            <select id="yearFilter" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-700 focus:ring-2 focus:ring-brand-500 focus:border-brand-500 outline-none">
                                <option value="all">Semua Tahun</option>
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            </div>

            <!-- ========================================== -->
            <!-- RIGHT CONTENT (Dynamic Categories) -->
            <!-- ========================================== -->
            <div class="lg:col-span-9 space-y-12">

                @forelse($categories as $category)
                    <section id="{{ Str::slug($category->NamaJenis) }}" class="scroll-mt-24">

                        <!-- Category Header -->
                        <div class="flex items-start justify-between mb-6 pb-4 border-b border-slate-200">
                            <div>
                                <div class="flex items-center gap-3 mb-2">
                                    @if($category->IconKategori)
                                        <div class="w-10 h-10 bg-{{ $category->WarnaBadge ?? 'brand' }}-100 rounded-lg flex items-center justify-center">
                                            <i class="{{ $category->IconKategori }} text-{{ $category->WarnaBadge ?? 'brand' }}-600 text-lg"></i>
                                        </div>
                                    @endif
                                    <h2 class="text-2xl font-bold text-slate-900">{{ $category->NamaJenis }}</h2>
                                </div>
                                @if($category->Deskripsi)
                                    <p class="text-slate-600">{{ $category->Deskripsi }}</p>
                                @endif
                            </div>
                        </div>

                        @if($category->details->count() > 0)
                            @php
                                // Kelompokkan detail berdasarkan TahunPeriode
                                $groupedByYear = $category->details->groupBy('TahunPeriode');
                            @endphp

                            <div class="space-y-8">
                                @foreach($groupedByYear as $year => $items)
                                    <div class="report-year-group" data-year="{{ $year }}">
                                        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center">
                                            <span class="w-1.5 h-1.5 bg-brand-500 rounded-full mr-2"></span>
                                            Periode {{ $year }}
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach($items as $item)
                                                @php
                                                    // Format file size (asumsi dalam bytes, ubah jika sudah dalam MB/KB)
                                                    $size = $item->FileSize;
                                                    $formattedSize = $size >= 1048576 ? round($size / 1048576, 2) . ' MB' : round($size / 1024, 2) . ' KB';

                                                    // Tentukan icon berdasarkan ekstensi file atau default
                                                    $ext = pathinfo($item->PathFile, PATHINFO_EXTENSION);
                                                    $fileIcon = 'fa-file';
                                                    $fileColor = 'text-slate-500';
                                                    if(in_array(strtolower($ext), ['pdf'])) { $fileIcon = 'fa-file-pdf'; $fileColor = 'text-red-500'; }
                                                    elseif(in_array(strtolower($ext), ['xls', 'xlsx', 'csv'])) { $fileIcon = 'fa-file-excel'; $fileColor = 'text-green-600'; }
                                                    elseif(in_array(strtolower($ext), ['doc', 'docx'])) { $fileIcon = 'fa-file-word'; $fileColor = 'text-blue-600'; }
                                                @endphp

                                                <div class="report-card bg-white rounded-xl p-5 border border-slate-200 flex flex-col h-full">
                                                    <div class="flex items-start justify-between mb-3">
                                                        <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                                            <i class="fa-regular {{ $fileIcon }} {{ $fileColor }} text-xl"></i>
                                                        </div>
                                                        @if($item->Bahasa)
                                                            <span class="px-2 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold uppercase rounded">
                                                                {{ $item->Bahasa }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <h4 class="font-bold text-slate-900 mb-2 leading-snug flex-grow">
                                                        {{ $item->Judul }}
                                                    </h4>

                                                    @if($item->Deskripsi)
                                                        <p class="text-sm text-slate-500 mb-4 line-clamp-2">
                                                            {{ $item->Deskripsi }}
                                                        </p>
                                                    @endif

                                                    <div class="flex items-center justify-between pt-4 border-t border-slate-100 mt-auto">
                                                        <div class="flex items-center gap-3 text-xs text-slate-500">
                                                            <span><i class="fa-solid fa-weight-hanging mr-1"></i>{{ $formattedSize }}</span>
                                                            <span><i class="fa-solid fa-download mr-1"></i>{{ $item->JumlahDownload ?? 0 }}</span>
                                                        </div>
                                                        <a href="{{ asset('storage/' . $item->PathFile) }}"
                                                           target="_blank"
                                                           class="inline-flex items-center px-3 py-1.5 bg-brand-50 hover:bg-brand-600 text-brand-700 hover:text-white text-sm font-semibold rounded-lg transition-colors">
                                                            <i class="fa-solid fa-download mr-1.5"></i>
                                                            Unduh
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="bg-slate-50 rounded-xl p-8 text-center border border-dashed border-slate-300">
                                <i class="fa-regular fa-folder-open text-4xl text-slate-300 mb-3"></i>
                                <p class="text-slate-500">Belum ada laporan yang diunggah untuk kategori ini.</p>
                            </div>
                        @endif

                    </section>
                @empty
                    <div class="col-span-12 text-center py-12">
                        <i class="fa-solid fa-chart-pie text-5xl text-slate-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-slate-700">Data Tidak Ditemukan</h3>
                        <p class="text-slate-500">Saat ini belum ada laporan keuangan yang dipublikasikan.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</section>

@endsection

@push('frontend-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Active Navigation Highlighting on Scroll
        const sections = document.querySelectorAll('section[id]');
        const navItems = document.querySelectorAll('.nav-item');

        const observerOptions = {
            root: null,
            rootMargin: '-100px 0px -60% 0px',
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const activeId = entry.target.getAttribute('id');
                    navItems.forEach(item => {
                        item.classList.remove('nav-item-active');
                        if (item.getAttribute('href') === `#${activeId}`) {
                            item.classList.add('nav-item-active');
                        }
                    });
                }
            });
        }, observerOptions);

        sections.forEach(section => observer.observe(section));

        // 2. Simple Year Filter (Client-side)
        const yearFilter = document.getElementById('yearFilter');
        if (yearFilter) {
            yearFilter.addEventListener('change', function() {
                const selectedYear = this.value;
                const yearGroups = document.querySelectorAll('.report-year-group');

                yearGroups.forEach(group => {
                    if (selectedYear === 'all' || group.dataset.year === selectedYear) {
                        group.style.display = 'block';
                    } else {
                        group.style.display = 'none';
                    }
                });

                // Hide empty category sections if all their years are filtered out
                document.querySelectorAll('section[id]').forEach(section => {
                    const visibleGroups = section.querySelectorAll('.report-year-group[style="display: block;"], .report-year-group:not([style*="display: none"])');
                    if (visibleGroups.length === 0) {
                        section.style.display = 'none';
                    } else {
                        section.style.display = 'block';
                    }
                });
            });
        }
    });
</script>
@endpush

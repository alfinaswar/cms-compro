@extends('frontend.index')

@section('content-frontend')
    @push('style')
        <style>
            /* Zona Drag & Drop Kustom */
            .custom-drop-zone {
                border: 2px dashed #cbd5e1;
                border-radius: 12px;
                padding: 2rem 1.5rem;
                text-align: center;
                cursor: pointer;
                transition: all 0.3s ease;
                background-color: #f8fafc;
                position: relative;
            }

            .custom-drop-zone:hover,
            .custom-drop-zone.drag-over {
                border-color: #0284c7;
                background-color: #f0f9ff;
            }

            .custom-drop-zone.drag-over {
                transform: scale(1.02);
                box-shadow: 0 10px 25px -5px rgba(2, 132, 199, 0.2);
            }

            .custom-drop-zone .drop-zone-content {
                pointer-events: none;
            }

            .custom-drop-zone .file-info {
                animation: fadeIn 0.3s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Styling Konten Deskripsi Pekerjaan */
            .job-description-content h1,
            .job-description-content h2,
            .job-description-content h3,
            .job-description-content h4,
            .job-description-content h5,
            .job-description-content h6 {
                font-weight: 700;
                color: #0f172a;
                margin-top: 1.5rem;
                margin-bottom: 0.75rem;
            }

            .job-description-content h3 {
                font-size: 1.25rem;
            }

            .job-description-content h4 {
                font-size: 1.125rem;
            }

            .job-description-content p {
                margin-bottom: 1rem;
                line-height: 1.75;
            }

            .job-description-content ul,
            .job-description-content ol {
                margin-bottom: 1rem;
                padding-left: 1.5rem;
            }

            .job-description-content li {
                margin-bottom: 0.5rem;
                line-height: 1.75;
            }

            .job-description-content ul li {
                list-style-type: disc;
            }

            .job-description-content ol li {
                list-style-type: decimal;
            }

            .job-description-content strong {
                color: #0f172a;
                font-weight: 600;
            }

            /* Scroll lembut ke form apply */
            html {
                scroll-behavior: smooth;
            }
        </style>
    @endpush
    <!-- ========================================== -->
    <!-- HERO / BREADCRUMB BAGIAN -->
    <!-- ========================================== -->
    <section class="relative pt-32 pb-16 bg-gradient-to-br from-brand-900 via-brand-800 to-brand-900 overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <img src="https://images.unsplash.com/photo-1454165804606-c3d57f86697dd?q=80&w=2070&auto=format&fit=crop"
                alt="Latar Belakang" class="w-full h-full object-cover">
        </div>
        <div
            class="absolute top-0 right-0 w-96 h-96 bg-brand-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10">
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            @if ($lowongan->masih_berlaku)
                                <span
                                    class="inline-flex items-center px-3 py-1 bg-green-500/20 text-green-300 text-sm font-bold rounded-full border border-green-500/30">
                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                    LOWONGAN TERBUKA
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 bg-slate-500/20 text-slate-300 text-sm font-bold rounded-full border border-slate-500/30">
                                    TUTUP
                                </span>
                            @endif
                        </div>
                        <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-4 leading-tight">
                            {{ $lowongan->Posisi }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-4 text-slate-300">
                            <span class="inline-flex items-center">
                                <i class="fa-solid fa-location-dot mr-2 text-brand-400"></i>
                                {{ $lowongan->Kota }}
                            </span>
                            <span class="inline-flex items-center">
                                <i class="fa-solid fa-building mr-2 text-brand-400"></i>
                                Jasuindo
                            </span>
                            <span class="inline-flex items-center">
                                <i class="fa-regular fa-clock mr-2 text-brand-400"></i>
                                Penuh Waktu
                            </span>
                        </div>
                    </div>

                    @if ($lowongan->masih_berlaku)
                        <a href="#apply-form"
                            class="inline-flex items-center justify-center px-6 py-3 bg-brand-600 hover:bg-brand-500 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl whitespace-nowrap">
                            Lamar Sekarang
                            <i class="fa-solid fa-arrow-right ml-2"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- NOTIFIKASI BERHASIL -->
    <!-- ========================================== -->
    @if (session('success'))
        <div class="container mx-auto px-6 -mt-6 relative z-20">
            <div class="bg-green-50 border-l-4 border-green-500 rounded-r-xl p-4 shadow-lg animate-fade-in">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fa-solid fa-circle-check text-green-500 text-2xl"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                    </div>
                    <button type="button" class="ml-auto text-green-500 hover:text-green-700"
                        onclick="this.parentElement.parentElement.remove()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- ========================================== -->
    <!-- KONTEN UTAMA -->
    <!-- ========================================== -->
    <section class="py-12 bg-slate-50">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- ========================================== -->
                <!-- KOLOM KIRI: DETAIL PEKERJAAN -->
                <!-- ========================================== -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- KARTU DESKRIPSI PEKERJAAN -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fa-regular fa-file-lines text-brand-600 text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-900">Deskripsi Pekerjaan</h2>
                        </div>

                        <div class="job-description-content text-slate-600">
                            {!! $lowongan->Deskripsi !!}
                        </div>
                    </div>

                    <!-- KARTU KUALIFIKASI -->
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                                <i class="fa-regular fa-circle-check text-green-600 text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-900">Kualifikasi</h2>
                        </div>

                        <div class="job-description-content text-slate-600">
                            {!! $lowongan->Kualifikasi !!}
                        </div>
                    </div>

                    <!-- Batas Terakhir Lamaran -->
                    <div
                        class="bg-gradient-to-r from-brand-600 to-brand-700 rounded-2xl p-6 md:p-8 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                        <div class="relative z-10">
                            <div class="flex items-center mb-4">
                                <i class="fa-regular fa-calendar-days text-3xl mr-4"></i>
                                <h3 class="text-xl font-bold">Batas Akhir Lamaran</h3>
                            </div>
                            <p class="text-3xl font-extrabold mb-2">
                                {{ \Carbon\Carbon::parse($lowongan->BatasWaktu)->format('j F Y') }}
                            </p>
                            <p class="text-brand-100">
                                ({{ \Carbon\Carbon::parse($lowongan->BatasWaktu)->diffForHumans() }})
                            </p>
                        </div>
                    </div>

                    <!-- ========================================== -->
                    <!-- FORM LAMAR -->
                    <!-- ========================================== -->
                    @if ($lowongan->masih_berlaku)
                        <div id="apply-form"
                            class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 md:p-8 scroll-mt-24">
                            <div class="flex items-center mb-6">
                                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fa-regular fa-paper-plane text-purple-600 text-xl"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-slate-900">Lamar Posisi Ini</h2>
                            </div>

                            <form action="{{ route('frontend.career.apply', $lowongan->id) }}" method="POST"
                                enctype="multipart/form-data" id="applyForm" class="space-y-5">
                                @csrf

                                <!-- Nama & Email -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Nama Lengkap <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <i class="fa-solid fa-user text-slate-400"></i>
                                            </div>
                                            <input type="text" name="NamaLengkap" required
                                                placeholder="Masukkan nama lengkap"
                                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Email <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <i class="fa-solid fa-envelope text-slate-400"></i>
                                            </div>
                                            <input type="email" name="Email" required placeholder="contoh@email.com"
                                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">
                                        </div>
                                    </div>
                                </div>

                                <!-- Telepon & Gaji -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            No. Handphone <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <i class="fa-solid fa-phone text-slate-400"></i>
                                            </div>
                                            <input type="tel" name="NoHp" required placeholder="08xxxxxxxxxx"
                                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                                            Ekspektasi Gaji <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <i class="fa-solid fa-money-bill-wave text-slate-400"></i>
                                            </div>
                                            <input type="text" name="EkspetasiGaji" id="ekspetasiGaji" required
                                                placeholder="Rp 5.000.000"
                                                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all">
                                        </div>
                                    </div>
                                </div>

                                <!-- Deskripsi Singkat -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Deskripsi Singkat Diri <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="DeskripsiSingkat" rows="5" required
                                        placeholder="Ceritakan sedikit tentang pengalaman dan keahlian Anda..."
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-brand-500 focus:bg-white outline-none transition-all resize-none"></textarea>
                                </div>

                                <!-- Upload CV -->
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                                        Upload CV / Dokumen Pendukung <span class="text-red-500">*</span>
                                    </label>

                                    <div class="custom-drop-zone" id="dropZone">
                                        <input type="file" name="PathCv" id="fileInput" class="hidden"
                                            accept=".pdf,.doc,.docx" required>

                                        <!-- Tampilan Default -->
                                        <div class="drop-zone-content" id="dropZoneContent">
                                            <div
                                                class="inline-flex items-center justify-center w-16 h-16 bg-brand-100 rounded-full mb-4">
                                                <i class="fa-solid fa-cloud-arrow-up text-brand-600 text-2xl"></i>
                                            </div>
                                            <p class="text-lg font-bold text-slate-900 mb-1">Drag & Drop file CV di sini
                                            </p>
                                            <p class="text-slate-600 text-sm mb-3">
                                                atau <span class="text-brand-600 font-semibold underline">klik untuk
                                                    mencari</span>
                                            </p>
                                            <p class="text-xs text-slate-500">
                                                <i class="fa-solid fa-circle-info mr-1"></i>
                                                Format: PDF, DOC, DOCX • Maksimal 2MB
                                            </p>
                                        </div>

                                        <!-- Tampilan File Dipilih -->
                                        <div class="file-info hidden" id="fileInfo">
                                            <div
                                                class="flex items-center justify-between bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                                                <div class="flex items-center flex-1 min-w-0">
                                                    <div
                                                        class="flex-shrink-0 w-12 h-12 bg-brand-100 rounded-xl flex items-center justify-center mr-4">
                                                        <i class="fa-solid fa-file-lines text-brand-600 text-xl"
                                                            id="fileIcon"></i>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="font-bold text-slate-900 truncate" id="fileName">
                                                            nama_file.pdf</p>
                                                        <p class="text-sm text-slate-500" id="fileSize">1.2 MB</p>
                                                    </div>
                                                </div>
                                                <button type="button" id="removeFile"
                                                    class="ml-4 flex-shrink-0 w-10 h-10 bg-red-50 hover:bg-red-100 text-red-600 hover:text-red-700 rounded-lg transition-colors flex items-center justify-center">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    @error('PathCv')
                                        <div class="mt-2 flex items-center text-red-600 text-sm">
                                            <i class="fa-solid fa-circle-exclamation mr-2"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Tombol Submit -->
                                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                                    <button type="submit" id="submitBtn"
                                        class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg">
                                        <i class="fa-regular fa-paper-plane mr-2"></i>
                                        Kirim Lamaran
                                    </button>
                                    <a href="{{ url('career') }}"
                                        class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all">
                                        <i class="fa-solid fa-arrow-left mr-2"></i>
                                        Kembali
                                    </a>
                                </div>
                            </form>
                        </div>
                    @else
                        <!-- Lowongan Tutup -->
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-r-xl p-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <i class="fa-regular fa-circle-exclamation text-yellow-500 text-2xl"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-bold text-yellow-900 mb-2">Lowongan Sudah Ditutup</h3>
                                    <p class="text-yellow-800 mb-4">
                                        Maaf, lowongan ini sudah tidak menerima aplikasi. Silakan cek lowongan lainnya.
                                    </p>
                                    <a href="{{ url('career') }}"
                                        class="inline-flex items-center px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-xl transition-all">
                                        <i class="fa-solid fa-arrow-left mr-2"></i>
                                        Lihat Lowongan Lain
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- ========================================== -->
                <!-- KOLOM KANAN: SIDEBAR -->
                <!-- ========================================== -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">

                        <!-- Widget Ringkasan Pekerjaan -->
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                            <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center">
                                <i class="fa-solid fa-circle-info text-brand-600 mr-3"></i>
                                Ringkasan Pekerjaan
                            </h3>

                            <div class="space-y-5">
                                <!-- Posisi -->
                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 bg-brand-50 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fa-regular fa-briefcase text-brand-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">
                                            Posisi</p>
                                        <p class="text-slate-900 font-semibold">{{ $lowongan->Posisi }}</p>
                                    </div>
                                </div>

                                <!-- Lokasi -->
                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fa-solid fa-location-dot text-green-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">
                                            Lokasi</p>
                                        <p class="text-slate-900 font-semibold">{{ $lowongan->Kota }}</p>
                                    </div>
                                </div>

                                <!-- Deadline -->
                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 bg-purple-50 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fa-regular fa-calendar text-purple-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">
                                            Batas Akhir</p>
                                        <p class="text-slate-900 font-semibold">
                                            {{ \Carbon\Carbon::parse($lowongan->BatasWaktu)->format('j F Y') }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="flex items-start">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 bg-yellow-50 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fa-regular fa-circle-check text-yellow-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-xs text-slate-500 uppercase tracking-wider font-semibold mb-1">
                                            Status</p>
                                        @if ($lowongan->masih_berlaku)
                                            <p class="text-green-600 font-bold">
                                                <i class="fa-solid fa-circle text-xs mr-1"></i> Aktif
                                            </p>
                                        @else
                                            <p class="text-slate-500 font-bold">
                                                <i class="fa-solid fa-circle text-xs mr-1"></i> Tutup
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if ($lowongan->masih_berlaku)
                                <div class="mt-6 pt-6 border-t border-slate-100">
                                    <a href="#apply-form"
                                        class="block w-full text-center px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-all shadow-md hover:shadow-lg">
                                        Lamar Sekarang
                                        <i class="fa-solid fa-arrow-right ml-2"></i>
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Widget Bagikan -->
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                            <h3 class="text-lg font-bold text-slate-900 mb-4">Bagikan Pekerjaan Ini</h3>
                            <div class="flex gap-3">
                                <a href="#"
                                    class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                                <a href="#"
                                    class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-sky-500 hover:bg-sky-600 text-white rounded-lg transition-colors">
                                    <i class="fa-brands fa-twitter"></i>
                                </a>
                                <a href="#"
                                    class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-lg transition-colors">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                                <a href="#"
                                    class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('frontend-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ==========================================
            // 1. LOGIKA DRAG & DROP FILE
            // ==========================================
            const dropZone = document.getElementById('dropZone');
            const fileInput = document.getElementById('fileInput');
            const dropZoneContent = document.getElementById('dropZoneContent');
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const fileIcon = document.getElementById('fileIcon');
            const removeFileBtn = document.getElementById('removeFile');

            if (!dropZone || !fileInput) return;

            // Klik untuk cari file
            dropZone.addEventListener('click', () => fileInput.click());

            // Perubahan input file
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    validateAndShowFile(this.files[0]);
                }
            });

            // Event drag & drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.add('drag-over'), false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.remove('drag-over'), false);
            });

            // Handler drop
            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files && files[0]) {
                    fileInput.files = files;
                    validateAndShowFile(files[0]);
                }
            }

            function validateAndShowFile(file) {
                // Validasi ukuran (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2MB!');
                    resetFileInput();
                    return;
                }

                // Validasi tipe file
                const validTypes = [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                ];

                if (!validTypes.includes(file.type)) {
                    alert('Format file harus PDF, DOC, atau DOCX!');
                    resetFileInput();
                    return;
                }

                // Tampilkan info file
                dropZoneContent.classList.add('hidden');
                fileInfo.classList.remove('hidden');
                fileName.textContent = file.name;
                fileSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';

                // Ganti ikon sesuai tipe file
                if (file.type === 'application/pdf') {
                    fileIcon.className = 'fa-solid fa-file-pdf text-red-600 text-xl';
                } else {
                    fileIcon.className = 'fa-solid fa-file-word text-blue-600 text-xl';
                }
            }

            // Hapus file
            removeFileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                resetFileInput();
            });

            function resetFileInput() {
                fileInput.value = '';
                dropZoneContent.classList.remove('hidden');
                fileInfo.classList.add('hidden');
            }

            // ==========================================
            // 2. FORMAT RUPIAH (Ekspektasi Gaji)
            // ==========================================
            const gajiInput = document.getElementById('ekspetasiGaji');

            if (gajiInput) {
                gajiInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');

                    if (value === '') {
                        e.target.value = '';
                        return;
                    }

                    let formatted = new Intl.NumberFormat('id-ID').format(value);
                    e.target.value = 'Rp ' + formatted;
                });

                gajiInput.addEventListener('blur', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value !== '') {
                        e.target.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                    }
                });
            }

            // ==========================================
            // 3. SCROLL HALUS KE FORM LAMAR
            // ==========================================
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if (href === '#') return;

                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
@endpush

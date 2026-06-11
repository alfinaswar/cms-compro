@extends('frontend.index')

@section('content-frontend')
    @push('frontend-css')
        <style>
            /* Custom Drag & Drop Zone */
            .custom-drop-zone {
                border: 2px dashed #ced4da;
                border-radius: 8px;
                padding: 30px 20px;
                text-align: center;
                cursor: pointer;
                transition: all 0.3s ease;
                background-color: #f8f9fa;
                position: relative;
            }

            .custom-drop-zone:hover,
            .custom-drop-zone.drag-over {
                border-color: #0d6efd;
                background-color: #e7f1ff;
            }

            .custom-drop-zone .drop-zone-content {
                pointer-events: none;
                /* Agar klik tembus ke parent div */
            }

            .custom-drop-zone .file-info {
                display: flex;
                align-items: center;
                justify-content: space-between;
                background: #fff;
                padding: 12px 15px;
                border-radius: 6px;
                border: 1px solid #dee2e6;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            /* Animasi halus saat file muncul */
            .file-info {
                animation: fadeIn 0.3s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(-5px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    @endpush
    <div class="breadcumb-wrapper" data-bg-src="{{ asset('assets/img/bg/breadcumb-bg.jpg') }}">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $lowongan->Posisi }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('career') }}">Career</a></li>
                    <li>{{ $lowongan->Posisi }}</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="space-top space-extra-bottom">
        <div class="container">

            {{-- NOTIFIKASI SUKSES --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row gy-4">
                <div class="col-lg-8">
                    <div class="job-details-card white-bg p-4 p-md-5">
                        <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
                            <div>
                                <h2 class="mb-2">{{ $lowongan->Posisi }}</h2>
                                <p class="text-muted mb-0">
                                    <i class="fa-light fa-location-dot me-1"></i> {{ $lowongan->Kota }}
                                    <span class="mx-2">•</span>
                                    <i class="fa-regular fa-building me-1"></i> Jasuindo
                                </p>
                            </div>
                            @if ($lowongan->masih_berlaku)
                                <span class="badge bg-success fs-6">Open</span>
                            @else
                                <span class="badge bg-secondary fs-6">Closed</span>
                            @endif
                        </div>

                        <hr>

                        <div class="mt-4">
                            <h4 class="mb-3"><i class="fa-regular fa-file-lines me-2"></i>Job Description</h4>
                            <div class="job-description-content">
                                {!! $lowongan->Deskripsi !!}
                            </div>
                        </div>

                        <div class="mt-5">
                            <h4 class="mb-3"><i class="fa-regular fa-circle-check me-2"></i>Qualifications</h4>
                            <div class="job-qualification-content">
                                {!! $lowongan->Kualifikasi !!}
                            </div>
                        </div>

                        <div class="mt-5 p-4 smoke-bg rounded">
                            <h5 class="mb-3"><i class="fa-regular fa-calendar-days me-2"></i>Application Deadline</h5>
                            <p class="mb-1 fs-5 fw-bold">
                                {{ \Carbon\Carbon::parse($lowongan->BatasWaktu)->format('jS F, Y') }}</p>
                            <p class="text-muted mb-0">
                                ({{ \Carbon\Carbon::parse($lowongan->BatasWaktu)->diffForHumans() }})
                            </p>
                        </div>

                        {{-- ================= FORM APPLY ================= --}}
                        @if ($lowongan->masih_berlaku)
                            <div class="mt-5" id="apply-form">
                                <h4 class="mb-4"><i class="fa-regular fa-paper-plane me-2"></i>Apply for this Position
                                </h4>

                                <form action="{{ route('frontend.career.apply', $lowongan->id) }}" method="POST"
                                    enctype="multipart/form-data" id="applyForm">
                                    @csrf

                                    <div class="row gy-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Nama Lengkap <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="NamaLengkap" class="form-control" required
                                                placeholder="Masukkan nama lengkap">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="Email" class="form-control" required
                                                placeholder="contoh@email.com">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">No. Handphone <span
                                                    class="text-danger">*</span></label>
                                            <input type="tel" name="NoHp" class="form-control" required
                                                placeholder="08xxxxxxxxxx">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Ekspetasi Gaji <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="EkspetasiGaji" id="ekspetasiGaji"
                                                class="form-control" required placeholder="Rp 5.000.000">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Deskripsi Singkat Diri <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="DeskripsiSingkat" class="form-control" rows="4" required
                                                placeholder="Ceritakan sedikit tentang pengalaman dan keahlian Anda..."></textarea>
                                        </div>

                                        {{-- CUSTOM DRAG & DROP UPLOAD --}}
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Upload CV / Dokumen Pendukung <span
                                                    class="text-danger">*</span></label>
                                            <div class="custom-drop-zone" id="dropZone">
                                                <input type="file" name="PathCv" id="fileInput" class="d-none"
                                                    accept=".pdf,.doc,.docx" required>

                                                {{-- Tampilan Default --}}
                                                <div class="drop-zone-content" id="dropZoneContent">
                                                    <i class="fa-solid fa-cloud-arrow-up fa-2x mb-2 text-primary"></i>
                                                    <p class="mb-1 fw-bold">Drag & Drop file CV di sini</p>
                                                    <p class="text-muted small mb-2">atau <span
                                                            class="text-primary text-decoration-underline">klik untuk
                                                            browse</span></p>
                                                    <small class="text-muted d-block">Format: PDF, DOC, DOCX. Maksimal
                                                        2MB.</small>
                                                </div>

                                                {{-- Tampilan Saat File Terpilih --}}
                                                <div class="file-info d-none" id="fileInfo">
                                                    <i class="fa-solid fa-file-lines fa-2x text-primary me-2"
                                                        id="fileIcon"></i>
                                                    <div class="text-start flex-grow-1">
                                                        <p class="mb-0 fw-bold text-truncate" id="fileName"
                                                            style="max-width: 250px;">nama_file.pdf</p>
                                                        <small class="text-muted" id="fileSize">1.2 MB</small>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-outline-danger ms-2"
                                                        id="removeFile" title="Hapus File">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('PathCv')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mt-4 d-flex gap-3 flex-wrap">
                                        <button type="submit" class="th-btn style3" id="submitBtn">
                                            <i class="fa-regular fa-paper-plane me-2"></i> Kirim Lamaran
                                        </button>
                                        <a href="{{ url('career') }}" class="th-btn style4">
                                            <i class="fa-light fa-arrow-left me-2"></i> Kembali
                                        </a>
                                    </div>
                                </form>
                            </div>
                        @else
                            <div class="alert alert-warning mt-4">
                                <i class="fa-regular fa-circle-exclamation me-2"></i>
                                Lowongan ini sudah ditutup. Silakan cek lowongan lainnya.
                            </div>
                            <a href="{{ url('career') }}" class="th-btn style4 mt-3">
                                <i class="fa-light fa-arrow-left me-2"></i> Lihat Lowongan Lain
                            </a>
                        @endif
                        {{-- ================= END FORM APPLY ================= --}}

                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="sidebar-area">
                        <div class="widget white-bg p-4">
                            <h4 class="widget_title">Job Summary</h4>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <strong><i class="fa-regular fa-briefcase me-2"></i>Position:</strong><br>
                                    {{ $lowongan->Posisi }}
                                </li>
                                <li class="mb-3">
                                    <strong><i class="fa-light fa-location-dot me-2"></i>Location:</strong><br>
                                    {{ $lowongan->Kota }}
                                </li>
                                <li class="mb-3">
                                    <strong><i class="fa-regular fa-calendar me-2"></i>Deadline:</strong><br>
                                    {{ \Carbon\Carbon::parse($lowongan->BatasWaktu)->format('jS F, Y') }}
                                </li>
                                <li class="mb-3">
                                    <strong><i class="fa-regular fa-circle-info me-2"></i>Status:</strong><br>
                                    @if ($lowongan->masih_berlaku)
                                        <span class="text-success fw-bold">Active</span>
                                    @else
                                        <span class="text-secondary fw-bold">Closed</span>
                                    @endif
                                </li>
                            </ul>
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

            // Klik area drop zone untuk membuka file browser
            dropZone.addEventListener('click', () => fileInput.click());

            // Saat file dipilih lewat browser
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    validateAndShowFile(this.files[0]);
                }
            });

            // Prevent default behavior untuk event drag
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            // Tambahkan class saat file di-drag ke atas zone
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.add('drag-over'), false);
            });

            // Hapus class saat file keluar atau di-drop
            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.remove('drag-over'), false);
            });

            // Handle saat file di-drop
            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files && files[0]) {
                    fileInput.files = files; // Assign file ke input hidden agar terkirim ke Laravel
                    validateAndShowFile(files[0]);
                }
            }

            function validateAndShowFile(file) {
                // Validasi Ukuran (Max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file maksimal 2MB!');
                    resetFileInput();
                    return;
                }

                // Validasi Tipe File
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

                // Tampilkan Info File
                dropZoneContent.classList.add('d-none');
                fileInfo.classList.remove('d-none');
                fileName.textContent = file.name;
                fileSize.textContent = (file.size / (1024 * 1024)).toFixed(2) + ' MB';

                // Ganti icon berdasarkan tipe file
                if (file.type === 'application/pdf') {
                    fileIcon.className = 'fa-solid fa-file-pdf fa-2x text-danger me-2';
                } else {
                    fileIcon.className = 'fa-solid fa-file-word fa-2x text-primary me-2';
                }
            }

            // Hapus file yang terpilih
            removeFileBtn.addEventListener('click', (e) => {
                e.stopPropagation(); // Mencegah trigger klik pada dropZone
                resetFileInput();
            });

            function resetFileInput() {
                fileInput.value = '';
                dropZoneContent.classList.remove('d-none');
                fileInfo.classList.add('d-none');
            }


            // ==========================================
            // 2. LOGIKA FORMAT RUPIAH (Ekspetasi Gaji)
            // ==========================================
            const gajiInput = document.getElementById('ekspetasiGaji');

            gajiInput.addEventListener('input', function(e) {
                // Ambil hanya angka dari input
                let value = e.target.value.replace(/\D/g, '');

                if (value === '') {
                    e.target.value = '';
                    return;
                }

                // Format dengan titik ribuan (Locale Indonesia)
                let formatted = new Intl.NumberFormat('id-ID').format(value);

                // Tambahkan prefix "Rp "
                e.target.value = 'Rp ' + formatted;
            });

            // Pastikan format tetap rapi saat paste atau blur
            gajiInput.addEventListener('blur', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value !== '') {
                    e.target.value = 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                }
            });
        });
    </script>
@endpush

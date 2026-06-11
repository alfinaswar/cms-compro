@extends('frontend.index')

@section('content-frontend')
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
                                    enctype="multipart/form-data">
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
                                            <input type="text" name="EkspetasiGaji" class="form-control" required
                                                placeholder="Contoh: Rp 5.000.000 atau Negotiable">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Deskripsi Singkat Diri <span
                                                    class="text-danger">*</span></label>
                                            <textarea name="DeskripsiSingkat" class="form-control" rows="4" required
                                                placeholder="Ceritakan sedikit tentang pengalaman dan keahlian Anda..."></textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label fw-bold">Upload CV / Dokumen Pendukung <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="PathCv" class="form-control"
                                                accept=".pdf,.doc,.docx" required>
                                            <small class="text-muted">Format: PDF, DOC, atau DOCX. Maksimal 2MB.</small>
                                        </div>
                                    </div>

                                    <div class="mt-4 d-flex gap-3 flex-wrap">
                                        <button type="submit" class="th-btn style3">
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

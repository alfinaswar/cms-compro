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
                            <p class="mb-1 fs-5 fw-bold">{{ $lowongan->BatasWaktuFormatted }}</p>
                            <p class="text-muted mb-0">
                                ({{ \Carbon\Carbon::parse($lowongan->BatasWaktu)->diffForHumans() }})
                            </p>
                        </div>

                        <div class="mt-4 d-flex gap-3 flex-wrap">
                            <a href="{{ url('career') }}" class="th-btn style4">
                                <i class="fa-light fa-arrow-left me-2"></i> Back to Jobs
                            </a>
                            @if ($lowongan->masih_berlaku)
                                <a href="mailto:hrd@jasuindo.co.id?subject=Lamaran {{ $lowongan->Posisi }}"
                                    class="th-btn style3">
                                    <i class="fa-regular fa-paper-plane me-2"></i> Apply via Email
                                </a>
                            @endif
                        </div>
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
                                    {{ $lowongan->BatasWaktuFormatted }}
                                </li>
                                <li class="mb-3">
                                    <strong><i class="fa-regular fa-circle-info me-2"></i>Status:</strong><br>
                                    @if ($lowongan->masih_berlaku)
                                        <span class="text-success">Active</span>
                                    @else
                                        <span class="text-secondary">Closed</span>
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

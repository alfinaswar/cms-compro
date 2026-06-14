@extends('frontend.index')
@section('content-frontend')
    <div class="breadcumb-wrapper " data-bg-src="assets/img/bg/breadcumb-bg.jpg">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $halamanSolusi->Judul }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="index.html">Home</a></li>
                    <li>Solusi</li>
                </ul>
            </div>
        </div>
    </div>
    <section class="position-relative bg-top-center overflow-hidden space-top" id="service-sec">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="title-area service-title-box text-center">
                        {!! $halamanSolusi->Konten !!}
                    </div>
                </div>
            </div>
            <div class="service-area">
                <div class="row gy-30 justify-content-center">
                    @foreach ($halamanSolusi->getSolusiDetail as $detail)
                        <div class="col-xl-3 col-md-6">
                            <div class="service-box service-style-1">
                                <div class="service-img">
                                    @if ($detail->Gambar)
                                        <img src="{{ asset('storage/' . $detail->Gambar) }}" alt="{{ $detail->Judul }}">
                                    @else
                                        <img src="{{ asset('assets/img/service/sv-1.jpg') }}" alt="{{ $detail->Judul }}">
                                    @endif
                                </div>
                                <div class="service-content">
                                    <h3 class="box-title">
                                        {{ $detail->Judul }}
                                    </h3>
                                    <p class="service-box_text">
                                        {!! $detail->Keterangan !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>
@endsection

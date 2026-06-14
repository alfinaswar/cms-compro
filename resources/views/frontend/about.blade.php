@extends('frontend.index')
@section('content-frontend')
    <div class="breadcumb-wrapper " data-bg-src="assets/img/bg/breadcumb-bg.jpg">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ $pageTitle ?? 'Tentang Kami' }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>{{ $pageTitle ?? 'Tentang Kami' }}</li>
                </ul>
            </div>

        </div>
    </div><!--==============================
                                                                                        About Area
                                                                                        ==============================-->
    <div class="about-area position-relative overflow-hidden space" id="about-sec">
        <div class="container">
            <div class="row">
                <div class="col-xl-12 col-xxl-12">
                    <div class="">
                        <div class="title-area about4-titlebox mb-20">
                            <h2 class="sec-title mb-20  text-anime-style-2">{{ $history->Judul }}</h2>
                        </div>
                        <p class="sec-text mb-30 wow fadeInUp" data-wow-delay=".2s">
                            {!! $history->Deskripsi !!}
                        </p>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('frontend.index')

@section('content-frontend')
    <div class="breadcumb-wrapper" data-bg-src="assets/img/bg/breadcumb-bg.jpg">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">Contact Us</h1>
                <ul class="breadcumb-menu">
                    <li><a href="index.html">Home</a></li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="space">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-5">
                    <div class="contact-infobox smoke-bg">
                        <div class="title-area">
                            <span class="sub-title">Work With Us</span>
                            <h3 class="sec-title">Contact Information</h3>
                            <p class="sec-text">
                                @if (isset($websiteSettings) && $websiteSettings->DeskripsiSingkat)
                                    {{ $websiteSettings->DeskripsiSingkat }}
                                @else
                                    Thank you for your interest in Attach Web Agency. We're excited to hear from
                                    you and discuss...
                                @endif
                            </p>
                        </div>
                        <div class="about-contact-grid inner-style">
                            <span class="about-contact-icon">
                                <i class="fa-solid fa-headphones-simple"></i>
                            </span>
                            <div class="about-contact-details">
                                <span class="sec-text">Call Us For Query</span>
                                <p class="about-contact-details-text">
                                    @if (isset($websiteSettings) && $websiteSettings->NomorTelepon)
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $websiteSettings->NomorTelepon) }}">
                                            {{ $websiteSettings->NomorTelepon }}
                                        </a>
                                    @else
                                        <a href="tel:+256698253158">(+256) 69825-3158</a>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="about-contact-grid inner-style">
                            <span class="about-contact-icon">
                                <i class="fa-brands fa-whatsapp"></i>
                            </span>
                            <div class="about-contact-details">
                                <span class="sec-text">WhatsApp</span>
                                <p class="about-contact-details-text">
                                    @if (isset($websiteSettings) && $websiteSettings->NomorWhatsApp)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $websiteSettings->NomorWhatsApp) }}"
                                            target="_blank">
                                            {{ $websiteSettings->NomorWhatsApp }}
                                        </a>
                                    @else
                                        <a href="#">Not Available</a>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="about-contact-grid inner-style">
                            <span class="about-contact-icon">
                                <i class="fa-light fa-envelope-open-text"></i>
                            </span>
                            <div class="about-contact-details">
                                <span class="sec-text">Email Us Anytime</span>
                                <p class="about-contact-details-text">
                                    @if (isset($websiteSettings) && $websiteSettings->AlamatEmail)
                                        <a href="mailto:{{ $websiteSettings->AlamatEmail }}">
                                            {{ $websiteSettings->AlamatEmail }}
                                        </a>
                                    @else
                                        <a href="mailto:info@atek.com">info@atek.com</a>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="about-contact-grid inner-style">
                            <span class="about-contact-icon">
                                <i class="fa-thin fa-map-location-dot"></i>
                            </span>
                            <div class="about-contact-details">
                                <span class="sec-text">Visit Our Office</span>
                                <p class="about-contact-details-text">
                                    @if (isset($websiteSettings) && $websiteSettings->AlamatKantor)
                                        <a href="{{ $websiteSettings->TautanGoogleMaps ?? '#' }}">
                                            {{ $websiteSettings->AlamatKantor }}
                                            @if ($websiteSettings->Kota || $websiteSettings->Provinsi)
                                                ,
                                                {{ $websiteSettings->Kota }}{{ $websiteSettings->Provinsi ? ', ' . $websiteSettings->Provinsi : '' }}
                                            @endif
                                            @if ($websiteSettings->Negara)
                                                , {{ $websiteSettings->Negara }}
                                            @endif
                                            @if ($websiteSettings->KodePos)
                                                , {{ $websiteSettings->KodePos }}
                                            @endif
                                        </a>
                                    @else
                                        <a href="#">14 Maniel Lane, Line Berlin</a>
                                    @endif
                                </p>
                            </div>
                        </div>
                        @if (isset($websiteSettings) && $websiteSettings->EmbedGoogleMaps)
                            <div class="about-contact-grid inner-style">
                                <span class="about-contact-icon">
                                    <i class="fa-solid fa-map"></i>
                                </span>
                                <div class="about-contact-details">
                                    <span class="sec-text">Map</span>
                                    <div class="about-contact-details-text" style="margin-top: 10px;">
                                        {!! $websiteSettings->EmbedGoogleMaps !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="about-contact-grid inner-style mt-3">
                            <span class="about-contact-icon">
                                <i class="fa-solid fa-share-nodes"></i>
                            </span>
                            <div class="about-contact-details">
                                <span class="sec-text">Our Socials</span>
                                <div class="about-contact-details-text d-flex gap-2 flex-wrap mt-1">
                                    @if (!empty($websiteSettings->SosialFacebook))
                                        <a href="{{ $websiteSettings->SosialFacebook }}" target="_blank" rel="noopener"
                                            aria-label="Facebook">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    @endif
                                    @if (!empty($websiteSettings->SosialInstagram))
                                        <a href="{{ $websiteSettings->SosialInstagram }}" target="_blank" rel="noopener"
                                            aria-label="Instagram">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    @endif
                                    @if (!empty($websiteSettings->SosialTwitter))
                                        <a href="{{ $websiteSettings->SosialTwitter }}" target="_blank" rel="noopener"
                                            aria-label="Twitter">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    @endif
                                    @if (!empty($websiteSettings->SosialLinkedIn))
                                        <a href="{{ $websiteSettings->SosialLinkedIn }}" target="_blank" rel="noopener"
                                            aria-label="LinkedIn">
                                            <i class="fab fa-linkedin"></i>
                                        </a>
                                    @endif
                                    @if (!empty($websiteSettings->SosialYoutube))
                                        <a href="{{ $websiteSettings->SosialYoutube }}" target="_blank" rel="noopener"
                                            aria-label="YouTube">
                                            <i class="fab fa-youtube"></i>
                                        </a>
                                    @endif
                                    @if (!empty($websiteSettings->SosialTiktok))
                                        <a href="{{ $websiteSettings->SosialTiktok }}" target="_blank" rel="noopener"
                                            aria-label="TikTok">
                                            <i class="fab fa-tiktok"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-7">
                    <div class="contact-formbox ms-xl-3 ps-xl-3">
                        <form id="contactForm" action="{{ route('frontend.contact.store') }}" method="POST"
                            class="contact-form">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <input type="text" class="form-control" name="NamaLengkap" id="namaLengkap"
                                        placeholder="Nama Lengkap" required>
                                    <img src="assets/img/icon/user.svg" alt="">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <input type="email" class="form-control" name="Email" id="email"
                                        placeholder="Email Address" required>
                                    <img src="assets/img/icon/mail.svg" alt="">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <input type="text" class="form-control" name="NomorHandphone" id="nomorHandphone"
                                        placeholder="Nomor Handphone">
                                    <img src="assets/img/icon/call.svg" alt="">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <input type="text" class="form-control" name="CompanyName" id="companyName"
                                        placeholder="Nama Perusahaan (Opsional)">
                                    <img src="assets/img/icon/building.svg" alt="">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <input type="text" class="form-control" name="LokasiPerusahaan"
                                        id="lokasiPerusahaan" placeholder="Lokasi Perusahaan (Opsional)">
                                    <img src="assets/img/icon/location-dot3.svg" alt="">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <input type="text" class="form-control" name="ProdukYangDibutuhkan"
                                        id="produkYangDibutuhkan" placeholder="Produk/Jasa yang Dibutuhkan (Opsional)">
                                    <img src="assets/img/icon/tag.svg" alt="">
                                </div>
                                <div class="form-group col-12">
                                    <textarea name="Pesan" id="pesan" cols="30" rows="3" class="form-control"
                                        placeholder="Pesan Anda"></textarea>
                                    <img src="assets/img/icon/chat.svg" alt="">
                                </div>
                                <div class="form-btn col-12">
                                    <button type="submit" class="th-btn" id="btnSubmit">
                                        <span class="btn-text">Kirim Pesan</span>
                                        <span class="btn-loader d-none">
                                            <span class="spinner-border spinner-border-sm me-2" role="status"
                                                aria-hidden="true"></span>
                                            Mengirim...
                                        </span>
                                        <img src="assets/img/icon/plane4.svg" alt="" class="btn-icon">
                                    </button>
                                </div>
                            </div>
                            <p class="form-messages mb-0 mt-3"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="space-bottom">
        <div class="container">
            <div class="contact-map style2">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6884.752860529671!2d112.73386551003723!3d-7.4182974915552915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e5a826db497d%3A0x9f2f2fe8700ab414!2sPT.%20Jasuindo%20Informatika%20Pratama!5e1!3m2!1sid!2sid!4v1781381089029!5m2!1sid!2sid"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>

                <div class="contact-icon">
                    <img src="assets/img/icon/location-dot3.svg" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('frontend-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const btnSubmit = $('#btnSubmit');
                const btnText = btnSubmit.find('.btn-text');
                const btnLoader = btnSubmit.find('.btn-loader');
                const btnIcon = btnSubmit.find('.btn-icon');
                btnSubmit.prop('disabled', true);
                btnText.addClass('d-none');
                btnIcon.addClass('d-none');
                btnLoader.removeClass('d-none');

                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').remove();

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Reset button
                        btnSubmit.prop('disabled', false);
                        btnText.removeClass('d-none');
                        btnIcon.removeClass('d-none');
                        btnLoader.addClass('d-none');

                        form[0].reset();

                        Swal.fire({
                            icon: 'success',
                            title: 'Pesan Terkirim!',
                            text: 'Terima kasih telah menghubungi kami. Tim kami akan segera menghubungi Anda.',
                            confirmButtonColor: '#1a56db',
                            confirmButtonText: 'OK',
                            timer: 4000,
                            timerProgressBar: true,
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        });
                    },
                    error: function(xhr) {
                        // Reset button
                        btnSubmit.prop('disabled', false);
                        btnText.removeClass('d-none');
                        btnIcon.removeClass('d-none');
                        btnLoader.addClass('d-none');

                        if (xhr.status === 422) {
                            // Validation errors
                            const errors = xhr.responseJSON.errors;
                            let errorMessages = '';

                            $.each(errors, function(key, value) {
                                errorMessages += value[0] + '<br>';

                                // Add error style to input
                                const input = form.find('[name="' + key + '"]');
                                input.addClass('is-invalid');
                                input.after('<div class="invalid-feedback d-block">' +
                                    value[0] + '</div>');
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal',
                                html: errorMessages,
                                confirmButtonColor: '#dc3545',
                                confirmButtonText: 'Perbaiki Data'
                            });
                        } else {
                            // Server error
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi.',
                                confirmButtonColor: '#dc3545',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush

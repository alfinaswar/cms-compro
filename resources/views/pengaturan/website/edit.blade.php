@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Pengaturan Website</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <form action="{{ route('pengaturan-website.update') }}" method="POST" enctype="multipart/form-data"
            id="formSettings">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- ================= KOLOM KIRI (TABS FORM) ================= -->
                <div class="col-lg-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-cogs mr-2"></i>
                                Konfigurasi Umum Website
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- Tabs Navigation -->
                            <ul class="nav nav-tabs" id="settings-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tab-umum-tab" data-toggle="tab" href="#tab-umum"
                                        role="tab">Umum & Identitas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-kontak-tab" data-toggle="tab" href="#tab-kontak"
                                        role="tab">Kontak & Sosial</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-branding-tab" data-toggle="tab" href="#tab-branding"
                                        role="tab">Branding & Visual</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-legal-tab" data-toggle="tab" href="#tab-legal"
                                        role="tab">Legal & SEO</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tab-sistem-tab" data-toggle="tab" href="#tab-sistem"
                                        role="tab">Sistem & Maintenance</a>
                                </li>
                            </ul>

                            <!-- Tabs Content -->
                            <div class="tab-content pt-3" id="settings-tabContent">

                                <!-- TAB 1: UMUM & IDENTITAS -->
                                <div class="tab-pane fade show active" id="tab-umum" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Perusahaan</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="fas fa-building"></i></span></div>
                                                    <input type="text" name="NamaPerusahaan"
                                                        class="form-control @error('NamaPerusahaan') is-invalid @enderror"
                                                        value="{{ old('NamaPerusahaan', $pengaturan->NamaPerusahaan) }}"
                                                        placeholder="Masukkan nama perusahaan">
                                                </div>
                                                @error('NamaPerusahaan')
                                                    <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Singkat (Footer/Mobile)</label>
                                                <input type="text" name="NamaSingkat"
                                                    class="form-control @error('NamaSingkat') is-invalid @enderror"
                                                    value="{{ old('NamaSingkat', $pengaturan->NamaSingkat) }}"
                                                    placeholder="Masukkan nama singkat, contoh: PT ABC">
                                                @error('NamaSingkat')
                                                    <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Deskripsi Singkat</label>
                                                <input type="text" name="DeskripsiSingkat"
                                                    class="form-control @error('DeskripsiSingkat') is-invalid @enderror"
                                                    value="{{ old('DeskripsiSingkat', $pengaturan->DeskripsiSingkat) }}"
                                                    placeholder="Masukkan deskripsi singkat perusahaan">
                                                @error('DeskripsiSingkat')
                                                    <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tagline Website</label>
                                                <input type="text" name="TaglineWebsite" class="form-control"
                                                    value="{{ old('TaglineWebsite', $pengaturan->TaglineWebsite) }}"
                                                    placeholder="Contoh: Solusi Terbaik untuk Bisnis Anda">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Tentang Perusahaan</label>
                                                <textarea name="TentangPerusahaan" class="form-control" rows="4"
                                                    placeholder="Deskripsikan perusahaan secara singkat...">{{ old('TentangPerusahaan', $pengaturan->TentangPerusahaan) }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <!-- TAB 2: KONTAK & SOSIAL -->
                                <div class="tab-pane fade" id="tab-kontak" role="tabpanel">
                                    <h5 class="mb-3 text-primary"><i class="fas fa-phone-alt mr-2"></i>Informasi Kontak
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nomor Telepon</label>
                                                <input type="text" name="NomorTelepon" class="form-control"
                                                    value="{{ old('NomorTelepon', $pengaturan->NomorTelepon) }}"
                                                    placeholder="Contoh: 021-XXXXXXX">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nomor WhatsApp</label>
                                                <input type="text" name="NomorWhatsApp" class="form-control"
                                                    value="{{ old('NomorWhatsApp', $pengaturan->NomorWhatsApp) }}"
                                                    placeholder="Contoh: 0812XXXXXXXX">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Alamat Email</label>
                                                <input type="email" name="AlamatEmail"
                                                    class="form-control @error('AlamatEmail') is-invalid @enderror"
                                                    value="{{ old('AlamatEmail', $pengaturan->AlamatEmail) }}"
                                                    placeholder="nama@email.com">
                                                @error('AlamatEmail')
                                                    <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Alamat Kantor Lengkap</label>
                                                <textarea name="AlamatKantor" class="form-control" rows="2" placeholder="Isi dengan alamat kantor lengkap">{{ old('AlamatKantor', $pengaturan->AlamatKantor) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5 class="mb-3 text-primary"><i class="fas fa-share-alt mr-2"></i>Media Sosial</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fab fa-facebook text-primary mr-1"></i> Facebook</label>
                                                <input type="url" name="SosialFacebook" class="form-control"
                                                    value="{{ old('SosialFacebook', $pengaturan->SosialFacebook) }}"
                                                    placeholder="https://facebook.com/namaperusahaan">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fab fa-instagram text-danger mr-1"></i> Instagram</label>
                                                <input type="url" name="SosialInstagram" class="form-control"
                                                    value="{{ old('SosialInstagram', $pengaturan->SosialInstagram) }}"
                                                    placeholder="https://instagram.com/namaperusahaan">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fab fa-twitter text-info mr-1"></i> Twitter/X</label>
                                                <input type="url" name="SosialTwitter" class="form-control"
                                                    value="{{ old('SosialTwitter', $pengaturan->SosialTwitter) }}"
                                                    placeholder="https://twitter.com/namaperusahaan">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fab fa-linkedin text-primary mr-1"></i> LinkedIn</label>
                                                <input type="url" name="SosialLinkedIn" class="form-control"
                                                    value="{{ old('SosialLinkedIn', $pengaturan->SosialLinkedIn) }}"
                                                    placeholder="https://linkedin.com/company/namaperusahaan">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB 3: BRANDING & VISUAL -->
                                <div class="tab-pane fade" id="tab-branding" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Upload Logo Utama</label>
                                                <div class="custom-file">
                                                    <input type="file" name="PathLogo"
                                                        class="custom-file-input @error('PathLogo') is-invalid @enderror"
                                                        id="logoInput" placeholder="Pilih Logo">
                                                    <label class="custom-file-label" for="logoInput">Pilih file...</label>
                                                </div>
                                                @error('PathLogo')
                                                    <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                                @if ($pengaturan->PathLogo)
                                                    <div class="mt-2">
                                                        <small class="text-muted">Logo saat ini:</small><br>
                                                        <img src="{{ Storage::url($pengaturan->PathLogo) }}"
                                                            alt="Logo" style="max-height: 50px;">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Upload Favicon (.ico / .png)</label>
                                                <input type="file" name="PathFavicon"
                                                    class="form-control @error('PathFavicon') is-invalid @enderror"
                                                    placeholder="Pilih Favicon">
                                                @error('PathFavicon')
                                                    <span class="error invalid-feedback">{{ $message }}</span>
                                                @enderror
                                                @if ($pengaturan->PathFavicon)
                                                    <div class="mt-2">
                                                        <small class="text-muted">Favicon saat ini:</small><br>
                                                        <img src="{{ Storage::url($pengaturan->PathFavicon) }}"
                                                            alt="Favicon" style="max-height: 32px;">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Warna Utama (Primary)</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="fas fa-palette"></i></span></div>
                                                    <input type="color" name="WarnaUtama"
                                                        class="form-control form-control-color"
                                                        value="{{ old('WarnaUtama', $pengaturan->WarnaUtama) ?? '#0d6efd' }}"
                                                        placeholder="Pilih warna utama">
                                                    <input type="text" name="WarnaUtamaText" class="form-control"
                                                        value="{{ old('WarnaUtama', $pengaturan->WarnaUtama) ?? '#0d6efd' }}"
                                                        placeholder="#0d6efd">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Warna Sekunder</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                class="fas fa-palette"></i></span></div>
                                                    <input type="color" name="WarnaSekunder"
                                                        class="form-control form-control-color"
                                                        value="{{ old('WarnaSekunder', $pengaturan->WarnaSekunder) }}"
                                                        placeholder="Pilih warna sekunder">
                                                    <input type="text" name="WarnaSekunderText" class="form-control"
                                                        value="{{ old('WarnaSekunder', $pengaturan->WarnaSekunder) }}"
                                                        placeholder="#666666">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB 4: LEGAL & SEO -->
                                <div class="tab-pane fade" id="tab-legal" role="tabpanel">
                                    <h5 class="mb-3 text-primary">Legalitas Perusahaan</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nomor NPWP</label>
                                                <input type="text" name="NomorNPWP" class="form-control"
                                                    value="{{ old('NomorNPWP', $pengaturan->NomorNPWP) }}"
                                                    placeholder="NPWP Perusahaan">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nomor NIB (OSS)</label>
                                                <input type="text" name="NomorNIB" class="form-control"
                                                    value="{{ old('NomorNIB', $pengaturan->NomorNIB) }}"
                                                    placeholder="NIB OSS Perusahaan">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Direktur</label>
                                                <input type="text" name="NamaDirektur" class="form-control"
                                                    value="{{ old('NamaDirektur', $pengaturan->NamaDirektur) }}"
                                                    placeholder="Isi nama direktur">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jabatan Direktur</label>
                                                <input type="text" name="JabatanDirektur" class="form-control"
                                                    value="{{ old('JabatanDirektur', $pengaturan->JabatanDirektur) }}"
                                                    placeholder="Jabatan direktur, contoh: Direktur Utama">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <h5 class="mb-3 text-primary">SEO & Analytics</h5>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Google Analytics ID (G-XXXXXXXXXX)</label>
                                                <input type="text" name="IdGoogleAnalytics" class="form-control"
                                                    value="{{ old('IdGoogleAnalytics', $pengaturan->IdGoogleAnalytics) }}"
                                                    placeholder="G-XXXXXXXXXX atau UA-XXXXXXXX-X">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label>Custom Script Header</label>
                                                <textarea name="ScriptHeaderCustom" class="form-control font-monospace" rows="4" style="font-size: 12px;"
                                                    placeholder="Masukkan script header (misal Google Tag, Pixel, verifikasi, dll)">{{ old('ScriptHeaderCustom', $pengaturan->ScriptHeaderCustom) }}</textarea>
                                                <small class="text-muted">Masukkan script &lt;script&gt; tag di sini jika
                                                    diperlukan (Pixel FB, Verif Domain, dll).</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB 5: SISTEM & MAINTENANCE -->
                                <div class="tab-pane fade" id="tab-sistem" role="tabpanel">
                                    <div
                                        class="form-group d-flex align-items-center justify-content-between p-3 bg-light rounded mb-3">
                                        <div>
                                            <strong class="d-block">Mode Maintenance</strong>
                                            <small class="text-muted">Aktifkan jika website sedang dalam perbaikan.</small>
                                        </div>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" name="ModeMaintenance" class="custom-control-input"
                                                id="maintenanceMode" value="1"
                                                {{ old('ModeMaintenance', $pengaturan->ModeMaintenance) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="maintenanceMode"></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Pesan Maintenance</label>
                                        <textarea name="PesanMaintenance" class="form-control" rows="2"
                                            placeholder="Isi pesan maintenance apabila website dalam mode perbaikan">{{ old('PesanMaintenance', $pengaturan->PesanMaintenance) }}</textarea>
                                    </div>

                                    <div
                                        class="form-group d-flex align-items-center justify-content-between p-3 bg-light rounded mt-4">
                                        <div>
                                            <strong class="d-block">Cookie Consent Banner</strong>
                                            <small class="text-muted">Tampilkan notifikasi persetujuan cookie.</small>
                                        </div>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" name="AktifkanCookieConsent"
                                                class="custom-control-input" id="cookieConsent" value="1"
                                                {{ old('AktifkanCookieConsent', $pengaturan->AktifkanCookieConsent) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="cookieConsent"></label>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <label>Teks Cookie Consent</label>
                                        <textarea name="TeksCookieConsent" class="form-control" rows="2"
                                            placeholder="Isi teks atau pesan cookie consent">{{ old('TeksCookieConsent', $pengaturan->TeksCookieConsent) }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-default float-right">
                                <i class="fas fa-times mr-2"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>

                <!-- ================= KOLOM KANAN (PREVIEW) ================= -->
                <div class="col-lg-3">
                    <div class="card card-primary card-outline sticky-top" style="top: 20px; z-index: 100;">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-eye mr-2"></i>Live Preview</h3>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ $pengaturan->PathLogo ? Storage::url($pengaturan->PathLogo) : asset('img/logo-default.png') }}"
                                alt="Logo Preview" id="previewLogo" style="max-height: 60px;" class="img-fluid mb-3">
                            <p class="mb-1 font-weight-bold" id="previewName">
                                {{ $pengaturan->NamaPerusahaan ?? 'Nama Perusahaan' }}</p>
                            <span class="badge badge-primary"
                                id="previewColor">{{ $pengaturan->WarnaUtama ?? '#0d6efd' }}</span>
                        </div>
                        <div class="card-footer bg-light">
                            <small class="text-muted d-block text-center">
                                <i class="fas fa-info-circle mr-1"></i> Perubahan akan tersimpan setelah klik Simpan.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // 1. Preview Nama Perusahaan
            $('input[name="NamaPerusahaan"]').on('keyup', function() {
                $('#previewName').text($(this).val() || 'Nama Perusahaan');
            });

            // 2. Preview Logo Upload
            $('#logoInput').on('change', function(e) {
                if (e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewLogo').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(e.target.files[0]);
                }
            });

            // 3. Sinkronisasi Color Picker
            $('input[type="color"]').on('input', function() {
                const name = $(this).attr('name');
                $('input[name="' + name + 'Text"]').val($(this).val());
                $('#previewColor').css('background-color', $(this).val()).text($(this).val());
            });
            $('input[name$="Text"]').on('input', function() {
                const name = $(this).attr('name').replace('Text', '');
                $('input[name="' + name + '"]').val($(this).val());
                $('#previewColor').css('background-color', $(this).val()).text($(this).val());
            });
        });
    </script>
@endpush

@extends('layouts.app')

@section('content')
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}">
        <style>
            .nav-tabs .nav-link {
                font-size: 13px;
                font-weight: 600;
                color: #6c757d;
                border: none;
                border-bottom: 2px solid transparent;
                padding: 10px 16px;
                transition: all 0.2s;
            }

            .nav-tabs .nav-link:hover {
                color: #007bff;
                background: rgba(0, 123, 255, 0.05);
            }

            .nav-tabs .nav-link.active {
                color: #007bff;
                border-bottom-color: #007bff;
                background: transparent;
            }

            .repeater-item {
                background: #f8f9fa;
                border: 1px solid #e9ecef;
                border-radius: 8px;
                padding: 20px 20px 16px;
                margin-bottom: 12px;
                position: relative;
                transition: all 0.2s;
            }

            .repeater-item:hover {
                border-color: #cfd8dc;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
            }

            .repeater-item .btn-remove {
                position: absolute;
                top: 10px;
                right: 10px;
                padding: 4px 8px;
                font-size: 12px;
            }

            .img-preview-box {
                width: 100px;
                height: 70px;
                border: 1px dashed #ccc;
                border-radius: 6px;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                background: #fff;
                margin-top: 6px;
            }

            .img-preview-box img {
                max-width: 100%;
                max-height: 100%;
                object-fit: cover;
            }

            .img-preview-box .placeholder-icon {
                color: #adb5bd;
                font-size: 24px;
            }

            .list-item-row {
                display: flex;
                gap: 8px;
                margin-bottom: 6px;
            }

            .list-item-row input {
                flex: 1;
            }

            .section-divider {
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 1px;
                color: #6c757d;
                font-weight: 700;
                margin: 24px 0 12px;
                padding-bottom: 8px;
                border-bottom: 1px solid #e9ecef;
            }

            .tab-pane {
                padding-top: 20px;
            }

            .empty-state {
                text-align: center;
                padding: 40px 20px;
                color: #adb5bd;
            }

            .empty-state i {
                font-size: 48px;
                margin-bottom: 12px;
                display: block;
            }

            .form-label-sm {
                font-size: 12px;
                font-weight: 600;
                color: #495057;
                margin-bottom: 4px;
                display: block;
            }
        </style>
    @endpush

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <a href="#" class="text-muted mr-2">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        Edit Halaman Solusi
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Solusi</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-header p-0 pt-2">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab-hero">
                                <i class="fa fa-home mr-1"></i> Hero
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-komponen">
                                <i class="fa fa-cogs mr-1"></i> Komponen
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-solusi">
                                <i class="fa fa-lightbulb mr-1"></i> Solusi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-security">
                                <i class="fa fa-shield-alt mr-1"></i> Keamanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-faq">
                                <i class="fa fa-question-circle mr-1"></i> FAQ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-pengaturan">
                                <i class="fa fa-cog mr-1"></i> Pengaturan
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">

                        <!-- ==================== TAB HERO ==================== -->
                        <div class="tab-pane fade show active" id="tab-hero">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Judul Halaman <span class="text-danger">*</span></label>
                                        <input type="text" name="Judul" class="form-control"
                                            value="Paspor & Dokumen Imigrasi Resmi" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Sub Judul</label>
                                        <input type="text" name="SubJudul" class="form-control"
                                            value="Perlindungan dokumen lintas negara berstandar internasional">
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi Hero</label>
                                        <textarea name="Deskripsi" class="form-control" rows="3">Perlindungan dokumen lintas negara berstandar internasional dan terintegrasi teknologi canggih.</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Konten Utama (Rich Text)</label>
                                        <textarea name="Konten" class="form-control summernote" rows="5"></textarea>
                                        <small class="text-muted">Opsional. Untuk konten tambahan di luar
                                            section-section.</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Slug URL <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">/solusi/</span>
                                            </div>
                                            <input type="text" name="Slug" class="form-control" value="paspor"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Gambar Hero</label>
                                        <input type="file" name="GambarHero" class="form-control-file" accept="image/*">
                                        <small class="text-muted">Maks. 2MB. Format: JPG, PNG, WebP</small>
                                        <div class="img-preview-box mt-2">
                                            <i class="fa fa-image placeholder-icon"></i>
                                        </div>
                                    </div>
                                    <div class="form-group mt-4">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="IsPublished"
                                                name="IsPublished" value="1" checked>
                                            <label class="custom-control-label" for="IsPublished">
                                                <strong>Publikasikan</strong>
                                            </label>
                                        </div>
                                        <small class="text-muted d-block mt-1">Halaman akan muncul di website jika
                                            dicentang.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ==================== TAB KOMPONEN ==================== -->
                        <div class="tab-pane fade" id="tab-komponen">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle mr-2"></i>
                                Section ini menampilkan card-card komponen manufaktur. Tipe <strong>Besar</strong> untuk 3
                                kolom atas, tipe <strong>Horizontal</strong> untuk 2 kolom bawah.
                            </div>

                            <div class="section-divider">Header Section</div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Badge Label</label>
                                    <input type="text" name="section_komponen_badge"
                                        class="form-control form-control-sm" value="Arsitektur Komponen Paspor"
                                        placeholder="Label badge">
                                </div>
                                <div class="col-md-8">
                                    <label>Judul Section</label>
                                    <input type="text" name="section_komponen_title"
                                        class="form-control form-control-sm" value="Komponen & Manufaktur Sekuriti"
                                        placeholder="Judul section">
                                </div>
                                <div class="col-12 mt-2">
                                    <label>Deskripsi Section</label>
                                    <textarea name="section_komponen_desc" class="form-control form-control-sm" rows="2">Eksplorasi setiap modul berstandar tinggi yang kami integrasikan.</textarea>
                                </div>
                            </div>

                            <div class="section-divider">
                                Daftar Komponen
                                <button type="button" class="btn btn-primary btn-sm float-right" id="btnAddKomponen">
                                    <i class="fa fa-plus mr-1"></i> Tambah Komponen
                                </button>
                            </div>

                            <div id="komponenRepeater">
                                <!-- Komponen 1 -->
                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Judul</label>
                                                <input type="text" name="komponen[0][Judul]"
                                                    class="form-control form-control-sm" value="Buklet Paspor">
                                            </div>
                                            <div class="form-group">
                                                <label>Sub Judul</label>
                                                <input type="text" name="komponen[0][SubJudul]"
                                                    class="form-control form-control-sm"
                                                    value="Passport Booklet & Finished Unit">
                                            </div>
                                            <div class="form-group">
                                                <label>Tipe Layout</label>
                                                <select name="komponen[0][Tipe]" class="form-control form-control-sm">
                                                    <option value="besar" selected>Besar (3 Kolom)</option>
                                                    <option value="horizontal">Horizontal (2 Kolom)</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Gambar</label>
                                                <input type="file" name="komponen[0][Gambar]"
                                                    class="form-control-file" accept="image/*">
                                                <div class="img-preview-box">
                                                    <i class="fa fa-image placeholder-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <label>List Items (Fitur/Spesifikasi)</label>
                                            <div class="list-items-container">
                                                <div class="list-item-row">
                                                    <input type="text" name="komponen[0][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Kompatibel mesin pembaca & pemindai paspor (MRZ & RFID)">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="list-item-row">
                                                    <input type="text" name="komponen[0][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="E-Paspor & paspor biometrik terstandardisasi">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="list-item-row">
                                                    <input type="text" name="komponen[0][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="E-covers / e-PCDP ultra tipis dan fleksibel">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="list-item-row">
                                                    <input type="text" name="komponen[0][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Sesuai standar ICAO Doc 9303 & ISO">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="list-item-row">
                                                    <input type="text" name="komponen[0][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Fitur keamanan berlapis Level 1, 2, dan 3">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="list-item-row">
                                                    <input type="text" name="komponen[0][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Usia pakai teruji hingga 10 tahun tanpa delaminasi">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary mt-2 btn-add-item">
                                                <i class="fa fa-plus"></i> Tambah Item
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Komponen 2 -->
                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Judul</label>
                                                <input type="text" name="komponen[1][Judul]"
                                                    class="form-control form-control-sm" value="Halaman Polikarbonat">
                                            </div>
                                            <div class="form-group">
                                                <label>Sub Judul</label>
                                                <input type="text" name="komponen[1][SubJudul]"
                                                    class="form-control form-control-sm" value="PCDP & e-PCDP Substrate">
                                            </div>
                                            <div class="form-group">
                                                <label>Tipe Layout</label>
                                                <select name="komponen[1][Tipe]" class="form-control form-control-sm">
                                                    <option value="besar" selected>Besar (3 Kolom)</option>
                                                    <option value="horizontal">Horizontal (2 Kolom)</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Gambar</label>
                                                <input type="file" name="komponen[1][Gambar]"
                                                    class="form-control-file" accept="image/*">
                                                <div class="img-preview-box">
                                                    <i class="fa fa-image placeholder-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <label>List Items</label>
                                            <div class="list-items-container">
                                                <div class="list-item-row">
                                                    <input type="text" name="komponen[1][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="PCDP & e-PCDP struktur multilayer anti-retak">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="list-item-row">
                                                    <input type="text" name="komponen[1][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Ketebalan ultra tipis berpresisi tinggi">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="list-item-row">
                                                    <input type="text" name="komponen[1][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Personalisasi ukiran laser anti-manipulasi">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="list-item-row">
                                                    <input type="text" name="komponen[1][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Tahan Suhu -40°C s/d +80°C">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary mt-2 btn-add-item">
                                                <i class="fa fa-plus"></i> Tambah Item
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Komponen 3 -->
                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Judul</label>
                                                <input type="text" name="komponen[2][Judul]"
                                                    class="form-control form-control-sm" value="Inlays & E-Cover">
                                            </div>
                                            <div class="form-group">
                                                <label>Sub Judul</label>
                                                <input type="text" name="komponen[2][SubJudul]"
                                                    class="form-control form-control-sm" value="RFID Embedded Module">
                                            </div>
                                            <div class="form-group">
                                                <label>Tipe Layout</label>
                                                <select name="komponen[2][Tipe]" class="form-control form-control-sm">
                                                    <option value="besar" selected>Besar (3 Kolom)</option>
                                                    <option value="horizontal">Horizontal (2 Kolom)</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Gambar</label>
                                                <input type="file" name="komponen[2][Gambar]"
                                                    class="form-control-file" accept="image/*">
                                                <div class="img-preview-box">
                                                    <i class="fa fa-image placeholder-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <label>List Items</label>
                                            <div class="list-items-container">
                                                <div class="list-item-row">
                                                    <input type="text" name="komponen[2][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Bahan kertas khusus & teslin berdaya tahan tinggi">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="list-item-row">
                                                    <input type="text" name="komponen[2][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Berbagai macam antena & chip secure-element">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="list-item-row">
                                                    <input type="text" name="komponen[2][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Dukungan protokol kriptografi BAC, SAC, EAC">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary mt-2 btn-add-item">
                                                <i class="fa fa-plus"></i> Tambah Item
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ==================== TAB SOLUSI ==================== -->
                        <div class="tab-pane fade" id="tab-solusi">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle mr-2"></i>
                                Section solusi lengkap berisi <strong>Info Cards</strong> (Pemerintah/Mitra) dan
                                <strong>Quality Items</strong> (jaminan mutu).
                            </div>

                            <div class="section-divider">Header Section Solusi</div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Badge</label>
                                    <input type="text" name="section_solusi_badge"
                                        class="form-control form-control-sm" value="Solusi Menyeluruh & Terpercaya">
                                </div>
                                <div class="col-md-8">
                                    <label>Judul Section</label>
                                    <input type="text" name="section_solusi_title"
                                        class="form-control form-control-sm"
                                        value="Solusi Cetak Paspor dengan Fitur Keamanan Tinggi">
                                </div>
                                <div class="col-12 mt-2">
                                    <label>Deskripsi</label>
                                    <textarea name="section_solusi_desc" class="form-control form-control-sm" rows="3">Jasuindo menghadirkan solusi lengkap dan terpercaya dalam pembuatan paspor berkualitas tinggi.</textarea>
                                </div>
                            </div>

                            <div class="section-divider">
                                Info Cards
                                <button type="button" class="btn btn-primary btn-sm float-right" id="btnAddInfoCard">
                                    <i class="fa fa-plus mr-1"></i> Tambah Info Card
                                </button>
                            </div>

                            <div id="infoCardRepeater">
                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Icon (FA Class)</label>
                                            <input type="text" name="info_cards[0][Icon]"
                                                class="form-control form-control-sm" value="fa-building-columns"
                                                placeholder="fa-building-columns">
                                            <small class="text-muted d-block mt-1">
                                                <a href="https://fontawesome.com/icons" target="_blank">Lihat daftar icon
                                                    →</a>
                                            </small>
                                        </div>
                                        <div class="col-md-9">
                                            <label>Judul</label>
                                            <input type="text" name="info_cards[0][Judul]"
                                                class="form-control form-control-sm" value="Pemerintah & Imigrasi">
                                            <label class="mt-2">Deskripsi</label>
                                            <textarea name="info_cards[0][Deskripsi]" class="form-control form-control-sm" rows="2">Penyediaan buku paspor nasional, blangko paspor diplomatik, dinas, dan reguler serta integrasi chip biometrik kenegaraan terpercaya.</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Icon (FA Class)</label>
                                            <input type="text" name="info_cards[1][Icon]"
                                                class="form-control form-control-sm" value="fa-handshake">
                                        </div>
                                        <div class="col-md-9">
                                            <label>Judul</label>
                                            <input type="text" name="info_cards[1][Judul]"
                                                class="form-control form-control-sm" value="Mitra Strategis & OEM">
                                            <label class="mt-2">Deskripsi</label>
                                            <textarea name="info_cards[1][Deskripsi]" class="form-control form-control-sm" rows="2">Aliansi manufaktur OEM, pasokan modul electronic inlay, penutup buku paspor, dan konsorsium percetakan sekuriti lintas kawasan regional.</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section-divider mt-4">Header Box Kualitas</div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Badge Box</label>
                                    <input type="text" name="section_quality_badge"
                                        class="form-control form-control-sm" value="STANDAR DUNIA ISO 14298">
                                </div>
                                <div class="col-md-8">
                                    <label>Judul Box</label>
                                    <input type="text" name="section_quality_title"
                                        class="form-control form-control-sm" value="Jaminan Keabsahan & Mutu">
                                </div>
                            </div>

                            <div class="section-divider">
                                Quality Items
                                <button type="button" class="btn btn-primary btn-sm float-right" id="btnAddQualityItem">
                                    <i class="fa fa-plus mr-1"></i> Tambah Item
                                </button>
                            </div>

                            <div id="qualityItemRepeater">
                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Icon</label>
                                            <input type="text" name="quality_items[0][Icon]"
                                                class="form-control form-control-sm" value="fa-industry">
                                        </div>
                                        <div class="col-md-9">
                                            <label>Judul</label>
                                            <input type="text" name="quality_items[0][Judul]"
                                                class="form-control form-control-sm"
                                                value="Kapasitas Manufaktur Skala Besar">
                                            <label class="mt-2">Deskripsi</label>
                                            <textarea name="quality_items[0][Deskripsi]" class="form-control form-control-sm" rows="2">Fasilitas modern dengan kapasitas cetak puluhan juta buku paspor per tahun dengan presisi konsisten.</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Icon</label>
                                            <input type="text" name="quality_items[1][Icon]"
                                                class="form-control form-control-sm" value="fa-lock">
                                        </div>
                                        <div class="col-md-9">
                                            <label>Judul</label>
                                            <input type="text" name="quality_items[1][Judul]"
                                                class="form-control form-control-sm"
                                                value="Area Fasilitas High-Security Terisolasi">
                                            <label class="mt-2">Deskripsi</label>
                                            <textarea name="quality_items[1][Deskripsi]" class="form-control form-control-sm" rows="2">Akses biometrik ganda dan pengawasan CCTV 24/7 bersertifikasi Integraf Security Printing Level Certified.</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Icon</label>
                                            <input type="text" name="quality_items[2][Icon]"
                                                class="form-control form-control-sm" value="fa-database">
                                        </div>
                                        <div class="col-md-9">
                                            <label>Judul</label>
                                            <input type="text" name="quality_items[2][Judul]"
                                                class="form-control form-control-sm"
                                                value="Kerahasiaan Data & Kedaulatan Nasional">
                                            <label class="mt-2">Deskripsi</label>
                                            <textarea name="quality_items[2][Deskripsi]" class="form-control form-control-sm" rows="2">Protokol pemusnahan sisa bahan reject tersertifikasi dan perlindungan enkripsi kunci kriptografi kenegaraan.</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ==================== TAB SECURITY ==================== -->
                        <div class="tab-pane fade" id="tab-security">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle mr-2"></i>
                                Section fitur keamanan 3 level (Overt, Covert, Forensic).
                            </div>

                            <div class="section-divider">Header Section Keamanan</div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Badge</label>
                                    <input type="text" name="section_security_badge"
                                        class="form-control form-control-sm" value="FORENSIC & INSPECTION STANDARD">
                                </div>
                                <div class="col-md-8">
                                    <label>Judul Section</label>
                                    <input type="text" name="section_security_title"
                                        class="form-control form-control-sm"
                                        value="Fitur Keamanan Tiga Level (Level 1, 2, & 3)">
                                </div>
                                <div class="col-12 mt-2">
                                    <label>Deskripsi</label>
                                    <textarea name="section_security_desc" class="form-control form-control-sm" rows="2">Setiap paspor dirancang bertingkat untuk memudahkan verifikasi cepat oleh petugas imigrasi.</textarea>
                                </div>
                            </div>

                            <div class="section-divider">
                                Level Keamanan
                                <button type="button" class="btn btn-primary btn-sm float-right"
                                    id="btnAddSecurityLevel">
                                    <i class="fa fa-plus mr-1"></i> Tambah Level
                                </button>
                            </div>

                            <div id="securityLevelRepeater">
                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Label Level</label>
                                                <input type="text" name="security_levels[0][LevelLabel]"
                                                    class="form-control form-control-sm" value="LEVEL 01">
                                            </div>
                                            <div class="form-group">
                                                <label>Icon</label>
                                                <input type="text" name="security_levels[0][Icon]"
                                                    class="form-control form-control-sm" value="fa-eye">
                                            </div>
                                            <div class="form-group">
                                                <label>Alat</label>
                                                <input type="text" name="security_levels[0][Alat]"
                                                    class="form-control form-control-sm" value="Tanpa Alat">
                                            </div>
                                            <div class="form-group">
                                                <label>Kecepatan</label>
                                                <input type="text" name="security_levels[0][Kecepatan]"
                                                    class="form-control form-control-sm" value="< 3 Detik">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label>Judul</label>
                                                <input type="text" name="security_levels[0][Judul]"
                                                    class="form-control form-control-sm" value="Overt (Kasat Mata)">
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi</label>
                                                <textarea name="security_levels[0][Deskripsi]" class="form-control form-control-sm" rows="2">Inspeksi langsung tanpa alat bantu dalam hitungan detik.</textarea>
                                            </div>
                                            <label>List Fitur</label>
                                            <div class="list-items-container">
                                                <div class="list-item-row">
                                                    <input type="text" name="security_levels[0][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Cetak intaglio bertekstur timbul">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="list-item-row">
                                                    <input type="text" name="security_levels[0][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="OVI tinta berubah warna sesuai sudut pandang">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="list-item-row">
                                                    <input type="text" name="security_levels[0][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Watermark transmisi cahaya tajam">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary mt-2 btn-add-item">
                                                <i class="fa fa-plus"></i> Tambah Item
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Label Level</label>
                                                <input type="text" name="security_levels[1][LevelLabel]"
                                                    class="form-control form-control-sm" value="LEVEL 02">
                                            </div>
                                            <div class="form-group">
                                                <label>Icon</label>
                                                <input type="text" name="security_levels[1][Icon]"
                                                    class="form-control form-control-sm" value="fa-magnifying-glass">
                                            </div>
                                            <div class="form-group">
                                                <label>Alat</label>
                                                <input type="text" name="security_levels[1][Alat]"
                                                    class="form-control form-control-sm" value="Lampu UV / Lup">
                                            </div>
                                            <div class="form-group">
                                                <label>Kecepatan</label>
                                                <input type="text" name="security_levels[1][Kecepatan]"
                                                    class="form-control form-control-sm" value="< 15 Detik">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label>Judul</label>
                                                <input type="text" name="security_levels[1][Judul]"
                                                    class="form-control form-control-sm" value="Covert (Alat Bantu)">
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi</label>
                                                <textarea name="security_levels[1][Deskripsi]" class="form-control form-control-sm" rows="2">Verifikasi tak kasat mata menggunakan peralatan standar petugas lapangan.</textarea>
                                            </div>
                                            <label>List Fitur</label>
                                            <div class="list-items-container">
                                                <div class="list-item-row">
                                                    <input type="text" name="security_levels[1][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Serat fluoresen UV tersembunyi">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="list-item-row">
                                                    <input type="text" name="security_levels[1][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Microtext & pola retro-reflektif">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary mt-2 btn-add-item">
                                                <i class="fa fa-plus"></i> Tambah Item
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Label Level</label>
                                                <input type="text" name="security_levels[2][LevelLabel]"
                                                    class="form-control form-control-sm" value="LEVEL 03">
                                            </div>
                                            <div class="form-group">
                                                <label>Icon</label>
                                                <input type="text" name="security_levels[2][Icon]"
                                                    class="form-control form-control-sm" value="fa-flask">
                                            </div>
                                            <div class="form-group">
                                                <label>Alat</label>
                                                <input type="text" name="security_levels[2][Alat]"
                                                    class="form-control form-control-sm" value="Lab Forensik">
                                            </div>
                                            <div class="form-group">
                                                <label>Kecepatan</label>
                                                <input type="text" name="security_levels[2][Kecepatan]"
                                                    class="form-control form-control-sm" value="Ahli Dokumen">
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label>Judul</label>
                                                <input type="text" name="security_levels[2][Judul]"
                                                    class="form-control form-control-sm" value="Forensic (Ahli Lab)">
                                            </div>
                                            <div class="form-group">
                                                <label>Deskripsi</label>
                                                <textarea name="security_levels[2][Deskripsi]" class="form-control form-control-sm" rows="2">Pemeriksaan spesifik laboratorium kriminalistik untuk pembuatan legal di pengadilan.</textarea>
                                            </div>
                                            <label>List Fitur</label>
                                            <div class="list-items-container">
                                                <div class="list-item-row">
                                                    <input type="text" name="security_levels[2][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Penanda kimiawi rahasia (chemical taggants)">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="list-item-row">
                                                    <input type="text" name="security_levels[2][Items][]"
                                                        class="form-control form-control-sm"
                                                        value="Spektroskopi inframerah & analisis substrat">
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-danger btn-remove-item">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary mt-2 btn-add-item">
                                                <i class="fa fa-plus"></i> Tambah Item
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ==================== TAB FAQ ==================== -->
                        <div class="tab-pane fade" id="tab-faq">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle mr-2"></i>
                                Section FAQ (Frequently Asked Questions) untuk halaman solusi.
                            </div>

                            <div class="section-divider">Header Section FAQ</div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Badge</label>
                                    <input type="text" name="section_faq_badge" class="form-control form-control-sm"
                                        value="Pusat Pengetahuan & Regulasi">
                                </div>
                                <div class="col-md-8">
                                    <label>Judul Section</label>
                                    <input type="text" name="section_faq_title" class="form-control form-control-sm"
                                        value="Pertanyaan Umum Seputar Pengadaan Paspor">
                                </div>
                                <div class="col-12 mt-2">
                                    <label>Deskripsi</label>
                                    <textarea name="section_faq_desc" class="form-control form-control-sm" rows="2">Panduan teknis, kepatuhan regulasi ICAO, standar keamanan fisik & digital.</textarea>
                                </div>
                            </div>

                            <div class="section-divider">
                                Daftar FAQ
                                <button type="button" class="btn btn-primary btn-sm float-right" id="btnAddFaq">
                                    <i class="fa fa-plus mr-1"></i> Tambah FAQ
                                </button>
                            </div>

                            <div id="faqRepeater">
                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="form-group">
                                        <label>Pertanyaan</label>
                                        <input type="text" name="faqs[0][Pertanyaan]"
                                            class="form-control form-control-sm"
                                            value="Apakah produk paspor dan e-Passport telah memenuhi standar ICAO Doc 9303?">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Jawaban</label>
                                        <textarea name="faqs[0][Jawaban]" class="form-control form-control-sm" rows="3">Ya, seluruh produk paspor dan e-Passport yang kami produksi telah tersertifikasi sesuai standar ICAO Doc 9303 edisi terbaru.</textarea>
                                    </div>
                                </div>

                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="form-group">
                                        <label>Pertanyaan</label>
                                        <input type="text" name="faqs[1][Pertanyaan]"
                                            class="form-control form-control-sm"
                                            value="Bagaimana proses penjaminan rantai pasok dan kerahasiaan data (NDA)?">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Jawaban</label>
                                        <textarea name="faqs[1][Jawaban]" class="form-control form-control-sm" rows="3">Kami menerapkan protokol NDA (Non-Disclosure Agreement) berlapis untuk setiap proyek kenegaraan.</textarea>
                                    </div>
                                </div>

                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="form-group">
                                        <label>Pertanyaan</label>
                                        <input type="text" name="faqs[2][Pertanyaan]"
                                            class="form-control form-control-sm"
                                            value="Apa keunggulan Halaman Data Polikarbonat (PCDP)?">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Jawaban</label>
                                        <textarea name="faqs[2][Jawaban]" class="form-control form-control-sm" rows="3">PCDP memiliki ketahanan hingga 10 tahun tanpa delaminasi, tahan suhu ekstrem, anti manipulasi laser engraving.</textarea>
                                    </div>
                                </div>

                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="form-group">
                                        <label>Pertanyaan</label>
                                        <input type="text" name="faqs[3][Pertanyaan]"
                                            class="form-control form-control-sm"
                                            value="Dapatkah instansi mengajukan kustomisasi fitur sekuriti?">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Jawaban</label>
                                        <textarea name="faqs[3][Jawaban]" class="form-control form-control-sm" rows="3">Ya, kami menyediakan layanan konsultasi teknis untuk kustomisasi fitur keamanan sesuai tingkat ancaman.</textarea>
                                    </div>
                                </div>

                                <div class="repeater-item">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="form-group">
                                        <label>Pertanyaan</label>
                                        <input type="text" name="faqs[4][Pertanyaan]"
                                            class="form-control form-control-sm"
                                            value="Bagaimana alur dan waktu pemenuhan pengadaan berskala jutaan dokumen?">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Jawaban</label>
                                        <textarea name="faqs[4][Jawaban]" class="form-control form-control-sm" rows="3">Dengan kapasitas produksi hingga 50 juta buku paspor per tahun, kami dapat memenuhi pengadaan skala besar dalam waktu 6-12 bulan.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ==================== TAB PENGATURAN ==================== -->
                        <div class="tab-pane fade" id="tab-pengaturan">
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle mr-2"></i>
                                Pengaturan umum dan SEO untuk halaman solusi.
                            </div>

                            <div class="section-divider">SEO & Meta</div>
                            <div class="form-group">
                                <label>Meta Title (untuk SEO)</label>
                                <input type="text" name="MetaTitle" class="form-control"
                                    value="Paspor & Dokumen Imigrasi Resmi | Jasuindo"
                                    placeholder="Judul halaman untuk search engine">
                                <small class="text-muted">Maksimal 60 karakter. Kosongkan untuk menggunakan judul
                                    halaman.</small>
                            </div>
                            <div class="form-group">
                                <label>Meta Description (untuk SEO)</label>
                                <textarea name="MetaDescription" class="form-control" rows="3"
                                    placeholder="Deskripsi singkat untuk hasil pencarian Google">Solusi lengkap pembuatan paspor berstandar internasional dengan fitur keamanan canggih. Konsultasikan kebutuhan Anda dengan tim ahli Jasuindo.</textarea>
                                <small class="text-muted">Maksimal 160 karakter.</small>
                            </div>

                            <div class="section-divider">Breadcrumb Custom</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Label Kategori</label>
                                    <input type="text" name="BreadcrumbCategory" class="form-control"
                                        value="Identitas" placeholder="Contoh: Identitas, Keamanan, dll">
                                </div>
                                <div class="col-md-6">
                                    <label>URL Kategori</label>
                                    <input type="text" name="BreadcrumbCategoryUrl" class="form-control"
                                        value="/solusi/identitas" placeholder="/solusi/kategori">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="#" class="btn btn-secondary mr-2">
                        <i class="fa fa-times mr-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save mr-1"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Summernote
            $('.summernote').summernote({
                height: 300,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['codeview']]
                ]
            });

            // Remove repeater item
            $(document).on('click', '.btn-remove', function() {
                if (confirm('Hapus item ini?')) {
                    $(this).closest('.repeater-item').remove();
                }
            });

            // Remove list item
            $(document).on('click', '.btn-remove-item', function() {
                $(this).closest('.list-item-row').remove();
            });

            // Add list item
            $(document).on('click', '.btn-add-item', function() {
                const container = $(this).siblings('.list-items-container');
                const inputName = container.find('input').first().attr('name');
                container.append(`
                    <div class="list-item-row">
                        <input type="text" name="${inputName}" class="form-control form-control-sm" placeholder="Item baru...">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-item">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                `);
            });

            // Add Komponen
            let komponenIdx = 3;
            $('#btnAddKomponen').click(function() {
                const html = `
                    <div class="repeater-item">
                        <button type="button" class="btn btn-sm btn-danger btn-remove">
                            <i class="fa fa-trash"></i>
                        </button>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Judul</label>
                                    <input type="text" name="komponen[${komponenIdx}][Judul]" class="form-control form-control-sm" placeholder="Judul komponen">
                                </div>
                                <div class="form-group">
                                    <label>Sub Judul</label>
                                    <input type="text" name="komponen[${komponenIdx}][SubJudul]" class="form-control form-control-sm" placeholder="Sub judul">
                                </div>
                                <div class="form-group">
                                    <label>Tipe Layout</label>
                                    <select name="komponen[${komponenIdx}][Tipe]" class="form-control form-control-sm">
                                        <option value="besar">Besar (3 Kolom)</option>
                                        <option value="horizontal">Horizontal (2 Kolom)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Gambar</label>
                                    <input type="file" name="komponen[${komponenIdx}][Gambar]" class="form-control-file" accept="image/*">
                                    <div class="img-preview-box">
                                        <i class="fa fa-image placeholder-icon"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label>List Items</label>
                                <div class="list-items-container">
                                    <div class="list-item-row">
                                        <input type="text" name="komponen[${komponenIdx}][Items][]" class="form-control form-control-sm" placeholder="Item...">
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-item">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2 btn-add-item">
                                    <i class="fa fa-plus"></i> Tambah Item
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                $('#komponenRepeater').append(html);
                komponenIdx++;
            });

            // Add Info Card
            let infoIdx = 2;
            $('#btnAddInfoCard').click(function() {
                const html = `
                    <div class="repeater-item">
                        <button type="button" class="btn btn-sm btn-danger btn-remove">
                            <i class="fa fa-trash"></i>
                        </button>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Icon (FA Class)</label>
                                <input type="text" name="info_cards[${infoIdx}][Icon]" class="form-control form-control-sm" placeholder="fa-building-columns">
                                <small class="text-muted d-block mt-1">
                                    <a href="https://fontawesome.com/icons" target="_blank">Lihat daftar icon →</a>
                                </small>
                            </div>
                            <div class="col-md-9">
                                <label>Judul</label>
                                <input type="text" name="info_cards[${infoIdx}][Judul]" class="form-control form-control-sm">
                                <label class="mt-2">Deskripsi</label>
                                <textarea name="info_cards[${infoIdx}][Deskripsi]" class="form-control form-control-sm" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                `;
                $('#infoCardRepeater').append(html);
                infoIdx++;
            });

            // Add Quality Item
            let qualityIdx = 3;
            $('#btnAddQualityItem').click(function() {
                const html = `
                    <div class="repeater-item">
                        <button type="button" class="btn btn-sm btn-danger btn-remove">
                            <i class="fa fa-trash"></i>
                        </button>
                        <div class="row">
                            <div class="col-md-3">
                                <label>Icon</label>
                                <input type="text" name="quality_items[${qualityIdx}][Icon]" class="form-control form-control-sm" placeholder="fa-industry">
                            </div>
                            <div class="col-md-9">
                                <label>Judul</label>
                                <input type="text" name="quality_items[${qualityIdx}][Judul]" class="form-control form-control-sm">
                                <label class="mt-2">Deskripsi</label>
                                <textarea name="quality_items[${qualityIdx}][Deskripsi]" class="form-control form-control-sm" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                `;
                $('#qualityItemRepeater').append(html);
                qualityIdx++;
            });

            // Add Security Level
            let secIdx = 3;
            $('#btnAddSecurityLevel').click(function() {
                const html = `
                    <div class="repeater-item">
                        <button type="button" class="btn btn-sm btn-danger btn-remove">
                            <i class="fa fa-trash"></i>
                        </button>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Label Level</label>
                                    <input type="text" name="security_levels[${secIdx}][LevelLabel]" class="form-control form-control-sm" placeholder="LEVEL 0${secIdx + 1}">
                                </div>
                                <div class="form-group">
                                    <label>Icon</label>
                                    <input type="text" name="security_levels[${secIdx}][Icon]" class="form-control form-control-sm" placeholder="fa-eye">
                                </div>
                                <div class="form-group">
                                    <label>Alat</label>
                                    <input type="text" name="security_levels[${secIdx}][Alat]" class="form-control form-control-sm" placeholder="Tanpa Alat">
                                </div>
                                <div class="form-group">
                                    <label>Kecepatan</label>
                                    <input type="text" name="security_levels[${secIdx}][Kecepatan]" class="form-control form-control-sm" placeholder="< 3 Detik">
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>Judul</label>
                                    <input type="text" name="security_levels[${secIdx}][Judul]" class="form-control form-control-sm" placeholder="Overt (Kasat Mata)">
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="security_levels[${secIdx}][Deskripsi]" class="form-control form-control-sm" rows="2"></textarea>
                                </div>
                                <label>List Fitur</label>
                                <div class="list-items-container">
                                    <div class="list-item-row">
                                        <input type="text" name="security_levels[${secIdx}][Items][]" class="form-control form-control-sm" placeholder="Fitur...">
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-item">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2 btn-add-item">
                                    <i class="fa fa-plus"></i> Tambah Item
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                $('#securityLevelRepeater').append(html);
                secIdx++;
            });

            // Add FAQ
            let faqIdx = 5;
            $('#btnAddFaq').click(function() {
                const html = `
                    <div class="repeater-item">
                        <button type="button" class="btn btn-sm btn-danger btn-remove">
                            <i class="fa fa-trash"></i>
                        </button>
                        <div class="form-group">
                            <label>Pertanyaan</label>
                            <input type="text" name="faqs[${faqIdx}][Pertanyaan]" class="form-control form-control-sm">
                        </div>
                        <div class="form-group mb-0">
                            <label>Jawaban</label>
                            <textarea name="faqs[${faqIdx}][Jawaban]" class="form-control form-control-sm" rows="3"></textarea>
                        </div>
                    </div>
                `;
                $('#faqRepeater').append(html);
                faqIdx++;
            });
        });
    </script>
@endpush

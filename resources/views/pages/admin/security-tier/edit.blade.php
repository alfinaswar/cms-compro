@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            .invalid-feedback { animation: fadeIn .3s ease-in-out; }
            @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
            .subfeature-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin-bottom: 12px; }
        </style>
    @endpush

    @php
        $transId = $item->translations->firstWhere('Locale', 'id');
        $transEn = $item->translations->firstWhere('Locale', 'en');
        $featuresId = $transId && is_array($transId->Features) ? $transId->Features : [];
        $featuresEn = $transEn && is_array($transEn->Features) ? $transEn->Features : [];
    @endphp

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1>Edit Lapisan Keamanan</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('homepage.index') }}">Homepage</a></li>
                        <li class="breadcrumb-item active">Edit Lapisan Keamanan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12">
                <form action="{{ route('security-tier.update', $item->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom">
                            <h3 class="card-title mb-0"><i class="fa fa-shield-alt text-primary mr-2"></i><strong>Edit Lapisan Keamanan: Tier {{ $item->NomorTier }}</strong></h3>
                        </div>
                        <div class="card-body">

                            {{-- PENGATURAN UMUM: NOMOR TIER, ICON FONTAWESOME, URUTAN & STATUS --}}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label><strong>Nomor / Label Tier</strong> <span class="text-danger">*</span></label>
                                        <input type="text" name="NomorTier" class="form-control @error('NomorTier') is-invalid @enderror" value="{{ old('NomorTier', $item->NomorTier) }}" required placeholder="Contoh: 01, 02, dst.">
                                        @error('NomorTier') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        <small class="text-muted">Nomor urut tier yang tampil besar pada kartu.</small>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="Icon"><strong>Icon (FontAwesome)</strong></label>
                                        @include('partials.icon-picker', [
                                            'id' => 'Icon',
                                            'name' => 'Icon',
                                            'value' => old('Icon', $item->Icon),
                                            'placeholder' => 'fa-solid fa-shield-halved',
                                            'invalid' => $errors->has('Icon'),
                                        ])
                                        @error('Icon') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        <small class="text-muted">Pilih icon FontAwesome atau ketik class, contoh: <code>fa-regular fa-eye</code>.</small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><strong>Urutan</strong> <span class="text-danger">*</span></label>
                                        <input type="number" name="Urutan" class="form-control @error('Urutan') is-invalid @enderror" value="{{ old('Urutan', $item->Urutan) }}" min="0" required>
                                        @error('Urutan') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label><strong>Status</strong> <span class="text-danger">*</span></label>
                                        <select name="Status" class="form-control @error('Status') is-invalid @enderror" required>
                                            <option value="1" {{ old('Status', (string)$item->Status) === '1' ? 'selected' : '' }}>Aktif</option>
                                            <option value="0" {{ old('Status', (string)$item->Status) === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                        @error('Status') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            {{-- TABS MULTI-BAHASA --}}
                            <ul class="nav nav-tabs mb-4" id="tierLangTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="tier-tab-id" data-toggle="tab" href="#tier-pane-id" role="tab">🇮🇩 Bahasa Indonesia <span class="text-danger">*</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="tier-tab-en" data-toggle="tab" href="#tier-pane-en" role="tab">🇬🇧 English</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="tierLangTabsContent">
                                <!-- TAB INDONESIA -->
                                <div class="tab-pane fade show active" id="tier-pane-id" role="tabpanel">
                                    <div class="form-group">
                                        <label><strong>Judul Tier (ID)</strong> <span class="text-danger">*</span></label>
                                        <input type="text" name="translations[id][Judul]" class="form-control @error('translations.id.Judul') is-invalid @enderror" value="{{ old('translations.id.Judul', $transId->Judul ?? '') }}" required placeholder="Contoh: Fitur Keamanan Kasat Mata">
                                        @error('translations.id.Judul') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Deskripsi Tier (ID)</strong> <span class="text-danger">*</span></label>
                                        <textarea name="translations[id][Deskripsi]" rows="3" class="form-control @error('translations.id.Deskripsi') is-invalid @enderror" required placeholder="Contoh: Elemen keamanan visual yang dapat diverifikasi tanpa alat khusus.">{{ old('translations.id.Deskripsi', $transId->Deskripsi ?? '') }}</textarea>
                                        @error('translations.id.Deskripsi') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>

                                    <h5 class="text-primary font-weight-bold mt-4 mb-3"><i class="fa fa-list-check mr-1"></i> Sub-Fitur (Poin Detail Kartu - ID)</h5>
                                    <!-- Sub-fitur 1 -->
                                    <div class="subfeature-box">
                                        <div class="font-weight-bold text-secondary mb-2">Sub-Fitur 1</div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <input type="text" name="translations[id][features][0][t]" class="form-control" value="{{ old('translations.id.features.0.t', $featuresId[0]['t'] ?? '') }}" placeholder="Judul Sub-Fitur (contoh: Diffractive OVD Hologram)">
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" name="translations[id][features][0][d]" class="form-control" value="{{ old('translations.id.features.0.d', $featuresId[0]['d'] ?? '') }}" placeholder="Keterangan singkat (contoh: Citra kinetik 2D/3D & microtext.)">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Sub-fitur 2 -->
                                    <div class="subfeature-box">
                                        <div class="font-weight-bold text-secondary mb-2">Sub-Fitur 2</div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <input type="text" name="translations[id][features][1][t]" class="form-control" value="{{ old('translations.id.features.1.t', $featuresId[1]['t'] ?? '') }}" placeholder="Judul Sub-Fitur (contoh: Visual Effect Ink / OVI)">
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" name="translations[id][features][1][d]" class="form-control" value="{{ old('translations.id.features.1.d', $featuresId[1]['d'] ?? '') }}" placeholder="Keterangan singkat (contoh: Perubahan warna dua nada saat dimiringkan.)">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB ENGLISH -->
                                <div class="tab-pane fade" id="tier-pane-en" role="tabpanel">
                                    <div class="form-group">
                                        <label><strong>Tier Title (EN)</strong></label>
                                        <input type="text" name="translations[en][Judul]" class="form-control @error('translations.en.Judul') is-invalid @enderror" value="{{ old('translations.en.Judul', $transEn->Judul ?? '') }}" placeholder="Example: Overt Security Features">
                                        @error('translations.en.Judul') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Tier Description (EN)</strong></label>
                                        <textarea name="translations[en][Deskripsi]" rows="3" class="form-control @error('translations.en.Deskripsi') is-invalid @enderror" placeholder="Example: Visual security elements verifiable without special tools.">{{ old('translations.en.Deskripsi', $transEn->Deskripsi ?? '') }}</textarea>
                                        @error('translations.en.Deskripsi') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>

                                    <h5 class="text-primary font-weight-bold mt-4 mb-3"><i class="fa fa-list-check mr-1"></i> Sub-Features (Card Details - EN)</h5>
                                    <!-- Sub-feature 1 -->
                                    <div class="subfeature-box">
                                        <div class="font-weight-bold text-secondary mb-2">Sub-Feature 1</div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <input type="text" name="translations[en][features][0][t]" class="form-control" value="{{ old('translations.en.features.0.t', $featuresEn[0]['t'] ?? '') }}" placeholder="Feature Title (e.g., Diffractive OVD Hologram)">
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" name="translations[en][features][0][d]" class="form-control" value="{{ old('translations.en.features.0.d', $featuresEn[0]['d'] ?? '') }}" placeholder="Feature Description (e.g., 2D/3D kinetic images & microtext.)">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Sub-feature 2 -->
                                    <div class="subfeature-box">
                                        <div class="font-weight-bold text-secondary mb-2">Sub-Feature 2</div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <input type="text" name="translations[en][features][1][t]" class="form-control" value="{{ old('translations.en.features.1.t', $featuresEn[1]['t'] ?? '') }}" placeholder="Feature Title (e.g., Visual Effect Ink / OVI)">
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" name="translations[en][features][1][d]" class="form-control" value="{{ old('translations.en.features.1.d', $featuresEn[1]['d'] ?? '') }}" placeholder="Feature Description (e.g., Two-tone color shift when tilted.)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer bg-white border-top d-flex justify-content-end">
                            <a href="{{ route('homepage.index') }}" class="btn btn-light border px-4 mr-2"><i class="fa fa-arrow-left mr-1"></i> Batal</a>
                            <button type="submit" class="btn btn-primary px-4"><i class="fa fa-save mr-1"></i> Perbarui</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

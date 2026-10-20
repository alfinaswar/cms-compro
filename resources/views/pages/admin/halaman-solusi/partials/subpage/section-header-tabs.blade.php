{{-- Header section (Sub Judul, Judul & Deskripsi) dengan tab bahasa ID/EN --}}
@php
    $prefix = $prefix ?? 'Sec1';      // Sec1 | Sec2 | Sec3 | Faq
    $paneBase = $paneBase ?? strtolower($prefix);
    $rows = $rows ?? 2;
@endphp
<ul class="nav nav-tabs mb-2" role="tablist">
    <li class="nav-item">
        <a class="nav-link active py-1 px-2" data-toggle="tab" href="#{{ $paneBase }}-head-id" role="tab">🇮🇩 Bahasa Indonesia</a>
    </li>
    <li class="nav-item">
        <a class="nav-link py-1 px-2" data-toggle="tab" href="#{{ $paneBase }}-head-en" role="tab">🇬🇧 English</a>
    </li>
</ul>
<div class="tab-content mb-2">
    @foreach (['id' => 'Bahasa Indonesia', 'en' => 'English'] as $langCode => $langLabel)
        <div class="tab-pane fade {{ $langCode === 'id' ? 'show active' : '' }}" id="{{ $paneBase }}-head-{{ $langCode }}" role="tabpanel">
            <div class="row">
                <div class="col-md-4">
                    <label>Sub Judul (Badge)</label>
                    <input type="text" name="translations[{{ $langCode }}][{{ $prefix }}SubJudul]" class="form-control form-control-sm"
                        value="{{ old('translations.'.$langCode.'.'.$prefix.'SubJudul', $tv($subpage, $langCode, $prefix.'SubJudul')) }}"
                        placeholder="Label badge ({{ $langLabel }})">
                </div>
                <div class="col-md-8">
                    <label>Judul Section</label>
                    <input type="text" name="translations[{{ $langCode }}][{{ $prefix }}Judul]" class="form-control form-control-sm"
                        value="{{ old('translations.'.$langCode.'.'.$prefix.'Judul', $tv($subpage, $langCode, $prefix.'Judul')) }}"
                        placeholder="Judul section ({{ $langLabel }})">
                </div>
                <div class="col-12 mt-2">
                    <label>Deskripsi</label>
                    <textarea name="translations[{{ $langCode }}][{{ $prefix }}Deskripsi]" class="form-control form-control-sm"
                        rows="{{ $rows }}"
                        placeholder="Deskripsi section ({{ $langLabel }})">{{ old('translations.'.$langCode.'.'.$prefix.'Deskripsi', $tv($subpage, $langCode, $prefix.'Deskripsi')) }}</textarea>
                </div>
            </div>
        </div>
    @endforeach
</div>

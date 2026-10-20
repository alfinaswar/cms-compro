{{-- Baris repeater item Section 2 & 3 — teks multi bahasa (ID/EN), icon bersama --}}
<div class="repeater-item">
    <button type="button" class="btn btn-sm btn-danger btn-remove" title="Hapus">
        <i class="fa fa-trash"></i>
    </button>
    @if ($item)
        <input type="hidden" name="{{ $prefix }}[{{ $i }}][Id]" value="{{ $item->id }}">
    @endif
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Icon (Gambar)</label>
                <input type="file" name="{{ $prefix }}[{{ $i }}][Icon]" class="form-control-file img-input"
                    accept="image/*">
                @if ($item && $item->Icon)
                    <small class="text-muted d-block">Kosongkan jika tetap memakai icon lama.</small>
                @endif
                <div class="img-preview-box icon-box">
                    @if ($item && $item->Icon)
                        <img src="{{ asset('storage/' . $item->Icon) }}" alt="preview">
                    @else
                        <i class="fa fa-image placeholder-icon"></i>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-9">
            {{-- Tab bahasa untuk konten teks --}}
            <ul class="nav nav-tabs mb-2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active py-1 px-2" data-toggle="tab" href="#{{ $prefix }}-{{ $i }}-id" role="tab">🇮🇩 Bahasa Indonesia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-1 px-2" data-toggle="tab" href="#{{ $prefix }}-{{ $i }}-en" role="tab">🇬🇧 English</a>
                </li>
            </ul>
            <div class="tab-content">
                @foreach (['id' => 'Bahasa Indonesia', 'en' => 'English'] as $langCode => $langLabel)
                    <div class="tab-pane fade {{ $langCode === 'id' ? 'show active' : '' }}" id="{{ $prefix }}-{{ $i }}-{{ $langCode }}" role="tabpanel">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="{{ $prefix }}[{{ $i }}][translations][{{ $langCode }}][Judul]"
                                class="form-control form-control-sm"
                                value="{{ old($prefix.'.'.$i.'.translations.'.$langCode.'.Judul', $tv($item, $langCode, 'Judul')) }}"
                                placeholder="Judul item ({{ $langLabel }})">
                        </div>
                        <div class="form-group mb-0">
                            <label>Deskripsi</label>
                            <textarea name="{{ $prefix }}[{{ $i }}][translations][{{ $langCode }}][Deskripsi]" class="form-control form-control-sm"
                                rows="2"
                                placeholder="Deskripsi item ({{ $langLabel }})">{{ old($prefix.'.'.$i.'.translations.'.$langCode.'.Deskripsi', $tv($item, $langCode, 'Deskripsi')) }}</textarea>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

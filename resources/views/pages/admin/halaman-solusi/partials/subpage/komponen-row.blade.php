{{-- Baris repeater Komponen (Section 1) — teks multi bahasa (ID/EN), gambar & tipe bersama --}}
<div class="repeater-item">
    <button type="button" class="btn btn-sm btn-danger btn-remove" title="Hapus">
        <i class="fa fa-trash"></i>
    </button>
    @if ($item)
        <input type="hidden" name="komponen[{{ $i }}][Id]" value="{{ $item->id }}">
    @endif

    {{-- Tab bahasa untuk konten teks --}}
    <ul class="nav nav-tabs mb-2" role="tablist">
        <li class="nav-item">
            <a class="nav-link active py-1 px-2" data-toggle="tab" href="#komponen-{{ $i }}-id" role="tab">🇮🇩 Bahasa Indonesia</a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-1 px-2" data-toggle="tab" href="#komponen-{{ $i }}-en" role="tab">🇬🇧 English</a>
        </li>
    </ul>
    <div class="tab-content mb-2">
        @foreach (['id' => 'Bahasa Indonesia', 'en' => 'English'] as $langCode => $langLabel)
            <div class="tab-pane fade {{ $langCode === 'id' ? 'show active' : '' }}" id="komponen-{{ $i }}-{{ $langCode }}" role="tabpanel">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="komponen[{{ $i }}][translations][{{ $langCode }}][Judul]" class="form-control form-control-sm"
                                value="{{ old('komponen.'.$i.'.translations.'.$langCode.'.Judul', $tv($item, $langCode, 'Judul')) }}"
                                placeholder="Judul komponen ({{ $langLabel }})">
                        </div>
                        <div class="form-group">
                            <label>Sub Judul</label>
                            <input type="text" name="komponen[{{ $i }}][translations][{{ $langCode }}][SubJudul]" class="form-control form-control-sm"
                                value="{{ old('komponen.'.$i.'.translations.'.$langCode.'.SubJudul', $tv($item, $langCode, 'SubJudul')) }}"
                                placeholder="Sub judul ({{ $langLabel }})">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label>Poin Keunggulan</label>
                        <div class="list-items-container">
                            @php($listPoints = old('komponen.'.$i.'.translations.'.$langCode.'.Items', $tv($item, $langCode, 'Items') ?: []))
                            @if (count($listPoints))
                                @foreach ($listPoints as $li)
                                    <div class="list-item-row">
                                        <input type="text" name="komponen[{{ $i }}][translations][{{ $langCode }}][Items][]"
                                            class="form-control form-control-sm" value="{{ $li }}" placeholder="Poin keunggulan...">
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-item">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="list-item-row">
                                    <input type="text" name="komponen[{{ $i }}][translations][{{ $langCode }}][Items][]"
                                        class="form-control form-control-sm" placeholder="Poin keunggulan...">
                                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-item">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2 btn-add-item">
                            <i class="fa fa-plus"></i> Tambah Poin
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Field bersama (tidak per bahasa): Tipe layout & Gambar --}}
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Tipe Layout</label>
                <select name="komponen[{{ $i }}][Tipe]" class="form-control form-control-sm">
                    <option value="besar" @if (old('komponen.' . $i . '.Tipe', $item?->Tipe ?? 'besar') === 'besar') selected @endif>Besar
                        (3 Kolom)</option>
                    <option value="horizontal" @if (old('komponen.' . $i . '.Tipe', $item?->Tipe) === 'horizontal') selected
                        @endif>Horizontal (2 Kolom)</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group mb-0">
                <label>Gambar</label>
                <input type="file" name="komponen[{{ $i }}][Gambar]" class="form-control-file img-input"
                    accept="image/*">
                @if ($item && $item->Gambar)
                    <small class="text-muted d-block">Kosongkan jika tetap memakai gambar lama.</small>
                @endif
                <div class="img-preview-box">
                    @if ($item && $item->Gambar)
                        <img src="{{ asset('storage/' . $item->Gambar) }}" alt="preview">
                    @else
                        <i class="fa fa-image placeholder-icon"></i>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Baris repeater Komponen (Section 1) --}}
<div class="repeater-item">
    <button type="button" class="btn btn-sm btn-danger btn-remove" title="Hapus">
        <i class="fa fa-trash"></i>
    </button>
    @if ($item)
        <input type="hidden" name="komponen[{{ $i }}][Id]" value="{{ $item->id }}">
    @endif
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="komponen[{{ $i }}][Judul]" class="form-control form-control-sm"
                    value="{{ old('komponen.' . $i . '.Judul', $item?->Judul) }}" placeholder="Judul komponen">
            </div>
            <div class="form-group">
                <label>Sub Judul</label>
                <input type="text" name="komponen[{{ $i }}][SubJudul]" class="form-control form-control-sm"
                    value="{{ old('komponen.' . $i . '.SubJudul', $item?->SubJudul) }}" placeholder="Sub judul">
            </div>
            <div class="form-group">
                <label>Tipe Layout</label>
                <select name="komponen[{{ $i }}][Tipe]" class="form-control form-control-sm">
                    <option value="besar" @if (old('komponen.' . $i . '.Tipe', $item?->Tipe ?? 'besar') === 'besar') selected @endif>Besar
                        (3 Kolom)</option>
                    <option value="horizontal" @if (old('komponen.' . $i . '.Tipe', $item?->Tipe) === 'horizontal') selected
                        @endif>Horizontal (2 Kolom)</option>
                </select>
            </div>
            <div class="form-group">
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
        <div class="col-md-8">
            <label>Poin Keunggulan</label>
            <div class="list-items-container">
                @php($listItems = old('komponen.' . $i . '.Items', $item?->Items ?? []))
                @if (count($listItems))
                    @foreach ($listItems as $li)
                        <div class="list-item-row">
                            <input type="text" name="komponen[{{ $i }}][Items][]"
                                class="form-control form-control-sm" value="{{ $li }}">
                            <button type="button" class="btn btn-sm btn-outline-danger btn-remove-item">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    @endforeach
                @else
                    <div class="list-item-row">
                        <input type="text" name="komponen[{{ $i }}][Items][]"
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

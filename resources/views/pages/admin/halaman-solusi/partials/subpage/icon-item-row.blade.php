{{-- Baris repeater item Section 2 & 3 (icon gambar + judul + deskripsi) --}}
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
            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="{{ $prefix }}[{{ $i }}][Judul]"
                    class="form-control form-control-sm"
                    value="{{ old($prefix . '.' . $i . '.Judul', $item?->Judul) }}" placeholder="Judul item">
            </div>
            <div class="form-group mb-0">
                <label>Deskripsi</label>
                <textarea name="{{ $prefix }}[{{ $i }}][Deskripsi]" class="form-control form-control-sm"
                    rows="2"
                    placeholder="Deskripsi item">{{ old($prefix . '.' . $i . '.Deskripsi', $item?->Deskripsi) }}</textarea>
            </div>
        </div>
    </div>
</div>

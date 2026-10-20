{{-- Baris repeater FAQ --}}
<div class="repeater-item">
    <button type="button" class="btn btn-sm btn-danger btn-remove" title="Hapus">
        <i class="fa fa-trash"></i>
    </button>
    @if ($item)
        <input type="hidden" name="faqs[{{ $i }}][Id]" value="{{ $item->id }}">
    @endif
    <div class="form-group">
        <label>Pertanyaan</label>
        <input type="text" name="faqs[{{ $i }}][Pertanyaan]" class="form-control form-control-sm"
            value="{{ old('faqs.' . $i . '.Pertanyaan', $item?->Judul) }}" placeholder="Pertanyaan...">
    </div>
    <div class="form-group mb-0">
        <label>Jawaban</label>
        <textarea name="faqs[{{ $i }}][Jawaban]" class="form-control form-control-sm" rows="3"
            placeholder="Jawaban...">{{ old('faqs.' . $i . '.Jawaban', $item?->Deskripsi) }}</textarea>
    </div>
</div>

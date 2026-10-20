{{-- Baris repeater FAQ — teks multi bahasa (ID/EN) --}}
<div class="repeater-item">
    <button type="button" class="btn btn-sm btn-danger btn-remove" title="Hapus">
        <i class="fa fa-trash"></i>
    </button>
    @if ($item)
        <input type="hidden" name="faqs[{{ $i }}][Id]" value="{{ $item->id }}">
    @endif

    {{-- Tab bahasa untuk konten teks --}}
    <ul class="nav nav-tabs mb-2" role="tablist">
        <li class="nav-item">
            <a class="nav-link active py-1 px-2" data-toggle="tab" href="#faq-{{ $i }}-id" role="tab">🇮🇩 Bahasa Indonesia</a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-1 px-2" data-toggle="tab" href="#faq-{{ $i }}-en" role="tab">🇬🇧 English</a>
        </li>
    </ul>
    <div class="tab-content">
        @foreach (['id' => 'Bahasa Indonesia', 'en' => 'English'] as $langCode => $langLabel)
            <div class="tab-pane fade {{ $langCode === 'id' ? 'show active' : '' }}" id="faq-{{ $i }}-{{ $langCode }}" role="tabpanel">
                <div class="form-group">
                    <label>Pertanyaan</label>
                    <input type="text" name="faqs[{{ $i }}][translations][{{ $langCode }}][Pertanyaan]" class="form-control form-control-sm"
                        value="{{ old('faqs.'.$i.'.translations.'.$langCode.'.Pertanyaan', $tv($item, $langCode, 'Judul')) }}"
                        placeholder="Pertanyaan ({{ $langLabel }})...">
                </div>
                <div class="form-group mb-0">
                    <label>Jawaban</label>
                    <textarea name="faqs[{{ $i }}][translations][{{ $langCode }}][Jawaban]" class="form-control form-control-sm" rows="3"
                        placeholder="Jawaban ({{ $langLabel }})...">{{ old('faqs.'.$i.'.translations.'.$langCode.'.Jawaban', $tv($item, $langCode, 'Deskripsi')) }}</textarea>
                </div>
            </div>
        @endforeach
    </div>
</div>

@php
    $pickerVal = trim((string) ($value ?? ''));
    $isFa = \App\Support\IconHelper::isFontAwesome($pickerVal);
    $isLegacyImg = $pickerVal !== '' && !$isFa;
    $isSm = ($size ?? '') === 'sm';
@endphp
<div class="input-group {{ $isSm ? 'input-group-sm' : '' }} fa-icon-picker-group"
    data-storage-base="{{ asset('storage') }}/">
    <div class="input-group-prepend">
        <span class="input-group-text fa-icon-picker-preview" title="Preview Icon">
            @if ($isFa)
                <i class="{{ $pickerVal }}"></i>
            @elseif ($isLegacyImg)
                <img src="{{ asset('storage/' . $pickerVal) }}" alt="Icon">
            @else
                <i class="fa-regular fa-face-smile text-muted fa-icon-picker-placeholder"></i>
            @endif
        </span>
    </div>
    <input type="text"
        @if (!empty($id)) id="{{ $id }}" @endif
        name="{{ $name }}"
        value="{{ $pickerVal }}"
        placeholder="{{ $placeholder ?? 'fa-solid fa-icons' }}"
        autocomplete="off"
        class="form-control {{ $isSm ? 'form-control-sm' : '' }} fa-icon-picker-input {{ !empty($invalid) ? 'is-invalid' : '' }}"
        @if (!empty($required)) required @endif>
    <div class="input-group-append">
        @if ($showClear ?? true)
            <button type="button"
                class="btn btn-outline-secondary {{ $isSm ? 'btn-sm' : '' }} fa-icon-picker-clear"
                title="Hapus icon"
                style="{{ $pickerVal === '' ? 'display:none;' : '' }}">
                <i class="fa-solid fa-xmark"></i>
            </button>
        @endif
        <button type="button"
            class="btn btn-outline-secondary {{ $isSm ? 'btn-sm' : '' }} fa-icon-picker-toggle"
            title="Pilih icon">
            <i class="fa-solid fa-chevron-down"></i>
        </button>
    </div>
</div>

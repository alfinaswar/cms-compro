@php
    $idTrans = $menu->translations->firstWhere('Locale', 'id');
    $enTrans = $menu->translations->firstWhere('Locale', 'en');
    $namaId = $idTrans ? $idTrans->NamaMenu : $menu->NamaMenu;
    $namaEn = $enTrans ? $enTrans->NamaMenu : '';
    $hasChildren = $menu->children->count() > 0;
    $indentClass = $level > 0 ? 'ml-' . $level * 4 : '';
@endphp

<div class="menu-item-row {{ $indentClass }}" data-id="{{ $menu->id }}">
    <div class="menu-drag-handle">
        <i class="fa fa-grip-vertical"></i>
    </div>

    <div class="menu-icon">
        @if ($menu->Icon)
            <i class="{{ $menu->Icon }}"></i>
        @else
            <i class="fa fa-circle" style="font-size:8px; color:#adb5bd;"></i>
        @endif
    </div>

    <div class="menu-content">
        <div class="menu-title">
            {{ $namaId }}
            @if ($namaEn)
                <span class="text-muted font-weight-normal">/ {{ $namaEn }}</span>
            @endif
            @if ($hasChildren)
                <span class="badge badge-info badge-sm menu-badges">Parent ({{ $menu->children->count() }} Sub)</span>
            @endif
            @if ($menu->TampilkanDiHeader && $menu->TampilkanDiFooter)
                <span class="badge badge-primary badge-sm menu-badges">Header</span>
                <span class="badge badge-warning badge-sm menu-badges">Footer</span>
            @elseif($menu->TampilkanDiHeader)
                <span class="badge badge-primary badge-sm menu-badges">Header</span>
            @elseif($menu->TampilkanDiFooter)
                <span class="badge badge-warning badge-sm menu-badges">Footer</span>
            @endif
        </div>
        @if ($namaEn)
            <div class="menu-subtitle">{{ $namaEn }}</div>
        @endif
    </div>

    <div class="menu-actions">
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-info btn-edit" data-id="{{ $menu->id }}" title="Edit">
                <i class="fa fa-edit"></i>
            </button>
            <button type="button" class="btn btn-danger btn-delete" data-id="{{ $menu->id }}"
                data-nama="{{ $namaId }}" title="Hapus">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </div>
</div>

<!-- Render children recursively -->
@if ($hasChildren)
    <div class="submenu" style="display:none;">
        @foreach ($menu->children as $child)
            @include('pages.admin.menu._menu_item', ['menu' => $child, 'level' => $level + 1])
        @endforeach
    </div>
@endif

<style>
    .fa-icon-picker-preview {
        min-width: 42px;
        justify-content: center;
        background-color: #f8fafc;
    }

    .input-group-sm .fa-icon-picker-preview {
        min-width: 34px;
    }

    .fa-icon-picker-preview i {
        font-size: 1rem;
        color: #1e293b;
    }

    .input-group-sm .fa-icon-picker-preview i {
        font-size: 0.875rem;
    }

    .fa-icon-picker-preview i.fa-icon-picker-placeholder {
        opacity: 0.45;
    }

    .fa-icon-picker-preview img {
        width: 20px;
        height: 20px;
        object-fit: contain;
    }

    .input-group-sm .fa-icon-picker-preview img {
        width: 16px;
        height: 16px;
    }

    .fa-icon-picker-popover {
        position: fixed;
        z-index: 1060;
        width: 310px;
        max-width: calc(100vw - 24px);
        background: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.16);
        padding: 10px;
        display: none;
    }

    .fa-icon-picker-popover.is-open {
        display: block;
    }

    .fa-icon-picker-search {
        margin-bottom: 8px;
    }

    .fa-icon-picker-grid {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 6px;
        max-height: 230px;
        overflow-y: auto;
        padding: 2px;
    }

    .fa-icon-picker-item {
        height: 40px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        background: #f8fafc;
        color: #334155;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.12s ease;
    }

    .fa-icon-picker-item:hover {
        background: #e0f2fe;
        border-color: #38bdf8;
        color: #0369a1;
        transform: translateY(-1px);
    }

    .fa-icon-picker-item.active {
        background: #0284c7;
        border-color: #0284c7;
        color: #ffffff;
    }

    .fa-icon-picker-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 16px 8px;
        color: #64748b;
        font-size: 12px;
    }

    .fa-icon-picker-footer {
        margin-top: 8px;
        padding-top: 6px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 11px;
        color: #64748b;
    }
</style>
<script src="{{ asset('assets/js/icon-picker.js') }}"></script>

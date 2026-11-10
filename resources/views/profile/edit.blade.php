@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            .profile-page {
                --pf-surface: #ffffff;
                --pf-subtle: #f8fafc;
                --pf-border: #e2e8f0;
                --pf-border-strong: #cbd5e1;
                --pf-ink: #0f172a;
                --pf-ink-soft: #475569;
                --pf-muted: #64748b;
                --pf-accent: #2563eb;
                --pf-accent-hover: #1d4ed8;
                --pf-accent-tint: #eff6ff;
                padding-bottom: 2rem;
            }

            .profile-header-bar {
                background: var(--pf-surface);
                border: 1px solid var(--pf-border);
                border-radius: 10px;
                padding: 18px 24px;
                margin-bottom: 20px;
            }

            .profile-header-title {
                font-size: 1.35rem;
                font-weight: 700;
                color: var(--pf-ink);
                letter-spacing: -0.02em;
                margin: 0;
            }

            .profile-header-desc {
                font-size: 0.875rem;
                color: var(--pf-ink-soft);
                margin: 4px 0 0;
            }

            .profile-breadcrumb {
                background: transparent;
                padding: 0;
                margin: 0;
                font-size: 0.85rem;
            }

            .profile-alert-success {
                background: #f0fdf4;
                border: 1px solid #bbf7d0;
                color: #166534;
                border-radius: 10px;
                padding: 12px 16px;
                margin-bottom: 20px;
            }

            .profile-panel {
                background: var(--pf-surface);
                border: 1px solid var(--pf-border);
                border-radius: 12px;
                box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
                overflow: hidden;
            }

            .profile-identity-top {
                padding: 24px;
                border-bottom: 1px solid var(--pf-border);
            }

            .profile-avatar-badge {
                width: 56px;
                height: 56px;
                border-radius: 12px;
                background: #1e40af;
                color: #ffffff;
                font-size: 1.25rem;
                font-weight: 700;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                letter-spacing: 0.03em;
                flex-shrink: 0;
            }

            .profile-identity-name {
                font-size: 1.05rem;
                font-weight: 700;
                color: var(--pf-ink);
                margin: 0;
                word-break: break-word;
            }

            .profile-identity-email {
                font-size: 0.85rem;
                color: var(--pf-ink-soft);
                margin: 2px 0 0;
                word-break: break-all;
            }

            .profile-role-pill {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: var(--pf-accent-tint);
                color: #1e40af;
                border: 1px solid #bfdbfe;
                border-radius: 999px;
                padding: 3px 10px;
                font-size: 0.75rem;
                font-weight: 600;
            }

            .profile-preview-wrap {
                padding: 20px 24px 24px;
                background: var(--pf-subtle);
            }

            .profile-preview-heading {
                font-size: 0.8125rem;
                font-weight: 700;
                color: var(--pf-ink);
                margin-bottom: 10px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .author-box-preview {
                background: var(--pf-surface);
                border: 1px solid var(--pf-border);
                border-radius: 10px;
                padding: 16px;
                display: flex;
                align-items: flex-start;
                gap: 12px;
            }

            .author-box-preview-avatar {
                width: 44px;
                height: 44px;
                border-radius: 50%;
                background: #0284c7;
                color: #ffffff;
                font-size: 0.9rem;
                font-weight: 700;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .author-box-preview-text {
                font-size: 0.84rem;
                line-height: 1.55;
                color: #334155;
                margin: 0;
                white-space: pre-line;
                word-break: break-word;
            }

            .profile-form-section {
                padding: 24px 28px;
            }

            .profile-form-section + .profile-form-section {
                border-top: 1px solid var(--pf-border);
            }

            .profile-section-head {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                margin-bottom: 20px;
            }

            .profile-section-icon {
                width: 36px;
                height: 36px;
                border-radius: 8px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 0.95rem;
                flex-shrink: 0;
            }

            .profile-section-icon.is-blue {
                background: #eff6ff;
                color: #2563eb;
            }

            .profile-section-icon.is-amber {
                background: #fffbeb;
                color: #b45309;
            }

            .profile-section-title {
                font-size: 1rem;
                font-weight: 700;
                color: var(--pf-ink);
                margin: 0;
            }

            .profile-section-sub {
                font-size: 0.83rem;
                color: var(--pf-ink-soft);
                margin: 2px 0 0;
            }

            .profile-label {
                font-size: 0.85rem;
                font-weight: 600;
                color: #1e293b;
                margin-bottom: 6px;
            }

            .profile-control {
                border: 1px solid var(--pf-border-strong);
                border-radius: 8px;
                padding: 0.55rem 0.85rem;
                font-size: 0.9rem;
                color: var(--pf-ink);
                background-color: #ffffff;
                transition: border-color 150ms ease, box-shadow 150ms ease;
            }

            .profile-control::placeholder {
                color: #64748b;
                opacity: 1;
            }

            .profile-control:focus {
                border-color: var(--pf-accent);
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.14);
                outline: none;
            }

            .profile-control.is-invalid {
                border-color: #dc2626;
            }

            .profile-control.is-invalid:focus {
                box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.14);
            }

            .profile-input-group {
                position: relative;
            }

            .profile-input-group .profile-control {
                padding-right: 2.6rem;
            }

            .profile-eye-btn {
                position: absolute;
                top: 50%;
                right: 8px;
                transform: translateY(-50%);
                border: none;
                background: transparent;
                color: #475569;
                width: 30px;
                height: 30px;
                border-radius: 6px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: background-color 150ms ease, color 150ms ease;
            }

            .profile-eye-btn:hover {
                background: #f1f5f9;
                color: var(--pf-ink);
            }

            .profile-eye-btn:focus {
                outline: none;
                box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.25);
            }

            .profile-bio-meta {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
                margin-top: 8px;
                font-size: 0.8rem;
                color: var(--pf-ink-soft);
                flex-wrap: wrap;
            }

            .profile-reset-bio-btn {
                border: none;
                background: transparent;
                padding: 0;
                font-size: 0.8rem;
                font-weight: 600;
                color: var(--pf-accent);
                cursor: pointer;
            }

            .profile-reset-bio-btn:hover {
                color: var(--pf-accent-hover);
                text-decoration: underline;
            }

            .pw-checklist {
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
                margin-top: 12px;
            }

            .pw-chip {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                font-size: 0.76rem;
                font-weight: 500;
                padding: 4px 10px;
                border-radius: 999px;
                background: #f1f5f9;
                color: #475569;
                border: 1px solid #e2e8f0;
                transition: background-color 150ms ease, color 150ms ease, border-color 150ms ease;
            }

            .pw-chip.is-met {
                background: #f0fdf4;
                color: #166534;
                border-color: #bbf7d0;
            }

            .pw-chip.is-unmet {
                background: #fef2f2;
                color: #991b1b;
                border-color: #fecaca;
            }

            .profile-form-footer {
                background: var(--pf-subtle);
                border-top: 1px solid var(--pf-border);
                padding: 16px 28px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
                flex-wrap: wrap;
            }

            .profile-footer-note {
                font-size: 0.82rem;
                color: var(--pf-ink-soft);
                margin: 0;
            }

            .profile-footer-note.is-warning {
                color: #92400e;
                font-weight: 600;
            }

            .profile-btn-save {
                background: var(--pf-accent);
                border: 1px solid var(--pf-accent);
                color: #ffffff;
                font-weight: 600;
                font-size: 0.88rem;
                padding: 0.55rem 1.25rem;
                border-radius: 8px;
                transition: background-color 150ms ease, border-color 150ms ease, transform 150ms ease;
            }

            .profile-btn-save:hover,
            .profile-btn-save:focus {
                background: var(--pf-accent-hover);
                border-color: var(--pf-accent-hover);
                color: #ffffff;
            }

            .profile-btn-cancel {
                background: #ffffff;
                border: 1px solid var(--pf-border-strong);
                color: #334155;
                font-weight: 600;
                font-size: 0.88rem;
                padding: 0.55rem 1rem;
                border-radius: 8px;
                transition: background-color 150ms ease, border-color 150ms ease;
            }

            .profile-btn-cancel:hover {
                background: #f1f5f9;
                color: var(--pf-ink);
                text-decoration: none;
            }

            @media (min-width: 992px) {
                .profile-sticky-col {
                    position: sticky;
                    top: 1.25rem;
                }
            }
        </style>
    @endpush

    @php
        $initials = collect(preg_split('/\s+/', trim($user->name ?: 'A')))
            ->filter()
            ->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');
        $initials = $initials !== '' ? $initials : 'A';
        $roles = method_exists($user, 'getRoleNames') ? $user->getRoleNames() : collect();
        $initialBio = old('bio_penulis', $user->bio_penulis);
        $previewBio = filled($initialBio) ? $initialBio : \App\Models\User::DEFAULT_AUTHOR_BIO;
    @endphp

    <div class="profile-page pt-3">
        <div class="container-fluid">
            <div class="profile-header-bar d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                <div>
                    <h1 class="profile-header-title">Edit Profile</h1>
                    <p class="profile-header-desc">Kelola data akun, teks informasi penulis pada halaman detail berita, dan kata sandi Anda.</p>
                </div>
                <ol class="breadcrumb profile-breadcrumb mt-2 mt-md-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Edit Profile</li>
                </ol>
            </div>

            @if (session('success'))
                <div class="alert profile-alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form id="formProfileEdit" action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row align-items-start">
                    {{-- Kolom Kiri: Identitas & Live Preview Author Box --}}
                    <div class="col-lg-4 mb-4 mb-lg-0 profile-sticky-col">
                        <div class="profile-panel">
                            <div class="profile-identity-top">
                                <div class="d-flex align-items-center" style="gap: 14px;">
                                    <div class="profile-avatar-badge" id="profileInitialsBadge">{{ $initials }}</div>
                                    <div class="min-w-0">
                                        <p class="profile-identity-name" id="previewAccountName">{{ $user->name }}</p>
                                        <p class="profile-identity-email" id="previewAccountEmail">{{ $user->email }}</p>
                                    </div>
                                </div>

                                <div class="mt-3 d-flex flex-wrap" style="gap: 6px;">
                                    @forelse ($roles as $roleName)
                                        <span class="profile-role-pill">
                                            <i class="fas fa-shield-alt"></i> {{ $roleName }}
                                        </span>
                                    @empty
                                        <span class="profile-role-pill">
                                            <i class="fas fa-user"></i> Pengguna Terdaftar
                                        </span>
                                    @endforelse
                                </div>
                            </div>

                            <div class="profile-preview-wrap">
                                <div class="profile-preview-heading">
                                    <span>Pratinjau Kotak Penulis</span>
                                    <span class="badge badge-light border text-dark font-weight-semibold">News Detail</span>
                                </div>
                                <div class="author-box-preview">
                                    <div class="author-box-preview-avatar" id="previewAuthorAvatar">{{ $initials }}</div>
                                    <div class="flex-grow-1 min-w-0">
                                        <p class="font-weight-bold mb-1" id="previewAuthorName" style="font-size: 0.92rem; color: #0f172a;">{{ old('name', $user->name) }}</p>
                                        <p class="author-box-preview-text" id="previewAuthorBio">{{ $previewBio }}</p>
                                    </div>
                                </div>
                                <small class="d-block mt-2" style="color: #475569; font-size: 0.78rem;">
                                    Pratinjau langsung tampilan kotak informasi penulis di bawah artikel berita.
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Form Profil, Bio Penulis, dan Keamanan Password --}}
                    <div class="col-lg-8">
                        <div class="profile-panel">
                            <div class="profile-form-section">
                                <div class="profile-section-head">
                                    <span class="profile-section-icon is-blue">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                    <div>
                                        <h2 class="profile-section-title">Informasi Profil &amp; Penulis</h2>
                                        <p class="profile-section-sub">Perubahan nama, email, dan deskripsi penulis tersimpan langsung tanpa perlu login ulang.</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name" class="profile-label">Nama Lengkap</label>
                                            <input type="text" name="name" id="name"
                                                class="form-control profile-control @error('name') is-invalid @enderror"
                                                placeholder="Masukkan nama lengkap"
                                                value="{{ old('name', $user->name) }}" required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="email" class="profile-label">Alamat Email</label>
                                            <input type="email" name="email" id="email"
                                                class="form-control profile-control @error('email') is-invalid @enderror"
                                                placeholder="Masukkan alamat email"
                                                value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label for="bio_penulis" class="profile-label">Informasi Penulis (News Detail)</label>
                                    <textarea name="bio_penulis" id="bio_penulis" rows="4" maxlength="1000"
                                        class="form-control profile-control @error('bio_penulis') is-invalid @enderror"
                                        placeholder="{{ \App\Models\User::DEFAULT_AUTHOR_BIO }}">{{ old('bio_penulis', $user->bio_penulis) }}</textarea>
                                    @error('bio_penulis')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="profile-bio-meta">
                                        <span>Kosongkan jika ingin kembali menampilkan teks bawaan sistem.</span>
                                        <div class="d-flex align-items-center" style="gap: 12px;">
                                            <button type="button" class="profile-reset-bio-btn" id="btnRestoreDefaultBio">
                                                Pakai teks bawaan
                                            </button>
                                            <span id="bioCharCount" style="font-variant-numeric: tabular-nums;">{{ mb_strlen((string) $initialBio) }}/1000</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="profile-form-section">
                                <div class="profile-section-head">
                                    <span class="profile-section-icon is-amber">
                                        <i class="fas fa-key"></i>
                                    </span>
                                    <div>
                                        <h2 class="profile-section-title">Ganti Password <span class="font-weight-normal" style="color: #64748b;">(Opsional)</span></h2>
                                        <p class="profile-section-sub">Biarkan seluruh kolom password kosong jika tidak ingin mengganti kata sandi.</p>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="current_password" class="profile-label">Password Saat Ini</label>
                                    <div class="profile-input-group">
                                        <input type="password" name="current_password" id="current_password"
                                            class="form-control profile-control @error('current_password') is-invalid @enderror"
                                            placeholder="Masukkan password saat ini"
                                            autocomplete="current-password">
                                        <button type="button" class="profile-eye-btn" data-toggle-target="current_password"
                                            aria-label="Tampilkan atau sembunyikan password saat ini">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3 mb-md-0">
                                            <label for="password" class="profile-label">Password Baru</label>
                                            <div class="profile-input-group">
                                                <input type="password" name="password" id="password"
                                                    class="form-control profile-control @error('password') is-invalid @enderror"
                                                    placeholder="Minimal 12 karakter"
                                                    minlength="12"
                                                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+\[\]{};:'&quot;,.&lt;&gt;/?\\|`~]).{12,}$"
                                                    title="Minimal 12 karakter, kombinasi huruf besar/kecil, angka, dan simbol."
                                                    autocomplete="new-password">
                                                <button type="button" class="profile-eye-btn" data-toggle-target="password"
                                                    aria-label="Tampilkan atau sembunyikan password baru">
                                                    <i class="far fa-eye"></i>
                                                </button>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-0">
                                            <label for="password_confirmation" class="profile-label">Konfirmasi Password Baru</label>
                                            <div class="profile-input-group">
                                                <input type="password" name="password_confirmation" id="password_confirmation"
                                                    class="form-control profile-control @error('password_confirmation') is-invalid @enderror"
                                                    placeholder="Ulangi password baru"
                                                    minlength="12"
                                                    autocomplete="new-password">
                                                <button type="button" class="profile-eye-btn" data-toggle-target="password_confirmation"
                                                    aria-label="Tampilkan atau sembunyikan konfirmasi password baru">
                                                    <i class="far fa-eye"></i>
                                                </button>
                                            </div>
                                            @error('password_confirmation')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="pw-checklist" id="pwChecklist" aria-live="polite">
                                    <span class="pw-chip" data-rule="length"><i class="fas fa-circle" style="font-size: 6px;"></i> 12+ karakter</span>
                                    <span class="pw-chip" data-rule="case"><i class="fas fa-circle" style="font-size: 6px;"></i> Huruf besar &amp; kecil</span>
                                    <span class="pw-chip" data-rule="digit"><i class="fas fa-circle" style="font-size: 6px;"></i> Angka</span>
                                    <span class="pw-chip" data-rule="symbol"><i class="fas fa-circle" style="font-size: 6px;"></i> Simbol</span>
                                    <span class="pw-chip" data-rule="match"><i class="fas fa-circle" style="font-size: 6px;"></i> Konfirmasi cocok</span>
                                </div>
                            </div>

                            <div class="profile-form-footer">
                                <p class="profile-footer-note" id="profileSaveHint">
                                    <i class="fas fa-info-circle mr-1"></i> Pastikan data profil dan teks penulis sudah sesuai sebelum menyimpan.
                                </p>
                                <div class="d-flex align-items-center" style="gap: 10px;">
                                    <a href="{{ route('home') }}" class="profile-btn-cancel">Kembali</a>
                                    <button type="submit" class="profile-btn-save" id="btnSaveProfile">
                                        <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            var defaultBio = @json(\App\Models\User::DEFAULT_AUTHOR_BIO);
            var $nameInput = $('#name');
            var $emailInput = $('#email');
            var $bioInput = $('#bio_penulis');
            var $pwInput = $('#password');
            var $pwConfirmInput = $('#password_confirmation');
            var $saveHint = $('#profileSaveHint');

            function computeInitials(name) {
                var parts = $.trim(name || '').split(/\s+/).filter(Boolean);
                if (!parts.length) return 'A';
                return parts.slice(0, 2).map(function (p) {
                    return p.charAt(0).toUpperCase();
                }).join('');
            }

            function syncPreview() {
                var nameVal = $.trim($nameInput.val()) || 'Admin';
                var emailVal = $.trim($emailInput.val()) || '-';
                var bioVal = $bioInput.val() || '';
                var initials = computeInitials(nameVal);

                $('#profileInitialsBadge, #previewAuthorAvatar').text(initials);
                $('#previewAccountName, #previewAuthorName').text(nameVal);
                $('#previewAccountEmail').text(emailVal);
                $('#previewAuthorBio').text($.trim(bioVal) !== '' ? bioVal : defaultBio);
                $('#bioCharCount').text(bioVal.length + '/1000');
            }

            function syncPasswordChecklist() {
                var pw = $pwInput.val() || '';
                var confirmPw = $pwConfirmInput.val() || '';
                var active = pw.length > 0 || confirmPw.length > 0;

                var checks = {
                    length: pw.length >= 12,
                    case: /[a-z]/.test(pw) && /[A-Z]/.test(pw),
                    digit: /\d/.test(pw),
                    symbol: /[!@#$%^&*()\-_=+\[\]{};:'",.<>\/?\\|`~]/.test(pw),
                    match: pw.length > 0 && pw === confirmPw
                };

                $('#pwChecklist .pw-chip').each(function () {
                    var $chip = $(this);
                    var rule = $chip.data('rule');
                    var $icon = $chip.find('i');
                    $chip.removeClass('is-met is-unmet');

                    if (!active) {
                        $icon.attr('class', 'fas fa-circle').css('font-size', '6px');
                        return;
                    }

                    if (checks[rule]) {
                        $chip.addClass('is-met');
                        $icon.attr('class', 'fas fa-check').css('font-size', '10px');
                    } else {
                        $chip.addClass('is-unmet');
                        $icon.attr('class', 'fas fa-times').css('font-size', '10px');
                    }
                });

                if (active) {
                    $saveHint
                        .addClass('is-warning')
                        .html('<i class="fas fa-exclamation-triangle mr-1"></i> Mengganti password akan mengeluarkan sesi ini agar Anda login ulang.');
                } else {
                    $saveHint
                        .removeClass('is-warning')
                        .html('<i class="fas fa-info-circle mr-1"></i> Pastikan data profil dan teks penulis sudah sesuai sebelum menyimpan.');
                }
            }

            $nameInput.on('input', syncPreview);
            $emailInput.on('input', syncPreview);
            $bioInput.on('input', syncPreview);

            $('#btnRestoreDefaultBio').on('click', function () {
                $bioInput.val(defaultBio).trigger('input').focus();
            });

            $pwInput.on('input', syncPasswordChecklist);
            $pwConfirmInput.on('input', syncPasswordChecklist);

            $('.profile-eye-btn').on('click', function () {
                var targetId = $(this).data('toggle-target');
                var $input = $('#' + targetId);
                var $icon = $(this).find('i');

                if ($input.attr('type') === 'password') {
                    $input.attr('type', 'text');
                    $icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $input.attr('type', 'password');
                    $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            $('#formProfileEdit').on('submit', function () {
                var $btn = $('#btnSaveProfile');
                $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menyimpan...');
            });

            syncPreview();
            syncPasswordChecklist();
        });
    </script>
@endpush

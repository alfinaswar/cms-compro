@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            :root {
                --primary-blue: #3b82f6;
                --bg-soft: #f8fafc;
                --border-soft: #e2e8f0;
            }

            .edit-card {
                background: white;
                border-radius: 16px;
                border: 1px solid var(--border-soft);
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
                overflow: hidden;
            }

            .edit-header {
                padding: 24px;
                border-bottom: 1px solid var(--border-soft);
            }

            .edit-title {
                font-size: 18px;
                font-weight: 700;
                color: #1e293b;
                margin: 0;
            }

            .email-inputs {
                padding: 24px;
            }

            .email-input-group {
                display: flex;
                gap: 12px;
                margin-bottom: 16px;
                align-items: center;
            }

            .email-input-wrapper {
                flex: 1;
                position: relative;
            }

            .email-input-icon {
                position: absolute;
                left: 16px;
                top: 50%;
                transform: translateY(-50%);
                color: #94a3b8;
            }

            .form-control-modern {
                width: 100%;
                padding: 12px 16px 12px 48px;
                border: 2px solid var(--border-soft);
                border-radius: 10px;
                font-size: 14px;
                transition: all 0.2s;
            }

            .form-control-modern:focus {
                outline: none;
                border-color: var(--primary-blue);
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }

            .btn-remove {
                width: 40px;
                height: 40px;
                border-radius: 8px;
                border: 1px solid var(--border-soft);
                background: white;
                color: #ef4444;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.2s;
            }

            .btn-remove:hover {
                background: #fee2e2;
                border-color: #fecaca;
            }

            .btn-add-new {
                width: 100%;
                padding: 12px;
                border: 2px dashed var(--border-soft);
                background: var(--bg-soft);
                border-radius: 10px;
                color: var(--primary-blue);
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .btn-add-new:hover {
                border-color: var(--primary-blue);
                background: #eff6ff;
            }

            .edit-footer {
                padding: 20px 24px;
                border-top: 1px solid var(--border-soft);
                display: flex;
                justify-content: flex-end;
                gap: 12px;
            }

            .btn-modern {
                padding: 12px 24px;
                border-radius: 10px;
                font-weight: 600;
                font-size: 14px;
                border: none;
                cursor: pointer;
                transition: all 0.2s;
                display: inline-flex;
                align-items: center;
                gap: 8px;
            }

            .btn-secondary {
                background: white;
                color: #64748b;
                border: 1px solid var(--border-soft);
            }

            .btn-secondary:hover {
                background: var(--bg-soft);
                color: #475569;
            }

            .btn-primary {
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                color: white;
            }

            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
                color: white;
            }

            .helper-text {
                font-size: 13px;
                color: #64748b;
                margin-top: 4px;
            }
        </style>
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <form id="emailForm">
                    @csrf
                    <div class="edit-card">
                        <div class="edit-header">
                            <h2 class="edit-title">Edit Email Penerima Notifikasi</h2>
                        </div>

                        <div class="email-inputs">
                            <div id="emailContainer">
                                @foreach ($emails as $index => $email)
                                    <div class="email-input-group" data-index="{{ $index }}">
                                        <div class="email-input-wrapper">
                                            <i class="fas fa-envelope email-input-icon"></i>
                                            <input type="email" name="emails[{{ $index }}][Email]"
                                                class="form-control-modern" placeholder="nama@domain.com"
                                                value="{{ $email->Email }}" required>
                                            <input type="hidden" name="emails[{{ $index }}][id]"
                                                value="{{ $email->id }}">
                                        </div>
                                        <button type="button" class="btn-remove" onclick="removeEmail(this)"
                                            title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn-add-new" onclick="addEmailField()">
                                <i class="fas fa-plus"></i> Tambah Email Baru
                            </button>
                            <p class="helper-text text-center mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Email akan menerima notifikasi dari formulir kontak website
                            </p>
                        </div>

                        <div class="edit-footer">
                            <a href="{{ route('notification-email.index') }}" class="btn-modern btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                            <button type="submit" class="btn-modern btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let emailIndex = {{ $emails->count() }};

            function addEmailField() {
                const container = document.getElementById('emailContainer');
                const div = document.createElement('div');
                div.className = 'email-input-group';
                div.setAttribute('data-index', emailIndex);
                div.innerHTML = `
        <div class="email-input-wrapper">
            <i class="fas fa-envelope email-input-icon"></i>
            <input type="email"
                   name="emails[${emailIndex}][Email]"
                   class="form-control-modern"
                   placeholder="nama@domain.com"
                   required>
        </div>
        <button type="button" class="btn-remove" onclick="removeEmail(this)" title="Hapus">
            <i class="fas fa-trash-alt"></i>
        </button>
    `;
                container.appendChild(div);
                emailIndex++;
            }

            function removeEmail(btn) {
                const group = btn.closest('.email-input-group');
                group.remove();
            }

            document.getElementById('emailForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const emails = [];

                // Collect all email inputs
                formData.forEach((value, key) => {
                    const match = key.match(/emails\[(\d+)\]\[(\w+)\]/);
                    if (match) {
                        const index = match[1];
                        const field = match[2];
                        if (!emails[index]) {
                            emails[index] = {};
                        }
                        emails[index][field] = value;
                    }
                });

                // Filter out empty entries
                const validEmails = emails.filter(e => e && e.Email);

                Swal.fire({
                    title: 'Menyimpan...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '{{ route('notification-email.update') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        emails: validEmails
                    },
                    success: function(res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '{{ route('notification-email.index') }}';
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: xhr.responseJSON?.message || 'Terjadi kesalahan'
                        });
                    }
                });
            });
        </script>
    @endpush
@endsection

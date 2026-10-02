@extends('layouts.app')

@section('content')
    @push('styles')
        <style>
            :root {
                --primary-blue: #3b82f6;
                --bg-soft: #f8fafc;
                --border-soft: #e2e8f0;
            }

            .notification-card {
                background: white;
                border-radius: 16px;
                border: 1px solid var(--border-soft);
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
                overflow: hidden;
            }

            .notification-header {
                padding: 24px;
                border-bottom: 1px solid var(--border-soft);
            }

            .notification-title {
                font-size: 18px;
                font-weight: 700;
                color: #1e293b;
                margin: 0 0 8px 0;
            }

            .notification-desc {
                font-size: 14px;
                color: #64748b;
                margin: 0;
            }

            .badge-count {
                background: #eff6ff;
                color: var(--primary-blue);
                padding: 6px 14px;
                border-radius: 20px;
                font-size: 13px;
                font-weight: 600;
            }

            .email-list {
                padding: 24px;
            }

            .email-item {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 16px;
                background: var(--bg-soft);
                border: 1px solid var(--border-soft);
                border-radius: 10px;
                margin-bottom: 12px;
                transition: all 0.2s;
            }

            .email-item:hover {
                border-color: #cbd5e1;
            }

            .email-icon {
                width: 40px;
                height: 40px;
                background: white;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #94a3b8;
                font-size: 18px;
            }

            .email-text {
                flex: 1;
                font-size: 14px;
                color: #334155;
                font-weight: 500;
            }

            .btn-icon {
                width: 36px;
                height: 36px;
                border-radius: 8px;
                border: 1px solid var(--border-soft);
                background: white;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.2s;
                color: #64748b;
            }

            .btn-icon:hover {
                background: #fee2e2;
                color: #ef4444;
                border-color: #fecaca;
            }

            .btn-add {
                width: 36px;
                height: 36px;
                border-radius: 8px;
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                color: white;
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.2s;
                font-size: 20px;
            }

            .btn-add:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
            }

            .notification-footer {
                padding: 20px 24px;
                border-top: 1px solid var(--border-soft);
                display: flex;
                justify-content: flex-end;
                gap: 12px;
            }

            .btn-modern {
                padding: 10px 20px;
                border-radius: 10px;
                font-weight: 600;
                font-size: 14px;
                border: none;
                cursor: pointer;
                transition: all 0.2s;
                text-decoration: none;
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
        </style>
    @endpush

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="notification-card">
                    <div class="notification-header d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="notification-title">Daftar Email Penerima Notifikasi</h2>
                            <p class="notification-desc">
                                Setiap formulir kontak yang dikirim oleh pengunjung web akan diteruskan secara otomatis ke
                                alamat di bawah ini.
                            </p>
                        </div>
                        <span class="badge-count">{{ $count }} Alamat Terdaftar</span>
                    </div>

                    <div class="email-list">
                        @forelse($emails as $email)
                            <div class="email-item">
                                <div class="email-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="email-text">{{ $email->Email }}</div>
                                <button class="btn-icon" onclick="deleteEmail({{ $email->id }}, '{{ $email->Email }}')"
                                    title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3" style="opacity: 0.3;"></i>
                                <p>Belum ada email terdaftar</p>
                            </div>
                        @endforelse

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('notification-email.edit') }}" class="btn-add" title="Tambah Email">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    <div class="notification-footer">
                        <button class="btn-modern btn-secondary" onclick="window.history.back()">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                        <a href="{{ route('notification-email.edit') }}" class="btn-modern btn-primary">
                            <i class="fas fa-edit"></i> Ubah Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function deleteEmail(id, email) {
                Swal.fire({
                    title: 'Hapus Email?',
                    html: `Apakah Anda yakin ingin menghapus email <strong>${email}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    confirmButtonColor: '#ef4444'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ url('notification-email') }}/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: res.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    location.reload();
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
                    }
                });
            }
        </script>
    @endpush
@endsection

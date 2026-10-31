@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark">
                    <i class="fas fa-file-download text-primary mr-2"></i>Data Pengunduh Company Profile
                </h1>
                <p class="text-muted small mb-0 mt-1">
                    Daftar visitor yang mengisi form untuk mengunduh Company Profile dari halaman Tentang Kami.
                </p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('about-us.index') }}">Tentang Kami</a></li>
                    <li class="breadcrumb-item active">Data Pengunduh</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card card-outline card-primary shadow-sm">
            <div class="card-header bg-white d-flex flex-wrap align-items-center justify-content-between py-3">
                <div class="d-flex align-items-center mb-2 mb-md-0">
                    <h3 class="card-title font-weight-bold text-secondary mb-0">
                        <i class="fas fa-users mr-1.5 text-primary"></i> Total Data:
                        <span class="badge badge-primary px-2.5 py-1.5 ml-1">{{ $totalDownloads }}</span>
                    </h3>
                </div>

                <div class="card-tools d-flex flex-wrap align-items-center gap-2">
                    <form action="{{ route('about-us.downloads.index') }}" method="GET" class="mr-2 mb-2 mb-md-0">
                        <div class="input-group input-group-sm" style="width: 250px;">
                            <input type="text" name="q" class="form-control"
                                placeholder="Cari nama, email, kantor..." value="{{ request('q') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if (request('q'))
                                    <a href="{{ route('about-us.downloads.index') }}" class="btn btn-default" title="Reset">
                                        <i class="fas fa-times text-danger"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <a href="{{ route('about-us.downloads.export') }}" class="btn btn-sm btn-success mr-2 mb-2 mb-md-0">
                        <i class="fas fa-file-excel mr-1"></i> Ekspor CSV
                    </a>

                    <a href="{{ route('about-us.index') }}" class="btn btn-sm btn-secondary mb-2 mb-md-0">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Form Tentang Kami
                    </a>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 5%" class="text-center">#</th>
                                <th style="width: 15%">Waktu Unduh</th>
                                <th style="width: 20%">Nama Lengkap</th>
                                <th style="width: 20%">Email</th>
                                <th style="width: 18%">Perusahaan</th>
                                <th style="width: 14%">No. HP / WA</th>
                                <th style="width: 8%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($leads as $index => $lead)
                                <tr>
                                    <td class="text-center align-middle font-weight-bold text-muted">
                                        {{ $leads->firstItem() + $index }}
                                    </td>
                                    <td class="align-middle">
                                        <div class="font-weight-bold text-dark">
                                            {{ $lead->created_at ? $lead->created_at->format('d M Y') : '-' }}
                                        </div>
                                        <small class="text-muted">
                                            {{ $lead->created_at ? $lead->created_at->format('H:i') : '' }} WIB
                                        </small>
                                    </td>
                                    <td class="align-middle font-weight-bold text-dark">
                                        {{ $lead->Nama }}
                                    </td>
                                    <td class="align-middle">
                                        <a href="mailto:{{ $lead->Email }}" class="text-primary font-weight-500">
                                            <i class="far fa-envelope mr-1 text-muted"></i>{{ $lead->Email }}
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        @if (!empty($lead->Perusahaan))
                                            <span class="badge badge-light border px-2 py-1 text-dark font-weight-normal">
                                                <i class="far fa-building mr-1 text-secondary"></i>{{ $lead->Perusahaan }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if (!empty($lead->NoHp))
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->NoHp) }}" target="_blank" class="text-success font-weight-500">
                                                <i class="fab fa-whatsapp mr-1"></i>{{ $lead->NoHp }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-xs btn-outline-danger btn-delete-lead"
                                            data-url="{{ route('about-us.downloads.destroy', $lead->id) }}"
                                            data-name="{{ $lead->Nama }}" title="Hapus Data">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3 d-block opacity-50"></i>
                                        <span>Belum ada visitor yang mengunduh Company Profile.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($leads->hasPages())
                <div class="card-footer bg-white clearfix">
                    <div class="float-right">
                        {{ $leads->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('.btn-delete-lead').on('click', function () {
            const url = $(this).data('url');
            const name = $(this).data('name');

            Swal.fire({
                title: 'Hapus Data?',
                text: `Hapus catatan unduhan oleh "${name}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (res) {
                            Swal.fire('Terhapus!', res.message, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function () {
                            Swal.fire('Error!', 'Gagal menghapus data.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

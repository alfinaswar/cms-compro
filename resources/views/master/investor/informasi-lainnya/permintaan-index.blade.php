@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-envelope-open-text text-primary mr-2"></i>Permintaan Salinan Fisik Dokumen</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.investor.informasi-lainnya.index') }}">Informasi Lainnya</a></li>
                    <li class="breadcrumb-item active">Permintaan Dokumen</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">
                    <i class="fas fa-list mr-1"></i> Daftar Pemohon Laporan Tahunan / Prospektus Cetak
                </h3>
                <div class="card-tools">
                    <a href="{{ route('admin.investor.informasi-lainnya.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Informasi Lainnya
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Tanggal</th>
                                <th>Nama Pemohon</th>
                                <th>Institusi / Perusahaan</th>
                                <th>Kontak (Email / Telp)</th>
                                <th>Jenis Dokumen</th>
                                <th>Alamat Pengiriman</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 12%">Ubah Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permintaanList as $idx => $req)
                                @php
                                    $badge = 'badge-warning';
                                    if ($req->StatusPermintaan === 'Diproses') $badge = 'badge-info';
                                    elseif ($req->StatusPermintaan === 'Terkirim') $badge = 'badge-success';
                                    elseif ($req->StatusPermintaan === 'Ditolak') $badge = 'badge-danger';
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $idx + 1 }}</td>
                                    <td>{{ $req->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="font-weight-bold">{{ $req->Nama }}</td>
                                    <td>{{ $req->Institusi ?? '-' }}</td>
                                    <td>
                                        <a href="mailto:{{ $req->Email }}">{{ $req->Email }}</a><br>
                                        <small class="text-muted">{{ $req->Telepon }}</small>
                                    </td>
                                    <td class="font-weight-bold text-primary">{{ $req->JenisDokumen }}</td>
                                    <td class="small">{{ $req->AlamatPengiriman }}</td>
                                    <td class="text-center">
                                        <span class="badge {{ $badge }} px-2 py-1">{{ $req->StatusPermintaan }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <form action="{{ route('admin.investor.informasi-lainnya.permintaan-update-status', $req->id) }}" method="POST" class="d-inline mr-1">
                                                @csrf
                                                <select name="StatusPermintaan" class="form-control form-control-sm font-weight-bold" onchange="this.form.submit()">
                                                    <option value="Pending" {{ $req->StatusPermintaan === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="Diproses" {{ $req->StatusPermintaan === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                                    <option value="Terkirim" {{ $req->StatusPermintaan === 'Terkirim' ? 'selected' : '' }}>Terkirim</option>
                                                    <option value="Ditolak" {{ $req->StatusPermintaan === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                </select>
                                            </form>
                                            <button type="button" class="btn btn-xs btn-danger btn-delete-row"
                                                    data-url="{{ route('admin.investor.informasi-lainnya.destroy-permintaan', $req->id) }}"
                                                    data-nama="Permintaan oleh {{ $req->Nama }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">Belum ada permintaan dokumen fisik yang masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('.btn-delete-row').on('click', function () {
            const url = $(this).data('url');
            const nama = $(this).data('nama');

            Swal.fire({
                title: 'Hapus Data?',
                text: `Apakah Anda yakin ingin menghapus "${nama}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
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
                            Swal.fire('Terhapus!', res.message, 'success').then(() => location.reload());
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

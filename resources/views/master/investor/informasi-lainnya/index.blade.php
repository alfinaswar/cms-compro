@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-info-circle mr-2"></i>Kelola Informasi Lainnya &amp; Regulasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('jenis-laporan.index') }}">Investor</a></li>
                    <li class="breadcrumb-item active">Informasi Lainnya</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">

        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="infoLainnyaTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" id="lembaga-tab" data-toggle="pill" href="#tab-lembaga" role="tab">
                            <i class="fas fa-building-columns mr-1"></i> Lembaga Penunjang Pasar Modal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="keterbukaan-tab" data-toggle="pill" href="#tab-keterbukaan" role="tab">
                            <i class="fas fa-bullhorn mr-1"></i> Keterbukaan Informasi &amp; Pengumuman
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold text-primary" href="{{ route('admin.investor.informasi-lainnya.permintaan-index') }}">
                            <i class="fas fa-envelope-open-text mr-1"></i> Permintaan Salinan Fisik
                            @if(isset($permintaanCount) && $permintaanCount > 0)
                                <span class="badge badge-warning ml-1">{{ $permintaanCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="infoLainnyaTabContent">

                    <!-- ============================================ -->
                    <!-- TAB 1: LEMBAGA PENUNJANG PASAR MODAL -->
                    <!-- ============================================ -->
                    <div class="tab-pane fade show active" id="tab-lembaga" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="font-weight-bold text-secondary mb-0">Institusi &amp; Profesi Penunjang Pasar Modal</h5>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambahLembaga">
                                <i class="fas fa-plus mr-1"></i> Tambah Lembaga Penunjang
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th>Nama Institusi</th>
                                        <th>Kategori</th>
                                        <th>Afiliasi</th>
                                        <th>Website</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($lembagaList as $idx => $lem)
                                        <tr>
                                            <td class="text-center">{{ $idx + 1 }}</td>
                                            <td class="font-weight-bold">{{ $lem->NamaInstitusi }}</td>
                                            <td>
                                                <span class="badge badge-info">{{ $lem->Kategori }}</span>
                                            </td>
                                            <td class="small">{{ $lem->Afiliasi ?? '-' }}</td>
                                            <td>
                                                @if($lem->Website)
                                                    <a href="{{ $lem->Website }}" target="_blank" class="small text-primary">
                                                        <i class="fas fa-external-link-alt"></i> {{ $lem->Website }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge {{ $lem->Status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $lem->Status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-xs btn-warning mr-1 btn-edit-lembaga"
                                                        data-id="{{ $lem->id }}"
                                                        data-nama="{{ $lem->NamaInstitusi }}"
                                                        data-kategori="{{ $lem->Kategori }}"
                                                        data-afiliasi="{{ $lem->Afiliasi }}"
                                                        data-website="{{ $lem->Website }}"
                                                        data-pusat="{{ $lem->KantorPusat }}"
                                                        data-cabang="{{ $lem->Cabang }}"
                                                        data-layanan="{{ $lem->Layanan }}"
                                                        data-urutan="{{ $lem->Urutan }}"
                                                        data-status="{{ $lem->Status }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-danger btn-delete-row"
                                                        data-url="{{ route('admin.investor.informasi-lainnya.destroy-lembaga', $lem->id) }}"
                                                        data-nama="{{ $lem->NamaInstitusi }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-3">Belum ada data lembaga penunjang.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ============================================ -->
                    <!-- TAB 2: KETERBUKAAN INFORMASI & PENGUMUMAN -->
                    <!-- ============================================ -->
                    <div class="tab-pane fade" id="tab-keterbukaan" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="font-weight-bold text-secondary mb-0">Arsip Keterbukaan Informasi &amp; Fakta Material</h5>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambahKeterbukaan">
                                <i class="fas fa-plus mr-1"></i> Tambah Dokumen Keterbukaan
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 12%">Tanggal</th>
                                        <th>Judul Keterbukaan Informasi</th>
                                        <th>Kategori</th>
                                        <th class="text-center">File</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($keterbukaanList as $idx => $ket)
                                        <tr>
                                            <td class="text-center">{{ $idx + 1 }}</td>
                                            <td class="font-weight-bold">{{ $ket->TanggalPublikasi ? $ket->TanggalPublikasi->format('d/m/Y') : '-' }}</td>
                                            <td class="font-weight-bold">{{ $ket->Judul }}</td>
                                            <td>
                                                <span class="badge badge-primary">{{ $ket->Kategori }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($ket->PathFile)
                                                    <a href="{{ asset('storage/' . $ket->PathFile) }}" target="_blank" class="btn btn-xs btn-outline-danger">
                                                        <i class="fas fa-file-pdf"></i> Unduh
                                                    </a>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge {{ $ket->Status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $ket->Status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-xs btn-warning mr-1 btn-edit-keterbukaan"
                                                        data-id="{{ $ket->id }}"
                                                        data-judul="{{ $ket->Judul }}"
                                                        data-kategori="{{ $ket->Kategori }}"
                                                        data-tanggal="{{ $ket->TanggalPublikasi ? $ket->TanggalPublikasi->format('Y-m-d') : '' }}"
                                                        data-deskripsi="{{ $ket->Deskripsi }}"
                                                        data-urutan="{{ $ket->Urutan }}"
                                                        data-status="{{ $ket->Status }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-danger btn-delete-row"
                                                        data-url="{{ route('admin.investor.informasi-lainnya.destroy-keterbukaan', $ket->id) }}"
                                                        data-nama="{{ $ket->Judul }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-3">Belum ada dokumen keterbukaan informasi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>

<!-- MODAL TAMBAH LEMBAGA -->
<div class="modal fade" id="modalTambahLembaga" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.investor.informasi-lainnya.store-lembaga') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">Tambah Lembaga Penunjang Pasar Modal</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Nama Institusi / Kantor <span class="text-danger">*</span></label>
                                <input type="text" name="NamaInstitusi" class="form-control" required placeholder="Contoh: Paul Hadiwinata, Hidajat Arsono, Retno Palilingan & Rekan">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="Kategori" class="form-control" required>
                                    <option value="Kantor Akuntan Publik (KAP)">Kantor Akuntan Publik (KAP)</option>
                                    <option value="Biro Administrasi Efek (BAE)">Biro Administrasi Efek (BAE)</option>
                                    <option value="Notaris">Notaris</option>
                                    <option value="Konsultan Hukum">Konsultan Hukum</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Afiliasi / Jaringan Internasional</label>
                                <input type="text" name="Afiliasi" class="form-control" placeholder="Contoh: Anggota Firma PKF International Limited">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Website Resmi</label>
                                <input type="url" name="Website" class="form-control" placeholder="https://pkf.co.id">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Alamat &amp; Kontak Kantor Pusat</label>
                        <textarea name="KantorPusat" rows="2" class="form-control" placeholder="Alamat lengkap, nomor telepon, dan nomor faksimili..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Alamat &amp; Kontak Kantor Cabang (Opsional)</label>
                        <textarea name="Cabang" rows="2" class="form-control" placeholder="Cabang Surabaya atau kota lainnya jika ada..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ruang Lingkup Layanan</label>
                                <input type="text" name="Layanan" class="form-control" placeholder="Contoh: Pemutakhiran DPS Saham">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="number" name="Urutan" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="Status" class="form-control">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH KETERBUKAAN -->
<div class="modal fade" id="modalTambahKeterbukaan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.investor.informasi-lainnya.store-keterbukaan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">Tambah Dokumen Keterbukaan Informasi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul Keterbukaan Informasi <span class="text-danger">*</span></label>
                        <input type="text" name="Judul" class="form-control" required placeholder="Contoh: 28 April 2024 - Keterbukaan Informasi atau Fakta Material">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="Kategori" class="form-control" required>
                                    <option value="Fakta Material">Fakta Material</option>
                                    <option value="Buyback Saham">Buyback Saham</option>
                                    <option value="Aksi Korporasi">Aksi Korporasi</option>
                                    <option value="Dividen">Dividen</option>
                                    <option value="Buletin Investor">Buletin Investor</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Publikasi <span class="text-danger">*</span></label>
                                <input type="date" name="TanggalPublikasi" class="form-control" required value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Ringkasan Isi / Keterangan</label>
                        <textarea name="Deskripsi" rows="3" class="form-control" placeholder="Ringkasan poin keterbukaan informasi..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>File Dokumen PDF <span class="text-danger">*</span></label>
                        <input type="file" name="FileDokumen" class="form-control-file" required>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="number" name="Urutan" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="Status" class="form-control">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT LEMBAGA -->
<div class="modal fade" id="modalEditLembaga" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formEditLembaga" action="" method="POST">
                @csrf
                <div class="modal-header bg-warning">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Lembaga Penunjang</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Institusi / Perusahaan <span class="text-danger">*</span></label>
                                <input type="text" name="NamaInstitusi" id="editNamaInstitusi" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori Profesi <span class="text-danger">*</span></label>
                                <select name="Kategori" id="editKategoriLembaga" class="form-control" required>
                                    <option value="Kantor Akuntan Publik (KAP)">Kantor Akuntan Publik (KAP)</option>
                                    <option value="Biro Administrasi Efek (BAE)">Biro Administrasi Efek (BAE)</option>
                                    <option value="Notaris">Notaris</option>
                                    <option value="Konsultan Hukum">Konsultan Hukum</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Afiliasi Internasional (Opsional)</label>
                                <input type="text" name="Afiliasi" id="editAfiliasi" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Website Resmi</label>
                                <input type="url" name="Website" id="editWebsite" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Alamat Kantor Pusat</label>
                        <textarea name="KantorPusat" id="editKantorPusat" rows="2" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Alamat Cabang / Operasional (Opsional)</label>
                        <textarea name="Cabang" id="editCabang" rows="2" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Jasa / Layanan yang Diberikan</label>
                        <input type="text" name="Layanan" id="editLayanan" class="form-control">
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="number" name="Urutan" id="editUrutanLembaga" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="Status" id="editStatusLembaga" class="form-control">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning font-weight-bold"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT KETERBUKAAN -->
<div class="modal fade" id="modalEditKeterbukaan" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formEditKeterbukaan" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-warning">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Dokumen Keterbukaan Informasi</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Judul Pengumuman / Dokumen <span class="text-danger">*</span></label>
                                <input type="text" name="Judul" id="editJudulKeterbukaan" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tanggal Publikasi <span class="text-danger">*</span></label>
                                <input type="date" name="TanggalPublikasi" id="editTanggalPublikasi" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori Informasi <span class="text-danger">*</span></label>
                                <select name="Kategori" id="editKategoriKeterbukaan" class="form-control" required>
                                    <option value="Fakta Material">Fakta Material</option>
                                    <option value="Buyback Saham">Buyback Saham</option>
                                    <option value="Aksi Korporasi">Aksi Korporasi</option>
                                    <option value="Dividen">Dividen</option>
                                    <option value="Buletin Investor">Buletin Investor</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ganti File Dokumen PDF (Opsional)</label>
                                <input type="file" name="FileDokumen" class="form-control-file">
                                <small class="text-muted">Biarkan kosong jika tidak memperbarui file.</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Ringkasan / Keterangan Tambahan</label>
                        <textarea name="Deskripsi" id="editDeskripsiKeterbukaan" rows="2" class="form-control"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="number" name="Urutan" id="editUrutanKeterbukaan" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="Status" id="editStatusKeterbukaan" class="form-control">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning font-weight-bold"><i class="fas fa-save mr-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Edit Lembaga
        $('.btn-edit-lembaga').on('click', function () {
            const id = $(this).data('id');
            const url = '{{ route('admin.investor.informasi-lainnya.update-lembaga', ':id') }}'.replace(':id', id);
            $('#formEditLembaga').attr('action', url);
            $('#editNamaInstitusi').val($(this).data('nama'));
            $('#editKategoriLembaga').val($(this).data('kategori'));
            $('#editAfiliasi').val($(this).data('afiliasi'));
            $('#editWebsite').val($(this).data('website'));
            $('#editKantorPusat').val($(this).data('pusat'));
            $('#editCabang').val($(this).data('cabang'));
            $('#editLayanan').val($(this).data('layanan'));
            $('#editUrutanLembaga').val($(this).data('urutan'));
            $('#editStatusLembaga').val($(this).data('status'));
            $('#modalEditLembaga').modal('show');
        });

        // Edit Keterbukaan
        $('.btn-edit-keterbukaan').on('click', function () {
            const id = $(this).data('id');
            const url = '{{ route('admin.investor.informasi-lainnya.update-keterbukaan', ':id') }}'.replace(':id', id);
            $('#formEditKeterbukaan').attr('action', url);
            $('#editJudulKeterbukaan').val($(this).data('judul'));
            $('#editTanggalPublikasi').val($(this).data('tanggal'));
            $('#editKategoriKeterbukaan').val($(this).data('kategori'));
            $('#editDeskripsiKeterbukaan').val($(this).data('deskripsi'));
            $('#editUrutanKeterbukaan').val($(this).data('urutan'));
            $('#editStatusKeterbukaan').val($(this).data('status'));
            $('#modalEditKeterbukaan').modal('show');
        });

        // Delete Row confirmation
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

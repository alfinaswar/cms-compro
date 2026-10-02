@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fas fa-landmark mr-2"></i>Kelola Tata Kelola Perusahaan (GCG)</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('jenis-laporan.index') }}">Investor</a></li>
                    <li class="breadcrumb-item active">Tata Kelola</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">

        <div class="card card-primary card-outline card-outline-tabs">
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="tataKelolaTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" id="bagan-tab" data-toggle="pill" href="#tab-bagan" role="tab">
                            <i class="fas fa-sitemap mr-1"></i> Bagan Organisasi &amp; Sekretariat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="manajemen-tab" data-toggle="pill" href="#tab-manajemen" role="tab">
                            <i class="fas fa-users-cog mr-1"></i> Manajemen Perseroan (Dewan &amp; Direksi)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="dokumen-tab" data-toggle="pill" href="#tab-dokumen" role="tab">
                            <i class="fas fa-file-contract mr-1"></i> Dokumen GCG &amp; Kebijakan
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="rups-tab" data-toggle="pill" href="#tab-rups" role="tab">
                            <i class="fas fa-calendar-check mr-1"></i> Rapat Umum Pemegang Saham (RUPS)
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold text-danger" href="{{ route('admin.investor.tata-kelola.wbs-index') }}">
                            <i class="fas fa-bullhorn mr-1"></i> Laporan WBS Masuk
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="tataKelolaTabContent">

                    <!-- ============================================ -->
                    <!-- TAB 1: BAGAN ORGANISASI & SEKRETARIAT -->
                    <!-- ============================================ -->
                    <div class="tab-pane fade show active" id="tab-bagan" role="tabpanel">
                        <form action="{{ route('admin.investor.tata-kelola.update-bagan') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Judul Bagan <span class="text-danger">*</span></label>
                                        <input type="text" name="Judul" class="form-control" value="{{ old('Judul', $bagan->Judul ?? 'Bagan Struktur Organisasi Perseroan') }}" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tanggal Diperbarui</label>
                                                <input type="date" name="TanggalDiperbarui" class="form-control" value="{{ old('TanggalDiperbarui', $bagan->TanggalDiperbarui ? $bagan->TanggalDiperbarui->format('Y-m-d') : '2024-06-02') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email Sekretariat <span class="text-danger">*</span></label>
                                                <input type="email" name="EmailSekretariat" class="form-control" value="{{ old('EmailSekretariat', $bagan->EmailSekretariat ?? 'corsec@jasuindo.com') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Telepon Sekretariat <span class="text-danger">*</span></label>
                                                <input type="text" name="TeleponSekretariat" class="form-control" value="{{ old('TeleponSekretariat', $bagan->TeleponSekretariat ?? '+62 31 891 0619') }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Alamat Sekretariat</label>
                                        <textarea name="AlamatSekretariat" rows="2" class="form-control">{{ old('AlamatSekretariat', $bagan->AlamatSekretariat ?? 'Jl. Raya Betro No. 21, Sedati, Sidoarjo 61253') }}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Keterangan Deskripsi Bagan</label>
                                        <textarea name="Keterangan" rows="3" class="form-control">{{ old('Keterangan', $bagan->Keterangan) }}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Upload Gambar Bagan Organisasi (Opsional)</label>
                                                <input type="file" name="GambarBagan" class="form-control-file">
                                                <small class="text-muted">Jika diunggah, gambar ini akan menggantikan diagram visual bawaan.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Upload PDF Dokumen Bagan (Opsional)</label>
                                                <input type="file" name="FileBaganPdf" class="form-control-file">
                                                <small class="text-muted">Untuk tombol "Unduh PDF" pada pengunjung.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary px-4 mt-2">
                                        <i class="fas fa-save mr-1"></i> Simpan Pengaturan Bagan
                                    </button>
                                </div>

                                <div class="col-md-4">
                                    <div class="card card-light">
                                        <div class="card-header"><h3 class="card-title text-sm font-weight-bold">Status Gambar Bagan</h3></div>
                                        <div class="card-body text-center p-3">
                                            @if($bagan->PathGambar)
                                                <img src="{{ asset('storage/' . $bagan->PathGambar) }}" class="img-fluid rounded border mb-2" alt="Bagan Organisasi">
                                                <p class="text-xs text-success mb-0"><i class="fas fa-check-circle"></i> Menggunakan gambar kustom</p>
                                            @else
                                                <div class="p-4 bg-light border rounded text-muted text-xs">
                                                    <i class="fas fa-sitemap fa-3x mb-2 text-secondary"></i>
                                                    <p class="mb-0">Belum ada gambar kustom diunggah. Bagan HTML default aktif.</p>
                                                </div>
                                            @endif

                                            @if($bagan->PathFilePdf)
                                                <div class="mt-2 text-left">
                                                    <a href="{{ asset('storage/' . $bagan->PathFilePdf) }}" target="_blank" class="btn btn-xs btn-outline-danger">
                                                        <i class="fas fa-file-pdf"></i> Lihat PDF Tersimpan
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- ============================================ -->
                    <!-- TAB 2: MANAJEMEN PERSEROAN -->
                    <!-- ============================================ -->
                    <div class="tab-pane fade" id="tab-manajemen" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="font-weight-bold text-secondary mb-0">Dewan Komisaris &amp; Direksi Perseroan</h5>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambahManajemen">
                                <i class="fas fa-plus mr-1"></i> Tambah Anggota Manajemen
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 8%">Foto</th>
                                        <th>Nama Lengkap</th>
                                        <th>Jabatan</th>
                                        <th>Kategori</th>
                                        <th>Deskripsi Singkat</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($manajemenList as $idx => $person)
                                        <tr>
                                            <td class="text-center">{{ $idx + 1 }}</td>
                                            <td class="text-center">
                                                @if($person->Foto)
                                                    <img src="{{ asset('storage/' . $person->Foto) }}" class="img-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <span class="badge badge-secondary p-2">{{ strtoupper(substr($person->Nama, 0, 2)) }}</span>
                                                @endif
                                            </td>
                                            <td class="font-weight-bold">{{ $person->Nama }}</td>
                                            <td class="text-primary font-weight-bold">{{ $person->Jabatan }}</td>
                                            <td>
                                                <span class="badge {{ $person->Kategori === 'Dewan Komisaris' ? 'badge-primary' : 'badge-success' }}">
                                                    {{ $person->Kategori }}
                                                </span>
                                            </td>
                                            <td class="small">{{ Str::limit($person->DeskripsiSingkat, 60) }}</td>
                                            <td class="text-center">
                                                <span class="badge {{ $person->Status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $person->Status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-xs btn-warning mr-1 btn-edit-manajemen"
                                                        data-id="{{ $person->id }}"
                                                        data-nama="{{ $person->Nama }}"
                                                        data-jabatan="{{ $person->Jabatan }}"
                                                        data-kategori="{{ $person->Kategori }}"
                                                        data-singkat="{{ $person->DeskripsiSingkat }}"
                                                        data-profil="{{ $person->ProfilLengkap }}"
                                                        data-urutan="{{ $person->Urutan }}"
                                                        data-status="{{ $person->Status }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-danger btn-delete-row"
                                                        data-url="{{ route('admin.investor.tata-kelola.destroy-manajemen', $person->id) }}"
                                                        data-nama="{{ $person->Nama }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-3">Belum ada data manajemen perseroan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ============================================ -->
                    <!-- TAB 3: DOKUMEN GCG & KEBIJAKAN -->
                    <!-- ============================================ -->
                    <div class="tab-pane fade" id="tab-dokumen" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="font-weight-bold text-secondary mb-0">Dokumen Piagam, Pedoman &amp; Kebijakan Operasional</h5>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambahDokumen">
                                <i class="fas fa-plus mr-1"></i> Tambah Dokumen GCG
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th>Judul Dokumen</th>
                                        <th>Kategori</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center">File</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dokumenList as $idx => $doc)
                                        <tr>
                                            <td class="text-center">{{ $idx + 1 }}</td>
                                            <td class="font-weight-bold">{{ $doc->Judul }}</td>
                                            <td>
                                                <span class="badge badge-info">{{ $doc->Kategori }}</span>
                                            </td>
                                            <td class="small">{{ $doc->Deskripsi ?? '-' }}</td>
                                            <td class="text-center">
                                                @if($doc->PathFile)
                                                    <a href="{{ asset('storage/' . $doc->PathFile) }}" target="_blank" class="btn btn-xs btn-outline-danger">
                                                        <i class="fas fa-file-pdf"></i> PDF ({{ $doc->FileSize }})
                                                    </a>
                                                @else
                                                    <span class="text-muted small">Tidak ada file</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge {{ $doc->Status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $doc->Status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-xs btn-warning mr-1 btn-edit-dokumen"
                                                        data-id="{{ $doc->id }}"
                                                        data-judul="{{ $doc->Judul }}"
                                                        data-kategori="{{ $doc->Kategori }}"
                                                        data-deskripsi="{{ $doc->Deskripsi }}"
                                                        data-urutan="{{ $doc->Urutan }}"
                                                        data-status="{{ $doc->Status }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-danger btn-delete-row"
                                                        data-url="{{ route('admin.investor.tata-kelola.destroy-dokumen', $doc->id) }}"
                                                        data-nama="{{ $doc->Judul }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-3">Belum ada dokumen GCG.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- ============================================ -->
                    <!-- TAB 4: RUPS -->
                    <!-- ============================================ -->
                    <div class="tab-pane fade" id="tab-rups" role="tabpanel">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="font-weight-bold text-secondary mb-0">Dokumen Rapat Umum Pemegang Saham (RUPS)</h5>
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambahRups">
                                <i class="fas fa-plus mr-1"></i> Tambah Dokumen RUPS
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 8%" class="text-center">Tahun</th>
                                        <th>Judul Dokumen</th>
                                        <th>Kategori Dokumen</th>
                                        <th class="text-center">Status Kegiatan</th>
                                        <th class="text-center">File</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rupsList as $idx => $rups)
                                        <tr>
                                            <td class="text-center">{{ $idx + 1 }}</td>
                                            <td class="text-center font-weight-bold text-primary">{{ $rups->Tahun }}</td>
                                            <td class="font-weight-bold">{{ $rups->Judul }}</td>
                                            <td>{{ $rups->KategoriDokumen ?? '-' }}</td>
                                            <td class="text-center">
                                                <span class="badge {{ $rups->StatusKegiatan === 'Selesai' ? 'badge-success' : 'badge-warning' }}">
                                                    {{ $rups->StatusKegiatan }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if($rups->PathFile)
                                                    <a href="{{ asset('storage/' . $rups->PathFile) }}" target="_blank" class="btn btn-xs btn-outline-danger">
                                                        <i class="fas fa-file-pdf"></i> Unduh
                                                    </a>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <span class="badge {{ $rups->Status === 'Aktif' ? 'badge-success' : 'badge-danger' }}">
                                                    {{ $rups->Status }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-xs btn-warning mr-1 btn-edit-rups"
                                                        data-id="{{ $rups->id }}"
                                                        data-tahun="{{ $rups->Tahun }}"
                                                        data-judul="{{ $rups->Judul }}"
                                                        data-kategori="{{ $rups->KategoriDokumen }}"
                                                        data-kegiatan="{{ $rups->StatusKegiatan }}"
                                                        data-urutan="{{ $rups->Urutan }}"
                                                        data-status="{{ $rups->Status }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-xs btn-danger btn-delete-row"
                                                        data-url="{{ route('admin.investor.tata-kelola.destroy-rups', $rups->id) }}"
                                                        data-nama="{{ $rups->Judul }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-3">Belum ada dokumen RUPS.</td>
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

<!-- MODAL TAMBAH MANAJEMEN -->
<div class="modal fade" id="modalTambahManajemen" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.investor.tata-kelola.store-manajemen') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">Tambah Anggota Manajemen</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="Nama" class="form-control" required placeholder="Contoh: Yongky Wijaya">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <input type="text" name="Jabatan" class="form-control" required placeholder="Contoh: Komisaris Utama">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori Dewan <span class="text-danger">*</span></label>
                                <select name="Kategori" class="form-control" required>
                                    <option value="Dewan Komisaris">Dewan Komisaris</option>
                                    <option value="Direksi Perseroan">Direksi Perseroan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Foto Profil (Opsional)</label>
                                <input type="file" name="Foto" class="form-control-file">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Ringkasan Profil (Muncul pada Card)</label>
                        <textarea name="DeskripsiSingkat" rows="2" class="form-control" placeholder="Ringkasan kewarganegaraan, tahun lahir, dan latar belakang singkat..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Biografi Lengkap (Muncul pada Modal Popup "Baca Profil Lengkap")</label>
                        <textarea name="ProfilLengkap" rows="4" class="form-control" placeholder="Tuliskan riwayat karier, pendidikan, dan pengalaman profesional secara mendalam..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Urutan Tampil</label>
                                <input type="number" name="Urutan" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="col-md-6">
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

<!-- MODAL TAMBAH DOKUMEN GCG -->
<div class="modal fade" id="modalTambahDokumen" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.investor.tata-kelola.store-dokumen') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">Tambah Dokumen GCG / Kebijakan</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul Dokumen <span class="text-danger">*</span></label>
                        <input type="text" name="Judul" class="form-control" required placeholder="Contoh: Pedoman Dewan Komisaris">
                    </div>

                    <div class="form-group">
                        <label>Kategori Dokumen <span class="text-danger">*</span></label>
                        <select name="Kategori" class="form-control" required>
                            <option value="Dokumen Tata Kelola">Dokumen Tata Kelola</option>
                            <option value="Kebijakan Operasional">Kebijakan Operasional</option>
                            <option value="Komite Audit">Komite Audit</option>
                            <option value="Satuan Audit Internal">Satuan Audit Internal</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi Singkat</label>
                        <textarea name="Deskripsi" rows="2" class="form-control" placeholder="Keterangan singkat dokumen..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>File Dokumen (PDF) <span class="text-danger">*</span></label>
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

<!-- MODAL TAMBAH RUPS -->
<div class="modal fade" id="modalTambahRups" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.investor.tata-kelola.store-rups') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">Tambah Dokumen RUPS</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tahun Buku <span class="text-danger">*</span></label>
                                <input type="number" name="Tahun" class="form-control" required value="{{ date('Y') }}">
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label>Status Kegiatan</label>
                                <select name="StatusKegiatan" class="form-control">
                                    <option value="Selesai">Selesai</option>
                                    <option value="Terjadwal">Terjadwal</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Judul Dokumen <span class="text-danger">*</span></label>
                        <input type="text" name="Judul" class="form-control" required placeholder="Contoh: Ringkasan Risalah RUPS 2024">
                    </div>

                    <div class="form-group">
                        <label>Kategori Dokumen</label>
                        <input type="text" name="KategoriDokumen" class="form-control" placeholder="Contoh: Ringkasan Risalah / Panggilan / CV / Surat Kuasa">
                    </div>

                    <div class="form-group">
                        <label>File Dokumen PDF</label>
                        <input type="file" name="FileDokumen" class="form-control-file">
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

<!-- MODAL EDIT MANAJEMEN -->
<div class="modal fade" id="modalEditManajemen" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formEditManajemen" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-warning">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Anggota Manajemen</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="Nama" id="editNamaManajemen" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jabatan <span class="text-danger">*</span></label>
                                <input type="text" name="Jabatan" id="editJabatanManajemen" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori <span class="text-danger">*</span></label>
                                <select name="Kategori" id="editKategoriManajemen" class="form-control" required>
                                    <option value="Dewan Komisaris">Dewan Komisaris</option>
                                    <option value="Direksi Perseroan">Direksi Perseroan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ganti Foto (Opsional)</label>
                                <input type="file" name="Foto" class="form-control-file">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto saat ini.</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi Singkat / Ringkasan</label>
                        <textarea name="DeskripsiSingkat" id="editDeskripsiSingkat" rows="2" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Profil Lengkap / Riwayat Karir</label>
                        <textarea name="ProfilLengkap" id="editProfilLengkap" rows="4" class="form-control"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Urutan Tampil</label>
                                <input type="number" name="Urutan" id="editUrutanManajemen" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="Status" id="editStatusManajemen" class="form-control">
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

<!-- MODAL EDIT DOKUMEN -->
<div class="modal fade" id="modalEditDokumen" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formEditDokumen" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-warning">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Dokumen GCG</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Judul Dokumen <span class="text-danger">*</span></label>
                        <input type="text" name="Judul" id="editJudulDokumen" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kategori Dokumen <span class="text-danger">*</span></label>
                                <select name="Kategori" id="editKategoriDokumen" class="form-control" required>
                                    <option value="Dokumen Tata Kelola">Dokumen Tata Kelola</option>
                                    <option value="Kebijakan Operasional">Kebijakan Operasional</option>
                                    <option value="Komite Audit">Komite Audit</option>
                                    <option value="Satuan Audit Internal">Satuan Audit Internal</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ganti File Dokumen (Opsional)</label>
                                <input type="file" name="FileDokumen" class="form-control-file">
                                <small class="text-muted">Biarkan kosong jika tidak ingin memperbarui file saat ini.</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi Singkat</label>
                        <textarea name="Deskripsi" id="editDeskripsiDokumen" rows="2" class="form-control"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="number" name="Urutan" id="editUrutanDokumen" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="Status" id="editStatusDokumen" class="form-control">
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

<!-- MODAL EDIT RUPS -->
<div class="modal fade" id="modalEditRups" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formEditRups" action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-warning">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-edit mr-1"></i> Edit Dokumen RUPS</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tahun Buku <span class="text-danger">*</span></label>
                                <input type="number" name="Tahun" id="editTahunRups" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label>Status Kegiatan</label>
                                <select name="StatusKegiatan" id="editStatusKegiatanRups" class="form-control">
                                    <option value="Selesai">Selesai</option>
                                    <option value="Terjadwal">Terjadwal</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Judul Dokumen <span class="text-danger">*</span></label>
                        <input type="text" name="Judul" id="editJudulRups" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Kategori Dokumen</label>
                        <input type="text" name="KategoriDokumen" id="editKategoriDokumenRups" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Ganti File Dokumen PDF (Opsional)</label>
                        <input type="file" name="FileDokumen" class="form-control-file">
                        <small class="text-muted">Biarkan kosong jika tidak ingin memperbarui file.</small>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Urutan</label>
                                <input type="number" name="Urutan" id="editUrutanRups" class="form-control">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select name="Status" id="editStatusRups" class="form-control">
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
        // Edit Manajemen
        $('.btn-edit-manajemen').on('click', function () {
            const id = $(this).data('id');
            const url = '{{ route('admin.investor.tata-kelola.update-manajemen', ':id') }}'.replace(':id', id);
            $('#formEditManajemen').attr('action', url);
            $('#editNamaManajemen').val($(this).data('nama'));
            $('#editJabatanManajemen').val($(this).data('jabatan'));
            $('#editKategoriManajemen').val($(this).data('kategori'));
            $('#editDeskripsiSingkat').val($(this).data('singkat'));
            $('#editProfilLengkap').val($(this).data('profil'));
            $('#editUrutanManajemen').val($(this).data('urutan'));
            $('#editStatusManajemen').val($(this).data('status'));
            $('#modalEditManajemen').modal('show');
        });

        // Edit Dokumen
        $('.btn-edit-dokumen').on('click', function () {
            const id = $(this).data('id');
            const url = '{{ route('admin.investor.tata-kelola.update-dokumen', ':id') }}'.replace(':id', id);
            $('#formEditDokumen').attr('action', url);
            $('#editJudulDokumen').val($(this).data('judul'));
            $('#editKategoriDokumen').val($(this).data('kategori'));
            $('#editDeskripsiDokumen').val($(this).data('deskripsi'));
            $('#editUrutanDokumen').val($(this).data('urutan'));
            $('#editStatusDokumen').val($(this).data('status'));
            $('#modalEditDokumen').modal('show');
        });

        // Edit RUPS
        $('.btn-edit-rups').on('click', function () {
            const id = $(this).data('id');
            const url = '{{ route('admin.investor.tata-kelola.update-rups', ':id') }}'.replace(':id', id);
            $('#formEditRups').attr('action', url);
            $('#editTahunRups').val($(this).data('tahun'));
            $('#editJudulRups').val($(this).data('judul'));
            $('#editKategoriDokumenRups').val($(this).data('kategori'));
            $('#editStatusKegiatanRups').val($(this).data('kegiatan'));
            $('#editUrutanRups').val($(this).data('urutan'));
            $('#editStatusRups').val($(this).data('status'));
            $('#modalEditRups').modal('show');
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

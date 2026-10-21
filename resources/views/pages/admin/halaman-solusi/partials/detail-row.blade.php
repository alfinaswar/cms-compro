<div class="p-3" style="background: #f8f9fa; border-left: 3px solid #007bff;">
    <div class="row">
        {{-- Kolom Kiri: Detail List --}}
        <div class="col-md-8">
            <h6 class="font-weight-bold mb-2">
                <i class="fa fa-list-alt mr-1 text-primary"></i> Detail Solusi
            </h6>
            @if ($row->details && count($row->details))
                <div class="table-responsive mb-3">
                    <table class="table table-sm table-bordered bg-white">
                        <thead>
                            <tr class="small">
                                <th>#</th>
                                <th>Judul</th>
                                <th>Keterangan</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($row->details as $i => $detail)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        {{ filled($detail->t('Judul')) ? $detail->t('Judul') : '-' }}
                                    </td>
                                    <td>
                                        {!! $detail->t('Keterangan') ? nl2br(e($detail->t('Keterangan'))) : '<span class="text-muted">-</span>' !!}
                                    </td>
                                    <td>
                                        @if ($detail->Gambar)
                                            <img src="{{ asset('storage/' . $detail->Gambar) }}" alt="Gambar"
                                                style="max-width: 60px; max-height: 60px;">
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('halaman-solusi.detail.edit', encrypt($detail->id)) }}"
                                            class="btn btn-sm btn-primary" title="Tambah Sub Halaman">
                                            <i class="fa fa-plus"></i> Subhalaman
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="small text-muted">Belum ada detail yang ditambahkan.</p>
            @endif
            <div class="d-flex flex-wrap" style="gap: 6px;">
                <a href="{{ $urlId }}" target="_blank" class="btn btn-sm btn-info">
                    <i class="fa fa-external-link-alt mr-1"></i> Lihat (ID)
                </a>
                <a href="{{ $urlEn }}" target="_blank" class="btn btn-sm btn-secondary">
                    <i class="fa fa-external-link-alt mr-1"></i> Lihat (EN)
                </a>
            </div>
        </div>

        {{-- Kolom Kanan: Informasi & Meta --}}
        <div class="col-md-4">
            <h6 class="font-weight-bold mb-2">
                <i class="fa fa-info-circle mr-1 text-primary"></i> Informasi
            </h6>
            <table class="table table-sm mb-0 small table-bordered bg-white">
                <tr>
                    <th style="width: 40%;">Status</th>
                    <td>
                        @if ($row->IsPublished)
                            <span class="badge badge-success">Publikasi</span>
                        @else
                            <span class="badge badge-secondary">Draft</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td><code>{{ $row->Slug }}</code></td>
                </tr>
                <tr>
                    <th>Dibuat</th>
                    <td>
                        {{ $row->created_at ? $row->created_at->format('d M Y, H:i') : '-' }}
                        <br><span class="text-muted">{{ $row->UserCreate ?? '-' }}</span>
                    </td>
                </tr>
                <tr>
                    <th>Update</th>
                    <td>
                        {{ $row->updated_at ? $row->updated_at->format('d M Y, H:i') : '-' }}
                        <br><span class="text-muted">{{ $row->UserUpdate ?? '-' }}</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

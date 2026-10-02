<?php

namespace Database\Seeders;

use App\Models\JenisLaporanKeuangan;
use App\Models\LaporanKeuanganDetail;
use Illuminate\Database\Seeder;

class LaporanKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Kategori Jenis Laporan
        $kategoriList = [
            [
                'NamaJenis' => 'Prospektus & Keterbukaan',
                'Slug' => 'prospektus',
                'Deskripsi' => 'Dokumen resmi prospektus penawaran umum perdana dan keterbukaan informasi aksi korporasi perseroan.',
                'IconKategori' => 'fa-file-contract',
                'WarnaBadge' => 'primary',
                'Urutan' => 1,
                'Status' => 'Aktif',
                'UserCreate' => 'System',
            ],
            [
                'NamaJenis' => 'Laporan Tahunan (Annual Report)',
                'Slug' => 'laporan-tahunan',
                'Deskripsi' => 'Laporan tahunan dan laporan keberlanjutan yang mencakup kinerja menyeluruh operasional dan finansial perusahaan.',
                'IconKategori' => 'fa-book-bookmark',
                'WarnaBadge' => 'success',
                'Urutan' => 2,
                'Status' => 'Aktif',
                'UserCreate' => 'System',
            ],
            [
                'NamaJenis' => 'Laporan Keuangan Triwulanan',
                'Slug' => 'laporan-triwulanan',
                'Deskripsi' => 'Laporan keuangan berkala per kuartal (Q1, Q2, Q3, Q4) yang diaudit dan dipublikasikan.',
                'IconKategori' => 'fa-calendar-week',
                'WarnaBadge' => 'info',
                'Urutan' => 3,
                'Status' => 'Aktif',
                'UserCreate' => 'System',
            ],
            [
                'NamaJenis' => 'Ringkasan Kinerja Keuangan',
                'Slug' => 'ringkasan-keuangan',
                'Deskripsi' => 'Ikhtisar data keuangan 5 tahunan dan rasio-rasio penting perseroan.',
                'IconKategori' => 'fa-chart-line',
                'WarnaBadge' => 'warning',
                'Urutan' => 4,
                'Status' => 'Aktif',
                'UserCreate' => 'System',
            ],
        ];

        foreach ($kategoriList as $kat) {
            $cat = JenisLaporanKeuangan::updateOrCreate(['Slug' => $kat['Slug']], $kat);

            // Seed details per kategori jika masih kosong
            if ($cat->details()->count() === 0) {
                if ($cat->Slug === 'prospektus') {
                    LaporanKeuanganDetail::create([
                        'JenisLaporanId' => $cat->id,
                        'Judul' => 'Prospektus Penawaran Umum Perdana Saham',
                        'Deskripsi' => 'Penawaran umum saham biasa perseroan yang dicatatkan pada BEI (IDX: JTPE).',
                        'PathFile' => 'investor/dokumen/prospektus-jtpe.pdf',
                        'FileSize' => '14.8 MB',
                        'TahunPeriode' => '2002-01-01',
                        'Bahasa' => 'ID',
                        'Urutan' => 1,
                        'Status' => 'Aktif',
                        'UserCreate' => 'System',
                    ]);
                    LaporanKeuanganDetail::create([
                        'JenisLaporanId' => $cat->id,
                        'Judul' => 'Keterbukaan Informasi & Prospektus Aksi',
                        'Deskripsi' => 'Pengumuman aksi korporasi, stock split, dan ringkasan distribusi dividen.',
                        'PathFile' => 'investor/dokumen/prospektus-aksi-korporasi.pdf',
                        'FileSize' => '8.2 MB',
                        'TahunPeriode' => '2024-01-01',
                        'Bahasa' => 'ID',
                        'Urutan' => 2,
                        'Status' => 'Aktif',
                        'UserCreate' => 'System',
                    ]);
                } elseif ($cat->Slug === 'laporan-tahunan') {
                    LaporanKeuanganDetail::create([
                        'JenisLaporanId' => $cat->id,
                        'Judul' => 'Laporan Tahunan & Laporan Keberlanjutan 2025',
                        'Deskripsi' => 'Pendapatan Rp2,78 Triliun (+31.5% YoY), Laba Bersih Induk Rp351,4 M (+47.7% YoY), Dividen Final Rp17,00/saham.',
                        'PathFile' => 'investor/dokumen/annual-report-2025.pdf',
                        'FileSize' => '24.5 MB',
                        'TahunPeriode' => '2025-12-31',
                        'Bahasa' => 'ID',
                        'Urutan' => 1,
                        'Status' => 'Aktif',
                        'UserCreate' => 'System',
                    ]);
                    LaporanKeuanganDetail::create([
                        'JenisLaporanId' => $cat->id,
                        'Judul' => 'Laporan Tahunan & Laporan Keberlanjutan 2024',
                        'Deskripsi' => 'Inovasi Tanpa Batas menuju ekosistem identitas dan pembayaran cerdas terintegrasi.',
                        'PathFile' => 'investor/dokumen/annual-report-2024.pdf',
                        'FileSize' => '21.0 MB',
                        'TahunPeriode' => '2024-12-31',
                        'Bahasa' => 'ID',
                        'Urutan' => 2,
                        'Status' => 'Aktif',
                        'UserCreate' => 'System',
                    ]);
                    LaporanKeuanganDetail::create([
                        'JenisLaporanId' => $cat->id,
                        'Judul' => 'Laporan Tahunan 2023',
                        'Deskripsi' => 'Penguatan kapabilitas ekspor dan penetrasi pasar kartu pintar global.',
                        'PathFile' => 'investor/dokumen/annual-report-2023.pdf',
                        'FileSize' => '19.5 MB',
                        'TahunPeriode' => '2023-12-31',
                        'Bahasa' => 'ID',
                        'Urutan' => 3,
                        'Status' => 'Aktif',
                        'UserCreate' => 'System',
                    ]);
                } elseif ($cat->Slug === 'laporan-triwulanan') {
                    LaporanKeuanganDetail::create([
                        'JenisLaporanId' => $cat->id,
                        'Judul' => 'Laporan Keuangan Triwulan I 2026 (Unaudited)',
                        'Deskripsi' => 'Per 31 Maret 2026',
                        'PathFile' => 'investor/dokumen/q1-2026.pdf',
                        'FileSize' => '4.2 MB',
                        'TahunPeriode' => '2026-03-31',
                        'Bahasa' => 'ID',
                        'Urutan' => 1,
                        'Status' => 'Aktif',
                        'UserCreate' => 'System',
                    ]);
                    LaporanKeuanganDetail::create([
                        'JenisLaporanId' => $cat->id,
                        'Judul' => 'Laporan Keuangan Triwulan II 2026 (Limited Review)',
                        'Deskripsi' => 'Per 30 Juni 2026',
                        'PathFile' => 'investor/dokumen/q2-2026.pdf',
                        'FileSize' => '4.8 MB',
                        'TahunPeriode' => '2026-06-30',
                        'Bahasa' => 'ID',
                        'Urutan' => 2,
                        'Status' => 'Aktif',
                        'UserCreate' => 'System',
                    ]);
                }
            }
        }
    }
}

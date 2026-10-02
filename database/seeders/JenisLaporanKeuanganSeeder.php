<?php

namespace Database\Seeders;

use App\Models\JenisLaporanKeuangan;
use Illuminate\Database\Seeder;

class JenisLaporanKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'NamaJenis' => 'Prospectus',
                'Slug' => 'prospectus',
                'Deskripsi' => 'Dokumen prospektus penawaran umum saham dan obligasi perusahaan.',
                'IconKategori' => 'fa-file-alt',
                'WarnaBadge' => 'secondary',
                'Urutan' => 1,
                'Status' => 'Aktif',
                'UserCreate' => 'System',
            ],
            [
                'NamaJenis' => 'Annual Report',
                'Slug' => 'annual-report',
                'Deskripsi' => 'Laporan tahunan perusahaan mencakup kinerja keuangan dan operasional.',
                'IconKategori' => 'fa-calendar-alt',
                'WarnaBadge' => 'primary',
                'Urutan' => 2,
                'Status' => 'Aktif',
                'UserCreate' => 'System',
            ],
            [
                'NamaJenis' => 'Quarterly Report',
                'Slug' => 'quarterly-report',
                'Deskripsi' => 'Laporan keuangan triwulanan perusahaan.',
                'IconKategori' => 'fa-calendar-week',
                'WarnaBadge' => 'info',
                'Urutan' => 3,
                'Status' => 'Aktif',
                'UserCreate' => 'System',
            ],
            [
                'NamaJenis' => 'Financial Highlight',
                'Slug' => 'financial-highlight',
                'Deskripsi' => 'Ringkasan kinerja keuangan utama perusahaan.',
                'IconKategori' => 'fa-chart-line',
                'WarnaBadge' => 'success',
                'Urutan' => 4,
                'Status' => 'Aktif',
                'UserCreate' => 'System',
            ],
            [
                'NamaJenis' => 'Other Information',
                'Slug' => 'other-information',
                'Deskripsi' => 'Informasi lainnya terkait investor relations.',
                'IconKategori' => 'fa-info-circle',
                'WarnaBadge' => 'warning',
                'Urutan' => 5,
                'Status' => 'Aktif',
                'UserCreate' => 'System',
            ],
        ];

        foreach ($data as $item) {
            JenisLaporanKeuangan::create($item);
        }

        $this->command->info('✅ Seeder Jenis Laporan Keuangan berhasil dijalankan!');
    }
}

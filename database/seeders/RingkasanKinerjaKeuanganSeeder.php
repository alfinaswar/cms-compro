<?php

namespace Database\Seeders;

use App\Models\RingkasanKinerjaPos;
use App\Models\RingkasanKinerjaNilai;
use App\Models\PengaturanKinerjaKeuangan;
use Illuminate\Database\Seeder;

class RingkasanKinerjaKeuanganSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pengaturan Periode Tampilan & Highlight Pertumbuhan
        PengaturanKinerjaKeuangan::updateOrCreate(
            ['id' => 1],
            [
                'ModeWindow' => 'Kustom',
                'JumlahTahun' => 5,
                'TahunMulai' => 2021,
                'TahunSelesai' => 2025,
                'PertumbuhanRevenue' => '+31.5% YoY (2025)',
                'PertumbuhanProfit' => '+47.7% YoY (2025)',
                'Subjudul' => 'Ringkasan kinerja keuangan utama perusahaan selama 5 tahun terakhir (2021 - 2025).',
                'UserCreate' => 'System',
            ]
        );

        // 2. Data Pos dan Nilai Tahunan (Relasional Normal 3NF)
        $items = [
            // === LABA RUGI ===
            [
                'KodePos' => 'pendapatan_usaha',
                'Kategori' => 'Laba Rugi',
                'NamaPos' => 'Pendapatan Usaha',
                'Catatan' => null,
                'Satuan' => 'Jutaan IDR',
                'IsSubPos' => false,
                'IsBold' => true,
                'IsHighlight' => false,
                'Urutan' => 1,
                'values' => [
                    2021 => '1.150.320',
                    2022 => '1.480.110',
                    2023 => '1.820.450',
                    2024 => '2.115.680',
                    2025 => '2.780.250',
                ],
            ],
            [
                'KodePos' => 'beban_pokok',
                'Kategori' => 'Laba Rugi',
                'NamaPos' => 'Beban Pokok Pendapatan',
                'Catatan' => null,
                'Satuan' => 'Jutaan IDR',
                'IsSubPos' => false,
                'IsBold' => false,
                'IsHighlight' => false,
                'Urutan' => 2,
                'values' => [
                    2021 => '(820.150)',
                    2022 => '(1.020.400)',
                    2023 => '(1.230.120)',
                    2024 => '(1.410.200)',
                    2025 => '(1.810.150)',
                ],
            ],
            [
                'KodePos' => 'laba_bruto',
                'Kategori' => 'Laba Rugi',
                'NamaPos' => 'Laba Bruto',
                'Catatan' => null,
                'Satuan' => 'Jutaan IDR',
                'IsSubPos' => false,
                'IsBold' => true,
                'IsHighlight' => false,
                'Urutan' => 3,
                'values' => [
                    2021 => '330.170',
                    2022 => '459.710',
                    2023 => '590.330',
                    2024 => '705.480',
                    2025 => '970.100',
                ],
            ],
            [
                'KodePos' => 'laba_entitas_induk',
                'Kategori' => 'Laba Rugi',
                'NamaPos' => 'Pemilik Entitas Induk',
                'Catatan' => 'Laba yang dapat diatribusikan kepada:',
                'Satuan' => 'Jutaan IDR',
                'IsSubPos' => true,
                'IsBold' => false,
                'IsHighlight' => false,
                'Urutan' => 4,
                'values' => [
                    2021 => '108.450',
                    2022 => '158.200',
                    2023 => '209.110',
                    2024 => '231.450',
                    2025 => '351.420',
                ],
            ],
            [
                'KodePos' => 'kepentingan_non_pengendali',
                'Kategori' => 'Laba Rugi',
                'NamaPos' => 'Kepentingan Non-Pengendali',
                'Catatan' => null,
                'Satuan' => 'Jutaan IDR',
                'IsSubPos' => true,
                'IsBold' => false,
                'IsHighlight' => false,
                'Urutan' => 5,
                'values' => [
                    2021 => '3.550',
                    2022 => '6.800',
                    2023 => '8.890',
                    2024 => '6.550',
                    2025 => '8.580',
                ],
            ],
            [
                'KodePos' => 'laba_bersih',
                'Kategori' => 'Laba Rugi',
                'NamaPos' => 'Laba Bersih Tahun Berjalan',
                'Catatan' => null,
                'Satuan' => 'Jutaan IDR',
                'IsSubPos' => false,
                'IsBold' => true,
                'IsHighlight' => true,
                'Urutan' => 6,
                'values' => [
                    2021 => '112.000',
                    2022 => '165.000',
                    2023 => '218.000',
                    2024 => '238.000',
                    2025 => '360.000',
                ],
            ],
            [
                'KodePos' => 'laba_per_saham',
                'Kategori' => 'Laba Rugi',
                'NamaPos' => 'Laba per Saham Dasar (Rupiah)',
                'Catatan' => null,
                'Satuan' => 'Rupiah',
                'IsSubPos' => false,
                'IsBold' => true,
                'IsHighlight' => false,
                'Urutan' => 7,
                'values' => [
                    2021 => '15,8',
                    2022 => '23,1',
                    2023 => '30,5',
                    2024 => '33,8',
                    2025 => '51,3',
                ],
            ],

            // === POSISI KEUANGAN ===
            [
                'KodePos' => 'aset_lancar',
                'Kategori' => 'Posisi Keuangan',
                'NamaPos' => 'Total Aset Lancar',
                'Catatan' => null,
                'Satuan' => 'Jutaan IDR',
                'IsSubPos' => false,
                'IsBold' => false,
                'IsHighlight' => false,
                'Urutan' => 8,
                'values' => [
                    2021 => '780.200',
                    2022 => '980.500',
                    2023 => '1.250.300',
                    2024 => '1.460.200',
                    2025 => '1.850.400',
                ],
            ],
            [
                'KodePos' => 'aset_tidak_lancar',
                'Kategori' => 'Posisi Keuangan',
                'NamaPos' => 'Total Aset Tidak Lancar',
                'Catatan' => null,
                'Satuan' => 'Jutaan IDR',
                'IsSubPos' => false,
                'IsBold' => false,
                'IsHighlight' => false,
                'Urutan' => 9,
                'values' => [
                    2021 => '543.120',
                    2022 => '639.700',
                    2023 => '690.200',
                    2024 => '801.600',
                    2025 => '1.050.200',
                ],
            ],
            [
                'KodePos' => 'total_aset',
                'Kategori' => 'Posisi Keuangan',
                'NamaPos' => 'Total Aset',
                'Catatan' => null,
                'Satuan' => 'Jutaan IDR',
                'IsSubPos' => false,
                'IsBold' => true,
                'IsHighlight' => false,
                'Urutan' => 10,
                'values' => [
                    2021 => '1.323.320',
                    2022 => '1.620.200',
                    2023 => '1.940.500',
                    2024 => '2.261.800',
                    2025 => '2.900.600',
                ],
            ],
            [
                'KodePos' => 'liabilitas_pendek',
                'Kategori' => 'Posisi Keuangan',
                'NamaPos' => 'Total Liabilitas Jangka Pendek',
                'Catatan' => null,
                'Satuan' => 'Jutaan IDR',
                'IsSubPos' => false,
                'IsBold' => false,
                'IsHighlight' => false,
                'Urutan' => 11,
                'values' => [
                    2021 => '385.150',
                    2022 => '460.400',
                    2023 => '560.200',
                    2024 => '670.300',
                    2025 => '890.300',
                ],
            ],
            [
                'KodePos' => 'liabilitas_panjang',
                'Kategori' => 'Posisi Keuangan',
                'NamaPos' => 'Total Liabilitas Jangka Panjang',
                'Catatan' => null,
                'Satuan' => 'Jutaan IDR',
                'IsSubPos' => false,
                'IsBold' => false,
                'IsHighlight' => false,
                'Urutan' => 12,
                'values' => [
                    2021 => '115.400',
                    2022 => '140.100',
                    2023 => '180.400',
                    2024 => '195.500',
                    2025 => '240.200',
                ],
            ],
            [
                'KodePos' => 'total_liabilitas',
                'Kategori' => 'Posisi Keuangan',
                'NamaPos' => 'Total Liabilitas',
                'Catatan' => null,
                'Satuan' => 'Jutaan IDR',
                'IsSubPos' => false,
                'IsBold' => true,
                'IsHighlight' => false,
                'Urutan' => 13,
                'values' => [
                    2021 => '500.550',
                    2022 => '600.500',
                    2023 => '740.600',
                    2024 => '865.800',
                    2025 => '1.130.500',
                ],
            ],
            [
                'KodePos' => 'total_ekuitas',
                'Kategori' => 'Posisi Keuangan',
                'NamaPos' => 'Total Ekuitas',
                'Catatan' => null,
                'Satuan' => 'Jutaan IDR',
                'IsSubPos' => false,
                'IsBold' => true,
                'IsHighlight' => false,
                'Urutan' => 14,
                'values' => [
                    2021 => '819.750',
                    2022 => '1.000.400',
                    2023 => '1.218.900',
                    2024 => '1.440.700',
                    2025 => '1.870.300',
                ],
            ],

            // === RASIO - RASIO PENTING ===
            [
                'KodePos' => 'marjin_laba_bersih',
                'Kategori' => 'Rasio',
                'NamaPos' => 'Marjin Laba Bersih (%)',
                'Catatan' => null,
                'Satuan' => '%',
                'IsSubPos' => false,
                'IsBold' => false,
                'IsHighlight' => false,
                'Urutan' => 15,
                'values' => [
                    2021 => '9,7%',
                    2022 => '11,1%',
                    2023 => '12,0%',
                    2024 => '11,2%',
                    2025 => '12,4%',
                ],
            ],
            [
                'KodePos' => 'roe',
                'Kategori' => 'Rasio',
                'NamaPos' => 'Imbal Hasil atas Ekuitas (ROE) (%)',
                'Catatan' => null,
                'Satuan' => '%',
                'IsSubPos' => false,
                'IsBold' => false,
                'IsHighlight' => false,
                'Urutan' => 16,
                'values' => [
                    2021 => '13,7%',
                    2022 => '16,5%',
                    2023 => '17,9%',
                    2024 => '16,5%',
                    2025 => '19,3%',
                ],
            ],
            [
                'KodePos' => 'roa',
                'Kategori' => 'Rasio',
                'NamaPos' => 'Imbal Hasil atas Aset (ROA) (%)',
                'Catatan' => null,
                'Satuan' => '%',
                'IsSubPos' => false,
                'IsBold' => false,
                'IsHighlight' => false,
                'Urutan' => 17,
                'values' => [
                    2021 => '8,5%',
                    2022 => '10,3%',
                    2023 => '11,1%',
                    2024 => '10,3%',
                    2025 => '12,0%',
                ],
            ],
            [
                'KodePos' => 'rasio_lancar',
                'Kategori' => 'Rasio',
                'NamaPos' => 'Rasio Lancar (x)',
                'Catatan' => null,
                'Satuan' => 'x',
                'IsSubPos' => false,
                'IsBold' => false,
                'IsHighlight' => false,
                'Urutan' => 18,
                'values' => [
                    2021 => '2,05x',
                    2022 => '2,13x',
                    2023 => '2,15x',
                    2024 => '2,21x',
                    2025 => '2,19x',
                ],
            ],
            [
                'KodePos' => 'der',
                'Kategori' => 'Rasio',
                'NamaPos' => 'Rasio Liabilitas terhadap Ekuitas (DER) (x)',
                'Catatan' => null,
                'Satuan' => 'x',
                'IsSubPos' => false,
                'IsBold' => false,
                'IsHighlight' => false,
                'Urutan' => 19,
                'values' => [
                    2021 => '0,61x',
                    2022 => '0,60x',
                    2023 => '0,61x',
                    2024 => '0,60x',
                    2025 => '0,60x',
                ],
            ],

            // === INFORMASI SAHAM & DIVIDEN ===
            [
                'KodePos' => 'harga_saham',
                'Kategori' => 'Saham & Dividen',
                'NamaPos' => 'Harga Saham Penutupan (IDR)',
                'Catatan' => null,
                'Satuan' => 'IDR',
                'IsSubPos' => false,
                'IsBold' => true,
                'IsHighlight' => false,
                'Urutan' => 20,
                'values' => [
                    2021 => '340',
                    2022 => '450',
                    2023 => '520',
                    2024 => '585',
                    2025 => '690',
                ],
            ],
            [
                'KodePos' => 'kapitalisasi_pasar',
                'Kategori' => 'Saham & Dividen',
                'NamaPos' => 'Kapitalisasi Pasar (Miliar IDR)',
                'Catatan' => null,
                'Satuan' => 'Miliar IDR',
                'IsSubPos' => false,
                'IsBold' => true,
                'IsHighlight' => false,
                'Urutan' => 21,
                'values' => [
                    2021 => '2.329',
                    2022 => '3.082',
                    2023 => '3.562',
                    2024 => '4.007',
                    2025 => '4.726',
                ],
            ],
            [
                'KodePos' => 'dividen_per_saham',
                'Kategori' => 'Saham & Dividen',
                'NamaPos' => 'Dividen per Saham (IDR)',
                'Catatan' => null,
                'Satuan' => 'IDR',
                'IsSubPos' => false,
                'IsBold' => true,
                'IsHighlight' => false,
                'Urutan' => 22,
                'values' => [
                    2021 => '12,00',
                    2022 => '20,00',
                    2023 => '24,00',
                    2024 => '14,00',
                    2025 => '17,00',
                ],
            ],
        ];

        foreach ($items as $item) {
            $values = $item['values'] ?? [];
            unset($item['values']);
            $item['UserCreate'] = 'System';

            $pos = RingkasanKinerjaPos::updateOrCreate(
                ['KodePos' => $item['KodePos']],
                $item
            );

            foreach ($values as $year => $valStr) {
                RingkasanKinerjaNilai::updateOrCreate(
                    [
                        'PosId' => $pos->id,
                        'Tahun' => (int) $year,
                    ],
                    [
                        'NilaiTampil' => $valStr,
                        'UserCreate' => 'System',
                    ]
                );
            }
        }
    }
}

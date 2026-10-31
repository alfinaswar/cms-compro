<?php

namespace Database\Seeders;

use App\Models\MasterProduk;
use Illuminate\Database\Seeder;

class MasterProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hierarchy = [
            [
                'Nama' => 'Identitas',
                'NamaTranslate' => 'Identity',
                'children' => [
                    ['Nama' => 'Paspor', 'NamaTranslate' => 'Passport'],
                    ['Nama' => 'Kartu Identitas', 'NamaTranslate' => 'Identity Card'],
                    ['Nama' => 'Ijazah & Sertifikat', 'NamaTranslate' => 'Diplomas & Certificates'],
                ],
            ],
            [
                'Nama' => 'Pembayaran',
                'NamaTranslate' => 'Payment',
                'children' => [
                    [
                        'Nama' => 'Kartu bank',
                        'NamaTranslate' => 'Bank cards',
                        'children' => [
                            ['Nama' => 'Kartu Kredit', 'NamaTranslate' => 'Credit Card'],
                            ['Nama' => 'Kartu Debit', 'NamaTranslate' => 'Debit Card'],
                            ['Nama' => 'Kartu pembayaran transportasi', 'NamaTranslate' => 'Transit Payment Card'],
                        ],
                    ],
                    [
                        'Nama' => 'Warkat bank',
                        'NamaTranslate' => 'Bank instruments',
                        'children' => [
                            ['Nama' => 'Cek', 'NamaTranslate' => 'Cheque'],
                            ['Nama' => 'Buku tabungan', 'NamaTranslate' => 'Passbook / Savings Book'],
                            ['Nama' => 'Giro', 'NamaTranslate' => 'Giro / Demand Deposit'],
                            ['Nama' => 'Bank garansi', 'NamaTranslate' => 'Bank Guarantee'],
                        ],
                    ],
                    [
                        'Nama' => 'Biro personalisasi',
                        'NamaTranslate' => 'Personalization bureau',
                    ],
                ],
            ],
            [
                'Nama' => 'Perlindungan Merek',
                'NamaTranslate' => 'Brand Protection',
                'children' => [
                    ['Nama' => 'Kemasan', 'NamaTranslate' => 'Packaging'],
                    ['Nama' => 'Label', 'NamaTranslate' => 'Label'],
                    ['Nama' => 'Voucher', 'NamaTranslate' => 'Voucher'],
                    ['Nama' => 'Pita cukai', 'NamaTranslate' => 'Excise Stamp / Tax Band'],
                    ['Nama' => 'Hologram', 'NamaTranslate' => 'Hologram'],
                    ['Nama' => 'Kemasan logam mulia', 'NamaTranslate' => 'Precious Metal Packaging'],
                ],
            ],
            [
                'Nama' => 'Percetakan Komersial',
                'NamaTranslate' => 'Commercial Printing',
                'children' => [
                    ['Nama' => 'Tiket gelang', 'NamaTranslate' => 'Wristband Ticket'],
                    ['Nama' => 'Tiket permainan', 'NamaTranslate' => 'Game Ticket'],
                    ['Nama' => 'Kartu permainan', 'NamaTranslate' => 'Playing Cards / Game Cards'],
                    ['Nama' => 'Buku agenda', 'NamaTranslate' => 'Agenda Book / Diary'],
                    ['Nama' => 'Kalender', 'NamaTranslate' => 'Calendar'],
                    ['Nama' => 'Sticky note', 'NamaTranslate' => 'Sticky Note'],
                ],
            ],
        ];

        foreach ($hierarchy as $urutanTop => $itemTop) {
            $top = MasterProduk::updateOrCreate(
                ['Nama' => $itemTop['Nama'], 'parent_id' => null],
                [
                    'NamaTranslate' => $itemTop['NamaTranslate'],
                    'Urutan' => $urutanTop + 1,
                    'StatusAktif' => true,
                    'UserCreate' => 'seeder',
                ]
            );

            if (!empty($itemTop['children'])) {
                foreach ($itemTop['children'] as $urutanSub => $itemSub) {
                    $sub = MasterProduk::updateOrCreate(
                        ['Nama' => $itemSub['Nama'], 'parent_id' => $top->id],
                        [
                            'NamaTranslate' => $itemSub['NamaTranslate'],
                            'Urutan' => $urutanSub + 1,
                            'StatusAktif' => true,
                            'UserCreate' => 'seeder',
                        ]
                    );

                    if (!empty($itemSub['children'])) {
                        foreach ($itemSub['children'] as $urutanSubSub => $itemSubSub) {
                            MasterProduk::updateOrCreate(
                                ['Nama' => $itemSubSub['Nama'], 'parent_id' => $sub->id],
                                [
                                    'NamaTranslate' => $itemSubSub['NamaTranslate'],
                                    'Urutan' => $urutanSubSub + 1,
                                    'StatusAktif' => true,
                                    'UserCreate' => 'seeder',
                                ]
                            );
                        }
                    }
                }
            }
        }
    }
}

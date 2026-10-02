<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JasuindoOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offices = [
            [
                'NamaKantor' => 'PT Jasuindo Tiga Perkasa Tbk - Kantor Surabaya (Pusat)',
                'TipeKantor' => 'Pusat',
                'Urutan' => 1,
                'Status' => 'Aktif',
                'AlamatLengkap' => 'Jalan Raya Betro Nomor 21, Sedati',
                'Kota' => 'Kabupaten Sidoarjo',
                'Provinsi' => 'Jawa Timur',
                'KodePos' => '61253',
                'TautanGoogleMaps' => 'https://goo.gl',
                'EmbedGoogleMaps' => '<iframe src="https://google.com!" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                'NomorTelepon' => '+62 31 8910919',
                'NomorWhatsApp' => null,
                'AlamatEmail' => 'corporate@jasuindo.co.id',
                'UserCreate' => 'SystemAdmin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'NamaKantor' => 'PT Jasuindo Tiga Perkasa Tbk - Pabrik Sidoarjo',
                'TipeKantor' => 'Cabang',
                'Urutan' => 2,
                'Status' => 'Aktif',
                'AlamatLengkap' => 'Jalan Raya Lingkar Timur Km 1, Desa Banjarsari, Buduran',
                'Kota' => 'Kabupaten Sidoarjo',
                'Provinsi' => 'Jawa Timur',
                'KodePos' => '61252',
                'TautanGoogleMaps' => 'https://goo.gl',
                'EmbedGoogleMaps' => '<iframe src="https://google.com!" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                'NomorTelepon' => null,
                'NomorWhatsApp' => null,
                'AlamatEmail' => 'factory@jasuindo.co.id',
                'UserCreate' => 'SystemAdmin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'NamaKantor' => 'PT Jasuindo Tiga Perkasa Tbk - Kantor Jakarta',
                'TipeKantor' => 'Cabang',
                'Urutan' => 3,
                'Status' => 'Aktif',
                'AlamatLengkap' => 'Office 8 Building, Floor 31st, Unit B-E, SCBD Lot. 28, Jalan Jenderal Sudirman Kav. 52-53 (Jalan Senopati Raya 8B)',
                'Kota' => 'Jakarta Selatan',
                'Provinsi' => 'DKI Jakarta',
                'KodePos' => '12190',
                'TautanGoogleMaps' => 'https://goo.gl',
                'EmbedGoogleMaps' => '<iframe src="https://google.com!" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                'NomorTelepon' => '+62 21 293 33101',
                'NomorWhatsApp' => null,
                'AlamatEmail' => 'jakarta@jasuindo.co.id',
                'UserCreate' => 'SystemAdmin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ];

        // Ganti 'nama_tabel_anda' dengan nama tabel aktual di database Anda
        DB::table('master_kantors')->insert($offices);
    }
}

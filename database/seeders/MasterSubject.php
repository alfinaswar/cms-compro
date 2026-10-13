<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSubject extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('master_subjects')->truncate();

        DB::table('master_subjects')->insert([
            [
                'Nama' => 'Permintaan Penawaran',
                'NamaTranslate' => 'Quotation Request',
                'UserCreate' => 'seeder',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Nama' => 'Info Produk',
                'NamaTranslate' => 'Product Info',
                'UserCreate' => 'seeder',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Nama' => 'Info Perusahaan',
                'NamaTranslate' => 'Company Info',
                'UserCreate' => 'seeder',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'Nama' => 'Lainnya',
                'NamaTranslate' => 'Others',
                'UserCreate' => 'seeder',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

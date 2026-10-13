<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MigrateAboutUsTranslationsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Migrate AboutUs ke translations (ID)
        $sections = DB::table('about_us')->get();
        foreach ($sections as $section) {
            DB::table('AboutUsTranslations')->updateOrInsert(
                ['IdAbout' => $section->id, 'Locale' => 'id'],
                [
                    'SubJudul' => $section->SubJudul,
                    'Judul' => $section->Judul,
                    'Deskripsi' => $section->Deskripsi,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // 2. Migrate AboutUsDetail ke translations (ID)
        $details = DB::table('about_us_details')->get();
        foreach ($details as $detail) {
            DB::table('AboutUsDetailTranslations')->updateOrInsert(
                ['IdAboutUsDetail' => $detail->id, 'Locale' => 'id'],
                [
                    'Judul' => $detail->Judul,
                    'Deskripsi' => $detail->Deskripsi,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('✅ Data existing berhasil dimigrate ke tabel translations.');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $translations = [
            '1990' => [
                'Keterangan' => 'SEJAK 1990',
                'KeteranganEn' => 'SINCE 1990',
                'KontenEn' => '1990',
            ],
            '800' => [
                'Keterangan' => 'LEBIH DARI 800 KARYAWAN',
                'KeteranganEn' => 'OVER 800 EMPLOYEES',
                'KontenEn' => '800',
            ],
            '100' => [
                'Keterangan' => 'Dipercaya Lebih Dari 100 Institusi Pemerintah',
                'KeteranganEn' => 'Trusted By Over 100 Government Institutions',
                'KontenEn' => '100',
            ],
            '80' => [
                'Keterangan' => 'Dipercaya Lebih Dari 80 Bank',
                'KeteranganEn' => 'Trusted By Over 80 Banks',
                'KontenEn' => '80',
            ],
            '9' => [
                'Keterangan' => '9x Pengakuan oleh Forbes Indonesia & Asia',
                'KeteranganEn' => '9x Recognition by Forbes Indonesia & Asia',
                'KontenEn' => '9',
            ],
        ];

        foreach ($translations as $konten => $data) {
            DB::table('key_figures')
                ->where('Konten', $konten)
                ->update($data);
        }

        Cache::forget('key_figures');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to English default if rolled back
        DB::table('key_figures')->where('Konten', '1990')->update(['Keterangan' => 'SINCE 1990']);
        DB::table('key_figures')->where('Konten', '800')->update(['Keterangan' => 'OVER 800 EMPLOYEES']);
        DB::table('key_figures')->where('Konten', '100')->update(['Keterangan' => 'Trusted By Over 100 Government Institutions']);
        DB::table('key_figures')->where('Konten', '80')->update(['Keterangan' => 'Trusted By Over 80 Banks']);
        DB::table('key_figures')->where('Konten', '9')->update(['Keterangan' => '9x recognition by Forbes Indonesia & Asia']);

        Cache::forget('key_figures');
    }
};

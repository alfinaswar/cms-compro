<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
            LandingPageSeeder::class,
            InvestorPagesSeeder::class,
            LaporanKeuanganSeeder::class,
            RingkasanKinerjaKeuanganSeeder::class,
        ]);
    }
}

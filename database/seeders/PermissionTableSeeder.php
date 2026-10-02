<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Format: modul.aksi
     * Jika nama modul 2 kata → gunakan "-" (contoh: kotak-masuk.view, tentang-kami.view)
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            // Navigasi Utama
            'dashboard.view',

            // Komunikasi & Transaksi — Kontak & RFQ
            'kotak-masuk.view',
            'kotak-masuk.create',
            'kotak-masuk.edit',
            'kotak-masuk.delete',
            'pengaturan-form-kontak.view',
            'pengaturan-form-kontak.create',
            'pengaturan-form-kontak.edit',
            'pengaturan-form-kontak.delete',

            // Publikasi & Berita — News & Artikel
            'berita.view',
            'berita.create',
            'berita.edit',
            'berita.delete',
            'kategori-berita.view',
            'kategori-berita.create',
            'kategori-berita.edit',
            'kategori-berita.delete',

            // Manajemen Portal & Web — Manajemen Konten
            'homepage.view',
            'homepage.create',
            'homepage.edit',
            'homepage.delete',
            'tentang-kami.view',
            'tentang-kami.create',
            'tentang-kami.edit',
            'tentang-kami.delete',
            'solusi.view',
            'solusi.create',
            'solusi.edit',
            'solusi.delete',
            'investor.view',
            'investor.create',
            'investor.edit',
            'investor.delete',
            'kebijakan-privasi.view',
            'kebijakan-privasi.create',
            'kebijakan-privasi.edit',
            'kebijakan-privasi.delete',
            'syarat-ketentuan.view',
            'syarat-ketentuan.create',
            'syarat-ketentuan.edit',
            'syarat-ketentuan.delete',

            // Kelola Halaman
            'kelola-halaman.view',
            'kelola-halaman.create',
            'kelola-halaman.edit',
            'kelola-halaman.delete',

            // Menu & Navigasi
            'menu.view',
            'menu.create',
            'menu.edit',
            'menu.delete',

            // Karir & Rekrutmen
            'karir.view',
            'karir.create',
            'karir.edit',
            'karir.delete',

            // Sistem & Pengaturan — Manajemen Akun
            'users.view',
            'users.create',
            'users.edit',
            'users.delete',
            'roles.view',
            'roles.create',
            'roles.edit',
            'roles.delete',
            'permissions.view',
            'permissions.create',
            'permissions.edit',
            'permissions.delete',

            // Setting Sistem
            'pengaturan-website.view',
            'pengaturan-website.create',
            'pengaturan-website.edit',
            'pengaturan-website.delete',
            'informasi-kantor.view',
            'informasi-kantor.create',
            'informasi-kantor.edit',
            'informasi-kantor.delete',

            // Log Aktivitas
            'log-aktivitas.view',

            // Landing Page — Komponen Landing Page
            'struktur-organisasi.view',
            'struktur-organisasi.create',
            'struktur-organisasi.edit',
            'struktur-organisasi.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

        // Sync semua permission ke role Admin (jika sudah ada)
        $adminRole = Role::where('name', 'Admin')->first();
        if ($adminRole) {
            $adminRole->syncPermissions(Permission::all());
        }
    }
}

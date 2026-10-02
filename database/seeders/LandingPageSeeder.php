<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use App\Models\PengaturanWebsite;
use App\Models\HeroSlider;
use App\Models\KeyFigures;
use App\Models\Menu;
use App\Models\MenuTranslation;
use App\Models\HalamanSolusi;
use App\Models\WhyChooseUs;
use App\Models\ClientLogo;

class LandingPageSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Schema guard for HeroSlider
        if (!Schema::hasColumn('hero_sliders', 'TipeMedia')) {
            Schema::table('hero_sliders', function (Blueprint $table) {
                $table->string('TipeMedia')->default('video')->after('Id');
            });
        }
        if (!Schema::hasColumn('hero_sliders', 'Deskripsi')) {
            Schema::table('hero_sliders', function (Blueprint $table) {
                $table->text('Deskripsi')->nullable()->after('JudulUtama');
            });
        }

        // 2. Pengaturan Website
        $settings = PengaturanWebsite::first() ?? new PengaturanWebsite();
        $settings->NamaPerusahaan = 'PT Jasuindo Tiga Perkasa Tbk';
        $settings->NamaSingkat = 'Jasuindo';
        $settings->TaglineWebsite = 'Transformasi Digital Identitas & Pembayaran Nasional';
        $settings->DeskripsiSingkat = 'Perusahaan percetakan keamanan terkemuka di Indonesia untuk dokumen sekuriti & solusi identitas.';
        $settings->PathLogo = 'pengaturan/jXR2qW8qCnLMq8361itfHjUvCjLwOnL2JB7C2foO.png';
        $settings->NomorTelepon = '(021) 526-1020';
        $settings->AlamatEmail = 'corsec@jasuindo.com';
        $settings->AlamatKantor = 'Jl. Raya Betro No. 21, Sedati, Sidoarjo 61253';
        $settings->Kota = 'Sidoarjo';
        $settings->Provinsi = 'Jawa Timur';
        $settings->Negara = 'Indonesia';
        $settings->save();

        // 3. Hero Slider
        if (HeroSlider::count() === 0) {
            HeroSlider::create([
                'SubJudul' => 'INNOVATION & INTEGRITY',
                'JudulUtama' => 'The Fastest Growing Identity & Payment Company In Asia',
                'Deskripsi' => 'In an industry that demands absolute accuracy, precision, and integrity, Jasuindo integrates modern security technology, precise printing, and intelligent quality control to safeguard the sovereignty of identity and public trust.',
                'TipeMedia' => 'video',
                'Video' => 'hero-sliders/videos/nu0XfjSiAn81aOdGrUyV9RJIEMChPoEtuYVwpBd6.mp4',
                'TeksCTA' => 'View Our Solution',
                'LinkCTA' => 'https://jasuindo.com/',
                'Urutan' => 1,
                'Status' => 1,
                'UserCreate' => 'System',
            ]);
        }

        // 4. Key Figures
        if (KeyFigures::count() === 0) {
            $figures = [
                ['Konten' => '1990', 'Keterangan' => 'SINCE 1990', 'Icon' => 'key-figures/icons/5d1AT7lVxLnCtV9KceCcKzaBlcbXHjF41wDTBuhd.png'],
                ['Konten' => '800', 'Keterangan' => 'OVER 800 EMPLOYEES', 'Icon' => 'key-figures/icons/1K3gsnjK3V3a2wuFSuOlfMs1MknPcaUlvj7nSv9b.png'],
                ['Konten' => '100', 'Keterangan' => 'Trusted By Over 100 Government Institutions', 'Icon' => 'key-figures/icons/epEM0RtuRcxVzNKxyZ81egdvIMZ7n3mTvL6GDUb0.png'],
                ['Konten' => '80', 'Keterangan' => 'Trusted By Over 80 Banks', 'Icon' => 'key-figures/icons/3IzDvurNPxvXeqwErSe4sPptEJJUOwnhCYRol5fH.png'],
                ['Konten' => '9', 'Keterangan' => '9x recognition by Forbes Indonesia & Asia', 'Icon' => 'key-figures/icons/QfpA2bFxnwyADHgkJai6YD15VyghprIQwAyU4Q8s.png'],
            ];
            foreach ($figures as $f) {
                $f['UserCreate'] = 'System';
                KeyFigures::create($f);
            }
        }

        // 5. Header Menus
        if (Menu::count() === 0) {
            $m1 = Menu::create(['NamaMenu' => 'Homepage', 'SlugMenu' => 'homepage', 'JenisLink' => 'custom', 'Url' => '/', 'Urutan' => 1, 'StatusAktif' => 1, 'TampilkanDiHeader' => 1]);
            MenuTranslation::create(['MenuId' => $m1->id, 'Locale' => 'id', 'NamaMenu' => 'Beranda']);
            MenuTranslation::create(['MenuId' => $m1->id, 'Locale' => 'en', 'NamaMenu' => 'Homepage']);

            $m2 = Menu::create(['NamaMenu' => 'About Us', 'SlugMenu' => 'about-us', 'JenisLink' => 'custom', 'Url' => 'about-us', 'Urutan' => 2, 'StatusAktif' => 1, 'TampilkanDiHeader' => 1]);
            MenuTranslation::create(['MenuId' => $m2->id, 'Locale' => 'id', 'NamaMenu' => 'Tentang Kami']);
            MenuTranslation::create(['MenuId' => $m2->id, 'Locale' => 'en', 'NamaMenu' => 'About Us']);

            $m3 = Menu::create(['NamaMenu' => 'Solution', 'SlugMenu' => 'solution', 'JenisLink' => 'custom', 'Url' => '#', 'Urutan' => 3, 'StatusAktif' => 1, 'TampilkanDiHeader' => 1]);
            MenuTranslation::create(['MenuId' => $m3->id, 'Locale' => 'id', 'NamaMenu' => 'Solusi']);
            MenuTranslation::create(['MenuId' => $m3->id, 'Locale' => 'en', 'NamaMenu' => 'Solution']);

            $subSolutions = [
                ['name_en' => 'Payment', 'name_id' => 'Pembayaran', 'url' => 'https://demo2.indotambangmitraenergi.co.id/admin/pengaturan/landing-page/solusi/show/pembayaran'],
                ['name_en' => 'Identity', 'name_id' => 'Identitas', 'url' => 'https://demo2.indotambangmitraenergi.co.id/admin/pengaturan/landing-page/solusi/show/identitas'],
                ['name_en' => 'Pasport', 'name_id' => 'Paspor', 'url' => 'https://jasuindo.com/id/solution/identity/passports'],
                ['name_en' => 'Brand Protection', 'name_id' => 'Perlindungan Merek', 'url' => 'https://demo2.indotambangmitraenergi.co.id/admin/pengaturan/landing-page/solusi/show/perlindungan-merek'],
                ['name_en' => 'Commercial Printing', 'name_id' => 'Percetakan Komersil', 'url' => 'https://demo2.indotambangmitraenergi.co.id/admin/pengaturan/landing-page/solusi/show/percetakan-komersil'],
            ];

            $u = 1;
            foreach ($subSolutions as $sub) {
                $subM = Menu::create([
                    'ParentId' => $m3->id,
                    'NamaMenu' => $sub['name_en'],
                    'SlugMenu' => Str::slug($sub['name_en']),
                    'JenisLink' => 'custom',
                    'Url' => $sub['url'],
                    'Urutan' => $u++,
                    'StatusAktif' => 1,
                    'TampilkanDiHeader' => 1,
                ]);
                MenuTranslation::create(['MenuId' => $subM->id, 'Locale' => 'id', 'NamaMenu' => $sub['name_id']]);
                MenuTranslation::create(['MenuId' => $subM->id, 'Locale' => 'en', 'NamaMenu' => $sub['name_en']]);
            }

            $m4 = Menu::create(['NamaMenu' => 'Investor', 'SlugMenu' => 'investor', 'JenisLink' => 'custom', 'Url' => 'laporan-keuangan', 'Urutan' => 4, 'StatusAktif' => 1, 'TampilkanDiHeader' => 1]);
            MenuTranslation::create(['MenuId' => $m4->id, 'Locale' => 'id', 'NamaMenu' => 'Investor']);
            MenuTranslation::create(['MenuId' => $m4->id, 'Locale' => 'en', 'NamaMenu' => 'Investor']);

            $m5 = Menu::create(['NamaMenu' => 'News', 'SlugMenu' => 'news', 'JenisLink' => 'custom', 'Url' => 'news', 'Urutan' => 5, 'StatusAktif' => 1, 'TampilkanDiHeader' => 1]);
            MenuTranslation::create(['MenuId' => $m5->id, 'Locale' => 'id', 'NamaMenu' => 'Berita']);
            MenuTranslation::create(['MenuId' => $m5->id, 'Locale' => 'en', 'NamaMenu' => 'News']);
        }

        // 6. Solusi
        if (HalamanSolusi::count() === 0) {
            $solusis = [
                ['Judul' => 'Pembayaran', 'Slug' => 'pembayaran', 'DeskripsiSingkat' => 'Solusi aman dari perancangan hingga implementasi.', 'Thumbnail' => 'halaman-solusi/thumbnail/Rcu217gPDEejWT2sUBfpD0WD55tcXXA0x9JB8NI3.jpg', 'IsPublished' => 1],
                ['Judul' => 'Identitas', 'Slug' => 'identitas', 'DeskripsiSingkat' => 'Solusi teknologi identitas terdepan untuk pemerintah dan korporasi.', 'Thumbnail' => 'halaman-solusi/thumbnail/ugDPotJZAbyeo3rMpsIFpJVa2c78SCI906u357zP.jpg', 'IsPublished' => 1],
                ['Judul' => 'Perlindungan Merek', 'Slug' => 'perlindungan-merek', 'DeskripsiSingkat' => 'Teknologi anti-pemalsuan mutakhir untuk perlindungan produk.', 'Thumbnail' => 'halaman-solusi/thumbnail/OzY3R1UDHcqN4ThNKlUEAY15uHgPpTfJSqxiQlv2.jpg', 'IsPublished' => 1],
                ['Judul' => 'Percetakan Komersil', 'Slug' => 'percetakan-komersil', 'DeskripsiSingkat' => 'Solusi cetak dokumen skala besar berstandar keamanan tinggi.', 'Thumbnail' => 'halaman-solusi/thumbnail/j83aYuGkVK2pDHGntfatf3a2SconzkdoO7TUsydx.jpg', 'IsPublished' => 1],
            ];
            foreach ($solusis as $s) {
                $s['UserCreate'] = 'System';
                HalamanSolusi::create($s);
            }
        }

        // 7. Why Choose Us
        if (WhyChooseUs::count() === 0) {
            $whys = [
                ['Judul' => 'Sebuah Pendekatan Unik', 'Deskripsi' => 'Kami menempatkan pelanggan sebagai inti dari perkembangan perusahaan.', 'Urutan' => 1, 'Status' => 1],
                ['Judul' => 'Penelitian & Pengembangan', 'Deskripsi' => 'Bersama Toppan dan iDGate, kami terus menginovasikan solusi keamanan.', 'Urutan' => 2, 'Status' => 1],
                ['Judul' => 'Rekam Jejak', 'Deskripsi' => 'Satu-satunya di Indonesia yang mengekspor produk pemerintah ke 15+ negara.', 'Urutan' => 3, 'Status' => 1],
                ['Judul' => 'Penghargaan & Sertifikasi', 'Deskripsi' => 'Diakui oleh Forbes Asia dan institusi internasional terkemuka.', 'Urutan' => 4, 'Status' => 1],
            ];
            foreach ($whys as $w) {
                WhyChooseUs::create($w);
            }
        }

        // 8. Client Logos
        if (ClientLogo::count() === 0) {
            $logos = [
                'client-logos/xUipddl5xhU7DQ8L2M6y3xr9GZ1PZi84TQoG9BoP.webp',
                'client-logos/ywGEZtldhvUI42T5dB8IkeXJIgQZXPoTIAxd3TGV.png',
                'client-logos/rNpCB1Q1s2lDagVm8S7KO1ElqWswjNwcKGDAoDVV.png',
                'client-logos/yvKYKm9QjXw2htpJxjsYhrSbQySaCKGnxNoHSpGE.webp',
                'client-logos/LyYCAPCVgpfAfXa5wdQLHMKbV3MYY6FqnovQhRCg.webp',
            ];
            $u = 1;
            foreach ($logos as $l) {
                ClientLogo::create([
                    'NamaPartner' => 'Mitra ' . $u,
                    'PathLogo' => $l,
                    'UrlWebsite' => 'https://jasuindo.com',
                    'Tipe' => 'Partner',
                    'Urutan' => $u++,
                    'Status' => 'Aktif',
                    'UserCreate' => 'System',
                ]);
            }
        }
    }
}

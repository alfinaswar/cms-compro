<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContentRevisionTest extends TestCase
{
    /**
     * Test 1: Homepage (ID & EN)
     */
    public function test_homepage_content_labels(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        // ID
        $resId = $this->get('/id/');
        $resId->assertStatus(200);
        $resId->assertSee('Perusahaan Berbasis Teknologi');
        $resId->assertSee('Mengapa Memilih Kami?');
        $resId->assertSee('Produk fisik dengan fitur pengaman');
        $resId->assertSee('Layanan kami');
        $resId->assertSee('Kami Hadirkan Fitur Pengaman Disetiap Lapisan');
        $resId->assertSee('Keamanan Berlapis');
        $resId->assertSee('Berita dan pengetahuan terbaru');
        $resId->assertSee('kabar terbaru');
        $resId->assertSee('Temukan solusi yang tepat untuk Anda');
        $resId->assertSee('permintaan penawaran atau informasi');

        // EN
        $resEn = $this->get('/en/');
        $resEn->assertStatus(200);
        $resEn->assertSee('Technology-Driven Company');
        $resEn->assertSee('Why Choose Us?');
        $resEn->assertSee('Physical Security Products');
        $resEn->assertSee('Our Services');
        $resEn->assertSee('We Build Security Into Every Layer');
        $resEn->assertSee('Multi-Layer Security');
        $resEn->assertSee('Latest News &amp; Insights', false);
        $resEn->assertSee('Latest updates');
        $resEn->assertSee("Let&#039;s Find the Right Solution for You", false);
        $resEn->assertSee('Quotation &amp; Information Request', false);
    }

    /**
     * Test 2: Informasi Finansial (ID & EN)
     */
    public function test_informasi_finansial_content_labels(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        // ID
        $resId = $this->get('/id/laporan-investor/informasi-finansial/');
        $resId->assertStatus(200);
        $resId->assertSee('Struktur Kepemilikan Perusahaan Publik');
        $resId->assertSee('Klasifikasi Kepemilikan Saham Perusahaan');
        $resId->assertSee('Entitas Anak dan Perusahaan Asosiasi');
        $resId->assertSee('Entitas anak serta Persentase Kepemilikan');

        // EN
        $resEn = $this->get('/en/investor-relations/financial-information/');
        $resEn->assertStatus(200);
        $resEn->assertSee('Public Company Ownership Structure');
        $resEn->assertSee('Classification of Company Share Ownership');
        $resEn->assertSee('Subsidiaries and Associated Companies');
        $resEn->assertSee('The Subsidiaries and the Percentage of Ownership');
    }

    /**
     * Test 3: Tata Kelola (ID & EN)
     */
    public function test_tata_kelola_content_labels(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        // ID
        $resId = $this->get('/id/laporan-investor/tata-kelola-perusahaan/');
        $resId->assertStatus(200);
        $resId->assertSee('Manajemen');
        $resId->assertSee('Komposisi Manajemen Perusahaan');
        $resId->assertSee('Piagam');
        $resId->assertSee('Dokumen Tata Kelola Perusahaan');
        $resId->assertSee('Rapat Umum Pemegang Saham (RUPS)');
        $resId->assertSee('Informasi Rapat Umum Pemegang Saham Tahunan dan Luar Biasa');
        $resId->assertSee('Kebijakan Perusahaan');
        $resId->assertSee('Komite Audit');
        $resId->assertSee('Mekanisme sistem pelaporan pelanggaran');

        // EN
        $resEn = $this->get('/en/investor-relations/corporate-governance/');
        $resEn->assertStatus(200);
        $resEn->assertSee('Management');
        $resEn->assertSee('Composition of Company Management');
        $resEn->assertSee('Charter');
        $resEn->assertSee('Governance Documents');
        $resEn->assertSee('General Meeting of Shareholders');
        $resEn->assertSee('Information of Annual and Extraordinary General Meeting of Shareholders');
        $resEn->assertSee('Company Policy');
        $resEn->assertSee('Audit Committee');
        $resEn->assertSee('Whistleblowing System (WBS) Mechanism');
    }

    /**
     * Test 4: Informasi Lainnya (ID & EN)
     */
    public function test_informasi_lainnya_content_labels(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        // ID
        $resId = $this->get('/id/laporan-investor/informasi-lainnya/');
        $resId->assertStatus(200);
        $resId->assertSee('Profesional Independen');
        $resId->assertSee('Lembaga Profesi Penunjang Pasar Modal');
        $resId->assertSee('Informasi Investor');
        $resId->assertSee('Keterbukaan Informasi dan Pengumuman Material');

        // EN
        $resEn = $this->get('/en/investor-relations/other-information/');
        $resEn->assertStatus(200);
        $resEn->assertSee('Independent Professional');
        $resEn->assertSee('Capital Market Supporting Institutions Professions');
        $resEn->assertSee('Investor Information');
        $resEn->assertSee('Disclosure of Information or Material Facts');
    }

    /**
     * Test 5: Berita (ID & EN)
     */
    public function test_berita_content_labels(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        // ID
        $resId = $this->get('/id/berita/');
        $resId->assertStatus(200);
        $resId->assertSee('Berita dan pengetahuan terbaru');
        $resId->assertSee('kabar terbaru');

        // EN
        $resEn = $this->get('/en/news/');
        $resEn->assertStatus(200);
        $resEn->assertSee('Latest News &amp; Insights', false);
        $resEn->assertSee('Latest updates');
    }

    /**
     * Test 6: Hubungi Kami (ID & EN)
     */
    public function test_hubungi_kami_content_labels(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        // ID
        $resId = $this->get('/id/hubungi-kami/');
        $resId->assertStatus(200);
        $resId->assertSee('Temukan solusi yang tepat untuk Anda');
        $resId->assertSee('Hubungi Kami');
        $resId->assertSee('Informasi detail kontak');
        $resId->assertSee('Kontak');
        $resId->assertSee('Hubungi kami - Ada pertanyaan atau membutuhkan penawaran harga? Kirimkan pesan kepada kami.');
        $resId->assertSee('Lokasi kami');
        $resId->assertSee('Temukan kami');

        // EN
        $resEn = $this->get('/en/contact-us/');
        $resEn->assertStatus(200);
        $resEn->assertSee("Let&#039;s Find the Right Solution for You", false);
        $resEn->assertSee('Contact us');
        $resEn->assertSee('Detail contact information');
        $resEn->assertSee('Contact');
        $resEn->assertSee('Get in Touch - Have a question or need a quotation? Send us a message.');
        $resEn->assertSee('Our locations');
        $resEn->assertSee('Find us');
    }

    /**
     * Test 7: Solusi (ID & EN)
     */
    public function test_solusi_content_labels(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        $solusi = \App\Models\HalamanSolusi::where('IsPublished', true)->first();
        if (!$solusi) {
            $this->markTestSkipped('No published HalamanSolusi found');
        }

        // ID
        $resId = $this->get('/id/solusi/' . $solusi->Slug . '/');
        $resId->assertStatus(200);
        $resId->assertSee('Ringkasan');
        $resId->assertSee('Produk dan Solusi yang Sesuai dengan Kebutuhan Anda');
        $resId->assertSee('keahlian kami');
        $resId->assertSee('Pertanyaan yang Sering Diajukan');
        $resId->assertSee('FAQ &amp; Basis Pengetahuan', false);
        $resId->assertSee('Tertarik dengan Solusi Ini?');
        $resId->assertSee('Mari Berkolaborasi');

        // EN
        $resEn = $this->get('/en/solutions/' . $solusi->Slug . '/');
        $resEn->assertStatus(200);
        $resEn->assertSee('Overview');
        $resEn->assertSee('Products &amp; Solutions That Meet Your Needs', false);
        $resEn->assertSee('Our specialty');
        $resEn->assertSee('Frequently Asked Questions (FAQ)');
        $resEn->assertSee('FAQ &amp; Knowledge Base', false);
        $resEn->assertSee('Interested in This Solution?');
        $resEn->assertSee('Let&#039;s Collaborate', false);
    }

    /**
     * Test 8: Featured Article thumbnail on Homepage
     */
    public function test_homepage_featured_article_renders_thumbnail(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        $featured = \App\Models\Berita::where('Status', 'Diterbitkan')
            ->latest('TanggalPublikasi')
            ->first();

        if (
            !$featured ||
            empty($featured->PathThumbnail) ||
            !\Illuminate\Support\Facades\Storage::disk('public')->exists($featured->PathThumbnail)
        ) {
            $this->markTestSkipped('No published Berita with existing PathThumbnail found');
        }

        $res = $this->get('/id/');
        $res->assertStatus(200);
        $res->assertSee('<img src="' . asset('storage/' . $featured->PathThumbnail) . '"', false);
    }

    /**
     * Test 9: About page button icons sit on the right side of text
     */
    public function test_about_page_button_icons_are_positioned_on_right(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        $resId = $this->get('/id/tentang-kami/');
        $resId->assertStatus(200);
        $htmlId = $resId->getContent();

        $this->assertMatchesRegularExpression('/Unduh Profil\s*<i class="fa-solid fa-download ml-2"><\/i>/', $htmlId);
        $this->assertMatchesRegularExpression('/<span>Kirim &amp; Unduh Dokumen<\/span>\s*<i class="fa-solid fa-download text-xs"><\/i>/', $htmlId);
        $this->assertMatchesRegularExpression('/<span>Memproses\.\.\.<\/span>\s*<i class="fa-solid fa-spinner fa-spin"><\/i>/', $htmlId);
        $this->assertDoesNotMatchRegularExpression('/<a\b[^>]*>\s*<i class="fa-regular fa-file-lines/', $htmlId);

        if (preg_match('/<!-- 7\. CTA -->(.*?)<\/section>/s', $htmlId, $ctaMatch)) {
            $this->assertDoesNotMatchRegularExpression('/<a\b[^>]*>\s*<i\b/', $ctaMatch[1]);
        } else {
            $this->fail('CTA section not found in About page HTML');
        }

        $resEn = $this->get('/en/about-us/');
        $resEn->assertStatus(200);
        $htmlEn = $resEn->getContent();

        $this->assertMatchesRegularExpression('/Download Profile\s*<i class="fa-solid fa-download ml-2"><\/i>/', $htmlEn);
        $this->assertMatchesRegularExpression('/<span>Submit &amp; Download File<\/span>\s*<i class="fa-solid fa-download text-xs"><\/i>/', $htmlEn);
    }

    /**
     * Test 10: Solusi page "Back to Solutions" scrolls to top and never links to admin
     */
    public function test_solusi_back_button_scrolls_to_top_and_no_admin_link(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        $solusi = \App\Models\HalamanSolusi::where('IsPublished', true)->first();
        if (!$solusi) {
            $this->markTestSkipped('No published HalamanSolusi found');
        }

        // ID
        $resId = $this->get('/id/solusi/' . $solusi->Slug . '/');
        $resId->assertStatus(200);
        $resId->assertDontSee('landing-page/solusi/', false);
        if (preg_match('/<!-- Breadcrumb -->\s*<nav\b[^>]*>(.*?)<\/nav>/s', $resId->getContent(), $bcId)) {
            $this->assertStringContainsString('<span>Solusi</span>', $bcId[1]);
            $this->assertDoesNotMatchRegularExpression('/<a\b[^>]*>\s*Solusi\s*<\/a>/', $bcId[1]);
        } else {
            $this->fail('Breadcrumb nav not found in ID Solusi page');
        }
        $this->assertMatchesRegularExpression(
            '/<button\s+type="button"\s+onclick="window\.scrollTo\(\{\s*top:\s*0,\s*behavior:\s*\'smooth\'\s*\}\)"[^>]*>.*?Kembali ke Solusi\s*<\/button>/s',
            $resId->getContent()
        );

        // EN
        $resEn = $this->get('/en/solutions/' . $solusi->Slug . '/');
        $resEn->assertStatus(200);
        $resEn->assertDontSee('landing-page/solusi/', false);
        if (preg_match('/<!-- Breadcrumb -->\s*<nav\b[^>]*>(.*?)<\/nav>/s', $resEn->getContent(), $bcEn)) {
            $this->assertStringContainsString('<span>Solutions</span>', $bcEn[1]);
            $this->assertDoesNotMatchRegularExpression('/<a\b[^>]*>\s*Solutions\s*<\/a>/', $bcEn[1]);
        } else {
            $this->fail('Breadcrumb nav not found in EN Solusi page');
        }
        $this->assertMatchesRegularExpression(
            '/<button\s+type="button"\s+onclick="window\.scrollTo\(\{\s*top:\s*0,\s*behavior:\s*\'smooth\'\s*\}\)"[^>]*>.*?Back to Solutions\s*<\/button>/s',
            $resEn->getContent()
        );

        // Subpage (jika ada) juga memakai breadcrumb Solusi non-clickable
        $subpage = \App\Models\HalamanSolusiSubpage::where('IsPublished', true)
            ->whereHas('detail.solusi', fn ($q) => $q->where('IsPublished', true))
            ->with('detail.solusi')
            ->first();
        if ($subpage) {
            $parentSlug = $subpage->detail->solusi->Slug;
            $resSub = $this->get('/id/solusi/' . $parentSlug . '/' . $subpage->Slug . '/');
            $resSub->assertStatus(200);
            if (preg_match('/<!-- Breadcrumb -->\s*<nav\b[^>]*>(.*?)<\/nav>/s', $resSub->getContent(), $bcSub)) {
                $this->assertStringContainsString('<span>Solusi</span>', $bcSub[1]);
                $this->assertDoesNotMatchRegularExpression('/<a\b[^>]*>\s*Solusi\s*<\/a>/', $bcSub[1]);
            } else {
                $this->fail('Breadcrumb nav not found in Solusi subpage');
            }
        }
    }

    /**
     * Test 11: Frontend desktop typography enforces min 16px & 1.4em line-height except situational subheadlines, eyebrows, and small badges
     */
    public function test_frontend_desktop_typography_enforces_16px_and_14em_except_subheadlines_and_badges(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        $resHome = $this->get('/id/');
        $resHome->assertStatus(200);
        $homeHtml = $resHome->getContent();

        $resHome->assertDontSee('@import "tailwindcss";', false);
        $this->assertMatchesRegularExpression('/@media\s*\(\s*min-width:\s*1024px\s*\)/', $homeHtml);
        $this->assertStringContainsString('.text-\\[10px\\]', $homeHtml);
        $this->assertStringContainsString(':not(.subheadline)', $homeHtml);
        $this->assertStringContainsString(':not([class*="uppercase"][class*="tracking-"])', $homeHtml);
        $this->assertStringContainsString(':not(span.rounded-full)', $homeHtml);
        $this->assertMatchesRegularExpression('/font-size:\s*16px\s*!important;\s*line-height:\s*1\.4em\s*!important;/s', $homeHtml);

        $resAbout = $this->get('/id/tentang-kami/');
        $resAbout->assertStatus(200);
        $resAbout->assertDontSee('.text-[10px],', false);

        $resContact = $this->get('/id/hubungi-kami/');
        $resContact->assertStatus(200);
        $resContact->assertDontSee('font-size: 0.875rem !important;', false);
    }

    /**
     * Test 12: Multi-language localized routes and translations
     */
    public function test_multilanguage_urls_and_translations(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        // LocalizedUrlService route resolution
        $this->assertStringEndsWith('/id/hubungi-kami/', \App\Services\LocalizedUrlService::route('frontend.contact.index', [], 'id'));
        $this->assertStringEndsWith('/en/contact-us/', \App\Services\LocalizedUrlService::route('frontend.contact.index', [], 'en'));
        $this->assertStringEndsWith('/id/halaman/profil-kami/', \App\Services\LocalizedUrlService::route('frontend.halaman-custom', ['slug' => 'profil-kami'], 'id'));
        $this->assertStringEndsWith('/en/page/profil-kami/', \App\Services\LocalizedUrlService::route('frontend.halaman-custom', ['slug' => 'profil-kami'], 'en'));
        $this->assertStringEndsWith('/en/page/profil-kami/', \App\Services\LocalizedUrlService::switchLocale('/id/halaman/profil-kami/', 'en'));
        $this->assertStringEndsWith('/id/halaman/profil-kami/', \App\Services\LocalizedUrlService::switchLocale('/en/page/profil-kami/', 'id'));

        // Other Information contact CTA points to canonical locale path
        $resOtherId = $this->get('/id/laporan-investor/informasi-lainnya/');
        $resOtherId->assertStatus(200);
        $resOtherId->assertSee('/id/hubungi-kami/');
        $resOtherId->assertSee('Dokumen Terarsip');

        $resOtherEn = $this->get('/en/investor-relations/other-information/');
        $resOtherEn->assertStatus(200);
        $resOtherEn->assertSee('/en/contact-us/');

        // Financial Reports & Information EN labels
        $resInvEn = $this->get('/en/investor-relations/');
        $resInvEn->assertStatus(200);
        $resInvEn->assertSee('Prospectus');
        $resInvEn->assertSee('COMPREHENSIVE INCOME STATEMENT (MILLION IDR)');

        $resFinEn = $this->get('/en/investor-relations/financial-information/');
        $resFinEn->assertStatus(200);
        $resFinEn->assertSee('Entity Name');
        $resFinEn->assertSee('Domestic Investors');

        // About EN JS processing text
        $resAboutEn = $this->get('/en/about-us/');
        $resAboutEn->assertStatus(200);
        $resAboutEn->assertSee('<span>Processing...</span>', false);

        // Language JSON files are valid and have no duplicate keys
        foreach ([base_path('lang/en.json'), base_path('lang/id.json')] as $langFile) {
            $raw = file_get_contents($langFile);
            $decoded = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
            $this->assertNotEmpty($decoded);
            preg_match_all('/^\s*"((?:\\\\.|[^"\\\\])*)"\s*:/m', $raw, $matches);
            $this->assertSame(count($matches[1]), count(array_unique($matches[1])), "Duplicate keys found in {$langFile}");
        }
    }
}

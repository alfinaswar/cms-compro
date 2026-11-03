<?php

namespace Tests\Feature;

use Tests\TestCase;

class InvestorTataKelolaTest extends TestCase
{
    public function test_tata_kelola_page_renders_successfully(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);
        $response = $this->get('/id/laporan-investor/tata-kelola-perusahaan/');
        $response->assertStatus(200);
        $response->assertViewHas('kantor');

        $kantor = $response->viewData('kantor');
        if ($kantor) {
            $expectedEmail = $kantor->HubunganInvestorEmail ?: ($kantor->AlamatEmail ?: null);
            if ($expectedEmail) {
                $response->assertSee($expectedEmail);
            }
        }
    }

    public function test_laporan_keuangan_page_renders_successfully(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);
        $response = $this->get('/id/laporan-investor/');
        $response->assertStatus(200);
        $response->assertSee('quarterYearSelect');
        $response->assertSee('annualYearSelect');
    }

    public function test_informasi_finansial_page_renders_successfully(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);
        $response = $this->get('/id/laporan-investor/informasi-finansial/');
        $response->assertStatus(200);
        $response->assertSee('kepemilikanBulanSelect');
        $response->assertSee('kepemilikanTahunSelect');
    }

    public function test_english_investor_relations_urls_render_successfully(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        $res1 = $this->get('/en/investor-relations/');
        $res1->assertStatus(200);

        $res2 = $this->get('/en/investor-relations/financial-information/');
        $res2->assertStatus(200);

        $res3 = $this->get('/en/investor-relations/corporate-governance/');
        $res3->assertStatus(200);

        $res4 = $this->get('/en/investor-relations/other-information/');
        $res4->assertStatus(200);
    }

    public function test_news_and_berita_urls_render_successfully(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        $resId = $this->get('/id/berita/');
        $resId->assertStatus(200);

        $resEn = $this->get('/en/news/');
        $resEn->assertStatus(200);
    }

    public function test_canonical_redirects_for_cross_locale_urls(): void
    {
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        // Akses URL Indonesia di prefix EN harus redirect 301 ke URL EN
        $res1 = $this->get('/en/laporan-investor/');
        $res1->assertStatus(301);
        $res1->assertRedirect('/en/investor-relations/');

        // Akses URL News di prefix ID harus redirect 301 ke URL Berita
        $res2 = $this->get('/id/news/');
        $res2->assertStatus(301);
        $res2->assertRedirect('/id/berita/');
    }

    public function test_localized_url_service_switcher_mapping(): void
    {
        // Investor Relations Switcher Mapping
        $enInvestor = \App\Services\LocalizedUrlService::switchLocale('id/laporan-investor/informasi-finansial', 'en');
        $this->assertStringContainsString('/en/investor-relations/financial-information/', $enInvestor);

        $idInvestor = \App\Services\LocalizedUrlService::switchLocale('en/investor-relations/corporate-governance', 'id');
        $this->assertStringContainsString('/id/laporan-investor/tata-kelola-perusahaan/', $idInvestor);

        // News / Berita Switcher Mapping
        $enNews = \App\Services\LocalizedUrlService::switchLocale('id/berita/artikel-pertama', 'en');
        $this->assertStringContainsString('/en/news/artikel-pertama/', $enNews);

        $idNews = \App\Services\LocalizedUrlService::switchLocale('en/news/artikel-pertama', 'id');
        $this->assertStringContainsString('/id/berita/artikel-pertama/', $idNews);

        // Solutions / Solusi Switcher Mapping
        $enSolusi = \App\Services\LocalizedUrlService::switchLocale('id/solusi/smart-card', 'en');
        $this->assertStringContainsString('/en/solutions/smart-card/', $enSolusi);

        $idSolusi = \App\Services\LocalizedUrlService::switchLocale('en/solutions/smart-card', 'id');
        $this->assertStringContainsString('/id/solusi/smart-card/', $idSolusi);

        // Sitemap / Peta Situs Switcher Mapping
        $enSitemap = \App\Services\LocalizedUrlService::switchLocale('id/peta-situs', 'en');
        $this->assertStringContainsString('/en/sitemap/', $enSitemap);

        $idSitemap = \App\Services\LocalizedUrlService::switchLocale('en/sitemap', 'id');
        $this->assertStringContainsString('/id/peta-situs/', $idSitemap);
    }
}

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
        $resEn->assertSee('Perusahaan Berbasis Teknologi');
        $resEn->assertSee('Keamanan Tanpa Kompromi');
        $resEn->assertSee('Physical Security Products');
        $resEn->assertSee('Our Services');
        $resEn->assertSee('We Build Security Into Every Layer');
        $resEn->assertSee('Multi-Layer Security');
        $resEn->assertSee('Latest News &amp; knowledges', false);
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
        $resId->assertSee('Entitas anak serta Presentase Kepemilikan');

        // EN
        $resEn = $this->get('/en/investor-relations/financial-information/');
        $resEn->assertStatus(200);
        $resEn->assertSee('Public Company Ownership Structure');
        $resEn->assertSee('Classification of Company Share Ownership');
        $resEn->assertSee('Subsidiaries and Associated Companies');
        $resEn->assertSee('The Subsidiaries and the Precentage of Ownership');
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
        $resEn->assertSee('Latest News &amp; knowledges', false);
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
        $resId->assertSee('Hubungi kami - Ada pertanyaan atau membutuhkan penawaran harga? Kirimkan');
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
}

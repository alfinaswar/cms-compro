<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Berita;
use App\Models\LowonganKerja;
use App\Models\StaticPage;
use App\Models\CustomPage;
use App\Models\HalamanSolusi;
use App\Models\HalamanSolusiSubpage;
use App\Services\LocalizedUrlService;
use Illuminate\Support\Str;
use DateTimeInterface;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml with multi-language (ID & EN) support';

    /**
     * Helper: Ambil tanggal modifikasi terakhir yang pasti DateTimeInterface
     */
    protected function lastMod($model): DateTimeInterface
    {
        if (isset($model->updated_at) && $model->updated_at instanceof DateTimeInterface) {
            return $model->updated_at;
        }
        if (isset($model->created_at) && $model->created_at instanceof DateTimeInterface) {
            return $model->created_at;
        }
        return now();
    }

    /**
     * Helper: Tambahkan pasangan URL ID & EN lengkap dengan rel alternate hreflang
     */
    protected function addLocalizedPair(
        Sitemap $sitemap,
        string $idPath,
        string $enPath,
        DateTimeInterface $lastMod,
        string $frequency,
        float $priority
    ): void {
        $idUrl = url('/' . trim($idPath, '/') . '/');
        $enUrl = url('/' . trim($enPath, '/') . '/');

        $sitemap->add(
            Url::create($idUrl)
                ->setLastModificationDate($lastMod)
                ->setChangeFrequency($frequency)
                ->setPriority($priority)
                ->addAlternate($idUrl, 'id')
                ->addAlternate($enUrl, 'en')
        );

        $sitemap->add(
            Url::create($enUrl)
                ->setLastModificationDate($lastMod)
                ->setChangeFrequency($frequency)
                ->setPriority($priority)
                ->addAlternate($idUrl, 'id')
                ->addAlternate($enUrl, 'en')
        );
    }

    public function handle()
    {
        $sitemap = Sitemap::create();
        $now = now();
        $today = $now->toDateString();

        // 1. Beranda / Homepage
        $this->addLocalizedPair($sitemap, 'id', 'en', $now, Url::CHANGE_FREQUENCY_DAILY, 1.0);

        // 2. Tentang Kami / About Us
        $this->addLocalizedPair($sitemap, 'id/tentang-kami', 'en/about-us', $now, Url::CHANGE_FREQUENCY_MONTHLY, 0.8);

        // 3. Hubungi Kami / Contact Us
        $this->addLocalizedPair($sitemap, 'id/hubungi-kami', 'en/contact-us', $now, Url::CHANGE_FREQUENCY_MONTHLY, 0.8);

        // 4. Berita / News Listing
        $this->addLocalizedPair($sitemap, 'id/berita', 'en/news', $now, Url::CHANGE_FREQUENCY_DAILY, 0.8);

        // 5. Karir / Careers Listing
        $this->addLocalizedPair($sitemap, 'id/karir', 'en/career', $now, Url::CHANGE_FREQUENCY_WEEKLY, 0.8);

        // 6. Hubungan Investor / Investor Relations (4 Tabs)
        $this->addLocalizedPair(
            $sitemap,
            'id/laporan-investor',
            'en/investor-relations',
            $now,
            Url::CHANGE_FREQUENCY_WEEKLY,
            0.8
        );
        $this->addLocalizedPair(
            $sitemap,
            'id/laporan-investor/informasi-finansial',
            'en/investor-relations/financial-information',
            $now,
            Url::CHANGE_FREQUENCY_WEEKLY,
            0.8
        );
        $this->addLocalizedPair(
            $sitemap,
            'id/laporan-investor/tata-kelola-perusahaan',
            'en/investor-relations/corporate-governance',
            $now,
            Url::CHANGE_FREQUENCY_MONTHLY,
            0.8
        );
        $this->addLocalizedPair(
            $sitemap,
            'id/laporan-investor/informasi-lainnya',
            'en/investor-relations/other-information',
            $now,
            Url::CHANGE_FREQUENCY_MONTHLY,
            0.7
        );

        // 7. Peta Situs / Sitemap
        $this->addLocalizedPair($sitemap, 'id/peta-situs', 'en/sitemap', $now, Url::CHANGE_FREQUENCY_MONTHLY, 0.5);

        // 8. Solusi / Solutions
        $solusis = HalamanSolusi::where('IsPublished', true)->get();
        foreach ($solusis as $solusi) {
            $lastMod = $this->lastMod($solusi);
            $this->addLocalizedPair(
                $sitemap,
                "id/solusi/{$solusi->Slug}",
                "en/solutions/{$solusi->Slug}",
                $lastMod,
                Url::CHANGE_FREQUENCY_WEEKLY,
                0.8
            );
        }

        // Subhalaman Solusi
        $subpages = HalamanSolusiSubpage::where('IsPublished', true)->with('detail.solusi')->get();
        foreach ($subpages as $sub) {
            if (!empty($sub->detail?->solusi?->Slug) && !empty($sub->Slug)) {
                $lastMod = $this->lastMod($sub);
                $parentSlug = $sub->detail->solusi->Slug;
                $this->addLocalizedPair(
                    $sitemap,
                    "id/solusi/{$parentSlug}/{$sub->Slug}",
                    "en/solutions/{$parentSlug}/{$sub->Slug}",
                    $lastMod,
                    Url::CHANGE_FREQUENCY_WEEKLY,
                    0.7
                );
            }
        }

        // 9. Berita / News Detail
        $berita = Berita::where('Status', 'Diterbitkan')->get();
        foreach ($berita as $item) {
            $lastMod = $this->lastMod($item);
            $this->addLocalizedPair(
                $sitemap,
                "id/berita/{$item->Slug}",
                "en/news/{$item->Slug}",
                $lastMod,
                Url::CHANGE_FREQUENCY_WEEKLY,
                0.8
            );
        }

        // 10. Lowongan Kerja / Careers Detail
        $lowongan = LowonganKerja::where('Status', 'Buka')
            ->where(function ($q) use ($today) {
                $q->whereNull('BatasWaktu')->orWhereDate('BatasWaktu', '>=', $today);
            })->get();
        foreach ($lowongan as $job) {
            $lastMod = $this->lastMod($job);
            $jobSlug = Str::slug($job->Posisi ?: 'lowongan');
            $this->addLocalizedPair(
                $sitemap,
                "id/karir/{$job->id}-{$jobSlug}",
                "en/career/{$job->id}-{$jobSlug}",
                $lastMod,
                Url::CHANGE_FREQUENCY_WEEKLY,
                0.8
            );
        }

        // 11. Halaman Statis / Static Pages
        $staticPages = StaticPage::where('IsPublished', true)->get();
        foreach ($staticPages as $page) {
            $lastMod = $this->lastMod($page);
            $enSlug = LocalizedUrlService::EXACT_MAP[$page->Slug] ?? $page->Slug;
            $this->addLocalizedPair(
                $sitemap,
                "id/{$page->Slug}",
                "en/{$enSlug}",
                $lastMod,
                Url::CHANGE_FREQUENCY_MONTHLY,
                0.6
            );
        }

        // 12. Custom Pages (jika model ada)
        if (class_exists(CustomPage::class)) {
            $customPages = CustomPage::where('IsPublished', true)->get();
            foreach ($customPages as $page) {
                $lastMod = $this->lastMod($page);
                $this->addLocalizedPair(
                    $sitemap,
                    "id/halaman/{$page->Slug}",
                    "en/page/{$page->Slug}",
                    $lastMod,
                    Url::CHANGE_FREQUENCY_MONTHLY,
                    0.6
                );
            }
        }

        // Simpan sitemap.xml ke public folder
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('✅ Sitemap berhasil di-generate: ' . public_path('sitemap.xml'));
        $this->info('📊 Total URL: ' . count($sitemap->getTags()));

        return Command::SUCCESS;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Berita;
use App\Models\LowonganKerja;
use App\Models\StaticPage;
use App\Models\CustomPage;
use Carbon\Carbon;
use DateTimeInterface;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate sitemap.xml';

    /**
     * ✅ HELPER: Ambil tanggal modifikasi terakhir yang PASTI DateTimeInterface (never null)
     * Fallback: updated_at -> created_at -> now()
     */
    protected function lastMod($model): DateTimeInterface
    {
        // Mulai dari updated_at, jika null ambil created_at, jika masih null -> now()
        if (isset($model->updated_at) && $model->updated_at instanceof DateTimeInterface) {
            return $model->updated_at;
        }
        if (isset($model->created_at) && $model->created_at instanceof DateTimeInterface) {
            return $model->created_at;
        }
        return now();
    }

    public function handle()
    {
        $sitemap = Sitemap::create();
        $today = now()->toDateString();

        // ✅ 1. Halaman Utama
        $sitemap->add(
            Url::create('/')
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                ->setPriority(1.0)
        );
        $sitemap->add(
            Url::create('/id/kontak')
                ->setLastModificationDate(now())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7)
        );

        // ✅ 2. Halaman Berita (yang sudah Diterbitkan)
        $berita = Berita::where('Status', 'Diterbitkan')->get();
        foreach ($berita as $item) {
            $lastMod = $this->lastMod($item); // Pastikan DateTimeInterface (bukan null)
            $sitemap->add(
                Url::create("/id/berita/{$item->Slug}")
                    ->setLastModificationDate($lastMod)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        }

        // ✅ 3. Lowongan Kerja (yang masih Buka)
        $lowongan = LowonganKerja::where('Status', 'Buka')
            ->where(function ($q) use ($today) {
                $q->whereNull('BatasWaktu')->orWhereDate('BatasWaktu', '>=', $today);
            })->get();
        foreach ($lowongan as $item) {
            $lastMod = $this->lastMod($item); // Pastikan DateTimeInterface (bukan null)
            $sitemap->add(
                Url::create("/id/karir/{$item->Slug}")
                    ->setLastModificationDate($lastMod)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        }

        // ✅ 4. Halaman Statis (Kebijakan Privasi, Syarat, dll)
        $staticPages = StaticPage::where('IsPublished', true)->get();
        foreach ($staticPages as $page) {
            $lastMod = $this->lastMod($page);
            $sitemap->add(
                Url::create("/id/{$page->Slug}")
                    ->setLastModificationDate($lastMod)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.5)
            );
        }

        // ✅ 5. Custom Pages (jika model ada)
        if (class_exists(CustomPage::class)) {
            $customPages = CustomPage::where('IsPublished', true)->get();
            foreach ($customPages as $page) {
                $lastMod = $this->lastMod($page);
                $sitemap->add(
                    Url::create("/id/page/{$page->Slug}")
                        ->setLastModificationDate($lastMod)
                        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                        ->setPriority(0.6)
                );
            }
        }

        // ✅ 6. Versi English untuk halaman penting
        foreach ($berita as $item) {
            $lastMod = $this->lastMod($item);
            $sitemap->add(
                Url::create("/en/news/{$item->Slug}")
                    ->setLastModificationDate($lastMod)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.7)
            );
        }

        // Simpan ke public folder
        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('✅ Sitemap berhasil di-generate: ' . public_path('sitemap.xml'));
        $this->info('📊 Total URL: ' . count($sitemap->getTags()));

        return Command::SUCCESS;
    }
}

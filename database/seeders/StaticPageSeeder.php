<?php

namespace Database\Seeders;

use App\Models\StaticPage;
use Illuminate\Database\Seeder;

class StaticPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'PageType' => 'privacy_policy',
                'Label' => 'Kebijakan Privasi',
                'Icon' => 'fa fa-user-shield',
                'Slug' => 'kebijakan-privasi',
                'IsPublished' => true,
                'Urutan' => 1,
                'translations' => [
                    'id' => [
                        'Judul' => 'Kebijakan Privasi',
                        'Konten' => '<p>Silakan isi kebijakan privasi perusahaan Anda di sini...</p>',
                        'SEOTitle' => 'Kebijakan Privasi - Jasuindo',
                        'SEODescription' => 'Pelajari bagaimana kami melindungi data pribadi Anda.',
                    ],
                    'en' => [
                        'Judul' => 'Privacy Policy',
                        'Konten' => '<p>Please fill in your company privacy policy here...</p>',
                        'SEOTitle' => 'Privacy Policy - Jasuindo',
                        'SEODescription' => 'Learn how we protect your personal data.',
                    ],
                ],
            ],
            [
                'PageType' => 'terms_conditions',
                'Label' => 'Syarat & Ketentuan',
                'Icon' => 'fa fa-file-contract',
                'Slug' => 'syarat-ketentuan',
                'IsPublished' => true,
                'Urutan' => 2,
                'translations' => [
                    'id' => [
                        'Judul' => 'Syarat & Ketentuan',
                        'Konten' => '<p>Silakan isi syarat dan ketentuan penggunaan website Anda di sini...</p>',
                        'SEOTitle' => 'Syarat & Ketentuan - Jasuindo',
                        'SEODescription' => 'Syarat dan ketentuan penggunaan layanan kami.',
                    ],
                    'en' => [
                        'Judul' => 'Terms & Conditions',
                        'Konten' => '<p>Please fill in your website terms and conditions here...</p>',
                        'SEOTitle' => 'Terms & Conditions - Jasuindo',
                        'SEODescription' => 'Terms and conditions for using our services.',
                    ],
                ],
            ],
            [
                'PageType' => 'about_us',
                'Label' => 'Tentang Kami',
                'Icon' => 'fa fa-building',
                'Slug' => 'tentang-kami',
                'IsPublished' => true,
                'Urutan' => 3,
                'translations' => [
                    'id' => [
                        'Judul' => 'Tentang Kami',
                        'Konten' => '<p>Informasi tentang perusahaan Anda...</p>',
                    ],
                    'en' => [
                        'Judul' => 'About Us',
                        'Konten' => '<p>Information about your company...</p>',
                    ],
                ],
            ],
            [
                'PageType' => 'faq',
                'Label' => 'FAQ',
                'Icon' => 'fa fa-question-circle',
                'Slug' => 'faq',
                'IsPublished' => true,
                'Urutan' => 4,
                'translations' => [
                    'id' => [
                        'Judul' => 'Pertanyaan yang Sering Diajukan',
                        'Konten' => '<p>Daftar FAQ perusahaan Anda...</p>',
                    ],
                    'en' => [
                        'Judul' => 'Frequently Asked Questions',
                        'Konten' => '<p>Your company FAQ list...</p>',
                    ],
                ],
            ],
        ];

        foreach ($pages as $pageData) {
            $translations = $pageData['translations'];
            unset($pageData['translations']);

            $page = StaticPage::updateOrCreate(
                ['PageType' => $pageData['PageType']],
                $pageData
            );

            foreach ($translations as $locale => $transData) {
                $page->translations()->updateOrCreate(
                    ['Locale' => $locale],
                    $transData
                );
            }
        }
    }
}

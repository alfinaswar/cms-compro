<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            [
                'NamaMenu' => 'Home',
                'JenisLink' => 'custom',
                'Url' => '/',
                'Urutan' => 1,
                'StatusAktif' => true,
                'TampilkanDiHeader' => true,
            ],
            [
                'NamaMenu' => 'About Us',
                'JenisLink' => 'route',
                'RouteName' => 'frontend.about',
                'Urutan' => 2,
                'StatusAktif' => true,
                'TampilkanDiHeader' => true,
            ],
            [
                'NamaMenu' => 'News',
                'JenisLink' => 'route',
                'RouteName' => 'frontend.news',
                'Urutan' => 3,
                'StatusAktif' => true,
                'TampilkanDiHeader' => true,
            ],
            [
                'NamaMenu' => 'Career',
                'JenisLink' => 'route',
                'RouteName' => 'frontend.career',
                'Urutan' => 4,
                'StatusAktif' => true,
                'TampilkanDiHeader' => true,
            ],
            [
                'NamaMenu' => 'Contact Us',
                'JenisLink' => 'route',
                'RouteName' => 'frontend.contact',
                'Urutan' => 5,
                'StatusAktif' => true,
                'TampilkanDiHeader' => true,
            ],
        ];

        foreach ($menus as $menuData) {
            $menuData['SlugMenu'] = Str::slug($menuData['NamaMenu']);
            Menu::create($menuData);
        }
    }
}

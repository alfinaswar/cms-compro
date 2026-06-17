<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\HalamanSolusiController;
use App\Http\Controllers\HeroSliderController;
use App\Http\Controllers\HistoryPerusahaanController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\KeyFiguresController;
use App\Http\Controllers\LowonganKerjaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PengaturanWebsiteController;
use App\Http\Controllers\PenghargaanPerusahaanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValuePerusahaanController;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.main');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::prefix('/')->group(function () {
    Route::get('/news', [BeritaController::class, 'news'])->name('frontend.news');
    Route::get('/about-us', [AboutUsController::class, 'show'])->name('frontend.about-us');
    Route::get('/news/{slug}', [BeritaController::class, 'newsDetail'])->name('frontend.detail');
    Route::get('/career', [LowonganKerjaController::class, 'career'])->name('frontend.career');
    Route::get('/career/{id}-{slug}', [LowonganKerjaController::class, 'careerDetail'])->name('frontend.career.detail');
    Route::post('/career/{id}/apply', [LowonganKerjaController::class, 'apply'])->name('frontend.career.apply');
    Route::get('/contact-us', [ContactUsController::class, 'index'])->name('frontend.contact.index');
    Route::POST('/store-contact-us', [ContactUsController::class, 'store'])->name('frontend.contact.store');
});
Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    // === GROUP DASHBOARD ===
    Route::resource('manajemen-akun/roles', RoleController::class)->names('roles');
    Route::resource('manajemen-akun/users', UserController::class)->names('users');

    // Karir & Rekrutmen Section
    Route::prefix('karir-dan-rekrutmen')->group(function () {
        Route::get('/', [LowonganKerjaController::class, 'index'])->name('karir.index');
        Route::get('/create', [LowonganKerjaController::class, 'create'])->name('karir.create');
        Route::post('/store', [LowonganKerjaController::class, 'store'])->name('karir.store');
        Route::get('/edit/{id}', [LowonganKerjaController::class, 'edit'])->name('karir.edit');
        Route::put('/update/{id}', [LowonganKerjaController::class, 'update'])->name('karir.update');
        Route::get('/show/{id}', [LowonganKerjaController::class, 'show'])->name('karir.show');
        Route::delete('/delete/{id}', [LowonganKerjaController::class, 'destroy'])->name('karir.destroy');
        Route::get('karir/{id}/pelamar', [LowonganKerjaController::class, 'pelamar'])->name('karir.pelamar');
        Route::post('karir/pelamar/{id}/update-status', [LowonganKerjaController::class, 'updateStatus'])->name('karir.update-status');
    });

    // Pengaturan Website Section
    Route::prefix('pengaturan')->group(function () {
        Route::get('/', [PengaturanWebsiteController::class, 'index'])->name('pengaturan-website.index');
        Route::get('/create', [PengaturanWebsiteController::class, 'create'])->name('pengaturan-website.create');
        Route::post('/store', [PengaturanWebsiteController::class, 'store'])->name('pengaturan-website.store');
        Route::get('/edit', [PengaturanWebsiteController::class, 'edit'])->name('pengaturan-website.edit');
        Route::put('/update', [PengaturanWebsiteController::class, 'update'])->name('pengaturan-website.update');
        Route::get('/show/{id}', [PengaturanWebsiteController::class, 'show'])->name('pengaturan-website.show');
        Route::delete('/delete/{id}', [PengaturanWebsiteController::class, 'destroy'])->name('pengaturan-website.destroy');

        Route::get('/landing-page/key-figure', [KeyFiguresController::class, 'index'])->name('pengaturan-key-figure.index');
        Route::get('/landing-page/key-figure/create', [KeyFiguresController::class, 'create'])->name('pengaturan-key-figure.create');
        Route::post('/landing-page/key-figure/store', [KeyFiguresController::class, 'store'])->name('pengaturan-key-figure.store');
        Route::get('/landing-page/key-figure/edit/{id}', [KeyFiguresController::class, 'edit'])->name('pengaturan-key-figure.edit');
        Route::put('/landing-page/key-figure/update/{id}', [KeyFiguresController::class, 'update'])->name('pengaturan-key-figure.update');
        Route::delete('/landing-page/key-figure/delete/{id}', [KeyFiguresController::class, 'destroy'])->name('pengaturan-key-figure.destroy');

        Route::get('/landing-page/solusi', [HalamanSolusiController::class, 'index'])->name('halaman-solusi.index');
        Route::get('/landing-page/solusi/create', [HalamanSolusiController::class, 'create'])->name('halaman-solusi.create');
        Route::post('/landing-page/solusi/store', [HalamanSolusiController::class, 'store'])->name('halaman-solusi.store');
        Route::get('/landing-page/solusi/edit/{id}', [HalamanSolusiController::class, 'edit'])->name('halaman-solusi.edit');
        Route::put('/landing-page/solusi/update/{id}', [HalamanSolusiController::class, 'update'])->name('halaman-solusi.update');
        Route::get('/landing-page/solusi/show/{id}', [HalamanSolusiController::class, 'show'])->name('halaman-solusi.show');
        Route::delete('/landing-page/solusi/delete/{id}', [HalamanSolusiController::class, 'destroy'])->name('halaman-solusi.destroy');

        // Routes Slider
        Route::get('/landing-page/hero-slider', [HeroSliderController::class, 'index'])->name('hero-slider.index');
        Route::get('/landing-page/hero-slider/create', [HeroSliderController::class, 'create'])->name('hero-slider.create');
        Route::post('/landing-page/hero-slider/store', [HeroSliderController::class, 'store'])->name('hero-slider.store');
        Route::get('/landing-page/hero-slider/edit/{id}', [HeroSliderController::class, 'edit'])->name('hero-slider.edit');
        Route::put('/landing-page/hero-slider/update/{id}', [HeroSliderController::class, 'update'])->name('hero-slider.update');
        Route::delete('/landing-page/hero-slider/delete/{id}', [HeroSliderController::class, 'destroy'])->name('hero-slider.destroy');

        // History Perusahaan
        Route::get('/landing-page/history-perusahaan', [HistoryPerusahaanController::class, 'index'])->name('history-perusahaan.index');
        Route::get('/landing-page/history-perusahaan/create', [HistoryPerusahaanController::class, 'create'])->name('history-perusahaan.create');
        Route::post('/landing-page/history-perusahaan/store', [HistoryPerusahaanController::class, 'store'])->name('history-perusahaan.store');

        // Penghargaan Perusahaan
        Route::get('/landing-page/penghargaan-perusahaan', [PenghargaanPerusahaanController::class, 'index'])->name('penghargaan-perusahaan.index');
        Route::get('/landing-page/penghargaan-perusahaan/create', [PenghargaanPerusahaanController::class, 'create'])->name('penghargaan-perusahaan.create');
        Route::post('/landing-page/penghargaan-perusahaan/store', [PenghargaanPerusahaanController::class, 'store'])->name('penghargaan-perusahaan.store');
        Route::get('/landing-page/penghargaan-perusahaan/edit/{id}', [PenghargaanPerusahaanController::class, 'edit'])->name('penghargaan-perusahaan.edit');
        Route::put('/landing-page/penghargaan-perusahaan/update/{id}', [PenghargaanPerusahaanController::class, 'update'])->name('penghargaan-perusahaan.update');
        Route::delete('/landing-page/penghargaan-perusahaan/delete/{id}', [PenghargaanPerusahaanController::class, 'destroy'])->name('penghargaan-perusahaan.destroy');
        Route::get('/landing-page/penghargaan-perusahaan/show/{id}', [PenghargaanPerusahaanController::class, 'show'])->name('penghargaan-perusahaan.show');

        // Value Perusahaan
        Route::get('/landing-page/value-perusahaan', [ValuePerusahaanController::class, 'index'])->name('value-perusahaan.index');
        Route::get('/landing-page/value-perusahaan/create', [ValuePerusahaanController::class, 'create'])->name('value-perusahaan.create');
        Route::post('/landing-page/value-perusahaan/store', [ValuePerusahaanController::class, 'store'])->name('value-perusahaan.store');
        Route::get('/landing-page/value-perusahaan/edit/{id}', [ValuePerusahaanController::class, 'edit'])->name('value-perusahaan.edit');
        Route::put('/landing-page/value-perusahaan/update/{id}', [ValuePerusahaanController::class, 'update'])->name('value-perusahaan.update');
        Route::delete('/landing-page/value-perusahaan/delete/{id}', [ValuePerusahaanController::class, 'destroy'])->name('value-perusahaan.destroy');
        Route::get('/landing-page/value-perusahaan/show/{id}', [ValuePerusahaanController::class, 'show'])->name('value-perusahaan.show');

        // Crud About Us
        Route::get('/landing-page/about-us', [AboutUsController::class, 'index'])->name('about-us.index');
        Route::get('/landing-page/about-us/create', [AboutUsController::class, 'create'])->name('about-us.create');
        Route::post('/landing-page/about-us/store', [AboutUsController::class, 'store'])->name('about-us.store');
        Route::get('/landing-page/about-us/edit/{id}', [AboutUsController::class, 'edit'])->name('about-us.edit');
        Route::put('/landing-page/about-us/update/{id}', [AboutUsController::class, 'update'])->name('about-us.update');
        Route::delete('/landing-page/about-us/delete/{id}', [AboutUsController::class, 'destroy'])->name('about-us.destroy');
        Route::get('/landing-page/about-us/show/{id}', [AboutUsController::class, 'show'])->name('about-us.show');

    });
    // === ROUTE UNTUK BERITA ===
    Route::prefix('post')->group(function () {
        Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
        Route::get('/berita/create', [BeritaController::class, 'create'])->name('berita.create');
        Route::post('/berita/store', [BeritaController::class, 'store'])->name('berita.store');
        Route::get('/berita/edit/{id}', [BeritaController::class, 'edit'])->name('berita.edit');
        Route::put('/berita/update/{id}', [BeritaController::class, 'update'])->name('berita.update');
        Route::get('/berita/show/{id}', [BeritaController::class, 'show'])->name('berita.show');
        Route::delete('/berita/delete/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');
        Route::post('/berita/upload-image', [BeritaController::class, 'uploadImage'])->name('berita.upload-image');
        Route::post('/berita/kategori/store-ajax', [BeritaController::class, 'storeKategoriAjax'])
            ->name('berita.store-ajax');
    });

    // Menu
    Route::prefix('menu')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('menu.index');
        Route::get('/create', [MenuController::class, 'create'])->name('menu.create');
        Route::post('/', [MenuController::class, 'store'])->name('menu.store');
        Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
        Route::put('/{id}', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
        Route::post('/update-order', [MenuController::class, 'updateOrder'])->name('menu.update-order');
    });
    Route::prefix('data-master')->group(function () {
        Route::resource('kategori-berita', KategoriBeritaController::class)->names('kategori-berita');
        Route::get('/api/kategori-berita', [KategoriBeritaController::class, 'apiKategori'])->name('api.kategori-berita');
    });
    Route::prefix('contact')->group(function () {
        Route::get('/', [ContactUsController::class, 'list'])->name('contact.list');
        Route::get('/export', [ContactUsController::class, 'encuxport'])->name('contact.export');
        Route::delete('/contact/{id}', [ContactUsController::class, 'destroy']);
    });

    Route::get('log-aktivitas-user', [ActivityLogController::class, 'index'])->name('log.index');
});

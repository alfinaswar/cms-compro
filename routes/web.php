<?php

use App\Http\Controllers\BeritaController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\LowonganKerjaController;
use App\Http\Controllers\PengaturanWebsiteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.index');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => ['auth']], function () {
    // === GROUP DASHBOARD ===
    Route::resource('manajemen-akun/roles', RoleController::class)->names('roles');
    Route::resource('manajemen-akun/users', UserController::class)->names('users');

    // Karir & Rekrutmen Section
    Route::prefix('karir-dan-rekrutmen')->group(function () {
        Route::get('/', [LowonganKerjaController::class, 'index'])->name('karir.index');
        Route::get('/create', [LowonganKerjaController::class, 'create'])->name('karir.create');
        Route::post('/store', [LowonganKerjaController::class, 'store'])->name('karir.store');
        Route::get('/edit', [LowonganKerjaController::class, 'edit'])->name('karir.edit');
        Route::put('/update', [LowonganKerjaController::class, 'update'])->name('karir.update');
        Route::get('/show/{id}', [LowonganKerjaController::class, 'show'])->name('karir.show');
        Route::delete('/delete/{id}', [LowonganKerjaController::class, 'destroy'])->name('karir.destroy');
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
    });
    // === ROUTE UNTUK BERITA ===
    Route::prefix('berita')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('berita.index');
        Route::get('/create', [BeritaController::class, 'create'])->name('berita.create');
        Route::post('/store', [BeritaController::class, 'store'])->name('berita.store');
        Route::get('/edit/{id}', [BeritaController::class, 'edit'])->name('berita.edit');
        Route::put('/update/{id}', [BeritaController::class, 'update'])->name('berita.update');
        Route::get('/show/{id}', [BeritaController::class, 'show'])->name('berita.show');
        Route::delete('/delete/{id}', [BeritaController::class, 'destroy'])->name('berita.destroy');
        Route::post('/upload-image', [BeritaController::class, 'uploadImage'])->name('berita.upload-image');
        Route::post('/kategori/store-ajax', [BeritaController::class, 'storeKategoriAjax'])
            ->name('berita.store-ajax');
    });
    Route::prefix('data-master')->group(function () {
        Route::resource('kategori-berita', KategoriBeritaController::class)->names('kategori-berita');
        Route::get('/api/kategori-berita', [KategoriBeritaController::class, 'apiKategori'])->name('api.kategori-berita');
    });

    // Blog Section
});

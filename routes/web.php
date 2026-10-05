<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\ClientLogoController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\CustomPageController;
use App\Http\Controllers\CustomPagesController;
use App\Http\Controllers\HalamanSolusiController;
use App\Http\Controllers\HeroSliderController;
use App\Http\Controllers\HistoryPerusahaanController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\JenisLaporanKeuanganController;
use App\Http\Controllers\InvestorFrontendController;
use App\Http\Controllers\AdminInvestorFinansialController;
use App\Http\Controllers\AdminInvestorTataKelolaController;
use App\Http\Controllers\AdminInvestorInformasiLainnyaController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\KeyFiguresController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LaporanKeuanganDetailController;
use App\Http\Controllers\LowonganKerjaController;
use App\Http\Controllers\MasterKantorController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\NotificationEmailController;
use App\Http\Controllers\NotificationEmailRecipientController;
use App\Http\Controllers\PengaturanWebsiteController;
use App\Http\Controllers\PenghargaanPerusahaanController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StrukturOrganisasiController;
use App\Http\Controllers\StrukturOrganisasiDetailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ValuePerusahaanController;
use App\Http\Controllers\WhyChooseUsController;
use App\Models\ContactUs;
use App\Models\JenisLaporanKeuangan;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('frontend.main');  // Hanya Tampil Footer saja

Auth::routes();
Route::get('/', function () {
    $locale = session('locale', 'id');
    return redirect('/' . $locale);
});
// 2. Auth Routes (di luar group locale)
Auth::routes();
Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 3. GROUP ROUTE: Semua route di dalam sini otomatis mendapat prefix /id/ atau /en/
Route::group(['prefix' => '{locale}', 'where' => ['locale' => 'id|en']], function () {
    Route::get('/', [LandingPageController::class, 'index'])->name('frontend.main');
    Route::get('/news', [BeritaController::class, 'news'])->name('frontend.news');
    Route::get('/news/{slug}', [BeritaController::class, 'newsDetail'])->name('frontend.detail');
    Route::get('/halaman/{slug}', [CustomPagesController::class, 'show'])->name('frontend.halaman-custom');
    // === INVESTOR RELATIONS (4 TABS) ===
    Route::get('/laporan-keuangan', [InvestorFrontendController::class, 'laporanKeuangan'])->name('frontend.laporan-keuangan');
    Route::get('/laporan-keuangan/informasi-finansial', [InvestorFrontendController::class, 'informasiFinansial'])->name('frontend.investor.informasi-finansial');
    Route::get('/laporan-keuangan/tata-kelola-perusahaan', [InvestorFrontendController::class, 'tataKelola'])->name('frontend.investor.tata-kelola');
    Route::get('/laporan-keuangan/informasi-lainnya', [InvestorFrontendController::class, 'informasiLainnya'])->name('frontend.investor.informasi-lainnya');
    Route::post('/laporan-keuangan/kirim-wbs', [InvestorFrontendController::class, 'submitWbs'])->name('frontend.investor.wbs.store');
    Route::post('/laporan-keuangan/permintaan-dokumen', [InvestorFrontendController::class, 'submitPermintaanDokumen'])->name('frontend.investor.permintaan-dokumen.store');
    Route::get('/about-us', [AboutUsController::class, 'show'])->name('frontend.about-us');
    Route::get('/career', [LowonganKerjaController::class, 'career'])->name('frontend.career');
    Route::get('/career/{id}-{slug}', [LowonganKerjaController::class, 'careerDetail'])->name('frontend.career.detail');
    Route::post('/career/{id}/apply', [LowonganKerjaController::class, 'apply'])->name('frontend.career.apply');
    Route::get('/contact-us', [ContactUsController::class, 'index'])->name('frontend.contact.index');
    Route::post('/store-contact-us', [ContactUsController::class, 'store'])->name('frontend.contact.store');
});
Route::group(['middleware' => ['auth'], 'prefix' => 'admin'], function () {
    // === GROUP DASHBOARD ===
    Route::resource('manajemen-akun/roles', RoleController::class)->names('roles');
    Route::resource('manajemen-akun/users', UserController::class)->names('users');
    Route::resource('permissions', PermissionController::class);

    Route::prefix('homepage')->group(function () {
        Route::get('/', [HomepageController::class, 'index'])->name('homepage.index');
    });
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
        // Notification Email Routes
        Route::get('/penerima-notif-email', [NotificationEmailRecipientController::class, 'index'])->name('notification-email.index');
        Route::post('/penerima-notif-email', [NotificationEmailRecipientController::class, 'store'])->name('notification-email.store');
        Route::put('/penerima-notif-email/{id}', [NotificationEmailRecipientController::class, 'update'])->name('notification-email.update');
        Route::delete('/penerima-notif-email/{id}', [NotificationEmailRecipientController::class, 'destroy'])->name('notification-email.destroy');
        Route::put('/{id}/toggle-status', [NotificationEmailRecipientController::class, 'toggleStatus'])
            ->name('notification-email.toggle-status');

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

        // Manajemen Tentang Kami (satu halaman terpadu)
        Route::get('/landing-page/about-us', [AboutUsController::class, 'index'])->name('about-us.index');
        Route::put('/landing-page/about-us/update', [AboutUsController::class, 'update'])->name('about-us.update');
        Route::get('/landing-page/about-us/create', [AboutUsController::class, 'create'])->name('about-us.create');
        Route::get('/landing-page/about-us/edit/{id}', [AboutUsController::class, 'edit'])->name('about-us.edit');

        Route::resource('/landing-page/why-choose-us', WhyChooseUsController::class);
        Route::resource('/landing-page/client-logo', ClientLogoController::class)->names('client-logo');
        Route::get('/landing-page/client-logo/create-detail/{id}', [ClientLogoController::class, 'createDetail'])->name('client-logo.create-detail');
        Route::post('/landing-page/client-logo/store-detail/{id}', [ClientLogoController::class, 'storeDetail'])->name('client-logo.store-detail');

        // untuk detail client logo
        Route::put('/landing-page/client-logo/update-detail/{id}', [ClientLogoController::class, 'updateDetail'])->name('client-logo.update-detail');
        Route::delete('/landing-page/client-logo/delete/{id}', [ClientLogoController::class, 'destroyDetail'])->name('client-logo.destroy-detail');
    });
    // === ROUTE UNTUK BERITA ===
    Route::prefix('publikasi-dan-berita')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('berita.index');
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
    Route::prefix('buat-halaman')->group(function () {
        Route::get('/custom-pages', [CustomPagesController::class, 'index'])->name('custom-pages.index');
        Route::get('/custom-pages/create', [CustomPagesController::class, 'create'])->name('custom-pages.create');
        Route::post('/custom-pages', [CustomPagesController::class, 'store'])->name('custom-pages.store');
        Route::get('/custom-pages/{id}/edit', [CustomPagesController::class, 'edit'])->name('custom-pages.edit');
        Route::put('/custom-pages/{id}', [CustomPagesController::class, 'update'])->name('custom-pages.update');
        Route::delete('/custom-pages/{id}', [CustomPagesController::class, 'destroy'])->name('custom-pages.destroy');
    });
    // Menu
    Route::prefix('menu')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('menu.index');
        Route::get('/create', [MenuController::class, 'create'])->name('menu.create');
        Route::post('/', [MenuController::class, 'store'])->name('menu.store');
        Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
        Route::put('/{id}', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
        Route::POST('/update-order', [MenuController::class, 'updateOrder'])->name('menu.update-order');
    });
    Route::prefix('data-master')->group(function () {
        // Investor Relation Section
        Route::resource('kantor', MasterKantorController::class)->names('master-kantor');
        Route::resource('kategori-berita', KategoriBeritaController::class)->names('kategori-berita');
        Route::get('/api/kategori-berita', [KategoriBeritaController::class, 'apiKategori'])->name('api.kategori-berita');
    });
    Route::prefix('komunikasi-dan-transaksi')->group(function () {
        Route::get('/kotak-masuk', [ContactUsController::class, 'list'])->name('contact.list');
        Route::get('/export', [ContactUsController::class, 'export'])->name('contact.export');
        Route::delete('/contact/{id}', [ContactUsController::class, 'destroy']);
    });
    Route::resource('jenis-laporan', JenisLaporanKeuanganController::class)->names('jenis-laporan');
    Route::prefix('jenis-laporan/{jenisId}/dokumen')->name('jenis-laporan.details.')->group(function () {
        Route::get('/', [LaporanKeuanganDetailController::class, 'index'])->name('index');
        Route::post('/', [LaporanKeuanganDetailController::class, 'store'])->name('store');
        Route::put('/{id}', [LaporanKeuanganDetailController::class, 'update'])->name('update');
        Route::delete('/{id}', [LaporanKeuanganDetailController::class, 'destroy'])->name('destroy');
    });

    // === INVESTOR RELATIONS CMS (Informasi Finansial, Tata Kelola, Informasi Lainnya) ===
    Route::prefix('investor')->name('admin.investor.')->group(function () {
        // Tab 1 Sub: Ringkasan Kinerja Keuangan (5 Tahun)
        Route::prefix('ringkasan-kinerja')->name('ringkasan-kinerja.')->group(function () {
            Route::get('/', [\App\Http\Controllers\AdminRingkasanKinerjaController::class, 'index'])->name('index');
            Route::post('/store', [\App\Http\Controllers\AdminRingkasanKinerjaController::class, 'store'])->name('store');
            Route::post('/update/{id}', [\App\Http\Controllers\AdminRingkasanKinerjaController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [\App\Http\Controllers\AdminRingkasanKinerjaController::class, 'destroy'])->name('destroy');
            Route::post('/update-periode', [\App\Http\Controllers\AdminRingkasanKinerjaController::class, 'updatePeriode'])->name('update-periode');
            Route::post('/quick-update-batch', [\App\Http\Controllers\AdminRingkasanKinerjaController::class, 'quickUpdateBatch'])->name('quick-update-batch');
            Route::post('/tambah-tahun', [\App\Http\Controllers\AdminRingkasanKinerjaController::class, 'tambahTahun'])->name('tambah-tahun');
            Route::post('/hapus-tahun', [\App\Http\Controllers\AdminRingkasanKinerjaController::class, 'hapusTahun'])->name('hapus-tahun');
        });

        // Tab 2: Informasi Finansial
        Route::prefix('finansial')->name('finansial.')->group(function () {
            Route::get('/', [AdminInvestorFinansialController::class, 'index'])->name('index');
            Route::post('/update-saham', [AdminInvestorFinansialController::class, 'updateSaham'])->name('update-saham');
            Route::post('/store-struktur', [AdminInvestorFinansialController::class, 'storeStruktur'])->name('store-struktur');
            Route::post('/update-struktur/{id}', [AdminInvestorFinansialController::class, 'updateStruktur'])->name('update-struktur');
            Route::delete('/destroy-struktur/{id}', [AdminInvestorFinansialController::class, 'destroyStruktur'])->name('destroy-struktur');
            Route::post('/update-skema', [AdminInvestorFinansialController::class, 'updateSkema'])->name('update-skema');
            Route::post('/store-entitas', [AdminInvestorFinansialController::class, 'storeEntitas'])->name('store-entitas');
            Route::post('/update-entitas/{id}', [AdminInvestorFinansialController::class, 'updateEntitas'])->name('update-entitas');
            Route::delete('/destroy-entitas/{id}', [AdminInvestorFinansialController::class, 'destroyEntitas'])->name('destroy-entitas');
        });

        // Tab 3: Tata Kelola Perusahaan
        Route::prefix('tata-kelola')->name('tata-kelola.')->group(function () {
            Route::get('/', [AdminInvestorTataKelolaController::class, 'index'])->name('index');
            Route::post('/update-bagan', [AdminInvestorTataKelolaController::class, 'updateBagan'])->name('update-bagan');
            Route::post('/store-manajemen', [AdminInvestorTataKelolaController::class, 'storeManajemen'])->name('store-manajemen');
            Route::post('/update-manajemen/{id}', [AdminInvestorTataKelolaController::class, 'updateManajemen'])->name('update-manajemen');
            Route::delete('/destroy-manajemen/{id}', [AdminInvestorTataKelolaController::class, 'destroyManajemen'])->name('destroy-manajemen');
            Route::post('/store-dokumen', [AdminInvestorTataKelolaController::class, 'storeDokumen'])->name('store-dokumen');
            Route::post('/update-dokumen/{id}', [AdminInvestorTataKelolaController::class, 'updateDokumen'])->name('update-dokumen');
            Route::delete('/destroy-dokumen/{id}', [AdminInvestorTataKelolaController::class, 'destroyDokumen'])->name('destroy-dokumen');
            Route::post('/store-rups', [AdminInvestorTataKelolaController::class, 'storeRups'])->name('store-rups');
            Route::post('/update-rups/{id}', [AdminInvestorTataKelolaController::class, 'updateRups'])->name('update-rups');
            Route::delete('/destroy-rups/{id}', [AdminInvestorTataKelolaController::class, 'destroyRups'])->name('destroy-rups');
            // WBS Inbox
            Route::get('/wbs', [AdminInvestorTataKelolaController::class, 'wbsIndex'])->name('wbs-index');
            Route::get('/wbs/{id}', [AdminInvestorTataKelolaController::class, 'wbsShow'])->name('wbs-show');
            Route::post('/wbs/{id}/update-status', [AdminInvestorTataKelolaController::class, 'wbsUpdateStatus'])->name('wbs-update-status');
        });

        // Tab 4: Informasi Lainnya
        Route::prefix('informasi-lainnya')->name('informasi-lainnya.')->group(function () {
            Route::get('/', [AdminInvestorInformasiLainnyaController::class, 'index'])->name('index');
            Route::post('/store-lembaga', [AdminInvestorInformasiLainnyaController::class, 'storeLembaga'])->name('store-lembaga');
            Route::post('/update-lembaga/{id}', [AdminInvestorInformasiLainnyaController::class, 'updateLembaga'])->name('update-lembaga');
            Route::delete('/destroy-lembaga/{id}', [AdminInvestorInformasiLainnyaController::class, 'destroyLembaga'])->name('destroy-lembaga');
            Route::post('/store-keterbukaan', [AdminInvestorInformasiLainnyaController::class, 'storeKeterbukaan'])->name('store-keterbukaan');
            Route::post('/update-keterbukaan/{id}', [AdminInvestorInformasiLainnyaController::class, 'updateKeterbukaan'])->name('update-keterbukaan');
            Route::delete('/destroy-keterbukaan/{id}', [AdminInvestorInformasiLainnyaController::class, 'destroyKeterbukaan'])->name('destroy-keterbukaan');
            // Permintaan Dokumen Fisik Inbox
            Route::get('/permintaan-dokumen', [AdminInvestorInformasiLainnyaController::class, 'permintaanIndex'])->name('permintaan-index');
            Route::post('/permintaan-dokumen/{id}/update-status', [AdminInvestorInformasiLainnyaController::class, 'permintaanUpdateStatus'])->name('permintaan-update-status');
            Route::delete('/destroy-permintaan/{id}', [AdminInvestorInformasiLainnyaController::class, 'permintaanDestroy'])->name('destroy-permintaan');
        });
    });

    // Download dokumen (public)
    Route::get('laporan-download/{id}', [LaporanKeuanganDetailController::class, 'download'])
        ->name('laporan.download');
    Route::prefix('struktur-organisasi')->group(function () {
        Route::get('/', [StrukturOrganisasiController::class, 'index'])->name('struktur-organisasi.index');
        Route::get('/create', [StrukturOrganisasiController::class, 'create'])->name('struktur-organisasi.create');
        Route::post('/store', [StrukturOrganisasiController::class, 'store'])->name('struktur-organisasi.store');
        Route::get('/edit/{id}', [StrukturOrganisasiController::class, 'edit'])->name('struktur-organisasi.edit');
        Route::put('/update/{id}', [StrukturOrganisasiController::class, 'update'])->name('struktur-organisasi.update');
        Route::delete('/delete/{id}', [StrukturOrganisasiController::class, 'destroy'])->name('struktur-organisasi.destroy');
        Route::get('/show/{id}', [StrukturOrganisasiController::class, 'show'])->name('struktur-organisasi.show');
        Route::get('struktur-organisasi/{section}/details', [StrukturOrganisasiController::class, 'getDetails'])
            ->name('struktur-organisasi.details');
        Route::post('struktur-organisasi/detail/store', [StrukturOrganisasiController::class, 'storeDetail'])
            ->name('struktur-organisasi.detail.store');
        Route::put('struktur-organisasi/detail/{id}/update', [StrukturOrganisasiController::class, 'updateDetail'])
            ->name('struktur-organisasi.detail.update');
        Route::delete('struktur-organisasi/detail/{id}/delete', [StrukturOrganisasiController::class, 'destroyDetail'])
            ->name('struktur-organisasi.detail.destroy');
    });
    Route::prefix('struktur-organisasi/{section}/anggota')->name('struktur-organisasi.anggota.')->group(function () {
        Route::get('/', [StrukturOrganisasiDetailController::class, 'index'])->name('index');
        Route::get('/create', [StrukturOrganisasiDetailController::class, 'create'])->name('create');
        Route::post('/', [StrukturOrganisasiDetailController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [StrukturOrganisasiDetailController::class, 'edit'])->name('edit');
        Route::put('/{id}', [StrukturOrganisasiDetailController::class, 'update'])->name('update');
        Route::delete('/{id}', [StrukturOrganisasiDetailController::class, 'destroy'])->name('destroy');
    });
    Route::get('log-aktivitas-user', [ActivityLogController::class, 'index'])->name('log.index');
});

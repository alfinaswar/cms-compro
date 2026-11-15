<?php

namespace Tests\Feature;

use App\Models\LembagaPenunjang;
use App\Models\KeterbukaanInformasi;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class InformasiLainnyaRevisionTest extends TestCase
{
    use DatabaseTransactions;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        $this->admin = User::factory()->create();
        $perms = [
            'investor.view',
            'investor.create',
            'investor.edit',
            'investor.delete',
        ];
        foreach ($perms as $perm) {
            Permission::findOrCreate($perm);
        }
        $this->admin->givePermissionTo($perms);
    }

    /**
     * Point 1: Lembaga Penunjang Pasar Modal Bug Penyimpanan
     * - Fix: saving with empty/null Urutan and Website without https:// protocol succeeds
     */
    public function test_store_lembaga_penunjang_succeeds_with_normalized_website_and_null_urutan(): void
    {
        $payload = [
            'NamaInstitusi' => 'KAP Tanubrata Sutanto Fahmi Bambang & Rekan',
            'Kategori' => 'Kantor Akuntan Publik (KAP)',
            'Afiliasi' => 'BDO International',
            'Website' => 'bdo.co.id', // Tanpa https://
            'KantorPusat' => 'Prudential Tower Lantai 16, Jakarta',
            'Cabang' => 'Surabaya',
            'Layanan' => 'Audit Umum',
            'Urutan' => null, // Empty value yang sebelumnya memicu integrity error
            'Status' => 'Aktif',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.investor.informasi-lainnya.store-lembaga'), $payload);

        $response->assertSessionHas('success');

        $lembaga = LembagaPenunjang::where('NamaInstitusi', 'KAP Tanubrata Sutanto Fahmi Bambang & Rekan')->first();
        $this->assertNotNull($lembaga);
        $this->assertEquals('https://bdo.co.id', $lembaga->Website);
        $this->assertEquals(0, $lembaga->Urutan);
        $this->assertEquals('Aktif', $lembaga->Status);
    }

    /**
     * Point 2: Keterbukaan Informasi Live Search
     * - Admin view contains adminSearchKeterbukaan
     * - Frontend view contains search-keterbukaan, filter-tahun, filter-kategori, and data attributes for DOM filtering
     */
    public function test_keterbukaan_informasi_live_search_structure(): void
    {
        // Admin view has live search input
        $adminRes = $this->actingAs($this->admin)->get(route('admin.investor.informasi-lainnya.index'));
        $adminRes->assertStatus(200);
        $adminRes->assertSee('id="adminSearchKeterbukaan"', false);

        // Frontend view has live search elements
        $frontendRes = $this->get('/id/laporan-investor/informasi-lainnya/');
        $frontendRes->assertStatus(200);
        $frontendRes->assertSee('id="search-keterbukaan"', false);
        $frontendRes->assertSee('id="filter-tahun-keterbukaan"', false);
        $frontendRes->assertSee('id="filter-kategori-keterbukaan"', false);
        $frontendRes->assertSee('keterbukaan-card', false);
        $frontendRes->assertSee('data-judul', false);
        $frontendRes->assertSee('data-kategori', false);
    }

    /**
     * Point 3: Pemisahan Menu Permintaan Laporan Fisik
     * - Tab Permintaan Salinan Fisik is taken out from infoLainnyaTab
     * - Sidebar contains independent sub-menu 'Permintaan Laporan Fisik'
     * - Permintaan index view reflects 'Permintaan Laporan Fisik'
     */
    public function test_permintaan_laporan_fisik_menu_separation(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.investor.informasi-lainnya.index'));
        $response->assertStatus(200);

        $html = $response->getContent();

        // The infoLainnyaTab nav-tabs must NOT contain Permintaan Salinan Fisik
        if (preg_match('/<ul[^>]*id="infoLainnyaTab"[^>]*>(.*?)<\/ul>/s', $html, $matches)) {
            $this->assertStringNotContainsString('Permintaan Salinan Fisik', $matches[1]);
        }

        // Sidebar contains dedicated sub-menu 'Permintaan Laporan Fisik'
        $response->assertSee('Permintaan Laporan Fisik');
        $response->assertSee(route('admin.investor.informasi-lainnya.permintaan-index'));

        // Permintaan index view renders with correct title
        $permintaanIndexRes = $this->actingAs($this->admin)->get(route('admin.investor.informasi-lainnya.permintaan-index'));
        $permintaanIndexRes->assertStatus(200);
        $permintaanIndexRes->assertSee('Permintaan Laporan Fisik');
    }
}

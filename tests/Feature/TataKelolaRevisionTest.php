<?php

namespace Tests\Feature;

use App\Models\BaganOrganisasi;
use App\Models\DokumenTataKelola;
use App\Models\RupsDokumen;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class TataKelolaRevisionTest extends TestCase
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
     * Point 1: Bagan Organisasi
     * - PDF upload input removed from admin
     * - Bagan update works without PDF
     * - Download PDF button removed from frontend
     */
    public function test_bagan_organisasi_revision(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.investor.tata-kelola.index'));
        $response->assertStatus(200);

        // Assert input FileBaganPdf is removed from admin view
        $response->assertDontSee('name="FileBaganPdf"', false);
        $response->assertDontSee('Upload PDF Dokumen Bagan', false);

        // Assert bagan update succeeds without PDF
        $updateResponse = $this->actingAs($this->admin)->post(route('admin.investor.tata-kelola.update-bagan'), [
            'Judul' => 'Struktur Organisasi Unit Test',
            'EmailSekretariat' => 'corsec@test.com',
            'TeleponSekretariat' => '021-123456',
            'AlamatSekretariat' => 'Gedung Test Lantai 5',
        ]);
        $updateResponse->assertSessionHas('success');

        $bagan = BaganOrganisasi::first();
        $this->assertNotNull($bagan);
        $this->assertEquals('Struktur Organisasi Unit Test', $bagan->Judul);

        // Assert frontend doesn't render "Unduh PDF" in bagan section
        $frontendResponse = $this->get('/id/laporan-investor/tata-kelola-perusahaan/');
        $frontendResponse->assertStatus(200);
        $frontendResponse->assertDontSee('fa-download text-xs"></i> Unduh PDF', false);
    }

    /**
     * Point 2: Dokumen Kebijakan
     * - PDF input is optional (store works without file, PathFile = null)
     * - Category filter exists on admin & frontend
     * - Category badges have distinct colors
     */
    public function test_dokumen_kebijakan_revision(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.investor.tata-kelola.index'));
        $response->assertStatus(200);

        // Category filter in admin table
        $response->assertSee('id="filterKategoriDokumenAdmin"', false);

        // Category badge classes
        $response->assertSee('badge-primary');
        $response->assertSee('badge-success');
        $response->assertSee('badge-warning');
        $response->assertSee('badge-purple');

        // File input in modal is optional (no required attribute)
        $response->assertDontSee('name="FileDokumen[]" class="form-control-file" multiple required', false);

        // Store document without file (optional PDF)
        $storeResponse = $this->actingAs($this->admin)->post(route('admin.investor.tata-kelola.store-dokumen'), [
            'Judul' => 'Dokumen Tanpa File PDF Test',
            'Kategori' => 'Kebijakan Operasional',
            'Deskripsi' => 'Testing optional PDF',
            'Status' => 'Aktif',
            'Urutan' => 99,
        ]);
        $storeResponse->assertSessionHas('success');

        $doc = DokumenTataKelola::where('Judul', 'Dokumen Tanpa File PDF Test')->first();
        $this->assertNotNull($doc);
        $this->assertNull($doc->PathFile);
        $this->assertEquals('Kebijakan Operasional', $doc->Kategori);

        // Frontend has category filter container and badges
        $frontendResponse = $this->get('/id/laporan-investor/tata-kelola-perusahaan/');
        $frontendResponse->assertStatus(200);
        $frontendResponse->assertSee('id="filter-kategori-gcg"', false);
        $frontendResponse->assertSee('btn-gcg-cat', false);
        $frontendResponse->assertSee('data-filter="Dokumen Tata Kelola"', false);
        $frontendResponse->assertSee('data-filter="Kebijakan Operasional"', false);
    }

    /**
     * Point 3: RUPS
     * - Year filter in admin & frontend
     * - StatusKegiatan removed from forms & requests
     * - Document button changed from "Unduh" to "Lihat"
     */
    public function test_rups_revision(): void
    {
        // Store RUPS without StatusKegiatan field
        $storeResponse = $this->actingAs($this->admin)->post(route('admin.investor.tata-kelola.store-rups'), [
            'Tahun' => 2026,
            'Judul' => 'Risalah RUPS 2026 Test',
            'KategoriDokumen' => 'Ringkasan Risalah',
            'Status' => 'Aktif',
            'Urutan' => 1,
        ]);
        $storeResponse->assertSessionHas('success');

        $rups = RupsDokumen::where('Judul', 'Risalah RUPS 2026 Test')->first();
        $this->assertNotNull($rups);
        $this->assertEquals('Selesai', $rups->StatusKegiatan);

        // Update RUPS without StatusKegiatan field
        $updateResponse = $this->actingAs($this->admin)->post(route('admin.investor.tata-kelola.update-rups', $rups->id), [
            'Tahun' => 2026,
            'Judul' => 'Risalah RUPS 2026 Test Updated',
            'KategoriDokumen' => 'Ringkasan Risalah',
            'Status' => 'Aktif',
            'Urutan' => 2,
        ]);
        $updateResponse->assertSessionHas('success');

        // Admin view checks
        $response = $this->actingAs($this->admin)->get(route('admin.investor.tata-kelola.index'));
        $response->assertStatus(200);

        // Filter year dropdown in admin RUPS tab
        $response->assertSee('id="filterTahunRupsAdmin"', false);

        // Status kegiatan input removed from edit modal
        $response->assertDontSee('id="editStatusKegiatanRups"', false);

        // Document button in admin changed to "Lihat"
        $response->assertSee('Lihat');

        // Frontend view checks: button changed to "Lihat" in ID, "View" in EN
        $frontendId = $this->get('/id/laporan-investor/tata-kelola-perusahaan/');
        $frontendId->assertStatus(200);
        $frontendId->assertSee('Lihat');

        $frontendEn = $this->get('/en/investor-relations/corporate-governance/');
        $frontendEn->assertStatus(200);
        $frontendEn->assertSee('View');
    }

    /**
     * Point 4: Laporan WBS
     * - Tab removed from Tata Kelola tab bar
     * - Independent sub-menu in admin sidebar
     */
    public function test_laporan_wbs_revision(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.investor.tata-kelola.index'));
        $response->assertStatus(200);

        $html = $response->getContent();

        // The nav-tabs in the card header must not contain "Laporan WBS Masuk"
        if (preg_match('/<ul[^>]*id="tataKelolaTab"[^>]*>(.*?)<\/ul>/s', $html, $matches)) {
            $this->assertStringNotContainsString('Laporan WBS Masuk', $matches[1]);
        }

        // Sidebar still has the Laporan WBS menu link
        $response->assertSee(route('admin.investor.tata-kelola.wbs-index'));
    }
}

<?php

namespace Tests\Feature;

use App\Models\AboutUs;
use App\Models\AboutUsDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class AboutUsHeroDetailTest extends TestCase
{
    use DatabaseTransactions;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        $this->admin = User::factory()->create();
        $perms = [
            'tentang-kami.view',
            'tentang-kami.create',
            'tentang-kami.edit',
            'tentang-kami.delete',
        ];
        foreach ($perms as $perm) {
            Permission::findOrCreate($perm);
        }
        $this->admin->givePermissionTo($perms);
    }

    /**
     * Test 1: Dashboard Hero tab does not have Gambar column, has Label, Nilai, Deskripsi
     */
    public function test_dashboard_hero_detail_repeater_columns(): void
    {
        $response = $this->actingAs($this->admin)->get(route('about-us.index'));
        $response->assertStatus(200);

        $html = $response->getContent();

        // Extract Hero tab content
        $this->assertStringContainsString('id="tab-hero"', $html);

        // Within tab-hero, table header must have Label, Nilai, Deskripsi
        if (preg_match('/<div[^>]*id="tab-hero"[^>]*>(.*?)<\/div>\s*<div[^>]*id="tab-/s', $html, $matches)) {
            $heroHtml = $matches[1];

            // Should NOT have Gambar in table header for hero details
            $this->assertDoesNotMatchRegularExpression('/<th[^>]*>Gambar.*?<\/th>/i', $heroHtml);

            // Should have Label, Nilai, Deskripsi
            $this->assertMatchesRegularExpression('/<th[^>]*>Label<\/th>/i', $heroHtml);
            $this->assertMatchesRegularExpression('/<th[^>]*>Nilai<\/th>/i', $heroHtml);
            $this->assertMatchesRegularExpression('/<th[^>]*>Deskripsi<\/th>/i', $heroHtml);

            // Button tambah detail must have data-has-image="0"
            $this->assertMatchesRegularExpression('/data-section="5"[^>]*data-has-image="0"/i', $heroHtml);
        } else {
            $this->fail('Could not extract tab-hero content from dashboard');
        }

        // Check that a section WITH images (e.g. CSR or Nilai) still has Gambar column
        if (preg_match('/<div[^>]*id="tab-nilai"[^>]*>(.*?)<\/div>\s*<div[^>]*id="tab-/s', $html, $matchesNilai)) {
            $nilaiHtml = $matchesNilai[1];
            $this->assertMatchesRegularExpression('/<th[^>]*>Gambar.*?<\/th>/i', $nilaiHtml);
        }
    }

    /**
     * Test 2: Submitting hero details with separate Label, Nilai, and Deskripsi saves properly
     */
    public function test_can_save_hero_details_with_separate_label_and_description(): void
    {
        // Setup initial Hero section
        $hero = AboutUs::find(5);

        $payload = [
            'sections' => [
                5 => [
                    'translations' => [
                        'id' => [
                            'SubJudul' => 'Sub Judul Hero ID',
                            'Judul' => 'Judul Hero ID',
                            'Deskripsi' => 'Deskripsi Hero ID',
                        ],
                        'en' => [
                            'SubJudul' => 'Hero Subtitle EN',
                            'Judul' => 'Hero Title EN',
                            'Deskripsi' => 'Hero Description EN',
                        ],
                    ],
                    'details' => [
                        0 => [
                            'translations' => [
                                'id' => [
                                    'SubJudul' => 'LABEL ID TEST',
                                    'Judul' => '99+ UNIT',
                                    'Deskripsi' => 'Keterangan deskripsi statistik ID',
                                ],
                                'en' => [
                                    'SubJudul' => 'LABEL EN TEST',
                                    'Judul' => '99+ UNITS',
                                    'Deskripsi' => 'Statistical description info EN',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $response = $this->actingAs($this->admin)->put(route('about-us.update'), $payload);
        $response->assertRedirect(route('about-us.index'));
        $response->assertSessionHas('success');

        // Check DB
        $savedDetail = AboutUsDetail::where('IdAbout', 5)->where('Judul', '99+ UNIT')->first();
        $this->assertNotNull($savedDetail);
        $this->assertEquals('LABEL ID TEST', $savedDetail->SubJudul);
        $this->assertEquals('99+ UNIT', $savedDetail->Judul);
        $this->assertEquals('Keterangan deskripsi statistik ID', $savedDetail->Deskripsi);

        // Check translations
        $transId = $savedDetail->translations->firstWhere('Locale', 'id');
        $this->assertNotNull($transId);
        $this->assertEquals('LABEL ID TEST', $transId->SubJudul);
        $this->assertEquals('99+ UNIT', $transId->Judul);
        $this->assertEquals('Keterangan deskripsi statistik ID', $transId->Deskripsi);

        $transEn = $savedDetail->translations->firstWhere('Locale', 'en');
        $this->assertNotNull($transEn);
        $this->assertEquals('LABEL EN TEST', $transEn->SubJudul);
        $this->assertEquals('99+ UNITS', $transEn->Judul);
        $this->assertEquals('Statistical description info EN', $transEn->Deskripsi);

        // Check Frontend ID
        $resId = $this->get('/id/tentang-kami/');
        $resId->assertStatus(200);
        $resId->assertSee('LABEL ID TEST');
        $resId->assertSee('99+ UNIT');
        $resId->assertSee('Keterangan deskripsi statistik ID');

        // Check Frontend EN
        $resEn = $this->get('/en/about-us/');
        $resEn->assertStatus(200);
        $resEn->assertSee('LABEL EN TEST');
        $resEn->assertSee('99+ UNITS');
        $resEn->assertSee('Statistical description info EN');
    }
}

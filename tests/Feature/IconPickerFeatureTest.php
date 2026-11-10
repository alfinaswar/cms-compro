<?php

namespace Tests\Feature;

use App\Models\AboutUs;
use App\Models\AboutUsDetail;
use App\Models\HalamanSolusi;
use App\Models\HalamanSolusiDetail;
use App\Models\HalamanSolusiSubpage;
use App\Models\HalamanSolusiSubpageItem;
use App\Models\KeyFigures;
use App\Models\Menu;
use App\Models\SecurityTier;
use App\Models\User;
use App\Models\WhyChooseUs;
use App\Support\IconHelper;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class IconPickerFeatureTest extends TestCase
{
    use DatabaseTransactions;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);

        $this->admin = User::factory()->create();
        $perms = [
            'homepage.view',
            'homepage.create',
            'homepage.edit',
            'homepage.delete',
            'solusi.edit',
            'tentang-kami.view',
            'tentang-kami.edit',
            'menu.view',
            'menu.create',
            'menu.edit',
        ];
        foreach ($perms as $perm) {
            Permission::findOrCreate($perm);
        }
        $this->admin->givePermissionTo($perms);
    }

    public function test_icon_helper_distinguishes_fontawesome_versions_from_image_paths_and_sanitizes(): void
    {
        // Valid FA4, FA5, FA6 & single-token FA classes
        $this->assertTrue(IconHelper::isFontAwesome('fa fa-handshake-o'));
        $this->assertTrue(IconHelper::isFontAwesome('fas fa-shield-alt'));
        $this->assertTrue(IconHelper::isFontAwesome('far fa-eye'));
        $this->assertTrue(IconHelper::isFontAwesome('fab fa-linkedin'));
        $this->assertTrue(IconHelper::isFontAwesome('fa-solid fa-shield-halved'));
        $this->assertTrue(IconHelper::isFontAwesome('fa-regular fa-eye'));
        $this->assertTrue(IconHelper::isFontAwesome('fa-brands fa-whatsapp'));
        $this->assertTrue(IconHelper::isFontAwesome('fa-award'));

        $this->assertSame('fa-solid fa-shield-halved', IconHelper::sanitizeClass('  fa-solid   fa-shield-halved! '));
        $this->assertSame('fa fa-handshake-o', IconHelper::sanitizeClass('fa fa-handshake-o'));

        // Legacy storage paths & invalid non-FA strings
        $this->assertFalse(IconHelper::isFontAwesome('key-figures/icons/abc.png'));
        $this->assertFalse(IconHelper::isFontAwesome('halaman-solusi/subpage/icon/item.svg'));
        $this->assertFalse(IconHelper::isFontAwesome('about-us/details/sofa-icon.png'));
        $this->assertFalse(IconHelper::isFontAwesome('not-an-icon'));
        $this->assertFalse(IconHelper::isFontAwesome(''));
        $this->assertFalse(IconHelper::isFontAwesome(null));

        $this->assertNull(IconHelper::sanitizeClass('key-figures/icons/abc.png'));
        $this->assertNull(IconHelper::sanitizeClass('not-an-icon'));
        $this->assertNull(IconHelper::sanitizeClass('!!!'));
        $this->assertNull(IconHelper::sanitizeClass(''));
    }

    public function test_key_figures_supports_fa_icon_validation_and_legacy_storage_cleanup(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('key-figures/icons/legacy.png', 'img');
        Storage::disk('public')->put('key-figures/icons/delete-me.png', 'img');

        // Reject invalid non-FA class
        $this->actingAs($this->admin)
            ->from(route('pengaturan-key-figure.create'))
            ->post(route('pengaturan-key-figure.store'), [
                'Konten' => '100+',
                'Keterangan' => 'Klien',
                'Icon' => 'not-an-icon',
            ])
            ->assertRedirect(route('pengaturan-key-figure.create'))
            ->assertSessionHasErrors('Icon');

        // Store valid FA6 icon
        $this->actingAs($this->admin)
            ->post(route('pengaturan-key-figure.store'), [
                'Konten' => '250+',
                'Keterangan' => 'Penghargaan',
                'Icon' => 'fa-solid fa-award',
            ])
            ->assertRedirect(route('pengaturan-key-figure.index'));

        $this->assertDatabaseHas('key_figures', [
            'Konten' => '250+',
            'Icon' => 'fa-solid fa-award',
        ]);

        // Legacy image path preserved on unchanged update and omitted Icon key
        $legacy = KeyFigures::create([
            'Konten' => '50',
            'Keterangan' => 'Tahun',
            'Icon' => 'key-figures/icons/legacy.png',
        ]);

        $this->actingAs($this->admin)
            ->put(route('pengaturan-key-figure.update', $legacy->id), [
                'Konten' => '51',
                'Keterangan' => 'Tahun',
                'Icon' => 'key-figures/icons/legacy.png',
            ])
            ->assertRedirect(route('pengaturan-key-figure.index'));

        $this->assertSame('key-figures/icons/legacy.png', $legacy->fresh()->Icon);
        Storage::disk('public')->assertExists('key-figures/icons/legacy.png');

        $this->actingAs($this->admin)
            ->put(route('pengaturan-key-figure.update', $legacy->id), [
                'Konten' => '52',
                'Keterangan' => 'Tahun',
            ])
            ->assertRedirect(route('pengaturan-key-figure.index'));

        $this->assertSame('key-figures/icons/legacy.png', $legacy->fresh()->Icon);
        Storage::disk('public')->assertExists('key-figures/icons/legacy.png');

        // Replacing legacy path with FA icon deletes old storage file
        $this->actingAs($this->admin)
            ->put(route('pengaturan-key-figure.update', $legacy->id), [
                'Konten' => '53',
                'Keterangan' => 'Tahun',
                'Icon' => 'fa-solid fa-trophy',
            ])
            ->assertRedirect(route('pengaturan-key-figure.index'));

        $this->assertSame('fa-solid fa-trophy', $legacy->fresh()->Icon);
        Storage::disk('public')->assertMissing('key-figures/icons/legacy.png');

        // Destroying legacy item deletes file
        $toDelete = KeyFigures::create([
            'Konten' => '99',
            'Keterangan' => 'Delete',
            'Icon' => 'key-figures/icons/delete-me.png',
        ]);

        $this->actingAs($this->admin)
            ->delete(route('pengaturan-key-figure.destroy', $toDelete->id))
            ->assertOk();

        Storage::disk('public')->assertMissing('key-figures/icons/delete-me.png');
    }

    public function test_why_choose_us_and_security_tier_store_update_destroy_handle_fa_and_legacy_icons(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('why-choose-us/icons/old.png', 'img');
        Storage::disk('public')->put('why-choose-us/icons/destroy.png', 'img');
        Storage::disk('public')->put('security-tiers/icons/old.png', 'img');
        Storage::disk('public')->put('security-tiers/icons/destroy.png', 'img');

        // WhyChooseUs: reject invalid icon, accept valid FA6
        $this->actingAs($this->admin)
            ->from(route('why-choose-us.create'))
            ->post(route('why-choose-us.store'), [
                'Icon' => 'invalid-icon',
                'Urutan' => 1,
                'Status' => 1,
                'translations' => ['id' => ['Judul' => 'Aman', 'Deskripsi' => 'Desc']],
            ])
            ->assertSessionHasErrors('Icon');

        $this->actingAs($this->admin)
            ->post(route('why-choose-us.store'), [
                'Icon' => 'fa-solid fa-shield-halved',
                'Urutan' => 1,
                'Status' => 1,
                'translations' => ['id' => ['Judul' => 'Keamanan Tinggi', 'Deskripsi' => 'Desc']],
            ])
            ->assertRedirect(route('why-choose-us.index'));

        $this->assertDatabaseHas('why_choose_us', ['Icon' => 'fa-solid fa-shield-halved']);

        // WhyChooseUs legacy preserved then cleared -> deletes storage file
        $wcuLegacy = WhyChooseUs::create(['Icon' => 'why-choose-us/icons/old.png', 'Urutan' => 2, 'Status' => 1]);
        $this->actingAs($this->admin)
            ->put(route('why-choose-us.update', $wcuLegacy->id), [
                'Icon' => 'why-choose-us/icons/old.png',
                'Urutan' => 2,
                'Status' => 1,
                'translations' => ['id' => ['Judul' => 'Legacy', 'Deskripsi' => 'Desc']],
            ])
            ->assertRedirect(route('why-choose-us.index'));

        $this->assertSame('why-choose-us/icons/old.png', $wcuLegacy->fresh()->Icon);
        Storage::disk('public')->assertExists('why-choose-us/icons/old.png');

        $this->actingAs($this->admin)
            ->put(route('why-choose-us.update', $wcuLegacy->id), [
                'Icon' => '',
                'Urutan' => 2,
                'Status' => 1,
                'translations' => ['id' => ['Judul' => 'Cleared', 'Deskripsi' => 'Desc']],
            ])
            ->assertRedirect(route('why-choose-us.index'));

        $this->assertNull($wcuLegacy->fresh()->Icon);
        Storage::disk('public')->assertMissing('why-choose-us/icons/old.png');

        $wcuDelete = WhyChooseUs::create(['Icon' => 'why-choose-us/icons/destroy.png', 'Urutan' => 3, 'Status' => 1]);
        $this->actingAs($this->admin)->delete(route('why-choose-us.destroy', $wcuDelete->id))->assertOk();
        Storage::disk('public')->assertMissing('why-choose-us/icons/destroy.png');

        // SecurityTier: reject invalid icon, accept valid FA6
        $this->actingAs($this->admin)
            ->from(route('security-tier.create'))
            ->post(route('security-tier.store'), [
                'NomorTier' => '09',
                'Icon' => 'bad',
                'Urutan' => 9,
                'Status' => 1,
                'translations' => ['id' => ['Judul' => 'Tier Uji', 'Deskripsi' => 'Desc']],
            ])
            ->assertSessionHasErrors('Icon');

        $this->actingAs($this->admin)
            ->post(route('security-tier.store'), [
                'NomorTier' => '09',
                'Icon' => 'fa-regular fa-eye',
                'Urutan' => 9,
                'Status' => 1,
                'translations' => ['id' => ['Judul' => 'Tier Overt', 'Deskripsi' => 'Desc']],
            ])
            ->assertRedirect(route('homepage.index'));

        $this->assertDatabaseHas('security_tiers', ['NomorTier' => '09', 'Icon' => 'fa-regular fa-eye']);

        // SecurityTier legacy preserved then replaced -> deletes old file
        $tierLegacy = SecurityTier::create(['NomorTier' => '10', 'Icon' => 'security-tiers/icons/old.png', 'Urutan' => 10, 'Status' => 1]);
        $this->actingAs($this->admin)
            ->put(route('security-tier.update', $tierLegacy->id), [
                'NomorTier' => '10',
                'Icon' => 'security-tiers/icons/old.png',
                'Urutan' => 10,
                'Status' => 1,
                'translations' => ['id' => ['Judul' => 'Tier 10', 'Deskripsi' => 'Desc']],
            ])
            ->assertRedirect(route('homepage.index'));

        $this->assertSame('security-tiers/icons/old.png', $tierLegacy->fresh()->Icon);
        Storage::disk('public')->assertExists('security-tiers/icons/old.png');

        $this->actingAs($this->admin)
            ->put(route('security-tier.update', $tierLegacy->id), [
                'NomorTier' => '10',
                'Icon' => 'fa-solid fa-lock',
                'Urutan' => 10,
                'Status' => 1,
                'translations' => ['id' => ['Judul' => 'Tier 10', 'Deskripsi' => 'Desc']],
            ])
            ->assertRedirect(route('homepage.index'));

        $this->assertSame('fa-solid fa-lock', $tierLegacy->fresh()->Icon);
        Storage::disk('public')->assertMissing('security-tiers/icons/old.png');

        $tierDelete = SecurityTier::create(['NomorTier' => '11', 'Icon' => 'security-tiers/icons/destroy.png', 'Urutan' => 11, 'Status' => 1]);
        $this->actingAs($this->admin)->delete(route('security-tier.destroy', $tierDelete->id))->assertOk();
        Storage::disk('public')->assertMissing('security-tiers/icons/destroy.png');
    }

    public function test_halaman_solusi_subpage_validates_item_icons_atomically_and_renders_mixed_icons(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('halaman-solusi/subpage/icon/old.svg', '<svg></svg>');

        $solusi = HalamanSolusi::create([
            'Judul' => 'Solusi Uji',
            'Slug' => 'solusi-uji-' . uniqid(),
            'IsPublished' => true,
        ]);
        $detail = HalamanSolusiDetail::create([
            'HalamanSolusiId' => $solusi->id,
            'Judul' => 'Detail Uji',
        ]);
        $subpage = HalamanSolusiSubpage::create([
            'HalamanSolusiDetailId' => $detail->id,
            'Judul' => 'Sub Judul Awal',
            'Slug' => 'sub-uji-' . uniqid(),
            'IsPublished' => true,
        ]);
        $sec2Item = HalamanSolusiSubpageItem::create([
            'HalamanSolusiSubpageId' => $subpage->id,
            'Section' => 'section2',
            'Icon' => 'halaman-solusi/subpage/icon/old.svg',
            'Judul' => 'Legacy Item',
            'SortOrder' => 0,
        ]);

        $editSubUrl = route('halaman-solusi.detail.edit', encrypt($detail->id));

        // Atomic validation failure: subpage Judul must remain unchanged
        $this->actingAs($this->admin)
            ->from($editSubUrl)
            ->put(route('halaman-solusi.detail.update', encrypt($detail->id)), [
                'Slug' => $subpage->Slug,
                'IsPublished' => '1',
                'translations' => [
                    'id' => ['Judul' => 'Judul Tidak Boleh Tersimpan'],
                    'en' => ['Judul' => 'Should Not Save'],
                ],
                'solusi_items' => [
                    [
                        'Id' => $sec2Item->id,
                        'Icon' => 'invalid-icon',
                        'translations' => ['id' => ['Judul' => 'Item 1']],
                    ],
                ],
            ])
            ->assertRedirect($editSubUrl)
            ->assertSessionHasErrors('solusi_items.0.Icon');

        $this->assertSame('Sub Judul Awal', $subpage->fresh()->Judul);

        // Valid update: section2 keeps untouched legacy svg, section3 saves FA6 icon
        $this->actingAs($this->admin)
            ->put(route('halaman-solusi.detail.update', encrypt($detail->id)), [
                'Slug' => $subpage->Slug,
                'IsPublished' => '1',
                'translations' => [
                    'id' => ['Judul' => 'Sub Judul Baru', 'Sec2Judul' => 'Sec2', 'Sec3Judul' => 'Sec3'],
                    'en' => ['Judul' => 'New Sub Title'],
                ],
                'solusi_items' => [
                    [
                        'Id' => $sec2Item->id,
                        'Icon' => 'halaman-solusi/subpage/icon/old.svg',
                        'translations' => ['id' => ['Judul' => 'Item Legacy']],
                    ],
                ],
                'security_items' => [
                    [
                        'Icon' => 'fa-solid fa-fingerprint',
                        'translations' => ['id' => ['Judul' => 'Biometrik']],
                    ],
                ],
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertSame('halaman-solusi/subpage/icon/old.svg', $sec2Item->fresh()->Icon);
        Storage::disk('public')->assertExists('halaman-solusi/subpage/icon/old.svg');
        $this->assertDatabaseHas('halaman_solusi_subpage_items', [
            'HalamanSolusiSubpageId' => $subpage->id,
            'Section' => 'section3',
            'Icon' => 'fa-solid fa-fingerprint',
        ]);

        // Frontend subpage renders both legacy <img> and FA6 <i>
        $res = $this->get('/id/solusi/' . $solusi->Slug . '/' . $subpage->Slug . '/');
        $res->assertStatus(200);
        $res->assertSee('halaman-solusi/subpage/icon/old.svg', false);
        $res->assertSee('<i class="fa-solid fa-fingerprint text-lg text-brand-300"></i>', false);
    }

    public function test_about_us_sync_details_handles_icon_fa_clearing_validation_and_image_preservation(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('about-us/details/csr-photo.jpg', 'img');

        // Ensure sections exist
        $this->actingAs($this->admin)->get(route('about-us.index'))->assertOk();
        $nilai = AboutUs::findOrFail(2);
        $csr = AboutUs::findOrFail(3);

        $nilaiDetail = AboutUsDetail::create([
            'IdAbout' => $nilai->id,
            'Judul' => 'Integritas',
            'Deskripsi' => 'Desc',
            'Gambar' => 'fa-solid fa-gem',
        ]);
        $csrDetail = AboutUsDetail::create([
            'IdAbout' => $csr->id,
            'Judul' => 'Pendidikan',
            'Deskripsi' => 'Desc CSR',
            'Gambar' => 'about-us/details/csr-photo.jpg',
        ]);

        // Invalid IconFa fails upfront before transaction
        $this->actingAs($this->admin)
            ->from(route('about-us.index'))
            ->put(route('about-us.update'), [
                'sections' => [
                    2 => [
                        'translations' => ['id' => ['Judul' => 'Nilai Inti']],
                        'details' => [
                            [
                                'id' => $nilaiDetail->id,
                                'IconFa' => 'invalid-class',
                                'translations' => ['id' => ['Judul' => 'Integritas Berubah', 'Deskripsi' => 'Desc']],
                            ],
                        ],
                    ],
                ],
            ])
            ->assertRedirect(route('about-us.index'))
            ->assertSessionHasErrors('sections.2.details.0.IconFa');

        $this->assertSame('fa-solid fa-gem', $nilaiDetail->fresh()->Gambar);

        // Clearing IconFa clears Gambar for FA item, while CSR image without IconFa is preserved
        $this->actingAs($this->admin)
            ->put(route('about-us.update'), [
                'sections' => [
                    2 => [
                        'translations' => ['id' => ['Judul' => 'Nilai Inti']],
                        'details' => [
                            [
                                'id' => $nilaiDetail->id,
                                'IconFa' => '',
                                'translations' => ['id' => ['Judul' => 'Integritas', 'Deskripsi' => 'Desc']],
                            ],
                        ],
                    ],
                    3 => [
                        'translations' => ['id' => ['Judul' => 'CSR']],
                        'details' => [
                            [
                                'id' => $csrDetail->id,
                                'translations' => ['id' => ['Judul' => 'Pendidikan', 'Deskripsi' => 'Desc CSR']],
                            ],
                        ],
                    ],
                ],
            ])
            ->assertRedirect(route('about-us.index'));

        $this->assertNull($nilaiDetail->fresh()->Gambar);
        $this->assertSame('about-us/details/csr-photo.jpg', $csrDetail->fresh()->Gambar);
        Storage::disk('public')->assertExists('about-us/details/csr-photo.jpg');
    }

    public function test_menu_and_views_handle_icon_picker_and_legacy_rendering(): void
    {
        // Menu store rejects invalid icon, accepts FA6, update preserves omitted Icon
        $this->actingAs($this->admin)
            ->from(route('menu.create'))
            ->post(route('menu.store'), [
                'translations' => ['id' => ['NamaMenu' => 'Menu Uji']],
                'JenisLink' => 'custom',
                'Url' => '/id/',
                'Icon' => 'not-fa',
            ])
            ->assertRedirect(route('menu.create'))
            ->assertSessionHasErrors('Icon');

        $this->actingAs($this->admin)
            ->post(route('menu.store'), [
                'translations' => ['id' => ['NamaMenu' => 'Menu Uji FA6']],
                'JenisLink' => 'custom',
                'Url' => '/id/',
                'Icon' => 'fa-solid fa-house',
            ])
            ->assertRedirect(route('menu.index'));

        $menu = Menu::where('SlugMenu', 'like', 'menu-uji-fa6%')->firstOrFail();
        $this->assertSame('fa-solid fa-house', $menu->Icon);

        $this->actingAs($this->admin)
            ->put(route('menu.update', $menu->id), [
                'translations' => ['id' => ['NamaMenu' => 'Menu Uji FA6 Edited']],
                'JenisLink' => 'custom',
                'Url' => '/id/',
            ])
            ->assertRedirect(route('menu.index'));

        $this->assertSame('fa-solid fa-house', $menu->fresh()->Icon);

        // Admin forms render FA 6.4.0 CDN & shared icon-picker markup
        $this->actingAs($this->admin)
            ->get(route('pengaturan-key-figure.create'))
            ->assertOk()
            ->assertSee('font-awesome/6.4.0/css/all.min.css', false)
            ->assertSee('fa-icon-picker-input', false)
            ->assertSee('assets/js/icon-picker.js', false);

        // Frontend landing & about pages render FA5/FA6 icons cleanly
        KeyFigures::create(['Konten' => '777', 'Keterangan' => 'Uji FA6', 'Icon' => 'fa-solid fa-award']);
        WhyChooseUs::create(['Icon' => 'fas fa-lock', 'Urutan' => 99, 'Status' => 1])
            ->translations()->create(['Locale' => 'id', 'Judul' => 'Uji FA5', 'Deskripsi' => 'Desc']);
        SecurityTier::create(['NomorTier' => '99', 'Icon' => 'fa-solid fa-shield-halved', 'Urutan' => 99, 'Status' => 1])
            ->translations()->create(['Locale' => 'id', 'Judul' => 'Uji Tier FA6', 'Deskripsi' => 'Desc', 'Features' => []]);

        $home = $this->get('/id/');
        $home->assertOk();
        $home->assertSee('<i class="fa-solid fa-award text-brand-600"></i>', false);
        $home->assertSee('<i class="fas fa-lock text-lg"></i>', false);
        $home->assertSee('<i class="fa-solid fa-shield-halved text-lg text-slate-800"></i>', false);

        $about = $this->get('/id/tentang-kami/');
        $about->assertOk();
    }
}

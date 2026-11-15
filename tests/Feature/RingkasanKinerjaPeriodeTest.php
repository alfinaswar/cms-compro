<?php

namespace Tests\Feature;

use App\Models\PengaturanKinerjaKeuangan;
use App\Models\RingkasanKinerjaNilai;
use App\Models\RingkasanKinerjaPos;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class RingkasanKinerjaPeriodeTest extends TestCase
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

    public function test_view_renders_mode_window_and_sustainable_elements(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.investor.ringkasan-kinerja.index'));

        $response->assertStatus(200);
        $response->assertSee('id="selectModeWindow"', false);
        $response->assertSee('id="wrapperJumlahTahun"', false);
        $response->assertSee('id="wrapperTahunMulai"', false);
        $response->assertSee('id="wrapperTahunSelesai"', false);
        $response->assertSee('updateModeFields', false);
    }

    public function test_update_periode_mode_otomatis_succeeds_without_tahun_mulai_and_selesai(): void
    {
        $payload = [
            'ModeWindow' => 'Otomatis',
            'JumlahTahun' => 4,
            'PertumbuhanRevenue' => '+25.0% YoY',
            'PertumbuhanProfit' => '+30.0% YoY',
            'Subjudul' => 'Kinerja 4 tahun terakhir',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.investor.ringkasan-kinerja.update-periode'), $payload);

        $response->assertSessionHas('success');

        $pengaturan = PengaturanKinerjaKeuangan::first();
        $this->assertEquals('Otomatis', $pengaturan->ModeWindow);
        $this->assertEquals(4, $pengaturan->JumlahTahun);
        $this->assertEquals('+25.0% YoY', $pengaturan->PertumbuhanRevenue);
    }

    public function test_update_periode_mode_kustom_succeeds_without_jumlah_tahun_and_calculates_it(): void
    {
        $payload = [
            'ModeWindow' => 'Kustom',
            'TahunMulai' => 2019,
            'TahunSelesai' => 2024,
            'PertumbuhanRevenue' => '+40.0% YoY',
            'PertumbuhanProfit' => '+50.0% YoY',
            'Subjudul' => 'Rentang Kustom 2019-2024',
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.investor.ringkasan-kinerja.update-periode'), $payload);

        $response->assertSessionHas('success');

        $pengaturan = PengaturanKinerjaKeuangan::first();
        $this->assertEquals('Kustom', $pengaturan->ModeWindow);
        $this->assertEquals(2019, $pengaturan->TahunMulai);
        $this->assertEquals(2024, $pengaturan->TahunSelesai);
        $this->assertEquals(6, $pengaturan->JumlahTahun); // (2024 - 2019) + 1
    }

    public function test_update_periode_mode_kustom_validates_gte_tahun_mulai(): void
    {
        $payload = [
            'ModeWindow' => 'Kustom',
            'TahunMulai' => 2024,
            'TahunSelesai' => 2020, // Tidak valid karena lebih kecil dari TahunMulai
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.investor.ringkasan-kinerja.update-periode'), $payload);

        $response->assertSessionHasErrors(['TahunSelesai']);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\EnforceTrailingSlash::class);
    }

    public function test_guest_cannot_access_edit_profile(): void
    {
        $this->get('/admin/profile/')
            ->assertRedirect(route('login'));

        $this->put('/admin/profile/', ['name' => 'Hacker', 'email' => 'hacker@example.com'])
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_edit_profile_and_navbar_button(): void
    {
        $user = User::factory()->create([
            'bio_penulis' => 'Bio awal penulis uji',
        ]);

        $response = $this->actingAs($user)->get('/admin/profile/');

        $response->assertStatus(200);
        $response->assertSee('Edit Profile');
        $response->assertSee('Informasi Penulis (News Detail)');
        $response->assertSee('Bio awal penulis uji');
        $response->assertSee('name="current_password"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('name="password_confirmation"', false);
    }

    public function test_update_profile_and_author_bio_reflects_on_news_detail_without_logout(): void
    {
        $user = User::factory()->create([
            'name' => 'Penulis Uji',
            'email' => 'penulis.uji@example.com',
            'bio_penulis' => User::DEFAULT_AUTHOR_BIO,
        ]);

        $berita = Berita::where('Status', 'Diterbitkan')->firstOrFail();
        $berita->update(['user_id' => $user->id]);

        $newBio = "Analis keamanan siber & teknologi.\n<script>alert('xss')</script>";

        $response = $this->actingAs($user)->put('/admin/profile/', [
            'name' => 'Penulis Uji Baru',
            'email' => 'penulis.uji.baru@example.com',
            'bio_penulis' => $newBio,
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('success');
        $this->assertAuthenticatedAs($user);

        $user->refresh();
        $this->assertSame('Penulis Uji Baru', $user->name);
        $this->assertSame('penulis.uji.baru@example.com', $user->email);
        $this->assertSame($newBio, $user->bio_penulis);

        // Render news detail ID dan EN, pastikan nama penulis & bio tampil serta XSS ter-escape
        foreach (['/id/berita/' . $berita->Slug . '/', '/en/news/' . $berita->Slug . '/'] as $url) {
            $detail = $this->get($url);
            $detail->assertStatus(200);
            $detail->assertSee('<h3 class="text-lg font-bold text-slate-900 mb-2">Penulis Uji Baru</h3>', false);
            $detail->assertSee('Analis keamanan siber &amp; teknologi.', false);
            $detail->assertSee('&lt;script&gt;alert(&#039;xss&#039;)&lt;/script&gt;', false);
            $detail->assertDontSee("<script>alert('xss')</script>", false);
        }
    }

    public function test_blank_bio_falls_back_to_default_on_news_detail_and_unlinked_article_uses_fallback_user(): void
    {
        $admin = User::orderBy('id')->firstOrFail();
        $this->actingAs($admin)->put('/admin/profile/', [
            'name' => $admin->name,
            'email' => $admin->email,
            'bio_penulis' => '',
        ])->assertRedirect(route('profile.edit'));

        $berita = Berita::where('Status', 'Diterbitkan')->firstOrFail();
        $berita->update([
            'user_id' => null,
            'Penulis' => 'Penulis Tidak Terdaftar',
            'UserCreate' => 'Tidak Ada',
        ]);

        $detail = $this->get('/id/berita/' . $berita->Slug . '/');
        $detail->assertStatus(200);
        $detail->assertSee(User::DEFAULT_AUTHOR_BIO);

        // Sekarang isi bio custom di admin pertama, artikel lama tanpa user_id ikut berubah
        $this->actingAs($admin)->put('/admin/profile/', [
            'name' => $admin->name,
            'email' => $admin->email,
            'bio_penulis' => 'Bio dinamis redaksi resmi.',
        ])->assertRedirect(route('profile.edit'));

        $this->get('/id/berita/' . $berita->Slug . '/')
            ->assertStatus(200)
            ->assertSee('Bio dinamis redaksi resmi.');
    }

    public function test_password_change_validates_current_password_and_complexity_then_logs_out(): void
    {
        $oldPassword = 'OldPassword!123';
        $newPassword = 'NewPassword!456';

        $user = User::factory()->create([
            'password' => Hash::make($oldPassword),
            'bio_penulis' => 'Bio tetap aman',
        ]);

        // 1. Salah current_password
        $this->actingAs($user)
            ->from('/admin/profile/')
            ->put('/admin/profile/', [
                'name' => $user->name,
                'email' => $user->email,
                'bio_penulis' => $user->bio_penulis,
                'current_password' => 'SalahPassword!1',
                'password' => $newPassword,
                'password_confirmation' => $newPassword,
            ])
            ->assertRedirect('/admin/profile/')
            ->assertSessionHasErrors('current_password');

        // 2. Password baru lemah (kurang dari 12 / tanpa simbol)
        $this->actingAs($user)
            ->from('/admin/profile/')
            ->put('/admin/profile/', [
                'name' => $user->name,
                'email' => $user->email,
                'bio_penulis' => $user->bio_penulis,
                'current_password' => $oldPassword,
                'password' => 'weakpass',
                'password_confirmation' => 'weakpass',
            ])
            ->assertRedirect('/admin/profile/')
            ->assertSessionHasErrors('password');

        // 3. Password baru valid -> hash berubah, user logout, redirect login dengan status, log tanpa password
        $response = $this->actingAs($user)->put('/admin/profile/', [
            'name' => $user->name,
            'email' => $user->email,
            'bio_penulis' => 'Bio setelah ganti password',
            'current_password' => $oldPassword,
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('status');
        $this->assertGuest();

        $user->refresh();
        $this->assertTrue(Hash::check($newPassword, $user->password));
        $this->assertSame('Bio setelah ganti password', $user->bio_penulis);

        $lastActivity = Activity::where('subject_id', $user->id)
            ->where('subject_type', User::class)
            ->latest('id')
            ->first();

        $this->assertNotNull($lastActivity);
        $props = $lastActivity->properties->toArray();
        $this->assertTrue($props['password_changed'] ?? false);
        $this->assertArrayNotHasKey('password', $props['attributes'] ?? []);
        $this->assertArrayNotHasKey('password', $props['old'] ?? []);
    }

    public function test_news_detail_prev_next_links_and_null_publish_date_render_without_error(): void
    {
        $datedPosts = Berita::where('Status', 'Diterbitkan')
            ->whereNotNull('TanggalPublikasi')
            ->orderBy('TanggalPublikasi')
            ->orderBy('id')
            ->get();

        $this->assertGreaterThanOrEqual(3, $datedPosts->count());
        $middle = $datedPosts[1];

        foreach ([
            ['url' => '/id/berita/' . $middle->Slug . '/', 'prefix' => '/id/berita/'],
            ['url' => '/en/news/' . $middle->Slug . '/', 'prefix' => '/en/news/'],
        ] as $case) {
            $response = $this->get($case['url']);
            $response->assertStatus(200);

            $prevPost = $response->viewData('prevPost');
            $nextPost = $response->viewData('nextPost');
            $this->assertNotNull($prevPost);
            $this->assertNotNull($nextPost);
            $this->assertNotSame($middle->id, $prevPost->id);
            $this->assertNotSame($middle->id, $nextPost->id);

            $prevHref = $case['prefix'] . $prevPost->Slug;
            $nextHref = $case['prefix'] . $nextPost->Slug;

            $response->assertSee($prevHref);
            $response->assertSee($nextHref);

            $this->get($prevHref . '/')->assertStatus(200);
            $this->get($nextHref . '/')->assertStatus(200);
        }

        // Pastikan artikel dengan TanggalPublikasi NULL tidak menyebabkan error 500 pada query prev/next
        $nullDatePost = Berita::where('Status', 'Diterbitkan')
            ->whereNull('TanggalPublikasi')
            ->first();

        if (!$nullDatePost) {
            $nullDatePost = Berita::where('Status', 'Diterbitkan')->firstOrFail();
            $nullDatePost->update(['TanggalPublikasi' => null]);
        }

        $nullResponse = $this->get('/id/berita/' . $nullDatePost->Slug . '/');
        $nullResponse->assertStatus(200);
        $this->assertNotSame($nullDatePost->id, optional($nullResponse->viewData('prevPost'))->id);
        $this->assertNotSame($nullDatePost->id, optional($nullResponse->viewData('nextPost'))->id);
    }
}

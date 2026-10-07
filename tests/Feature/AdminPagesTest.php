<?php

namespace Tests\Feature;

use App\Enums\AvailabilityStatus;
use App\Enums\PostStatus;
use App\Filament\Pages\AdminLogin;
use App\Filament\Pages\ManageContactInfo;
use App\Filament\Pages\ManageLandingPage;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SiteSetting;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\SiteSettingsSeeder;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class AdminPagesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Filament::setCurrentPanel(Filament::getPanel('admin'));
    }

    public function test_admins_log_in_with_email(): void
    {
        $this->assertAdminLogin('email');
    }

    public function test_admins_log_in_with_username(): void
    {
        $this->assertAdminLogin('username');
    }

    public function test_incorrect_admin_credentials_are_rejected(): void
    {
        $user = User::factory()->create();

        Livewire::test(AdminLogin::class)
            ->fillForm(['email' => $user->email, 'password' => 'incorrect'])
            ->call('authenticate')
            ->assertHasFormErrors(['email']);

        $this->assertGuest();
    }

    public function test_authenticated_admin_pages_render(): void
    {
        $this->actingAs(User::factory()->create());

        foreach ([
            '/admin',
            '/admin/manage-site-settings',
            '/admin/manage-landing-page',
            '/admin/manage-about-page',
            '/admin/manage-contact-info',
            '/admin/manage-social-media',
        ] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_admin_sidebar_groups_resources_and_pages(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin')->assertOk();

        $response->assertSee('Konten Situs');
        $response->assertSee('Katalog Produk');
        $response->assertSee('Blog');
    }

    public function test_overview_shows_product_and_post_statistics(): void
    {
        $this->actingAs(User::factory()->create());

        $category = ProductCategory::create([
            'name' => 'Tas',
            'slug' => 'tas',
        ]);
        $postCategory = PostCategory::create([
            'name' => 'Berita',
            'slug' => 'berita',
        ]);

        Product::create([
            'category_id' => $category->id,
            'name' => 'Tas A',
            'slug' => 'tas-a',
            'price' => 100000,
            'availability_status' => AvailabilityStatus::ReadyStock,
            'primary_image' => 'products/a.jpg',
        ]);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Tas B',
            'slug' => 'tas-b',
            'price' => 150000,
            'availability_status' => AvailabilityStatus::PreOrder,
            'primary_image' => 'products/b.jpg',
        ]);
        Post::create([
            'post_category_id' => $postCategory->id,
            'title' => 'Draft',
            'slug' => 'draft',
            'content' => 'Draft',
            'status' => PostStatus::Draft,
        ]);
        Post::create([
            'post_category_id' => $postCategory->id,
            'title' => 'Live',
            'slug' => 'live',
            'content' => 'Live',
            'status' => PostStatus::Published,
            'published_at' => now()->subDay(),
        ]);

        $this->get('/admin')
            ->assertOk()
            ->assertSee('Total Produk')
            ->assertSee('2')
            ->assertSee('Ready Stock')
            ->assertSee('Pre-Order')
            ->assertSee('Stok Habis')
            ->assertSee('Total Artikel')
            ->assertSee('Draft')
            ->assertSee('Artikel Terbit')
            ->assertSee('1');
    }

    public function test_admin_sidebar_has_collapsible_groups_and_site_link(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin')->assertOk();

        $response->assertSee('Kembali ke Situs');
        $response->assertSee('href="/"', false);
        $response->assertSee('target="_blank"', false);
        $response->assertSee('toggleCollapsedGroup', false);
    }

    public function test_landing_page_loads_and_saves_separate_payloads(): void
    {
        $this->actingAs(User::factory()->create());
        $this->seed(SiteSettingsSeeder::class);

        $this->get('/admin/manage-landing-page')
            ->assertOk()
            ->assertSee('Hero')
            ->assertSee('About')
            ->assertSee('Purpose')
            ->assertSee('Stats');

        $component = Livewire::test(ManageLandingPage::class)
            ->assertFormSet(['landing_hero.headline' => setting('landing_hero.headline')])
            ->fillForm([
                'landing_hero.headline' => 'New hero',
                'landing_about.title' => 'New about',
                'landing_purpose.title' => 'New purpose',
                'landing_stats.stats' => [['value' => '75+', 'label' => 'Pengrajin']],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('New hero', setting('landing_hero.headline'));
        $this->assertSame('New about', setting('landing_about.title'));
        $this->assertSame('New purpose', setting('landing_purpose.title'));
        $this->assertSame('75+', setting('landing_stats.stats.0.value'));
        $this->assertSame(4, SiteSetting::where('group', 'landing')->count());
        $this->assertArrayNotHasKey('landing_about', setting('landing_hero'));

        $component->fillForm(['landing_hero.headline' => ''])
            ->call('save')
            ->assertHasFormErrors(['landing_hero.headline' => 'required']);

        $this->assertSame('New hero', setting('landing_hero.headline'));
    }

    public function test_site_settings_seeder_stores_landing_hero_in_landing_group(): void
    {
        $this->seed(SiteSettingsSeeder::class);

        $this->assertSame('landing', SiteSetting::where('key', 'landing_hero')->value('group'));
    }

    public function test_admin_seeder_uses_environment_password_without_changing_existing_admin(): void
    {
        $password = bin2hex(random_bytes(16));
        $original = getenv('ADMIN_PASSWORD');
        putenv("ADMIN_PASSWORD={$password}");

        try {
            $this->seed(AdminUserSeeder::class);
            $user = User::where('email', 'anyamanmansiang@gmail.com')->firstOrFail();
            $this->assertTrue(Hash::check($password, $user->password));

            $hash = $user->password;
            putenv('ADMIN_PASSWORD=changed-password');
            $this->seed(AdminUserSeeder::class);
            $this->assertSame($hash, $user->fresh()->password);
        } finally {
            putenv($original === false ? 'ADMIN_PASSWORD' : "ADMIN_PASSWORD={$original}");
        }
    }

    private function assertAdminLogin(string $field): void
    {
        $user = User::factory()->create();

        Livewire::test(AdminLogin::class)
            ->fillForm(['email' => $user->{$field}, 'password' => 'password'])
            ->call('authenticate')
            ->assertHasNoFormErrors()
            ->assertRedirect('/admin');

        $this->assertAuthenticatedAs($user);
    }

    public function test_contact_info_rejects_non_url_and_accepts_valid_maps_url(): void
    {
        $this->actingAs(User::factory()->create());
        $valid = [
            'whatsapp_number' => '6281234567890',
            'whatsapp_display' => '0812 3456 7890',
            'email' => 'contact@example.com',
        ];

        Livewire::test(ManageContactInfo::class)
            ->fillForm($valid + ['google_maps_embed' => 'javascript:alert(1)'])
            ->call('save')
            ->assertHasFormErrors(['google_maps_embed']);

        Livewire::test(ManageContactInfo::class)
            ->fillForm($valid + ['google_maps_embed' => 'https://maps.google.com/maps?q=Taratak'])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertSame('https://maps.google.com/maps?q=Taratak', setting('contact_info.google_maps_embed'));
    }
}

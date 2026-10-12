<?php

use App\Filament\Pages\ManageSiteSettings;
use App\Models\SiteSetting;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('uses single public logo fallback when settings are empty', function () {
    $this->get('/')
        ->assertOk()
        ->assertSee(asset('images/branding/logo.png'), false)
        ->assertSee('<link rel="icon" href="'.asset('images/branding/logo.png').'">', false)
        ->assertDontSee('logo-full-color.svg', false)
        ->assertDontSee('logo-mark.svg', false)
        ->assertDontSee('logo-light.svg', false);
});

it('uses existing local storage logo override', function () {
    Storage::fake('public');
    Storage::disk('public')->put('settings/custom-logo.png', 'x');

    SiteSetting::create([
        'group' => 'general',
        'key' => 'site_general',
        'payload' => [
            'logo_path' => 'settings/custom-logo.png',
        ],
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee('/storage/settings/custom-logo.png', false)
        ->assertDontSee(asset('images/branding/logo.png'), false);
});

it('falls back when configured logo file is missing', function () {
    Storage::fake('public');

    SiteSetting::create([
        'group' => 'general',
        'key' => 'site_general',
        'payload' => [
            'logo_path' => 'settings/missing-logo.png',
        ],
    ]);

    $this->get('/')
        ->assertOk()
        ->assertSee(asset('images/branding/logo.png'), false);
});

it('renders header footer and favicon branding slots with ivory backing', function () {
    $response = $this->get('/')->assertOk();

    $response->assertSee('class="h-11 w-11 shrink-0 rounded-xl bg-[#FDFBF7] p-1 object-contain sm:h-[52px] sm:w-[52px]"', false);
    $response->assertSee('class="h-12 w-12 shrink-0 rounded-xl bg-[#FDFBF7] p-1 object-contain"', false);
    $response->assertSee('<link rel="icon" href="'.asset('images/branding/logo.png').'">', false);
});

it('renders admin sidebar logo with brand text', function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
    $this->actingAs(User::factory()->create());

    $this->get('/admin')
        ->assertOk()
        ->assertSee('data-admin-brand', false)
        ->assertSee('Anyaman Mansiang');
});

it('renders collapsed sidebar logo inside native expand button while retaining keyboard accessible control', function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
    $this->actingAs(User::factory()->create());

    $this->get('/admin')
        ->assertOk()
        ->assertSee('data-collapsed-sidebar-brand', false)
        ->assertSee('data-admin-brand', false)
        ->assertSee('x-on:click="$store.sidebar.open()"', false)
        ->assertSee('x-show="! $store.sidebar.isOpen"', false)
        ->assertSee(__('filament-panels::layout.actions.sidebar.expand.label'));
});

it('stores allowed site logo upload only', function () {
    Filament::setCurrentPanel(Filament::getPanel('admin'));
    $this->actingAs(User::factory()->create());
    Storage::fake('public');

    Livewire::test(ManageSiteSettings::class)
        ->fillForm([
            'site_name' => 'Anyaman Mansiang',
            'site_tagline' => 'Tagline',
            'logo_path' => UploadedFile::fake()->image('logo.png'),
            'footer_description' => 'Footer',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $payload = SiteSetting::where('key', 'site_general')->value('payload');

    expect($payload['logo_path'])->toStartWith('settings/')
        ->and($payload)->not->toHaveKeys(['logo_light_path', 'logo_mark_path', 'favicon_path']);
});

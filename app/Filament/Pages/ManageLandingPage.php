<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;

class ManageLandingPage extends SettingPage
{
    protected const KEYS = ['landing_hero', 'landing_about', 'landing_purpose', 'landing_stats'];

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationLabel = 'Landing Page';

    protected static ?string $navigationGroup = 'Konten Situs';

    protected static ?int $navigationSort = 1;

    protected static ?string $title = 'Kelola Landing Page';

    protected static string $view = 'filament.pages.manage-landing-page';

    protected function settingKey(): string
    {
        return 'landing_hero';
    }

    protected function settingGroup(): string
    {
        return 'landing';
    }

    protected function loadPayload(): array
    {
        return collect(self::KEYS)
            ->mapWithKeys(fn ($key) => [$key => SiteSetting::where('key', $key)->value('payload') ?? []])
            ->all();
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach (self::KEYS as $key) {
            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['group' => $this->settingGroup(), 'payload' => $data[$key] ?? []]
            );
        }

        Notification::make()
            ->title('Landing page tersimpan')
            ->success()
            ->send();
    }

    protected function formSchema(): array
    {
        return [
            Section::make('Panduan Landing Page')
                ->description('Form ini mengatur isi halaman depan website. Buka setiap tab untuk mengubah bagian yang sesuai, lalu klik Simpan.'),
            Tabs::make('landing-sections')
                ->tabs([
                    Tab::make('Hero')
                        ->schema([
                            Section::make('Bagian pembuka halaman')
                                ->description('Hero tampil paling atas. Atur judul utama, tombol ajakan, dan foto bergeser yang pertama dilihat pengunjung.'),
                            TextInput::make('landing_hero.badge')->label('Badge'),
                            TextInput::make('landing_hero.headline')->label('Headline')->required(),
                            TextInput::make('landing_hero.subheadline')->label('Subheadline'),
                            TextInput::make('landing_hero.cta_text')->label('Teks CTA'),
                            TextInput::make('landing_hero.cta_link')->label('Link CTA')->helperText('Alamat tujuan tombol, contoh: /products atau https://wa.me/6281234567890'),
                            Repeater::make('landing_hero.slides')
                                ->helperText('Foto ditampilkan bergantian. Angka urutan lebih kecil tampil lebih dahulu.')
                                ->label('Slideshow')
                                ->schema([
                                    static::makeImageField('image', 'Gambar'),
                                    TextInput::make('caption')->label('Caption'),
                                    TextInput::make('sort_order')->label('Urutan')->integer()->default(0),
                                ])
                                ->columns(3),
                        ]),
                    Tab::make('About')
                        ->schema([
                            Section::make('Ringkasan tentang koperasi')
                                ->description('Bagian ini mengenalkan koperasi secara singkat pada halaman depan, termasuk foto dan poin keunggulan.'),
                            TextInput::make('landing_about.badge')->label('Badge'),
                            TextInput::make('landing_about.title')->label('Judul'),
                            RichEditor::make('landing_about.description')->label('Deskripsi'),
                            static::makeImageField('landing_about.primary_image', 'Gambar'),
                            Repeater::make('landing_about.highlight_points')
                                ->label('Highlight')
                                ->schema([
                                    TextInput::make('label')->label('Label'),
                                    TextInput::make('desc')->label('Deskripsi'),
                                ])
                                ->columns(2),
                        ]),
                    Tab::make('Purpose')
                        ->schema([
                            Section::make('Tujuan koperasi')
                                ->description('Bagian ini menjelaskan tiga tujuan utama koperasi beserta foto pendukungnya.'),
                            TextInput::make('landing_purpose.badge')->label('Badge'),
                            TextInput::make('landing_purpose.title')->label('Judul'),
                            TextInput::make('landing_purpose.subtitle')->label('Subjudul'),
                            Repeater::make('landing_purpose.items')
                                ->label('Item')
                                ->helperText('Isi tepat tiga tujuan: satu gambar besar di kiri, dua gambar ditumpuk di kanan.')
                                ->minItems(3)
                                ->maxItems(3)
                                ->schema([
                                    TextInput::make('title')->label('Judul'),
                                    TextInput::make('description')->label('Deskripsi'),
                                    static::makeImageField('image', 'Gambar'),
                                ]),
                        ]),
                    Tab::make('Stats')
                        ->schema([
                            Section::make('Angka pencapaian')
                                ->description('Tampilkan angka singkat yang menunjukkan dampak koperasi, seperti jumlah pengrajin atau produk.'),
                            Repeater::make('landing_stats.stats')
                                ->helperText('Nilai boleh memakai tanda, contoh: 50+ atau 100%. Label menjelaskan arti angka.')
                                ->label('Statistik')
                                ->schema([
                                    TextInput::make('value')->label('Nilai'),
                                    TextInput::make('label')->label('Label'),
                                ])
                                ->columns(2),
                        ]),
                ])
                ->persistTabInQueryString(),
        ];
    }
}

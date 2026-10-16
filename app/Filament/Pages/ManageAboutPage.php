<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

class ManageAboutPage extends SettingPage
{
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationLabel = 'Tentang Kami';

    protected static ?string $navigationGroup = 'Konten Situs';

    protected static ?int $navigationSort = 2;

    protected static ?string $title = 'Kelola Halaman Tentang';

    protected static string $view = 'filament.pages.manage-about-page';

    protected function settingKey(): string
    {
        return 'about_content';
    }

    protected function settingGroup(): string
    {
        return 'about';
    }

    protected function formSchema(): array
    {
        return [
            Section::make('Panduan Halaman Tentang Kami')
                ->description('Form ini mengatur cerita koperasi pada halaman Tentang Kami: foto pembuka, sejarah, dampak, dan galeri kegiatan.'),
            static::makeImageField('hero_image', 'Gambar Hero')->helperText('Foto pembuka yang tampil di bagian atas halaman.'),
            TextInput::make('history_title')->label('Judul Sejarah')->required(),
            RichEditor::make('history_narrative')->label('Naratif Sejarah')->required(),
            TextInput::make('impact_title')->label('Judul Dampak')->required(),
            RichEditor::make('impact_narrative')->label('Naratif Dampak')->required(),
            Repeater::make('gallery')
                ->label('Galeri')
                ->helperText('Tambahkan foto kegiatan koperasi. Caption menjelaskan isi foto.')
                ->schema([
                    static::makeImageField('image', 'Gambar'),
                    TextInput::make('caption')->label('Caption'),
                ])
                ->columns(2),
        ];
    }
}

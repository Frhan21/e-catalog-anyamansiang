<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;

class ManageSiteSettings extends SettingPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Pengaturan Situs';

    protected static ?string $navigationGroup = 'Konten Situs';

    protected static ?int $navigationSort = 3;

    protected static ?string $title = 'Kelola Pengaturan Global';

    protected static string $view = 'filament.pages.manage-site-settings';

    protected function settingKey(): string
    {
        return 'site_general';
    }

    protected function settingGroup(): string
    {
        return 'general';
    }

    protected function formSchema(): array
    {
        return [
            TextInput::make('site_name')->label('Nama Situs')->required(),
            TextInput::make('site_tagline')->label('Tagline')->required(),
            static::makeImageField('logo_path', 'Logo'),
            static::makeImageField('favicon_path', 'Favicon'),
            RichEditor::make('footer_description')->label('Deskripsi Footer'),
        ];
    }
}

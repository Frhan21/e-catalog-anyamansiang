<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;

class ManageSocialMedia extends SettingPage
{
    protected static ?string $navigationIcon = 'heroicon-o-share';

    protected static ?string $navigationLabel = 'Media Sosial';

    protected static ?string $navigationGroup = 'Konten Situs';

    protected static ?int $navigationSort = 5;

    protected static ?string $title = 'Kelola Media Sosial';

    protected static string $view = 'filament.pages.manage-social-media';

    protected function settingKey(): string
    {
        return 'social_media';
    }

    protected function settingGroup(): string
    {
        return 'social';
    }

    protected function formSchema(): array
    {
        return [
            TextInput::make('instagram')->label('Instagram')->url(),
            TextInput::make('tiktok')->label('TikTok')->url(),
            TextInput::make('facebook')->label('Facebook')->url(),
            TextInput::make('youtube')->label('YouTube')->url(),
        ];
    }
}

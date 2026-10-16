<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
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
            Section::make('Panduan Pengaturan Situs')
                ->description('Form ini mengatur identitas yang dipakai di seluruh website, termasuk nama, logo, tagline, dan keterangan bagian bawah halaman.'),
            TextInput::make('site_name')->label('Nama Situs')->helperText('Nama koperasi yang tampil sebagai identitas website.')->required(),
            TextInput::make('site_tagline')->label('Tagline')->required(),
            static::makeImageField('logo_path', 'Logo')
                ->acceptedFileTypes(['image/png', 'image/webp', 'image/jpeg'])
                ->maxSize(2048)
                ->helperText('Logo dipakai pada header, footer, ikon browser, dan halaman admin. Format JPG, PNG, atau WebP; maksimal 2 MB.'),
            RichEditor::make('footer_description')->label('Deskripsi Footer')->helperText('Keterangan singkat koperasi yang tampil di bagian bawah website.'),
        ];
    }
}

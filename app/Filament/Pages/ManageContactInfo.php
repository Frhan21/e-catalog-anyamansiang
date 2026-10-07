<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class ManageContactInfo extends SettingPage
{
    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationLabel = 'Kontak';

    protected static ?string $navigationGroup = 'Konten Situs';

    protected static ?int $navigationSort = 4;

    protected static ?string $title = 'Kelola Info Kontak';

    protected static string $view = 'filament.pages.manage-contact-info';

    protected function settingKey(): string
    {
        return 'contact_info';
    }

    protected function settingGroup(): string
    {
        return 'contact';
    }

    protected function formSchema(): array
    {
        return [
            TextInput::make('whatsapp_number')
                ->label('Nomor WhatsApp')
                ->required()
                ->helperText('Format internasional tanpa tanda +, contoh: 6281234567890')
                ->regex('/^628\d{8,12}$/'),
            TextInput::make('whatsapp_display')
                ->label('Nomor WhatsApp (tampilan)')
                ->required(),
            TextInput::make('email')->label('Email')->email()->required(),
            TextInput::make('phone')->label('Telepon'),
            Textarea::make('address')->label('Alamat')->rows(3),
            Textarea::make('google_maps_embed')
                ->label('Embed Google Maps')
                ->rows(3)
                ->nullable()
                ->rule(fn (): \Closure => fn (string $attribute, $value, \Closure $fail) => $value && ! google_maps_url($value) ? $fail(__('Masukkan URL Google Maps HTTPS yang valid.')) : null),
            TextInput::make('business_hours')->label('Jam Operasional'),
        ];
    }
}

<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login;

class AdminLogin extends Login
{
    public function getTitle(): string
    {
        return 'Masuk Admin';
    }

    protected function getEmailFormComponent(): TextInput
    {
        return TextInput::make('email')
            ->label('Email atau Username')
            ->required()
            ->autofocus();
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        $login = $data['email'];

        if (! filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('username', $login)->first();

            if ($user) {
                $login = $user->email;
            }
        }

        return ['email' => $login, 'password' => $data['password']];
    }
}

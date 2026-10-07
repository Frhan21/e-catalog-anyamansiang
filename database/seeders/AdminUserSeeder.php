<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $password = getenv('ADMIN_PASSWORD') ?: env('ADMIN_PASSWORD');

        if (! $password) {
            throw new \LogicException('ADMIN_PASSWORD must be set before seeding the admin user.');
        }

        User::firstOrCreate(
            ['email' => 'anyamanmansiang@gmail.com'],
            [
                'name' => 'Admin Mansiang',
                'username' => 'anyamansiangadmin',
                'password' => Hash::make($password),
            ]
        );
    }
}

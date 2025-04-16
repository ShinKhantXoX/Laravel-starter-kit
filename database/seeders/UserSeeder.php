<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\{
    UserStatusEnum,
};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    protected static ?string $password;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = [
            'username' => 'MANAGER',
            'email' => 'manager@gmail.com',
            'phone' => '9951939131',
            'email_confirm_at' => now(),
            'phone_confirm_at' => now(),
            'status' => UserStatusEnum::ACTIVE->value,
            'password' => static::$password ??= Hash::make('password'),
        ];

        $cashear = [
            'username' => 'CASHEAR',
            'email' => 'cashear@gmail.com',
            'phone' => '9951939132',
            'email_confirm_at' => now(),
            'phone_confirm_at' => now(),
            'status' => UserStatusEnum::ACTIVE->value,
            'password' => static::$password ??= Hash::make('password'),
        ];

        try {
            User::Create($manager)->assignRole('MANAGER');
            User::Create($cashear)->assignRole('CASHEAR');
            User::factory(20)->create();
        } catch (\Exception $e) {
            throw ($e);
        }
    }
}
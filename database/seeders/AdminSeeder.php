<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\{
    UserStatusEnum,
};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    protected static ?string $password;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = [
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '9951939130',
            'email_confirm_at' => now(),
            'phone_confirm_at' => now(),
            'status' => UserStatusEnum::ACTIVE->value,
            'password' => static::$password ??= Hash::make('password'),
        ];

        // $roles = Enum::make(RoleEnum::class)->values();

        try {
            User::updateOrCreate($superAdmin)->assignRole('SUPER_ADMIN');
            // Admin::factory(100)->create();
        } catch (\Exception $e) {
            throw ($e);
        }
    }
}
<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Helpers\Enum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = collect(Enum::make(PermissionEnum::class)->values())->map(function ($permission) {
            return [
                'name' => $permission,
                'guard_name' => 'dashboard',
            ];
        });

        try {
            Permission::insert($permissions->toArray());
            app()[PermissionRegistrar::class]->forgetCachedPermissions();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
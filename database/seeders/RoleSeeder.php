<?php

namespace Database\Seeders;

use App\Enums\RoleTypeEnum;
use App\Helpers\Enum;
use Exception;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = collect(Enum::make(RoleTypeEnum::class)->values())->each(function ($role) {
            try {
                $createRole = Role::firstOrCreate([
                    'name' => $role,
                    'guard_name' => 'dashboard',
                ]);

                // Assign all permissions to SUPER_ADMIN
                if ($createRole->name === RoleTypeEnum::SUPER_ADMIN->value) {
                    $createRole->syncPermissions(Permission::pluck('name')->toArray());
                }

                // Assign specific permissions to MANAGER by permission names (not IDs)
                if ($createRole->name === RoleTypeEnum::MANAGER->value) {
                    $per = Permission::pluck('name')->toArray();
                    $managerPermissions = [$per[2], $per[3], $per[4]]; // Replace with actual permission names
                    $createRole->syncPermissions($managerPermissions);
                }

                if ($createRole->name === RoleTypeEnum::CASHEAR->value) {
                    $casherPermission = Permission::where('name', 'COUNTER_INDEX')->first();
                    $createRole->syncPermissions([$casherPermission->name]);
                }

            } catch (Exception $e) {
                throw $e;
            }
        });
    }
}

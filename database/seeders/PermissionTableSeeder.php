<?php

namespace Database\Seeders;

use App\Enums\Permissions\PermissionsEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionsEnum = PermissionsEnum::cases();

        foreach ($permissionsEnum as $permissionEnum) {
            $permission = Permission::query()->firstOrNew(['name' => $permissionEnum->toString(), 'guard_name' => $permissionEnum->getGuard()]);
            $permission->save();
        }
    }
}

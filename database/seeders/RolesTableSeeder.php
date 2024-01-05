<?php

namespace Database\Seeders;

use App\Enums\Roles\RolesEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = RolesEnum::cases();

        foreach ($roles as $roleEnum) {
            /**
             * @var Role $role
             */
            $role = Role::query()->firstOrNew([
                'name' => $roleEnum->toString(),
                'guard_name' => $roleEnum->getGuard(),
            ]);
            $role->save();

            $rolePermissions = RolesEnum::getRolePermissions($roleEnum);
            $role->syncPermissions($rolePermissions);
        }
    }
}

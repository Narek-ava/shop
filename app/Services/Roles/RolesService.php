<?php

namespace App\Services\Roles;

use Spatie\Permission\Models\Role;

class RolesService
{

    public function find(int $id)
    {
        return Role::query()->where('id',$id)->first();
    }
}

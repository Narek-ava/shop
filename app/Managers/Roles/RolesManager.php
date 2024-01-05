<?php

namespace App\Managers\Roles;

use App\Services\Roles\RolesService;

class RolesManager
{

    protected RolesService $rolesService;

    public function __construct(
        RolesService $rolesService
    )
    {
        $this->rolesService = $rolesService;
    }

    public function find(int $id)
    {
        return $this->rolesService->find($id);
    }
}

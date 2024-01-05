<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Role\FindRoleRequest;
use App\Http\Resources\V1\Roles\RolesResource;
use App\Managers\Roles\RolesManager;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{


    protected RolesManager $rolesManager;

    public function __construct(
        RolesManager $rolesManager
    )
    {
        $this->rolesManager = $rolesManager;
    }

    public function find(FindRoleRequest $request)
    {
        return new RolesResource($this->rolesManager->find($request->getId()));
    }
}

<?php

namespace App\Http\Resources\V1\User;

use App\Http\Resources\V1\Media\MediaResource;
use App\Http\Resources\V1\Permissions\PermissionsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property mixed $name
 * @property mixed $email
 * @property mixed $id
 */
class UserResource extends JsonResource
{

    #[ArrayShape([
        'id' => "mixed",
        'name' => "mixed",
        'email' => "mixed",
        'permissions' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection",
        'image' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"])]
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'permissions' => PermissionsResource::collection($this->resource->getPermissionsViaRoles()),
            'image' => MediaResource::collection($this->whenLoaded('image')),

        ];
    }
}

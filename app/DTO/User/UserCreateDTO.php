<?php

namespace App\DTO\User;

use App\DTO\DTO;
use App\Enums\Roles\RolesEnum;
use Nyholm\Psr7\UploadedFile;

class UserCreateDTO implements DTO
{
    public string $name;
    public string $email;
    public string $password;
    public RolesEnum $role;
    public ?UploadedFile $image;

    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param RolesEnum $role
     * @param UploadedFile|null $image
     */
    public function __construct(
        string $name,
        string $email,
        string $password,
        RolesEnum $role,
        UploadedFile | null $image,
    )
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->image = $image;
    }
}

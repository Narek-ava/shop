<?php

namespace App\DTO\User;

use App\DTO\DTO;
use Illuminate\Http\UploadedFile;

class CreateUserImageDTO implements DTO
{
    public UploadedFile $image;

    public function __construct(
        UploadedFile $image,
    )
    {
        $this->image = $image;

    }
}

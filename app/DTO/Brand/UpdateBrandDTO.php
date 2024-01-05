<?php

namespace App\DTO\Brand;

use App\DTO\DTO;
use Illuminate\Http\UploadedFile;

/**
 * @property $Id
 */
class UpdateBrandDTO implements DTO
{
    public int $brandId;
    public string $slug;
    public string $name;
    public int $position;
    public ?UploadedFile $image;

    /**
     * @param int $brandId
     * @param string $slug
     * @param string $name
     * @param int $position
     * @param UploadedFile|null $image
     */
    public function __construct(
        int $brandId,
        string $slug,
        string $name,
        int $position,
        ?UploadedFile $image ,
    ) {
        $this->brandId = $brandId;
        $this->slug = $slug;
        $this->name = $name;
        $this->position = $position;
        $this->image = $image;
    }

}

<?php

namespace App\DTO\Brand;

use App\DTO\DTO;
use Illuminate\Http\UploadedFile;

/**
 * Class CreateBrandDTO
 * @package App\DTO\Brand
 * @property string $slug
 * @property string $name
 * @property int $position
 */
class CreateBrandDTO implements DTO
{
    public string $slug;
    public string $name;
    public int $position;
    public UploadedFile $image;

    /**
     * @param string $slug
     * @param string $name
     * @param int $position
     * @param array|null $image
     */
    public function __construct(
        string $slug,
        string $name,
        int $position,
        UploadedFile $image,
    ) {
        $this->slug = $slug;
        $this->name = $name;
        $this->position = $position;
        $this->image = $image;
    }
}

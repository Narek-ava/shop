<?php

namespace App\DTO\Product;

use App\DTO\DTO;

class UpdateProductDTO implements DTO
{

    public int $position;
    public bool $published;
    public ?int $brandId;
    public int $productId;
    public array | null $images;
    /**
     * @var ProductTranslationDTO[]
     */
    public array $translations;

    public function __construct(
        int   $position,
        bool  $published,
        ?int  $brandId,
        int   $productId,
        array $translationDTO,
        array |null $images
    )
    {
        $this->position = $position;
        $this->published = $published;
        $this->brandId = $brandId;
        $this->productId = $productId;
        $this->translations = $translationDTO;
        $this->images = $images;
    }
}

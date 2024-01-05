<?php

namespace App\DTO\ProductVariant;

use App\DTO\DTO;

class UpdateProductVariantDTO extends CreateProductVariantDTO implements DTO
{
    public int $productVariantId;
    public string $sku;
    public bool $published;
    public int $position;
    public array $translations;

    /**
     * @param int $productVariantId
     * @param string $sku
     * @param bool $published
     * @param int $position
     * @param array $translations
     */
    public function __construct(

        int $productVariantId,
        string $sku,
        bool $published,
        int  $position,
        array $translations,
        array | null $images,
    ) {
        $this->productVariantId = $productVariantId;
        $this->sku = $sku;
        $this->published = $published;
        $this->position = $position;
        $this->translations = $translations;
        $this->images = $images;
    }
}

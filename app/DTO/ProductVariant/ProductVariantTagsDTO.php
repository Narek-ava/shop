<?php

namespace App\DTO\ProductVariant;

use App\DTO\DTO;

class ProductVariantTagsDTO implements DTO
{
    public int $productVariantId;
    public string $tags;

    public function __construct(

        int    $productVariantId,
        string $tags,
    )
    {
        $this->productVariantId = $productVariantId;
        $this->tags = $tags;
    }

}

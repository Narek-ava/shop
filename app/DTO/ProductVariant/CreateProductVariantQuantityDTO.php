<?php

namespace App\DTO\ProductVariant;

use App\DTO\DTO;

/**
 * @param int $quantity
 * @property int $productVariantId
 */
class CreateProductVariantQuantityDTO implements DTO
{
    public int $quantity;
    public int $productVariantId;

    public function __construct(
        int $quantity,
        int $productVariantId,
    ){
        $this->quantity=$quantity;
        $this->productVariantId=$productVariantId;
    }
}

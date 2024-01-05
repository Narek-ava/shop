<?php

namespace App\DTO\Order;

use App\DTO\DTO;

class OrderProductVariantDTO implements DTO
{
    public int $productVariantId;
    public int $quantity;
    public int $price;



    public function __construct(
        int $productVariantId,
        int $quantity,
        int $price,
    )
    {
        $this->productVariantId = $productVariantId;
        $this->quantity = $quantity;
        $this->price = $price;
    }
}

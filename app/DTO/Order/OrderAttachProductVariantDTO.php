<?php

namespace App\DTO\Order;

use App\DTO\DTO;

class OrderAttachProductVariantDTO implements DTO
{
    public int $orderId;
    public int $productVariantId;
    public ?float $productPrice;
    public int $count;

    /**
     * @param int $orderId
     * @param int $productVariantId
     * @param ?float $productPrice
     * @param int $count
     */
    public function __construct(
        int $orderId,
        int $productVariantId,
        ?float $productPrice,
        int $count
    ) {
        $this->orderId = $orderId;
        $this->productVariantId = $productVariantId;
        $this->productPrice = $productPrice;
        $this->count = $count;
    }
}

<?php

namespace App\DTO\Order;

use App\DTO\DTO;

class CreateOrderDTO implements DTO
{
    public int | null $userId;
    public float $deliveryPrice;
    /**
     * @var OrderProductVariantDTO[] $orderProductVariants
     */
    public array $orderProductVariants;

    /**
     * @param int|null $userId
     * @param float $deliveryPrice
     * @param array $orderProductVariants
     */
    public function __construct(
        int |null $userId,
        float $deliveryPrice,
        array $orderProductVariants,
    ) {
        $this->userId = $userId;
        $this->deliveryPrice = $deliveryPrice;
        $this->orderProductVariants = $orderProductVariants;
    }
}

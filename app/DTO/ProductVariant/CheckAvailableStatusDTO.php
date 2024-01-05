<?php

namespace App\DTO\ProductVariant;

use App\DTO\DTO;

class CheckAvailableStatusDTO implements DTO
{
    public bool $available;
    public int $variantId;

    public function __construct(
        int $variantId,
        bool $available
    )
    {
        $this->variantId = $variantId;
        $this->available = $available;
    }
}

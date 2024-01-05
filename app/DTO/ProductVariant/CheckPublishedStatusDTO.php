<?php

namespace App\DTO\ProductVariant;

use App\DTO\DTO;

class CheckPublishedStatusDTO implements DTO
{
    public bool $published;
    public int $variantId;

    public function __construct(
        int $variantId,
        bool $published
    )
    {
        $this->variantId = $variantId;
        $this->published = $published;
    }
}

<?php

namespace App\DTO\FavoritesProduct;

use App\DTO\DTO;

class FavoritesProductDTO implements DTO
{
    public ?int $productVariantId;
    public ?int $userId;

    public function __construct(
        ?int $productVariantId,
        ?int $userId,
    )
    {
        $this->productVariantId = $productVariantId;
        $this->userId = $userId;
    }
}

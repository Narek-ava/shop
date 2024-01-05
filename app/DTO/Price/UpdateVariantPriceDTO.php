<?php

namespace App\DTO\Price;

use App\DTO\DTO;

class UpdateVariantPriceDTO implements DTO
{

    public int $amount;
    public int $priceVariantId;

    function __construct(
        int $amount,
        int $priceVariantId,
    )
    {
        $this->amount = $amount;
        $this->priceVariantId = $priceVariantId;
    }
}

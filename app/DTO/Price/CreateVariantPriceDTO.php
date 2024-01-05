<?php

namespace App\DTO\Price;

class CreateVariantPriceDTO
{
    public int $variantId;
    public int $priceTypeId;
    public int $amount;
    public string $currency;
    function __construct(
       int $variantId,
       int $priceTypeId,
       int $amount,
       string $currency,
    )
    {
       $this->variantId = $variantId;
       $this->priceTypeId = $priceTypeId;
       $this->amount = $amount;
       $this->currency = $currency;
    }

}

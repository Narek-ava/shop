<?php

namespace App\DTO\Price;

use App\DTO\DTO;

class UpdatePriceTypeDTO implements DTO
{
    public int $priority;
    public int $priceTypeId;

    public array $priceTypeTranslationsDTO;

    public function __construct(
        int   $priority,
        int   $priceTypeId,
        array $priceTypeTranslationsDTO
    )
    {
        $this->priority = $priority;
        $this->priceTypeId = $priceTypeId;
        $this->priceTypeTranslationsDTO = $priceTypeTranslationsDTO;
    }
}

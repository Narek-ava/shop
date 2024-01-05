<?php

namespace App\DTO\Price;

use App\DTO\DTO;

class CreatePriceTypeDTO implements DTO
{
    public int $priority;
    public array $priceTypeTranslationsDTO;

    public function __construct(
        int $priority,
        array $priceTypeTranslationsDTO
    )
    {
      $this->priority = $priority;
      $this->priceTypeTranslationsDTO = $priceTypeTranslationsDTO;
    }
}

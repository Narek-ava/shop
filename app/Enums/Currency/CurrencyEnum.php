<?php

namespace App\Enums\Currency;

use App\Enums\StringableEnum;

enum CurrencyEnum: string implements StringableEnum
{
    case AMD = 'AMD';

    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @return CurrencyEnum
     */
    public static function defaultCurrency(): CurrencyEnum
    {
        return CurrencyEnum::AMD;
    }
}

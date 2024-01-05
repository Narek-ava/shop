<?php

namespace App\Enums\Price;

use App\Enums\StringableEnum;
use JetBrains\PhpStorm\Pure;

enum PriceTypesEnum: string implements StringableEnum {
    case DEFAULT = 'default';
    case CREDIT = 'credit';
    case SALE = 'sale';
    case PARTNER = 'partner';


    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }

    #[Pure] public static function priorities(): array
    {
        return [
            PriceTypesEnum::SALE->toString() => 200,
            PriceTypesEnum::DEFAULT->toString() => 100,
            PriceTypesEnum::CREDIT->toString() => 0,
            PriceTypesEnum::PARTNER->toString() => 0,
        ];
    }

    public function getPriority(): int
    {
        return self::priorities()[$this->toString()];
    }
}

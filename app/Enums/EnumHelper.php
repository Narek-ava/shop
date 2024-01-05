<?php

namespace App\Enums;

class EnumHelper
{
    /**
     * @param StringableEnum[] $enums
     * @return string[]
     */
    public static function values(array $enums): array
    {
        $enumsSting = [];

        foreach ($enums as $enum) {
            $enumsSting[] = $enum->toString();
        }

        return $enumsSting;
    }
}

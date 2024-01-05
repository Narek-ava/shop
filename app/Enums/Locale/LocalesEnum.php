<?php

namespace App\Enums\Locale;

use App\Enums\StringableEnum;

enum LocalesEnum: string implements StringableEnum {
    case EN = 'en';
    case HY = 'hy';

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public static function requiredLocales(): array
    {
        return self::cases();
    }
}

<?php

namespace App\DTO\Price;

use App\Enums\Locale\LocalesEnum;

class PriceTypeTranslationsDTO
{
    public string $text;
    public string $field;
    public LocalesEnum $locale;

    public function __construct(LocalesEnum $locale, string $field, string $text)
    {
        $this->locale = $locale;
        $this->field = $field;
        $this->text = $text;
    }
}

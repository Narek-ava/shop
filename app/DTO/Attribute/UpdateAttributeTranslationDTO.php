<?php

namespace App\DTO\Attribute;

use App\DTO\DTO;
use App\Enums\Locale\LocalesEnum;

class UpdateAttributeTranslationDTO implements DTO
{
    public LocalesEnum $locale;
    public ?int $attributeId;
    public ?string $field;
    public ?string $text;

    public function __construct(
        LocalesEnum $locale,
        string      $field,
        string      $text,
        int         $attributeId = null
    )
    {
        $this->locale = $locale;
        $this->attributeId = $attributeId;
        $this->field = $field;
        $this->text = $text;
    }
}

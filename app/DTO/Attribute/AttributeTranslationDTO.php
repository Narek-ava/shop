<?php
namespace App\DTO\Attribute;

use App\DTO\DTO;
use App\Enums\Locale\LocalesEnum;

/**
 * Class AttributeTranslationDTO
 * @package App\DTO\Attribute
 * @property LocalesEnum $locale
 * @property int|null $attributeId
 * @property string $field
 * @property string $text
 */
class AttributeTranslationDTO implements DTO
{
    public LocalesEnum $locale;
    public ?int $attributeId;
    public string $field;
    public string $text;

    public function __construct(LocalesEnum $locale, string $field, string $text, int $attributeId = null)
    {
        $this->locale = $locale;
        $this->attributeId = $attributeId;
        $this->field = $field;
        $this->text = $text;
    }
}

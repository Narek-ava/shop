<?php
namespace App\DTO\Option;

use App\DTO\DTO;
use App\Enums\Locale\LocalesEnum;

/**
 * Class OptionTranslationDTO
 * @package App\DTO\Option
 * @property LocalesEnum $locale
 * @property int|null $optionId
 * @property string $field
 * @property string $text
 */
class OptionTranslationDTO implements DTO
{
    public LocalesEnum $locale;
    public ?int $optionId;
    public string $field;
    public string $text;

    public function __construct(LocalesEnum $locale, string $field, string $text, int $optionId = null)
    {
        $this->locale = $locale;
        $this->optionId = $optionId;
        $this->field = $field;
        $this->text = $text;
    }
}

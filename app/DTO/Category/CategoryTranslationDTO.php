<?php
namespace App\DTO\Category;

use App\DTO\DTO;
use App\Enums\Locale\LocalesEnum;

class CategoryTranslationDTO implements DTO
{
    public LocalesEnum $locale;
    public ?int $categoryId;
    public string $field;
    public string $text;

    public function __construct(LocalesEnum $locale, string $field, string $text, int $categoryId = null)
    {
        $this->locale = $locale;
        $this->categoryId = $categoryId;
        $this->field = $field;
        $this->text = $text;
    }
}

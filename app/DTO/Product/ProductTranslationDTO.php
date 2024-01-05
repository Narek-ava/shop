<?php
namespace App\DTO\Product;

use App\DTO\DTO;
use App\Enums\Locale\LocalesEnum;

class ProductTranslationDTO implements DTO
{
    public LocalesEnum $locale;
    public ?int $productId;
    public string $field;
    public string $text;

    public function __construct(LocalesEnum $locale, string $field, string $text, int $productId = null)
    {
        $this->locale = $locale;
        $this->field = $field;
        $this->text = $text;
        $this->productId = $productId;
    }
}

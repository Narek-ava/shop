<?php
namespace App\DTO\ProductVariant;

use App\DTO\DTO;
use App\Enums\Locale\LocalesEnum;

class ProductVariantTranslationDTO implements DTO
{
    public LocalesEnum $locale;
    public ?int $productId;
    public string $field;
    public string $text;

    public function __construct(LocalesEnum $locale, string $field, string $text, int $productId = null)
    {
        $this->locale = $locale;
        $this->productId = $productId;
        $this->field = $field;
        $this->text = $text;
    }
}

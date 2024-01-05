<?php

namespace App\Http\Resources\V1\ProductVariant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property mixed $locale
 * @property mixed $product_variant_id
 * @property mixed $field
 * @property mixed $value
 */
class ProductVariantTranslationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        'locale' => "mixed",
        'product_variant_id' => "mixed",
        'field' => "mixed",
        'value' => "mixed"
    ])]

    public function toArray(Request $request): array
    {
        return [
            'locale' => $this->locale,
            'value' => $this->value,
        ];
    }
}

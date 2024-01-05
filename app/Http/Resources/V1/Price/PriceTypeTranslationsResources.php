<?php

namespace App\Http\Resources\V1\Price;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property mixed $locale
 * @property mixed $price_type_id
 * @property mixed $field
 * @property mixed $value
 */
class PriceTypeTranslationsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape([
        'locale' => "mixed",
        'price_type_id' => "mixed",
        'field' => "mixed",
        'value' => "mixed"
    ])]

    public function toArray(Request $request): array
    {
        return [
            'locale'=>$this->locale,
             'price_type_id'=>$this->price_type_id,
             'field'=>$this->field,
             'value'=>$this->value
        ];
    }
}

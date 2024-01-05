<?php

namespace App\Http\Resources\V1\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $locale
 * @property string $field
 * @property string $value
 */
class TranslationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'locale' => $this->locale,
            'field' => $this->field,
            'value' => $this->value,
        ];
    }
}

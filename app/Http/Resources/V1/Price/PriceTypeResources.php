<?php

namespace App\Http\Resources\V1\Price;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property int $id
 * @property int $price_type_id
 * @property string $locale
 * @property string $field
 * @property string $value
 * @property mixed $priority
 */
class PriceTypeResources extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */


    #[ArrayShape([
        'id' => "int",
        'priority' => "mixed",
        'nameTranslations' => "\Illuminate\Http\Resources\Json\AnonymousResourceCollection"
    ])]

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'priority' => $this->priority,
            'nameTranslations' => PriceTypeTranslationsResources::collection($this->whenLoaded('nameTranslations'))
        ];
    }
}

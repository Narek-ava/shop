<?php

namespace App\Http\Resources\V1\Option;

use App\Http\Resources\V1\Attribute\AttributeResource;
use App\Models\Attribute\Attribute;
use App\Models\Attribute\AttributeTranslation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class OptionResource
 * @package App\Http\Resources\V1\Option
 * @property int $id
 * @property string $name
 * @property int $attribute_id
 * @property-read Attribute $attribute
 */
class OptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'nameTranslations' => OptionTranslationResource::collection($this->whenLoaded('nameTranslations')),
            'attribute' => new AttributeResource($this->whenLoaded('attribute')),
        ];
    }
}

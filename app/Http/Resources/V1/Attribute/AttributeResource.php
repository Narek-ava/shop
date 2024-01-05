<?php

namespace App\Http\Resources\V1\Attribute;

use App\Http\Resources\V1\Option\OptionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class AttributeResource
 * @package App\Http\Resources\V1\Attribute
 * @property int $id
 * @property-read string $name
 * @property int $position
 */
class AttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name' => $this->name,
            'position' => $this->position,
            'nameTranslations' => AttributeTranslationResource::collection($this->whenLoaded('nameTranslations')),
            'options' => OptionResource::collection($this->whenLoaded('options')),
        ];
    }
}

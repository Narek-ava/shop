<?php

namespace App\Http\Resources\V1\Brand;

use App\Http\Resources\V1\Media\MediaResource;
use App\Http\Resources\V1\Product\TranslationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @file
 * Contains BrandResource.php
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $position
 */
class BrandResource extends JsonResource
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
            'slug' => $this->slug,
            'name' => $this->name,
            'position' => $this->position,
            'image' => MediaResource::collection($this->whenLoaded('image')),
        ];
    }
}

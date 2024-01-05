<?php

namespace App\Http\Resources\V1\Product;

use App\Http\Resources\V1\Brand\BrandResource;
use App\Http\Resources\V1\Category\CategoryResource;
use App\Http\Resources\V1\Media\MediaResource;
use App\Http\Resources\V1\ProductVariant\ProductVariantResource;
use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductTranslation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class ProductResource
 * @package App\Http\Resources\V1\Product
 * @property int $id
 * @property int $category_id
 * @property int $position
 * @property bool $published
 * @property-read string $name
 * @property-read  string $description
 * @property-read  string $shortDescription
 * @property-read  Category $category
 * @property mixed $nameTranslations
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @param null $images
     * @return array<string, mixed>
     */



    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'published' => $this->published,
            'position' => $this->position,
            'name' => $this->name,
            'description' => $this->description,
            'shortDescription' => $this->shortDescription,
            'nameTranslations' => TranslationResource::collection($this->whenLoaded('nameTranslations')),
            'descriptionTranslations' => TranslationResource::collection($this->whenLoaded('descriptionTranslations')),
            'shortDescriptionTranslations' => TranslationResource::collection($this->whenLoaded('shortDescriptionTranslations')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'variants' => ProductVariantResource::collection($this->whenLoaded('variants')),
            'images' => MediaResource::collection($this->whenLoaded('images'))
           ];
    }
}

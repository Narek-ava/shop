<?php

namespace App\Http\Resources\V1\ProductVariant;

use App\Http\Resources\V1\Attribute\AttributeResource;
use App\Http\Resources\V1\Media\MediaResource;
use App\Http\Resources\V1\Option\OptionResource;
use App\Http\Resources\V1\Price\PriceTypeResources;
use App\Http\Resources\V1\Product\ProductResource;
use App\Http\Resources\V1\Product\ProductVariantTagsResource;
use App\Models\Product\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Class ProductVariantResource
 * @package App\Http\Resources\V1\ProductVariant
 * @property int $id
 * @property int $product_id
 * @property int $position
 * @property bool $published
 * @property-read string $name
 * @property string $sku
 * @property-read Product $product
 * @property mixed $price
 * @property mixed $price_type
 * @property bool $available
 * @property object $quantity
 * @property boolean $out_of_stock
 */
class ProductVariantResource extends JsonResource
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
            'sku' => $this->sku,
            'published' => $this->published,
            'position' => $this->position,
            'price' => $this->price,
            'options' => OptionResource::collection($this->whenLoaded('options')),
            'product' => new ProductResource($this->whenLoaded('product')),
            'price_type' => PriceTypeResources::collection($this->whenLoaded('priceType')),
            'nameTranslations' => ProductVariantTranslationResource::collection($this->whenLoaded('nameTranslations')),
            'images' => MediaResource::collection($this->whenLoaded('images')),
            'quantity' => $this->quantity ? $this->whenLoaded('quantity')->sum('quantity') : 0,
            'tags'=> ProductVariantTagsResource::collection($this->whenLoaded('tags')),
            'available' => (bool)$this->available,
            'outOfStock' => (bool)$this->out_of_stock,
            'attributes' => AttributeResource::collection($this->whenLoaded('options')),
        ];
    }
}

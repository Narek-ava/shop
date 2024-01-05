<?php

namespace App\Http\Resources\V1\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @property mixed $product_variant_id
 * @property mixed $tags
 * @property mixed $id
 */
class ProductVariantTagsResource extends JsonResource
{

    #[ArrayShape([
        'id' => "mixed",
        'tags' => "mixed"])]

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tags' => $this->tags,
        ];
    }
}


<?php

namespace App\Http\Resources\V1\ProductVariant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $quantity
 */
class ProductVariantQuantityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'quantity' => $this->whenLoaded('quantity', $this->quantity->sum('quantity')),
        ];

    }
}

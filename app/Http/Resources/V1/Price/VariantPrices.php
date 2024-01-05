<?php

namespace App\Http\Resources\V1\Price;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property int $variant_id
 * @property int $price_type_id
 * @property int $amount
 * @property string  $currency
 */
class VariantPrices extends JsonResource
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
            'variant_id'=>$this->variant_id,
            'price_type_id'=>$this->price_type_id,
            'amount'=>$this->amount,
            'currency'=>$this->currency
        ];
    }
}

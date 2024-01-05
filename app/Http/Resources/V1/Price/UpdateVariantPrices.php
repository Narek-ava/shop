<?php

namespace App\Http\Resources\V1\Price;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $amount
 */
class UpdateVariantPrices extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [
            'amount'=>$this->amount,
        ];
    }

}

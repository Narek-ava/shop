<?php

namespace App\Models\Price;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $variant_id
 * @property int $price_type_id
 * @property int $amount
 * @property string $currency
 */
class VariantPrice extends Model
{
    use HasFactory;

    /**
     * @param int $variantId
     * @return int
     */
    public function setVariantId(int $variantId): int
    {
        return $this->variant_id = $variantId;
    }

    /**
     * @param int $priceTypeId
     * @return int
     */
    public function setPriceTypeId(int $priceTypeId): int
    {
        return $this->price_type_id = $priceTypeId;
    }

    /**
     * @param int $amount
     * @return int
     */
    public function setAmount(int $amount): int
    {
        return $this->amount = $amount;
    }

    /**
     * @param string $currency
     * @return string
     */
    public function setCurrency(string $currency): string
    {
        return $this->currency = $currency;
    }
}

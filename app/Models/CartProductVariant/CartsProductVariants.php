<?php

namespace App\Models\CartProductVariant;

use App\Models\Product\Variant\ProductVariant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $count
 * @property int $product_variant_id
 * @property int $cart_id
 */
class CartsProductVariants extends Model
{
    use HasFactory;

    /**
     * @param int $count
     * @return void
     */
    public function setCount(int $count):void
    {
        $this->count = $count;
    }

    /**
     * @return HasOne
     */
    public function productVariants(): HasOne
    {
        return $this->hasOne(ProductVariant::class);
    }
    public function setProductId(int $product_variant_id):void
    {
        $this->product_variant_id = $product_variant_id;
    }

    /**
     * @param int $cartId
     * @return void
     */
    public function setCartId(int $cartId):void
    {
        $this->cart_id = $cartId;
    }
}

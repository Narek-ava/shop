<?php

namespace App\Models\Cart;

use App\Models\Product\Variant\ProductVariant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property mixed|string $token
 * @property int|null $user_id
 * @property int $id
 */
class Cart extends Model
{
    use HasFactory;
    public function productVariants(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class, 'carts_product_variants', 'cart_id','product_variant_id')->withPivot('count');
    }
       public function setUserId(?int $user_id): void
   {
       $this->user_id = $user_id;
   }
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

}

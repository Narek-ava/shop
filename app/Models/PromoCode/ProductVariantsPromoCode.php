<?php

namespace App\Models\PromoCode;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $product_variant_id
 * @property mixed $promo_code_id
 */
class ProductVariantsPromoCode extends Model
{
    use HasFactory;

    protected $table = 'product_variants_promo_code';
}

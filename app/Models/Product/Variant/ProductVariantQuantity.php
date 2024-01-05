<?php

namespace App\Models\Product\Variant;

use Illuminate\Database\Eloquent\Model;

/**
 *@property int|mixed $quantity
 * @property int|mixed $product_variant_id
 * @property int|null $sourceable_id
 */
class ProductVariantQuantity extends Model
{
    public $table = 'product_variant_quantity';

    protected $fillable = ['quantity','product_variant_id','sourceable_id'];
    //todo create sourceable functionality

}

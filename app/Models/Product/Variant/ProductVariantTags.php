<?php

namespace App\Models\Product\Variant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|mixed $product_variant_id
 * @property mixed|string $tags
 */
class ProductVariantTags extends Model
{
    use HasFactory;
}

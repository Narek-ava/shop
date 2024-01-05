<?php

namespace App\Models\Product\Variant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

/**
 * @property int variant_id
 * @property int price_type_id
 * @property int amount
 * @property string currency
 * @property string created_at
 * @property string updated_at
 */
class ProductVariantPrice extends Model
{
    use HasFactory;

    protected $table = 'variant_prices';
}

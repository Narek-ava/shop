<?php

namespace App\Models\Product\Variant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductVariantTranslation
 * @package App\Models\Product\ProductVariant
 * @property int $id
 * @property int $product_variant_id
 * @property string $locale
 * @property string $field
 * @property string $value
 */
class ProductVariantTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['value','product_variant_id',
        'field',
        'locale',];

}

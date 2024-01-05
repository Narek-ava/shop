<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductTranslation
 * @package App\Models\Product
 * @property int $id
 * @property int $product_id
 * @property string $locale
 * @property string $field
 * @property string $value
 */
class ProductTranslation extends Model
{
    protected $fillable = ['value','product_id',
'field',
'locale',];
    use HasFactory;
    public $timestamps = false;
}

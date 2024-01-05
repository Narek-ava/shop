<?php

namespace App\Models\Price;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $locale
 * @property string $field
 * @property string $value
 * @property int $price_type_id
 */
class PriceTypeTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['value'];
}

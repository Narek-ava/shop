<?php

namespace App\Models\Attribute;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AttributeTranslation
 * @package App\Models\Attribute
 * @property int $id
 * @property int $attribute_id
 * @property string $locale
 * @property string $field
 * @property string $value
 */
class AttributeTranslation extends Model
{
    protected $fillable = [
        'locale',
        'attribute_id',
        'field',
        'value',
    ];
    use HasFactory;

    public $timestamps = false;
}

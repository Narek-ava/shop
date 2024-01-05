<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * Class CategoryTranslation
 * @package App\Models\Category
 * @property int $id
 * @property int $category_id
 * @property string $locale
 * @property string $field
 * @property string $value
 */
class CategoryTranslation extends Model
{
    protected $fillable = [
        'locale',
        'category_id',
        'field',
        'value',
    ];
    use HasFactory;

    public $timestamps = false;
}

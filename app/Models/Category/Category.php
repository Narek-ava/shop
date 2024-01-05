<?php

namespace App\Models\Category;

use App\Interfaces\Model\Translatable;
use App\Models\TranslatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Category
 * @package App\Models\Category
 * @property int $id
 * @property string $slug
 * @property int $parent_id
 * @property-read string $name
 * @property-read  Category[] $subcategories
 * @property-read CategoryTranslation $nameTranslationRelation
 */
class Category extends Model implements Translatable
{
    use HasFactory, TranslatableTrait;

    public const NAME_FIELD = 'name';

    protected $with = ['nameTranslationRelation'];

    public static function getTranslatableFields(): array
    {
        return [self::NAME_FIELD];
    }

    /**
     * @return HasOne
     */
    public function nameTranslationRelation(): HasOne
    {
        return $this->hasOne(CategoryTranslation::class, 'category_id', 'id')
            ->where('field', self::NAME_FIELD)
            ->where('locale', $this->getLocale());
    }

    /**
     * @return HasMany
     */
    public function subcategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->with(['subcategories']);
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->nameTranslationRelation->value;
    }

    /**
     * @return HasMany
     */
    public function nameTranslations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class, 'category_id', 'id')
            ->where('field', self::NAME_FIELD);
    }

    /**
     * @return HasOne
     */
    public function parentCategory(): HasOne
    {
        return $this->hasOne(Category::class,'parent_id','id');
    }
}

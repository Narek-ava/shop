<?php

namespace App\Models\Attribute;

use App\Interfaces\Model\Translatable;
use App\Models\Attribute\Option\Option;
use App\Models\TranslatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Attribute
 * @package App\Models\Attribute
 * @property int $id
 * @property bool $is_filterable
 * @property int $position
 * @property-read string $name
 * @property-read AttributeTranslation $nameTranslationRelation
 */
class Attribute extends Model implements Translatable
{
    use HasFactory, TranslatableTrait;

    public const NAME_FIELD = 'name';

    /**
     * @return string[]
     */
    public static function getTranslatableFields(): array
    {
        return [
            self::NAME_FIELD,
        ];
    }

    /**
     * @return HasOne
     */
    public function nameTranslationRelation(): HasOne
    {
        return $this->hasOne(AttributeTranslation::class, 'attribute_id', 'id')
            ->where('field', self::NAME_FIELD)
            ->where('locale', $this->getLocale());
    }

    public function nameTranslations(): HasMany
    {
        return $this->hasMany(AttributeTranslation::class, 'attribute_id', 'id')
            ->where('field', self::NAME_FIELD);
    }
    public function translations(): HasMany
    {
        return $this->hasMany(AttributeTranslation::class, 'attribute_id', 'id');

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
    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }
}

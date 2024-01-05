<?php

namespace App\Models\Attribute\Option;

use App\Interfaces\Model\Translatable;
use App\Models\Attribute\Attribute;
use App\Models\Product\Variant\ProductVariant;
use App\Models\TranslatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Option
 * @package App\Models\Attribute\Option
 * @property int $id
 * @property int $attribute_id
 * @property-read string $name
 * @property-read OptionTranslation $nameTranslationRelation
 */
class Option extends Model implements Translatable
{
    use HasFactory, TranslatableTrait;

    public const NAME_FIELD = 'name';

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
        return $this->hasOne(OptionTranslation::class, 'option_id', 'id')
            ->where('field', self::NAME_FIELD)
            ->where('locale', $this->getLocale());
    }

    public function translations(): HasMany
    {
        return $this->hasMany(OptionTranslation::class, 'option_id', 'id');
    }


    public function nameTranslations(): HasMany
    {
        return $this->hasMany(OptionTranslation::class, 'option_id', 'id')->where('field', self::NAME_FIELD);
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string | null
    {
        return $this->nameTranslationRelation;
    }


    public function attribute(): hasOne
    {
        return $this->hasOne(Attribute::class,'id','attribute_id');
    }

    public function productVariants(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class, 'product_variant_options');
    }
}

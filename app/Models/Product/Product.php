<?php

namespace App\Models\Product;

use App\Interfaces\Model\Translatable;
use App\Models\Brand\Brand;
use App\Models\Category\Category;
use App\Models\Product\Variant\ProductVariant;
use App\Models\TranslatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class Product
 * @package App\Models\Product
 * @property int $id
 * @property int $category_id
 * @property int $position
 * @property bool $published
 * @property int|null $brand_id
 * @property-read string $name
 * @property-read string $description
 * @property-read string $short_description
 * @property-read ProductTranslation $nameTranslationRelation
 * @property-read ProductTranslation $descriptionTranslationRelation
 * @property-read ProductTranslation $shortDescriptionTranslationRelation
 * @property-read ProductTranslation[]|Collection $nameTranslations
 */
class Product extends Model implements HasMedia,Translatable
{
    use HasFactory, TranslatableTrait,InteractsWithMedia;

    protected $appends = ['images'];
    public const DESCRIPTION_FIELD = 'description';
    public const SHORT_DESCRIPTION_FIELD = 'short_description';
    public const NAME_FIELD = 'name';
    public const IMAGE_COLLECTION_NAME = 'images';

    protected $with = [
        'nameTranslationRelation',
        'descriptionTranslationRelation',
        'shortDescriptionTranslationRelation',
    ];

    /**
     * @return string[]
     */
    public static function getTranslatableFields(): array
    {
        return [
            self::DESCRIPTION_FIELD,
            self::SHORT_DESCRIPTION_FIELD,
            self::NAME_FIELD,
        ];
    }

    /**
     * @return HasOne
     */
    public function nameTranslationRelation(): HasOne
    {
        return $this->hasOne(ProductTranslation::class, 'product_id', 'id')
            ->where('field', self::NAME_FIELD)->where('locale', $this->getLocale());
    }

    /**
     * @return HasMany
     */
    public function nameTranslations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class, 'product_id', 'id')
            ->where('field', self::NAME_FIELD);
    }

    /**
     * @return HasMany
     */
    public function descriptionTranslations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class, 'product_id', 'id')
            ->where('field', self::DESCRIPTION_FIELD);
    }

    /**
     * @return HasMany
     */
    public function shortDescriptionTranslations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class, 'product_id', 'id')
            ->where('field', self::SHORT_DESCRIPTION_FIELD);
    }

    /**
     * @return HasOne
     */
    public function descriptionTranslationRelation(): HasOne
    {
        return $this->hasOne(ProductTranslation::class, 'product_id', 'id')
            ->where('field', self::DESCRIPTION_FIELD)
            ->where('locale', $this->getLocale());
    }

    /**
     * @return HasOne
     */
    public function shortDescriptionTranslationRelation(): HasOne
    {
        return $this->hasOne(ProductTranslation::class, 'product_id', 'id')
            ->where('field', self::SHORT_DESCRIPTION_FIELD)
            ->where('locale', $this->getLocale());
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->nameTranslationRelation->value ?? '';
    }

    /**
     * @return string
     */
    public function getDescriptionAttribute(): string
    {
        return $this->descriptionTranslationRelation->value ?? '';
    }

    /**
     * @return string
     */
    public function getShortDescriptionAttribute(): string
    {
        return $this->shortDescriptionTranslationRelation->value ?? '';
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    /**
     * @return void
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::IMAGE_COLLECTION_NAME);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Media::class, 'model_id', 'id')->where('model_type', Product::class);
    }
}

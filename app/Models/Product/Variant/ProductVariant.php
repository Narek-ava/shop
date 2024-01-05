<?php

namespace App\Models\Product\Variant;

use App\Interfaces\Model\Translatable;
use App\Models\Attribute\Option\Option;
use App\Models\Price\PriceType;
use App\Models\Price\VariantPrice;
use App\Models\Product\Product;
use App\Models\PromoCode\ProductVariantsPromoCode;
use App\Models\TranslatableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class ProductVariant
 * @package App\Models\Product\ProductVariant
 * @property int $id
 * @property int $product_id
 * @property int $position
 * @property bool $published
 * @property string $sku
 * @property int $quantity
 * @property int $price
 * @property-read Product $product
 * @property-read ProductVariantTranslation $nameTranslationRelation
 */
class ProductVariant extends Model implements HasMedia,Translatable
{
    use HasFactory, TranslatableTrait, InteractsWithMedia;

    public const NAME_FIELD = 'name';
    const IMAGE_COLLECTION_NAME = 'images';
    protected $appends = ['images'];
    protected $fillable = [
    'out_of_stock'
    ];
    protected $with = [
        'nameTranslationRelation'
    ];

    public static function getTranslatableFields(): array
    {
        return [
            self::NAME_FIELD,
        ];
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return BelongsToMany
     */
    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class, 'product_variant_options');
    }

    /**
     * @return HasOne
     */
    public function nameTranslationRelation(): HasOne
    {
        return $this->hasOne(ProductVariantTranslation::class, 'product_variant_id', 'id')
            ->where('field', self::NAME_FIELD)
            ->where('locale', $this->getLocale());
    }

    /**
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(ProductVariantTranslation::class, 'product_variant_id', 'id');
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->nameTranslationRelation->value;
    }

    /**
     * @return BelongsToMany
     */
    public function productVariantPromoCode(): BelongsToMany
    {
        return $this->belongsToMany(ProductVariantsPromoCode::class,'product_variants_promo_code','product_variant_id');
    }

    public function nameTranslations(): HasMany
    {
        return $this->hasMany(ProductVariantTranslation::class, 'product_variant_id', 'id')
            ->where('field', self::NAME_FIELD);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(VariantPrice::class, 'variant_id', 'id');
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->prices()
                ->join('price_types', 'price_types.id', '=', 'variant_prices.price_type_id')
                ->orderByDesc('price_types.priority')
                ->first()->amount ?? 0
        );
    }

    public function images(): HasMany
    {
        return $this->hasMany(Media::class, 'model_id', 'id')->where('model_type', ProductVariant::class);
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

    public function quantity(): HasMany
    {
        return $this->hasMany(ProductVariantQuantity::class,'product_variant_id','id');
    }

    public function tags(): HasMany
    {
        return $this->hasMany(ProductVariantTags::class,'product_variant_id','id');
    }

//    public function getImagesAttribute()
//    {
//        return $this->hasMany(Media::class, 'model_id', 'id')->where('model_type', ProductVariant::class);
//    }

    protected function totalquantity(): Attribute
    {
        return Attribute::make(
            get: fn() => array_sum($this->quantity()->pluck('quantity')->toArray())
        );
    }

}

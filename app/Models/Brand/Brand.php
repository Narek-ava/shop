<?php

namespace App\Models\Brand;

use App\Http\Requests\API\V1\Brand\SearchBrandRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class Brand
 * @package App\Models\Brand
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $position
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Brand extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;

    protected $appends = ['images'];
    public const IMAGE_COLLECTION_NAME = 'images';


    public function image(): HasMany
    {
        return $this->hasMany(Media::class, 'model_id', 'id')->where('model_type', Brand::class);
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
    public function addImage($file)
    {
        $this->addMedia($file)->toMediaCollection('images');
    }
    public function getImagesAttribute()
    {
        return $this->hasMany(Media::class, 'model_id', 'id')->where('model_type', Brand::class);
    }
}

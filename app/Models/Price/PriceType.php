<?php

namespace App\Models\Price;

use App\Interfaces\Model\Translatable;
use App\Models\TranslatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $type
 * @property int $priority
 */
class PriceType extends Model implements  Translatable
{
    use HasFactory,TranslatableTrait;

    public const NAME_FIELD = 'name';
    public const DESCRIPTION_FIELD = 'description';

    public static function getTranslatableFields(): array
    {
        return [
            self::NAME_FIELD,
            self::DESCRIPTION_FIELD
        ];
    }
    public function nameTranslations(): HasMany
    {
        return $this->hasMany(PriceTypeTranslation::class, 'price_type_id','id')
            ->where('field', self::NAME_FIELD);
}
}

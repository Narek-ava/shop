<?php

namespace App\Models\Attribute\Option;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OptionTranslation
 * @package App\Models\Attribute\Option
 * @property int $id
 * @property int $option_id
 * @property string $locale
 * @property string $field
 * @property string $value
 */
class OptionTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;
}

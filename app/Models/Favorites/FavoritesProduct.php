<?php

namespace App\Models\Favorites;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|mixed|null $product_variants_id
 * @property mixed $user_id
 */
class FavoritesProduct extends Model
{
    use HasFactory;
}

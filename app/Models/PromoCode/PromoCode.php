<?php

namespace App\Models\PromoCode;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property mixed|string $code
 * @property int|mixed|null $discount_amount
 * @property int|mixed|null $discount_percent
 * @property int|mixed|null $max_uses
 * @property Carbon|mixed $starting_at
 * @property \Carbon\Carbon|mixed $expired_at
 * @property mixed $id
 */
class PromoCode extends Model
{
    use HasFactory;
}

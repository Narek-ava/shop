<?php

namespace App\Models\Order;

use App\Models\Price\Price;
use App\Models\Product\Variant\ProductVariant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProductVariant extends Model
{
    use HasFactory, SoftDeletes;

}

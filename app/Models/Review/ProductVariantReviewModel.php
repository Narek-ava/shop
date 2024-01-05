<?php

namespace App\Models\Review;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int|mixed $rating
 * @property mixed|string $review
 * @property mixed|string $review_title
 * @property int|mixed $product_variant_id
 * @property mixed $user_id
 */
class ProductVariantReviewModel extends Model
{
    protected $table = 'product_variant_reviews';
    use HasFactory;
}

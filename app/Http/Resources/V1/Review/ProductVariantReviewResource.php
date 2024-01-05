<?php

namespace App\Http\Resources\V1\Review;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @property int $rating
 * @property string $review
 * @property int $product_variant_id
 * @property string $review_title
 */
class ProductVariantReviewResource extends JsonResource
{

    public function toArray(Request $request): array
    {

        return [
            'rating' => $this->rating,
            'reviewTitle' => $this->review_title,
            'review' => $this->review,
            'productVariantId' => $this->product_variant_id,
        ];

    }
}

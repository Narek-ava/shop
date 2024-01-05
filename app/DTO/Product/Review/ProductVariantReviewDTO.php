<?php

namespace App\DTO\Product\Review;

use App\DTO\DTO;

class ProductVariantReviewDTO implements DTO
{

    public int $rating;
    public string $reviewTitle;
    public string $review;
    public int $productVariantId;

    public function __construct(int $rating, string $reviewTitle, string $review, int $productVariantId)
    {
        $this->rating = $rating;
        $this->reviewTitle = $reviewTitle;
        $this->review = $review;
        $this->productVariantId = $productVariantId;
    }

}

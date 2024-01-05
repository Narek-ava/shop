<?php

namespace App\Services\review;

use App\DTO\Pagination\PaginationFilterDTO;
use App\DTO\Product\Review\ProductVariantReviewDTO;
use App\Models\Review\ProductVariantReviewModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductVariantReviewService
{
    public function review(ProductVariantReviewDTO $productVariantReviewDTO): ProductVariantReviewModel
    {
        $productVariantReview = new ProductVariantReviewModel();

        $productVariantReview->rating = $productVariantReviewDTO->rating;
        $productVariantReview->review_title = $productVariantReviewDTO->reviewTitle;
        $productVariantReview->review = $productVariantReviewDTO->review;
        $productVariantReview->product_variant_id = $productVariantReviewDTO->productVariantId;
        $productVariantReview->user_id = auth()->id();
        $productVariantReview->save();

        return $productVariantReview;
    }

    /**
     * @param PaginationFilterDTO $productVariantReviewFilterDTO
     * @return LengthAwarePaginator
     */
    public function getAll(PaginationFilterDTO $productVariantReviewFilterDTO): LengthAwarePaginator
    {
        $reviews = ProductVariantReviewModel::query();

        if (!empty($productVariantReviewFilterDTO->filter)){
            $reviews->whereIn('product_variant_id', $productVariantReviewFilterDTO->filter);
        }
        return $reviews->with($productVariantReviewFilterDTO->relations)->paginate($productVariantReviewFilterDTO->perPage, ['*'], 'page', $productVariantReviewFilterDTO->page);
    }
}

<?php

namespace App\Managers\Review;

use App\DTO\Pagination\PaginationFilterDTO;
use App\DTO\Product\Review\ProductVariantReviewDTO;
use App\Models\Review\ProductVariantReviewModel;
use App\Services\review\ProductVariantReviewService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductVariantReviewManager
{
    protected ProductVariantReviewService $productVariantReviewService;

    /**
     * @param ProductVariantReviewService $productVariantReviewService
     */
    public function __construct(ProductVariantReviewService $productVariantReviewService)
    {
        $this->productVariantReviewService = $productVariantReviewService;
    }

    /**
     * @throws Throwable
     */
    public function review(ProductVariantReviewDTO $productVariantReviewDTO): ProductVariantReviewModel
    {
        DB::beginTransaction();
        try {
            $productVariantReview = $this->productVariantReviewService->review($productVariantReviewDTO);
            DB::commit();

            return $productVariantReview;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * @param PaginationFilterDTO $productVariantReviewFilterDTO
     * @return LengthAwarePaginator
     */
    public function getAll(PaginationFilterDTO $productVariantReviewFilterDTO): LengthAwarePaginator
    {
        return $this->productVariantReviewService->getAll( $productVariantReviewFilterDTO);
    }

}

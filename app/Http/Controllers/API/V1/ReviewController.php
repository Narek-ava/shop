<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\Pagination\PaginationFilterDTO;
use App\DTO\Product\Review\ProductVariantReviewDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Pagination\GetAllRequest;
use App\Http\Requests\API\V1\Review\ProductVariantReviewRequest;
use App\Http\Resources\V1\Review\ProductVariantReviewResource;
use App\Managers\Review\ProductVariantReviewManager;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;


class ReviewController extends Controller
{

    /**
     * @var ProductVariantReviewManager
     */
    public ProductVariantReviewManager $productVariantReviewManager;

    public function __construct(ProductVariantReviewManager $productVariantReviewManager)
    {
        $this->productVariantReviewManager = $productVariantReviewManager;
    }

    /**
     * @throws Throwable
     */
    public function review(ProductVariantReviewRequest $request): ProductVariantReviewResource
    {
        $productVariantReviewDTO = new ProductVariantReviewDTO(
            $request->getRating(),
            $request->getReviewTitle(),
            $request->getReview(),
            $request->getProductVariantId(),
        );
        $productVariantReview = $this->productVariantReviewManager->review($productVariantReviewDTO);

        return new ProductVariantReviewResource($productVariantReview);
    }

    /**
     * @param GetAllRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(GetAllRequest $request): AnonymousResourceCollection
    {
        $productVariantReviewFilterDTO = new PaginationFilterDTO(
            $request->getFilter(),
            $request->getPerPage(),
            $request->getCurrentPage(),
            [],
        );

        $users = $this->productVariantReviewManager->getAll($productVariantReviewFilterDTO);

        return ProductVariantReviewResource::collection($users);
    }
}

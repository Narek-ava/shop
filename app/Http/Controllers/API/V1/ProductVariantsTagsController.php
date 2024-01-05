<?php

namespace App\Http\Controllers\API\V1;

use App\DTO\ProductVariant\ProductVariantTagsDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\ProductVariant\DeleteTagRequest;
use App\Http\Requests\API\V1\ProductVariant\productVariantTagsRequest;
use App\Http\Resources\V1\Product\ProductVariantTagsResource;
use App\Managers\ProductVariant\ProductVariantTagsManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ProductVariantsTagsController extends Controller
{
    public ProductVariantTagsManager $productVariantTagsManager;

    public function __construct(ProductVariantTagsManager $productVariantTagsManager)
    {
        $this->productVariantTagsManager = $productVariantTagsManager;
    }

    /**
     * @param productVariantTagsRequest $request
     * @return ProductVariantTagsResource
     * @throws Throwable
     */
    public function createAction(productVariantTagsRequest $request): ProductVariantTagsResource
    {

        $productVariantTagsDTO = new ProductVariantTagsDTO(
            $request->getProductVariantId(),
            $request->getTags(),
        );

        $productVariantTags = $this->productVariantTagsManager->createAction($productVariantTagsDTO);

        return new ProductVariantTagsResource($productVariantTags);
    }

    /**
     * @param DeleteTagRequest $request
     * @return JsonResponse
     */
    public function deleteTagById(DeleteTagRequest $request): JsonResponse
    {

        return $this->productVariantTagsManager->delete($request->id);
    }
}

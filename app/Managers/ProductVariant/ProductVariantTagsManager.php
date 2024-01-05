<?php

namespace App\Managers\ProductVariant;

use App\DTO\ProductVariant\ProductVariantTagsDTO;
use App\Models\Product\Variant\ProductVariantTags;
use App\Services\ProductVariant\ProductVariantTagsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductVariantTagsManager
{

    /**
     * @var ProductVariantTagsService
     */
    protected ProductVariantTagsService $productVariantTagsService;

    /**
     * @param ProductVariantTagsService $productVariantTagsService
     */
    public function __construct(ProductVariantTagsService $productVariantTagsService)
    {
        $this->productVariantTagsService = $productVariantTagsService;
    }

    /**
     * @throws Throwable
     */
    public function createAction(ProductVariantTagsDTO $productVariantTagsDTO): ProductVariantTags
    {

        DB::beginTransaction();
        try {
            $productVariantTags = $this->productVariantTagsService->createAction($productVariantTagsDTO);
            DB::commit();

            return $productVariantTags;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }


    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        return $this->productVariantTagsService->delete($id);
    }
}

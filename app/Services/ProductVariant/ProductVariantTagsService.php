<?php

namespace App\Services\ProductVariant;

use App\DTO\ProductVariant\ProductVariantTagsDTO;
use App\Models\Product\Variant\ProductVariantTags;
use Exception;
use Illuminate\Http\JsonResponse;


class ProductVariantTagsService
{
    /**
     * @param ProductVariantTagsDTO $productVariantTagsDTO
     * @return ProductVariantTags
     */
    public function createAction(ProductVariantTagsDTO $productVariantTagsDTO): ProductVariantTags
    {
        $productVariantTags = new ProductVariantTags();
        $productVariantTags->product_variant_id = $productVariantTagsDTO->productVariantId;
        $productVariantTags->tags = $productVariantTagsDTO->tags;
        $productVariantTags->save();

        return $productVariantTags;
    }


    public function delete(int $id): JsonResponse
    {
        try {
            ProductVariantTags::query()->where('id',$id)->delete();
            return response()->json(['message' => 'Tag deleted successfully']);
        }catch(Exception $exception)
        {
            return response()->json(['message' => 'Tag not found']);
        }
    }
}

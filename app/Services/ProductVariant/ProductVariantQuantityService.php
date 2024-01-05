<?php

namespace App\Services\ProductVariant;

use App\DTO\ProductVariant\CreateProductVariantQuantityDTO;
use App\Models\Product\Variant\ProductVariant;
use App\Models\Product\Variant\ProductVariantQuantity;

class ProductVariantQuantityService
{
    /**
     * @param CreateProductVariantQuantityDTO $productVariantQuantityDTO
     * @return ProductVariant
     */
    public function create(CreateProductVariantQuantityDTO $productVariantQuantityDTO): ProductVariant
    {
            $variant = ProductVariantQuantity::query()->where('product_variant_id',$productVariantQuantityDTO->productVariantId)->first();

        $productVariantQuantity = ProductVariantQuantity::create(
            [
                'product_variant_id'=> $productVariantQuantityDTO->productVariantId,
                'quantity' =>  $productVariantQuantityDTO->quantity,
                'sourceable_id' => auth()->id()
            ]
        );

        $productVariant = ProductVariant::find($productVariantQuantityDTO->productVariantId);
        $productVariant->update([
                'out_of_stock' => !($productVariantQuantity->quantity === 0),
            ]);

        return $productVariant;
    }

    public function getById($productVariantId)
    {
        return ProductVariant::query()->where('id', $productVariantId)->first();
    }

}

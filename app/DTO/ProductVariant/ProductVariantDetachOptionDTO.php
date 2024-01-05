<?php
namespace App\DTO\ProductVariant;

use App\DTO\DTO;

/**
 * Class ProductVariantAttachOptionDTO
 * @package App\DTO\ProductVariant
 * @property int $productVariantId
 * @property int $optionId
 */
class ProductVariantDetachOptionDTO implements DTO
{
    public int $productVariantId;
    public int $optionId;

    /**
     * @param int $productVariantId
     * @param int $optionId
     */
    public function __construct(
        int $productVariantId,
        int $optionId,
    ) {
        $this->productVariantId = $productVariantId;
        $this->optionId = $optionId;
    }
}
